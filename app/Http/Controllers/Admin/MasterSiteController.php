<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\Company;
use App\Services\System\GetCompanySiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MasterSiteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::query()->orderBy('title', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterSite.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.company.index');
    }

    public function getSite(Request $request)
    {
        return (new GetCompanySiteService)->handle($request);
    }

    public function destroy($id)
    {
        $data = Company::find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Category Tidak Tersedia'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category Berhasil dihapus'
        ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->all()
            ]);
        }

        [$empCode, $compName] = explode(' - ', $request->site, 2);

        try {
            DB::beginTransaction();

            $data = Company::where('compCode', $empCode)->first();
            if (empty($data)) {
                # code...
                Company::create([
                    'compCode' => $empCode,
                    'title' => $compName,
                ]);
            } else {
                # code...
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah Terdaftar !'
                ]);
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Added Success Company Site Kalbe'
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
