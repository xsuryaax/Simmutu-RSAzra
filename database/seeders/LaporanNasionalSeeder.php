<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanNasionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $bulan = 12;
        $tahun = 2025;

        $data = [];

        /**
         * 13 laporan
         * indikator_nasional_id = 1 s/d 13
         */
        for ($i = 1; $i <= 13; $i++) {

            $nilai = rand(80, 100); // simulasi nilai
            $target = 90;

            $data[] = [
                'indikator_nasional_id' => $i,
                'tanggal_laporan' => Carbon::create($tahun, $bulan, rand(1, 28))->format('Y-m-d'),
                'nilai' => $nilai,
                'pencapaian' => $nilai >= $target ? 'tercapai' : 'tidak-tercapai',
                'file_laporan' => 'laporan_nasional/dummy-file.pdf',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tbl_laporan_dan_analis_nasional')->insert($data);

    }
}
