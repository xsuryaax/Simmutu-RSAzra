<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    public function index()
    {
        // Ambil semua role
        $roles = DB::table('tbl_role')->orderBy('id', 'ASC')->get();

        // Ambil semua unit
        $units = DB::table('tbl_unit')->where('status_unit', 'aktif')->orderBy('nama_unit')->get();

        // Ambil semua user + join role & unit
        $users = DB::table('users')
            ->leftJoin('tbl_role', 'users.role_id', '=', 'tbl_role.id')
            ->leftJoin('tbl_unit', 'users.unit_id', '=', 'tbl_unit.id')
            ->select(
                'users.*',
                'tbl_role.nama_role',
                'tbl_unit.nama_unit'
            )
            ->orderBy('users.id', 'ASC')
            ->get();

        return view('ManajemenUser.index', compact('users', 'roles', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required',
            'unit_id' => 'nullable',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'status_user' => $request->status_user ?? 'aktif',
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'role_id' => 'required',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'status_user' => $request->status_user,
        ];

        // Jika password diisi, update
        if ($request->password != null) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
