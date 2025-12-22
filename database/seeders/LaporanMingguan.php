<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanMingguan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indikatorId = 3;
        $unitId = 4;

        $tahun = date('Y');

        // Range tanggal
        $startDate = Carbon::create($tahun, 1, 1)->startOfWeek(); // Senin
        $endDate = Carbon::create($tahun, 12, 18);

        // Ambil target indikator
        $target = DB::table('tbl_indikator')
            ->where('id', $indikatorId)
            ->value('target_indikator');

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {

            // Tanggal laporan = akhir minggu (Minggu)
            $tanggalLaporan = $date->copy()->endOfWeek();

            // Jangan lewat dari 18 Desember
            if ($tanggalLaporan->gt($endDate)) {
                break;
            }

            // Cegah data dobel
            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $indikatorId)
                ->where('unit_id', $unitId)
                ->whereDate('tanggal_laporan', $tanggalLaporan->format('Y-m-d'))
                ->exists();

            if ($exists) {
                continue;
            }

            // Dummy nilai mingguan (lebih stabil)
            $numerator = rand(85, 100);
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
                'file_laporan' => 'dummy_mingguan_marketing.pdf',
                'tanggal_laporan' => $tanggalLaporan->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
