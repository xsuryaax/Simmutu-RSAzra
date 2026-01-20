<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanAnalisIMPUController extends Controller
{
    // DISPLAY INDEX
    public function index(Request $request)
    {
        $user = auth()->user();
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $indikators = $this->getIndikator($user);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun);

        $laporan = $this->getLaporan($user, $bulan, $tahun);

        return view('menu.IndikatorMutu.laporan-analis-impu.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'laporanHarian' => $laporan['grouped'],
            'paginate' => $laporan['paginator'],
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    // AMBIL DATA INDIKATOR
    private function getIndikator($user)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data as f', 'f.id', '=', 'k.frekuensi_pengumpulan_data_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'i.target_indikator',
                'i.tanggal_mulai',
                'i.tanggal_selesai',
                'f.nama_frekuensi_pengumpulan_data',
                'u.nama_unit'
            )
            ->where('i.status_indikator', 'aktif')
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas unit%'")
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderBy('i.id')
            ->get();
    }

    // AMBIL DATA LAPORAN
    private function getLaporan($user, $bulan, $tahun)
    {
        $laporan = DB::table('tbl_laporan_dan_analis_unit as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->select(
                'l.indikator_id',
                'l.unit_id',
                'l.nilai',
                'l.tanggal_laporan',
                'l.file_laporan',
                'l.created_at',
            )
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereRaw("k.jenis_indikator ILIKE '%prioritas unit%'")
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('l.unit_id', $user->unit_id)
            )
            ->orderBy('l.tanggal_laporan', 'desc')
            ->paginate(10);

        return [
            'paginator' => $laporan,
            'grouped' => $laporan->getCollection()->groupBy('indikator_id'),
        ];
    }


    // AMBIL REKAP BULANAN
    private function getRekapBulanan($user, $bulan, $tahun)
    {
        return DB::table('tbl_laporan_dan_analis_unit as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
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
            ->whereMonth('l.tanggal_laporan', $bulan)
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereRaw("k.jenis_indikator ILIKE '%Prioritas Unit%'")
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('l.unit_id', $user->unit_id)
            )
            ->groupBy('l.indikator_id', 'l.unit_id', 'i.target_indikator')
            ->get()
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);
    }

    // STORE DATA LAPORAN
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'numerator' => 'required|numeric|min:0',
            'denominator' => 'required|numeric|min:1',
            'tanggal_laporan' => 'required|date',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $today = now();
        $day = min($today->day, Carbon::create($request->tahun, $request->bulan, 1)->daysInMonth);
        $tanggal = Carbon::create($request->tahun, $request->bulan, $day);


        $indikator = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->first();

        if (
            $tanggal->lt(Carbon::parse($indikator->tanggal_mulai)) ||
            $tanggal->gt(Carbon::parse($indikator->tanggal_selesai))
        ) {
            return back()->with('error', 'Tanggal laporan di luar periode indikator');
        }

        $exists = DB::table('tbl_laporan_dan_analis_unit')
            ->where('indikator_id', $request->indikator_id)
            ->where('unit_id', $request->unit_id)
            ->whereDate('tanggal_laporan', $tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tanggal tersebut sudah diinput');
        }

        $nilai = ($request->numerator / $request->denominator) * 100;
        $pencapaian = $nilai >= $indikator->target_indikator
            ? 'tercapai'
            : 'tidak-tercapai';

        $filePath = $request->file('file_laporan')
            ->store('laporan_indikator', 'public');

        DB::table('tbl_laporan_dan_analis_unit')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'nilai' => round($nilai, 2),
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $tanggal->format('Y-m-d'),
            'file_laporan' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }
}
