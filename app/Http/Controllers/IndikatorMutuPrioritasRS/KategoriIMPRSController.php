<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use App\Models\tbl_kategori_imprs;
use Illuminate\Http\Request;

class KategoriIMPRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriimprs = tbl_kategori_imprs::all();
        return view('menu.IndikatorMutuPrioritasRS.kategori-imprs.index', compact('kategoriimprs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.IndikatorMutuPrioritasRS.kategori-imprs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_imprs' => 'required|string|max:255',
        ]);

        tbl_kategori_imprs::create([
            'nama_kategori_imprs' => $request->nama_kategori_imprs,
        ]);

        return redirect()->route('kategori-imprs.index')
            ->with('success', 'Kategori IMPRS berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriimprs = tbl_kategori_imprs::findOrFail($id);
        return view('menu.IndikatorMutuPrioritasRS.kategori-imprs.edit', compact('kategoriimprs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori_imprs' => 'required|string|max:255',
        ]);

        $kategoriimprs = tbl_kategori_imprs::findOrFail($id);
        $kategoriimprs->update([
            'nama_kategori_imprs' => $request->nama_kategori_imprs,
        ]);

        return redirect()->route('kategori-imprs.index')
            ->with('success', 'Kategori IMPRS berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategoriimprs = tbl_kategori_imprs::findOrFail($id);
        $kategoriimprs->delete();

        return redirect()->route('kategori-imprs.index')
            ->with('success', 'Kategori IMPRS berhasil dihapus!');
    }
}
