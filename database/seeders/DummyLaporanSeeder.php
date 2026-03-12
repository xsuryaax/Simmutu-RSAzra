<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan Periode Aktif (Tahun 2025)
        $periode = DB::table('tbl_periode')->where('status', 'aktif')->first();

        if (!$periode) {
            $periodeId = DB::table('tbl_periode')->insertGetId([
                'nama_periode' => 'Periode Simulasi 2025',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'deadline' => 5,
                'status_deadline' => 0,
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $periode = DB::table('tbl_periode')->where('id', $periodeId)->first();
        }

        // 2. Ambil semua indikator yang ada
        $indikators = DB::table('tbl_indikator')->get();

        if ($indikators->isEmpty()) {
            $this->command->warn('Tidak ada indikator ditemukan. Jalankan php artisan db:seed --class=Indikator terlebih dahulu.');
            return;
        }

        $this->command->info('Memulai seeding data laporan untuk ' . $indikators->count() . ' indikator (Januari - Desember)...');

        // Hapus SEMUA data laporan analis & validator untuk tahun 2025 secara global (Clean Start)
        DB::table('tbl_laporan_dan_analis')->whereYear('tanggal_laporan', 2025)->delete();
        DB::table('tbl_laporan_validator')->whereYear('tanggal_laporan', 2025)->delete();

        foreach ($indikators as $ind) {
            // ... (A & B logic remains same, just ensuring references)
            // A. Pastikan terhubung ke kamus_indikator
            if (!$ind->kamus_indikator_id) {
                $kategori = 'Nasional';
                if ($ind->id > 13) $kategori = 'Prioritas RS';
                if ($ind->id > 30) $kategori = 'Prioritas Unit';

                $kamusId = DB::table('tbl_kamus_indikator')->insertGetId([
                    'indikator_id' => $ind->id,
                    'kategori_indikator' => $kategori,
                    'kategori_id' => ($kategori === 'Prioritas RS' ? 1 : null),
                    'dimensi_mutu_id' => 1,
                    'dasar_pemikiran' => 'Dummy Dasar Pemikiran',
                    'tujuan' => 'Dummy Tujuan',
                    'definisi_operasional' => 'Dummy Definisi',
                    'jenis_indikator_id' => 1,
                    'satuan_pengukuran' => 'Persen',
                    'numerator' => 'Dummy Numerator',
                    'denominator' => 'Dummy Denominator',
                    'target_pencapaian' => '100%',
                    'kriteria_inklusi' => 'Semua',
                    'kriteria_eksklusi' => 'Tidak ada',
                    'formula' => 'N/D x 100',
                    'metode_pengumpulan_data' => 'Sensus',
                    'sumber_data' => 'Rekam Medis',
                    'instrumen_pengambilan_data' => 'Formulir',
                    'populasi' => 'Semua Pasien',
                    'sampel' => 'Total Populasi',
                    'periode_pengumpulan_data_id' => 3, // Bulanan
                    'periode_analisis_data_id' => 1,    // Bulanan
                    'penyajian_data_id' => 2,          // Run Chart
                    'penanggung_jawab' => 'Kepala Unit',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('tbl_indikator')->where('id', $ind->id)->update(['kamus_indikator_id' => $kamusId]);
            }

            // B. Pastikan terhubung ke periode aktif
            $existsInPeriode = DB::table('tbl_indikator_periode')
                ->where('indikator_id', $ind->id)
                ->where('periode_id', $periode->id)
                ->exists();

            if (!$existsInPeriode) {
                DB::table('tbl_indikator_periode')->insert([
                    'indikator_id' => $ind->id,
                    'periode_id'   => $periode->id,
                    'status'       => 'aktif',
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ]);
            }

            // C. Data sudah dibersihkan di awal (global delete)

            // D. Looping 12 Bulan (Januari - Desember)
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $target = (float)($ind->target_indikator ?? 80);
                $arah = $ind->arah_target ?? 'lebih_besar';
                
                $nilaiRand = $target + rand(-15, 20);
                if ($nilaiRand > 100) $nilaiRand = 100;
                if ($nilaiRand < 0) $nilaiRand = 0;

                $isTercapai = ($arah === 'lebih_besar') ? ($nilaiRand >= $target) : ($arah === 'lebih_kecil' ? ($nilaiRand <= $target) : true);

                $denominator = rand(50, 200);
                $numerator = round(($nilaiRand / 100) * $denominator);
                $actualNilai = $denominator > 0 ? ($numerator / $denominator * 100) : 0;

                DB::table('tbl_laporan_dan_analis')->insert([
                    'tanggal_laporan' => Carbon::create($periode->tahun, $bulan, 1),
                    'indikator_id'    => $ind->id,
                    'unit_id'         => $ind->unit_id ?? 1,
                    'numerator'       => $numerator,
                    'denominator'     => $denominator,
                    'nilai'           => $actualNilai,
                    'pencapaian'      => $isTercapai ? 'tercapai' : 'tidak-tercapai',
                    'target_saat_input' => $target,
                    'arah_target_saat_input' => $arah,
                    'status_laporan'  => 'valid',
                    'created_at'      => Carbon::now(),
                    'updated_at'      => Carbon::now(),
                ]);
            }
        }
        $this->command->info('Seeding selesai! ' . $indikators->count() * 12 . ' data laporan (Januari - Desember) telah dibuat.');
    }
}
