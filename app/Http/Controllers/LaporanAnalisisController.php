<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LaporanAnalisisController extends Controller
{
    // Menampilkan halaman index
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = DB::table('tbl_indikator')
            ->leftJoin('tbl_laporan_dan_analis', function ($join) use ($bulan, $tahun) {
                $join->on('tbl_laporan_dan_analis.indikator_id', '=', 'tbl_indikator.id')
                    ->whereMonth('tbl_laporan_dan_analis.created_at', $bulan)
                    ->whereYear('tbl_laporan_dan_analis.created_at', $tahun);
            })
            ->leftJoin('tbl_pdsa', 'tbl_pdsa.laporan_analisis_id', '=', 'tbl_laporan_dan_analis.id')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_indikator.*',
                'tbl_unit.nama_unit',
                'tbl_laporan_dan_analis.id as laporan_id',
                'tbl_laporan_dan_analis.nilai',
                'tbl_laporan_dan_analis.pencapaian',
                'tbl_laporan_dan_analis.file_laporan',
                'tbl_pdsa.id as pdsa_id'
            )
            ->orderBy('tbl_indikator.id', 'DESC')
            ->get();

        return view('menu.LaporanAnalisis.index', compact('data', 'bulan', 'tahun'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'file_laporan' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:5120',
            // optional: validate bulan/tahun jika dikirim
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:1900',
        ]);

        // Hitung nilai
        $nilai = ($request->numerator / $request->denominator) * 100;

        // Ambil target dari tbl_indikator
        $target = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->value('target_indikator');

        // Tentukan pencapaian
        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

        // Upload file
        $filePath = null;
        if ($request->hasFile('file_laporan')) {
            $filePath = $request->file('file_laporan')->store('laporan', 'public');
        }

        // Ambil bulan/tahun dari request (jika ada), kalau tidak pakai sekarang
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Tentukan hari yang valid (hindari tanggal > jumlah hari di bulan tersebut)
        $day = date('d'); // gunakan hari sekarang
        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth();
        if ($day > $daysInMonth) {
            $day = $daysInMonth;
        }

        // Buat timestamp created_at sesuai bulan & tahun pilihan
        $createdAt = Carbon::createFromDate($tahun, $bulan, $day)->setTime(
            now()->hour,
            now()->minute,
            now()->second
        );

        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'nilai' => $nilai,
            'pencapaian' => $pencapaian,
            'file_laporan' => $filePath,
            'created_at' => $createdAt->toDateTimeString(),
            'updated_at' => now(),
        ]);

        // Redirect kembali ke index dengan mempertahankan filter bulan/tahun
        return redirect()
            ->route('laporan-analisis.index', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Laporan berhasil disimpan!');
    }
}
