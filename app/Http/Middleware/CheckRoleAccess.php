<?php

namespace App\Http\Middleware;

use App\Models\tbl_hak_akses;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $menuKey
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $menuKey = null)
    {
        $user = Auth::user();

        // biarkan auth middleware handle jika belum login
        if (!$user) {
            return $next($request);
        }

        // super admin bebas akses
        if ($user->role_id == 1) {
            return $next($request);
        }

        // jika menuKey kosong, akses diizinkan
        if (!$menuKey) {
            return $next($request);
        }

        // cek di tbl_hak_akses
        $hasAccess = tbl_hak_akses::where('role_id', $user->role_id)
            ->where('menu_key', $menuKey)
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
