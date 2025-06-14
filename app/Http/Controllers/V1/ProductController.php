<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->urlToko()->url);
        return view('v1.product.index');
    }

    public function create()
    {
        return view('v1.product.create');
    }
}
