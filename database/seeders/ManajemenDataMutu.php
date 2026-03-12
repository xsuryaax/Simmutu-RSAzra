<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
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
            ['nama_role' => 'Tim Mutu', 'deskripsi_role' => 'Bertanggung jawab atas manajemen unit tertentu dan pelaporan indikator mutu.'],
            ['nama_role' => 'Validator', 'deskripsi_role' => 'Menginput dan melaporkan data indikator sesuai unit masing-masing.'],
            ['nama_role' => 'Pengumpul Data', 'deskripsi_role' => 'Menginput dan melaporkan data indikator sesuai unit masing-masing.'],
        ]);

        DB::table('tbl_unit')->insert([
            ['id' => 1, 'kode_unit' => 'UNIT001', 'nama_unit' => 'Administrator', 'status_unit' => 'aktif'],
            ['id' => 2, 'kode_unit' => 'UNIT002', 'nama_unit' => 'Mutu', 'status_unit' => 'aktif'],
            ['id' => 3, 'kode_unit' => 'UNIT003', 'nama_unit' => 'IGD', 'status_unit' => 'aktif'],
            ['id' => 4, 'kode_unit' => 'UNIT004', 'nama_unit' => 'Rawat Jalan, hemodialisa, MCU, Homecare', 'status_unit' => 'aktif'],
            ['id' => 5, 'kode_unit' => 'UNIT005', 'nama_unit' => 'Rawat Inap', 'status_unit' => 'aktif'],
            ['id' => 6, 'kode_unit' => 'UNIT006', 'nama_unit' => 'Kamar Bersalin', 'status_unit' => 'aktif'],
            ['id' => 7, 'kode_unit' => 'UNIT007', 'nama_unit' => 'Casemix', 'status_unit' => 'aktif'],
            ['id' => 8, 'kode_unit' => 'UNIT008', 'nama_unit' => 'Ruang Intensif', 'status_unit' => 'aktif'],
            ['id' => 9, 'kode_unit' => 'UNIT009', 'nama_unit' => 'Keperawatan', 'status_unit' => 'aktif'],
            ['id' => 10, 'kode_unit' => 'UNIT010', 'nama_unit' => 'Kamar Operasi', 'status_unit' => 'aktif'],
            ['id' => 11, 'kode_unit' => 'UNIT011', 'nama_unit' => 'Radiologi', 'status_unit' => 'aktif'],
            ['id' => 12, 'kode_unit' => 'UNIT012', 'nama_unit' => 'Labolatorium', 'status_unit' => 'aktif'],
            ['id' => 13, 'kode_unit' => 'UNIT013', 'nama_unit' => 'Gizi', 'status_unit' => 'aktif'],
            ['id' => 14, 'kode_unit' => 'UNIT014', 'nama_unit' => 'Farmasi', 'status_unit' => 'aktif'],
            ['id' => 15, 'kode_unit' => 'UNIT015', 'nama_unit' => 'Rekam Medis', 'status_unit' => 'aktif'],
            ['id' => 16, 'kode_unit' => 'UNIT016', 'nama_unit' => 'Rehabilitasi Medik', 'status_unit' => 'aktif'],
            ['id' => 17, 'kode_unit' => 'UNIT017', 'nama_unit' => 'AO & Call Center', 'status_unit' => 'aktif'],
            ['id' => 18, 'kode_unit' => 'UNIT018', 'nama_unit' => 'Humas & Customer Care', 'status_unit' => 'aktif'],
            ['id' => 19, 'kode_unit' => 'UNIT019', 'nama_unit' => 'Sales & Digital marketing', 'status_unit' => 'aktif'],
            ['id' => 20, 'kode_unit' => 'UNIT020', 'nama_unit' => 'IPSRS', 'status_unit' => 'aktif'],
            ['id' => 21, 'kode_unit' => 'UNIT021', 'nama_unit' => 'ATEM', 'status_unit' => 'aktif'],
            ['id' => 22, 'kode_unit' => 'UNIT022', 'nama_unit' => 'Rumah Tangga', 'status_unit' => 'aktif'],
            ['id' => 23, 'kode_unit' => 'UNIT023', 'nama_unit' => 'Cleaning Service', 'status_unit' => 'aktif'],
            ['id' => 24, 'kode_unit' => 'UNIT024', 'nama_unit' => 'Laundry', 'status_unit' => 'aktif'],
            ['id' => 25, 'kode_unit' => 'UNIT025', 'nama_unit' => 'Keamanan/Security', 'status_unit' => 'aktif'],
            ['id' => 26, 'kode_unit' => 'UNIT026', 'nama_unit' => 'Parkir', 'status_unit' => 'aktif'],
            ['id' => 27, 'kode_unit' => 'UNIT027', 'nama_unit' => 'KESLING', 'status_unit' => 'aktif'],
            ['id' => 28, 'kode_unit' => 'UNIT028', 'nama_unit' => 'Admin Perizinan & Outsource', 'status_unit' => 'aktif'],
            ['id' => 29, 'kode_unit' => 'UNIT029', 'nama_unit' => 'SIRS', 'status_unit' => 'aktif'],
            ['id' => 30, 'kode_unit' => 'UNIT030', 'nama_unit' => 'SDM', 'status_unit' => 'aktif'],
            ['id' => 31, 'kode_unit' => 'UNIT031', 'nama_unit' => 'Legal', 'status_unit' => 'aktif'],
            ['id' => 32, 'kode_unit' => 'UNIT032', 'nama_unit' => 'Keuangan', 'status_unit' => 'aktif'],
            ['id' => 33, 'kode_unit' => 'UNIT033', 'nama_unit' => 'Kasit dan Pentarifan', 'status_unit' => 'aktif'],
            ['id' => 34, 'kode_unit' => 'UNIT034', 'nama_unit' => 'AR', 'status_unit' => 'aktif'],
            ['id' => 35, 'kode_unit' => 'UNIT035', 'nama_unit' => 'Akuntansi & Pajak', 'status_unit' => 'aktif'],
            ['id' => 36, 'kode_unit' => 'UNIT036', 'nama_unit' => 'Procurement', 'status_unit' => 'aktif'],
            ['id' => 37, 'kode_unit' => 'UNIT037', 'nama_unit' => 'PPI', 'status_unit' => 'aktif'],
            ['id' => 38, 'kode_unit' => 'UNIT038', 'nama_unit' => 'K3RS', 'status_unit' => 'aktif'],
            

        ]);

        DB::table('tbl_periode')->insert([
            [
                'nama_periode' => 'Periode 1',
                'tahun' => 2025,
                'tanggal_mulai' => '2025-01-01',
                'tanggal_selesai' => '2025-12-31',
                'deadline' => 5,
                'status_deadline' => 0,
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('tbl_kategori_imprs')->insert([
            ['nama_kategori_imprs' => 'Sasaran Keselamatan Pasien (SKP)'],
            ['nama_kategori_imprs' => 'Identifikasi Pasien'],
            ['nama_kategori_imprs' => 'Komunikasi Efektif'],
            ['nama_kategori_imprs' => 'Keamanan Obat'],
            ['nama_kategori_imprs' => 'Tepat Lokasi dan Prosedur'],
            ['nama_kategori_imprs' => 'Risiko Infeksi'],
            ['nama_kategori_imprs' => 'Risiko Jatuh'],
            ['nama_kategori_imprs' => 'Pelayanan Klinis Prioritas'],
            ['nama_kategori_imprs' => 'Tujuan Strategis RS'],
            ['nama_kategori_imprs' => 'Perbaikan Sistem Lintas Unit'],
            ['nama_kategori_imprs' => 'Manajemen Resiko'],
        ]);
    }
}
