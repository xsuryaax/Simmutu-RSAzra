<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_metode_pengumpulan_data;
use Illuminate\Http\Request;

class MetodePengumpulanDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodePengumpulanData = tbl_metode_pengumpulan_data::all();
        return view('menu.ManajemenMutu.metode-pengumpulan-data.index', compact('metodePengumpulanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.metode-pengumpulan-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_metode_pengumpulan_data' => 'required|string|max:255',
        ]);

        tbl_metode_pengumpulan_data::create([
            'nama_metode_pengumpulan_data' => $request->nama_metode_pengumpulan_data,
        ]);

        return redirect()->route('metode-pengumpulan-data.index')
            ->with('success', 'metode Pengumpulan Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metodePengumpulanData = tbl_metode_pengumpulan_data::findOrFail($id);
        return view('menu.ManajemenMutu.metode-pengumpulan-data.edit', compact('metodePengumpulanData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_metode_pengumpulan_data' => 'required|string|max:255',
        ]);

        $metodePengumpulanData = tbl_metode_pengumpulan_data::findOrFail($id);
        $metodePengumpulanData->update([
            'nama_metode_pengumpulan_data' => $request->nama_metode_pengumpulan_data,
        ]);

        return redirect()->route('metode-pengumpulan-data.index')
            ->with('success', 'metode Pengumpulan Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metodePengumpulanData = tbl_metode_pengumpulan_data::findOrFail($id);
        $metodePengumpulanData->delete();

        return redirect()->route('metode-pengumpulan-data.index')
            ->with('success', 'metode Pengumpulan Data berhasil dihapus!');
    }
}
