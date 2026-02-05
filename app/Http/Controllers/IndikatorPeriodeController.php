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
            // 1️⃣ Ambil periode aktif
            $periode = DB::table('tbl_periode')
                ->where('status', 'aktif')
                ->first();

            if (!$periode) {
                return back()->withErrors([
                    'periode' => 'Tidak ada periode aktif.'
                ]);
            }

            // 2️⃣ Cek apakah indikator sudah terdaftar di periode ini
            $exists = DB::table('tbl_indikator_periode')
                ->where('indikator_id', $indikatorId)
                ->where('periode_id', $periode->id)
                ->exists();

            if ($exists) {
                return back()->with('warning', 'Indikator sudah aktif di periode ini.');
            }

            // 3️⃣ Insert ke tabel relasi indikator-periode
            DB::table('tbl_indikator_periode')->insert([
                'indikator_id' => $indikatorId,
                'periode_id' => $periode->id,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4️⃣ 🔥 Sinkron status master indikator
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
