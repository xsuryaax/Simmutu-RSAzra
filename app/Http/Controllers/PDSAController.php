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
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->unit_id, [1, 2])) {

            $data = DB::table('tbl_laporan_dan_analis as l')
                ->leftJoin('tbl_indikator as i', 'l.indikator_id', '=', 'i.id')
                ->leftJoin('tbl_unit as u', 'l.unit_id', '=', 'u.id')
                ->leftJoin('tbl_pdsa_assignments as p', function ($join) {
                    $join->on('l.indikator_id', '=', 'p.indikator_id')
                        ->on('l.unit_id', '=', 'p.unit_id')
                        ->on(DB::raw('EXTRACT(YEAR FROM l.tanggal_laporan)'), '=', 'p.tahun')
                        ->on(DB::raw("
                        CASE
                            WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 1 AND 3 THEN 'Q1'
                            WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 4 AND 6 THEN 'Q2'
                            WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 7 AND 9 THEN 'Q3'
                            ELSE 'Q4'
                        END
                    "), '=', 'p.quarter');
                })
                ->select(
                    'l.indikator_id',
                    'l.unit_id',
                    'i.nama_indikator',
                    'i.target_indikator',
                    'u.nama_unit',
                    DB::raw('EXTRACT(YEAR FROM l.tanggal_laporan) as tahun'),
                    DB::raw("
                    CASE
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 1 AND 3 THEN 'Q1'
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 4 AND 6 THEN 'Q2'
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 7 AND 9 THEN 'Q3'
                        ELSE 'Q4'
                    END as quarter
                "),
                    DB::raw('ROUND(AVG(l.nilai), 2) as nilai_quarter'),
                    'p.id as pdsa_id',
                    'p.status_pdsa'
                )
                ->groupBy(
                    'l.indikator_id',
                    'l.unit_id',
                    'i.nama_indikator',
                    'i.target_indikator',
                    'u.nama_unit',
                    DB::raw('EXTRACT(YEAR FROM l.tanggal_laporan)'),
                    DB::raw("
                    CASE
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 1 AND 3 THEN 'Q1'
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 4 AND 6 THEN 'Q2'
                        WHEN EXTRACT(MONTH FROM l.tanggal_laporan) BETWEEN 7 AND 9 THEN 'Q3'
                        ELSE 'Q4'
                    END
                "),
                    'p.id',
                    'p.status_pdsa'
                )
                ->havingRaw('AVG(l.nilai) < i.target_indikator')
                ->orderBy('tahun')
                ->orderBy('quarter', 'desc')
                ->get();

            return view('menu.IndikatorMutu.pdsa.index', [
                'data' => $data,
                'pdsaList' => collect(),
                'pdsaTotal' => 0
            ]);
        }

        $pdsaList = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_indikator as i', 'a.indikator_id', '=', 'i.id')
            ->select(
                'a.id',
                'a.status_pdsa',
                'a.quarter',
                'a.tahun',
                'i.nama_indikator'
            )
            ->where('a.unit_id', $user->unit_id)
            ->whereIn('a.status_pdsa', ['assigned', 'revised', 'submitted', 'approved'])
            ->orderBy('a.tahun', 'desc')
            ->get();

        return view('menu.IndikatorMutu.pdsa.index', [
            'data' => collect(),
            'pdsaList' => $pdsaList,
            'pdsaTotal' => $pdsaList->count()
        ]);
    }

    /**
     * MUTU - TUGASKAN PDSA
     */
    public function assign(Request $request)
    {
        $data = $request->validate([
            'indikator_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'tahun' => 'required|integer',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
        ]);

        $assignment = DB::table('tbl_pdsa_assignments')
            ->where($data)
            ->first();

        if ($assignment) {
            return back()->with('success', 'PDSA untuk periode ini sudah ditugaskan');
        }

        DB::table('tbl_pdsa_assignments')->insert([
            ...$data,
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
        $pdsa = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->select('a.*', 'p.plan', 'p.do', 'p.study', 'p.action')
            ->where('a.id', $id)
            ->first();

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
                'catatan_mutu' => null,
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

        $isMutu = in_array($user->unit_id, [1, 2]);

        if (!$isMutu) {
            DB::table('tbl_pdsa_assignments')
                ->where('id', $id)
                ->update([
                    'status_pdsa' => 'submitted',
                    'catatan_mutu' => null,
                    'updated_at' => now(),
                ]);

            return redirect()
                ->route('dashboard')
                ->with('success', 'PDSA berhasil diperbarui dan dikirim kembali');
        }

        return redirect()
            ->route('pdsa.show', $id)
            ->with('success', 'PDSA berhasil diperbarui');
    }

    public function approve($id)
    {
        $user = Auth::user();

        if (!in_array($user->unit_id, [1, 2])) {
            abort(403, 'Anda tidak berhak melakukan approve');
        }

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

    public function revise(Request $request, $id)
    {
        $user = Auth::user();

        if (!in_array($user->unit_id, [1, 2])) {
            abort(403, 'Anda tidak berhak melakukan revisi');
        }

        $request->validate([
            'catatan_mutu' => 'required|string'
        ]);

        $assignment = DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->first();

        if (!$assignment) {
            abort(404);
        }

        DB::table('tbl_pdsa_assignments')
            ->where('id', $id)
            ->update([
                'status_pdsa' => 'revised',
                'catatan_mutu' => $request->catatan_mutu,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('pdsa.show', $id)
            ->with('success', 'PDSA dikembalikan untuk revisi');
    }

}
