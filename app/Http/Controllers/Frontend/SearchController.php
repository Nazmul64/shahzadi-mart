<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  AJAX LIVE SEARCH (returns JSON for dropdown)
    // ══════════════════════════════════════════════════════════════

    public function ajax(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['products' => [], 'categories' => []]);
        }

        $products = Product::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
            })
            ->with('category')
            ->select('id', 'name', 'slug', 'feature_image', 'current_price', 'discount_price', 'stock', 'is_unlimited', 'category_id')
            ->limit(8)
            ->get()
            ->map(function ($p) {
                $price = $p->discount_price ?? $p->current_price;
                return [
                    'id'       => $p->id,
                    'name'     => $p->name,
                    'slug'     => $p->slug,
                    'image'    => asset('uploads/products/' . $p->feature_image),
                    'price'    => number_format($price, 0),
                    'old_price'=> $p->discount_price ? number_format($p->current_price, 0) : null,
                    'in_stock' => $p->is_unlimited || ($p->stock ?? 0) > 0,
                    'category' => $p->category->category_name ?? '',
                    'url'      => route('product.detail', $p->slug),
                ];
            });

        $categories = Category::where('status', 'active')
            ->where('category_name', 'like', "%{$q}%")
            ->select('id', 'category_name', 'slug', 'category_photo')
            ->limit(4)
            ->get()
            ->map(function ($c) {
                return [
                    'name'  => $c->category_name,
                    'url'   => url('category/' . $c->slug),
                    'image' => asset('uploads/category/' . $c->category_photo),
                ];
            });

        return response()->json([
            'products'   => $products,
            'categories' => $categories,
            'query'      => $q,
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  FULL SEARCH RESULTS PAGE
    // ══════════════════════════════════════════════════════════════

    public function results(Request $request)
    {
        $q = trim($request->get('q', ''));

        $products = collect();

        if (strlen($q) >= 2) {
            $products = Product::where('status', 'active')
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                          ->orWhere('slug', 'like', "%{$q}%");
                })
                ->with('category')
                ->orderByDesc('created_at')
                ->paginate(20)
                ->withQueryString();
        }

        return view('frontend.search_results', compact('products', 'q'));
    }
}
