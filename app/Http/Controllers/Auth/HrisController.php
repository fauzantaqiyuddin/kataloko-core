<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\System\Role;
use App\Models\User;
use App\Services\System\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HrisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Masukan Email',
            'email.email' => 'Email Tidak Valid',
            'password.required' => 'Masukan Password'
        ]);

        // Mengambil kredensial dari request
        $kredensil = $request->only('email', 'password');

        // Cek apakah user dengan email tersebut ada
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan.',
            ]);
        }

        // Coba melakukan autentikasi
        if (Auth::attempt($kredensil)) {
            return response()->json([
                'success' => true,
                'message' => 'Selamat datang, login berhasil.',
                'redirect' => route('v1.dashboard'),
            ]);
        }

        // Jika autentikasi gagal
        return response()->json([
            'success' => false,
            'message' => 'Login gagal, silakan ulangi.',
        ]);
    }

    public function logout(Request $request)
    {
        try {
            DB::beginTransaction();
           
            Auth::logout(); // Log out the user

            $request->session()->invalidate(); // Invalidate the session
            $request->session()->regenerateToken(); // Regenerate the session token

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out, Terima kasih',
                'redirect' => route('login'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
