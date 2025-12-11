<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanTes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indikatorIds = [1];
        $unitIds = DB::table('tbl_unit')->pluck('id')->toArray();

        $tahun = date('Y');

        foreach ($indikatorIds as $indikator_id) {

            // ============================
            // 1) GENERATE DATA HARIAN (Jan–Nov)
            // ============================
            for ($bulan = 1; $bulan <= 11; $bulan++) {

                // Hitung jumlah hari di bulan tersebut
                $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
                    foreach ($unitIds as $unit_id) {

                        $numerator = rand(50, 100);
                        $denominator = 100;
                        $nilai = ($numerator / $denominator) * 100;

                        $target = DB::table('tbl_indikator')->where('id', $indikator_id)->value('target_indikator');
                        $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

                        DB::table('tbl_laporan_dan_analis')->insert([
                            'indikator_id' => $indikator_id,
                            'unit_id' => $unit_id,
                            'nilai' => $nilai,
                            'pencapaian' => $pencapaian,
                            'file_laporan' => 'dummy_harian.pdf',
                            'tanggal_laporan' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // ============================
            // 2) GENERATE DATA BULANAN (Jan–Nov)
            // ============================
            for ($bulan = 1; $bulan <= 11; $bulan++) {
                foreach ($unitIds as $unit_id) {

                    $numerator = rand(500, 1000); // range lebih besar supaya beda
                    $denominator = 1000;
                    $nilai = ($numerator / $denominator) * 100;

                    $target = DB::table('tbl_indikator')->where('id', $indikator_id)->value('target_indikator');
                    $pencapaian = $nilai >= $target ? 'tercapai' : 'tidak-tercapai';

                    // simpan pada tanggal akhir bulan
                    $tanggalAkhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                    DB::table('tbl_laporan_dan_analis')->insert([
                        'indikator_id' => $indikator_id,
                        'unit_id' => $unit_id,
                        'nilai' => $nilai,
                        'pencapaian' => $pencapaian,
                        'file_laporan' => 'dummy_bulanan.pdf',
                        'tanggal_laporan' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggalAkhir),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
