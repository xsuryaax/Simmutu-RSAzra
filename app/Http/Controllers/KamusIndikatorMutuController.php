<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;

class KamusIndikatorMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutu = DB::table('tbl_kamus_indikator_mutu')
            ->leftJoin('tbl_indikator', 'tbl_kamus_indikator_mutu.indikator_id', '=', 'tbl_indikator.id')
            ->leftJoin('tbl_dimensi_mutu', 'tbl_kamus_indikator_mutu.dimensi_mutu_id', '=', 'tbl_dimensi_mutu.id')
            ->leftJoin('tbl_metodologi_pengumpulan_data', 'tbl_kamus_indikator_mutu.metodologi_pengumpulan_data_id', '=', 'tbl_metodologi_pengumpulan_data.id')
            ->leftJoin('tbl_cakupan_data', 'tbl_kamus_indikator_mutu.cakupan_data_id', '=', 'tbl_cakupan_data.id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_kamus_indikator_mutu.frekuensi_pengumpulan_data_id', '=', 'tbl_frekuensi_pengumpulan_data.id')
            ->leftJoin('tbl_frekuensi_analisis_data', 'tbl_kamus_indikator_mutu.frekuensi_analisis_data_id', '=', 'tbl_frekuensi_analisis_data.id')
            ->leftJoin('tbl_metodologi_analisis_data', 'tbl_kamus_indikator_mutu.metodologi_analisis_data_id', '=', 'tbl_metodologi_analisis_data.id')
            ->leftJoin('tbl_interpretasi_data', 'tbl_kamus_indikator_mutu.interpretasi_data_id', '=', 'tbl_interpretasi_data.id')
            ->leftJoin('tbl_publikasi_data', 'tbl_kamus_indikator_mutu.publikasi_data_id', '=', 'tbl_publikasi_data.id')
            ->select(
                'tbl_kamus_indikator_mutu.*',
                'tbl_indikator.nama_indikator',
                'tbl_dimensi_mutu.nama_dimensi_mutu',
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data'
            )
            ->orderBy('tbl_kamus_indikator_mutu.id', 'asc')
            ->get();

        return view('menu.KamusIndikatorMutu.index', compact('mutu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show form create
     */
    public function create()
    {
        // Semua data dropdown
        $indikator = DB::table('tbl_indikator')->get();
        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();

        return view('KamusIndikatorMutu.create', compact(
            'indikator',
            'dimensi',
            'metodologiPengumpulan',
            'cakupan',
            'frekuensiPengumpulan',
            'frekuensiAnalisis',
            'metodologiAnalisis',
            'interpretasi',
            'publikasi'
        ));
    }

    /**
     * Store Kamus Indikator Mutu
     */
    public function store(Request $request)
    {
        $request->validate([
            'definisi_operasional' => 'required',
            'tujuan' => 'required',
            'dasar_pemikiran' => 'required',
            'formula_pengukuran' => 'required',
            'metodologi' => 'required',
            'detail_pengukuran' => 'required',
            'sumber_data' => 'required',
            'penanggung_jawab' => 'required',

            'indikator_id' => 'required',
            'dimensi_mutu_id' => 'required',
            'metodologi_pengumpulan_data_id' => 'required',
            'cakupan_data_id' => 'required',
            'frekuensi_pengumpulan_data_id' => 'required',
            'frekuensi_analisis_data_id' => 'required',
            'metodologi_analisis_data_id' => 'required',
            'interpretasi_data_id' => 'required',
            'publikasi_data_id' => 'required',
        ]);

        DB::table('tbl_kamus_indikator_mutu')->insert([
            'definisi_operasional' => $request->definisi_operasional,
            'tujuan' => $request->tujuan,
            'dasar_pemikiran' => $request->dasar_pemikiran,
            'formula_pengukuran' => $request->formula_pengukuran,
            'metodologi' => $request->metodologi,
            'detail_pengukuran' => $request->detail_pengukuran,
            'sumber_data' => $request->sumber_data,
            'penanggung_jawab' => $request->penanggung_jawab,

            'indikator_id' => $request->indikator_id,
            'dimensi_mutu_id' => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id' => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,

            // FIX: sebelumnya salah → metode_analisis_data_id
            'metodologi_analisis_data_id' => $request->metodologi_analisis_data_id,

            'interpretasi_data_id' => $request->interpretasi_data_id,
            'publikasi_data_id' => $request->publikasi_data_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('kamus-indikator-mutu.index')
            ->with('success', 'Kamus Indikator Mutu berhasil ditambahkan.');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('tbl_kamus_indikator_mutu')->where('id', $id)->first();

        $indikator = DB::table('tbl_indikator')->get();
        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $metodologi = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodeAnalisis = DB::table('tbl_metode_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();

        return view('menu.KamusIndikatorMutu.edit', compact(
            'data',
            'indikator',
            'dimensi',
            'metodologi',
            'cakupan',
            'frekuensiPengumpulan',
            'frekuensiAnalisis',
            'metodeAnalisis',
            'interpretasi',
            'publikasi'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('tbl_kamus_indikator_mutu')->where('id', $id)->update([
            'indikator_id' => $request->indikator_id,
            'dimensi_mutu_id' => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id' => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,
            'metode_analisis_data_id' => $request->metode_analisis_data_id,
            'interpretasi_data_id' => $request->interpretasi_data_id,
            'publikasi_data_id' => $request->publikasi_data_id,
        ]);

        return redirect()->route('kamus-indikator-mutu.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_kamus_indikator_mutu')->where('id', $id)->delete();

        return redirect()->route('kamus-indikator-mutu.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
