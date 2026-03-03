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
            ->join('tbl_indikator', 'tbl_kamus_indikator.indikator_id', '=', 'tbl_indikator.id')
            ->leftJoin('tbl_unit', 'tbl_indikator.unit_id', '=', 'tbl_unit.id')
            ->leftJoin('tbl_periode_pengumpulan_data', 'tbl_kamus_indikator.periode_pengumpulan_data_id', '=', 'tbl_periode_pengumpulan_data.id')
            ->leftJoin('tbl_periode_analisis_data', 'tbl_kamus_indikator.periode_analisis_data_id', '=', 'tbl_periode_analisis_data.id')
            ->leftJoin('tbl_penyajian_data', 'tbl_kamus_indikator.penyajian_data_id', '=', 'tbl_penyajian_data.id')
            ->leftJoin('tbl_kategori_imprs', 'tbl_kamus_indikator.kategori_id', '=', 'tbl_kategori_imprs.id')
            ->leftJoin('tbl_dimensi_mutu as d', function ($join) {
                $join->whereRaw("
                d.id = ANY(
                    string_to_array(tbl_kamus_indikator.dimensi_mutu_id::text, ',')::int[]
                )
            ");
            })
            ->select(
                'tbl_kamus_indikator.id',
                'tbl_kamus_indikator.kategori_indikator',
                'tbl_kamus_indikator.penanggung_jawab',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                'tbl_unit.nama_unit',
                DB::raw("string_agg(d.nama_dimensi_mutu, ', ') as nama_dimensi_mutu"),
                'tbl_periode_pengumpulan_data.nama_periode_pengumpulan_data',
                'tbl_periode_analisis_data.nama_periode_analisis_data',
                'tbl_penyajian_data.nama_penyajian_data',
                'tbl_kategori_imprs.nama_kategori_imprs'
            )
            ->groupBy(
                'tbl_kamus_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.unit_id',
                'tbl_unit.nama_unit',
                'tbl_periode_pengumpulan_data.nama_periode_pengumpulan_data',
                'tbl_periode_analisis_data.nama_periode_analisis_data',
                'tbl_penyajian_data.nama_penyajian_data',
                'tbl_kategori_imprs.nama_kategori_imprs'
            );

        if (in_array($user->unit_id, [1, 2])) {

            $query->orderByRaw(
                "CASE WHEN tbl_indikator.unit_id = ? THEN 0 ELSE 1 END",
                [$user->unit_id]
            );

        } else {

            $query->where('tbl_indikator.unit_id', $user->unit_id);
        }

        $query->orderByRaw("
    CASE 
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Nasional%' THEN 1
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Prioritas RS%' THEN 2
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Prioritas Unit%' THEN 3
        ELSE 4
    END
")
            ->orderBy('tbl_indikator.nama_indikator', 'ASC');

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

        $jenisIndikator = DB::table('tbl_jenis_indikator')->get();

        if (!in_array($user->unit_id, [1, 2])) {
            $queryIndikator->where('unit_id', $user->unit_id);
        }

        $kategoriImprs = DB::table('tbl_kategori_imprs')->orderBy('nama_kategori_imprs', 'ASC')->get();

        $indikator = $queryIndikator->get();

        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $periodePengumpulan = DB::table('tbl_periode_pengumpulan_data')->get();
        $periodeAnalisis = DB::table('tbl_periode_analisis_data')->get();
        $penyajianData = DB::table('tbl_penyajian_data')->get();

        $unit = DB::table('tbl_unit')
            ->orderBy('nama_unit', 'ASC')
            ->get();

        return view('menu.IndikatorMutu.kamus-indikator.create', compact(
            'indikator',
            'dimensi',
            'periodePengumpulan',
            'periodeAnalisis',
            'penyajianData',
            'kategoriImprs',
            'jenisIndikator',
            'unit',
        ));
    }

    /**
     * Store Kamus Indikator Mutu
     */
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:tbl_indikator,id',
            'kategori_indikator' => 'required|array|min:1',
            'kategori_indikator.*' => 'in:Prioritas Unit,Prioritas RS,Nasional',

            'dimensi_mutu_id' => 'required|array|min:1',
            'dimensi_mutu_id.*' => 'exists:tbl_dimensi_mutu,id',
            'jenis_indikator_id' => 'required|integer',

            'dasar_pemikiran' => 'required',
            'tujuan' => 'required',
            'definisi_operasional' => 'required',

            'numerator' => 'required',
            'denominator' => 'required',
            'satuan_pengukuran' => 'required',
            'target_pencapaian' => 'required',

            'kriteria_inklusi' => 'required',
            'kriteria_eksklusi' => 'required',
            'formula' => 'required',

            'metode_pengumpulan_data' => 'required',
            'sumber_data' => 'required',
            'instrumen_pengambilan_data' => 'required',

            'populasi' => 'required',
            'sampel' => 'required',

            'periode_pengumpulan_data_id' => 'required|integer',
            'periode_analisis_data_id' => 'required|integer',
            'penyajian_data_id' => 'required|integer',

            'penanggung_jawab' => 'required',
        ]);

        // validasi tambahan jika Prioritas RS
        if (in_array('Prioritas RS', $request->kategori_indikator)) {
            $request->validate([
                'kategori_id' => 'required|exists:tbl_kategori_imprs,id',
            ]);
        }

        $kamusId = DB::table('tbl_kamus_indikator')->insertGetId([
            'indikator_id' => $request->indikator_id,
            'kategori_indikator' => implode(',', $request->kategori_indikator),
            'kategori_id' => $request->kategori_id ?? null,

            'dimensi_mutu_id' => implode(',', $request->dimensi_mutu_id),
            'jenis_indikator_id' => $request->jenis_indikator_id,

            'dasar_pemikiran' => $request->dasar_pemikiran,
            'tujuan' => $request->tujuan,
            'definisi_operasional' => $request->definisi_operasional,

            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'satuan_pengukuran' => $request->satuan_pengukuran,
            'target_pencapaian' => $request->target_pencapaian,

            'kriteria_inklusi' => $request->kriteria_inklusi,
            'kriteria_eksklusi' => $request->kriteria_eksklusi,
            'formula' => $request->formula,

            'metode_pengumpulan_data' => $request->metode_pengumpulan_data,
            'sumber_data' => $request->sumber_data,
            'instrumen_pengambilan_data' => $request->instrumen_pengambilan_data,

            'populasi' => $request->populasi,
            'sampel' => $request->sampel,

            'periode_pengumpulan_data_id' => $request->periode_pengumpulan_data_id,
            'periode_analisis_data_id' => $request->periode_analisis_data_id,
            'penyajian_data_id' => $request->penyajian_data_id,

            'penanggung_jawab' => $request->penanggung_jawab,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->update([
                'kamus_indikator_id' => $kamusId,
            ]);

        return redirect()
            ->route('kamus-indikator.index')
            ->with('success', 'Kamus Indikator Mutu berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DB::table('tbl_kamus_indikator')
            ->join('tbl_indikator', 'tbl_indikator.id', '=', 'tbl_kamus_indikator.indikator_id')
            ->join('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select(
                'tbl_kamus_indikator.*',
                'tbl_indikator.nama_indikator',
                'tbl_unit.nama_unit'
            )
            ->where('tbl_kamus_indikator.id', $id)
            ->first();

        $unit = DB::table('tbl_unit')
            ->orderBy('nama_unit', 'ASC')
            ->get();
        $indikator = DB::table('tbl_indikator')->get();
        $dimensi = DB::table('tbl_dimensi_mutu')->get();
        $selectedDimensi = explode(',', $data->dimensi_mutu_id);
        $periodePengumpulan = DB::table('tbl_periode_pengumpulan_data')->get();
        $periodeAnalisis = DB::table('tbl_periode_analisis_data')->get();
        $penyajianData = DB::table('tbl_penyajian_data')->get();
        $kategoriImprs = DB::table('tbl_kategori_imprs')->orderBy('nama_kategori_imprs', 'ASC')->get();
        $jenisIndikator = DB::table('tbl_jenis_indikator')->get();

        return view('menu.IndikatorMutu.kamus-indikator.edit', compact(
            'data',
            'indikator',
            'dimensi',
            'selectedDimensi',
            'periodePengumpulan',
            'periodeAnalisis',
            'penyajianData',
            'kategoriImprs',
            'jenisIndikator',
            'unit',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'indikator_id' => 'required|exists:tbl_indikator,id',
            'kategori_indikator' => 'required|array|min:1',
            'kategori_indikator.*' => 'in:Prioritas Unit,Prioritas RS,Nasional',

            'dimensi_mutu_id' => 'required|array|min:1',
            'dimensi_mutu_id.*' => 'exists:tbl_dimensi_mutu,id',

            'jenis_indikator_id' => 'required|integer',
            'periode_pengumpulan_data_id' => 'required|integer',
            'periode_analisis_data_id' => 'required|integer',
            'penyajian_data_id' => 'required|integer',
            'penanggung_jawab' => 'required',
        ]);

        if (in_array('Prioritas RS', $request->kategori_indikator)) {
            $request->validate([
                'kategori_id' => 'required|exists:tbl_kategori_imprs,id',
            ]);
        }

        DB::table('tbl_kamus_indikator')
            ->where('id', $id)
            ->update([
                'indikator_id' => $request->indikator_id,
                'kategori_indikator' => implode(',', $request->kategori_indikator),
                'kategori_id' => in_array('Prioritas RS', $request->kategori_indikator)
                    ? $request->kategori_id
                    : null,

                'dimensi_mutu_id' => implode(',', $request->dimensi_mutu_id),
                'jenis_indikator_id' => $request->jenis_indikator_id,

                'dasar_pemikiran' => $request->dasar_pemikiran,
                'tujuan' => $request->tujuan,
                'definisi_operasional' => $request->definisi_operasional,

                'numerator' => $request->numerator,
                'denominator' => $request->denominator,
                'satuan_pengukuran' => $request->satuan_pengukuran,
                'target_pencapaian' => $request->target_pencapaian,

                'kriteria_inklusi' => $request->kriteria_inklusi,
                'kriteria_eksklusi' => $request->kriteria_eksklusi,
                'formula' => $request->formula,

                'metode_pengumpulan_data' => $request->metode_pengumpulan_data,
                'sumber_data' => $request->sumber_data,
                'instrumen_pengambilan_data' => $request->instrumen_pengambilan_data,

                'populasi' => $request->populasi,
                'sampel' => $request->sampel,

                'periode_pengumpulan_data_id' => $request->periode_pengumpulan_data_id,
                'periode_analisis_data_id' => $request->periode_analisis_data_id,
                'penyajian_data_id' => $request->penyajian_data_id,

                'penanggung_jawab' => $request->penanggung_jawab,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('kamus-indikator.index')
            ->with('success', 'Data Kamus Indikator berhasil diperbarui.');
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