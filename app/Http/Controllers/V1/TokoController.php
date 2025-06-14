<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    public function index()
    {
        return view('v1.toko.index');
    }

    public function tokoBaru(Request $request)
    {
        $request->validate([
            'logo'   => 'required|image|mimes:png,jpg,jpeg|max:1030',
            'toko'   => 'required',
            'alamat' => 'required',
            'phone'  => 'required|numeric'
        ]);

        if (!auth()->user()->tokoSaya()) {
            // Simpan file logo ke folder public/assets/toko/logo/
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/toko/logo'), $logoName);

            // Simpan data ke database
            Toko::create([
                'user_id' => auth()->user()->id,
                'toko'    => $request->toko,
                'url'     => $request->slug,
                'alamat'  => $request->alamat,
                'phone'   => $request->phone,
                'logo'    => 'assets/toko/logo/' . $logoName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih',
                'redirect' => route('v1.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'sudah membuat toko'
        ]);
    }

    public function checkUrl(Request $request)
    {
        $slug = $request->get('slug');

        $exists = Toko::where('url', $slug)->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'URL tidak tersedia.'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'URL tersedia.'
        ]);
    }
}
