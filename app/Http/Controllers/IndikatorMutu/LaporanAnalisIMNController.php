<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LaporanAnalisIMNController extends Controller
{
    public function index(Request $request)
    {
        $periode = DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();

        if (!$periode) {
            abort(404, 'Periode aktif tidak ditemukan');
        }

        $periodeMulai = Carbon::parse($periode->tanggal_mulai);
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

        $bulan = (int) ($request->bulan ?? $periodeMulai->month);
        $tahun = (int) ($request->tahun ?? $periodeMulai->year);

        $tanggalFilter = Carbon::create($tahun, $bulan, 1);

        if ($tanggalFilter->lt($periodeMulai) || $tanggalFilter->gt($periodeSelesai)) {
            $bulan = $periodeMulai->month;
            $tahun = $periodeMulai->year;
        }

        return view('menu.IndikatorMutu.laporan-analis-imn.index', [
            'indikatorLaporan' => $this->getIndikatorLaporan($bulan, $tahun), // rekap
            'laporanNasional' => $this->getLaporanNasional(),                // SEMUA DATA
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    private function getIndikatorLaporan($bulan, $tahun)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_laporan_dan_analis_nasional as l', function ($join) use ($bulan, $tahun) {
                $join->on('i.id', '=', 'l.indikator_id')
                    ->whereMonth('l.tanggal_laporan', $bulan)
                    ->whereYear('l.tanggal_laporan', $tahun);
            })
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.target_indikator as target',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai'),
                DB::raw('COUNT(l.id) > 0 as sudah_input')
            )
            ->where('i.status_indikator', 'aktif')
            ->where('k.jenis_indikator', 'LIKE', '%Nasional%')
            ->groupBy('i.id', 'i.nama_indikator', 'i.target_indikator')
            ->orderBy('i.id')
            ->get();
    }

    private function getLaporanNasional()
    {
        return DB::table('tbl_laporan_dan_analis_nasional as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select(
                'l.id',
                'i.nama_indikator',
                'l.tanggal_laporan',
                'i.target_indikator as target',
                'l.file_laporan',
                'l.nilai',
                'l.pencapaian',
                'l.created_at',
                'l.numerator',
                'l.denominator'
            )
            ->where('k.jenis_indikator', 'LIKE', '%Nasional%')
            ->orderBy('l.tanggal_laporan', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $periode = DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();

        if (!$periode) {
            return back()->with('error', 'Periode aktif tidak ditemukan');
        }

        $periodeMulai = Carbon::parse($periode->tanggal_mulai);
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

        $tanggalLaporan = Carbon::create(
            $request->tahun,
            $request->bulan,
            1
        )->startOfDay();

        if ($tanggalLaporan->lt($periodeMulai) || $tanggalLaporan->gt($periodeSelesai)) {
            return back()->with('error', 'Bulan dan tahun di luar periode aktif');
        }

        $indikator = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $nilai = round(($request->numerator / $request->denominator) * 100, 2);

        $pencapaian = $nilai >= $indikator->target_indikator
            ? 'tercapai'
            : 'tidak-tercapai';

        $filePath = $request->file('file_laporan')
            ->store('laporan_nasional', 'public');

        DB::table('tbl_laporan_dan_analis_nasional')->insert([
            'indikator_id' => $request->indikator_id,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => $nilai,
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggalLaporan->format('Y-m-d'),
            'file_laporan' => $filePath,
            'created_at' => now(), // INI YANG MEMBEDAKAN SETIAP INPUT
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Laporan nasional berhasil disimpan');
    }

}
