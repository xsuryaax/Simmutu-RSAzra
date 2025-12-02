<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_publikasi_data;
use Illuminate\Http\Request;

class PublikasiDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publikasiData = tbl_publikasi_data::all();
        return view('menu.ManajemenMutu.publikasi-data.index', compact('publikasiData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.publikasi-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_publikasi_data' => 'required|string|max:255',
        ]);

        tbl_publikasi_data::create([
            'nama_publikasi_data' => $request->nama_publikasi_data,
        ]);

        return redirect()->route('publikasi-data.index')
            ->with('success', 'Publikasi Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $publikasiData = tbl_publikasi_data::findOrFail($id);
        return view('menu.ManajemenMutu.publikasi-data.edit', compact('publikasiData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_publikasi_data' => 'required|string|max:255',
        ]);

        $publikasiData = tbl_publikasi_data::findOrFail($id);
        $publikasiData->update([
            'nama_publikasi_data' => $request->nama_publikasi_data,
        ]);

        return redirect()->route('publikasi-data.index')
            ->with('success', 'Publikasi Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publikasiData = tbl_publikasi_data::findOrFail($id);
        $publikasiData->delete();

        return redirect()->route('publikasi-data.index')
            ->with('success', 'Publikasi Data berhasil dihapus!');
    }
}
