<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\System\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readAll(Request $request)
    {
        try {
            Notification::where('user', auth()->user()->email)->update(['status' => 'read']);
            return response()->json([
                'success' => true,
                'message' => 'Mark As Read Success',
                'redirect' => route('v1.dashboard'),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
