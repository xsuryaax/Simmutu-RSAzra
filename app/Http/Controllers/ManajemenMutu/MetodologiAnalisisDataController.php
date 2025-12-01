<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_metodologi_analisis_data;
use Illuminate\Http\Request;

class MetodologiAnalisisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodologiAnalisisData = tbl_metodologi_analisis_data::all(); // Ganti dengan logika pengambilan data yang sesuai
        return view('ManajemenMutu.metodologi-analisis-data.index', compact('metodologiAnalisisData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ManajemenMutu.metodologi-analisis-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_metodologi_analisis_data' => 'required|string|max:255',
        ]);

        tbl_metodologi_analisis_data::create([
            'nama_metodologi_analisis_data' => $request->nama_metodologi_analisis_data,
        ]);

        return redirect()->route('metodologi-analisis-data.index')
            ->with('success', 'Metodologi Analisis Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metodologiAnalisisData = tbl_metodologi_analisis_data::findOrFail($id);
        return view('ManajemenMutu.metodologi-analisis-data.edit', compact('metodologiAnalisisData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_metodologi_analisis_data' => 'required|string|max:255',
        ]);

        $metodologiAnalisisData = tbl_metodologi_analisis_data::findOrFail($id);
        $metodologiAnalisisData->update([
            'nama_metodologi_analisis_data' => $request->nama_metodologi_analisis_data,
        ]);

        return redirect()->route('metodologi-analisis-data.index')
            ->with('success', 'Metodologi Analisis Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metodologiAnalisisData = tbl_metodologi_analisis_data::findOrFail($id);
        $metodologiAnalisisData->delete();

        return redirect()->route('metodologi-analisis-data.index')
            ->with('success', 'Metodologi Analisis Data berhasil dihapus!');
    }
}
