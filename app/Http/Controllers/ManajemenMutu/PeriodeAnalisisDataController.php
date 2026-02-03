<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_periode_analisis_data;
use Illuminate\Http\Request;

class PeriodeAnalisisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodeAnalisisData = tbl_periode_analisis_data::all();
        return view('menu.ManajemenMutu.periode-analisis-data.index', compact('periodeAnalisisData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.periode-analisis-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode_analisis_data' => 'required|string|max:255',
        ]);

        tbl_periode_analisis_data::create([
            'nama_periode_analisis_data' => $request->nama_periode_analisis_data,
        ]);

        return redirect()->route('periode-analisis-data.index')
            ->with('success', 'Periode Analisis Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $periodeAnalisisData = tbl_periode_analisis_data::findOrFail($id);
        return view('menu.ManajemenMutu.periode-analisis-data.edit', compact('periodeAnalisisData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_periode_analisis_data' => 'required|string|max:255',
        ]);

        $periodeAnalisisData = tbl_periode_analisis_data::findOrFail($id);
        $periodeAnalisisData->update([
            'nama_periode_analisis_data' => $request->nama_periode_analisis_data,
        ]);

        return redirect()->route('periode-analisis-data.index')
            ->with('success', 'Periode Analisis Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periodeAnalisisData = tbl_periode_analisis_data::findOrFail($id);
        $periodeAnalisisData->delete();

        return redirect()->route('periode-analisis-data.index')
            ->with('success', 'Periode Analisis Data berhasil dihapus!');
    }
}
