<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Indikator extends Seeder
{
    public function run(): void
    {
        $indikators = [

            // Indikator Nasional
            ['nama_indikator' => 'Kepatuhan Kebersihan Tangan', 'unit_id' => 37, 'target_indikator' => 85, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan Alat Pelindung Diri (APD)', 'unit_id' => 37, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan identifikasi pasien', 'unit_id' => 9, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi', 'unit_id' => 10, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu tunggu rawat jalan', 'unit_id' => 4, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Penundaan operasi elektif', 'unit_id' => 10, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan waktu visite dokter', 'unit_id' => 5, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pelaporan hasil kritis laboratorium', 'unit_id' => 12, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan formularium nasional', 'unit_id' => 14, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan terhadap Clinical Pathway', 'unit_id' => 2, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan upaya pencegahan risiko pasien jatuh', 'unit_id' => 9, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kecepatan waktu tanggap komplain', 'unit_id' => 18, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepuasan pasien', 'unit_id' => 18, 'target_indikator' => 76.61, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 1. IGD (3) ================== */
            ['nama_indikator' => 'Respon Time Menjawab Permintaan Rujukan Melalui Sistem Rujukan', 'unit_id' => 3, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu tunggu pasien di Instalasi Gawat Darurat', 'unit_id' => 3, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 2. Rawat Jalan (4) ================== */
            ['nama_indikator' => 'Kepatuhan perawat melakukan TTV dan penginputan di ERM', 'unit_id' => 4, 'target_indikator' => 95, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Kepatuhan Jam Praktek Dokter Spesialis Sesuai Jadwal', 'unit_id' => 4, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Kejadian Mesin Hemodialisa Rusak Saat Digunakan', 'unit_id' => 4, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Kejadian Hipotensi Intradialisis', 'unit_id' => 4, 'target_indikator' => 20, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 3. Rawat Inap (5) ================== */
            ['nama_indikator' => 'Tidak ada kesalahan pemberian Alergen pada pasien alergi di Rawat Inap', 'unit_id' => 5, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kejadian Pasien jatuh pada anak diruang rawat Inap', 'unit_id' => 5, 'target_indikator' => 1, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 4. Kamar Bersalin (6) ================== */
            ['nama_indikator' => 'Kepatuhan Pengisian Partograf pada Persalinan Kala I Fase Aktif', 'unit_id' => 6, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak ada kesalahan penempelan stiker pasien Kebidanan di VK', 'unit_id' => 6, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 5. Casemix (7) ================== */
            ['nama_indikator' => 'Readmission Rate ≤ 30 Hari', 'unit_id' => 7, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Klaim INA-CBGs', 'unit_id' => 7, 'target_indikator' => 95, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Case Mix Index (CMI)', 'unit_id' => 7, 'target_indikator' => 1.2, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Persentase Klaim Pending', 'unit_id' => 7, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Persentase Klaim Ditolak', 'unit_id' => 7, 'target_indikator' => 2, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 6. Ruang Intensif (8) ================== */
            ['nama_indikator' => 'Kepatuhan assesmen akhir kehidupan pada pasien terminal', 'unit_id' => 8, 'target_indikator' => 85, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Ventilator Associated Pneumonia (VAP)', 'unit_id' => 8, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kejadian Iritasi pada bayi yang dilakukan fototerapi', 'unit_id' => 8, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 7. Keperawatan (9) ================== */
            ['nama_indikator' => 'Kejadian medication error oleh perawat dan bidan', 'unit_id' => 9, 'target_indikator' => 1, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Keberhasilan Pemasangan Infus satu kali', 'unit_id' => 9, 'target_indikator' => 90, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 8. Kamar Operasi (10) ================== */
            ['nama_indikator' => 'Keterlambatan waktu mulai operasi >30 menit', 'unit_id' => 10, 'target_indikator' => 2, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak ada kesalahan penjadwalan tindakan operasi', 'unit_id' => 10, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 9. Radiologi (11) ================== */
            ['nama_indikator' => 'Pemenuhan Waktu Tunggu Rontgen Thorax Cito < 30 Menit', 'unit_id' => 11, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pemenuhan Waktu Tunggu Rontgen Thorax <= 3 Jam', 'unit_id' => 11, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 10. Laboratorium (12) ================== */
            ['nama_indikator' => 'Tidak ada kesalahan pemberian hasil Laboratorium pasien lain', 'unit_id' => 12, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian Pemeriksaan Laboratorium sesuai Perjanjian', 'unit_id' => 12, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Pelaporan Hasil Laboratorium Nilai Kritis', 'unit_id' => 12, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 11. Gizi (13) ================== */
            ['nama_indikator' => 'Pemenuhan Waktu Menyiapkan dan Menyajikan Menu <45 menit', 'unit_id' => 13, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan waktu menyediakan makanan katering', 'unit_id' => 13, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 12. Farmasi (14) ================== */
            ['nama_indikator' => 'Tidak ada kesalahan Penempelan Etiket Obat di Farmasi Rawat Jalan', 'unit_id' => 14, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak ada kesalahan penulisan dosis pada etiket obat di Farmasi', 'unit_id' => 14, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 13. Rekam Medis (15) ================== */
            ['nama_indikator' => 'Kelengkapan Pengisian Informed Consent', 'unit_id' => 15, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kelengkapan Laporan Operasi', 'unit_id' => 15, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 14. Rehabilitasi Medik (16) ================== */
            ['nama_indikator' => 'Kejadian Drop Out Pasien Pelayanan Rehabilitasi Medik', 'unit_id' => 16, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesalahan Tindakan Terapi Rehabilitasi Medik', 'unit_id' => 16, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kejadian Luka Bakar Akibat Tindakan Elektroterapi', 'unit_id' => 16, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== 15. AO & Call Center (17) ================== */
            ['nama_indikator' => 'Kepatuhan Kedatangan Pasien Kontrol Pasca Reminder', 'unit_id' => 17, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesalahan Input Data Identitas Pasien di Pendaftaran', 'unit_id' => 17, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian Booking Online dengan Kehadiran Pasien', 'unit_id' => 17, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Akurasi Penentuan Payor Asuransi', 'unit_id' => 17, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 16. Humas (18) ================== */
            ['nama_indikator' => 'Handling komplain pasien oleh masing masing unit', 'unit_id' => 18, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pengisian angket kepuasan pasien rawat inap', 'unit_id' => 18, 'target_indikator' => 30, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 17. Sales & Digital Marketing (19) ================== */
            ['nama_indikator' => 'Peningkatan Rujukan Pasien Luar', 'unit_id' => 19, 'target_indikator' => 20, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Peningkatan jumlah pengikut dan interaksi konten', 'unit_id' => 19, 'target_indikator' => 40, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== 18. IPSRS (20) ================== */
            ['nama_indikator' => 'Respon time menanggapi kerusakan alat', 'unit_id' => 20, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan waktu pemeliharaan utilitas', 'unit_id' => 20, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Keluhan fasilitas yang ditindaklanjuti', 'unit_id' => 20, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== ATEM (21) ================== */
            ['nama_indikator' => 'Ketepatan waktu preventive alkes', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Respon time menanggapi kerusakan alkes', 'unit_id' => 21, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Cleaning Service (23) ================== */
            ['nama_indikator' => 'Komplain kebersihan kamar dan area publik', 'unit_id' => 23, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== Laundry (24) ================== */
            ['nama_indikator' => 'Ketersediaan linen sesuai parstock 1x24 jam', 'unit_id' => 24, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Security (25) ================== */
            ['nama_indikator' => 'Penyelesaian laporan kasus maksimal 3x24 jam', 'unit_id' => 25, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Parkir (26) ================== */
            ['nama_indikator' => 'Tidak ada kehilangan aksesoris kendaraan', 'unit_id' => 26, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== KESLING (27) ================== */
            ['nama_indikator' => 'Ketepatan jadwal pengangkutan Limbah B3 Medis', 'unit_id' => 27, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Admin Perizinan & Outsource (28) ================== */
            ['nama_indikator' => 'Kepatuhan Ceklis Harian Kendaraan', 'unit_id' => 28, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Security Melaksanakan Patroli', 'unit_id' => 28, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Response Time Sopir dalam On Call', 'unit_id' => 28, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== SIRS (29) ================== */
            ['nama_indikator' => 'Penyelesaian terhadap permintaan perbaikan fasilitas SIMRS < 10 menit', 'unit_id' => 29, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== SDM (30) ================== */
            ['nama_indikator' => 'Persentase Karyawan dengan Jam Pelatihan < 20 Jam (Masa Kerja > 6 Bulan)', 'unit_id' => 30, 'target_indikator' => 85, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Persentase Proses Rekrutmen Level Staf yang Diselesaikan Tepat Waktu', 'unit_id' => 30, 'target_indikator' => 85, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Legal (31) ================== */
            ['nama_indikator' => 'Ketepatan Waktu Penyusunan dan Review Perjanjian Manajerial (Contract)', 'unit_id' => 31, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu Respon Terhadap Permintaan Revisi Dokumen Hukum RS / Perjanjian (Contract) < 72 Jam', 'unit_id' => 31, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Kasir & Pentarifan (32) ================== */
            ['nama_indikator' => 'Kecepatan Waktu Tunggu Perhitungan Pasien RI < 2 Jam', 'unit_id' => 32, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== AR (33) ================== */
            ['nama_indikator' => 'Penagihan Klaim Asuransi', 'unit_id' => 33, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pemantauan Aging Piutang Asuransi', 'unit_id' => 33, 'target_indikator' => 10, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],

            /* ================== Akuntansi & Pajak (34) ================== */
            ['nama_indikator' => 'Ketepatan penyajian nilai pendapatan BPJS dalam laporan keuangan', 'unit_id' => 34, 'target_indikator' => 30, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu dalam Penyusunan, Pembayaran dan Pelaporan Pajak', 'unit_id' => 34, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== Procurement (35) ================== */
            ['nama_indikator' => 'Ketepatan dalam Pengadaan Logistik Umum', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan dalam Pengadaan Sediaan Farmasi', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== PPI (36) ================== */
            ['nama_indikator' => 'Tidak adanya Sterirecord Expired di unit Pelayanan', 'unit_id' => 36, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Insiden Petugas Tertusuk Benda Tajam dan Jarum', 'unit_id' => 36, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Penempatan Pasien Di Ruang Isolasi Sesuai Indikasi', 'unit_id' => 36, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan petugas memilah limbah medis sesuai jenisnya di unit pelayanan', 'unit_id' => 36, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian suhu penyimpanan bahan makanan didalam Chiller', 'unit_id' => 36, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

            /* ================== K3RS (37) ================== */
            ['nama_indikator' => 'Kelengkapan PCRA dan ICRA pada setiap Renovasi di RS Azra', 'unit_id' => 37, 'target_indikator' => 100, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kecepatan waktu pelaporan kecelakaan kerja staf RS Azra kurang dari 2 x 24 jam', 'unit_id' => 37, 'target_indikator' => 90, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka keterampilan staf dalam penggunaan APAR', 'unit_id' => 37, 'target_indikator' => 80, 'arah_target' => 'lebih_besar', 'tipe_indikator' => 'lokal'],

        ];

        foreach ($indikators as $indikator) {
            DB::table('tbl_indikator')->insert([
                'nama_indikator' => $indikator['nama_indikator'],
                'unit_id' => $indikator['unit_id'] ?? 1,
                'arah_target' => $indikator['arah_target'] ?? 'lebih_besar',
                'target_indikator' => $indikator['target_indikator'] ?? null,
                'target_min' => $indikator['target_min'] ?? null,
                'target_max' => $indikator['target_max'] ?? null,
                'tipe_indikator' => $indikator['tipe_indikator'],
                'status_indikator' => 'aktif',
                'kamus_indikator_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
