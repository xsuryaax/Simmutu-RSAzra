<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Indikator extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_indikator_unit')->insert([
            /*
            |--------------------------------------------------------------------------
            | SIMRS
            |--------------------------------------------------------------------------
            */
            [
                'nama_indikator_unit'      => 'Response Time Permintaan Perbaikan SIMRS',
                'target_indikator_unit'    => 90.00,
                'tipe_indikator_unit'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-12-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator_unit'    => 'aktif',
                'unit_id'             => 3, // SIMRS
                'kamus_indikator_unit_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MARKETING
            |--------------------------------------------------------------------------
            */
            [
                'nama_indikator_unit'      => 'Angka Kelengkapan Data Pembayaran Piutang Perusahaan dan Asuransi',
                'target_indikator_unit'    => 100.00,
                'tipe_indikator_unit'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator_unit'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_unit_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nama_indikator_unit'      => 'Ketepatan Waktu Pemberian Imbalan Honor Dokter Sesuai Kesepakatan',
                'target_indikator_unit'    => 100.00,
                'tipe_indikator_unit'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator_unit'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_unit_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nama_indikator_unit'      => 'Tidak Adanya Kesalahan Harga antara Memo Estimasi dan Nota Perawatan Pasien Tindakan Pembedahan',
                'target_indikator_unit'    => 0.00,
                'tipe_indikator_unit'      => 'lokal',
                'periode_tahun'       => '2025',
                'tanggal_mulai'       => '2025-01-01',
                'tanggal_selesai'     => '2025-12-31',
                'status_periode'      => 'aktif',
                'status_indikator_unit'    => 'aktif',
                'unit_id'             => 4, // Marketing
                'kamus_indikator_unit_id'  => null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);
    }
}
