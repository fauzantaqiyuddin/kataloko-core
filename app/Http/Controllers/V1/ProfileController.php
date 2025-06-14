<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\System\UploadToMinioService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('v1.profile.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'about' => 'required',
            'profile' => 'nullable|image|mimes:png,jpg|max:3070'
        ]);

        $data = User::find(auth()->user()->id);
        $data->update([
            'about' => $request->about,
            'profile' => $request->has('profile') ? (new UploadToMinioService)->handle($request->profile, 'profile') : $data->profile
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Melakukan Update Profile',
            'redirect' => route('v1.profile.index')
        ]);
    }
}
