<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Mail\FinishApproval;
use App\Models\V1\CategoryUmum;
use App\Models\V1\MasterDept;
use App\Models\V1\OnePointLesson;
use App\Services\Dept\MasterDeptService;
use App\Services\System\LogActivityService;
use App\Services\V1\AjaxHrisAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class MstdController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->where([
                    'progress' => 401
                ])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('v1.approval.mstd.show', $row->id) . '" class="btn btn-primary"><i class="ti ti-eye f-20"></i> Lihat</a>';
                    return $btn;
                })

                ->rawColumns(['action', 'approvalnya'])
                ->make(true);
        }
        return view('v1.opl.mstd.index');
    }

    public function show($id)
    {
        $data = Onepointlesson::query()
            ->with('mesin', 'lampiran', 'kategori')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('v1.approval.superior.index')->with('galat', 'OPL Tidak Ditemukan');
        }
        # code...
        $category = CategoryUmum::latest()->get();
        $dept = MasterDept::latest()->get();

        return view('v1.opl.mstd.show', compact('data', 'category', 'dept'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'dept' => 'required'
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
                    'message' => 'Data OPL Tidak Tersedia'
                ]);
            }

            $nomor = $this->generateNomor($data, $request);

            $data->update([
                'progress' => 501,
                'accMstd' => now(),
                'nomor' => $nomor
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'APROVED',
                'catatan' => 'MSTD Berhasil Telah Mempublish OPL'
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => '-',
                'user' => 'SYSTEM',
                'tindakan' => 'GENERATED',
                'catatan' => 'GENERATE NOMOR ' . $nomor . ' OnePointLesson'
            ]);

            $message = 'Halo, OnePointLesson anda sudah selesai persetujuan, silahkan cek kembali data anda';
            $email = [
                'status' => 'Finish Approval',
                'link' => route('v1.onePointLesson.index'),
                'penerima' => strstr($data->user, '@', true),
                'body' => $message
            ];
            Mail::to($data->user)->send(new FinishApproval($email));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Publish OnePoint Lesson',
                'redirect' => route('v1.approval.mstd.index')
            ]);
        } catch (\Throwable $th) {
            DB::commit();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function generateNomor($data, $request)
    {
        $category = CategoryUmum::find($data->category_umum_id);
        $nextNomor = $category->nomor + 1;

        $nomor = sprintf(
            'KF-OPL%s-%s-%04d.00',
            $category->deskripsi,
            $request->dept,
            $nextNomor
        );

        $category->update([
            'nomor' => $nextNomor
        ]);

        return $nomor;
    }
}
