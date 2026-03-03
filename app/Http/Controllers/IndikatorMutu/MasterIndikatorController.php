<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class MasterIndikatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $periodes = DB::table('tbl_periode')
            ->orderBy('tahun', 'desc')
            ->get();

        $periodeAktif = $this->getPeriodeAktif();

        $periodeId = $request->filled('periode_id')
            ? $request->periode_id
            : ($periodeAktif->id ?? null);

        $periodeDipilih = DB::table('tbl_periode')->where('id', $periodeId)->first();

        $query = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->leftJoin('tbl_kamus_indikator', 'tbl_kamus_indikator.indikator_id', '=', 'tbl_indikator.id')
            ->join('tbl_indikator_periode as ip_filter', function ($join) use ($periodeId) {
                $join->on('tbl_indikator.id', '=', 'ip_filter.indikator_id');
                if ($periodeId) {
                    $join->where('ip_filter.periode_id', $periodeId);
                }
            })
            ->leftJoin('tbl_indikator_periode as ip_aktif', function ($join) use ($periodeAktif) {
                $join->on('tbl_indikator.id', '=', 'ip_aktif.indikator_id');
                if ($periodeAktif) {
                    $join->where('ip_aktif.periode_id', $periodeAktif->id);
                }
            })
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.tipe_indikator',
                'tbl_indikator.keterangan',
                'tbl_indikator.status_indikator',
                'tbl_unit.nama_unit',
                'tbl_kamus_indikator.kategori_indikator',
                'ip_filter.status as status_periode',
                'ip_aktif.id as sudah_di_periode_aktif',
                'tbl_indikator.arah_target',
                'tbl_indikator.target_min',
                'tbl_indikator.target_max',
            );

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_indikator.unit_id', $user->unit_id);
        }
        if (in_array($user->unit_id, [1, 2]) && $request->filled('unit_id')) {
            $query->where('tbl_indikator.unit_id', $request->unit_id);
        }

        $query->orderByRaw(
            "CASE WHEN tbl_indikator.unit_id = ? THEN 0 ELSE 1 END",
            [$user->unit_id]
        )

            ->orderByRaw("
    CASE 
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Nasional%' THEN 1
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Prioritas RS%' THEN 2
        WHEN tbl_kamus_indikator.kategori_indikator ILIKE '%Prioritas Unit%' THEN 3
        ELSE 4
    END
")

            ->orderBy('tbl_indikator.nama_indikator', 'ASC');

        $indikators = $query->get();

        $units = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC')->get();

        return view('menu.IndikatorMutu.master-indikator.index', compact(
            'indikators',
            'units',
            'periodes',
            'periodeAktif',
            'periodeId',
            'periodeDipilih'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $units = null;
        $unitUser = null;

        if (in_array($user->unit_id, [1, 2])) {
            $units = DB::table('tbl_unit')
                ->orderBy('nama_unit', 'ASC')
                ->get();
        } else {
            $unitUser = DB::table('tbl_unit')
                ->where('id', $user->unit_id)
                ->first();
        }

        return view(
            'menu.IndikatorMutu.master-indikator.create',
            compact('units', 'unitUser')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            $request->merge([
                'unit_id' => auth()->user()->unit_id
            ]);
        }

        $request->validate([
            'nama_indikator' => 'required|string',
            'unit_id' => 'required|exists:tbl_unit,id',

            'keterangan' => 'nullable|string',
            'arah_target' => 'required|in:lebih_besar,lebih_kecil,range',

            'target_indikator' => 'nullable|numeric',
            'target_min' => 'nullable|numeric',
            'target_max' => 'nullable|numeric',

            'tipe_indikator' => 'required|in:lokal,nasional',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        // VALIDASI TAMBAHAN LOGIC RANGE
        if ($request->arah_target === 'range') {
            if ($request->target_min === null || $request->target_max === null) {
                return back()->withErrors([
                    'range' => 'Target minimum dan maksimum wajib diisi untuk tipe range.'
                ]);
            }

            if ($request->target_min > $request->target_max) {
                return back()->withErrors([
                    'range' => 'Target minimum tidak boleh lebih besar dari maksimum.'
                ]);
            }
        } else {
            if ($request->target_indikator === null) {
                return back()->withErrors([
                    'target' => 'Target indikator wajib diisi.'
                ]);
            }
        }

        $periodeAktif = $this->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->withErrors([
                'periode' => 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.'
            ]);
        }

        DB::beginTransaction();

        try {
            $indikatorId = DB::table('tbl_indikator')->insertGetId([
                'nama_indikator' => $request->nama_indikator,
                'unit_id' => $request->unit_id,

                'arah_target' => $request->arah_target,

                'target_indikator' => $request->arah_target !== 'range'
                    ? $request->target_indikator
                    : null,

                'target_min' => $request->arah_target === 'range'
                    ? $request->target_min
                    : null,

                'target_max' => $request->arah_target === 'range'
                    ? $request->target_max
                    : null,

                'tipe_indikator' => $request->tipe_indikator,
                'status_indikator' => $request->status_indikator,

                'keterangan' => $request->keterangan,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tbl_indikator_periode')->insert([
                'indikator_id' => $indikatorId,
                'periode_id' => $periodeAktif->id,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('master-indikator.index')
                ->with('success', 'Indikator berhasil ditambahkan dan otomatis aktif di periode berjalan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'Gagal menyimpan indikator: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $indikator = DB::table('tbl_indikator')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_indikator.unit_id')
            ->select('tbl_indikator.*', 'tbl_unit.nama_unit')
            ->where('tbl_indikator.id', $id)
            ->first();

        $queryUnits = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC');

        if (!in_array($user->unit_id, [1, 2])) {
            $queryUnits->where('id', $user->unit_id);
        }
        $units = $queryUnits->get();

        return view('menu.IndikatorMutu.master-indikator.edit', compact('indikator', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_indikator' => 'required|string',
            'unit_id' => 'required|exists:tbl_unit,id',

            'keterangan' => 'nullable|string',

            'arah_target' => 'required|in:lebih_besar,lebih_kecil,range',

            'target_indikator' => 'nullable|numeric',
            'target_min' => 'nullable|numeric',
            'target_max' => 'nullable|numeric',

            'tipe_indikator' => 'required|in:lokal,nasional',
            'status_indikator' => 'required|in:aktif,non-aktif',
        ]);

        // VALIDASI TAMBAHAN
        if ($request->arah_target === 'range') {
            if ($request->target_min === null || $request->target_max === null) {
                return back()->withErrors([
                    'range' => 'Target minimum dan maksimum wajib diisi untuk tipe range.'
                ]);
            }

            if ($request->target_min > $request->target_max) {
                return back()->withErrors([
                    'range' => 'Target minimum tidak boleh lebih besar dari maksimum.'
                ]);
            }
        } else {
            if ($request->target_indikator === null) {
                return back()->withErrors([
                    'target' => 'Target indikator wajib diisi.'
                ]);
            }
        }

        DB::table('tbl_indikator')->where('id', $id)->update([
            'nama_indikator' => $request->nama_indikator,
            'unit_id' => $request->unit_id,

            'arah_target' => $request->arah_target,

            'target_indikator' => $request->arah_target !== 'range'
                ? $request->target_indikator
                : null,

            'target_min' => $request->arah_target === 'range'
                ? $request->target_min
                : null,

            'target_max' => $request->arah_target === 'range'
                ? $request->target_max
                : null,

            'tipe_indikator' => $request->tipe_indikator,
            'status_indikator' => $request->status_indikator,

            'keterangan' => $request->keterangan,

            'updated_at' => now(),
        ]);

        return redirect()->route('master-indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $adaData = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $id)
            ->exists();

        if ($adaData) {
            DB::table('tbl_indikator')
                ->where('id', $id)
                ->update([
                    'status_indikator' => 'non-aktif',
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Indikator sudah memiliki histori. Status diubah menjadi non-aktif.');
        }

        DB::table('tbl_indikator')->where('id', $id)->delete();

        return back()->with('success', 'Indikator berhasil dihapus.');
    }

    private function getPeriodeAktif()
    {
        return cache()->remember('periode_aktif', 60, function () {
            return DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->first();
        });
    }
}