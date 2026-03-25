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
            ['nama_indikator' => 'Kepatuhan Kebersihan Tangan', 'unit_id' => 35, 'target_indikator' => 85, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Penggunaan Alat Pelindung Diri (APD)', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Identifikasi Pasien', 'unit_id' => 50, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi', 'unit_id' => 27, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Waktu Tunggu Rawat Jalan', 'unit_id' => 7, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Penundaan Operasi Elektif', 'unit_id' => 27, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kepatuhan Waktu Visite Dokter', 'unit_id' => 45, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Pelaporan Hasil Kritis Laboratorium', 'unit_id' => 8, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Penggunaan Formularium Nasional', 'unit_id' => 21, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Terhadap Clinical Pathway', 'unit_id' => 2, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Upaya Pencegahan Risiko Pasien Jatuh', 'unit_id' => 50, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kecepatan Waktu Tanggap Komplain', 'unit_id' => 20, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepuasan Pasien', 'unit_id' => 20, 'target_indikator' => 76.61, 'arah_target' => 'lebih_besar'],

            // INDIKATOR PRIORITAS RS
            // Identifikasi Pasien
            ['nama_indikator' => 'Tidak ada kesalahan input jumlah obat dalam E-Resep di Poliklinik', 'unit_id' => 7, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak ada kesalahan Pemberian Obat di Rawat Inap', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak ada kesalahan memasukan obat ke plastik etiket pasien lain di Farmasi', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak ada kesalahan input hasil expertise Radiologi oleh Radiografer ke E-MR', 'unit_id' => 34, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak ada kesalahan pemberian obat pulang pasien rawat inap', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Komunikasi Efektif
            ['nama_indikator' => 'Kepatuhan Verifikasi SBAR instruksi via telepon di Rawat Inap', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Keamanan Obat
            ['nama_indikator' => 'Tidak ada kesalahan cara pemberian obat elektrolit konsentrat di Rawat Inap dan Intensif', 'unit_id' => 17, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Tepat Lokasi dan Prosedur
            ['nama_indikator' => 'Tidak ada kesalahan penulisan lokasi operasi di Formulir Serah Terima Perawat di Kamar Operasi', 'unit_id' => 27, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Risiko Infeksi
            ['nama_indikator' => 'Kepatuhan Cuci Tangan 6 langkah', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Risiko Jatuh
            ['nama_indikator' => 'Tidak ada kejadian Pasien Jatuh di Area Layanan', 'unit_id' => 50, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Pelayanan Klinis Prioritas
            ['nama_indikator' => 'Kepatuhan Tatalaksana Clinical Pothway Pneumonia / BP di Rawat Inap', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Tatalaksanan Clinical Pathway DHF', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            // Tujuan Strategis RS
            ['nama_indikator' => 'kesesuaian waktu tunggu pemulangan pasien rawat inap < 2 jam', 'unit_id' => 45, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Maternity : Ketidaktepatan Waktu Operasi SC Elektif < 45 menit sesuai jadwal', 'unit_id' => 27, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            // Perbaikan Sistem Lintas Unit
            ['nama_indikator' => 'Waktu tunggu Obat lama di Farmasi (Obat Jadi < 25 menit, Obat Racikan < 55 menit)', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kelengkapan berkas Discharge Planning H-1', 'unit_id' => 45, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            // Manajemen Risiko
            ['nama_indikator' => 'Waktu tunggu hasil expertise Radiologi (Foto Thorax < 3 jam, USG < 60 Menit, CT Scan < 6 Jam', 'unit_id' => 34, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],


            /* ================== 1. IGD (18) ================== */
            ['nama_indikator' => 'Respon Time Menjawab Permintaan Rujukan Melalui Sistem Rujukan', 'unit_id' => 18, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Waktu Tunggu Pasien di Instalasi Gawat Darurat', 'unit_id' => 18, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 2. Rawat Jalan (7) ================== */
            ['nama_indikator' => 'Kepatuhan Perawat Melakukan TTV dan Penginputan di ERM', 'unit_id' => 7, 'target_indikator' => 95, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka Kepatuhan Jam Praktek Dokter Spesialis Sesuai Jadwal', 'unit_id' => 7, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka Kejadian Mesin Hemodialisa Rusak Saat Digunakan', 'unit_id' => 33, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Angka Kejadian Hipotensi Intradialisis', 'unit_id' => 33, 'target_indikator' => 20, 'arah_target' => 'lebih_kecil'],

            /* ================== 3. Rawat Inap (45) ================== */
            ['nama_indikator' => 'Tidak Ada Kesalahan Pemberian Alergen pada Pasien Alergi di Rawat Inap', 'unit_id' => 45, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kejadian Pasien Jatuh pada Anak di Ruang Rawat Inap', 'unit_id' => 45, 'target_indikator' => 1, 'arah_target' => 'lebih_kecil'],

            /* ================== 4. Kamar Bersalin (44) ================== */
            ['nama_indikator' => 'Kepatuhan Pengisian Partograf pada Persalinan Kala I Fase Aktif', 'unit_id' => 44, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak Ada Kesalahan Penempelan Stiker Pasien KKebidanan di VK', 'unit_id' => 44, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 5. Casemix (26) ================== */
            ['nama_indikator' => 'Readmission Rate ≤ 30 Hari', 'unit_id' => 26, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kepatuhan Klaim INA-CBGs', 'unit_id' => 26, 'target_indikator' => 95, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Case Mix Index (CMI)', 'unit_id' => 26, 'target_indikator' => 1.2, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Persentase Klaim Pending', 'unit_id' => 26, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Persentase Klaim Ditolak', 'unit_id' => 26, 'target_indikator' => 2, 'arah_target' => 'lebih_kecil'],

            /* ================== 6. Ruang Intensif (17 ICU / 22 NICU) ================== */
            ['nama_indikator' => 'Kepatuhan Assesmen Akhir Kehidupan pada Pasien Terminal', 'unit_id' => 17, 'target_indikator' => 85, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka Ventilator Associated Pneumonia (VAP)', 'unit_id' => 17, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kejadian Iritasi pada Bayi yang dilakukan Fototerapi', 'unit_id' => 22, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],

            /* ================== 7. Keperawatan (50) ================== */
            ['nama_indikator' => 'Kejadian Medication Error Oleh Perawat dan Bidan', 'unit_id' => 50, 'target_indikator' => 1, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Keberhasilan Pemasangan Infus Satu Kali', 'unit_id' => 50, 'target_indikator' => 90, 'arah_target' => 'lebih_kecil'],

            /* ================== 8. Kamar Operasi (27) ================== */
            ['nama_indikator' => 'Keterlambatan Waktu Mulai Operasi >30 Menit', 'unit_id' => 27, 'target_indikator' => 2, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Tidak Ada Kesalahan Penjadwalan Tindakan Operasi', 'unit_id' => 27, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 9. Radiologi (34) ================== */
            ['nama_indikator' => 'Pemenuhan Waktu Tunggu Rontgen Thorax Cito < 30 Menit', 'unit_id' => 34, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Pemenuhan Waktu Tunggu Rontgen Thorax <= 3 Jam', 'unit_id' => 34, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 10. Laboratorium (8) ================== */
            ['nama_indikator' => 'Tidak Ada Kesalahan Pemberian Hasil Laboratorium Pasien Lain', 'unit_id' => 8, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kesesuaian Pemeriksaan Laboratorium sesuai Perjanjian', 'unit_id' => 8, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Pelaporan Hasil Laboratorium Nilai Kritis', 'unit_id' => 8, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],

            /* ================== 11. Gizi (3) ================== */
            ['nama_indikator' => 'Pemenuhan Waktu Menyiapkan dan Menyajikan Menu < 45 menit', 'unit_id' => 3, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Ketepatan Waktu Menyediakan Makanan Katering', 'unit_id' => 3, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 12. Farmasi (21) ================== */
            ['nama_indikator' => 'Tidak Ada Kesalahan Penempelan Etiket Obat di Farmasi Rawat Jalan', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Tidak Ada Kesalahan Penulisan Dosis pada Etiket Obat di Farmasi', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 13. Rekam Medis (41) ================== */
            ['nama_indikator' => 'Kelengkapan Pengisian Informed Consent', 'unit_id' => 41, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kelengkapan Laporan Operasi', 'unit_id' => 41, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 14. Rehabilitasi Medik (29) ================== */
            ['nama_indikator' => 'Kejadian Drop Out Pasien Pelayanan Rehabilitasi Medik', 'unit_id' => 29, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kesalahan Tindakan Terapi Rehabilitasi Medik', 'unit_id' => 29, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kejadian Luka Bakar Akibat Tindakan Elektroterapi', 'unit_id' => 29, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],

            /* ================== 15. AO & Call Center (37 / 20) ================== */
            ['nama_indikator' => 'Persentase Kepatuhan Kedatangan Pasien Kontrol ke Dokter Spesialis Pasca Reminder', 'unit_id' => 37, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Persentase Kesalahan Input Data Identitas Pasien di Bagian Pendaftaran.', 'unit_id' => 37, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Persentase Kesesuaian Booking Online dengan Kehadiran Pasien Rawat Jalan', 'unit_id' => 37, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Persentase Akurasi Penentuan Payor Asuransi di Pendaftaran Rawat Jalan', 'unit_id' => 37, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== 16. Humas (20) ================== */
            ['nama_indikator' => 'Penanganan Langsung Handling Komplain Pasien oleh Masing Masing Unit', 'unit_id' => 20, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Pengisian Angket Kepuasan Pasien Rawat Inap', 'unit_id' => 20, 'target_indikator' => 30, 'arah_target' => 'lebih_besar'],

            /* ================== 17. Sales & Digital Marketing (20) ================== */
            ['nama_indikator' => 'Peningkatan Rujukan Pasien Luar', 'unit_id' => 20, 'target_indikator' => 20, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Peningkatan Jumlah Pengikut Baru dan Jumlah Interaksi pada Konten yang diposting', 'unit_id' => 20, 'target_indikator' => 40, 'arah_target' => 'lebih_besar'],

            /* ================== 18. IPSRS (6) ================== */
            ['nama_indikator' => 'Respon Time Menanggapi Kerusakan Alat', 'unit_id' => 6, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Ketepatan Waktu Pemeliharaan Utilitas', 'unit_id' => 6, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka Keluhan yang Ditindaklanjuti  dari Data Angket Keluhan Terkait Fasilitas', 'unit_id' => 6, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],

            /* ================== ATEM (31 Maintenance) ================== */
            ['nama_indikator' => 'Ketepatan Waktu Preventive Alkes', 'unit_id' => 31, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Respon Time Menanggapi Kerusakan Alkes', 'unit_id' => 31, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],

            /* ================== Cleaning Service (4 Rumah Tangga) ================== */
            ['nama_indikator' => 'Angka Komplain / Keluhan dari Pasien (RI / RJ) terhadap Kebersihan Kamar Rawat Inap, Publik Area, Toilet Umum, dan Lingkungan Rumah Sakit (maksimal 15 komplain setiap bulan)', 'unit_id' => 4, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            /* ================== Laundry (51 Laundry) ================== */
            ['nama_indikator' => 'Ketersediaan Linen Untuk Pasien Sesuai dengan Parstock Untuk Jumlah Bed yang Tersedia Dalam Waktu 1 x 24 jam', 'unit_id' => 51, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],
            /* ================== Security (5 Admin umum & alih daya) ================== */
            ['nama_indikator' => 'Angka Penyelesaian Laporan kasus yang ditangani Security maksimal 3x24 jam sejak penerimaan laporan', 'unit_id' => 5, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            /* ================== Parkir (5 Admin umum & alih daya) ================== */
            ['nama_indikator' => 'Tidak ada kejadian kehilangan aksesoris kendaraan yang terparkir di RS Azra ', 'unit_id' => 5, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            /* ================== KESLING (46 Kesehatan lingkungan) ================== */
            ['nama_indikator' => 'Ketepatan Jadwal Pengangkutan Limbah B3 Medis di TPS LB3', 'unit_id' => 46, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== Admin Perizinan & Outsource (5) ================== */
            ['nama_indikator' => 'Kepatuhan Ceklis Harian Kendaraan', 'unit_id' => 5, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan Security Melaksanakan Patroli', 'unit_id' => 5, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Response Time Sopir dalam On Call', 'unit_id' => 9, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== SIRS (23 IT) ================== */
            ['nama_indikator' => 'Penyelesaian terhadap permintaan perbaikan fasilitas SIMRS < 10 menit', 'unit_id' => 23, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== SDM (36) ================== */
            ['nama_indikator' => 'Persentase Karyawan dengan Jam Pelatihan < 20 Jam (Masa Kerja > 6 Bulan)', 'unit_id' => 36, 'target_indikator' => 85, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Persentase Proses Rekrutmen Level Staf yang Diselesaikan Tepat Waktu', 'unit_id' => 36, 'target_indikator' => 85, 'arah_target' => 'lebih_besar'],

            /* ================== Legal (47) ================== */
            ['nama_indikator' => 'Ketepatan Waktu Penyusunan dan Review Perjanjian Manajerial (Contract)', 'unit_id' => 47, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Waktu Respon Terhadap Permintaan Revisi Dokumen Hukum RS / Perjanjian (Contract) < 72 Jam', 'unit_id' => 47, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== Kasir & Pentarifan (30 Kasir) ================== */
            ['nama_indikator' => 'Kecepatan Waktu Tunggu Perhitungan Pasien RI < 2 Jam', 'unit_id' => 30, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== AR (43 Keuangan) ================== */
            ['nama_indikator' => 'Penagihan Klaim Asuransi', 'unit_id' => 43, 'target_indikator' => 5, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Pemantauan Aging Piutang Asuransi', 'unit_id' => 43, 'target_indikator' => 10, 'arah_target' => 'lebih_kecil'],

            /* ================== Akuntansi & Pajak (40) ================== */
            ['nama_indikator' => 'Ketepatan penyajian nilai pendapatan BPJS dalam laporan keuangan', 'unit_id' => 40, 'target_indikator' => 30, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Ketepatan Waktu dalam Penyusunan, Pembayaran dan Pelaporan Pajak', 'unit_id' => 40, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== Procurement (28 / 21) ================== */
            ['nama_indikator' => 'Ketepatan dalam Pengadaan Logistik Umum', 'unit_id' => 28, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Ketepatan dalam Pengadaan Sediaan Farmasi', 'unit_id' => 21, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== PPI (35) ================== */
            ['nama_indikator' => 'Tidak adanya Sterirecord Expired di unit Pelayanan', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka Insiden Petugas Tertusuk Benda Tajam dan Jarum', 'unit_id' => 35, 'target_indikator' => 0, 'arah_target' => 'lebih_kecil'],
            ['nama_indikator' => 'Kepatuhan Penempatan Pasien Di Ruang Isolasi Sesuai Indikasi', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kepatuhan petugas memilah limbah medis sesuai jenisnya di unit pelayanan', 'unit_id' => 35, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kesesuaian suhu penyimpanan bahan makanan didalam Chiller', 'unit_id' => 3, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],

            /* ================== K3RS (31 / 36) ================== */
            ['nama_indikator' => 'Kelengkapan PCRA dan ICRA pada setiap Renovasi di RS Azra', 'unit_id' => 31, 'target_indikator' => 100, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Kecepatan waktu pelaporan kecelakaan kerja staf RS Azra kurang dari 2 x 24 jam', 'unit_id' => 36, 'target_indikator' => 90, 'arah_target' => 'lebih_besar'],
            ['nama_indikator' => 'Angka keterampilan staf dalam penggunaan APAR', 'unit_id' => 36, 'target_indikator' => 80, 'arah_target' => 'lebih_besar'],



        ];

        foreach ($indikators as $indikator) {
            DB::table('tbl_indikator')->insert([
                'nama_indikator' => $indikator['nama_indikator'],
                'unit_id' => $indikator['unit_id'] ?? 1,
                'arah_target' => $indikator['arah_target'] ?? 'lebih_besar',
                'target_indikator' => $indikator['target_indikator'] ?? null,
                'target_min' => $indikator['target_min'] ?? null,
                'target_max' => $indikator['target_max'] ?? null,
                'status_indikator' => 'aktif',
                'kamus_indikator_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
