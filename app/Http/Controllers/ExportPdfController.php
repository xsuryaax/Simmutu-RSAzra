<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;

class ExportPdfController extends Controller
{
    public function exportChart(Request $request)
    {
        $request->validate([
            'chart_image' => 'required',
            'judul' => 'required'
        ]);

        $pdf = PDF::loadView('menu.ExportPdf.chart', [
            'judul' => $request->judul,
            'chart' => $request->chart_image
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            str_replace(' ', '_', strtolower($request->judul)) . '.pdf'
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
