<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisIMPRSController extends Controller
{
    // DISPLAY INDEX
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $laporan = $this->getLaporan($bulan, $tahun);

        return view('menu.IndikatorMutu.laporan-analis-imprs.index', [
            'indikators' => $this->getIndikator(),
            'rekapBulanan' => $this->getRekapBulanan($bulan, $tahun),
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'usedDates' => $this->getUsedDates($bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    // AMBIL DATA INDIKATOR
    private function getIndikator()
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_kategori_imprs as ki', 'ki.id', '=', 'k.kategori_id')
            ->leftJoin(
                'tbl_frekuensi_pengumpulan_data as f',
                'f.id',
                '=',
                'k.frekuensi_pengumpulan_data_id'
            )
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.target_indikator',
                'i.tanggal_mulai',
                'i.tanggal_selesai',
                'k.jenis_indikator',
                'f.nama_frekuensi_pengumpulan_data',
                'ki.nama_kategori_imprs'
            )
            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->orderBy('ki.nama_kategori_imprs')
            ->orderBy('i.id')
            ->get();
    }

    // AMBIL DATA LAPORAN
    private function getLaporan($bulan, $tahun)
    {
        $laporan = DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
            ->select(
                'l.indikator_id',
                'l.nilai',
                'l.pencapaian',
                'l.tanggal_laporan',
                'u.nama_unit',
                'l.file_laporan',
                'l.created_at'
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->orderBy('l.tanggal_laporan', 'desc')
            ->paginate(10);

        return [
            'paginator' => $laporan,
            'grouped' => $laporan->getCollection()->groupBy('indikator_id'),
        ];
    }

    // AMBIL REKAP BULANAN
    private function getRekapBulanan($bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select(
                'l.indikator_id',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai_rekap'),
                DB::raw("
                CASE
                    WHEN ROUND(AVG(l.nilai)::numeric, 2) >= i.target_indikator
                    THEN 'tercapai'
                    ELSE 'tidak tercapai'
                END as status
            ")
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->groupBy('l.indikator_id', 'i.target_indikator')
            ->get()
            ->keyBy('indikator_id');
    }

    // AMBIL TANGGAL YANG SUDAH DIGUNAKAN
    private function getUsedDates($bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select(
                'l.indikator_id',
                DB::raw('EXTRACT(DAY FROM l.tanggal_laporan)::int as hari')
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->get()
            ->groupBy('indikator_id')
            ->map(fn($rows) => $rows->pluck('hari')->values());
    }

    // PROSES SIMPAN LAPORAN
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|date',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $unitId = Auth::user()->unit_id;
        if (!$unitId) {
            return back()->with('error', 'Unit user belum ditentukan');
        }

        $today = now();
        $day = min($today->day, Carbon::create($request->tahun, $request->bulan, 1)->daysInMonth);
        $tanggal = Carbon::create($request->tahun, $request->bulan, $day);

        $indikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select(
                'i.id',
                'k.kategori_id',
                'i.target_indikator',
                'i.tanggal_mulai',
                'i.tanggal_selesai',

            )
            ->where('i.id', $request->indikator_id)
            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator bukan Prioritas RS atau tidak aktif');
        }

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        if ($tanggal < $indikator->tanggal_mulai || $tanggal > $indikator->tanggal_selesai) {
            return back()->with('error', 'Tanggal di luar periode Indikator');
        }

        if (
            DB::table('tbl_laporan_dan_analis_imprs')
                ->where('indikator_id', $indikator->id)
                ->where('unit_id', $unitId)
                ->whereDate('tanggal_laporan', $tanggal)
                ->exists()
        ) {
            return back()->with('error', 'Data sudah diinput');
        }

        $nilai = ($request->numerator / $request->denominator) * 100;
        $pencapaian = $nilai >= $indikator->target_indikator
            ? 'tercapai'
            : 'tidak tercapai';

        $filePath = $request->file('file_laporan')
            ->store('laporan_imprs', 'public');

        DB::table('tbl_laporan_dan_analis_imprs')->insert([
            'indikator_id' => $indikator->id,
            'kategori_id' => $indikator->kategori_id,
            'unit_id' => $unitId,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggal,
            'file_laporan' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }
}
