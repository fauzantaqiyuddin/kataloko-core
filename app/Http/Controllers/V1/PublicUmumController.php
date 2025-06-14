<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use App\Models\V1\Sosialisasi;
use App\Models\V1\UserMstd;
use App\Services\Dept\MasterDeptService;
use App\Services\System\ApprovalMailService;
use App\Services\V1\AjaxHrisAuthService;
use App\Services\V1\Opl\AddedViewOplService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicUmumController extends Controller
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
            ->where('umum', 'public')
            ->whereJsonContains('distribusi', auth()->user()->groupName)
            ->paginate(6)
            ->appends(request()->query()); // ⬅️ ini penting!

        $dept = $this->listDept();
        return view('v1.publicUmum.index', compact('data', 'dept'));
    }

    private function listDept()
    {
        return (new MasterDeptService)->handle();
    }

    public function show($id)
    {
        $data = Onepointlesson::query()
            ->with('lampiran', 'kategori', 'firstSosialisasi')
            ->whereJsonContains('distribusi', auth()->user()->groupName)
            ->whereId($id)
            ->first();

        if (empty($data)) {
            # code...
            return redirect()->route('v1.publicUmum.index')->with('galat', 'OPL Tidak Ditemukan');
        }

        (new AddedViewOplService)->handle($data);

        $category = CategoryUmum::latest()->get();

        return view('v1.publicUmum.show', compact('data', 'category'));
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

            if ($data->user == auth()->user()->email) {
                # code...
                return response()->json([
                    'success' => false,
                    'message' => 'Owner OnePointLesson Tidak Bisa Ikut Sosialisasi !'
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

            $checkCountSosialisasi = Sosialisasi::where('opl_id', $data->id)->count();
            if ($checkCountSosialisasi >= 2) {
                # code...
                $data->update([
                    'progress' => 401
                ]);

                // Notif Ke MSTD
                $message = 'Halo anda baru saja menerima permintaan persetujuan OnePointLesson yang telah dibuat oleh ' . $data->pemohon->fullname . ' Silahkan lakukan persetujuan segera.';
                $params = [
                    'status' => 'Waiting Approval MSTD',
                    'link' => route('v1.approval.mstd.index'),
                    'penerima' => 'MSTD Users',
                    'body' => $message
                ];
                $mstdOfficer = UserMstd::pluck('email');
                (new ApprovalMailService)->handle($mstdOfficer, $params);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih Telah Mengikuti Sosialisasi',
                'redirect' => route('v1.publicUmum.index', $id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
