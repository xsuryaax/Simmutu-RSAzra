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
        $user = auth()->user();
        $periodeAktif = $this->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        $bulan = $request->bulan ?? Carbon::parse($periodeAktif->tanggal_mulai)->month;
        $tahun = $request->tahun ?? Carbon::parse($periodeAktif->tanggal_mulai)->year;

        $indikators = $this->getIndikator($user);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun);
        $laporan = $this->getLaporan($user, $periodeAktif, $bulan, $tahun);
        $laporanAll = $this->getLaporan($user, $periodeAktif, null, null, true); // Untuk export all

        return view('menu.IndikatorMutu.laporan-analis-imprs.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'laporanAll' => $laporanAll['grouped'],
        ]);
    }

    // AMBIL DATA INDIKATOR
    private function getIndikator($user)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_kategori_imprs as ki', 'ki.id', '=', 'k.kategori_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data as f', 'f.id', '=', 'k.frekuensi_pengumpulan_data_id')
            ->join('tbl_periode as p', function ($join) {
                $join->where('p.status', 'aktif');
            })
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'i.target_indikator',
                'p.tanggal_mulai',
                'p.tanggal_selesai',
                'k.jenis_indikator',
                'f.nama_frekuensi_pengumpulan_data',
                'ki.nama_kategori_imprs'
            )
            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderBy('ki.nama_kategori_imprs')
            ->orderBy('i.id')
            ->get();
    }

    // AMBIL DATA LAPORAN
    private function getLaporan($user, $periode = null, $bulan = null, $tahun = null, $all = false)
    {
        $query = DB::table('tbl_laporan_dan_analis_imprs as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
            ->select(
                'l.indikator_id',
                'l.numerator',
                'l.denominator',
                'l.nilai',
                'l.pencapaian',
                'l.tanggal_laporan',
                'u.nama_unit',
                'l.file_laporan',
                'l.created_at'
            )
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->when(!in_array($user->unit_id, [1, 2]), fn($q) => $q->where('l.unit_id', $user->unit_id))
            ->orderBy('l.tanggal_laporan', 'desc');

        if (!$all) {
            // Hanya untuk tabel atas
            $query->whereMonth('l.tanggal_laporan', $bulan)
                ->whereYear('l.tanggal_laporan', $tahun)
                ->whereBetween('l.tanggal_laporan', [$periode->tanggal_mulai, $periode->tanggal_selesai]);
        }

        $laporan = $all ? $query->get() : $query->paginate(10);

        return [
            'paginator' => $all ? null : $laporan,
            'grouped' => $laporan->groupBy('indikator_id'),
        ];
    }

    // AMBIL REKAP BULANAN
    private function getRekapBulanan($user, $bulan, $tahun)
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

    // AMBIL PERIODE AKTIF
    private function getPeriodeAktif()
    {
        return DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->select('tanggal_mulai', 'tanggal_selesai')
            ->first();

    }

    // STORE DATA LAPORAN
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|date',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $periode = $this->getPeriodeAktif();
        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum tersedia');
        }

        $tanggal = Carbon::parse($request->tanggal_laporan);

        // VALIDASI PERIODE
        if ($tanggal->lt($periode->tanggal_mulai) || $tanggal->gt($periode->tanggal_selesai)) {
            return back()->with('error', 'Tanggal laporan di luar periode mutu aktif');
        }

        $unitId = Auth::user()->unit_id;

        // Ambil indikator + kategori_id
        $indikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select('i.id', 'i.target_indikator', 'k.kategori_id')
            ->where('i.id', $request->indikator_id)
            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas rs%'")
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak aktif atau bukan prioritas RS');
        }

        // Cek data sudah ada
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
        $pencapaian = $nilai >= $indikator->target_indikator ? 'tercapai' : 'tidak tercapai';

        $filePath = $request->file('file_laporan')->store('laporan_imprs', 'public');

        DB::table('tbl_laporan_dan_analis_imprs')->insert([
            'indikator_id' => $indikator->id,
            'kategori_id' => $indikator->kategori_id, // 🔹 penting!
            'unit_id' => $unitId,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
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
