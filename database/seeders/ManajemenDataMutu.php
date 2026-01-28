<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManajemenDataMutu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('tbl_dimensi_mutu')->insert([
            ['nama_dimensi_mutu' => 'Keselamatan'],
            ['nama_dimensi_mutu' => 'Efektivitas'],
            ['nama_dimensi_mutu' => 'Berfokus pada Pasien'],
            ['nama_dimensi_mutu' => 'Ketepatan Waktu'],
            ['nama_dimensi_mutu' => 'Efisiensi'],
            ['nama_dimensi_mutu' => 'Keadilan / Kesetaraan'],
            ['nama_dimensi_mutu' => 'Kesinambungan / Integrasi Pelayanan'],
        ]);

        DB::table('tbl_cakupan_data')->insert([
            ['nama_cakupan_data' => 'Total'],
            ['nama_cakupan_data' => 'Sampel'],
        ]);

        DB::table('tbl_frekuensi_analisis_data')->insert([
            ['nama_frekuensi_analisis_data' => 'Bulanan'],
            ['nama_frekuensi_analisis_data' => 'Triwulanan'],
            ['nama_frekuensi_analisis_data' => 'Tahunan'],
        ]);

        DB::table('tbl_frekuensi_pengumpulan_data')->insert([
            ['nama_frekuensi_pengumpulan_data' => 'Harian'],
            ['nama_frekuensi_pengumpulan_data' => 'Mingguan'],
            ['nama_frekuensi_pengumpulan_data' => 'Bulanan'],
        ]);

        DB::table('tbl_interpretasi_data')->insert([
            ['nama_interpretasi_data' => 'Trend Dibandingkan Dengan Standar'],
            ['nama_interpretasi_data' => 'Trend Dibandingkan Dengan RS Lain'],
            ['nama_interpretasi_data' => 'Trend Dibandingkan Dengan Praktek Terbaik'],
        ]);

        DB::table('tbl_metodologi_analisis_data')->insert([
            ['nama_metodologi_analisis_data' => 'Statistik'],
            ['nama_metodologi_analisis_data' => 'Run Chart'],
            ['nama_metodologi_analisis_data' => 'Control Chart'],
            ['nama_metodologi_analisis_data' => 'Pareto'],
            ['nama_metodologi_analisis_data' => 'Bar Diagram'],
        ]);

        DB::table('tbl_metodologi_pengumpulan_data')->insert([
            ['nama_metodologi_pengumpulan_data' => 'Sensus Harian'],
            ['nama_metodologi_pengumpulan_data' => 'Retrospektif'],
        ]);

        DB::table('tbl_publikasi_data')->insert([
            ['nama_publikasi_data' => 'Internal'],
            ['nama_publikasi_data' => 'Eksternal'],
        ]);

        DB::table('tbl_role')->insert([
            ['nama_role' => 'Administrator', 'deskripsi_role' => 'Memiliki akses penuh ke semua fitur dan pengaturan sistem.'],
            ['nama_role' => 'Mutu', 'deskripsi_role' => 'Bertanggung jawab atas manajemen unit tertentu dan pelaporan indikator mutu.'],
            ['nama_role' => 'SIMRS', 'deskripsi_role' => 'Mengawasi pelaksanaan program unit dan analisis data mutu.'],
            ['nama_role' => 'Marketing', 'deskripsi_role' => 'Mengelola data mutu, melakukan analisis, dan menyusun laporan.'],
            ['nama_role' => 'Kasir', 'deskripsi_role' => 'Mengumpulkan data dan melaksanakan prosedur sesuai standar mutu.'],
        ]);

        DB::table('tbl_unit')->insert([
            [
                'id' => 1,
                'kode_unit' => 'UNIT001',
                'nama_unit' => 'Administrator',
                'status_unit' => 'aktif',
            ],
            [
                'id' => 2,
                'kode_unit' => 'UNIT002',
                'nama_unit' => 'Mutu',
                'status_unit' => 'aktif',
            ],
        ]);

        DB::table('tbl_kategori_imprs')->insert([
            ['nama_kategori_imprs' => 'Sasaran Keselamatan Pasien (SKP)'],
            ['nama_kategori_imprs' => 'Klinis Prioritas'],
            ['nama_kategori_imprs' => 'Tujuan Strategis'],
            ['nama_kategori_imprs' => 'Perbaikan system'],
            ['nama_kategori_imprs' => 'Manajemen risiko'],
        ]);
    }
}
