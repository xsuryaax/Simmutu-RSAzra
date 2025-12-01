<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_frekuensi_pengumpulan_data;
use Illuminate\Http\Request;

class FrekuensiPengumpulanDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frekuensiPengumpulanData = tbl_frekuensi_pengumpulan_data::all();
        return view('ManajemenMutu.frekuensi-pengumpulan-data.index', compact('frekuensiPengumpulanData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ManajemenMutu.frekuensi-pengumpulan-data.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_frekuensi_pengumpulan_data' => 'required|string|max:255',
        ]);

        tbl_frekuensi_pengumpulan_data::create([
            'nama_frekuensi_pengumpulan_data' => $request->nama_frekuensi_pengumpulan_data,
        ]);

        return redirect()->route('frekuensi-pengumpulan-data.index')
            ->with('success', 'Frekuensi Pengumpulan Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $frekuensiPengumpulanData = tbl_frekuensi_pengumpulan_data::findOrFail($id);
        return view('ManajemenMutu.frekuensi-pengumpulan-data.edit', compact('frekuensiPengumpulanData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_frekuensi_pengumpulan_data' => 'required|string|max:255',
        ]);

        $frekuensiPengumpulanData = tbl_frekuensi_pengumpulan_data::findOrFail($id);
        $frekuensiPengumpulanData->update([
            'nama_frekuensi_pengumpulan_data' => $request->nama_frekuensi_pengumpulan_data,
        ]);

        return redirect()->route('frekuensi-pengumpulan-data.index')
            ->with('success', 'Frekuensi Pengumpulan Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $frekuensiPengumpulanData = tbl_frekuensi_pengumpulan_data::findOrFail($id);
        $frekuensiPengumpulanData->delete();

        return redirect()->route('frekuensi-pengumpulan-data.index')
            ->with('success', 'Frekuensi Pengumpulan Data berhasil dihapus!');
    }
}
