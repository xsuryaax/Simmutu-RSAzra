<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamusIndikator extends Seeder
{
    public function run(): void
    {
        $indikators = DB::table('tbl_indikator')->get();

        $dimensi = DB::table('tbl_dimensi_mutu')->first();
        $jenis = DB::table('tbl_jenis_indikator')->first();
        $periodePengumpulan = DB::table('tbl_periode_pengumpulan_data')->first();
        $periodeAnalisis = DB::table('tbl_periode_analisis_data')->first();
        $penyajian = DB::table('tbl_penyajian_data')->first();

        foreach ($indikators as $indikator) {

            // insert kamus dan ambil ID
            $kamusId = DB::table('tbl_kamus_indikator')->insertGetId([
                'indikator_id' => $indikator->id,
                'kategori_indikator' => 'Prioritas Unit',
                'dimensi_mutu_id' => $dimensi->id ?? 1,
                'dasar_pemikiran' => 'test',
                'tujuan' => 'test',
                'definisi_operasional' => 'test',
                'jenis_indikator_id' => $jenis->id ?? 1,
                'satuan_pengukuran' => 'test',
                'numerator' => 'test',
                'denominator' => 'test',
                'target_pencapaian' => 'test',
                'kriteria_inklusi' => 'test',
                'kriteria_eksklusi' => 'test',
                'formula' => 'test',
                'metode_pengumpulan_data' => 'test',
                'sumber_data' => 'test',
                'instrumen_pengambilan_data' => 'test',
                'populasi' => 'test',
                'sampel' => 'test',
                'periode_pengumpulan_data_id' => $periodePengumpulan->id ?? 1,
                'periode_analisis_data_id' => $periodeAnalisis->id ?? 1,
                'penyajian_data_id' => $penyajian->id ?? 1,
                'penanggung_jawab' => 'test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // update indikator supaya terhubung
            DB::table('tbl_indikator')
                ->where('id', $indikator->id)
                ->update([
                    'kamus_indikator_id' => $kamusId
                ]);
        }
    }
}
