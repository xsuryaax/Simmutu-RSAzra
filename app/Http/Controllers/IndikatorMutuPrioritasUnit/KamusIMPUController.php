<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasUnit;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class KamusIMPUController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // ambil user login

        $query = DB::table('tbl_kamus_indikator_mutu_unit')
            ->leftJoin('tbl_indikator_unit', 'tbl_kamus_indikator_mutu_unit.indikator_unit_id', '=', 'tbl_indikator_unit.id')
            ->leftJoin('tbl_dimensi_mutu', 'tbl_kamus_indikator_mutu_unit.dimensi_mutu_id', '=', 'tbl_dimensi_mutu.id')
            ->leftJoin('tbl_metodologi_pengumpulan_data', 'tbl_kamus_indikator_mutu_unit.metodologi_pengumpulan_data_id', '=', 'tbl_metodologi_pengumpulan_data.id')
            ->leftJoin('tbl_cakupan_data', 'tbl_kamus_indikator_mutu_unit.cakupan_data_id', '=', 'tbl_cakupan_data.id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_kamus_indikator_mutu_unit.frekuensi_pengumpulan_data_id', '=', 'tbl_frekuensi_pengumpulan_data.id')
            ->leftJoin('tbl_frekuensi_analisis_data', 'tbl_kamus_indikator_mutu_unit.frekuensi_analisis_data_id', '=', 'tbl_frekuensi_analisis_data.id')
            ->leftJoin('tbl_metodologi_analisis_data', 'tbl_kamus_indikator_mutu_unit.metodologi_analisis_data_id', '=', 'tbl_metodologi_analisis_data.id')
            ->leftJoin('tbl_interpretasi_data', 'tbl_kamus_indikator_mutu_unit.interpretasi_data_id', '=', 'tbl_interpretasi_data.id')
            ->leftJoin('tbl_publikasi_data', 'tbl_kamus_indikator_mutu_unit.publikasi_data_id', '=', 'tbl_publikasi_data.id')
            ->select(
                'tbl_kamus_indikator_mutu_unit.*',
                'tbl_indikator_unit.nama_indikator_unit',
                'tbl_indikator_unit.unit_id',
                'tbl_dimensi_mutu.nama_dimensi_mutu',
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data'
            )
            ->orderBy('tbl_kamus_indikator_mutu_unit.id', 'asc');

        // Filter sesuai unit jika bukan admin/unit_mutu
        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_indikator_unit.unit_id', $user->unit_id);
        }

        $mutu = $query->get();

        return view('menu.IndikatorMutuPrioritasUnit.kamus-impu.index', compact('mutu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show form create
     */
    public function create()
    {
        $user = Auth::user();

        // Query indikator
        $queryIndikator = DB::table('tbl_indikator_unit');

        // Jika bukan admin / mutu, batasi unit sendiri
        if (!in_array($user->unit_id, [1, 2])) {
            $queryIndikator->where('unit_id', $user->unit_id);
        }

        $indikator = $queryIndikator->get();

        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();

        return view('menu.IndikatorMutuPrioritasUnit.kamus-impu.create', compact(
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

            'indikator_unit_id' => 'required',
            'dimensi_mutu_id' => 'required',
            'metodologi_pengumpulan_data_id' => 'required',
            'cakupan_data_id' => 'required',
            'frekuensi_pengumpulan_data_id' => 'required',
            'frekuensi_analisis_data_id' => 'required',
            'metodologi_analisis_data_id' => 'required',
            'interpretasi_data_id' => 'required',
            'publikasi_data_id' => 'required',
        ]);

        // 1️⃣ Insert & dapatkan ID kamus
        $kamusId = DB::table('tbl_kamus_indikator_mutu_unit')->insertGetId([
            'definisi_operasional' => $request->definisi_operasional,
            'tujuan' => $request->tujuan,
            'dasar_pemikiran' => $request->dasar_pemikiran,
            'formula_pengukuran' => $request->formula_pengukuran,
            'metodologi' => $request->metodologi,
            'detail_pengukuran' => $request->detail_pengukuran,
            'sumber_data' => $request->sumber_data,
            'penanggung_jawab' => $request->penanggung_jawab,

            'indikator_unit_id' => $request->indikator_unit_id,
            'dimensi_mutu_id' => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id' => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,
            'metodologi_analisis_data_id' => $request->metodologi_analisis_data_id,

            'interpretasi_data_id' => $request->interpretasi_data_id,
            'publikasi_data_id' => $request->publikasi_data_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Update tabel indikator -> isi kamus_indikator_unit_id
        DB::table('tbl_indikator_unit')
            ->where('id', $request->indikator_id)
            ->update([
                'kamus_indikator_unit_id' => $kamusId,
            ]);

        return redirect()->route('kamus-impu.index')
            ->with('success', 'Kamus Indikator Mutu berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('tbl_kamus_indikator_mutu_unit')->where('id', $id)->first();

        $indikator = DB::table('tbl_indikator_unit')->get();
        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();

        return view('menu.IndikatorMutuPrioritasUnit.kamus-impu.edit', compact(
            'data',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('tbl_kamus_indikator_mutu_unit')->where('id', $id)->update([
            'indikator_unit_id' => $request->indikator_unit_id,
            'dimensi_mutu_id' => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id' => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,
            'metodologi_analisis_data_id' => $request->metodologi_analisis_data_id,
            'interpretasi_data_id' => $request->interpretasi_data_id,
            'publikasi_data_id' => $request->publikasi_data_id,
        ]);

        return redirect()->route('kamus-impu.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_kamus_indikator_mutu_unit')->where('id', $id)->delete();

        return redirect()->route('kamus-impu.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
