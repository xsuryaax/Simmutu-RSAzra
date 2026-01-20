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
            ->leftJoin('tbl_metodologi_pengumpulan_data', 'tbl_kamus_indikator.metodologi_pengumpulan_data_id', '=', 'tbl_metodologi_pengumpulan_data.id')
            ->leftJoin('tbl_cakupan_data', 'tbl_kamus_indikator.cakupan_data_id', '=', 'tbl_cakupan_data.id')
            ->leftJoin('tbl_frekuensi_pengumpulan_data', 'tbl_kamus_indikator.frekuensi_pengumpulan_data_id', '=', 'tbl_frekuensi_pengumpulan_data.id')
            ->leftJoin('tbl_frekuensi_analisis_data', 'tbl_kamus_indikator.frekuensi_analisis_data_id', '=', 'tbl_frekuensi_analisis_data.id')
            ->leftJoin('tbl_metodologi_analisis_data', 'tbl_kamus_indikator.metodologi_analisis_data_id', '=', 'tbl_metodologi_analisis_data.id')
            ->leftJoin('tbl_interpretasi_data', 'tbl_kamus_indikator.interpretasi_data_id', '=', 'tbl_interpretasi_data.id')
            ->leftJoin('tbl_publikasi_data', 'tbl_kamus_indikator.publikasi_data_id', '=', 'tbl_publikasi_data.id')
            ->leftJoin('tbl_kategori_imprs', 'tbl_kamus_indikator.kategori_id', '=', 'tbl_kategori_imprs.id')
            // LEFT JOIN dimensi_mutu dengan string_agg
            ->leftJoin('tbl_dimensi_mutu as d', function ($join) {
                $join->on(DB::raw("d.id::text"), 'like', DB::raw("ANY(string_to_array(tbl_kamus_indikator.dimensi_mutu_id, ',')::text[])"));
            })
            ->select(
                'tbl_kamus_indikator.*',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                DB::raw("string_agg(d.nama_dimensi_mutu, ', ') as nama_dimensi_mutu"),
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data',
                'tbl_kategori_imprs.nama_kategori_imprs as kategori_indikator'
            )
            ->groupBy(
                'tbl_kamus_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                'tbl_metodologi_pengumpulan_data.nama_metodologi_pengumpulan_data',
                'tbl_cakupan_data.nama_cakupan_data',
                'tbl_frekuensi_pengumpulan_data.nama_frekuensi_pengumpulan_data',
                'tbl_frekuensi_analisis_data.nama_frekuensi_analisis_data',
                'tbl_metodologi_analisis_data.nama_metodologi_analisis_data',
                'tbl_interpretasi_data.nama_interpretasi_data',
                'tbl_publikasi_data.nama_publikasi_data',
                'tbl_kategori_imprs.nama_kategori_imprs'
            )
            ->orderBy('tbl_kamus_indikator.id', 'asc');

        // Batasi untuk unit bukan admin/mutu
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

        $kategoriImprs = DB::table('tbl_kategori_imprs')->orderBy('nama_kategori_imprs', 'ASC')->get();

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
            'publikasi',
            'kategoriImprs'
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

            'jenis_indikator' => 'required|array|min:1',
            'jenis_indikator.*' => 'in:Prioritas Unit,Prioritas RS,Nasional',

            'indikator_id' => 'required',
            'dimensi_mutu_id' => 'required|array|min:1',
            'dimensi_mutu_id.*' => 'integer|exists:tbl_dimensi_mutu,id',
            'metodologi_pengumpulan_data_id' => 'required',
            'cakupan_data_id' => 'required',
            'frekuensi_pengumpulan_data_id' => 'required',
            'frekuensi_analisis_data_id' => 'required',
            'metodologi_analisis_data_id' => 'required',
            'interpretasi_data_id' => 'required',
            'publikasi_data_id' => 'required',
        ]);

        // VALIDASI KHUSUS JIKA PRIORITAS RS DIPILIH
        if (in_array('Prioritas RS', $request->jenis_indikator)) {
            $request->validate([
                'kategori_id' => 'required|exists:tbl_kategori_imprs,id',
            ]);
        }

        $kategoriId = in_array('Prioritas RS', $request->jenis_indikator)
            ? $request->kategori_id
            : null;

        $kamusId = DB::table('tbl_kamus_indikator')->insertGetId([
            'definisi_operasional' => $request->definisi_operasional,
            'tujuan' => $request->tujuan,
            'dasar_pemikiran' => $request->dasar_pemikiran,
            'formula_pengukuran' => $request->formula_pengukuran,
            'metodologi' => $request->metodologi,
            'detail_pengukuran' => $request->detail_pengukuran,
            'sumber_data' => $request->sumber_data,
            'penanggung_jawab' => $request->penanggung_jawab,

            'jenis_indikator' => implode(',', $request->jenis_indikator),
            'kategori_id' => $kategoriId,

            'indikator_id' => $request->indikator_id,
            'dimensi_mutu_id' => implode(',', $request->dimensi_mutu_id),

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
        $dimensi = DB::table('tbl_dimensi_mutu')->get(); // <-- tambahkan ini
        $selectedDimensi = explode(',', $data->dimensi_mutu_id);
        $metodologiPengumpulan = DB::table('tbl_metodologi_pengumpulan_data')->get();
        $cakupan = DB::table('tbl_cakupan_data')->get();
        $frekuensiPengumpulan = DB::table('tbl_frekuensi_pengumpulan_data')->get();
        $frekuensiAnalisis = DB::table('tbl_frekuensi_analisis_data')->get();
        $metodologiAnalisis = DB::table('tbl_metodologi_analisis_data')->get();
        $interpretasi = DB::table('tbl_interpretasi_data')->get();
        $publikasi = DB::table('tbl_publikasi_data')->get();
        $kategoriImprs = DB::table('tbl_kategori_imprs')->orderBy('nama_kategori_imprs', 'ASC')->get();

        return view('menu.IndikatorMutu.kamus-indikator.edit', compact(
            'data',
            'indikator',
            'dimensi',          // sekarang sudah ada
            'selectedDimensi',  // kirim juga array yang dipilih
            'metodologiPengumpulan',
            'cakupan',
            'frekuensiPengumpulan',
            'frekuensiAnalisis',
            'metodologiAnalisis',
            'interpretasi',
            'publikasi',
            'kategoriImprs'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('tbl_kamus_indikator')
            ->where('id', $id)
            ->update([
                'indikator_id' => $request->indikator_id,
                'dimensi_mutu_id' => $request->dimensi_mutu_id ? implode(',', $request->dimensi_mutu_id) : null,
                'metodologi_pengumpulan_data_id' => $request->metodologi_pengumpulan_data_id,
                'cakupan_data_id' => $request->cakupan_data_id,
                'frekuensi_pengumpulan_data_id' => $request->frekuensi_pengumpulan_data_id,
                'frekuensi_analisis_data_id' => $request->frekuensi_analisis_data_id,
                'metodologi_analisis_data_id' => $request->metodologi_analisis_data_id,
                'interpretasi_data_id' => $request->interpretasi_data_id,
                'publikasi_data_id' => $request->publikasi_data_id,

                // =========================
                // FIX UTAMA
                // =========================
                'jenis_indikator' => $request->jenis_indikator
                    ? implode(',', $request->jenis_indikator)
                    : null,

                // =========================
                // KATEGORI IMPRS
                // =========================
                'kategori_id' => in_array('Prioritas RS', $request->jenis_indikator ?? [])
                    ? $request->kategori_id
                    : null,
            ]);

        return redirect()
            ->route('kamus-indikator.index')
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
