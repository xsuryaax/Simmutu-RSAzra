<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_cakupan_data;
use Illuminate\Http\Request;
use App\Models\CakupanData;

class CakupanDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cakupanData = tbl_cakupan_data::all();
        return view('menu.ManajemenMutu.cakupan-data.index', compact('cakupanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.cakupan-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_cakupan_data' => 'required|string|max:255',
        ]);

        tbl_cakupan_data::create([
            'nama_cakupan_data' => $request->nama_cakupan_data,
        ]);

        return redirect()->route('cakupan-data.index')
            ->with('success', 'Cakupan Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cakupanData = tbl_cakupan_data::findOrFail($id);
        return view('menu.ManajemenMutu.cakupan-data.edit', compact('cakupanData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cakupan_data' => 'required|string|max:255',
        ]);

        $cakupanData = tbl_cakupan_data::findOrFail($id);
        $cakupanData->update([
            'nama_cakupan_data' => $request->nama_cakupan_data,
        ]);

        return redirect()->route('cakupan-data.index')
            ->with('success', 'Cakupan Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cakupanData = tbl_cakupan_data::findOrFail($id);
        $cakupanData->delete();

        return redirect()->route('cakupan-data.index')
            ->with('success', 'Cakupan Data berhasil dihapus!');
    }
}
