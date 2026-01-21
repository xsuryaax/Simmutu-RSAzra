<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class PDSAController extends Controller
{
    /**
     * Menampilkan indikator yang tidak tercapai
     */
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        $quarter = $request->quarter ?? 'Q1';

        $rangeBulan = match ($quarter) {
            'Q1' => [1, 3],
            'Q2' => [4, 6],
            'Q3' => [7, 9],
            'Q4' => [10, 12],
        };

        $data = DB::table('tbl_laporan_dan_analis_unit as l')
            ->leftJoin('tbl_indikator as i', 'l.indikator_id', '=', 'i.id')
            ->leftJoin('tbl_unit as u', 'l.unit_id', '=', 'u.id')
            ->leftJoin('tbl_pdsa_assignments as p', function ($join) use ($tahun, $quarter) {
                $join->on('l.indikator_id', '=', 'p.indikator_id')
                    ->on('l.unit_id', '=', 'p.unit_id')
                    ->where('p.tahun', $tahun)
                    ->where('p.quarter', $quarter);
            })
            ->select(
                'l.indikator_id',
                'l.unit_id',
                'i.nama_indikator',
                'i.target_indikator',
                'u.nama_unit',
                DB::raw('ROUND(AVG(l.nilai), 2) as nilai_quarter'),
                DB::raw('COUNT(l.id) as jumlah_laporan'),
                'p.id as pdsa_id',
                'p.status_pdsa'
            )
            ->whereYear('l.tanggal_laporan', $tahun)
            ->whereMonth('l.tanggal_laporan', '>=', $rangeBulan[0])
            ->whereMonth('l.tanggal_laporan', '<=', $rangeBulan[1])
            ->groupBy(
                'l.indikator_id',
                'l.unit_id',
                'i.nama_indikator',
                'i.target_indikator',
                'u.nama_unit',
                'p.id',
                'p.status_pdsa'
            )
            ->havingRaw('AVG(l.nilai) < i.target_indikator') // 🔥 hanya yang TIDAK tercapai
            ->orderBy('nilai_quarter', 'asc')
            ->get();

        return view('menu.IndikatorMutu.pdsa.index', compact('data', 'tahun', 'quarter'));
    }

    /**
     * MUTU - TUGASKAN PDSA
     */
    public function store(Request $request)
    {
        DB::table('tbl_pdsa_assignments')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'tahun' => $request->tahun,
            'quarter' => $request->quarter,
            'catatan_mutu' => $request->catatan_mutu,
            'status_pdsa' => 'assigned',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'PDSA berhasil ditugaskan');
    }

    /**
     * DETAIL PDSA (MUTU & UNIT)
     */
    public function show($id)
    {
        $pdsa = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->select(
                'a.*',
                'p.plan',
                'p.do',
                'p.study',
                'p.action'
            )
            ->where('a.id', $id)
            ->first();

        if (!$pdsa) {
            abort(404);
        }

        return view('menu.IndikatorMutu.pdsa.show', compact('pdsa'));
    }

    /**
     * UNIT - SUBMIT PDSA
     */
    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        $assignment = DB::table('tbl_pdsa_assignments')->where('id', $id)->first();

        if (!$assignment || $assignment->unit_id != $user->unit_id || $assignment->status_pdsa != 'assigned') {
            abort(403, "Anda tidak dapat submit PDSA ini.");
        }

        // Validasi input
        $data = $request->validate([
            'plan' => 'nullable|string',
            'do' => 'nullable|string',
            'study' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        DB::table('tbl_pdsa')->updateOrInsert(
            ['assignment_id' => $id],
            array_merge($data, [
                'created_by' => 1,
                'updated_at' => now()
            ])
        );

        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update([
                'status_pdsa' => 'submitted',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'PDSA berhasil dikirim');
    }


    public function updateByMutu(Request $request, $id)
    {
        $pdsa = DB::table('tbl_pdsa_assignments')->where('id', $id)->first();

        // Cek role Mutu/Admin
        $user = Auth::user();
        if (!in_array($user->unit_id, [1, 2])) {
            abort(403, "Anda tidak berhak mengedit PDSA ini.");
        }

        $data = $request->validate([
            'plan' => 'nullable|string',
            'do' => 'nullable|string',
            'study' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update(array_merge($data, ['updated_at' => now()]));

        return redirect()->back()->with('success', 'PDSA berhasil diperbarui oleh Mutu/Admin');
    }

    /**
     * UPDATE PDSA (Unit & Mutu/Admin)
     */
    public function update(Request $request, $id)
    {
        $pdsa = DB::table('tbl_pdsa_assignments')->where('id', $id)->first();
        $user = Auth::user();

        $isMutu = in_array($user->unit_id, [1, 2]);
        $isUnit = !in_array($user->unit_id, [1, 2]);

        // UNIT hanya bisa edit jika status belum approved dan milik unitnya
        if ($isUnit) {
            if ($pdsa->unit_id != $user->unit_id) {
                abort(403, "Unit hanya bisa mengedit PDSA unitnya sendiri.");
            }
            if ($pdsa->status_pdsa === 'approved') {
                abort(403, "Unit tidak bisa mengedit PDSA yang sudah approved.");
            }
        }

        // MUTU/Admin bisa edit kapan saja
        if ($isMutu) {
            // opsional: bisa kasih validasi tambahan
        }

        // Validasi input
        $data = $request->validate([
            'plan' => 'nullable|string',
            'do' => 'nullable|string',
            'study' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        // Update
        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update(array_merge($data, ['updated_at' => now()]));

        return redirect()->back()->with('success', 'PDSA berhasil diperbarui');
    }


    /**
     * MUTU - APPROVE PDSA
     */
    public function approve($id)
    {
        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update([
                'status_pdsa' => 'approved',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'PDSA disetujui');
    }
}
