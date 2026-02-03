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
                ['key' => 'laporan_analis', 'label' => 'Laporan Analis'],
                ['key'=> 'pdsa', 'label'=> 'PDSA'],
            ]
        ],
        'manajemen_data_mutu' => [
            'title' => 'Manajemen Data Mutu',
            'icon' => 'ri-list-check-2',
            'menus' => [

                ['key' => 'kategori_imprs', 'label' => 'Kategori IMPRS'],
                ['key' => 'jenis_indikator', 'label' => 'Jenis Indikator'],
                ['key' => 'dimensi_mutu', 'label' => 'Dimensi Mutu'],
                ['key' => 'periode_analisis_data', 'label' => 'Periode Analisis Data'],
                ['key' => 'periode_pengumpulan_data', 'label' => 'Periode Pengumpulan Data'],
                ['key' => 'penyajian_data', 'label' => 'Penyajian Data'],
                ['key' => 'metode_pengumpulan_data', 'label' => 'Metode Pengumpulan Data'],
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
