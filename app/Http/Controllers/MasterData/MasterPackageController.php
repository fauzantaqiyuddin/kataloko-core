<?php
namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\MasterPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class MasterPackageController extends Controller
{
    public function index(Request $request)
    {
        $masterPackages = MasterPackage::latest()->get();
        if ($request->ajax()) {
            $data = $masterPackages;
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('masterData.masterPackage.index', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('masterData.masterPackage.index', compact('masterPackages'));
    }
}
