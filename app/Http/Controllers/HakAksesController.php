<?php

namespace App\Http\Controllers;

use App\Models\tbl_hak_akses;
use App\Models\tbl_role;
use DB;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    // Define menu structure
    private $menuStructure = [
        'menu_utama' => [
            'title' => 'Menu Utama',
            'icon' => 'ri-dashboard-line',
            'menus' => [
                ['key' => 'dashboard', 'label' => 'Dashboard'],
                ['key' => 'master_indikator', 'label' => 'Master Indikator Mutu'],
                ['key' => 'kamus_indikator', 'label' => 'Kamus Indikator Mutu'],
                ['key' => 'laporan_analis_imprs', 'label' => 'Laporan Analis IMPRS'],
                ['key' => 'laporan_analis_impu', 'label' => 'Laporan Analis IMPU'],
                ['key' => 'laporan_analis_imn', 'label' => 'Laporan Analis IMN'],
                ['key'=> 'pdsa', 'label'=> 'PDSA'],
            ]
        ],
        'manajemen_data_mutu' => [
            'title' => 'Manajemen Data Mutu',
            'icon' => 'ri-list-check-2',
            'menus' => [

                ['key' => 'cakupan_data', 'label' => 'Cakupan Data'],
                ['key' => 'dimensi_mutu', 'label' => 'Dimensi Mutu'],
                ['key' => 'frekuensi_analisis_data', 'label' => 'Frekuensi Analisis Data'],
                ['key' => 'frekuensi_pengumpulan_data', 'label' => 'Frekuensi Pengumpulan Data'],
                ['key' => 'interpretasi_data', 'label' => 'Interpretasi Data'],
                ['key' => 'metodologi_analisis_data', 'label' => 'Metodologi Analisis Data'],
                ['key' => 'metodologi_pengumpulan_data', 'label' => 'Metodologi Pengumpulan Data'],
                ['key' => 'publikasi_data', 'label' => 'Publikasi Data'],
            ]
        ],
        'pengaturan' => [
            'title' => 'Pengaturan',
            'icon' => 'ri-database-2-line',
            'menus' => [
                ['key' => 'manajemen_user', 'label' => 'Manajemen User'],
                ['key' => 'manage_role', 'label' => 'Manajemen Role'],
                ['key' => 'manajemen_unit', 'label' => 'Manajemen Unit'],
                ['key' => 'hak_akses', 'label' => 'Hak Akses'],
            ]
        ]
    ];

    // Display hak akses management page
    public function index(Request $request)
    {
        $selectedRole = $request->role_id ?? tbl_role::first()->id;

        $hakAkses = tbl_hak_akses::where('role_id', $selectedRole)
            ->pluck('menu_key')
            ->toArray();

        return view('menu.HakAkses.index', [
            'menuStructure' => $this->menuStructure,
            'roles' => tbl_role::all(),
            'selectedRole' => $selectedRole,
            'hakAkses' => $hakAkses
        ]);
    }

    // Update hak akses for a role
    public function update(Request $request, $roleId)
    {
        $menuDipilih = $request->menu_key ?? [];

        tbl_hak_akses::where('role_id', $roleId)->delete();

        foreach ($menuDipilih as $key) {
            tbl_hak_akses::create([
                'role_id' => $roleId,
                'menu_key' => $key
            ]);
        }

        return redirect()->back()->with('success', 'Hak akses berhasil diperbarui!');
    }
}
