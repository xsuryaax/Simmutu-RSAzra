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
        $data = [
            [
                'indikator_id' => 1,
                'definisi_operasional' => 'Persentase pasien yang mendapatkan pelayanan tepat waktu.',
                'tujuan' => 'Meningkatkan kepuasan pasien dan efektivitas pelayanan.',
                'dimensi_mutu_id' => 1,
                'dasar_pemikiran' => 'Pelayanan tepat waktu merupakan indikator utama kepuasan pasien.',
                'formula_pengukuran' => '(Jumlah pasien yang dilayani tepat waktu / Total pasien) x 100%',
                'metodologi' => 'Observasi langsung dan laporan pelayanan harian.',
                'metodologi_pengumpulan_data_id' => 1,
                'cakupan_data_id' => 1,
                'detail_pengukuran' => 'Menghitung pasien yang datang sesuai jadwal.',
                'frekuensi_pengumpulan_data_id' => 1,
                'sumber_data' => 'Rekam medis dan laporan staff.',
                'frekuensi_analisis_data_id' => 1,
                'metodologi_analisis_data_id' => 1,
                'interpretasi_data_id' => 1,
                'penanggung_jawab' => 'Manajer Pelayanan',
                'publikasi_data_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 2,
                'definisi_operasional' => 'Persentase kepatuhan staf terhadap prosedur keselamatan pasien.',
                'tujuan' => 'Menjamin keselamatan pasien dan kualitas pelayanan.',
                'dimensi_mutu_id' => 2,
                'dasar_pemikiran' => 'Keselamatan pasien adalah prioritas utama rumah sakit.',
                'formula_pengukuran' => '(Jumlah staf yang patuh / Total staf) x 100%',
                'metodologi' => 'Audit internal dan pengamatan langsung.',
                'metodologi_pengumpulan_data_id' => 2,
                'cakupan_data_id' => 2,
                'detail_pengukuran' => 'Memeriksa kepatuhan staf sesuai SOP keselamatan.',
                'frekuensi_pengumpulan_data_id' => 3,
                'sumber_data' => 'Laporan audit internal dan pengamatan harian.',
                'frekuensi_analisis_data_id' => 2,
                'metodologi_analisis_data_id' => 2,
                'interpretasi_data_id' => 2,
                'penanggung_jawab' => 'Kepala Unit Keselamatan',
                'publikasi_data_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tbl_kamus_indikator_mutu')->insert($data);
    }
}
