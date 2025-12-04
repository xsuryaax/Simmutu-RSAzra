<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class PDSAController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'laporan_analisis_id' => 'required|integer',
            'plan' => 'required|string',
            'do' => 'required|string',
            'study' => 'required|string',
            'act' => 'required|string',
            'file_pdsa' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:5120'
        ]);

        // Upload File PDSA
        $filePath = null;
        if ($request->hasFile('file_pdsa')) {
            $filePath = $request->file('file_pdsa')->store('pdsa', 'public');
        }

        // Insert PDSA baru
        DB::table('tbl_pdsa')->insert([
            'laporan_analisis_id' => $request->laporan_analisis_id,
            'plan' => $request->plan,
            'do' => $request->do,
            'study' => $request->study,
            'act' => $request->act,
            'file_pdsa' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'PDSA berhasil disimpan!');
    }
}
