<?php

namespace App\Http\Controllers;

use App\Models\tbl_periode;
use DB;
use Illuminate\Http\Request;
use Validator;

class PeriodeController extends Controller
{
    /**
     * Tampilkan daftar periode mutu
     */
    public function index()
    {
        $periodes = DB::table('tbl_periode')
            ->orderBy('tahun', 'asc')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('menu.PeriodeMutu.index', compact('periodes'));
    }

    /**
     * Form tambah periode
     */
    public function create()
    {
        return view('menu.PeriodeMutu.create');
    }

    /**
     * Simpan periode baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:100',
            'tahun' => 'required|integer|min:2000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        DB::beginTransaction();

        try {
            // Jika status aktif → nonaktifkan semua periode lain
            if ($request->status === 'aktif') {
                DB::table('tbl_periode')
                    ->where('status', 'aktif')
                    ->update(['status' => 'non-aktif']);
            }

            DB::table('tbl_periode')->insert([
                'nama_periode' => $request->nama_periode,
                'tahun' => $request->tahun,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('periode-mutu.index')
                ->with('success', 'Periode mutu berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menyimpan data');
        }
    }

    /**
     * Aktifkan periode (jadikan global aktif)
     */
    public function setAktif($id)
    {
        DB::beginTransaction();

        try {
            DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->update(['status' => 'non-aktif']);

            DB::table('tbl_periode')
                ->where('id', $id)
                ->update([
                    'status' => 'aktif',
                    'updated_at' => now()
                ]);

            DB::commit();

            return back()->with('success', 'Periode berhasil diaktifkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengaktifkan periode');
        }
    }

    public function edit($id)
    {
        $periode = tbl_periode::findOrFail($id);
        return view('menu.PeriodeMutu.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $periode = tbl_periode::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,non-aktif', // tambahkan validasi status
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data
        $periode->update([
            'nama_periode' => $request->nama_periode,
            'tahun' => $request->tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status, // simpan status
        ]);

        return redirect()->route('periode-mutu.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = tbl_periode::findOrFail($id);
        $periode->delete();

        return redirect()->route('periode-mutu.index')->with('success', 'Periode berhasil dihapus.');
    }
}
