<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanBulanan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indikatorId = 4;
        $unitId = 4;

        $tahun = date('Y');

        // Batas akhir data (18 Desember)
        $endDate = Carbon::create($tahun, 12, 18);

        // Ambil target indikator
        $target = DB::table('tbl_indikator')
            ->where('id', $indikatorId)
            ->value('target_indikator');

        // Loop per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {

            // Tanggal akhir bulan
            $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            // Jangan lewat 18 Desember
            if ($tanggalAkhirBulan->gt($endDate)) {
                break;
            }

            // Cegah data duplikat
            $exists = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $indikatorId)
                ->where('unit_id', $unitId)
                ->whereDate('tanggal_laporan', $tanggalAkhirBulan->format('Y-m-d'))
                ->exists();

            if ($exists) {
                continue;
            }

            // Dummy nilai bulanan (lebih stabil)
            $numerator = rand(0, 5);
            $denominator = 45;
            $nilai = ($numerator / $denominator) * 100;

            $pencapaian = $nilai >= $target
                ? 'tercapai'
                : 'tidak-tercapai';

            DB::table('tbl_laporan_dan_analis')->insert([
                'indikator_id' => $indikatorId,
                'unit_id' => $unitId,
                'nilai' => $nilai,
                'pencapaian' => $pencapaian,
                'file_laporan' => 'dummy_bulanan_marketing.pdf',
                'tanggal_laporan' => $tanggalAkhirBulan->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
