<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\Banner;
use App\Models\V1\Company;
use App\Services\System\UploadToMinioService;
use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::query()->with('company')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.banner.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        $company = Company::latest()->get();
        return view('admin.banner.index', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,gif'
        ]);

        Banner::create([
            'compCode' => $request->site,
            'user_id' => auth()->user()->id,
            'lampiran' => (new UploadToMinioService)->handle($request->image, 'banner')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Upload Banner',
            'redirect' => route('admin.banner.index')
        ]);
    }

    public function destroy($id)
    {
        $data = Banner::find($id);
        // Pastikan menu tidak memiliki submenu
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Banner Not Found'
            ]);
        }

        try {
            DB::beginTransaction();
            $fileName = $data->lampiran;
            $directory = 'comim/banner';
            Miniojan::delete($directory, $fileName);
            $data->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Banner has been deleted'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return response()->json([
                'success' => true,
                'message' => 'Banner has been deleted',
                'data' => $th
            ]);
        }
    }
}
