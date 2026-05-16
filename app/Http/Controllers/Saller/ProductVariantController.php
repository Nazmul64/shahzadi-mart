<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductVariantController extends Controller
{
    public function brands()
    {
        $brands = DB::table('brands')->latest()->get();
        return view('saller.pages.variant.brand', compact('brands'));
    }

    public function colors()
    {
        $colors = DB::table('colors')->latest()->get();
        return view('saller.pages.variant.color', compact('colors'));
    }

    public function sizes()
    {
        $sizes = DB::table('sizes')->latest()->get();
        return view('saller.pages.variant.size', compact('sizes'));
    }

    public function units()
    {
        $units = DB::table('units')->latest()->get();
        return view('saller.pages.variant.unit', compact('units'));
    }
}
