<?php

namespace App\Http\Middleware;

use App\Models\System\Settings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dapatkan pengguna yang sedang login
        $user = $request->user();

        // Cek apakah pengguna sudah login dan memiliki jobLvl
        if (!$user || !$user->jobLvl) {
            return redirect('/login')->with('error', 'Silakan login untuk melanjutkan.');
        }

        if ($user->jobLvl != 'Administrator') {
            # code...
            $data = Settings::first();
            // Jika tidak ada izin, tampilkan halaman forbidden
            if ($data->maintenance == 'active') {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sedang Dalam Perbaikan System',
                    ]);
                } else {
                    return response()->view('layouts.maintenance');
                }
                // Lanjutkan ke rute berikutnya jika izin ditemukan
                return $next($request);
            }
            // Lanjutkan ke rute berikutnya jika izin ditemukan
            return $next($request);
        }
        // Lanjutkan ke rute berikutnya jika izin ditemukan
        return $next($request);
    }
}
