<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use App\Models\V1\Sosialisasi;
use App\Services\Dept\MasterDeptService;
use App\Services\V1\AjaxHrisAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SosialisasiController extends Controller
{
    public function index(Request $request)
    {
        $query = OnePointLesson::query();

        if ($request->tema) {
            $query->where('tema', 'like', '%' . $request->tema . '%');
        }

        if ($request->dept) {
            $query->whereHas('pemohon', function ($q) use ($request) {
                $q->where('groupName', $request->dept);
            });
        }

        $data = $query->with('pemohon', 'firstImage')
            ->orderBy('tema', 'ASC')
            // ->where('progress', 301)
            // ->whereNull('category_rnd_id')
            ->whereNotNull('category_rnd_id')
            ->paginate(6)
            ->appends(request()->query()); // ⬅️ ini penting!

        $dept = $this->listDept();
        return view('v1.sosialisasi.index', compact('data', 'dept'));
    }

    private function listDept()
    {
        return (new MasterDeptService)->handle();
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
                'trainer' => $data->user
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih Telah Mengikuti Sosialisasi',
                'redirect' => route('v1.sosialisasi.show', $data->id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
