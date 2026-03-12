<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
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
        $tahun = $request->tahun ?? $periodeMulai->year;
        $bulan = $request->bulan ?? $periodeMulai->month;
        $kategori = $request->kategori_indikator;
        $indikators = $this->indikatorService->getIndikator($user, $kategori);
        $indikatorIds = $indikators->pluck('id')->toArray();

        // =============================
        // ANALISA PER BULAN
        // =============================
        $analisaRows = DB::table('tbl_hasil_analisa')
            ->whereYear('tanggal_analisa', $tahun)
            ->whereMonth('tanggal_analisa', $bulan)
            ->when(
                !in_array($roleId, [1, 2]),
                fn($q) => $q->where('unit_id', $user->unit_id)
            )
            ->whereIn('indikator_id', $indikatorIds)
            ->get()
            ->keyBy('indikator_id');

        $analisaData = [];

        foreach ($indikators as $ind) {
            $analisa = $analisaRows[$ind->id] ?? null;

            $analisaData[$ind->id] = [
                'analisa' => $analisa->analisa ?? '-',
                'tindak_lanjut' => $analisa->tindak_lanjut ?? '-',
            ];
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
            'kategoriDipilih' => $kategori
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

        DB::table('tbl_hasil_analisa')->updateOrInsert(
            [
                'indikator_id' => $request->indikator_id,
                'unit_id' => $user->unit_id,
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
            ROUND(AVG(nilai),2) as nilai
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