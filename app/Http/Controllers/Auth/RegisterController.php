<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\System\VerificationUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required'
        ]);

        $otp = $this->generateRandomPassword();
        $phone = $request->phone;
        // Ubah awalan 0 menjadi 62 (kode negara Indonesia)
        $formattedPhone = preg_replace('/^0/', '62', $phone);
        $text = "*[VERIFIKASI KODE OTP]*\n\n"
            . "Kode OTP Anda adalah: *{$otp}*\n"
            . "Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari kami.\n\n"
            . "⏰ *Kode berlaku selama 5 menit.*\n"
            . "Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.\n\n"
            . "_Terima kasih_ 🙏";

        $response = Http::post('https://node.kalbe.my.id/api/send-message', [
            'apikey'   => 'fauzan2542',
            'mtype'    => 'text',
            'receiver' => $formattedPhone,
            'text'     => $text,
        ]);

        // Jika ingin mendapatkan hasilnya:
        if ($response->successful()) {
            // Berhasil
            $user = User::create([
                'fullname' => $request->name,
                'role' => 'user',
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);


            $userVerif = VerificationUser::create([
                'user_id' => $user->id,
                'expired_at' => now()->addMinutes(5),
                'otp' => Hash::make($otp)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Mendaftarkan Akun, Silahkan Verifikasi Akun',
                'redirect' => route('verify.index', $userVerif->id)
            ]);
        } else {
            // Gagal
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP',
                'body' => $response->body()
            ]);
        }
    }

    private function generateRandomPassword()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        $maxIndex = strlen($characters) - 1;
        $length = 5;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $maxIndex)];
        }

        return $password;
    }
}
