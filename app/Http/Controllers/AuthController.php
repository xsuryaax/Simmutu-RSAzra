<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    // SHOW LOGIN PAGE
    public function showLogin()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:5',
        ]);

        if (
            !Auth::attempt([
                'username' => $request->username,
                'password' => $request->password,
                'status_user' => 'aktif'
            ])
        ) {
            return back()->withErrors([
                'username' => 'Username, password, atau akun belum aktif.'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    // SHOW REGISTER PAGE
    public function showRegister()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'profesi' => 'nullable|in:Medis,Non Medis',
            'atasan_langsung' => 'nullable|string|max:255',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => null,
            'unit_id' => null,
            'profesi' => $request->profesi,
            'atasan_langsung' => $request->atasan_langsung,
            'status_user' => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
