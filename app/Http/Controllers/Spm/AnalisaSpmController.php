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
        
        // Reset filters if coming from a different page
        $prevPath = parse_url(url()->previous(), PHP_URL_PATH);
        $currPath = $request->getPathInfo();
        if ($prevPath !== $currPath && !$request->ajax() && !$request->hasAny(['bulan', 'tahun', 'unit_id', 'kategori_spm', 'page'])) {
            session()->forget('simmutu_filters');
        }

        // Use structured session for filters
        $filters = session('simmutu_filters', []);

        if (!$request->has('bulan')) {
            $bulan = $filters['bulan'] ?? null;
            $tahun = $filters['tahun'] ?? null;
            
            if (!$bulan || !$tahun) {
                $bulan = $periodeMulai->month;
                $tahun = $periodeMulai->year;
            }
        } else {
            $bulan = (int)$request->bulan;
            $tahun = (int)$request->tahun;
        }

        $unitIdFilter = $request->unit_id ?? ($filters['unit_id'] ?? null);
        if (in_array($roleId, [1, 2])) {
            if ($request->has('unit_id')) {
                $unitIdFilter = $request->unit_id;
            }
        } else {
            $unitIdFilter = $user->unit_id;
        }

        $kategori = $request->kategori_spm ?? ($filters['kategori'] ?? null);

        // Update session with new structured data
        $filters = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'unit_id' => $unitIdFilter,
            'kategori' => $kategori
        ];
        session(['simmutu_filters' => $filters]);

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
            
        if ($unitIdFilter) {
            $spmsQuery->where('tbl_spm.unit_id', $unitIdFilter);
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
            ->get()
            ->keyBy('spm_id');

        $analisaData = [];

        foreach ($spms as $spm) {
            $rowAnalisa = $analisaRows->get($spm->id);
            $analisaData[$spm->id] = [
                'analisa' => optional($rowAnalisa)->analisa ?? '-',
                'tindak_lanjut' => optional($rowAnalisa)->tindak_lanjut ?? '-',
            ];
        }

        $units = [];
        if (in_array($roleId, [1, 2])) {
            $units = DB::table('tbl_unit')->where('status_unit', 'aktif')->orderBy('nama_unit')->get();
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
            'kategoriDipilih' => $kategori,
            'units' => $units,
            'selectedUnitId' => (int)$unitIdFilter,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $tanggalAnalisa = Carbon::createFromDate($tahun, $bulan, 1);

        $unitId = (in_array($user->unit_id, [1, 2])) 
            ? ($request->unit_id ?? $user->unit_id) 
            : $user->unit_id;

        SpmHasilAnalisa::updateOrCreate(
            [
                'spm_id' => $request->spm_id,
                'unit_id' => $unitId,
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
                CASE 
                    WHEN SUM(denominator) > 0 THEN ROUND(SUM(numerator) * 100.0 / SUM(denominator), 2)
                    ELSE NULL
                END as nilai
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
