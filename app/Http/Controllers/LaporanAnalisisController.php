<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisisController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // ==============================
        // AMBIL INDIKATOR + FREKUENSI
        // ==============================
        $indikators = DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator_mutu', 'tbl_kamus_indikator_mutu.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_frekuensi_pengumpulan_data.id', '=', 'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_indikator.*',
                'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id as frekuensi_id',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_unit.nama_unit'
            )
            ->where('tbl_indikator.status_indikator', 'aktif')
            ->orderBy('tbl_indikator.id', 'DESC')
            ->get();

        // ==============================
        // AMBIL LAPORAN BULAN & TAHUN INI
        // ==============================
        $laporan = DB::table('tbl_laporan_dan_analis')
            ->whereMonth('tanggal_laporan', $bulan)
            ->whereYear('tanggal_laporan', $tahun)
            ->get();

        // Kelompokkan laporan berdasarkan indikator
        $laporanByIndikator = [];
        foreach ($laporan as $lap) {
            $laporanByIndikator[$lap->indikator_id][] = $lap;
        }

        $rows = [];

        // =====================================
        // LOOP SETIAP INDIKATOR
        // =====================================
        foreach ($indikators as $ind) {

            // Ambil seluruh laporan indikator ini (sudah difilter bulan & tahun)
            $laporanIndikator = collect($laporanByIndikator[$ind->id] ?? []);

            // TAMPILKAN LAPORAN YANG SUDAH ADA
            foreach ($laporanIndikator as $lap) {
                $rows[] = (object) [
                    'id' => $ind->id,
                    'nama_indikator' => $ind->nama_indikator,
                    'unit_id' => $lap->unit_id,
                    'nama_unit' => $ind->nama_unit,
                    'frekuensi_id' => $ind->frekuensi_id,
                    'nama_frekuensi_pengumpulan_data' => $ind->nama_frekuensi_pengumpulan_data,
                    'target_indikator' => $ind->target_indikator,
                    'status_indikator' => $ind->status_indikator,
                    'laporan_id' => $lap->id,
                    'nilai' => $lap->nilai,
                    'pencapaian' => $lap->pencapaian,
                    'file_laporan' => $lap->file_laporan,
                    'tanggal_laporan' => $lap->tanggal_laporan,
                    'boleh_input' => false,
                    'alasan_tidak_boleh' => null,
                ];
            }

            // =============================================
            // CEK APAKAH MASIH BOLEH INPUT DATA
            // =============================================
            $freq = (int) ($ind->frekuensi_id ?? 0);

            // Laporan indikator sesuai unit
            $lapUnit = $laporanIndikator->where('unit_id', $ind->unit_id);

            $bolehInput = true;
            $alasanTidakBoleh = null;

            // FREKUENSI HARIAN
            if ($freq === 1) {
                $hariIni = Carbon::now()->format('Y-m-d');

                $found = $lapUnit->first(function ($l) use ($hariIni) {
                    return Carbon::parse($l->tanggal_laporan)->format('Y-m-d') === $hariIni;
                });

                if ($found) {
                    $bolehInput = false;
                    $alasanTidakBoleh = 'Sudah ada laporan hari ini';
                }
            }

            // FREKUENSI MINGGUAN
            if ($freq === 2) {
                $currentWeek = Carbon::now()->isoWeek();

                $found = $lapUnit->first(function ($l) use ($currentWeek) {
                    return Carbon::parse($l->tanggal_laporan)->isoWeek() == $currentWeek;
                });

                if ($found) {
                    $bolehInput = false;
                    $alasanTidakBoleh = 'Sudah ada laporan minggu ini';
                }
            }

            // FREKUENSI BULANAN
            if ($freq === 3 && $lapUnit->count()) {
                $bolehInput = false;
                $alasanTidakBoleh = 'Sudah ada laporan bulan ini';
            }

            // Jika boleh input → tambahkan baris kosong
            if ($bolehInput) {
                $rows[] = (object) [
                    'id' => $ind->id,
                    'nama_indikator' => $ind->nama_indikator,
                    'unit_id' => $ind->unit_id,
                    'nama_unit' => $ind->nama_unit,
                    'frekuensi_id' => $ind->frekuensi_id,
                    'nama_frekuensi_pengumpulan_data' => $ind->nama_frekuensi_pengumpulan_data,
                    'target_indikator' => $ind->target_indikator,
                    'status_indikator' => $ind->status_indikator,
                    'laporan_id' => null,
                    'nilai' => null,
                    'pencapaian' => null,
                    'file_laporan' => null,
                    'tanggal_laporan' => null,
                    'boleh_input' => true,
                    'alasan_tidak_boleh' => null,
                ];
            }
        }

        return view('menu.LaporanAnalisis.index', [
            'data' => collect($rows),
            'bulan' => (int) $bulan,
            'tahun' => (int) $tahun,
        ]);
    }

    public function store(Request $request)
    {
        // validasi tetap seperti sebelumnya
        $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:5120',
            'tanggal_laporan' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
        ]);

        // frekuensi id dari kamus
        $frekuensi = DB::table('tbl_kamus_indikator_mutu')
            ->join('tbl_indikator', 'tbl_indikator.kamus_indikator_id', '=', 'tbl_kamus_indikator_mutu.id')
            ->where('tbl_indikator.id', $request->indikator_id)
            ->value('frekuensi_pengumpulan_data_id');

        $tanggalLaporan = sprintf('%04d-%02d-%02d', $request->tahun, $request->bulan, $request->tanggal_laporan);

        // cek frekuensi sebelum insert
        if ($frekuensi == 1) { // harian
            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereDate('tanggal_laporan', $tanggalLaporan)
                ->exists();

            if ($exists) {
                return back()->with('error', 'Input harian sudah dilakukan untuk tanggal ini!');
            }
        } elseif ($frekuensi == 2) { // mingguan
            $weekNumber = Carbon::parse($tanggalLaporan)->isoWeek();

            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereYear('tanggal_laporan', $request->tahun)
                ->whereRaw("EXTRACT(WEEK FROM tanggal_laporan) = ?", [$weekNumber])
                ->exists();

            if ($exists) {
                return back()->with('error', 'Input mingguan sudah dilakukan pada minggu ini!');
            }
        } elseif ($frekuensi == 3) { // bulanan
            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereMonth('tanggal_laporan', $request->bulan)
                ->whereYear('tanggal_laporan', $request->tahun)
                ->exists();

            if ($exists) {
                return back()->with('error', 'Input bulanan sudah dilakukan pada bulan ini!');
            }
        }

        // hitung nilai & insert
        $nilai = ($request->numerator / $request->denominator) * 100;
        $target = DB::table('tbl_indikator')->where('id', $request->indikator_id)->value('target_indikator');
        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

        $filePath = null;
        if ($request->hasFile('file_laporan')) {
            $filePath = $request->file('file_laporan')->store('laporan', 'public');
        }

        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'nilai' => $nilai,
            'pencapaian' => $pencapaian,
            'file_laporan' => $filePath,
            'tanggal_laporan' => $tanggalLaporan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('laporan-analisis.index')
            ->with('success', 'Laporan berhasil disimpan!');
    }
}
