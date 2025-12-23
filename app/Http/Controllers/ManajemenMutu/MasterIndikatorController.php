<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class MasterIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // ambil user login

        $query = DB::table('tbl_indikator_unit')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator_unit.unit_id')
            ->select('tbl_indikator_unit.*', 'tbl_unit.nama_unit')
            ->orderBy('tbl_indikator_unit.created_at', 'DESC');

        // Filter hanya unit sendiri jika bukan admin atau unit_mutu
        // Admin/unit_mutu: unit_id 1 dan 2 (ubah sesuai database)
        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_indikator_unit.unit_id', $user->unit_id);
        }

        $indikators = $query->get(); // ✅ ambil list semua

        return view('menu.ManajemenMutu.master-indikator-unit.index', compact('indikators'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Ambil unit
        $queryUnits = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC');

        // Jika bukan admin/unit_mutu, batasi hanya unit user sendiri
        if (!in_array($user->unit_id, [1, 2])) {
            $queryUnits->where('id', $user->unit_id);
        }

        $units = $queryUnits->get();

        return view('menu.ManajemenMutu.master-indikator-unit.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_indikator_unit' => 'required',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_indikator_unit' => 'required|numeric',
            'tipe_indikator_unit' => 'required|in:lokal,nasional',
            'periode_tahun' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator_unit' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator_unit')->insert([
            'nama_indikator_unit' => $request->nama_indikator_unit,
            'unit_id' => $request->unit_id,
            'target_indikator_unit' => $request->target_indikator_unit,
            'tipe_indikator_unit' => $request->tipe_indikator_unit,
            'periode_tahun' => $request->periode_tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
            'status_indikator_unit' => $request->status_indikator_unit,
            'created_at' => now(),
        ]);

        return redirect()->route('master-indikator-unit.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $indikator = DB::table('tbl_indikator_unit')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator_unit.unit_id')
            ->select('tbl_indikator_unit.*', 'tbl_unit.nama_unit')
            ->where('tbl_indikator_unit.id', $id)
            ->first();

        // Ambil unit
        $queryUnits = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC');
        // Admin (1) atau Unit Mutu (2) boleh lihat semua
        if (!in_array($user->unit_id, [1, 2])) {
            $queryUnits->where('id', $user->unit_id);
        }
        $units = $queryUnits->get();

        return view('menu.ManajemenMutu.master-indikator-unit.edit', compact('indikator', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_indikator_unit' => 'required',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_indikator_unit' => 'required|numeric',
            'tipe_indikator_unit' => 'required|in:lokal,nasional',
            'periode_tahun' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator_unit' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator_unit')->where('id', $id)->update([
            'nama_indikator_unit' => $request->nama_indikator_unit,
            'unit_id' => $request->unit_id,
            'target_indikator_unit' => $request->target_indikator_unit,
            'tipe_indikator_unit' => $request->tipe_indikator_unit,
            'periode_tahun' => $request->periode_tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
            'status_indikator_unit' => $request->status_indikator_unit,
            'updated_at' => now(),
        ]);

        return redirect()->route('master-indikator-unit.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_indikator_unit')->where('id', $id)->delete();

        return redirect()->route('master-indikator-unit.index')
            ->with('success', 'Indikator berhasil dihapus.');
    }
}
