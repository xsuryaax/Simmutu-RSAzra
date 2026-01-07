<?php

namespace App\Http\Controllers\IndikatorMutuNasional;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class LaporanAnalisIMNController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        return view('menu.IndikatorMutuNasional.laporan-analis-imn.index', [
            'indikatorLaporan' => $this->getIndikatorLaporan($bulan, $tahun),
            'laporanNasional' => $this->getLaporanNasional($bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    // CARD ATAS - REKAP BULANAN
    private function getIndikatorLaporan($bulan, $tahun)
    {
        return DB::table('tbl_indikator_nasional as i')
            ->leftJoin('tbl_laporan_dan_analis_nasional as l', function ($join) use ($bulan, $tahun) {
                $join->on('i.id', '=', 'l.indikator_nasional_id')
                    ->whereMonth('l.tanggal_laporan', $bulan)
                    ->whereYear('l.tanggal_laporan', $tahun);
            })
            ->select(
                'i.id',
                'i.nama_indikator_nasional as nama_indikator',
                'i.target_indikator_nasional as target',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai'),
                DB::raw('COUNT(l.id) > 0 as sudah_input')
            )
            ->where('i.status_indikator_nasional', 'aktif')
            ->groupBy(
                'i.id',
                'i.nama_indikator_nasional',
                'i.target_indikator_nasional'
            )
            ->orderBy('i.id')
            ->get();
    }

    // CARD BAWAH - DETAIL LAPORAN
    private function getLaporanNasional($bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_nasional as l')
            ->join('tbl_indikator_nasional as i', 'i.id', '=', 'l.indikator_nasional_id')
            ->select(
                'l.id',
                'i.nama_indikator_nasional as nama_indikator',
                'l.tanggal_laporan',
                'i.target_indikator_nasional as target',
                'l.file_laporan',
                'l.nilai',
                'l.pencapaian'
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->orderBy('l.tanggal_laporan', 'desc')
            ->get();
    }

    // STORE - SAMA DENGAN UNIT
    public function store(Request $request)
    {
        $request->validate([
            'indikator_nasional_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $tanggal = Carbon::createFromDate(
            $request->tahun,
            $request->bulan,
            $request->tanggal_laporan
        );

        $indikator = DB::table('tbl_indikator_nasional')
            ->where('id', $request->indikator_nasional_id)
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        if (
            $tanggal->lt(Carbon::parse($indikator->tanggal_mulai)) ||
            $tanggal->gt(Carbon::parse($indikator->tanggal_selesai))
        ) {
            return back()->with('error', 'Tanggal laporan di luar periode indikator');
        }

        $exists = DB::table('tbl_laporan_dan_analis_nasional')
            ->where('indikator_nasional_id', $request->indikator_nasional_id)
            ->whereDate('tanggal_laporan', $tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tanggal tersebut sudah diinput');
        }

        // HITUNG NILAI
        $nilai = round(
            ($request->numerator / $request->denominator) * 100,
            2
        );

        // PENCAPAIAN
        $pencapaian = $nilai >= $indikator->target_indikator_nasional
            ? 'tercapai'
            : 'tidak-tercapai';

        // UPLOAD FILE
        $filePath = $request->file('file_laporan')
            ->store('laporan_nasional', 'public');

        // SIMPAN DATA
        DB::table('tbl_laporan_dan_analis_nasional')->insert([
            'indikator_nasional_id' => $request->indikator_nasional_id,
            'tanggal_laporan' => $tanggal->format('Y-m-d'),
            'nilai' => $nilai,
            'pencapaian' => $pencapaian,
            'file_laporan' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Laporan nasional berhasil disimpan');
    }
}