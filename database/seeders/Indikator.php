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
            ['nama_indikator' => 'Kepatuhan Kebersihan Tangan', 'unit_id' => 26, 'target_indikator' => 85, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan Alat Pelindung Diri (APD)', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan identifikasi pasien', 'unit_id' => 8, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi', 'unit_id' => 31, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu tunggu rawat jalan', 'unit_id' => 14, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Penundaan operasi elektif', 'unit_id' => 30, 'target_indikator' => 5, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan waktu visite dokter', 'unit_id' => 25, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pelaporan hasil kritis laboratorium', 'unit_id' => 5, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan formularium nasional', 'unit_id' => 33, 'target_indikator' => 80, 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan terhadap Clinical Pathway', 'unit_id' => 2, 'target_indikator' => 80, 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan upaya pencegahan risiko pasien jatuh', 'unit_id' => 8, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kecepatan waktu tanggap komplain', 'unit_id' => 19, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepuasan pasien', 'unit_id' => 19, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT IGD
            ['nama_indikator' => 'Kesesuaian waktu tunggu observasi pasien di Instalasi Gawat Darurat ≤ 2 jam', 'unit_id' => 3, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Respon Time Menjawab Permintaan Rujukan Melalui Sistem Rujukan', 'unit_id' => 3, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],

            // UNIT RJ & HD
            ['nama_indikator' => 'Respon Time hasil MCU selesai dalam 72 jam', 'unit_id' => 14, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Keterlambatan Dokter Spesialis Terhadap Jadwal Praktek < 30 menit', 'unit_id' => 14, 'target_indikator' => 5, 'tipe_indikator' => 'lokal'],

            // UNIT RI
            ['nama_indikator' => 'Kepatuhan Edukasi Risiko Jatuh pada pasien Anak di Rawat Inap', 'unit_id' => 25, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kelengkapan Berkas Discharge Planning H-1 oleh DPJP', 'unit_id' => 25, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Keberhasilan Perawat Dalam Pemasangan Infus Satu Kali Pada Pasien Rawat Inap', 'unit_id' => 25, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Pengkajian Awal Rawat Inap dalam waktu ≤ 24 jam', 'unit_id' => 25, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Respon time Kecepatan proses pemulangan Pasien Rawat Inap < 2 jam', 'unit_id' => 25, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT BEDAH
            ['nama_indikator' => 'Kepatuhan Pelaksanaan dan Pengisian Formulir Serah Terima ke Ruang Operasi', 'unit_id' => 30, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Kepatuhan Pelaksanaan Surgical Safety Checklist di Kamar Operasi', 'unit_id' => 30, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu Operasi Elektif Pasien Obsgyn tanpa penyulit < 45 menit', 'unit_id' => 30, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Pengisian Laporan Operasi Diteramedik Oleh Dokter Operator', 'unit_id' => 30, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT PERSALINAN DAN PERINATOLOGI
            ['nama_indikator' => 'Waktu Respon Pemberian Magnesiuum Sulfat (MgSO4) Pada Pasien Dengan Pre Eklamsia Atau Eklamsia', 'unit_id' => 31, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu Tanggap Pelayanan Dokter Obgyn di VK saat partus spontan < 30 Menit', 'unit_id' => 31, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT FARMASI
            ['nama_indikator' => 'Kepatuhan Identifikasi Pasien Saat Penempelan Etiket Obat di Farmasi Rawat Jalan', 'unit_id' => 33, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Respon Time Racik 55 menit, Non Racik 25 menit', 'unit_id' => 33, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan pengisian grafik suhu kulkas vaksin oleh Farmasi Klinis', 'unit_id' => 33, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Visite Apoteker pada Pasien Baru Rawat Inap', 'unit_id' => 33, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT GIZI
            ['nama_indikator' => 'Risiko Masuk Risk Register Identifikasi Alergi', 'unit_id' => 34, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Kelengkapan Pengkajian Gizi Dalam 1 X 24 Jam', 'unit_id' => 34, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT LAUNDRY & CSSD
            ['nama_indikator' => 'Kepatuhan Penempelan Steri Record', 'unit_id' => 4, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Pengisian Formulir Permintaan Sterilisasi', 'unit_id' => 4, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Kemasan Alat Medis Dan Linen Steril Sesuai Perubahan Warna Indikator Post Sterilisasi', 'unit_id' => 4, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak adanya noda Linen setelah dilakukan pencucian', 'unit_id' => 4, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak adanya kehilangan linen saat stok opname/bulan, Kesesuaian suhu ruang di Gudang Linen Bersih', 'unit_id' => 4, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT LABORATORIUM
            ['nama_indikator' => 'Waktu Tunggu Pelayanan Darah (TAT) 60 Menit', 'unit_id' => 5, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT REKAM MEDIS
            ['nama_indikator' => 'Kelengkapan Pengisian Informed Concent Setelah Mendapatkan Informasi Yang Jelas', 'unit_id' => 6, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kelengkapan pengisian rekam medik 24 jam setelah selesai pelayanan berupa Resume Medis, Hasil Laboratorium, Hasil Radiologi, Hasil PA, EKG, USG sesuai persyaratan yang dibutuhkan untuk proses klaim pada pasien Jaminan Asuransi', 'unit_id' => 6, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Dokter Dalam Memberikan Kode Diagnosa Pasien Rawat Inap', 'unit_id' => 6, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kelengkapan Pengisian SOAP Pada Pasien Rawat Jalan oleh Dokter', 'unit_id' => 6, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],

            // UNIT UMUM & OUTSOURCE
            ['nama_indikator' => 'Kepatuhan Ceklis Harian Kendaraan', 'unit_id' => 9, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Response Time Sopir Dalam Tugas On Call', 'unit_id' => 9, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Satpam Melaksanakan Patroli', 'unit_id' => 9, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT IPSRS ALAT MEDIS
            ['nama_indikator' => 'Ketepatan waktu menanggapi kerusakan alat medis oleh ATEM', 'unit_id' => 10, 'target_indikator' => 90, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan peralatan atau alat ukur yang dikalibrasi --> Berdasarkan Inventaris', 'unit_id' => 10, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT LIMBAH
            ['nama_indikator' => 'Ketepatan jadwal pengangkutan Limbah B3 medis di TPS LB3', 'unit_id' => 11, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian hasil pemeriksaan limbah cair dengan standar', 'unit_id' => 11, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT KEUANGAN
            ['nama_indikator' => 'Angka Kelengkapan Data Pembayaran Piutang Perusahaan dan Asuransi--> Tidak ada kejadian pasien loss (tidak bayar)', 'unit_id' => 13, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Ketepatan waktu pemberian imbalan Honor Dokter sesuai kesepakatan waktu', 'unit_id' => 13, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT AKUNTANSI
            ['nama_indikator' => 'Ketepatan Waktu Penyusunan Laporan Keuangan', 'unit_id' => 15, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu dalam Penyusunan, Pembayaran dan Pelaporan Pajak', 'unit_id' => 15, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT PROCUREMENT MEDIS
            ['nama_indikator' => 'Kepatuhan Pembelian Obat sesuai Jadwal', 'unit_id' => 16, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian permintaan barang di invoice dengan obat datang ke Procurement Medis', 'unit_id' => 16, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu Realisasi Permintaan Pembelian Medis hingga obat datang ke Procurement Medis', 'unit_id' => 16, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT LEGAL
            ['nama_indikator' => 'Ketepatan Waktu Penyusunan dan Review Perjanjian Manajerial (Contract) / Dokumen Hukum lainnya', 'unit_id' => 18, 'target_indikator' => 90, 'tipe_indikator' => 'lokal'],

            // UNIT HUMAS & CUSTOMER CARE
            ['nama_indikator' => 'Peningkatan Pasien Baru', 'unit_id' => 19, 'target_indikator' => 20, 'tipe_indikator' => 'lokal'],

            // UNIT SALES & DIGITAL MARKETING
            ['nama_indikator' => 'Kesesuaian Kerjasama dengan Perusahaan atau Asuransi sesuai target jadwal', 'unit_id' => 20, 'target_indikator' => 90, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan penyelesaian Digital Project sesuai permintaan target --> Respone Time permintaan desain', 'unit_id' => 20, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT AO & CALL CENTER
            ['nama_indikator' => 'Kesesuaian Formulir Asuransi dengan Payor Asuransi oleh petugas pendaftaran rawat jalan', 'unit_id' => 21, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian pembookingan via DIGITAL terhadap pasien poliklinik rawat jalan', 'unit_id' => 21, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],

            // UNIT SIMRS
            ['nama_indikator' => 'Respon Time Terhadap Permintaan Perbaikan Fasilitas SIMRS < 15 Menit', 'unit_id' => 22, 'target_indikator' => 90, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian waktu penyelesaian worksheet order IT dengan target Digitalisasi RS', 'unit_id' => 22, 'target_indikator' => 90, 'tipe_indikator' => 'lokal'],

            // UNIT K3RS
            ['nama_indikator' => 'Kepatuhan Melaksanakan Assessment Risiko Pra Kontruksi (PCRA)', 'unit_id' => 23, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan pemeriksaan rutin APAR (Perumahsakitan)', 'unit_id' => 23, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Tidak ditemukannya pengunjung/ keluarga/ staff yang merokok dan adanya puntung rokok di lingkungan RS AZRA', 'unit_id' => 23, 'target_indikator' => 5, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Cek Alur dan Dokumentasi kaitan dengan BPJSTK', 'unit_id' => 23, 'target_indikator' => 80, 'tipe_indikator' => 'lokal'],

            // UNIT PROJECT UMUM
            ['nama_indikator' => 'Kelengkapan PCRA dan ICRA pada setiap Renovasi di RS Azra', 'unit_id' => 24, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian desain dan alur sesuai Peraturan (Permenkes Teknis Bangunan Perumahsakitan)', 'unit_id' => 24, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian waktu Permintaan Kerja Tambah Kontraktor jalan Terhadap Pelaksanaan Pembangunan', 'unit_id' => 24, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT PPI
            ['nama_indikator' => 'Tidak adanya sterirecord expired di Unit Pelayanan', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Pengelolaan Limbah B3 Sesuai SPO', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Manajemen Linen Sesuai SPO', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Kegiatan Pelayanan Makanan Sesuai SPO', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan Penempatan Pasien Di Ruangan Isolasi sesuai indikasi', 'unit_id' => 26, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT MUTU
            ['nama_indikator' => 'Ketepatan Waktu Pelaporan INM Ke Kementrian Kesehatan Republik Indonesia', 'unit_id' => 2, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu Pelaporan IKP Ke Kementrian Kesehatan Republik Indonesia', 'unit_id' => 2, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Angka Pelaporan Insiden Yang Ditindaklanjuti', 'unit_id' => 2, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            // UNIT JKN
            ['nama_indikator' => 'Kesesuaian berkas sesuai syarat sebelum pengajuan klaim', 'unit_id' => 27, 'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

        ];

        foreach ($indikators as $indikator) {
            DB::table('tbl_indikator')->insert([
                'nama_indikator' => $indikator['nama_indikator'],
                'target_indikator' => $indikator['target_indikator'],
                'tipe_indikator' => $indikator['tipe_indikator'],
                'status_indikator' => 'aktif',
                'unit_id' => $indikator['unit_id'] ?? 1,
                'kamus_indikator_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
