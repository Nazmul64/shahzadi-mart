<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Generalsetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function frontend()
    {
        $websetting = Generalsetting::first();
        $slider     = Slider::all();
        $categories = Category::all();
        $products   = Product::all();

        return view('frontend.index', compact('slider', 'categories', 'products', 'websetting'));
    }

    public function user_dashboard()
    {
        return view('userdashboard.master');
    }

    public function productdetails($slug)
    {
        // slug দিয়ে খোঁজো, না পেলে id দিয়ে খোঁজো
        $product = Product::with(['category', 'subCategory'])
            ->where('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? $slug : 0)
            ->firstOrFail();

        $relatedProducts = Product::with(['category'])
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                if ($product->category_id) {
                    $query->where('category_id', $product->category_id);
                }
            })
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.productdetails.productdetails', compact('product', 'relatedProducts'));
    }
}
