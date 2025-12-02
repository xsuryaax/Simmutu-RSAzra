<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ManajemenRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua role + hitung jumlah user yang memakai role tsb
        $roles = DB::table('tbl_role')
            ->leftJoin('users', 'tbl_role.id', '=', 'users.role_id')
            ->select(
                'tbl_role.id',
                'tbl_role.nama_role',
                'tbl_role.deskripsi_role',
                DB::raw('COUNT(users.id) as total_user')
            )
            ->groupBy('tbl_role.id', 'tbl_role.nama_role', 'tbl_role.deskripsi_role')
            ->orderBy('tbl_role.id', 'asc')
            ->get();

        // Hitung kartu statistik
        $total_role = $roles->count();
        $role_aktif = $roles->where('total_user', '>', 0)->count();
        $role_nonaktif = $roles->where('total_user', '=', 0)->count();

        return view('menu.ManajemenRole.index', compact(
            'roles',
            'total_role',
            'role_aktif',
            'role_nonaktif'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:50|unique:tbl_role,nama_role',
            'deskripsi_role' => 'nullable|string'
        ]);

        DB::table('tbl_role')->insert([
            'nama_role' => $request->nama_role,
            'deskripsi_role' => $request->deskripsi_role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Role baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = DB::table('tbl_role')->where('id', $id)->first();
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_role' => 'required|string|max:50|unique:tbl_role,nama_role,' . $id,
            'deskripsi_role' => 'nullable|string'
        ]);

        DB::table('tbl_role')->where('id', $id)->update([
            'nama_role' => $request->nama_role,
            'deskripsi_role' => $request->deskripsi_role,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Role berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cek apakah role dipakai user → kalau iya, jangan dihapus
        $cekUser = DB::table('users')->where('role_id', $id)->count();

        if ($cekUser > 0) {
            return back()->with('error', 'Role tidak dapat dihapus karena sedang digunakan user!');
        }

        DB::table('tbl_role')->where('id', $id)->delete();

        return back()->with('success', 'Role berhasil dihapus!');
    }
}
