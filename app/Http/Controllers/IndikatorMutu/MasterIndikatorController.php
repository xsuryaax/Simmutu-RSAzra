<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class MasterIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select('tbl_indikator.*', 'tbl_unit.nama_unit')
            ->orderBy('tbl_indikator.created_at', 'DESC');

        // 🔐 User biasa → hanya lihat unit sendiri
        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_indikator.unit_id', $user->unit_id);
        }

        // 🔥 FILTER UNIT (khusus admin/mutu)
        if (
            in_array($user->unit_id, [1, 2]) &&
            $request->filled('unit_id')
        ) {
            $query->where('tbl_indikator.unit_id', $request->unit_id);
        }

        $indikators = $query->get();

        // 🔽 Data unit untuk dropdown filter
        $units = DB::table('tbl_unit')
            ->orderBy('nama_unit', 'ASC')
            ->get();

        return view(
            'menu.IndikatorMutu.master-indikator.index',
            compact('indikators', 'units')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // default
        $units = null;
        $unitUser = null;

        if (in_array($user->unit_id, [1, 2])) {
            // ADMIN / MUTU → ambil semua unit
            $units = DB::table('tbl_unit')
                ->orderBy('nama_unit', 'ASC')
                ->get();
        } else {
            // USER BIASA → ambil unit dia sendiri
            $unitUser = DB::table('tbl_unit')
                ->where('id', $user->unit_id)
                ->first();
        }

        return view(
            'menu.IndikatorMutu.master-indikator.create',
            compact('units', 'unitUser')
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            $request->merge([
                'unit_id' => auth()->user()->unit_id
            ]);
        }

        $request->validate([
            'nama_indikator' => 'required',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_indikator' => 'required|numeric',
            'tipe_indikator' => 'required|in:lokal,nasional',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator')->insert([
            'nama_indikator' => $request->nama_indikator,
            'unit_id' => $request->unit_id,
            'target_indikator' => $request->target_indikator,
            'tipe_indikator' => $request->tipe_indikator,
            'status_indikator' => $request->status_indikator,
            'created_at' => now(),
        ]);

        return redirect()->route('master-indikator.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $indikator = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select('tbl_indikator.*', 'tbl_unit.nama_unit')
            ->where('tbl_indikator.id', $id)
            ->first();

        $queryUnits = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC');

        // Admin (1) atau Unit Mutu (2) boleh lihat semua
        if (!in_array($user->unit_id, [1, 2])) {
            $queryUnits->where('id', $user->unit_id);
        }
        $units = $queryUnits->get();

        return view('menu.IndikatorMutu.master-indikator.edit', compact('indikator', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_indikator' => 'required',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_indikator' => 'required|numeric',
            'tipe_indikator' => 'required|in:lokal,nasional',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator')->where('id', $id)->update([
            'nama_indikator' => $request->nama_indikator,
            'unit_id' => $request->unit_id,
            'target_indikator' => $request->target_indikator,
            'tipe_indikator' => $request->tipe_indikator,
            'status_indikator' => $request->status_indikator,
            'updated_at' => now(),
        ]);

        return redirect()->route('master-indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_indikator')->where('id', $id)->delete();

        return redirect()->route('master-indikator.index')
            ->with('success', 'Indikator berhasil dihapus.');
    }
}
