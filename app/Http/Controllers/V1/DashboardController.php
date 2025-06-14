<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\System\Banner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $banner = Banner::query()
            ->latest()->get();

        return view('welcome', compact('banner'));

        // $message = 'Halo anda baru saja menerima permintaan persetujuan OnePointLesson yang telah dibuat oleh ' . auth()->user()->fullname . ' Silahkan lakukan persetujuan segera.';
        // $params = [
        //     'status' => 'Approval Superior',
        //     'link' => '#',
        //     'penerima' => 'Fauzan Taqiyuddin',
        //     'body' => $message
        // ];

        // dd((new ApprovalMailService)->handle('fauzan.taqiyuddin@kalbe.co.id', $params));
    }

    public function manualBook()
    {
        return view('v1.manualBook');
    }
}
