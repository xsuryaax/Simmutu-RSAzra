<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndikatorPeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ambil semua indikator
        $indikators = DB::table('tbl_indikator')->get();

        // ambil periode aktif
        $periode = DB::table('tbl_periode')
            ->where('status', 'aktif')
            ->first();

        foreach ($indikators as $indikator) {
            DB::table('tbl_indikator_periode')->insert([
                'indikator_id' => $indikator->id,
                'periode_id' => $periode->id,
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
