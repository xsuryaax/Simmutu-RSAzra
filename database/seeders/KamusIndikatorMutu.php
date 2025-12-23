<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamusIndikatorMutu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_kamus_indikator_mutu_unit')->insert([

            /*
            |--------------------------------------------------------------------------
            | SIMRS / IT
            |--------------------------------------------------------------------------
            */
            [
                'indikator_unit_id' => 1, // Response Time Permintaan Perbaikan
                'definisi_operasional' =>
                    'Waktu yang dibutuhkan sejak permintaan perbaikan diterima hingga dilakukan respon awal.',
                'tujuan' =>
                    'Menilai kecepatan dan efektivitas unit dalam merespon permintaan perbaikan.',
                'dimensi_mutu_id' => 1,
                'dasar_pemikiran' =>
                    'Respon cepat mencerminkan mutu pelayanan dan kesiapan unit.',
                'formula_pengukuran' =>
                    'Total waktu respon / jumlah permintaan perbaikan',
                'metodologi' =>
                    'Observasional',
                'detail_pengukuran' =>
                    'Waktu dihitung sejak tiket dicatat hingga respon awal dilakukan.',
                'sumber_data' =>
                    'SIMRS / Helpdesk IT',
                'penanggung_jawab' =>
                    'Kepala Unit SIMRS',

                'metodologi_pengumpulan_data_id' => 1,
                'cakupan_data_id' => 1,
                'frekuensi_pengumpulan_data_id' => 3,
                'frekuensi_analisis_data_id' => 2,
                'metodologi_analisis_data_id' => 1,
                'interpretasi_data_id' => 1,
                'publikasi_data_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MARKETING
            |--------------------------------------------------------------------------
            */

            // 1. Kelengkapan Data Piutang
            [
                'indikator_unit_id' => 2,
                'definisi_operasional' =>
                    'Persentase kelengkapan data pembayaran piutang perusahaan dan asuransi.',
                'tujuan' =>
                    'Menilai ketertiban dan kelengkapan administrasi piutang.',
                'dasar_pemikiran' =>
                    'Kelengkapan data mendukung kelancaran klaim dan arus kas.',
                'formula_pengukuran' =>
                    '(Jumlah data lengkap / total data piutang) x 100%',
                'metodologi' =>
                    'Observasional',
                'detail_pengukuran' =>
                    'Data dinyatakan lengkap jika seluruh dokumen pembayaran tersedia.',
                'sumber_data' =>
                    'Sistem Keuangan / SIMRS',
                'penanggung_jawab' =>
                    'Kepala Unit Marketing',

                'dimensi_mutu_id' => 2,
                'metodologi_pengumpulan_data_id' => 1,
                'cakupan_data_id' => 1,
                'frekuensi_pengumpulan_data_id' => 2,
                'frekuensi_analisis_data_id' => 2,
                'metodologi_analisis_data_id' => 1,
                'interpretasi_data_id' => 1,
                'publikasi_data_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 2. Ketepatan Waktu Honor Dokter
            [
                'indikator_unit_id' => 3,
                'definisi_operasional' =>
                    'Persentase pembayaran honor dokter yang dilakukan tepat waktu sesuai kesepakatan.',
                'tujuan' =>
                    'Menilai kepatuhan pembayaran honor dokter.',
                'dasar_pemikiran' =>
                    'Pembayaran tepat waktu mencerminkan profesionalisme organisasi.',
                'formula_pengukuran' =>
                    '(Pembayaran tepat waktu / total pembayaran) x 100%',
                'metodologi' =>
                    'Observasional',
                'detail_pengukuran' =>
                    'Pembayaran dianggap tepat waktu jika sesuai tanggal kesepakatan.',
                'sumber_data' =>
                    'Sistem Keuangan',
                'penanggung_jawab' =>
                    'Kepala Unit Keuangan',

                'dimensi_mutu_id' => 1,
                'metodologi_pengumpulan_data_id' => 1,
                'cakupan_data_id' => 1,
                'frekuensi_pengumpulan_data_id' => 2,
                'frekuensi_analisis_data_id' => 2,
                'metodologi_analisis_data_id' => 1,
                'interpretasi_data_id' => 1,
                'publikasi_data_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 3. Kesalahan Harga Estimasi vs Nota
            [
                'indikator_unit_id' => 4,
                'definisi_operasional' =>
                    'Persentase kesesuaian harga antara memo estimasi dan nota perawatan pembedahan.',
                'tujuan' =>
                    'Menilai akurasi perhitungan biaya pelayanan pembedahan.',
                'dasar_pemikiran' =>
                    'Kesalahan harga dapat menurunkan kepercayaan pasien.',
                'formula_pengukuran' =>
                    '(Nota tanpa kesalahan / total nota pembedahan) x 100%',
                'metodologi' =>
                    'Observasional',
                'detail_pengukuran' =>
                    'Data sesuai jika tidak terdapat selisih harga.',
                'sumber_data' =>
                    'SIMRS / Billing',
                'penanggung_jawab' =>
                    'Kepala Unit Marketing',

                'dimensi_mutu_id' => 2,
                'metodologi_pengumpulan_data_id' => 1,
                'cakupan_data_id' => 1,
                'frekuensi_pengumpulan_data_id' => 2,
                'frekuensi_analisis_data_id' => 2,
                'metodologi_analisis_data_id' => 1,
                'interpretasi_data_id' => 1,
                'publikasi_data_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
