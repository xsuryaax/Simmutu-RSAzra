<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanHarian extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indikatorId = 1;
        $unitId = 3;

        $tahun = date('Y');

        // Range tanggal: 1 Januari - 18 Desember
        $startDate = Carbon::create($tahun, 10, 1);
        $endDate = Carbon::create($tahun, 10, 30);

        // Ambil target indikator (sekali saja)
        $target = DB::table('tbl_indikator')
            ->where('id', $indikatorId)
            ->value('target_indikator');

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {

            // Cegah data dobel (AMAN kalau seeder dijalankan ulang)
            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $indikatorId)
                ->where('unit_id', $unitId)
                ->whereDate('tanggal_laporan', $date->format('Y-m-d'))
                ->exists();

            if ($exists) {
                continue;
            }

            // Dummy nilai harian
            $numerator = rand(90, 100);
            $denominator = 100;
            $nilai = ($numerator / $denominator) * 100;

            $pencapaian = $nilai >= $target
                ? 'tercapai'
                : 'tidak-tercapai';

            DB::table('tbl_laporan_dan_analis')->insert([
                'indikator_id' => $indikatorId,
                'unit_id' => $unitId,
                'nilai' => $nilai,
                'pencapaian' => $pencapaian,
                'file_laporan' => 'dummy_harian_simrs.pdf',
                'tanggal_laporan' => $date->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
