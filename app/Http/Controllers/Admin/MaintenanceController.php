<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\Settings;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $data = Settings::first();
        return view('admin.settings.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mode' => 'required'
        ]);

        $data = Settings::first();
        if (empty($data)) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Settings Not Found'
            ]);
        }

        $data->update([
            'maintenance' => $request->mode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Update Mode Apps',
            'redirect' => route('admin.pageSettings.index')
        ]);
    }
}
