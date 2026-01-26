<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisIMPUController extends Controller
{
    /* =========================
     * DISPLAY INDEX
     * ========================= */
    public function index(Request $request)
    {
        $user = auth()->user();
        $periodeAktif = $this->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        // 🔥 AMBIL FILTER
        $bulan = $request->bulan ?? Carbon::parse($periodeAktif->tanggal_mulai)->month;
        $tahun = $request->tahun ?? Carbon::parse($periodeAktif->tanggal_mulai)->year;

        $indikators = $this->getIndikator($user);

        // 🔥 REKAP SESUAI FILTER
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun);

        // 🔥 LAPORAN BAWAH TETAP GLOBAL
        $laporan = $this->getLaporan($user, $periodeAktif);

        return view('menu.IndikatorMutu.laporan-analis-impu.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
        ]);
    }


    /* =========================
     * AMBIL DATA INDIKATOR
     * ========================= */
    private function getIndikator($user)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data as f', 'f.id', '=', 'k.frekuensi_pengumpulan_data_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')

            // 🔥 JOIN KE PERIODE AKTIF (GLOBAL)
            ->join('tbl_periode as p', function ($join) {
                $join->where('p.status', 'aktif');
            })

            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'i.target_indikator',
                'p.tanggal_mulai as periode_mulai',
                'p.tanggal_selesai as periode_selesai',
                'f.nama_frekuensi_pengumpulan_data',
                'u.nama_unit'
            )

            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas unit%'")

            // 🔐 FILTER UNIT
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )

            ->orderBy('i.id')
            ->get();
    }

    /* =========================
     * AMBIL DATA LAPORAN
     * ========================= */
    private function getLaporan($user, $periode, $bulan = null, $tahun = null)
    {
        $query = DB::table('tbl_laporan_dan_analis_unit as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas unit%'")
            ->whereBetween('l.tanggal_laporan', [$periode->tanggal_mulai, $periode->tanggal_selesai])
            ->when(!in_array($user->unit_id, [1, 2]), fn($q) => $q->where('l.unit_id', $user->unit_id))
            ->orderBy('l.tanggal_laporan', 'desc');

        // Jika filter bulan & tahun
        if ($bulan && $tahun) {
            $query->whereMonth('l.tanggal_laporan', $bulan)
                ->whereYear('l.tanggal_laporan', $tahun);
        }

        $laporan = $query->get(); // Ambil semua, jangan paginate dulu
        $grouped = $laporan->groupBy('indikator_id');

        // Siapkan paginator manual jika perlu, atau kirim semua ke Blade
        return [
            'paginator' => $laporan, // bisa ganti paginate jika mau
            'grouped' => $grouped,
        ];
    }


    /* =========================
     * AMBIL REKAP BULANAN
     * ========================= */
    private function getRekapBulanan($user, $bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_unit as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')

            // 🔥 FILTER BULAN & TAHUN
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)

            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai)::numeric, 2) as nilai_rekap'),
                DB::raw("
                CASE 
                    WHEN ROUND(AVG(l.nilai)::numeric, 2) >= i.target_indikator 
                    THEN 'tercapai' 
                    ELSE 'tidak tercapai' 
                END as status
            ")
            )

            ->whereRaw("k.jenis_indikator ILIKE '%prioritas unit%'")

            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('l.unit_id', $user->unit_id)
            )

            ->groupBy('l.indikator_id', 'l.unit_id', 'i.target_indikator')
            ->get()
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);
    }


    /* =========================
     * STORE DATA LAPORAN
     * ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required',
            'unit_id' => 'required',
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

        // 🔥 VALIDASI PERIODE
        if (
            $tanggal->lt($periode->tanggal_mulai) ||
            $tanggal->gt($periode->tanggal_selesai)
        ) {
            return back()->with('error', 'Tanggal laporan di luar periode mutu aktif');
        }

        $nilai = ($request->numerator / $request->denominator) * 100;

        $pencapaian = $nilai >= DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->value('target_indikator')
            ? 'tercapai'
            : 'tidak-tercapai';

        DB::table('tbl_laporan_dan_analis_unit')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggal,
            'file_laporan' => $request->file('file_laporan')->store('laporan_indikator', 'public'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    /* =========================
     * AMBIL PERIODE AKTIF
     * ========================= */
    private function getPeriodeAktif()
    {
        return DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();
    }
}
