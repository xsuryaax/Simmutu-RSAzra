<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndikatorPeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periode = DB::table('tbl_periode')->where('status', 'aktif')->first() 
                   ?? DB::table('tbl_periode')->first();

        if (!$periode) {
            return;
        }

        $indikators = DB::table('tbl_indikator')->get();
        $inserts = [];

        foreach ($indikators as $indikator) {
            $inserts[] = [
                'indikator_id' => $indikator->id,
                'periode_id' => $periode->id,
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($inserts) >= 500) {
                DB::table('tbl_indikator_periode')->insert($inserts);
                $inserts = [];
            }
        }

        if (!empty($inserts)) {
            DB::table('tbl_indikator_periode')->insert($inserts);
        }
    }
}
