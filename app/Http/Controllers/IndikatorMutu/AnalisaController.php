<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class AnalisaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        // =============================
        // FILTER
        // =============================
        $kategori = $request->kategori_indikator;

        // =============================
        // PERIODE AKTIF
        // =============================
        $periode = DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();

        $periodeMulai = Carbon::parse($periode->tanggal_mulai);
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

        $tahunAktif = range(
            $periodeMulai->year,
            $periodeSelesai->year
        );
        $bulan = $request->bulan ?? $periodeMulai->month;
        $tahun = $request->tahun ?? $periodeMulai->year;


        // =============================
        // AMBIL INDIKATOR
        // =============================
        $indikators = $this->getIndikator($user, $kategori);

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
            ->whereIn('indikator_id', $indikators->pluck('id'))
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

    private function getIndikator($user, $kategori = null)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->join('tbl_periode as p', fn($join) => $join->where('p.status', 'aktif'))
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'u.nama_unit',
                'k.kategori_indikator'
            )
            ->where('i.status_indikator', 'aktif')
            ->when(
                $kategori,
                fn($q) => $q->where('k.kategori_indikator', 'ILIKE', "%$kategori%")
            )
            ->when(
                !in_array($user->role_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            // ORDER indikator sesuai unit user di paling atas
            ->orderByRaw("CASE WHEN i.unit_id = ? THEN 0 ELSE 1 END, i.id", [$user->unit_id])
            ->get();
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

    public function chartData($indikatorId)
    {
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
            ->selectRaw('EXTRACT(MONTH FROM tanggal_laporan) as bulan, nilai')
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