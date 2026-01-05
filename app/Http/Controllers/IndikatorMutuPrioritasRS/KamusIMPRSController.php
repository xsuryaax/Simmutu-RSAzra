<?php
namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class KamusIMPRSController extends Controller
{
    /**
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // ambil user login

        $query = DB::table('tbl_kamus_imprs')
            ->leftJoin('tbl_imprs', 'tbl_kamus_imprs.imprs_id', '=', 'tbl_imprs.id')
            ->leftJoin('tbl_dimensi_mutu', 'tbl_kamus_imprs.dimensi_mutu_id', '=', 'tbl_dimensi_mutu.id')
            ->leftJoin('tbl_metodologi_pengumpulan_data', 'tbl_kamus_imprs.metodologi_pengumpulan_data_id', '=', 'tbl_metodologi_pengumpulan_data.id')
            ->leftJoin('tbl_cakupan_data', 'tbl_kamus_imprs.cakupan_data_id', '=', 'tbl_cakupan_data.id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_kamus_imprs.frekuensi_pengumpulan_data_id', '=', 'tbl_frekuensi_pengumpulan_data.id')
            ->leftJoin('tbl_frekuensi_analisis_data', 'tbl_kamus_imprs.frekuensi_analisis_data_id', '=', 'tbl_frekuensi_analisis_data.id')
            ->leftJoin('tbl_metodologi_analisis_data', 'tbl_kamus_imprs.metodologi_analisis_data_id', '=', 'tbl_metodologi_analisis_data.id')
            ->leftJoin('tbl_interpretasi_data', 'tbl_kamus_imprs.interpretasi_data_id', '=', 'tbl_interpretasi_data.id')
            ->leftJoin('tbl_publikasi_data', 'tbl_kamus_imprs.publikasi_data_id', '=', 'tbl_publikasi_data.id')
            ->select(
                'tbl_kamus_imprs.*',
                'tbl_imprs.nama_imprs',
                'tbl_dimensi_mutu.nama_dimensi_mutu',
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data'
            )
            ->orderBy('tbl_kamus_imprs.id', 'asc');

        $mutu = $query->get();

        return view('menu.IndikatorMutuPrioritasRS.kamus-imprs.index', compact('mutu'));
    }

    /**
     * Show form create
     */
    public function create()
    {
        $user = Auth::user();

        // Query indikator
        $queryIndikator = DB::table('tbl_imprs');

        $indikator = $queryIndikator->get();

        $dimensi               = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan               = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan  = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis     = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis    = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi          = DB::table('tbl_interpretasi_data')->get();
        $publikasi             = DB::table('tbl_publikasi_data')->get();

        return view('menu.IndikatorMutuPrioritasRS.kamus-imprs.create', compact(
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
            'definisi_operasional'           => 'required',
            'tujuan'                         => 'required',
            'dasar_pemikiran'                => 'required',
            'formula_pengukuran'             => 'required',
            'metodologi'                     => 'required',
            'detail_pengukuran'              => 'required',
            'sumber_data'                    => 'required',
            'penanggung_jawab'               => 'required',

            'imprs_id'                       => 'required',
            'dimensi_mutu_id'                => 'required',
            'metodologi_pengumpulan_data_id' => 'required',
            'cakupan_data_id'                => 'required',
            'frekuensi_pengumpulan_data_id'  => 'required',
            'frekuensi_analisis_data_id'     => 'required',
            'metodologi_analisis_data_id'    => 'required',
            'interpretasi_data_id'           => 'required',
            'publikasi_data_id'              => 'required',
        ]);

        $kamusId = DB::table('tbl_kamus_imprs')->insertGetId([
            'definisi_operasional'           => $request->definisi_operasional,
            'tujuan'                         => $request->tujuan,
            'dasar_pemikiran'                => $request->dasar_pemikiran,
            'formula_pengukuran'             => $request->formula_pengukuran,
            'metodologi'                     => $request->metodologi,
            'detail_pengukuran'              => $request->detail_pengukuran,
            'sumber_data'                    => $request->sumber_data,
            'penanggung_jawab'               => $request->penanggung_jawab,

            'imprs_id'                       => $request->imprs_id,
            'dimensi_mutu_id'                => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id'                => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id'  => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id'     => $request->frekuensi_analisis_data_id,
            'metodologi_analisis_data_id'    => $request->metodologi_analisis_data_id,

            'interpretasi_data_id'           => $request->interpretasi_data_id,
            'publikasi_data_id'              => $request->publikasi_data_id,
            'created_at'                     => now(),
            'updated_at'                     => now(),
        ]);
        DB::table('tbl_imprs')
            ->where('id', $request->imprs_id)
            ->update([
                'kamus_imprs_id' => $kamusId,
            ]);

        return redirect()->route('kamus-imprs.index')
            ->with('success', 'Kamus Indikator Mutu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('tbl_kamus_imprs')->where('id', $id)->first();

        $indikator             = DB::table('tbl_imprs')->get();
        $dimensi               = DB::table('tbl_dimensi_mutu')->get();
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan               = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan  = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis     = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis    = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi          = DB::table('tbl_interpretasi_data')->get();
        $publikasi             = DB::table('tbl_publikasi_data')->get();

        return view('menu.IndikatorMutuPrioritasRS.kamus-imprs.edit', compact(
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
        DB::table('tbl_kamus_imprs')->where('id', $id)->update([
            'imprs_id'                       => $request->imprs_id,
            'dimensi_mutu_id'                => $request->dimensi_mutu_id,
            'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
            'cakupan_data_id'                => $request->cakupan_data_id,
            'frekuensi_pengumpulan_data_id'  => $request->frekuensi_pengumpulan_data_id,
            'frekuensi_analisis_data_id'     => $request->frekuensi_analisis_data_id,
            'metodologi_analisis_data_id'    => $request->metodologi_analisis_data_id,
            'interpretasi_data_id'           => $request->interpretasi_data_id,
            'publikasi_data_id'              => $request->publikasi_data_id,
        ]);

        return redirect()->route('kamus-imprs.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbl_kamus_imprs')->where('id', $id)->delete();

        return redirect()->route('kamus-imprs.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
