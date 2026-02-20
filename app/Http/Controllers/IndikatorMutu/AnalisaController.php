<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class AnalisaController extends Controller
{
    /**
     * Tampilkan halaman analisa data
     */
    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        $indikators = $this->getIndikator($user);

        $analisaData = [];

        $analisaRows = DB::table('tbl_hasil_analisa')
            ->when(
                !in_array($roleId, [1, 2]),
                fn($q) => $q->where('unit_id', $user->unit_id)
            )
            ->whereIn('indikator_id', $indikators->pluck('id'))
            ->get()
            ->keyBy('indikator_id');

        foreach ($indikators as $ind) {

            $analisa = $analisaRows[$ind->id] ?? null;

            $analisaData[$ind->id] = [
                'analisa' => $analisa->analisa ?? '-',
                'tindak_lanjut' => $analisa->tindak_lanjut ?? '-',
            ];
        }

        return view('menu.IndikatorMutu.analisa-data.index', [
            'roleId' => $roleId,
            'indikators' => $indikators,
            'analisaData' => $analisaData,
            'firstIndikator' => $indikators->first()
        ]);
    }

    // Ambil data indikator
    private function getIndikator($user, $kategoriIndikator = null)
    {
        return DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->join('tbl_periode as p', fn($join) => $join->where('p.status', 'aktif'))
            ->select(
                'i.id',
                'i.nama_indikator',
                'i.unit_id',
                'u.nama_unit'
            )
            ->where('i.status_indikator', 'aktif')
            ->when(
                !in_array($user->unit_id, [1, 2]),
                fn($q) => $q->where('i.unit_id', $user->unit_id)
            )
            ->orderByRaw("
            CASE 
                WHEN k.kategori_indikator ILIKE '%Nasional%' THEN 1
                WHEN k.kategori_indikator ILIKE '%Prioritas RS%' THEN 2
                WHEN k.kategori_indikator ILIKE '%Prioritas Unit%' THEN 3
                ELSE 4
            END ASC
        ")
            ->orderBy('i.id')
            ->get();
    }

    // Simpan hasil analisa dan tindak lanjut
    public function store(Request $request)
    {
        $user = Auth::user();

        if (in_array($user->role_id, [1, 2])) {
            $indikator = DB::table('tbl_indikator')
                ->where('id', $request->indikator_id)
                ->first();

            $unitId = $indikator->unit_id;
        } else {
            $unitId = $user->unit_id;
        }

        DB::table('tbl_hasil_analisa')->updateOrInsert(
            [
                'indikator_id' => (int) $request->indikator_id,
                'unit_id' => (int) $unitId,
            ],
            [
                'tanggal_analisa' => now()->toDateString(),
                'analisa' => $request->analisa,
                'tindak_lanjut' => $request->tindak_lanjut,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return response()->json(['success' => true]);
    }

    // Ambil data untuk chart analisa
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
            $index = $row->bulan - 1;
            $realisasi[$index] = $row->nilai;
        }

        return response()->json([
            'target' => $target,
            'realisasi' => $realisasi
        ]);
    }
}
