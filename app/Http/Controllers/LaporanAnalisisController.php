<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LaporanAnalisisController extends Controller
{
    // ---------------------------------------------------------------------
    // INDEX LAPORAN & ANALISIS
    // ---------------------------------------------------------------------

    public function index(Request $request)
    {
        $bulan = str_pad($request->bulan ?? date('m'), 2, '0', STR_PAD_LEFT);
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('tbl_indikator')
            ->leftJoin('tbl_laporan_dan_analis as laporan_bulan', function ($join) use ($bulan, $tahun) {
                $join->on('laporan_bulan.indikator_id', '=', 'tbl_indikator.id')
                    ->whereRaw("to_char(laporan_bulan.created_at, 'MM') = ?", [$bulan])
                    ->whereRaw("to_char(laporan_bulan.created_at, 'YYYY') = ?", [$tahun]);
            })
            ->leftJoin('tbl_pdsa', 'tbl_pdsa.indikator_id', '=', 'tbl_indikator.id')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_indikator.*',
                'tbl_unit.nama_unit',
                'laporan_bulan.id as laporan_id',
                'laporan_bulan.nilai',
                'laporan_bulan.pencapaian',
                'laporan_bulan.file_laporan',
                'laporan_bulan.status_laporan',
                'tbl_pdsa.id as pdsa_id'
            )
            ->where('tbl_indikator.status_indikator', 'aktif')
            ->orderBy('tbl_indikator.id', 'DESC')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG STATUS TRIWULAN
        |--------------------------------------------------------------------------
        */

        $bulanInt = (int) $bulan; // penting!

        foreach ($data as $row) {

            // Triwulan aktif
            $triwulan = ceil($bulanInt / 3);

            // Range bulan triwulan
            $startMonth = ($triwulan - 1) * 3 + 1;
            $endMonth = $triwulan * 3;

            // Ambil nilai 3 bulan
            $nilaiTriwulan = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $row->id)
                ->whereRaw("EXTRACT(MONTH FROM created_at) BETWEEN ? AND ?", [$startMonth, $endMonth])
                ->whereRaw("EXTRACT(YEAR FROM created_at) = ?", [$tahun])
                ->pluck('nilai');

            // Tentukan status triwulan
            if ($nilaiTriwulan->count() === 3) {
                $rataRata = $nilaiTriwulan->avg();

                $row->status_laporan =
                    $rataRata >= $row->target_indikator
                    ? 'tercapai'
                    : 'tidak-tercapai';
            } else {
                $row->status_laporan = 'belum-lengkap';
            }
        }

        return view('menu.LaporanAnalisis.index', compact('data', 'bulan', 'tahun'));
    }

    // ---------------------------------------------------------------------
    // SIMPAN LAPORAN & OTOMATIS CEK PDSA
    // ---------------------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:5120',
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:1900',
        ]);

        // Hitung nilai
        $nilai = ($request->numerator / $request->denominator) * 100;

        // Ambil target
        $target = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->value('target_indikator');

        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

        // Upload file
        $filePath = null;
        if ($request->hasFile('file_laporan')) {
            $filePath = $request->file('file_laporan')->store('laporan', 'public');
        }

        // Atur tanggal sesuai bulan & tahun filter
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $day = date('d');
        $maxDay = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth();
        if ($day > $maxDay)
            $day = $maxDay;

        $createdAt = Carbon::createFromDate($tahun, $bulan, $day)->setTime(
            now()->hour,
            now()->minute,
            now()->second
        );

        // Simpan laporan
        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'nilai' => $nilai,
            'pencapaian' => $pencapaian,
            'file_laporan' => $filePath,
            'created_at' => $createdAt,
            'updated_at' => now(),
        ]);

        // ---------------------------------------------------------------------
        // PDSA OTOMATIS SETIAP 3 BULAN (TRIWULAN)
        // ---------------------------------------------------------------------
        $triwulan = $this->getTriwulan((int) $bulan);

        $startMonth = ($triwulan - 1) * 3 + 1; // contoh Q2 → bulan 4
        $endMonth = $startMonth + 2;           // contoh Q2 → bulan 6

        // Ambil nilai 3 bulan dalam triwulan yang sama
        $nilaiTriwulan = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->whereBetween(DB::raw('EXTRACT(MONTH FROM created_at)'), [$startMonth, $endMonth])
            ->whereYear('created_at', $tahun)
            ->pluck('nilai');

        if ($nilaiTriwulan->count() === 3) {

            $rataRata = $nilaiTriwulan->avg();

            if ($rataRata < $target) {

                // cek apakah PDSA sudah ada
                $sudahAda = DB::table('tbl_pdsa')
                    ->where('indikator_id', $request->indikator_id)
                    ->where('triwulan', $triwulan)
                    ->where('tahun', $tahun)
                    ->exists();

                if (!$sudahAda) {
                    DB::table('tbl_pdsa')->insert([
                        'indikator_id' => $request->indikator_id,
                        'triwulan' => $triwulan,
                        'tahun' => $tahun,
                        'plan' => null,
                        'do' => null,
                        'study' => null,
                        'act' => null,
                        'file_pdsa' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()
            ->route('laporan-analisis.index', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Laporan berhasil disimpan!');
    }

    // ---------------------------------------------------------------------
    // FUNGSI HITUNG TRIWULAN
    // ---------------------------------------------------------------------
    private function getTriwulan($bulan)
    {
        if ($bulan >= 1 && $bulan <= 3)
            return 1;
        if ($bulan >= 4 && $bulan <= 6)
            return 2;
        if ($bulan >= 7 && $bulan <= 9)
            return 3;
        return 4;
    }
}
