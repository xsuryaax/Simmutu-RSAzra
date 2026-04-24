<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\IndikatorMutuService;

class AnalisaController extends Controller
{
    protected $indikatorService;

    public function __construct(IndikatorMutuService $indikatorService)
    {
        $this->indikatorService = $indikatorService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        $periode = $this->indikatorService->getPeriodeAktif();

        $periodeMulai = Carbon::parse($periode->tanggal_mulai);
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

        $tahunAktif = range(
            $periodeMulai->year,
            $periodeSelesai->year
        );
        // Reset filters if coming from a different page
        $prevPath = parse_url(url()->previous(), PHP_URL_PATH);
        $currPath = $request->getPathInfo();
        if ($prevPath !== $currPath && !$request->ajax() && !$request->hasAny(['bulan', 'tahun', 'unit_id', 'kategori_indikator', 'page'])) {
            session()->forget('simmutu_filters');
        }

        $filters = session('simmutu_filters', []);

        if (!$request->has('bulan')) {
            $bulan = $filters['bulan'] ?? $periodeMulai->month;
            $tahun = $filters['tahun'] ?? $periodeMulai->year;
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

        $kategori = $request->kategori_indikator ?? ($filters['kategori'] ?? null);

        // Update session with new structured data
        $filters = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'unit_id' => $unitIdFilter,
            'kategori' => $kategori
        ];
        session(['simmutu_filters' => $filters]);

        // Clone user for filtering if unitIdFilter is provided
        $unitFilterUser = clone $user;
        if ($unitIdFilter) {
            $unitFilterUser->unit_id = $unitIdFilter;
        }

        $indikators = $this->indikatorService->getIndikator($unitFilterUser, $kategori);
        $indikatorIds = $indikators->pluck('id')->toArray();

        // =============================
        // ANALISA PER BULAN
        // =============================
        $analisaRows = DB::table('tbl_hasil_analisa')
            ->whereYear('tanggal_analisa', $tahun)
            ->whereMonth('tanggal_analisa', $bulan)
            ->whereIn('indikator_id', $indikatorIds)
            ->get()
            ->keyBy('indikator_id');

        $analisaData = [];

        foreach ($indikators as $ind) {
            $rowAnalisa = $analisaRows->get($ind->id);
            $analisaData[$ind->id] = [
                'analisa' => optional($rowAnalisa)->analisa ?? '-',
                'tindak_lanjut' => optional($rowAnalisa)->tindak_lanjut ?? '-',
            ];
        }

        $units = [];
        if (in_array($roleId, [1, 2])) {
            $units = DB::table('tbl_unit')->where('status_unit', 'aktif')->orderBy('nama_unit')->get();
        }

        return view('menu.IndikatorMutu.analisa-data.index', [
            'indikators' => $indikators,
            'analisaData' => $analisaData,
            'firstIndikator' => $indikators->first(),
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

        // Ambil bulan & tahun dari request
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        // Buat tanggal sesuai filter (tanggal 1 saja cukup)
        $tanggalAnalisa = Carbon::createFromDate($tahun, $bulan, 1);

        $unitId = (in_array($user->unit_id, [1, 2])) 
            ? ($request->unit_id ?? $user->unit_id) 
            : $user->unit_id;

        DB::table('tbl_hasil_analisa')->updateOrInsert(
            [
                'indikator_id' => $request->indikator_id,
                'unit_id' => $unitId,
                'tanggal_analisa' => $tanggalAnalisa
            ],
            [
                'analisa' => $request->analisa,
                'tindak_lanjut' => $request->tindak_lanjut,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return response()->json(['success' => true]);
    }

    public function chartData(Request $request, $indikatorId)
    {
        $tahun = $request->tahun ?? date('Y');

        $indikator = DB::table('tbl_indikator')
            ->where('id', $indikatorId)
            ->first();

        if (!$indikator) {
            return response()->json([
                'target' => array_fill(0, 12, null),
                'realisasi' => array_fill(0, 12, null),
            ]);
        }

        $rows = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $indikatorId)
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

        $target = array_fill(0, 12, $indikator->target_indikator);
        $realisasi = array_fill(0, 12, null);

        foreach ($rows as $row) {
            $realisasi[$row->bulan - 1] = $row->nilai;
        }

        return response()->json([
            'target' => $target,
            'realisasi' => $realisasi
        ]);
    }
}