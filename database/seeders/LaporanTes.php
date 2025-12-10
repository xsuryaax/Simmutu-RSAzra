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
        // Tentukan indikator yang ingin diisi
        $indikatorIds = [1];
        // Ambil semua unit
        $unitIds = DB::table('tbl_unit')->pluck('id')->toArray();

        $tahun = date('Y');
        $bulan = 12; // bisa diganti bulan lain jika perlu
        $tanggal = 9;       // tanggal fix 9

        foreach ($indikatorIds as $indikator_id) {
            foreach ($unitIds as $unit_id) {
                // Contoh insert 1 laporan per indikator-unit
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
                    'file_laporan' => 'dummy.pdf', // bisa ditambahkan file jika perlu
                    'tanggal_laporan' => sprintf('%04d-%02d-%02d', $tahun, $bulan, $tanggal),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
