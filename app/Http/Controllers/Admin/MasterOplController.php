<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\CategoryRnd;
use App\Models\V1\CategoryUmum;
use App\Models\V1\ImageOpl;
use App\Models\V1\Machine;
use App\Models\V1\OnePointLesson;
use App\Services\System\GetFasilitatorService;
use App\Services\System\GetHrisEmployeeService;
use App\Services\System\UploadToMinioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MasterOplController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OnePointLesson::query()
                ->orderBy('tema', 'ASC', 'approval')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('publishnya', function ($row) {
                    if ($row->status == 'publish') {
                        $publishnya = '<span class="badge text-bg-success">PUBLISH</span>';
                    } else {
                        # code...
                        $publishnya = '<span class="badge text-bg-warning">DRAFT</span>';
                    }

                    return $publishnya;
                })
                ->addColumn('atasan', function ($row) {
                    $getSPV = (new GetFasilitatorService)->handle($row);
                    return $getSPV['fullname'];
                })

                ->addColumn('approvalnya', function ($row) {
                    return $row->approval->description;
                })

                ->addColumn('action', function ($row) {
                    $btn_1 = '<a href="' . route('admin.masterOPL.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info"><i class="ti ti-edit f-20"></i></a>';
                    $btn = $btn_1 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterOPL.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action', 'publishnya', 'approvalnya', 'atasan'])
                ->make(true);
        }
        return view('v1.opl.operator.index');
    }

    public function create()
    {
        $category = CategoryUmum::latest()->get();
        $mesin = Machine::latest()->get();
        $rnd = CategoryRnd::latest()->get();
        return view('v1.opl.operator.create', compact('category', 'mesin', 'rnd'));
    }

    public function getHrisEmployee(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $groupCode = auth()->user()->groupKode;
            return (new GetHrisEmployeeService)->handle($request, $groupCode);
        }
    }

    public function store(Request $request)
    {
        if ($request->draft == 'enabled') {
            # code...
            $request->validate([
                'category' => 'required',
                'tema' => 'required',
                'fasilitator' => 'required'
            ]);

            try {
                DB::beginTransaction();

                Onepointlesson::create([
                    'user' => auth()->user()->email,
                    'category_umum_id' => $request->category,
                    'category_rnd_id' => $request->rnd ?? null,
                    'mesin_id' => $request->mesin ?? null,
                    'supervisor' => $request->fasilitator,
                    'tema' => $request->tema,
                    'tujuan' => $request->tujuan ?? null,
                    'fungsi' => $request->fungsi ?? null,
                    'prosedur' => $request->prosedur ?? null,
                    'dampak' => $request->dampak ?? null,
                    'sdwi' => $request->sd_wi ?? null,
                    // 'nomor' => 'OPL/XII/2024/MSTD.001',
                    'status' => 'draft',
                    'progress' => 100
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Menyimpan OPL Menjadi Draft',
                    'redirect' => route('v1.opl.index')
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
        } else {
            # code...
            $request->validate([
                'category' => 'required',
                'tema' => 'required',
                'fasilitator' => 'required',
                'tujuan' => 'required',
                'fungsi' => 'required',
                'prosedur' => 'required',
                'dampak' => 'required',
            ]);

            try {
                DB::beginTransaction();
                $opl = Onepointlesson::create([
                    'user' => auth()->user()->email,
                    'category_umum_id' => $request->category,
                    'category_rnd_id' => $request->rnd ?? null,
                    'mesin_id' => $request->mesin,
                    'supervisor' => $request->fasilitator,
                    'tema' => $request->tema,
                    'tujuan' => $request->tujuan,
                    'fungsi' => $request->fungsi,
                    'prosedur' => $request->prosedur,
                    'dampak' => $request->dampak,
                    'sdwi' => $request->sd_wi ?? null,
                    // 'nomor' => 'OPL/XII/2024/MSTD.001',
                    'status' => 'publish',
                    'progress' => 101
                ]);

                // History::create([
                //     'user_id' => auth()->user()->id,
                //     'opl_id' => $opl->id,
                //     'status' => 'approval',
                //     'kode' => 'Pemohon Telah Menyetujui OPL',
                // ]);

                if ($request->has('image') && is_array($request->image)) {
                    foreach ($request->image as $key => $gambar) {
                        if ($gambar) { // Memastikan $gambar tidak kosong
                            ImageOpl::create([
                                'user' => auth()->user()->email,
                                'opl_id' => $opl->id,
                                'image' => (new UploadToMinioService)->handle($gambar, 'opl'),
                                'deskripsi' => $request->descImage[$key] ?? 'NA'
                            ]);
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Mengirim OPL Kepada Superior',
                    'redirect' => route('admin.masterOPL.index')
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
        }
    }

    public function show($id, Request $request)
    {
        $data = Onepointlesson::query()
            ->with('mesin', 'lampiran')
            ->find($id);

        if (empty($data)) {
            # code...
            return redirect()->route('admin.masterOPL.index')->with('galat', 'OPL Tidak Ditemukan');
        }

        if ($data->status == 'draft') {
            # code...
            $category = CategoryUmum::latest()->get();
            $mesin = Machine::latest()->get();
            return view('v1.opl.operator.edit', compact('data', 'category', 'mesin'));
        } else {
            # code...

            if (in_array($data->progress, [102, 202])) {
                # return 
                $category = CategoryUmum::latest()->get();
                $mesin = Machine::latest()->get();
                $rnd = CategoryRnd::latest()->get();
                return view('v1.opl.operator.edit', compact('data', 'category', 'mesin', 'rnd'));
            } else {
                # code...
                $category = CategoryUmum::latest()->get();

                return view('v1.opl.operator.show', compact('data', 'category'));
            }
        }
    }
}
