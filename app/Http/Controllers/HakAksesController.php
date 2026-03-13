<?php

namespace App\Http\Controllers;

use App\Models\tbl_hak_akses;
use App\Models\tbl_role;
use DB;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    public function __construct()
    {
        $this->menuStructure = config('menu');
    }

    private $menuStructure;

    // Display hak akses management page
    public function index(Request $request)
    {
        $selectedRole = $request->role_id ?? tbl_role::first()->id;

        if ($selectedRole == 1) {
            $allMenuKeys = [];
            foreach ($this->menuStructure as $group) {
                foreach ($group['menus'] as $menu) {
                    $allMenuKeys[] = $menu['key'];
                }
            }

            $hakAkses = $allMenuKeys;

        } else {
            $hakAkses = tbl_hak_akses::where('role_id', $selectedRole)
                ->pluck('menu_key')
                ->toArray();
        }

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
