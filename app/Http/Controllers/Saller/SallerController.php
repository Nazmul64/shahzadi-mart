<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SallerController extends Controller
{
    public function saller_dashboard()
    {
        $seller_id = auth()->id();
        
        $total_products = \App\Models\Product::where('vendor', $seller_id)->count();
        $physical_products = \App\Models\Product::where('vendor', $seller_id)->where('product_type', 'physical')->count();
        $digital_products = \App\Models\Product::where('vendor', $seller_id)->where('product_type', 'digital')->count();
        $low_stock_products = \App\Models\Product::where('vendor', $seller_id)->where('product_type', 'physical')->where('stock', '<=', 10)->count();


        $data = [
            'total_products' => $total_products,
            'physical_products' => $physical_products,
            'digital_products' => $digital_products,
            'low_stock_products' => $low_stock_products,
        ];

        return view('saller.index', compact('data', 'total_products', 'physical_products', 'digital_products', 'low_stock_products'));
    }


}
