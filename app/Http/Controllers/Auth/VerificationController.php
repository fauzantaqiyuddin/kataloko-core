<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\System\VerificationUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    public function index($id)
    {
        $data = VerificationUser::find($id);
        if (empty($data)) {
            # code...
            abort(404);
        }

        return view('auth.verify', compact('data'));
    }

    public function store($id, Request $request)
    {
        $verificationCode = strtoupper(implode('', $request->code));

        $data = VerificationUser::query()
            ->find($id);

        if (!Hash::check($verificationCode, $data->otp)) {
            // Berhasil
            return response()->json([
                'success' => false,
                'message' => 'OTP yang anda masukan salah',
            ]);
        }

        User::whereId($data->user_id)->update([
            'verify_at' => now()
        ]);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Verifikasi Akun, Silahkan Login Kembali',
            'redirect' => route('login')
        ]);
    }
}
