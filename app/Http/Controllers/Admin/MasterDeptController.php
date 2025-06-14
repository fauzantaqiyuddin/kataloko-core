<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\MasterDept;
use App\Services\Dept\MasterDeptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MasterDeptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterDept::query()->orderBy('EmpOrg', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterDept.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info editPost"><i class="ti ti-edit f-20"></i></a>';
                    $btn = $btn_1 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterDept.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.masterDept.index');
    }

    public function getHrisDept()
    {
        $data = (new MasterDeptService)->handle();

        foreach ($data as $key => $item) {
            # code...
            MasterDept::create([
                'EmpOrg' => $item['EmpOrg'],
                'OrgName' => $item['OrgName'],
                'OrgGroup' => $item['OrgGroup'],
                'OrgGroupName' => $item['OrgGroupName'],
                'EmpCompany' => $item['EmpCompany'],
                'CompName' => $item['CompName'],
                'CodeDept' => null,
            ]);
        }

        return redirect()->route('admin.masterDept.index')->with('success', 'Success Added Master Data Dept');
    }

    public function show($id)
    {
        $product = MasterDept::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $data = MasterDept::find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Master Dept Tidak Tersedia'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Master Dept Berhasil dihapus'
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'codeDept' => 'required',
        ], [
            'codeDept.required' => 'Masukan codeDept'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->all()
            ]);
        }

        try {
            DB::beginTransaction();

            MasterDept::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'CodeDept' => $request->codeDept,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Successfully Submit CodeDept'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
