<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSerialController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // Order by pinned first, then newest
        $products = $query->orderByDesc('is_pinned')
                          ->orderByDesc('id')
                          ->paginate(20);

        return view('admin.product_serial.index', compact('products'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'pinned_products' => 'nullable|array',
            'pinned_products.*' => 'exists:products,id'
        ]);

        $pinnedIds = $request->pinned_products ?? [];

        // Set is_pinned to 1 for selected products
        Product::whereIn('id', $pinnedIds)->update(['is_pinned' => true]);

        // Set is_pinned to 0 for unselected products
        Product::whereNotIn('id', $pinnedIds)->update(['is_pinned' => false]);

        return redirect()->back()->with('success', 'Product serials/priority updated successfully!');
    }
}
