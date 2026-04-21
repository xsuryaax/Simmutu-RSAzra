<?php

namespace App\Http\Controllers\Spm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SpmHasilAnalisa;
use Carbon\Carbon;

class AnalisaSpmController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        
        $periode = DB::table('tbl_periode')->where('status', 'aktif')->first();

        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        $periodeMulai = Carbon::parse($periode->tanggal_mulai);
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

        $tahunAktif = range(
            $periodeMulai->year,
            $periodeSelesai->year
        );
        
        $tahun = $request->tahun ?? $periodeMulai->year;
        $bulan = $request->bulan ?? $periodeMulai->month;
        $kategori = $request->kategori_spm ?? null;

        $spmsQuery = DB::table('tbl_spm')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_spm.unit_id')
            ->join('tbl_spm_periode', function ($join) use ($periode) {
                $join->on('tbl_spm.id', '=', 'tbl_spm_periode.spm_id')
                     ->where('tbl_spm_periode.periode_id', $periode->id)
                     ->where('tbl_spm_periode.status', 'aktif');
            })
            ->select('tbl_spm.*', 'tbl_unit.nama_unit')
            ->where('tbl_spm.status_spm', 'aktif');
            
        if (!in_array($roleId, [1, 2])) {
            $spmsQuery->where('tbl_spm.unit_id', $user->unit_id);
        }
        $spms = $spmsQuery->get();

        $spmIds = $spms->pluck('id')->toArray();

        // =============================
        // ANALISA PER BULAN
        // =============================
        $analisaRows = DB::table('tbl_spm_hasil_analisa')
            ->whereYear('tanggal_analisa', $tahun)
            ->whereMonth('tanggal_analisa', $bulan)
            ->whereIn('spm_id', $spmIds)
            ->when(
                !in_array($roleId, [1, 2]),
                fn($q) => $q->where('unit_id', $user->unit_id)
            )
            ->get()
            ->keyBy('spm_id');

        $analisaData = [];

        foreach ($spms as $spm) {
            $analisa = $analisaRows[$spm->id] ?? null;

            $analisaData[$spm->id] = [
                'analisa' => $analisa->analisa ?? '-',
                'tindak_lanjut' => $analisa->tindak_lanjut ?? '-',
            ];
        }

        return view('menu.spm.analisa-spm.index', [
            'spms' => $spms,
            'analisaData' => $analisaData,
            'firstSpm' => $spms->first(),
            'tahunAktif' => $tahunAktif,
            'periodeMulai' => $periodeMulai,
            'periodeSelesai' => $periodeSelesai,
            'tahunDipilih' => $tahun,
            'bulanDipilih' => $bulan,
            'kategoriDipilih' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $tanggalAnalisa = Carbon::createFromDate($tahun, $bulan, 1);

        SpmHasilAnalisa::updateOrCreate(
            [
                'spm_id' => $request->spm_id,
                'unit_id' => $user->unit_id,
                'tanggal_analisa' => $tanggalAnalisa->format('Y-m-d')
            ],
            [
                'analisa' => $request->analisa,
                'tindak_lanjut' => $request->tindak_lanjut,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Analisa berhasil disimpan'
        ]);
    }

    public function chartData(Request $request, $spmId)
    {
        $tahun = $request->tahun ?? date('Y');

        $spm = DB::table('tbl_spm')->where('id', $spmId)->first();

        if (!$spm) {
            return response()->json([
                'target'    => array_fill(0, 12, null),
                'realisasi' => array_fill(0, 12, null),
            ]);
        }

        $rows = DB::table('tbl_spm_laporan_dan_analis')
            ->where('spm_id', $spmId)
            ->whereBetween('tanggal_laporan', ["$tahun-01-01", "$tahun-12-31"])
            ->selectRaw('
                EXTRACT(MONTH FROM tanggal_laporan) as bulan,
                ROUND(CAST(AVG(nilai) AS numeric), 2) as nilai
            ')
            ->groupByRaw('EXTRACT(MONTH FROM tanggal_laporan)')
            ->orderBy('bulan')
            ->get();

        $target    = array_fill(0, 12, $spm->target_spm);
        $realisasi = array_fill(0, 12, null);

        foreach ($rows as $row) {
            $realisasi[(int)$row->bulan - 1] = $row->nilai;
        }

        return response()->json([
            'target'    => $target,
            'realisasi' => $realisasi,
        ]);
    }
}
