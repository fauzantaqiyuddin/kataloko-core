<?php

namespace App\Http\Middleware;

use App\Models\System\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJobLvlPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Dapatkan pengguna yang sedang login
        $user = $request->user();

        // Cek apakah pengguna sudah login dan memiliki jobLvl
        if (!$user || !$user->role) {
            return redirect()->route('login')->with('galat', 'Silakan login untuk melanjutkan.');
        }

        // Dapatkan nama rute saat ini
        $currentRoute = $request->route()->getName();
        // dd($currentRoute);

        // Cek apakah permission untuk jobLvl dan URL saat ini ada di database
        $hasPermission = Permission::where('role_id', $user->roles->id)
            ->where('url', $currentRoute)
            ->exists();

        // Jika tidak ada izin, tampilkan halaman forbidden
        if (!$hasPermission) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda Tidak Memiliki Akses Pada Action ini',
                ]);
            } else {
                return response()->view('layouts.forbidden');
            }
        }

        // Lanjutkan ke rute berikutnya jika izin ditemukan
        return $next($request);
    }
}
