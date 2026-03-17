<?php

return [
    'menu_utama' => [
        'title' => 'Menu Utama',
        'icon' => 'ri-dashboard-line',
        'menus' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'route' => 'dashboard'],
            ['key' => 'master_indikator', 'label' => 'Master Indikator', 'route' => 'master-indikator.index'],
            ['key' => 'kamus_indikator', 'label' => 'Profil Indikator', 'route' => 'kamus-indikator.index'],
            ['key' => 'laporan_analis', 'label' => 'Pengisian Indikator', 'route' => 'laporan-analis.index'],
            ['key' => 'laporan_validator', 'label' => 'Validasi Indikator', 'route' => 'laporan-validator.index'],
            ['key' => 'analisa_data', 'label' => 'Analisa Indikator', 'route' => 'analisa-data.index'],
            ['key' => 'pdsa', 'label' => 'PDSA', 'route' => 'pdsa.index'],

        ]
    ],
    'manajemen_data_mutu' => [
        'title' => 'Manajemen Data Mutu',
        'icon' => 'ri-list-check-2',
        'menus' => [
            ['key' => 'kategori_imprs', 'label' => 'Kategori IMPRS', 'route' => 'kategori-imprs.index'],
            ['key' => 'jenis_indikator', 'label' => 'Jenis Indikator', 'route' => 'jenis-indikator.index'],
            ['key' => 'dimensi_mutu', 'label' => 'Dimensi Mutu', 'route' => 'dimensi-mutu.index'],
            ['key' => 'periode_analisis_data', 'label' => 'Periode Analisis Data', 'route' => 'periode-analisis-data.index'],
            ['key' => 'periode_pengumpulan_data', 'label' => 'Periode Pengumpulan Data', 'route' => 'periode-pengumpulan-data.index'],
            ['key' => 'penyajian_data', 'label' => 'Penyajian Data', 'route' => 'penyajian-data.index'],
            ['key' => 'metode_pengumpulan_data', 'label' => 'Metode Pengumpulan Data', 'route' => 'metode-pengumpulan-data.index'],
        ]
    ],
    'pengaturan' => [
        'title' => 'Pengaturan',
        'icon' => 'ri-database-2-line',
        'menus' => [
            ['key' => 'hak_akses', 'label' => 'Hak Akses', 'route' => 'hak-akses.index'],
            ['key' => 'manajemen_user', 'label' => 'Manajemen User', 'route' => 'manajemen-user.index'],
            ['key' => 'manage_role', 'label' => 'Manajemen Role', 'route' => 'manajemen-role.index'],
            ['key' => 'manajemen_unit', 'label' => 'Manajemen Unit', 'route' => 'manajemen-unit.index'],
            ['key' => 'periode_mutu', 'label' => 'Manajemen Periode', 'route' => 'periode-mutu.index'],
        ]
    ]
];
