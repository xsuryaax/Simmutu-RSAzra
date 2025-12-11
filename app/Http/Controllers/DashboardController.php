<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIndikator = DB::table('tbl_indikator')->count();

        // ===============================
        // AMBIL SEMUA INDIKATOR + FREKUENSI
        // ===============================
        $indikators = DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator_mutu', 'tbl_kamus_indikator_mutu.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.unit_id',
                'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id as frekuensi_id'
            )
            ->orderBy('nama_indikator')
            ->get();

        // ===============================
        // AMBIL TAHUN LAPORAN
        // ===============================
        $years = DB::table('tbl_laporan_dan_analis')
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM tanggal_laporan) AS tahun'))
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $allData = [];
        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // ===============================
        // PROSES DATA PER INDIKATOR (UTAMA)
        // ===============================
        foreach ($indikators as $ind) {
            foreach ($years as $thn) {

                $hasil = array_fill(1, 12, null);
                $target = array_fill(1, 12, $ind->target_indikator);

                // HARIAN / MINGGUAN
                if ($ind->frekuensi_id == 1 || $ind->frekuensi_id == 2) {
                    $lap = DB::table('tbl_laporan_dan_analis')
                        ->select(
                            DB::raw("EXTRACT(MONTH FROM tanggal_laporan) AS bulan"),
                            DB::raw("SUM(nilai) AS total"),
                            DB::raw("COUNT(*) AS jumlah_input")
                        )
                        ->where('indikator_id', $ind->id)
                        ->whereYear('tanggal_laporan', $thn)
                        ->groupBy('bulan')
                        ->get();

                    foreach ($lap as $row) {
                        if ($row->jumlah_input > 0) {
                            $hasil[$row->bulan] = round($row->total / $row->jumlah_input, 2);
                        }
                    }
                }

                // BULANAN
                elseif ($ind->frekuensi_id == 3) {
                    $lap = DB::table('tbl_laporan_dan_analis')
                        ->select(
                            DB::raw("EXTRACT(MONTH FROM tanggal_laporan) AS bulan"),
                            'nilai'
                        )
                        ->where('indikator_id', $ind->id)
                        ->whereYear('tanggal_laporan', $thn)
                        ->get();

                    foreach ($lap as $row) {
                        $hasil[$row->bulan] = round($row->nilai, 2);
                    }
                }

                // simpan
                $allData[$ind->id][$thn] = [
                    'labels' => $labels,
                    'hasil' => array_values($hasil),
                    'target' => array_values($target),
                ];
            }
        }

        // ===========================================================
        // DIVISION DATA — PER UNIT + PER INDIKATOR
        // ===========================================================
        $units = DB::table('tbl_unit')->orderBy('nama_unit')->get();
        $divisionData = [];

        foreach ($years as $tahun) {

            $divisionData[$tahun] = [
                'labels' => $labels
            ];

            foreach ($units as $u) {

                // Ambil semua indikator milik unit ini
                $indikatorUnit = $indikators->where('unit_id', $u->id);

                $divisionData[$tahun][$u->nama_unit] = [
                    'labels' => $labels,
                    'indikators' => []
                ];

                foreach ($indikatorUnit as $ind) {

                    // Siapkan array empty
                    $hasil = array_fill(1, 12, null);
                    $target = array_fill(1, 12, $ind->target_indikator);

                    // HARIAN / MINGGUAN
                    if ($ind->frekuensi_id == 1 || $ind->frekuensi_id == 2) {

                        $lap = DB::table('tbl_laporan_dan_analis')
                            ->select(
                                DB::raw("EXTRACT(MONTH FROM tanggal_laporan) AS bulan"),
                                DB::raw("SUM(nilai) AS total"),
                                DB::raw("COUNT(*) AS jumlah_input")
                            )
                            ->where('indikator_id', $ind->id)
                            ->where('unit_id', $u->id)
                            ->whereYear('tanggal_laporan', $tahun)
                            ->groupBy('bulan')
                            ->get();

                        foreach ($lap as $row) {
                            if ($row->jumlah_input > 0) {
                                $hasil[$row->bulan] = round($row->total / $row->jumlah_input, 2);
                            }
                        }
                    }

                    // BULANAN
                    elseif ($ind->frekuensi_id == 3) {
                        $lap = DB::table('tbl_laporan_dan_analis')
                            ->select(
                                DB::raw("EXTRACT(MONTH FROM tanggal_laporan) AS bulan"),
                                "nilai"
                            )
                            ->where('indikator_id', $ind->id)
                            ->where('unit_id', $u->id)
                            ->whereYear('tanggal_laporan', $tahun)
                            ->get();

                        foreach ($lap as $row) {
                            $hasil[$row->bulan] = round($row->nilai, 2);
                        }
                    }

                    // MASUKKAN DATA
                    $divisionData[$tahun][$u->nama_unit]['indikators'][$ind->id] = [
                        'target' => array_values($target),
                        'hasil' => array_values($hasil),
                    ];
                }
            }
        }

        // ===============================
        // CARD UNIT BULAN INI
        // ===============================
        $bulanSekarang = date('m');
        $tahunSekarang = date('Y');

        $totalUnit = DB::table('tbl_unit')->count();

        $unitSudahIsi = DB::table('tbl_laporan_dan_analis as l')
            ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
            ->whereMonth('l.tanggal_laporan', $bulanSekarang)
            ->whereYear('l.tanggal_laporan', $tahunSekarang)
            ->distinct('l.unit_id')
            ->count('l.unit_id');

        $unitBelumIsi = $totalUnit - $unitSudahIsi;

        $recentIsi = DB::table('tbl_laporan_dan_analis as l')
            ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
            ->orderBy('l.tanggal_laporan', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'indikators' => $indikators,
            'years' => $years,
            'allDataJson' => json_encode($allData),
            'divisionData' => $divisionData,
            'totalUnit' => $totalUnit,
            'unitSudahIsi' => $unitSudahIsi,
            'unitBelumIsi' => $unitBelumIsi,
            'totalIndikator' => $totalIndikator,
            'recentIsi' => $recentIsi,
        ]);
    }
}
