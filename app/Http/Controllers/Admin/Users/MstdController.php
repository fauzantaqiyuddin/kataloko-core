<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\V1\Company;
use App\Models\V1\UserMstd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class MstdController extends Controller
{
    public function index(Request $request)
    {
        // dd($data);
        if ($request->ajax()) {
            $data = UserMstd::latest()->with('company')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<ul class="list-inline me-auto mb-0">
                                                <li class="list-inline-item align-bottom"
                                                    title="Delete">
                                                    <button type="button" data-url="' . route('admin.users.mstd.destroy', $row->id) . '" class="btn btn-sm btn-outline-danger deletePost" style="border-radius: 7px;">
                                                        <i class="ti ti-trash f-18"></i>
                                                    </button>
                                                </li>
                                            </ul>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $company = Company::latest()->get();
        return view('admin.users.mstd.index', compact('company'));
    }

    public function hrisGetEmployee(Request $request)
    {
        // $users = User::where('fullname', 'like', '%' . $request->q . '%')->get();
        $text = 'https://api-pharma.kalbe.co.id/v1/ListUsers/Name?SearchbyName=' . $request->q;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        $data = [];
        foreach ($response as $item) {
            # code...
            $data[] = [
                'id' => $item['EmpID'],
                'fullname' => $item['EmployeeName'],
                'email' => $item['EmpEmail'],
                'phone' => $item['EmpHandPhone'] ?? 'NA',
                'jobTitle' => $item['JobTtlName'],
                'subDept' => $item['OrgName'],
                'dept' => $item['OrgGroupName'],
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $data = UserMstd::where('nik', $request->nik)->first();
        if (!empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Account Sudah Terdaftar'
            ]);
        } else {
            # code...
            UserMstd::create([
                'fullname' => $request->fullname,
                'nik' => $request->nik,
                'email' => $request->email,
                'dept' => $request->dept,
                'phone' => $request->phone,
                'compCode' => $request->site
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Account Berhasil didaftarkan'
            ]);
        }
    }

    public function destroy($id)
    {
        $data = UserMstd::find($id);
        if (empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Account Tidak Bisa dihapus'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account Berhasil dihapus'
        ]);
    }
}
