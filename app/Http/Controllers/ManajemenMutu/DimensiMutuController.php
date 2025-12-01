<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_dimensi_mutu;
use Illuminate\Http\Request;

class DimensiMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dimensimutu = tbl_dimensi_mutu::all();
        return view('ManajemenMutu.dimensi-mutu.index', compact('dimensimutu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ManajemenMutu.dimensi-mutu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dimensi_mutu' => 'required|string|max:255',
        ]);

        tbl_dimensi_mutu::create([
            'nama_dimensi_mutu' => $request->nama_dimensi_mutu,
        ]);

        return redirect()->route('dimensi-mutu.index')
            ->with('success', 'Dimensi Mutu berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dimensimutu = tbl_dimensi_mutu::findOrFail($id);
        return view('ManajemenMutu.dimensi-mutu.edit', compact('dimensimutu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_dimensi_mutu' => 'required|string|max:255',
        ]);

        $dimensimutu = tbl_dimensi_mutu::findOrFail($id);
        $dimensimutu->update([
            'nama_dimensi_mutu' => $request->nama_dimensi_mutu,
        ]);

        return redirect()->route('dimensi-mutu.index')
            ->with('success', 'Dimensi Mutu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dimensimutu = tbl_dimensi_mutu::findOrFail($id);
        $dimensimutu->delete();

        return redirect()->route('dimensi-mutu.index')
            ->with('success', 'Dimensi Mutu berhasil dihapus!');
    }
}
