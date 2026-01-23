<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;

class PDSAController extends Controller
{
    /**
     * LIST INDIKATOR (MUTU)
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
            ->havingRaw('AVG(l.nilai) < i.target_indikator')
            ->orderBy('nilai_quarter', 'asc')
            ->get();

        return view('menu.IndikatorMutu.pdsa.index', compact('data', 'tahun', 'quarter'));
    }

    /**
     * MUTU - TUGASKAN PDSA
     */
    public function assign(Request $request)
    {
        DB::table('tbl_pdsa_assignments')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
            'tahun' => $request->tahun,
            'quarter' => $request->quarter,
            'status_pdsa' => 'assigned',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'PDSA berhasil ditugaskan');
    }

    /**
     * DETAIL PDSA (MUTU & ADMIN - READ ONLY)
     */
    public function show($id)
    {
        $user = Auth::user();
        if (!in_array($user->unit_id, [1, 2]))
            abort(403);

        $pdsa = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->select('a.*', 'p.plan', 'p.do', 'p.study', 'p.action')
            ->where('a.id', $id)
            ->first();

        if (!$pdsa)
            abort(404);

        return view('menu.IndikatorMutu.pdsa.show', compact('pdsa'));
    }

    /**
     * FORM SUBMIT (UNIT)
     */
    public function formSubmit($id)
    {
        $user = Auth::user();

        $assignment = DB::table('tbl_pdsa_assignments')->where('id', $id)->first();

        if (
            !$assignment ||
            $assignment->unit_id != $user->unit_id ||
            $assignment->status_pdsa !== 'assigned'
        ) {
            abort(403);
        }

        return view('menu.IndikatorMutu.pdsa.submit', compact('assignment'));
    }

    /**
     * SUBMIT PDSA (UNIT)
     */
    public function submit(Request $request, $id)
    {
        $data = $request->validate([
            'plan' => 'required',
            'do' => 'required',
            'study' => 'required',
            'action' => 'required',
        ]);

        DB::table('tbl_pdsa')->updateOrInsert(
            ['assignment_id' => $id],
            array_merge($data, [
                'created_by' => Auth::id(),
                'updated_at' => now()
            ])
        );

        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update([
                'status_pdsa' => 'submitted',
                'updated_at' => now()
            ]);

        return redirect()->route('dashboard')->with('success', 'PDSA berhasil disubmit');
    }

    /**
     * FORM EDIT (UNIT & MUTU)
     */
    public function edit($id)
    {
        $user = Auth::user();

        $pdsa = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->select('a.*', 'p.plan', 'p.do', 'p.study', 'p.action')
            ->where('a.id', $id)
            ->first();

        if (!$pdsa)
            abort(404);

        $isMutu = in_array($user->unit_id, [1, 2]);

        if (!$isMutu) {
            if ($pdsa->unit_id != $user->unit_id)
                abort(403);
            if ($pdsa->status_pdsa === 'approved')
                abort(403);
        }

        return view('menu.IndikatorMutu.pdsa.edit', compact('pdsa', 'isMutu'));
    }

    /**
     * UPDATE PDSA (UNIT & MUTU)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $data = $request->validate([
            'plan' => 'required',
            'do' => 'required',
            'study' => 'required',
            'action' => 'required',
        ]);

        DB::table('tbl_pdsa')
            ->where('assignment_id', $id)
            ->update(array_merge($data, [
                'updated_at' => now()
            ]));

        // cek apakah admin / mutu
        $isMutu = in_array($user->unit_id, [1, 2]);

        if ($isMutu) {
            return redirect()
                ->route('pdsa.show', $id)
                ->with('success', 'PDSA berhasil diperbarui');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'PDSA berhasil diperbarui');
    }

    public function approve($id)
    {
        $user = Auth::user();

        // Validasi hanya mutu / admin
        if (!in_array($user->unit_id, [1, 2])) {
            abort(403, 'Anda tidak berhak melakukan approve');
        }

        // Pastikan data assignment ada
        $assignment = DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->first();

        if (!$assignment) {
            abort(404);
        }

        // Update status PDSA
        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update([
                'status_pdsa' => 'approved',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('pdsa.show', $id)
            ->with('success', 'PDSA berhasil di-approve');
    }

}
