<?php
namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class KamusIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $query = DB::table('tbl_kamus_indikator')
            ->leftJoin('tbl_indikator', 'tbl_kamus_indikator.indikator_id', '=', 'tbl_indikator.id')
            ->leftJoin('tbl_dimensi_mutu', 'tbl_kamus_indikator.dimensi_mutu_id', '=', 'tbl_dimensi_mutu.id')
            ->leftJoin('tbl_metodologi_pengumpulan_data', 'tbl_kamus_indikator.metodologi_pengumpulan_data_id', '=', 'tbl_metodologi_pengumpulan_data.id')
            ->leftJoin('tbl_cakupan_data', 'tbl_kamus_indikator.cakupan_data_id', '=', 'tbl_cakupan_data.id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_kamus_indikator.frekuensi_pengumpulan_data_id', '=', 'tbl_frekuensi_pengumpulan_data.id')
            ->leftJoin('tbl_frekuensi_analisis_data', 'tbl_kamus_indikator.frekuensi_analisis_data_id', '=', 'tbl_frekuensi_analisis_data.id')
            ->leftJoin('tbl_metodologi_analisis_data', 'tbl_kamus_indikator.metodologi_analisis_data_id', '=', 'tbl_metodologi_analisis_data.id')
            ->leftJoin('tbl_interpretasi_data', 'tbl_kamus_indikator.interpretasi_data_id', '=', 'tbl_interpretasi_data.id')
            ->leftJoin('tbl_publikasi_data', 'tbl_kamus_indikator.publikasi_data_id', '=', 'tbl_publikasi_data.id')
            ->select(
                'tbl_kamus_indikator.*',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                'tbl_dimensi_mutu.nama_dimensi_mutu',
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data'
            )
            ->orderBy('tbl_kamus_indikator.id', 'asc');

        // Jika bukan admin / mutu, batasi unit sendiri
        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_indikator.unit_id', $user->unit_id);
        }

        $mutu = $query->get();

        return view('menu.IndikatorMutu.kamus-indikator.index', compact('mutu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $queryIndikator = DB::table('tbl_indikator');

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

        return view('menu.IndikatorMutu.kamus-indikator.create', compact(
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
            'kategori_indikator' => 'required|array|min:1',
            'kategori_indikator.*' => 'in:Prioritas Unit,Prioritas RS,Nasional',

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

        $kamusId = DB::table('tbl_kamus_indikator')->insertGetId([
            'definisi_operasional' => $request->definisi_operasional,
            'tujuan' => $request->tujuan,
            'dasar_pemikiran' => $request->dasar_pemikiran,
            'formula_pengukuran' => $request->formula_pengukuran,
            'metodologi' => $request->metodologi,
            'detail_pengukuran' => $request->detail_pengukuran,
            'sumber_data' => $request->sumber_data,
            'penanggung_jawab' => $request->penanggung_jawab,
            'kategori_indikator' => implode(',', $request->kategori_indikator),

            'indikator_id' => $request->indikator_id,
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

        DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->update([
                'kamus_indikator_id' => $kamusId,
            ]);

        return redirect()->route('kamus-indikator.index')
            ->with('success', 'Kamus Indikator Mutu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('tbl_kamus_indikator')->where('id', $id)->first();

        $indikator = DB::table('tbl_indikator')->get();
        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();


        return view('menu.IndikatorMutu.kamus-indikator.edit', compact(
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
        DB::table('tbl_kamus_indikator')->where('id', $id)->update([
            'indikator_id' => $request->indikator_id,
            'dimensi_mutu_id' => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id' => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,
            'metodologi_analisis_data_id' => $request->metodologi_analisis_data_id,
            'interpretasi_data_id' => $request->interpretasi_data_id,
            'publikasi_data_id' => $request->publikasi_data_id,
        ]);

        return redirect()->route('kamus-indikator.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_kamus_indikator')->where('id', $id)->delete();

        return redirect()->route('kamus-indikator.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
