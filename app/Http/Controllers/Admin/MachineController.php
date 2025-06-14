<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\V1\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\DataTables;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Machine::query()->orderBy('title', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn_1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterMachine.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info editPost"><i class="ti ti-edit f-20"></i></a>';
                    $btn = $btn_1 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.masterMachine.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.machine.index');
    }

    public function show($id)
    {
        $product = Machine::find($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'The name field is required.'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->all()
            ]);
        }

        try {
            DB::beginTransaction();

            Machine::updateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'user_id' => auth()->user()->id,
                    'title' => $request->title,
                    'desc' => $request->desc,
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Machine Success Added'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th
            ]);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'berkas' => 'required|file'
        ]);

        (new FastExcel())->import($request->berkas, function ($line) {
            return Machine::create([
                'user_id' => auth()->user()->id,
                'title' => $line['TITLE'],
                'desc' => $line['DESC']
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Import Excell Success',
            'redirect' => route('admin.masterMachine.index')
        ]);
    }

    public function destroy($id)
    {
        $data = Machine::find($id);
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Machine Tidak Tersedia'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Machine Berhasil dihapus'
        ]);
    }
}
