<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class IndikatorPeriodeController extends Controller
{
    public function active($indikatorId)
    {
        DB::beginTransaction();

        try {
            $periode = DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->first();

            if (!$periode) {
                return back()->withErrors([
                    'periode' => 'Tidak ada periode aktif.'
                ]);
            }

            $exists = DB::table('tbl_indikator_periode')
                ->where('indikator_id', $indikatorId)
                ->where('periode_id', $periode->id)
                ->exists();

            if ($exists) {
                return back()->with('warning', 'Indikator sudah aktif di periode ini.');
            }

            DB::table('tbl_indikator_periode')->insert([
                'indikator_id' => $indikatorId,
                'periode_id' => $periode->id,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tbl_indikator')
                ->where('id', $indikatorId)
                ->update([
                    'status_indikator' => 'aktif',
                    'updated_at' => now(),
                ]);

            DB::commit();

            return back()->with('success', 'Indikator berhasil diaktifkan pada periode aktif.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengaktifkan indikator.');
        }
    }
}
