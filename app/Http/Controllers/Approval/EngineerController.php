<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryUmum;
use App\Models\V1\OnePointLesson;
use App\Services\System\LogActivityService;
use App\Services\V1\AjaxHrisAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EngineerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->where([
                    'progress' => 201
                ])
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('v1.approval.eng.show', $row->id) . '" class="btn btn-primary"><i class="ti ti-eye f-20"></i> Lihat</a>';
                    return $btn;
                })

                ->rawColumns(['action', 'approvalnya'])
                ->make(true);
        }
        return view('v1.opl.engineer.index');
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

        return view('v1.opl.engineer.show', compact('data', 'category'));
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

            if ($data->umum == 'private') {
                # code...
                $data->update([
                    'progress' => 401,
                    'accEngginer' => json_encode([
                        'tanggal' => now(),
                        'nama'    => auth()->user()->fullname
                    ]),
                ]);
            } else {
                # code...
                $data->update([
                    'progress' => 301,
                    'accEngginer' => json_encode([
                        'tanggal' => now(),
                        'nama'    => auth()->user()->fullname
                    ]),
                ]);
            }



            (new LogActivityService)->handle([
                'perusahaan' => strtoupper(auth()->user()->result['CompName']),
                'user' => strtoupper(auth()->user()->email),
                'tindakan' => 'APROVED',
                'catatan' => 'Engineer Berhasil Telah Mengetujui OPL'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Setujui OnePoint Lesson',
                'redirect' => route('v1.approval.eng.index')
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
