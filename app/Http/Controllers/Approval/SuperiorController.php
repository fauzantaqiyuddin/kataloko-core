<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use App\Models\V1\UserEngineer;
use App\Models\V1\UserMstd;
use App\Services\System\ApprovalMailService;
use App\Services\System\LogActivityService;
use App\Services\V1\AjaxHrisAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SuperiorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->where([
                    'supervisor' => auth()->user()->email,
                    'progress' => 101
                ])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('v1.approval.superior.show', $row->id) . '" class="btn btn-primary"><i class="ti ti-eye f-20"></i> Lihat</a>';
                    return $btn;
                })

                ->rawColumns(['action', 'approvalnya'])
                ->make(true);
        }
        return view('v1.opl.atasan.index');
    }

    public function show($id)
    {
        $data = Onepointlesson::query()
            ->with('mesin', 'lampiran')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('v1.approval.superior.index')->with('galat', 'OPL Tidak Ditemukan');
        }
        # code...
        $category = CategoryUmum::latest()->get();

        return view('v1.opl.atasan.show', compact('data', 'category'));
    }

    public function storeReject(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'alasan' => 'required'
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
                    'message' => 'Request Inaktivasi Tidak Tersedia'
                ]);
            }

            $data->update([
                'progress' => 102,
                'catatan' => $request->alasan
            ]);

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'REJECTED',
                'catatan' => 'OPL Reject Dengan Catatan : ' . $request->alasan
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Reject OnePointLesson',
                'redirect' => route('v1.approval.superior.index')
            ]);
        } catch (\Throwable $th) {
            DB::commit();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
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
                    'message' => 'Data Tidak Tersedia'
                ]);
            }

            if ($data->mesin_id != null) {
                $data->update([
                    'progress' => 201,
                    'accAtasan' => json_encode([
                        'tanggal' => now(),
                        'nama'    => auth()->user()->fullname
                    ]),
                ]);

                // Notif Ke ENG
                $message = 'Halo anda baru saja menerima permintaan persetujuan OnePointLesson yang telah dibuat oleh ' . $data->pemohon->fullname . ' Silahkan lakukan persetujuan segera.';
                $params = [
                    'status' => 'Waiting Approval ENGINEER',
                    'link' => route('v1.approval.eng.index'),
                    'penerima' => 'Team Engineer',
                    'body' => $message
                ];
                $userEng = UserEngineer::pluck('email');
                (new ApprovalMailService)->handle($userEng, $params);
            } else {
                if ($data->umum == 'private') {
                    # code...
                    $data->update([
                        'progress' => 401,
                        'accAtasan' => json_encode([
                            'tanggal' => now(),
                            'nama'    => auth()->user()->fullname
                        ]),
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
                } else {
                    # code...
                    $data->update([
                        'progress' => 301,
                        'accAtasan' => json_encode([
                            'tanggal' => now(),
                            'nama'    => auth()->user()->fullname
                        ]),
                    ]);

                    (new LogActivityService)->handle([
                        'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                        'user' => strtoupper(auth()->user()->email),
                        'tindakan' => 'SOSIALISASI',
                        'catatan' => 'OPL Sedang Tahap Sosialisasi'
                    ]);
                }
            }

            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'APROVED',
                'catatan' => 'SUPERIOR Berhasil Telah Mengetujui OPL'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Setujui OnePoint Lesson',
                'redirect' => route('v1.approval.superior.index')
            ]);
        } catch (\Throwable $th) {
            DB::commit();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
