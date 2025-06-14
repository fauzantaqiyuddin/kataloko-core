<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use App\Models\V1\Sosialisasi;
use App\Services\System\LogActivityService;
use App\Services\V1\AjaxHrisAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicRndController extends Controller
{
    public function index(Request $request)
    {
        $isRandD =
            isset(auth()->user()->result['DivName']) &&
            preg_match('/R\s*&\s*D/i', auth()->user()->result['DivName']);

        if ($isRandD) {
            # code...
            $query = OnePointLesson::query();

            if ($request->tema) {
                $query->where('tema', 'like', '%' . $request->tema . '%');
            }

            if ($request->dept) {
                $query->whereHas('pemohon', function ($q) use ($request) {
                    $q->where('groupName', $request->dept);
                });
            }

            $data = $query->where('umum', 'public')
                ->whereNotNull('category_rnd_id')
                ->with(['pemohon', 'firstImage'])
                ->orderBy('tema', 'ASC')
                ->paginate(6)
                ->appends(request()->query()); // ⬅️ tetap penting!

            return view('v1.publicRnD.index', compact('data'));
        }

        return view('layouts.forbidden');
    }

    public function show($id)
    {
        $data = Onepointlesson::query()
            ->with('lampiran', 'kategori', 'firstSosialisasi')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('v1.approval.superior.index')->with('galat', 'OPL Tidak Ditemukan');
        }

        $category = CategoryUmum::latest()->get();

        return view('v1.publicRnD.show', compact('data', 'category'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $kredential = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!(new AjaxHrisAuthService)->handle($kredential)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Login Gagal, Password Salah Atau Email Salah'
            ]);
        }

        try {
            DB::beginTransaction();

            $data = OnePointLesson::find($id);
            if (empty($data)) {
                # code...
                return response()->json([
                    'success' => false,
                    'message' => 'OnePointLesson Tidak tersedia'
                ]);
            }

            Sosialisasi::create([
                'user' => auth()->user()->email,
                'opl_id' => $data->id,
                'tgl_training' => now(),
                'traine' => auth()->user()->fullname,
                'sign_traine' => now(),
                'trainer' => $data->user,
                'status' => 'aprove'
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'SOSIALISASI',
                'catatan' => 'Berhasil Mengikuti Sosialisasi'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih Telah Mengikuti Sosialisasi',
                'redirect' => route('v1.publicRnD.show', $data->id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
