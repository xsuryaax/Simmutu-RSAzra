<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date_start = '2026-01-01 00:00:00';

        $raw_data = [
            // 1. IGD (Unit 18)
            ['unit_id' => 18, 'nama' => 'Kemampuan menangani life saving anak dan dewasa', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Jam buka pelayanan gawat darurat', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Pemberi pelayanan gawat darurat yang bersertifikat (BLS/PPGD/GELS/ALS)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Ketersediaan tim penanggulangan bencana', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Waktu tanggap pelayanan Dokter di Gawat Darurat (≤ 5 menit)', 'target' => 5, 'arah' => 'lebih_kecil'],
            ['unit_id' => 18, 'nama' => 'Kepuasan pelanggan IGD', 'target' => 70, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Kematian pasien < 24 jam', 'target' => 0.2, 'arah' => 'lebih_kecil'], // 2 per 1000 = 0.2%
            ['unit_id' => 18, 'nama' => 'Khusus untuk RS Jiwa pasien dapat ditenangkan dalam waktu ≤ 48 jam', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 18, 'nama' => 'Tidak adanya pasien yang diharuskan membayar uang muka', 'target' => 100, 'arah' => 'lebih_besar'],

            // 2. Rawat Jalan (Unit 7)
            ['unit_id' => 7, 'nama' => 'Pemberi pelayanan di klinik spesialis', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Ketersediaan pelayanan rawat jalan (Anak, Dalam, Kebidanan, Bedah)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Ketersediaan pelayanan rawat jalan di RSJ (NAPZA, Psikotik, Nerotik, Organik)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Buka pelayanan sesuai ketentuan', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Waktu tunggu di rawat jalan (≤ 60 menit)', 'target' => 60, 'arah' => 'lebih_kecil'],
            ['unit_id' => 7, 'nama' => 'Kepuasan Pelanggan pada Rawat Jalan', 'target' => 90, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Pasien rawat jalan tuberkulosis yang ditangani dengan strategi DOTS', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Penegakan diagnosis TB melalui pemeriksaan mikroskopis TB', 'target' => 60, 'arah' => 'lebih_besar'],
            ['unit_id' => 7, 'nama' => 'Terlaksananya kegiatan pencatatan dan pelaporan TB di RJ RS', 'target' => 60, 'arah' => 'lebih_besar'],

            // 3. Rawat Inap (Unit 45)
            ['unit_id' => 45, 'nama' => 'Pemberi pelayanan rawat inap (Dr.Sp, Prwt D3)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Dokter penanggung jawab pasien rawat inap', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Ketersediaan pelayanan rawat inap (9 Spesialis Utama)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Jam visite dokter spesialis (08:00 - 14:00)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Kejadian infeksi pasca operasi', 'target' => 1.5, 'arah' => 'lebih_kecil'],
            ['unit_id' => 45, 'nama' => 'Angka kejadian infeksi nosokomial/ phlebitis', 'target' => 1.5, 'arah' => 'lebih_kecil'],
            ['unit_id' => 45, 'nama' => 'Tidak adanya kejadian pasien jatuh yang berakibat kecacatan/kematian', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Kematian Pasien > 48 Jam', 'target' => 0.24, 'arah' => 'lebih_kecil'],
            ['unit_id' => 45, 'nama' => 'Kejadian pulang paksa', 'target' => 5, 'arah' => 'lebih_kecil'],
            ['unit_id' => 45, 'nama' => 'Kepuasan Pelanggan Rawat Inap', 'target' => 90, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Penegakan diagnosis TB melalui pemeriksaan mikroskopis TB (RI)', 'target' => 60, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Pasien rawat Inap tuberkulosis yang ditangani dengan strategi DOTS (RI)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 45, 'nama' => 'Terlaksananya kegiatan pencatatan dan pelaporan TB di RS (RI)', 'target' => 60, 'arah' => 'lebih_besar'],

            // 4. Bedah (Unit 27)
            ['unit_id' => 27, 'nama' => 'Waktu tunggu operasi elektif (≤ 2 hari)', 'target' => 2, 'arah' => 'lebih_kecil'],
            ['unit_id' => 27, 'nama' => 'Kejadian kematian di meja operasi', 'target' => 1, 'arah' => 'lebih_kecil'],
            ['unit_id' => 27, 'nama' => 'Tidak adanya kejadian operasi salah sisi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 27, 'nama' => 'Tidak adanya kejadian operasi salah orang', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 27, 'nama' => 'Tidak adanya kejadian salah tindakan pada operasi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 27, 'nama' => 'Tidak adanya kejadian tertinggalnya benda asing pada tubuh pasien', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 27, 'nama' => 'Komplikasi anastesi (Overdosis, Reaksi, Salah Penempatan ETT)', 'target' => 6, 'arah' => 'lebih_kecil'],

            // 5. Persalinan & Perinatologi (Unit 44)
            ['unit_id' => 44, 'nama' => 'Kejadian kematian ibu karena persalinan (Perdarahan)', 'target' => 1, 'arah' => 'lebih_kecil'],
            ['unit_id' => 44, 'nama' => 'Kejadian kematian ibu karena persalinan (Pre-eklampsia)', 'target' => 30, 'arah' => 'lebih_kecil'],
            ['unit_id' => 44, 'nama' => 'Kejadian kematian ibu karena persalinan (Sepsis)', 'target' => 0.2, 'arah' => 'lebih_kecil'],
            ['unit_id' => 44, 'nama' => 'Pemberi pelayanan persalinan normal (SpOG)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Pemberi pelayanan persalinan dengan penyulit oleh Tim Ponek', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Pemberi pelayanan persalinan dengan tindakan operasi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Kemampuan menangani BBLR 1500 gr-2500 gr', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Pertolongan persalinan melalui seksio cesaria', 'target' => 100, 'arah' => 'lebih_kecil'],
            ['unit_id' => 44, 'nama' => 'Pelayanan KB Mantap', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Konseling KB Mantap', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 44, 'nama' => 'Kepuasan Pelanggan Persalinan', 'target' => 80, 'arah' => 'lebih_besar'],

            // 6. Intensif (Unit 17)
            ['unit_id' => 17, 'nama' => 'Rata-rata pasien yang kembali ke perawatan intensif < 72 jam', 'target' => 3, 'arah' => 'lebih_kecil'],
            ['unit_id' => 17, 'nama' => 'Pemberi pelayanan Unit Intensif', 'target' => 100, 'arah' => 'lebih_besar'],

            // 7. Radiologi (Unit 34)
            ['unit_id' => 34, 'nama' => 'Waktu tunggu hasil pelayanan thorax foto', 'target' => 3, 'arah' => 'lebih_kecil'],
            ['unit_id' => 34, 'nama' => 'Pelaksana ekspertisi Radiologi (Dr.Sp.Rad)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 34, 'nama' => 'Kejadian kegagalan pelayanan Rontgen', 'target' => 2, 'arah' => 'lebih_kecil'],
            ['unit_id' => 34, 'nama' => 'Kepuasan pelanggan Radiologi', 'target' => 80, 'arah' => 'lebih_besar'],

            // 8. Laboratorium (Unit 8)
            ['unit_id' => 8, 'nama' => 'Waktu tunggu hasil pelayanan lab Kimia & Darah Rutin', 'target' => 140, 'arah' => 'lebih_kecil'],
            ['unit_id' => 8, 'nama' => 'Pelaksana ekspertisi Dokter Sp.PK', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 8, 'nama' => 'Tidak adanya kesalahan pemberian hasil lab', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 8, 'nama' => 'Kepuasan pelanggan Laboratorium', 'target' => 80, 'arah' => 'lebih_besar'],

            // 9. Rehab Medik (Unit 29)
            ['unit_id' => 29, 'nama' => 'Kejadian Drop Out pasien terhadap pelayanan Rehab Medik', 'target' => 50, 'arah' => 'lebih_kecil'],
            ['unit_id' => 29, 'nama' => 'Tidak adanya kejadian kesalahan tindakan rehab medik', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 29, 'nama' => 'Kepuasan Pelanggan Rehab Medik', 'target' => 80, 'arah' => 'lebih_besar'],

            // 10. Farmasi (Unit 21)
            ['unit_id' => 21, 'nama' => 'Waktu tunggu pelayanan Obat Jadi (≤ 30 menit)', 'target' => 30, 'arah' => 'lebih_kecil'],
            ['unit_id' => 21, 'nama' => 'Waktu tunggu pelayanan Obat Racikan (≤ 60 menit)', 'target' => 60, 'arah' => 'lebih_kecil'],
            ['unit_id' => 21, 'nama' => 'Tidak adanya Kejadian kesalahan pemberian obat', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 21, 'nama' => 'Kepuasan pelanggan Farmasi', 'target' => 80, 'arah' => 'lebih_besar'],
            ['unit_id' => 21, 'nama' => 'Penulisan resep sesuai formularium', 'target' => 100, 'arah' => 'lebih_besar'],

            // 11. Gizi (Unit 3)
            ['unit_id' => 3, 'nama' => 'Ketepatan waktu pemberian makanan kepada pasien', 'target' => 90, 'arah' => 'lebih_besar'],
            ['unit_id' => 3, 'nama' => 'Sisa makanan yang tidak termakan oleh pasien', 'target' => 20, 'arah' => 'lebih_kecil'],
            ['unit_id' => 3, 'nama' => 'Tidak adanya kejadian kesalahan pemberian diet', 'target' => 100, 'arah' => 'lebih_besar'],

            // 12. Transfusi (Unit 8 - Lab fallback)
            ['unit_id' => 8, 'nama' => 'Kebutuhan darah bagi setiap pelayanan transfusi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 8, 'nama' => 'Kejadian Reaksi transfusi', 'target' => 0.01, 'arah' => 'lebih_kecil'],

            // 13. Rekam Medis (Unit 41)
            ['unit_id' => 41, 'nama' => 'Kelengkapan pengisian rekam medik 24 jam', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 41, 'nama' => 'Kelengkapan Informed Concent', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 41, 'nama' => 'Waktu penyediaan dokumen RM Rawat Jalan (≤ 10 menit)', 'target' => 10, 'arah' => 'lebih_kecil'],
            ['unit_id' => 41, 'nama' => 'Waktu penyediaan dokumen RM Rawat Inap (≤ 15 menit)', 'target' => 15, 'arah' => 'lebih_kecil'],

            // 14. Pengelolaan Limbah (Unit 46)
            ['unit_id' => 46, 'nama' => 'Baku mutu limbah cair (BOD, COD, TSS, PH)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 46, 'nama' => 'Pengelolaan limbah padat infeksius sesuai aturan', 'target' => 100, 'arah' => 'lebih_besar'],

            // 15. Adm dan Manajemen (Unit 1)
            ['unit_id' => 1, 'nama' => 'Tindak lanjut penyelesaian hasil pertemuan direksi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Kelengkapan laporan akuntabilitas kinerja', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Ketepatan waktu pengusulan kenaikan pangkat', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Ketepatan Waktu pengurusan gaji berkala', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Karyawan yang mendapat pelatihan minimal 20 jam setahun', 'target' => 60, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Cost recovery', 'target' => 40, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Ketepatan waktu penyusunan laporan keuangan', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 1, 'nama' => 'Kecepatan waktu pemberian informasi tagihan RI (≤ 2 jam)', 'target' => 2, 'arah' => 'lebih_kecil'],
            ['unit_id' => 1, 'nama' => 'Ketepatan waktu pemberian imbalan (insentif)', 'target' => 100, 'arah' => 'lebih_besar'],

            // 16. Ambulance (Unit 9)
            ['unit_id' => 9, 'nama' => 'Waktu pelayanan ambulance/Kereta jenazah (24 Jam)', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 9, 'nama' => 'Kecepatan pelayanan ambulance di RS < 30 Menit', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 9, 'nama' => 'Response time pelayanan ambulance oleh masyarakat', 'target' => 30, 'arah' => 'lebih_kecil'],

            // 17. Pemulasaran Jenazah (Unit 5 - Umum fallback)
            ['unit_id' => 5, 'nama' => 'Waktu tanggap pelayanan pemulasaraan jenazah (≤ 2 jam)', 'target' => 2, 'arah' => 'lebih_kecil'],

            // 18. IPSRS (Unit 6)
            ['unit_id' => 6, 'nama' => 'Kecepatan waktu menanggapi kerusakan alat', 'target' => 80, 'arah' => 'lebih_besar'],
            ['unit_id' => 6, 'nama' => 'Ketepatan waktu pemeliharaan alat', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 6, 'nama' => 'Peralatan lab dan ukur terkalibrasi tepat waktu', 'target' => 100, 'arah' => 'lebih_besar'],

            // 19. PPI (Unit 35)
            ['unit_id' => 35, 'nama' => 'Ada anggota Tim PPI yang terlatih', 'target' => 75, 'arah' => 'lebih_besar'],
            ['unit_id' => 35, 'nama' => 'Tersedia APD di setiap instalasi/departemen', 'target' => 75, 'arah' => 'lebih_besar'],
            ['unit_id' => 35, 'nama' => 'Kegiatan pencatatan dan pelaporan infeksi nosokomial (HAI)', 'target' => 75, 'arah' => 'lebih_besar'],

            // 20. Laundry dan CSSD (Unit 51 & 39)
            ['unit_id' => 39, 'nama' => 'Tidak Adanya Kerusakan Kemasan Setelah Post Sterilisasi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 39, 'nama' => 'Kepatuhan Pengisian Formulir Permintaan Sterilisasi', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 39, 'nama' => 'Ketepatan Kemasan Alat Medis Sesuai Perubahan Warna Indikator', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 51, 'nama' => 'Tidak adanya noda Linen setelah dilakukan pencucian', 'target' => 100, 'arah' => 'lebih_besar'],
            ['unit_id' => 51, 'nama' => 'Tidak Adanya Linen Yang Tertinggal Saat Serah Terima', 'target' => 100, 'arah' => 'lebih_besar'],
        ];

        $urutan = 1;
        foreach ($raw_data as $row) {
            DB::table('tbl_spm')->updateOrInsert(
                ['nama_spm' => $row['nama'], 'unit_id' => $row['unit_id']],
                [
                    'target_spm' => $row['target'],
                    'arah_target' => $row['arah'],
                    'status_spm' => 'aktif',
                    'urutan' => $urutan++,
                    'created_at' => $date_start,
                    'updated_at' => $date_start,
                ]
            );
        }

        // Auto-link to active period
        $periode = DB::table('tbl_periode')->where('status', 'aktif')->first() 
                   ?? DB::table('tbl_periode')->first();

        if ($periode) {
            $spms = DB::table('tbl_spm')->get();
            foreach ($spms as $spm) {
                DB::table('tbl_spm_periode')->updateOrInsert(
                    ['spm_id' => $spm->id, 'periode_id' => $periode->id],
                    [
                        'status' => 'aktif',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
}
