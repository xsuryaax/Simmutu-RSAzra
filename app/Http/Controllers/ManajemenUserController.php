<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    // Display list of users
    public function index()
    {
        $roles = DB::table('tbl_role')->orderBy('id', 'ASC')->get();

        $units = DB::table('tbl_unit')->where('status_unit', 'aktif')->orderBy('nama_unit')->get();

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

        return view('menu.ManajemenUser.index', compact('users', 'roles', 'units'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nip' => 'nullable|string|max:50',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required',
            'unit_id' => 'nullable',
            'profesi' => 'nullable|in:Medis,Non Medis',
            'atasan_langsung' => 'nullable|string|max:255',
        ]);

        $status = $request->status_user ? 'aktif' : 'non-aktif';

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'profesi' => $request->profesi,
            'atasan_langsung' => $request->atasan_langsung,
            'status_user' => $status,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    // Edit user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'nip' => 'nullable|string|max:50',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'role_id' => 'required',
            'password' => 'nullable|min:6|confirmed',
            'profesi' => 'nullable|in:Medis,Non Medis',
            'atasan_langsung' => 'nullable|string|max:255',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'unit_id' => $request->unit_id,
            'profesi' => $request->profesi,
            'atasan_langsung' => $request->atasan_langsung,
            'status_user' => $request->status_user,
        ];

        if ($request->password != null) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    // Delete user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}