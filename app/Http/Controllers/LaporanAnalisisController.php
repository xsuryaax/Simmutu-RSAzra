<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisisController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $indikators = $this->getIndikator($user);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun);

        $laporan = $this->getLaporan($user, $bulan, $tahun);

        return view('menu.LaporanAnalisis.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'laporanHarian' => $laporan['grouped'],   // Data grouped
            'paginate' => $laporan['paginator'], // Paginator untuk links()
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }


    private function getIndikator($user)
    {
        return DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator_mutu', 'tbl_kamus_indikator_mutu.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_frekuensi_pengumpulan_data.id', '=', 'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                'tbl_indikator.target_indikator',
                'tbl_indikator.tanggal_mulai',
                'tbl_indikator.tanggal_selesai',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_unit.nama_unit'
            )
            ->where('tbl_indikator.status_indikator', 'aktif')
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) =>
                $q->where('tbl_indikator.unit_id', $user->unit_id)
            )
            ->orderBy('tbl_indikator.id')
            ->get();

    }

    private function getLaporan($user, $bulan, $tahun)
    {
        // Ambil data per row dengan paginate
        $laporan = DB::table('tbl_laporan_dan_analis')
            ->select('indikator_id', 'unit_id', 'nilai', 'tanggal_laporan')
            ->whereMonth('tanggal_laporan', $bulan)
            ->whereYear('tanggal_laporan', $tahun)
            ->when(!in_array($user->unit_id, [1, 2]), function ($q) use ($user) {
                $q->where('unit_id', $user->unit_id);
            })
            ->orderBy('tanggal_laporan', 'desc')
            ->paginate(10); // 10 row per halaman

        // Group per indikator di Collection
        $grouped = $laporan->getCollection()->groupBy('indikator_id');

        return [
            'paginator' => $laporan,
            'grouped' => $grouped,
        ];
    }


    private function getRekapBulanan($user, $bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai_rekap'),
                DB::raw("CASE WHEN ROUND(AVG(l.nilai)::numeric, 2) >= i.target_indikator THEN 'tercapai' ELSE 'tidak tercapai' END as status")
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('l.unit_id', $user->unit_id)
            )
            ->groupBy('l.indikator_id', 'l.unit_id', 'i.target_indikator')
            ->get()
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);
    }


    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'nullable|file|max:5120',
        ]);

        $tanggal = Carbon::createFromDate(
            $request->tahun,
            $request->bulan,
            $request->tanggal_laporan
        );

        $indikator = DB::table('tbl_indikator')->where('id', $request->indikator_id)->first();

        if (
            $tanggal->lt(Carbon::parse($indikator->tanggal_mulai)) ||
            $tanggal->gt(Carbon::parse($indikator->tanggal_selesai))
        ) {
            return back()->with('error', 'Tanggal laporan di luar periode indikator');
        }

        $exists = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->where('unit_id', $request->unit_id)
            ->whereDate('tanggal_laporan', $tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tanggal tersebut sudah diinput');
        }

        $nilai = ($request->numerator / $request->denominator) * 100;
        $pencapaian = $nilai >= $indikator->target_indikator ? 'tercapai' : 'tidak-tercapai';

        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggal->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }
}
