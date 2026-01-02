<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MasterIMPRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $indikators = DB::table('tbl_imprs')
            ->leftJoin('tbl_kategori_imprs', 'tbl_kategori_imprs.id', '=', 'tbl_imprs.kategori_id')
            ->select(
                'tbl_imprs.*',
                'tbl_kategori_imprs.nama_kategori_imprs'
            )
            ->when($user->kategori_id, function ($q) use ($user) {
                $q->where('tbl_imprs.kategori_id', $user->kategori_id);
            })
            ->orderBy('tbl_kategori_imprs.id')
            ->orderBy('tbl_imprs.created_at')
            ->get();

        return view(
            'menu.IndikatorMutuPrioritasRS.master-imprs.index',
            compact('indikators')
        );
    }


    public function create()
    {
        $user = Auth::user();

        // Ambil kategori
        $kategoris = DB::table('tbl_kategori_imprs')
            ->orderBy('nama_kategori_imprs', 'ASC')
            ->get();

        return view('menu.IndikatorMutuPrioritasRS.master-imprs.create', compact('kategoris'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_imprs' => 'required',
            'kategori_id' => 'required|exists:tbl_kategori_imprs,id',
            'target_imprs' => 'required|numeric',
            'tipe_imprs' => 'required|in:lokal,nasional',
            'periode_tahun' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_imprs' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_imprs')->insert([
            'nama_imprs' => $request->nama_imprs,
            'kategori_id' => $request->kategori_id,
            'target_imprs' => $request->target_imprs,
            'tipe_imprs' => $request->tipe_imprs,
            'periode_tahun' => $request->periode_tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
            'status_imprs' => $request->status_imprs,
            'created_at' => now(),
        ]);

        return redirect()->route('master-imprs.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data IMPRS
        $imprs = DB::table('tbl_imprs')
            ->where('id', $id)
            ->first();

        // Ambil semua kategori (untuk dropdown)
        $kategoris = DB::table('tbl_kategori_imprs')
            ->orderBy('nama_kategori_imprs', 'ASC')
            ->get();

        // Validasi jika data tidak ditemukan
        if (!$imprs) {
            abort(404, 'Data IMPRS tidak ditemukan');
        }

        return view(
            'menu.IndikatorMutuPrioritasRS.master-imprs.edit',
            compact('imprs', 'kategoris')
        );
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_imprs' => 'required',
            'kategori_id' => 'required|exists:tbl_kategori_imprs,id',
            'target_imprs' => 'required|numeric',
            'tipe_imprs' => 'required|in:lokal,nasional',
            'periode_tahun' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_periode' => 'required|in:aktif,non-aktif',
            'status_imprs' => 'required|in:aktif,non-aktif',
        ]);

        DB::table('tbl_imprs')->where('id', $id)->update([
            'nama_imprs' => $request->nama_imprs,
            'kategori_id' => $request->kategori_id,
            'target_imprs' => $request->target_imprs,
            'tipe_imprs' => $request->tipe_imprs,
            'periode_tahun' => $request->periode_tahun,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_periode' => $request->status_periode,
            'status_imprs' => $request->status_imprs,
            'updated_at' => now(),
        ]);

        return redirect()->route('master-imprs.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        DB::table('tbl_imprs')->where('id', $id)->delete();

        return redirect()->route('master-imprs.index')
            ->with('success', 'Indikator berhasil dihapus.');
    }
}
