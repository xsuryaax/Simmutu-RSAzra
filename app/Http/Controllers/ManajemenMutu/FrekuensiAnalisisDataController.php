<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_frekuensi_analisis_data;
use Illuminate\Http\Request;

class FrekuensiAnalisisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frekuensiAnalisisData = tbl_frekuensi_analisis_data::all();
        return view('ManajemenMutu.frekuensi-analisis-data.index', compact('frekuensiAnalisisData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ManajemenMutu.frekuensi-analisis-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_frekuensi_analisis_data' => 'required|string|max:255',
        ]);

        tbl_frekuensi_analisis_data::create([
            'nama_frekuensi_analisis_data' => $request->nama_frekuensi_analisis_data,
        ]);

        return redirect()->route('frekuensi-analisis-data.index')
            ->with('success', 'Frekuensi Analisis Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $frekuensiAnalisisData = tbl_frekuensi_analisis_data::findOrFail($id);
        return view('ManajemenMutu.frekuensi-analisis-data.edit', compact('frekuensiAnalisisData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_frekuensi_analisis_data' => 'required|string|max:255',
        ]);

        $frekuensiAnalisisData = tbl_frekuensi_analisis_data::findOrFail($id);
        $frekuensiAnalisisData->update([
            'nama_frekuensi_analisis_data' => $request->nama_frekuensi_analisis_data,
        ]);

        return redirect()->route('frekuensi-analisis-data.index')
            ->with('success', 'Frekuensi Analisis Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $frekuensiAnalisisData = tbl_frekuensi_analisis_data::findOrFail($id);
        $frekuensiAnalisisData->delete();

        return redirect()->route('frekuensi-analisis-data.index')
            ->with('success', 'Frekuensi Analisis Data berhasil dihapus!');
    }
}
