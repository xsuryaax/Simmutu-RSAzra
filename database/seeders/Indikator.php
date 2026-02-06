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
            ['nama_indikator' => 'Kepatuhan Kebersihan Tangan', 'unit_id' => 5,'target_indikator' => 85, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan Alat Pelindung Diri (APD)', 'unit_id' => 5,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan identifikasi pasien', 'unit_id' => 6,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi', 'unit_id' => 6,'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Waktu tunggu rawat jalan', 'unit_id' => 10,'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Penundaan operasi elektif', 'unit_id' => 11,'target_indikator' => 5, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan waktu visite dokter', 'unit_id' => 12,'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Pelaporan hasil kritis laboratorium', 'unit_id' => 7,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepatuhan penggunaan formularium nasional', 'unit_id' => 8,'target_indikator' => 80, 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan terhadap Clinical Pathway', 'unit_id' => 2,'target_indikator' => 80, 'tipe_indikator' => 'nasional'],
            ['nama_indikator' => 'Kepatuhan upaya pencegahan risiko pasien jatuh', 'unit_id' => 2,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kecepatan waktu tanggap komplain', 'unit_id' => 2,'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kepuasan pasien', 'unit_id' => 2,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],

            ['nama_indikator' => 'Ketepatan Waktu Pelaporan INM ke Kementrian Kesehatan Republik Indonesia', 'unit_id' => 2,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan Waktu Pelaporan IKP Ke Kementrian Kesehatan Republik Indonesia', 'unit_id' => 2,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian waktu penyelesaian worksheet order IT dengan target Digitalisasi RS', 'unit_id' => 3,'target_indikator' => 90, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Respon Time Terhadap Permintaan Perbaikan Fasilitas SIMRS <15 Menit ', 'unit_id' => 3,'target_indikator' => 80, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Ketepatan penyelesaian Digital Project sesuai permintaan target', 'unit_id' => 4,'target_indikator' => 100, 'tipe_indikator' => 'lokal'],
            ['nama_indikator' => 'Kesesuaian Kerjasama dengan Perusahaan atau Asuransi sesuai target jadwal', 'unit_id' => 4,'target_indikator' => 90, 'tipe_indikator' => 'lokal'],
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
