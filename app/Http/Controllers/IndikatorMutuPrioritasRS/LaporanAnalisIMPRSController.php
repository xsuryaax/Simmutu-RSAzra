<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisIMPRSController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $laporan = $this->getLaporan($bulan, $tahun);

        return view('menu.IndikatorMutuPrioritasRS.laporan-analis-imprs.index', [
            'indikators' => $this->getIndikator(),
            'rekapBulanan' => $this->getRekapBulanan($bulan, $tahun),
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'usedDates' => $this->getUsedDates($bulan, $tahun),
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    private function getIndikator()
    {
        return DB::table('tbl_imprs as i')
            ->join('tbl_kategori_imprs as k', 'k.id', '=', 'i.kategori_id')
            ->select(
                'i.id',
                'i.nama_imprs',
                'i.target_imprs',
                'k.nama_kategori_imprs'
            )
            ->orderBy('i.id')
            ->get();
    }

    private function getLaporan($bulan, $tahun)
    {
        $laporan = DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
            ->select(
                'l.imprs_id',
                'l.nilai',
                'l.pencapaian',
                'l.tanggal_laporan',
                'u.nama_unit'
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->orderBy('l.tanggal_laporan', 'desc')
            ->paginate(10);

        return [
            'paginator' => $laporan,
            'grouped' => $laporan->getCollection()->groupBy('imprs_id'),
        ];
    }

    private function getRekapBulanan($bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_imprs as i', 'i.id', '=', 'l.imprs_id')
            ->select(
                'l.imprs_id',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai_rekap'),
                DB::raw("
                    CASE
                        WHEN ROUND(AVG(l.nilai)::numeric, 2) >= i.target_imprs
                        THEN 'tercapai'
                        ELSE 'tidak tercapai'
                    END as status
                ")
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->groupBy('l.imprs_id', 'i.target_imprs')
            ->get()
            ->keyBy('imprs_id');
    }

    private function getUsedDates($bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_imprs')
            ->select(
                'imprs_id',
                DB::raw('EXTRACT(DAY FROM tanggal_laporan)::int as hari')
            )
            ->whereMonth('tanggal_laporan', $bulan)
            ->whereYear('tanggal_laporan', $tahun)
            ->get()
            ->groupBy('imprs_id')
            ->map(fn($rows) => $rows->pluck('hari')->values());
    }

    public function store(Request $request)
    {
        $request->validate([
            'imprs_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|integer|min:1|max:31',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $unitId = Auth::user()->unit_id;
        if (!$unitId) {
            return back()->with('error', 'Unit user belum ditentukan');
        }

        $tanggal = Carbon::createFromDate(
            $request->tahun,
            $request->bulan,
            $request->tanggal_laporan
        );

        // Ambil data IMPRS seperlunya saja
        $imprs = DB::table('tbl_imprs')
            ->select(
                'id',
                'kategori_id',
                'target_imprs',
                'tanggal_mulai',
                'tanggal_selesai'
            )
            ->where('id', $request->imprs_id)
            ->first();

        if (!$imprs) {
            return back()->with('error', 'IMPRS tidak ditemukan');
        }

        // Validasi periode (WAJIB untuk mutu RS)
        if ($tanggal < $imprs->tanggal_mulai || $tanggal > $imprs->tanggal_selesai) {
            return back()->with('error', 'Tanggal di luar periode IMPRS');
        }

        // Cek duplikat (super cepat)
        if (
            DB::table('tbl_laporan_dan_analis_imprs')
                ->where('imprs_id', $imprs->id)
                ->where('unit_id', $unitId)
                ->whereDate('tanggal_laporan', $tanggal)
                ->exists()
        ) {
            return back()->with('error', 'Data sudah diinput');
        }

        // Hitung nilai & pencapaian
        $nilai = ($request->numerator / $request->denominator) * 100;
        $pencapaian = $nilai >= $imprs->target_imprs
            ? 'tercapai'
            : 'tidak tercapai';

        $filePath = $request->file('file_laporan')
            ->store('laporan_imprs', 'public');

        DB::table('tbl_laporan_dan_analis_imprs')->insert([
            'imprs_id' => $imprs->id,
            'kategori_id' => $imprs->kategori_id,
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
