<?php

namespace App\Http\Controllers\ManajemenMutu;

use App\Http\Controllers\Controller;
use App\Models\tbl_jenis_indikator;
use Illuminate\Http\Request;

class JenisIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisIndikator = tbl_jenis_indikator::all();
        return view('menu.ManajemenMutu.jenis-indikator.index', compact('jenisIndikator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ManajemenMutu.jenis-indikator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_indikator' => 'required|string|max:255',
        ]);

        tbl_jenis_indikator::create([
            'nama_jenis_indikator' => $request->nama_jenis_indikator,
        ]);

        return redirect()->route('jenis-indikator.index')
            ->with('success', 'Jenis Indikator berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jenisIndikator = tbl_jenis_indikator::findOrFail($id);
        return view('menu.ManajemenMutu.jenis-indikator.edit', compact('jenisIndikator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jenis_indikator' => 'required|string|max:255',
        ]);

        $jenisIndikator = tbl_jenis_indikator::findOrFail($id);
        $jenisIndikator->update([
            'nama_jenis_indikator' => $request->nama_jenis_indikator,
        ]);

        return redirect()->route('jenis-indikator.index')
            ->with('success', 'Jenis Indikator berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisIndikator = tbl_jenis_indikator::findOrFail($id);
        $jenisIndikator->delete();

        return redirect()->route('jenis-indikator.index')
            ->with('success', 'Jenis Indikator berhasil dihapus!');
    }
}
