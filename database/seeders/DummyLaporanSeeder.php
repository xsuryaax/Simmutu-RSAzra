<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing reports to ensure a clean start for charts
        DB::table('tbl_laporan_dan_analis')->truncate();
        DB::table('tbl_spm_laporan_dan_analis')->truncate();

        $startDate = Carbon::create(2026, 1, 1);
        $endDate = Carbon::create(2026, 4, 19); // Yesterday
        
        $indicators = DB::table('tbl_indikator')->get();
        $kamus = DB::table('tbl_kamus_indikator')->get()->keyBy('indikator_id');
        $spms = DB::table('tbl_spm')->get();

        $allDays = [];
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $allDays[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // 1. Seed Indikator Mutu Reports
        $imData = [];
        foreach ($indicators as $ind) {
            $kamu = $kamus->get($ind->id);
            foreach ($allDays as $day) {
                // Randomize numerator and denominator
                $denominator = rand(10, 50);
                $numerator = rand(round($denominator * 0.7), $denominator); // 70-100% achievement mostly
                $nilai = ($numerator / $denominator) * 100;
                
                $pencapaian = 'tidak-tercapai';
                if ($ind->arah_target == 'lebih_besar' && $nilai >= $ind->target_indikator) {
                    $pencapaian = 'tercapai';
                } elseif ($ind->arah_target == 'lebih_kecil' && $nilai <= $ind->target_indikator) {
                    $pencapaian = 'tercapai';
                }

                $imData[] = [
                    'tanggal_laporan' => $day,
                    'indikator_id' => $ind->id,
                    'unit_id' => $ind->unit_id,
                    'kategori_indikator' => $kamu ? $kamu->kategori_indikator : 'Lainnya',
                    'numerator' => $numerator,
                    'denominator' => $denominator,
                    'nilai' => round($nilai, 2),
                    'pencapaian' => $pencapaian,
                    'status_laporan' => 'valid',
                    'target_saat_input' => $ind->target_indikator,
                    'target_min_saat_input' => $ind->target_min,
                    'target_max_saat_input' => $ind->target_max,
                    'arah_target_saat_input' => $ind->arah_target,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                if (count($imData) >= 1000) {
                    DB::table('tbl_laporan_dan_analis')->insert($imData);
                    $imData = [];
                }
            }
        }
        if (!empty($imData)) {
            DB::table('tbl_laporan_dan_analis')->insert($imData);
        }

        // 2. Seed SPM Reports
        $spmData = [];
        foreach ($spms as $spm) {
            foreach ($allDays as $day) {
                $denominator = rand(10, 50);
                $numerator = rand(round($denominator * 0.8), $denominator); // 80-100% achievement mostly
                $nilai = ($numerator / $denominator) * 100;

                $pencapaian = 'tidak-tercapai';
                if ($spm->arah_target == 'lebih_besar' && $nilai >= $spm->target_spm) {
                    $pencapaian = 'tercapai';
                } elseif ($spm->arah_target == 'lebih_kecil' && $nilai <= $spm->target_spm) {
                    $pencapaian = 'tercapai';
                }

                $spmData[] = [
                    'spm_id' => $spm->id,
                    'unit_id' => $spm->unit_id,
                    'numerator' => $numerator,
                    'denominator' => $denominator,
                    'nilai' => round($nilai, 2),
                    'pencapaian' => $pencapaian,
                    'tanggal_laporan' => $day,
                    'target_saat_input' => $spm->target_spm,
                    'target_min_saat_input' => $spm->target_min,
                    'target_max_saat_input' => $spm->target_max,
                    'arah_target_saat_input' => $spm->arah_target,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                if (count($spmData) >= 1000) {
                    DB::table('tbl_spm_laporan_dan_analis')->insert($spmData);
                    $spmData = [];
                }
            }
        }
        if (!empty($spmData)) {
            DB::table('tbl_spm_laporan_dan_analis')->insert($spmData);
        }
    }
}
