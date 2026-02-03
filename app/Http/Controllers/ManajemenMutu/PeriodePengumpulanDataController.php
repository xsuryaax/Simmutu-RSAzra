<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_periode_pengumpulan_data;
use Illuminate\Http\Request;

class PeriodePengumpulanDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodePengumpulanData = tbl_periode_pengumpulan_data::all();
        return view('menu.ManajemenMutu.periode-pengumpulan-data.index', compact('periodePengumpulanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.periode-pengumpulan-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode_pengumpulan_data' => 'required|string|max:255',
        ]);

        tbl_periode_pengumpulan_data::create([
            'nama_periode_pengumpulan_data' => $request->nama_periode_pengumpulan_data,
        ]);

        return redirect()->route('periode-pengumpulan-data.index')
            ->with('success', 'periode Pengumpulan Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $periodePengumpulanData = tbl_periode_pengumpulan_data::findOrFail($id);
        return view('menu.ManajemenMutu.periode-pengumpulan-data.edit', compact('periodePengumpulanData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_periode_pengumpulan_data' => 'required|string|max:255',
        ]);

        $periodePengumpulanData = tbl_periode_pengumpulan_data::findOrFail($id);
        $periodePengumpulanData->update([
            'nama_periode_pengumpulan_data' => $request->nama_periode_pengumpulan_data,
        ]);

        return redirect()->route('periode-pengumpulan-data.index')
            ->with('success', 'periode Pengumpulan Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periodePengumpulanData = tbl_periode_pengumpulan_data::findOrFail($id);
        $periodePengumpulanData->delete();

        return redirect()->route('periode-pengumpulan-data.index')
            ->with('success', 'periode Pengumpulan Data berhasil dihapus!');
    }
}
