<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Models\tbl_hasil_analisa;

class AnalisaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        $indikators = $this->getIndikator($user);

        $analisaData = [];

        foreach ($indikators as $ind) {

            $query = DB::table('tbl_hasil_analisa')
                ->where('indikator_id', $ind->id);

            // Kalau bukan role 1 atau 2, batasi unit
            if (!in_array($roleId, [1, 2])) {
                $query->where('unit_id', $user->unit_id);
            }

            $analisa = $query->first();

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
                'u.nama_unit' // tambahkan ini
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

    public function store(Request $request)
    {
        $user = Auth::user();

        DB::table('tbl_hasil_analisa')->updateOrInsert(
            [
                'indikator_id' => $request->indikator_id,
                'unit_id' => $user->unit_id,
            ],
            [
                'tanggal_analisa' => now()->toDateString(),
                'analisa' => $request->analisa,
                'tindak_lanjut' => $request->tindak_lanjut,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return response()->json([
            'success' => true
        ]);
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
            $index = $row->bulan - 1;
            $realisasi[$index] = $row->nilai;
        }

        return response()->json([
            'target' => $target,
            'realisasi' => $realisasi
        ]);
    }

}
