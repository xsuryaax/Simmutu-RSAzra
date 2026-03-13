<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;

class ExportPdfController extends Controller
{
    public function exportChart(Request $request)
    {
        if ($request->is_batch) {
            ini_set('memory_limit', '512M');
            set_time_limit(300); // 5 minutes for large batches
            $batchData = json_decode($request->batch, true);
            $tahun = $request->tahun;
            
            $indicatorIds = array_column($batchData, 'indicator_id');
            $chartsByIndId = [];
            foreach ($batchData as $item) {
                $chartsByIndId[$item['indicator_id']] = $item['chart_image'];
            }

            // Batch Fetch all indicators
            $indicatorsData = DB::table('tbl_indikator as i')
                ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
                ->leftJoin('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
                ->select('i.*', 'u.nama_unit', 'ki.kategori_indikator', 'ki.numerator as label_numerator', 'ki.denominator as label_denominator')
                ->whereIn('i.id', $indicatorIds)
                ->get()
                ->keyBy('id');

            // Batch Fetch all monthly reports
            $allReports = DB::table('tbl_laporan_dan_analis')
                ->whereIn('indikator_id', $indicatorIds)
                ->whereYear('tanggal_laporan', $tahun)
                ->selectRaw('
                    indikator_id,
                    EXTRACT(MONTH FROM tanggal_laporan) as bulan,
                    SUM(numerator) as total_numerator,
                    SUM(denominator) as total_denominator,
                    AVG(nilai) as rata_nilai
                ')
                ->groupBy('indikator_id', DB::raw('EXTRACT(MONTH FROM tanggal_laporan)'))
                ->get()
                ->groupBy('indikator_id');

            $finalIndicators = [];
            $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            foreach ($indicatorIds as $id) {
                $ind = $indicatorsData->get($id);
                if (!$ind) continue;

                $indReports = $allReports->get($id, collect())->keyBy('bulan');
                $monthlyData = [];
                
                foreach (range(1, 12) as $m) {
                    $rep = $indReports->get($m);
                    $monthlyData[] = [
                        'bulan' => $months[$m - 1],
                        'numerator' => $rep ? $rep->total_numerator : 0,
                        'denominator' => $rep ? $rep->total_denominator : 0,
                        'pencapaian' => $rep ? round($rep->rata_nilai, 2) : 0,
                        'target' => (float) $ind->target_indikator
                    ];
                }

                $finalIndicators[] = [
                    'indicator' => $ind,
                    'monthlyData' => $monthlyData,
                    'chart' => $chartsByIndId[$id] ?? null,
                    'judul' => $ind->nama_indikator
                ];
            }

            $pdf = PDF::loadView('menu.ExportPdf.chart_batch', [
                'indicators' => $finalIndicators,
                'tahun' => $tahun,
                'judul' => $request->judul ?? 'Laporan Grafik Indikator',
                'isBatch' => true
            ])->setPaper('A4', 'portrait');

            return $pdf->stream('Laporan_Batch_' . $tahun . '.pdf');
        }

        // Single Export Logic (Existing)
        $request->validate([
            'chart_image' => 'required',
            'judul' => 'required',
            'indicator_id' => 'required',
            'tahun' => 'required'
        ]);

        $indicatorId = $request->indicator_id;
        $tahun = $request->tahun;

        // Fetch indicator full details
        $indicator = DB::table('tbl_indikator as i')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->leftJoin('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
            ->select('i.*', 'u.nama_unit', 'ki.kategori_indikator', 'ki.numerator as label_numerator', 'ki.denominator as label_denominator')
            ->where('i.id', $indicatorId)
            ->first();

        if (!$indicator) {
            return redirect()->back()->with('error', 'Indikator tidak ditemukan');
        }

        // Fetch monthly data
        $reports = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $indicatorId)
            ->whereYear('tanggal_laporan', $tahun)
            ->selectRaw('
                EXTRACT(MONTH FROM tanggal_laporan) as bulan,
                SUM(numerator) as total_numerator,
                SUM(denominator) as total_denominator,
                AVG(nilai) as rata_nilai
            ')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggal_laporan)'))
            ->get()
            ->keyBy('bulan');

        $monthlyData = [];
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        foreach (range(1, 12) as $m) {
            $rep = $reports->get($m);
            $monthlyData[] = [
                'bulan' => $months[$m - 1],
                'numerator' => $rep ? $rep->total_numerator : 0,
                'denominator' => $rep ? $rep->total_denominator : 0,
                'pencapaian' => $rep ? round($rep->rata_nilai, 2) : 0,
                'target' => (float) $indicator->target_indikator
            ];
        }

        $pdf = PDF::loadView('menu.ExportPdf.chart', [
            'judul' => $request->judul,
            'chart' => $request->chart_image,
            'indicator' => $indicator,
            'tahun' => $tahun,
            'monthlyData' => $monthlyData
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            str_replace(' ', '_', strtolower($request->judul)) . '_' . $tahun . '.pdf'
        );
    }

    public function exportPdsa(Request $request)
    {
        $filterUnit = $request->unit_id;
        $filterTahun = $request->tahun;

        $data = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_indikator as i', 'a.indikator_id', '=', 'i.id')
            ->leftJoin('tbl_unit as u', 'a.unit_id', '=', 'u.id')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->when($filterUnit, function ($query) use ($filterUnit) {
                $query->where('a.unit_id', $filterUnit);
            })
            ->when($filterTahun, function ($query) use ($filterTahun) {
                $query->where('a.tahun', $filterTahun);
            })
            ->select(
                'i.nama_indikator',
                'u.nama_unit',
                'a.tahun',
                'a.quarter',
                'a.status_pdsa',
                'p.plan',
                'p.do',
                'p.study',
                'p.action'
            )
            ->orderBy('a.tahun', 'desc')
            ->get();

        $pdf = Pdf::loadView('menu.ExportPdf.pdsa', [
            'data' => $data,
            'tahun' => $filterTahun
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_PDSA.pdf');
    }

    public function exportProfile($id)
    {
        $data = DB::table('tbl_kamus_indikator as k')
            ->join('tbl_indikator as i', 'i.id', '=', 'k.indikator_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->leftJoin('tbl_jenis_indikator as j', 'j.id', '=', 'k.jenis_indikator_id')
            ->leftJoin('tbl_periode_pengumpulan_data as pp', 'pp.id', '=', 'k.periode_pengumpulan_data_id')
            ->leftJoin('tbl_periode_analisis_data as pa', 'pa.id', '=', 'k.periode_analisis_data_id')
            ->leftJoin('tbl_penyajian_data as pd', 'pd.id', '=', 'k.penyajian_data_id')
            ->leftJoin('tbl_kategori_imprs as ki', 'ki.id', '=', 'k.kategori_id')
            ->leftJoin('tbl_dimensi_mutu as d', function ($join) {
                $join->whereRaw("
                d.id = ANY(
                    string_to_array(k.dimensi_mutu_id::text, ',')::int[]
                )
            ");
            })
            ->select(
                'k.*',
                'i.nama_indikator',
                'u.nama_unit',
                'j.nama_jenis_indikator',
                'pp.nama_periode_pengumpulan_data',
                'pa.nama_periode_analisis_data',
                'pd.nama_penyajian_data',
                'ki.nama_kategori_imprs',
                DB::raw("string_agg(d.nama_dimensi_mutu, ', ') as nama_dimensi_mutu")
            )
            ->where('k.id', $id)
            ->groupBy(
                'k.id',
                'i.nama_indikator',
                'u.nama_unit',
                'j.nama_jenis_indikator',
                'pp.nama_periode_pengumpulan_data',
                'pa.nama_periode_analisis_data',
                'pd.nama_penyajian_data',
                'ki.nama_kategori_imprs'
            )
            ->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $pdf = Pdf::loadView('menu.ExportPdf.profile', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream(
            'Profile_Indikator_' . str_replace(' ', '_', $data->nama_indikator) . '.pdf'
        );
    }
}
