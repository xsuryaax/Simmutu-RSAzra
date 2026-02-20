<?php

namespace Database\Seeders;

use Carbon\Carbon;
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

        DB::table('tbl_periode_analisis_data')->insert([
            ['nama_periode_analisis_data' => 'Bulanan'],
            ['nama_periode_analisis_data' => 'Triwulanan'],
            ['nama_periode_analisis_data' => 'Tahunan'],
        ]);

        DB::table('tbl_periode_pengumpulan_data')->insert([
            ['nama_periode_pengumpulan_data' => 'Harian'],
            ['nama_periode_pengumpulan_data' => 'Mingguan'],
            ['nama_periode_pengumpulan_data' => 'Bulanan'],
        ]);

        DB::table('tbl_penyajian_data')->insert([
            ['nama_penyajian_data' => 'Statistik'],
            ['nama_penyajian_data' => 'Run Chart'],
            ['nama_penyajian_data' => 'Control Chart'],
            ['nama_penyajian_data' => 'Pareto'],
            ['nama_penyajian_data' => 'Bar Diagram'],
        ]);

        DB::table('tbl_metode_pengumpulan_data')->insert([
            ['nama_metode_pengumpulan_data' => 'Sensus Harian'],
            ['nama_metode_pengumpulan_data' => 'Retrospektif'],
        ]);

        DB::table('tbl_jenis_indikator')->insert([
            ['nama_jenis_indikator' => 'Struktur'],
            ['nama_jenis_indikator' => 'Proses'],
            ['nama_jenis_indikator' => 'Output'],
            ['nama_jenis_indikator' => 'Outcome'],
        ]);

        DB::table('tbl_role')->insert([
            ['nama_role' => 'Administrator', 'deskripsi_role' => 'Memiliki akses penuh ke semua fitur dan pengaturan sistem.'],
            ['nama_role' => 'Mutu', 'deskripsi_role' => 'Bertanggung jawab atas manajemen unit tertentu dan pelaporan indikator mutu.'],
            ['nama_role' => 'Validator', 'deskripsi_role' => 'Menginput dan melaporkan data indikator sesuai unit masing-masing.'],
            ['nama_role' => 'Pengumpul Data', 'deskripsi_role' => 'Menginput dan melaporkan data indikator sesuai unit masing-masing.'],
        ]);

        DB::table('tbl_unit')->insert([
            ['id' => 1, 'kode_unit' => 'UNIT001', 'nama_unit' => 'Administrator', 'status_unit' => 'aktif'],
            ['id' => 2, 'kode_unit' => 'UNIT002', 'nama_unit' => 'Mutu', 'status_unit' => 'aktif'],
            ['id' => 3, 'kode_unit' => 'UNIT003', 'nama_unit' => 'IGD', 'status_unit' => 'aktif'],
            ['id' => 4, 'kode_unit' => 'UNIT004', 'nama_unit' => 'LAUNDRY & CSSD', 'status_unit' => 'aktif'],
            ['id' => 5, 'kode_unit' => 'UNIT005', 'nama_unit' => 'LAB', 'status_unit' => 'aktif'],
            ['id' => 6, 'kode_unit' => 'UNIT006', 'nama_unit' => 'REKAM MEDIS', 'status_unit' => 'aktif'],
            ['id' => 7, 'kode_unit' => 'UNIT007', 'nama_unit' => 'RADIOLOGI', 'status_unit' => 'aktif'],
            ['id' => 8, 'kode_unit' => 'UNIT008', 'nama_unit' => 'KEPERAWATAN', 'status_unit' => 'aktif'],
            ['id' => 9, 'kode_unit' => 'UNIT009', 'nama_unit' => 'UMUM & OUTSOURCE', 'status_unit' => 'aktif'],
            ['id' => 10, 'kode_unit' => 'UNIT010', 'nama_unit' => 'IPSRS Alat Medis', 'status_unit' => 'aktif'],
            ['id' => 11, 'kode_unit' => 'UNIT011', 'nama_unit' => 'LIMBAH', 'status_unit' => 'aktif'],
            ['id' => 12, 'kode_unit' => 'UNIT012', 'nama_unit' => 'IPSRS Umum', 'status_unit' => 'aktif'],
            ['id' => 13, 'kode_unit' => 'UNIT013', 'nama_unit' => 'KEUANGAN', 'status_unit' => 'aktif'],
            ['id' => 14, 'kode_unit' => 'UNIT014', 'nama_unit' => 'RJ & HD', 'status_unit' => 'aktif'],
            ['id' => 15, 'kode_unit' => 'UNIT015', 'nama_unit' => 'AKUNTANSI', 'status_unit' => 'aktif'],
            ['id' => 16, 'kode_unit' => 'UNIT016', 'nama_unit' => 'PROCUREMENT MEDIS', 'status_unit' => 'aktif'],
            ['id' => 17, 'kode_unit' => 'UNIT017', 'nama_unit' => 'PROCUREMENT UMUM', 'status_unit' => 'aktif'],
            ['id' => 18, 'kode_unit' => 'UNIT018', 'nama_unit' => 'LEGAL', 'status_unit' => 'aktif'],
            ['id' => 19, 'kode_unit' => 'UNIT019', 'nama_unit' => 'HUMAS & CUSTOMER CARE', 'status_unit' => 'aktif'],
            ['id' => 20, 'kode_unit' => 'UNIT020', 'nama_unit' => 'SALES & DIGITAL MARKETING', 'status_unit' => 'aktif'],
            ['id' => 21, 'kode_unit' => 'UNIT021', 'nama_unit' => 'AO & CALL CENTER', 'status_unit' => 'aktif'],
            ['id' => 22, 'kode_unit' => 'UNIT022', 'nama_unit' => 'SIMRS', 'status_unit' => 'aktif'],
            ['id' => 23, 'kode_unit' => 'UNIT023', 'nama_unit' => 'K3RS', 'status_unit' => 'aktif'],
            ['id' => 24, 'kode_unit' => 'UNIT024', 'nama_unit' => 'PROJECT UMUM', 'status_unit' => 'aktif'],
            ['id' => 25, 'kode_unit' => 'UNIT025', 'nama_unit' => 'RI', 'status_unit' => 'aktif'],
            ['id' => 26, 'kode_unit' => 'UNIT026', 'nama_unit' => 'PPI', 'status_unit' => 'aktif'],
            ['id' => 27, 'kode_unit' => 'UNIT027', 'nama_unit' => 'JKN', 'status_unit' => 'aktif'],
            ['id' => 28, 'kode_unit' => 'UNIT028', 'nama_unit' => 'SPI', 'status_unit' => 'aktif'],
            ['id' => 29, 'kode_unit' => 'UNIT029', 'nama_unit' => 'INTENSIF', 'status_unit' => 'aktif'],
            ['id' => 30, 'kode_unit' => 'UNIT030', 'nama_unit' => 'BEDAH', 'status_unit' => 'aktif'],
            ['id' => 31, 'kode_unit' => 'UNIT031', 'nama_unit' => 'PERSALINAN DAN PERINATOLOGI', 'status_unit' => 'aktif'],
            ['id' => 32, 'kode_unit' => 'UNIT032', 'nama_unit' => 'REHAB MEDIK & KTKA', 'status_unit' => 'aktif'],
            ['id' => 33, 'kode_unit' => 'UNIT033', 'nama_unit' => 'FARMASI', 'status_unit' => 'aktif'],
            ['id' => 34, 'kode_unit' => 'UNIT034', 'nama_unit' => 'GIZI', 'status_unit' => 'aktif'],
        ]);

        DB::table('tbl_periode')->insert([
            [
                'nama_periode' => 'Periode 1',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'deadline' => 5,
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
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
