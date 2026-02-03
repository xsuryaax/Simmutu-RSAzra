<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_penyajian_data;
use Illuminate\Http\Request;

class PenyajianDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyajianData = tbl_penyajian_data::all(); // Ganti dengan logika pengambilan data yang sesuai
        return view('menu.ManajemenMutu.penyajian-data.index', compact('penyajianData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.penyajian-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penyajian_data' => 'required|string|max:255',
        ]);

        tbl_penyajian_data::create([
            'nama_penyajian_data' => $request->nama_penyajian_data,
        ]);

        return redirect()->route('penyajian-data.index')
            ->with('success', 'Penyajian Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penyajianData = tbl_penyajian_data::findOrFail($id);
        return view('menu.ManajemenMutu.penyajian-data.edit', compact('penyajianData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_penyajian_data' => 'required|string|max:255',
        ]);

        $penyajianData = tbl_penyajian_data::findOrFail($id);
        $penyajianData->update([
            'nama_penyajian_data' => $request->nama_penyajian_data,
        ]);

        return redirect()->route('penyajian-data.index')
            ->with('success', 'Penyajian Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penyajianData = tbl_penyajian_data::findOrFail($id);
        $penyajianData->delete();

        return redirect()->route('penyajian-data.index')
            ->with('success', 'Metodologi Analisis Data berhasil dihapus!');
    }
}
