<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_metodologi_pengumpulan_data;
use Illuminate\Http\Request;

class MetodologiPengumpulanDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodologiPengumpulanData = tbl_metodologi_pengumpulan_data::all();
        return view('ManajemenMutu.metodologi-pengumpulan-data.index', compact('metodologiPengumpulanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ManajemenMutu.metodologi-pengumpulan-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_metodologi_pengumpulan_data' => 'required|string|max:255',
        ]);

        tbl_metodologi_pengumpulan_data::create([
            'nama_metodologi_pengumpulan_data' => $request->nama_metodologi_pengumpulan_data,
        ]);

        return redirect()->route('metodologi-pengumpulan-data.index')
            ->with('success', 'Metodologi Pengumpulan Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metodologiPengumpulanData = tbl_metodologi_pengumpulan_data::findOrFail($id);
        return view('ManajemenMutu.metodologi-pengumpulan-data.edit', compact('metodologiPengumpulanData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_metodologi_pengumpulan_data' => 'required|string|max:255',
        ]);

        $metodologiPengumpulanData = tbl_metodologi_pengumpulan_data::findOrFail($id);
        $metodologiPengumpulanData->update([
            'nama_metodologi_pengumpulan_data' => $request->nama_metodologi_pengumpulan_data,
        ]);

        return redirect()->route('metodologi-pengumpulan-data.index')
            ->with('success', 'Metodologi Pengumpulan Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metodologiPengumpulanData = tbl_metodologi_pengumpulan_data::findOrFail($id);
        $metodologiPengumpulanData->delete();

        return redirect()->route('metodologi-pengumpulan-data.index')
            ->with('success', 'Metodologi Pengumpulan Data berhasil dihapus!');
    }
}
