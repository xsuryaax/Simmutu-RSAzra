<?php
namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class LaporanBulanan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indikatorId = 1;
        $unitId      = 3;

        $tahun = 2025;

        // Batas akhir data (18 Desember 2025)
        $endDate = Carbon::create($tahun, 12, 18);

        // Ambil target indikator
        $target = DB::table('tbl_indikator_unit')
            ->where('id', $indikatorId)
            ->value('target_indikator_unit');

        // Loop per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {

            // Tanggal akhir bulan
            $tanggalAkhirBulan = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            // Jangan lewat 18 Desember
            if ($tanggalAkhirBulan->gt($endDate)) {
                break;
            }

            // Cegah data duplikat (AMAN per bulan 2025)
            $exists = DB::table('tbl_laporan_dan_analis_unit')
                ->where('indikator_unit_id', $indikatorId)
                ->where('unit_id', $unitId)
                ->whereYear('tanggal_laporan', $tahun)
                ->whereMonth('tanggal_laporan', $bulan)
                ->exists();

            if ($exists) {
                continue;
            }

            $numerator   = rand(30, 45);
            $denominator = 45;

            $nilai = round(($numerator / $denominator) * 100, 2);

            $pencapaian = $nilai >= $target
                ? 'tercapai'
                : 'tidak-tercapai';

            DB::table('tbl_laporan_dan_analis_unit')->insert([
                'indikator_unit_id'    => $indikatorId,
                'unit_id'         => $unitId,
                'nilai'           => $nilai,
                'pencapaian'      => $pencapaian,
                'file_laporan'    => 'dummy_bulanan_2025.pdf',
                'tanggal_laporan' => $tanggalAkhirBulan->format('Y-m-d'),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
