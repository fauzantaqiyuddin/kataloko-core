<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function show($url)
    {
        return view('landing.toko');
    }

    public function mockData($url)
    {
        $sellerInfo = [
            'name'        => 'Toko Berkah Jaya',
            'description' => 'Menyediakan produk berkualitas untuk kebutuhan sehari-hari',
            'location'    => 'Jakarta, Indonesia',
            'avatar'      => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
        ];

        $products = [
            [
                'id'    => 1,
                'name'  => 'Tas Ransel Premium Waterproof',
                'price' => 150000,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 2,
                'name'  => 'Sepatu Sneakers Casual Unisex',
                'price' => 275000,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 3,
                'name'  => 'Jam Tangan Smartwatch Sporty',
                'price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 4,
                'name'  => 'Kemeja Formal Pria Slim Fit',
                'price' => 185000,
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 5,
                'name'  => 'Dress Wanita Elegant Modern',
                'price' => 225000,
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 6,
                'name'  => 'Headphone Wireless Premium',
                'price' => 320000,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 7,
                'name'  => 'Parfum Unisex Long Lasting',
                'price' => 125000,
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&h=300&fit=crop',
            ],
            [
                'id'    => 8,
                'name'  => 'Kacamata Sunglasses UV Protection',
                'price' => 95000,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=300&fit=crop',
            ],
        ];

        return response()->json([
            'seller'   => $sellerInfo,
            'products' => $products,
        ]);
    }
}
