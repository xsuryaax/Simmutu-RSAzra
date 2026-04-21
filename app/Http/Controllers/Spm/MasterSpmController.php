<?php

namespace App\Http\Controllers\Spm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\IndikatorMutuService;

class MasterSpmController extends Controller
{
    protected $indikatorService;

    public function __construct(IndikatorMutuService $indikatorService)
    {
        $this->indikatorService = $indikatorService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $periodes = DB::table('tbl_periode')
            ->orderBy('tahun', 'desc')
            ->get();

        $periodeAktif = $this->indikatorService->getPeriodeAktif();

        $periodeId = $request->filled('periode_id')
            ? $request->periode_id
            : ($periodeAktif->id ?? null);
            
        $periodeDipilih = DB::table('tbl_periode')->where('id', $periodeId)->first();

        $query = DB::table('tbl_spm')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_spm.unit_id')
            ->join('tbl_spm_periode as ip_filter', function ($join) use ($periodeId) {
                $join->on('tbl_spm.id', '=', 'ip_filter.spm_id');
                if ($periodeId) {
                    $join->where('ip_filter.periode_id', $periodeId);
                }
            })
            ->leftJoin('tbl_spm_periode as ip_aktif', function ($join) use ($periodeAktif) {
                $join->on('tbl_spm.id', '=', 'ip_aktif.spm_id');
                if ($periodeAktif) {
                    $join->where('ip_aktif.periode_id', $periodeAktif->id);
                }
            })
            ->select(
                'tbl_spm.*',
                'tbl_unit.nama_unit',
                'ip_filter.status as status_periode',
                'ip_aktif.id as sudah_di_periode_aktif'
            );

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('tbl_spm.unit_id', $user->unit_id);
        }

        if (in_array($user->unit_id, [1, 2]) && $request->filled('unit_id')) {
            $query->where('tbl_spm.unit_id', $request->unit_id);
        }

        $spms = $query->orderBy('tbl_spm.id', 'ASC')->get();
        $units = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC')->get();

        return view('menu.spm.master-spm.index', compact('spms', 'units', 'periodes', 'periodeDipilih', 'periodeAktif'));
    }

    public function create()
    {
        $user = Auth::user();
        $units = null;
        $unitUser = null;

        if (in_array($user->unit_id, [1, 2])) {
            $units = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC')->get();
        } else {
            $unitUser = DB::table('tbl_unit')->where('id', $user->unit_id)->first();
        }

        return view('menu.spm.master-spm.create', compact('units', 'unitUser'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            $request->merge(['unit_id' => auth()->user()->unit_id]);
        }

        $request->validate([
            'nama_spm' => 'required|string',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_spm' => 'required|numeric',
            'arah_target' => 'required|in:lebih_besar,lebih_kecil,range',
            'target_min' => 'nullable|numeric',
            'target_max' => 'nullable|numeric',
            'status_spm' => 'required|in:aktif,non-aktif',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->arah_target === 'range' && ($request->target_min === null || $request->target_max === null)) {
            return back()->withErrors(['range' => 'Target min/max wajib diisi untuk tipe range.']);
        }

        $periodeAktif = $this->indikatorService->getPeriodeAktif();

        DB::beginTransaction();

        try {
            $spmId = DB::table('tbl_spm')->insertGetId([
                'nama_spm' => $request->nama_spm,
                'unit_id' => $request->unit_id,
                'target_spm' => $request->target_spm,
                'arah_target' => $request->arah_target,
                'target_min' => $request->target_min,
                'target_max' => $request->target_max,
                'status_spm' => $request->status_spm,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($periodeAktif) {
                DB::table('tbl_spm_periode')->insert([
                    'spm_id' => $spmId,
                    'periode_id' => $periodeAktif->id,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('master-spm.index')->with('success', 'SPM berhasil ditambahkan dan diset aktif di periode berjalan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan SPM: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $spm = DB::table('tbl_spm')->where('id', $id)->first();
        
        $queryUnits = DB::table('tbl_unit')->orderBy('nama_unit', 'ASC');
        if (!in_array($user->unit_id, [1, 2])) {
            $queryUnits->where('id', $user->unit_id);
        }
        $units = $queryUnits->get();

        return view('menu.spm.master-spm.edit', compact('spm', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_spm' => 'required|string',
            'unit_id' => 'required|exists:tbl_unit,id',
            'target_spm' => 'required|numeric',
            'arah_target' => 'required|in:lebih_besar,lebih_kecil,range',
            'target_min' => 'nullable|numeric',
            'target_max' => 'nullable|numeric',
            'status_spm' => 'required|in:aktif,non-aktif',
            'keterangan' => 'nullable|string',
        ]);

        DB::table('tbl_spm')->where('id', $id)->update([
            'nama_spm' => $request->nama_spm,
            'unit_id' => $request->unit_id,
            'target_spm' => $request->target_spm,
            'arah_target' => $request->arah_target,
            'target_min' => $request->target_min,
            'target_max' => $request->target_max,
            'status_spm' => $request->status_spm,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        return redirect()->route('master-spm.index')->with('success', 'SPM berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('tbl_spm_periode')->where('spm_id', $id)->delete();
        DB::table('tbl_spm')->where('id', $id)->delete();
        return redirect()->route('master-spm.index')->with('success', 'SPM berhasil dihapus.');
    }

    public function setPeriodeAktif($id)
    {
        $periodeAktif = $this->indikatorService->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->withErrors([
                'periode' => 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.'
            ]);
        }

        $exists = DB::table('tbl_spm_periode')
            ->where('spm_id', $id)
            ->where('periode_id', $periodeAktif->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'SPM tersebut sudah masuk dalam periode aktif.');
        }

        DB::table('tbl_spm_periode')->insert([
            'spm_id' => $id,
            'periode_id' => $periodeAktif->id,
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'SPM berhasil ditambahkan ke periode pengumpulan berjalan.');
    }
}
