<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanIMPRSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $tahun = 2025;
        $unitId = 3;   // FIXED
        $kategoriId = 1; // FIXED
        $indikatorIds = [1, 2]; // IMPRS ID

        $data = [];

        foreach ($indikatorIds as $imprsId) {

            // Ambil target indikator
            $imprs = DB::table('tbl_imprs')
                ->select('id', 'target_imprs')
                ->where('id', $imprsId)
                ->where('kategori_id', $kategoriId)
                ->first();

            if (!$imprs) {
                continue;
            }

            for ($bulan = 1; $bulan <= 12; $bulan++) {

                $tanggal = Carbon::create($tahun, $bulan, 1);
                $nilai = rand(80, 100);

                $data[] = [
                    'imprs_id' => $imprs->id,
                    'kategori_id' => $kategoriId,
                    'unit_id' => $unitId,
                    'nilai' => round($nilai, 2),
                    'pencapaian' => $nilai >= $imprs->target_imprs
                        ? 'tercapai'
                        : 'tidak tercapai',
                    'tanggal_laporan' => $tanggal->format('Y-m-d'),
                    'file_laporan' => 'laporan_imprs/dummy-unit3-kat1.pdf',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('tbl_laporan_dan_analis_imprs')->insert($data);
    }
}
