<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Indikator extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_indikator')->insert([
            /*
            |--------------------------------------------------------------------------
            | SIMRS
            |--------------------------------------------------------------------------
            */
            [
                'nama_indikator'      => 'Response Time Permintaan Perbaikan SIMRS',
                'target_indikator'    => 90.00,
                'tipe_indikator'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-12-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator'    => 'aktif',
                'unit_id'             => 3, // SIMRS
                'kamus_indikator_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MARKETING
            |--------------------------------------------------------------------------
            */
            [
                'nama_indikator'      => 'Angka Kelengkapan Data Pembayaran Piutang Perusahaan dan Asuransi',
                'target_indikator'    => 100.00,
                'tipe_indikator'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nama_indikator'      => 'Ketepatan Waktu Pemberian Imbalan Honor Dokter Sesuai Kesepakatan',
                'target_indikator'    => 100.00,
                'tipe_indikator'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nama_indikator'      => 'Tidak Adanya Kesalahan Harga antara Memo Estimasi dan Nota Perawatan Pasien Tindakan Pembedahan',
                'target_indikator'    => 0.00,
                'tipe_indikator'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);
    }
}
