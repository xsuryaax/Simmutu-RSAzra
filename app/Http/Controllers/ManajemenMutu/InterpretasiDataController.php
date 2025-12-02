<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_interpretasi_data;
use Illuminate\Http\Request;

class InterpretasiDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interpretasiData = tbl_interpretasi_data::all();
        return view('menu.ManajemenMutu.interpretasi-data.index', compact('interpretasiData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $interpretasiData = tbl_interpretasi_data::all();
        return view('menu.ManajemenMutu.interpretasi-data.create', compact('interpretasiData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_interpretasi_data' => 'required|string|max:255',
        ]);

        tbl_interpretasi_data::create([
            'nama_interpretasi_data' => $request->nama_interpretasi_data,
        ]);

        return redirect()->route('interpretasi-data.index')
            ->with('success', 'Interpretasi Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $interpretasiData = tbl_interpretasi_data::findOrFail($id);
        return view('menu.ManajemenMutu.interpretasi-data.edit', compact('interpretasiData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_interpretasi_data' => 'required|string|max:255',
        ]);

        $interpretasiData = tbl_interpretasi_data::findOrFail($id);
        $interpretasiData->update([
            'nama_interpretasi_data' => $request->nama_interpretasi_data,
        ]);

        return redirect()->route('interpretasi-data.index')
            ->with('success', 'Interpretasi Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $interpretasiData = tbl_interpretasi_data::findOrFail($id);
        $interpretasiData->delete();

        return redirect()->route('interpretasi-data.index')
            ->with('success', 'Interpretasi Data berhasil dihapus!');
    }
}
