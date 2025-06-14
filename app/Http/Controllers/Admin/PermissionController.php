<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\Permission;
use App\Models\System\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        // // Kosongkan tabel permissions
        // Permission::truncate();

        // // Dapatkan semua rute yang memiliki nama
        // $routes = Route::getRoutes()->getRoutesByName();
        // $role = Role::latest()->get();

        // foreach ($role as $item) {
        //     # code...
        //     foreach ($routes as $routeName => $route) {
        //         // Simpan routeName dan URL ke tabel permissions
        //         Permission::create([
        //             'url' => $routeName, // Menggunakan nama rute sebagai identifikasi
        //             'role_id' => $item->id // Set default jobLvl, ini dapat diubah sesuai kebutuhan Anda
        //         ]);
        //     }
        // }

        if ($request->ajax()) {
            $data = Role::query()->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn_1 = '<a href="' . route('admin.permission.show', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-info editPost"><i class="ti ti-edit f-20"></i></a>';
                    $btn = $btn_1 . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-url="' . route('admin.permission.destroy', $row->id) . '" data-original-title="Delete" class="avtar avtar-s btn-link-danger deletePost"><i class="ti ti-trash f-20"></i></a>';
                    return $btn;
                })
                ->addColumn('jumlah', function ($row) {
                    $btn = count($row->permission) . ' Url Access permission to users';
                    return $btn;
                })

                ->rawColumns(['action', 'jumlah'])
                ->make(true);
        }
        return view('admin.permission.index');
    }

    public function hrisGetEmployee()
    {
        $text = 'https://api-pharma.kalbe.co.id/v1/ListJobLvlName';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-API-Key' => 'SQA45CsPgqRCeyoO0ZzeKK6BFG1vpR1vy7r-gvPiEw4',
        ])->get($text);
        $response = $response->json();

        foreach ($response as $key => $value) {
            # code...
            Role::create([
                'name' => $value
            ]);
        }
    }

    public function create()
    {
        // Ambil semua rute dari aplikasi
        $routes = Route::getRoutes()->getRoutesByName();
        return view('admin.permission.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'urls' => 'required|array',
            'jobLvl' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->jobLvl
            ]);

            // Perbarui izin berdasarkan URL yang dipilih
            foreach ($request->input('urls', []) as $url) {
                $role->permission()->create(['url' => $url]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permission Has Been Created',
                'redirect' => route('admin.permission.index')
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        $role = Role::with('permission')->find($id);

        $routes = Route::getRoutes()->getRoutesByName();
        return view('admin.permission.edit', compact('role', 'routes'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->jobLvl]);

        // Hapus permissions lama jika ada
        $role->permission()->delete();

        // Perbarui izin berdasarkan URL yang dipilih
        foreach ($request->input('urls', []) as $url) {
            $role->permission()->create(['url' => $url]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success Update',
            'redirect' => route('admin.permission.index')
        ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
