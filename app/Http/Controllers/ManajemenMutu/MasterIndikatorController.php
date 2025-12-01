<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MasterIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indikators = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_indikator.*',
                'tbl_unit.nama_unit'
            )
            ->orderBy('tbl_indikator.created_at', 'DESC')
            ->get();

        return view('ManajemenMutu.master-indikator.index', compact('indikators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = DB::table('tbl_unit')
            ->orderBy('nama_unit', 'ASC')
            ->get();

        return view('ManajemenMutu.master-indikator.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_indikator' => 'required',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_indikator' => 'required|numeric',
            'tipe_indikator' => 'required|in:lokal, nasional',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator')->insert([
            'nama_indikator' => $request->nama_indikator,
            'unit_id' => $request->unit_id,
            'target_indikator' => $request->target_indikator,
            'tipe_indikator' => $request->tipe_indikator,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
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
        $indikator = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select('tbl_indikator.*', 'tbl_unit.nama_unit')
            ->where('tbl_indikator.id', $id)
            ->first();

        $units = DB::table('tbl_unit')->get();

        return view('ManajemenMutu.master-indikator.edit', compact('indikator', 'units'));
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
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator')->where('id', $id)->update([
            'nama_indikator' => $request->nama_indikator,
            'unit_id' => $request->unit_id,
            'target_indikator' => $request->target_indikator,
            'tipe_indikator' => $request->tipe_indikator,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
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
