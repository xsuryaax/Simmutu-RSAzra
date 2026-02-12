<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;

class AnalisaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        $indikators = $this->getIndikators($user, $roleId);

        $data = [
            'roleId'     => $roleId,
            'indikators' => $indikators,
        ];

        return view('menu.IndikatorMutu.analisa-data.index', $data);
    }

    private function getIndikators($user, $roleId)
    {
        $query = DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator', 'tbl_kamus_indikator.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.unit_id'
            )
            ->where('tbl_kamus_indikator.kategori_indikator', 'LIKE', '%Prioritas Unit%')
            ->orderBy('tbl_indikator.nama_indikator');

        if (!in_array($roleId, [1, 2])) {
            $query->where('tbl_indikator.unit_id', $user->unit_id);
        }

        return $query->get();
    }
}
