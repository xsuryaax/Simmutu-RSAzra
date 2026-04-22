<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManajemenDataMutu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_tbl_dimensi_mutu = [
    [
        'id' => '1',
        'nama_dimensi_mutu' => 'Keselamatan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_dimensi_mutu' => 'Efektivitas',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_dimensi_mutu' => 'Berfokus pada Pasien',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '4',
        'nama_dimensi_mutu' => 'Ketepatan Waktu',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '5',
        'nama_dimensi_mutu' => 'Efisiensi',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '6',
        'nama_dimensi_mutu' => 'Keadilan / Kesetaraan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '7',
        'nama_dimensi_mutu' => 'Kesinambungan / Integrasi Pelayanan',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_dimensi_mutu as $item) {
            DB::table('tbl_dimensi_mutu')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_periode_analisis_data = [
    [
        'id' => '1',
        'nama_periode_analisis_data' => 'Bulanan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_periode_analisis_data' => 'Triwulanan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_periode_analisis_data' => 'Tahunan',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_periode_analisis_data as $item) {
            DB::table('tbl_periode_analisis_data')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_periode_pengumpulan_data = [
    [
        'id' => '1',
        'nama_periode_pengumpulan_data' => 'Harian',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_periode_pengumpulan_data' => 'Mingguan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_periode_pengumpulan_data' => 'Bulanan',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_periode_pengumpulan_data as $item) {
            DB::table('tbl_periode_pengumpulan_data')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_penyajian_data = [
    [
        'id' => '1',
        'nama_penyajian_data' => 'Statistik',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_penyajian_data' => 'Run Chart',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_penyajian_data' => 'Control Chart',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '4',
        'nama_penyajian_data' => 'Pareto',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '5',
        'nama_penyajian_data' => 'Bar Diagram',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_penyajian_data as $item) {
            DB::table('tbl_penyajian_data')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_metode_pengumpulan_data = [
    [
        'id' => '1',
        'nama_metode_pengumpulan_data' => 'Sensus Harian',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_metode_pengumpulan_data' => 'Retrospektif',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_metode_pengumpulan_data as $item) {
            DB::table('tbl_metode_pengumpulan_data')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_jenis_indikator = [
    [
        'id' => '1',
        'nama_jenis_indikator' => 'Struktur',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_jenis_indikator' => 'Proses',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_jenis_indikator' => 'Output',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '4',
        'nama_jenis_indikator' => 'Outcome',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_jenis_indikator as $item) {
            DB::table('tbl_jenis_indikator')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_role = [
    [
        'id' => '1',
        'nama_role' => 'Administrator',
        'deskripsi_role' => 'Memiliki akses penuh ke semua fitur dan pengaturan sistem.',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_role' => 'Tim Mutu',
        'deskripsi_role' => 'Bertanggung jawab atas manajemen unit dan pelaporan indikator mutu.',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_role' => 'Validator',
        'deskripsi_role' => 'Menginput dan melaporkan data indikator sesuai unit masing-masing.',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '4',
        'nama_role' => 'Staff',
        'deskripsi_role' => 'Pelaksana',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '5',
        'nama_role' => 'Koordinator',
        'deskripsi_role' => 'Leader Ruangan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '6',
        'nama_role' => 'Penanggung Jawab',
        'deskripsi_role' => 'PJ Shift / PJ Layanan',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '7',
        'nama_role' => 'Supervisor',
        'deskripsi_role' => 'Leader Lintas Unit',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '8',
        'nama_role' => 'Kepala unit',
        'deskripsi_role' => 'Manager Unit',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '9',
        'nama_role' => 'Kepala',
        'deskripsi_role' => 'Kepala Divisi / Kepala Bagian',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '10',
        'nama_role' => 'Dokter Spesialis',
        'deskripsi_role' => 'Dokter Spesialis',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_role as $item) {
            DB::table('tbl_role')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_unit = [
    [
        'id' => '1',
        'kode_unit' => 'UNIT001',
        'nama_unit' => 'Administrator',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'kode_unit' => 'UNIT002',
        'nama_unit' => 'Mutu',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '6',
        'kode_unit' => 'UNIT006',
        'nama_unit' => 'IPSRS',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '7',
        'kode_unit' => 'UNIT007',
        'nama_unit' => 'Rawat jalan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '9',
        'kode_unit' => 'UNIT009',
        'nama_unit' => 'Transportasi & kurir',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '10',
        'kode_unit' => 'UNIT010',
        'nama_unit' => 'NS 1',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '11',
        'kode_unit' => 'UNIT011',
        'nama_unit' => 'NS 2',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '12',
        'kode_unit' => 'UNIT012',
        'nama_unit' => 'NS 3',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '13',
        'kode_unit' => 'UNIT013',
        'nama_unit' => 'NS 4',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '14',
        'kode_unit' => 'UNIT014',
        'nama_unit' => 'NS 6',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '15',
        'kode_unit' => 'UNIT015',
        'nama_unit' => 'NS 7',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '16',
        'kode_unit' => 'UNIT016',
        'nama_unit' => 'NS 8',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '17',
        'kode_unit' => 'UNIT017',
        'nama_unit' => 'ICU',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '18',
        'kode_unit' => 'UNIT018',
        'nama_unit' => 'Instalasi gawat darurat',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '20',
        'kode_unit' => 'UNIT020',
        'nama_unit' => 'Marketing',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '22',
        'kode_unit' => 'UNIT022',
        'nama_unit' => 'NICU & PICU',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '23',
        'kode_unit' => 'UNIT023',
        'nama_unit' => 'IT',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '24',
        'kode_unit' => 'UNIT024',
        'nama_unit' => 'Sekretariat',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '25',
        'kode_unit' => 'UNIT025',
        'nama_unit' => 'MPP',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '26',
        'kode_unit' => 'UNIT026',
        'nama_unit' => 'Casemix',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '27',
        'kode_unit' => 'UNIT027',
        'nama_unit' => 'Kamar operasi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '31',
        'kode_unit' => 'UNIT031',
        'nama_unit' => 'Maintenance',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '32',
        'kode_unit' => 'UNIT032',
        'nama_unit' => 'Dokter jaga',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '33',
        'kode_unit' => 'UNIT033',
        'nama_unit' => 'Hemodialisa',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '35',
        'kode_unit' => 'UNIT035',
        'nama_unit' => 'PPI',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '36',
        'kode_unit' => 'UNIT036',
        'nama_unit' => 'SDM',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '37',
        'kode_unit' => 'UNIT037',
        'nama_unit' => 'AO & Call center',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '38',
        'kode_unit' => 'UNIT038',
        'nama_unit' => 'Perinatologi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '39',
        'kode_unit' => 'UNIT039',
        'nama_unit' => 'CSSD',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '41',
        'kode_unit' => 'UNIT041',
        'nama_unit' => 'Rekam medis',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '42',
        'kode_unit' => 'UNIT042',
        'nama_unit' => 'Instalasi kamar operasi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '43',
        'kode_unit' => 'UNIT043',
        'nama_unit' => 'Keuangan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '44',
        'kode_unit' => 'UNIT044',
        'nama_unit' => 'Kamar bersalin',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '45',
        'kode_unit' => 'UNIT045',
        'nama_unit' => 'Rawat inap',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '46',
        'kode_unit' => 'UNIT046',
        'nama_unit' => 'Kesehatan lingkungan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '47',
        'kode_unit' => 'UNIT047',
        'nama_unit' => 'Legal',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '48',
        'kode_unit' => 'UNIT048',
        'nama_unit' => 'Logistik umum',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '49',
        'kode_unit' => 'UNIT049',
        'nama_unit' => 'Duty officer',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '51',
        'kode_unit' => 'UNIT051',
        'nama_unit' => 'Laundry',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '52',
        'kode_unit' => 'UNIT052',
        'nama_unit' => 'AR',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '40',
        'kode_unit' => 'UNIT040',
        'nama_unit' => 'Akuntansi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:35:14',
    ],
    [
        'id' => '30',
        'kode_unit' => 'UNIT030',
        'nama_unit' => 'Kasir & Pentarifan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:35:58',
    ],
    [
        'id' => '28',
        'kode_unit' => 'UNIT028',
        'nama_unit' => 'Pengadaan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:36:34',
    ],
    [
        'id' => '54',
        'kode_unit' => 'UNIT054',
        'nama_unit' => 'Sales & Digital Marketing',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => '2026-04-15 08:40:29',
        'updated_at' => '2026-04-15 08:40:29',
    ],
    [
        'id' => '21',
        'kode_unit' => 'UNIT021',
        'nama_unit' => 'Farmasi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:51:36',
    ],
    [
        'id' => '50',
        'kode_unit' => 'UNIT050',
        'nama_unit' => 'Keperawatan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:51:56',
    ],
    [
        'id' => '3',
        'kode_unit' => 'UNIT003',
        'nama_unit' => 'Gizi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:53:21',
    ],
    [
        'id' => '8',
        'kode_unit' => 'UNIT008',
        'nama_unit' => 'Laboratorium',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:54:30',
    ],
    [
        'id' => '34',
        'kode_unit' => 'UNIT034',
        'nama_unit' => 'Radiologi',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:55:23',
    ],
    [
        'id' => '29',
        'kode_unit' => 'UNIT029',
        'nama_unit' => 'Rehabilitasi Medik & KTKA',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 08:57:09',
    ],
    [
        'id' => '4',
        'kode_unit' => 'UNIT004',
        'nama_unit' => 'Rumah Tangga & K3RS',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 09:01:59',
    ],
    [
        'id' => '5',
        'kode_unit' => 'UNIT005',
        'nama_unit' => 'Umum & Perizinan',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => null,
        'updated_at' => '2026-04-15 09:05:11',
    ],
    [
        'id' => '55',
        'kode_unit' => 'UNIT055',
        'nama_unit' => 'Intensif',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => '2026-04-15 08:49:38',
        'updated_at' => '2026-04-16 01:32:11',
    ],
    [
        'id' => '19',
        'kode_unit' => 'UNIT019',
        'nama_unit' => 'KTKA',
        'deskripsi_unit' => null,
        'status_unit' => 'non-aktif',
        'created_at' => null,
        'updated_at' => '2026-04-16 02:43:17',
    ],
    [
        'id' => '53',
        'kode_unit' => 'UNIT053',
        'nama_unit' => 'Humas & CC',
        'deskripsi_unit' => null,
        'status_unit' => 'aktif',
        'created_at' => '2026-04-15 08:39:08',
        'updated_at' => '2026-04-16 03:16:08',
    ],
];
        foreach ($data_tbl_unit as $item) {
            DB::table('tbl_unit')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_periode = [
    [
        'id' => '1',
        'nama_periode' => 'Periode Mutu 2026',
        'tahun' => '2026',
        'tanggal_mulai' => '2026-01-01',
        'tanggal_selesai' => '2026-12-31',
        'deadline' => '5',
        'status_deadline' => 'f',
        'status' => 'aktif',
        'created_at' => '2026-04-15 08:29:31',
        'updated_at' => '2026-04-15 08:29:31',
    ],
];
        foreach ($data_tbl_periode as $item) {
            DB::table('tbl_periode')->updateOrInsert(['id' => $item['id']], $item);
        }

        $data_tbl_kategori_imprs = [
    [
        'id' => '1',
        'nama_kategori_imprs' => 'Sasaran Keselamatan Pasien (SKP)',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '2',
        'nama_kategori_imprs' => 'Identifikasi Pasien',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '3',
        'nama_kategori_imprs' => 'Komunikasi Efektif',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '4',
        'nama_kategori_imprs' => 'Keamanan Obat',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '5',
        'nama_kategori_imprs' => 'Tepat Lokasi dan Prosedur',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '6',
        'nama_kategori_imprs' => 'Risiko Infeksi',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '7',
        'nama_kategori_imprs' => 'Risiko Jatuh',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '8',
        'nama_kategori_imprs' => 'Pelayanan Klinis Prioritas',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '9',
        'nama_kategori_imprs' => 'Tujuan Strategis RS',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '10',
        'nama_kategori_imprs' => 'Perbaikan Sistem Lintas Unit',
        'created_at' => null,
        'updated_at' => null,
    ],
    [
        'id' => '11',
        'nama_kategori_imprs' => 'Manajemen Resiko',
        'created_at' => null,
        'updated_at' => null,
    ],
];
        foreach ($data_tbl_kategori_imprs as $item) {
            DB::table('tbl_kategori_imprs')->updateOrInsert(['id' => $item['id']], $item);
        }

        // --- SEED HAK AKSES ---
        $mapping_hak_akses = [
            // Role 2: Tim Mutu - Akses Semua Halaman
            2 => [
                'dashboard', 'master_indikator', 'kamus_indikator', 'laporan_analis', 'laporan_validator', 'analisa_data', 'pdsa',
                'master_spm', 'laporan_spm', 'analisa_spm',
                'kategori_imprs', 'jenis_indikator', 'dimensi_mutu', 'periode_analisis_data', 'periode_pengumpulan_data', 'penyajian_data', 'metode_pengumpulan_data',
                'hak_akses', 'manajemen_user', 'manage_role', 'manajemen_unit', 'periode_mutu'
            ],

            // Role 3: Validator
            3 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_validator'],

            // Role 4: Staff
            4 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_analis'],

            // Role 5: Koordinator
            5 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_analis', 'laporan_validator'],

            // Role 6: Penanggung Jawab
            6 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_analis'],

            // Role 7: Supervisor
            7 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_validator', 'analisa_data', 'pdsa'],

            // Role 8: Kepala unit
            8 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_validator', 'analisa_data', 'pdsa'],

            // Role 9: Kepala
            9 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'analisa_data'],

            // Role 10: Dokter Spesialis
            10 => ['dashboard', 'kamus_indikator', 'laporan_spm', 'analisa_spm', 'laporan_analis']
        ];

        foreach ($mapping_hak_akses as $role_id => $menus) {
            // Hapus hak akses lama untuk role ini agar tidak duplikat saat re-seed
            DB::table('tbl_hak_akses')->where('role_id', $role_id)->delete();

            foreach ($menus as $menu_key) {
                DB::table('tbl_hak_akses')->insert([
                    'role_id' => $role_id,
                    'menu_key' => $menu_key,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("Master data and Hak Akses synchronized.");
    }
}
