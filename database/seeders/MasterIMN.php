<?php
namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class MasterIMN extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tahun = '2025';

        $data = [
            [
                'nama'   => 'Kepatuhan Kebersihan Tangan',
                'target' => 85.00,
            ],
            [
                'nama'   => 'Kepatuhan penggunaan Alat Pelindung Diri (APD)',
                'target' => 100.00,
            ],
            [
                'nama'   => 'Kepatuhan identifikasi pasien',
                'target' => 100.00,
            ],
            [
                'nama'   => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Waktu tunggu rawat jalan',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Penundaan operasi elektif',
                'target' => 5.00,
            ],
            [
                'nama'   => 'Kepatuhan waktu visite dokter',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Pelaporan hasil kritis laboratorium',
                'target' => 100.00,
            ],
            [
                'nama'   => 'Kepatuhan penggunaan formularium nasional',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Kepatuhan terhadap Clinical Pathway',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Kepatuhan upaya pencegahan risiko pasien jatuh',
                'target' => 100.00,
            ],
            [
                'nama'   => 'Kecepatan waktu tanggap komplain',
                'target' => 80.00,
            ],
            [
                'nama'   => 'Kepuasan pasien',
                'target' => 76.61,
            ],
        ];

        foreach ($data as $item) {
            DB::table('tbl_indikator_nasional')->insert([
                'nama_indikator_nasional'   => $item['nama'],
                'target_indikator_nasional' => $item['target'],
                'periode_tahun'             => $tahun,
                'tanggal_mulai'             => Carbon::create($tahun, 1, 1),
                'tanggal_selesai'           => Carbon::create($tahun, 12, 31),
                'status_periode'            => 'aktif',
                'status_indikator_nasional' => 'aktif',
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);
        }
    }
}
