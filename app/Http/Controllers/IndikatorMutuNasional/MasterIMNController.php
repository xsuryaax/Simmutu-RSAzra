<?php

namespace App\Http\Controllers\IndikatorMutuNasional;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MasterIMNController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indikators = DB::table('tbl_indikator_nasional')
            ->orderBy('created_at', 'ASC')
            ->get();

        return view(
            'menu.IndikatorMutuNasional.master-imn.index',
            compact('indikators')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.IndikatorMutuNasional.master-imn.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_indikator_nasional' => 'required|string',
            'target_indikator_nasional' => 'required|numeric',
            'periode_tahun' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator_nasional' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator_nasional')->insert([
            'nama_indikator_nasional' => $request->nama_indikator_nasional,
            'target_indikator_nasional' => $request->target_indikator_nasional,
            'periode_tahun' => $request->periode_tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
            'status_indikator_nasional' => $request->status_indikator_nasional,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('master-imn.index')
            ->with('success', 'Indikator nasional berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $indikator = DB::table('tbl_indikator_nasional')
            ->where('id', $id)
            ->first();

        return view(
            'menu.IndikatorMutuNasional.master-imn.edit',
            compact('indikator')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_indikator_nasional' => 'required|string',
            'target_indikator_nasional' => 'required|numeric',
            'periode_tahun' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_indikator_nasional' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_indikator_nasional')
            ->where('id', $id)
            ->update([
                'nama_indikator_nasional' => $request->nama_indikator_nasional,
                'target_indikator_nasional' => $request->target_indikator_nasional,
                'periode_tahun' => $request->periode_tahun,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status_periode' => $request->status_periode,
                'status_indikator_nasional' => $request->status_indikator_nasional,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('master-imn.index')
            ->with('success', 'Indikator nasional berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('tbl_indikator_nasional')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('master-imn.index')
            ->with('success', 'Indikator nasional berhasil dihapus.');
    }
}
