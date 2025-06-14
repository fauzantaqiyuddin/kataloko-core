<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    public function index()
    {
        return view('v1.changeLog.index');
    }
}
