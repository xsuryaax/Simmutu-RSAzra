<?php

namespace App\Http\Controllers;

use App\Models\tbl_unit;
use Illuminate\Http\Request;

class ManajemenUnitController extends Controller
{
    // Display list of units
    public function index()
    {
        $units = tbl_unit::orderBy('id', 'ASC')->get();
        $title = "Data Unit";

        $totalUnit = tbl_unit::count();
        $unitAktif = tbl_unit::where('status_unit', 'aktif')->count();
        $unitNonAktif = tbl_unit::where('status_unit', 'non-aktif')->count();

        $last = tbl_unit::orderBy('id', 'DESC')->first();
        $num = $last ? (int) substr($last->kode_unit, 4) + 1 : 1;
        $kode = 'UNIT' . str_pad($num, 3, '0', STR_PAD_LEFT);

        return view('menu.ManajemenUnit.index', compact(
            'units',
            'totalUnit',
            'unitAktif',
            'unitNonAktif',
            'kode'
        ));
    }

    // Store new unit
    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required',
            'deskripsi_unit' => 'nullable',
            'status_unit' => 'nullable',
        ]);

        $status = $request->status_unit ? 'aktif' : 'non-aktif';

        $last = tbl_unit::orderBy('id', 'DESC')->first();
        $num = $last ? (int) substr($last->kode_unit, 4) + 1 : 1;
        $kode = 'UNIT' . str_pad($num, 3, '0', STR_PAD_LEFT);

        tbl_unit::create([
            'kode_unit' => $kode,
            'nama_unit' => $request->nama_unit,
            'deskripsi_unit' => $request->deskripsi_unit,
            'status_unit' => $status,
        ]);

        return redirect()->route('manajemen-unit.index')
            ->with('success', 'Unit berhasil ditambahkan.');
    }

    // Edit unit
    public function edit($id)
    {
        $unit = tbl_unit::findOrFail($id);

        return view('menu.ManajemenUnit.edit', compact('unit'));
    }

    // Update unit
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unit' => 'required',
            'deskripsi_unit' => 'nullable',
            'status_unit' => 'required|in:aktif,non-aktif',
        ]);

        $unit = tbl_unit::findOrFail($id);

        $unit->update([
            'nama_unit' => $request->nama_unit,
            'deskripsi_unit' => $request->deskripsi_unit,
            'status_unit' => $request->status_unit,
        ]);

        return redirect()->route('manajemen-unit.index')
            ->with('success', 'Unit berhasil diperbarui.');
    }

    // Delete unit
    public function destroy($id)
    {
        $unit = tbl_unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('manajemen-unit.index')
            ->with('success', 'Unit berhasil dihapus.');
    }
}
