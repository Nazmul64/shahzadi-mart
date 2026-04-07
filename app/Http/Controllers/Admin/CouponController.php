<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildSubCategory;
use App\Models\Coupon;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        $categories    = Category::where('status', 1)->get();
        $subCategories = SubCategory::where('status', 1)->get();
        $childSubs     = ChildSubCategory::where('status', 1)->get();
        return view('admin.coupon.create', compact('categories', 'subCategories', 'childSubs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'                  => 'required|string|unique:coupons,code',
            'allow_product_type'    => 'required|in:all,category,sub_category,child_sub_category',
            'category_id'           => 'nullable|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'type'                  => 'required|in:discount_by_percentage,discount_by_amount',
            'percentage'            => 'nullable|numeric|min:0|max:100',
            'amount'                => 'nullable|numeric|min:0',
            'quantity'              => 'required|in:unlimited,limited',
            'quantity_limit'        => 'nullable|integer|min:1',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
        ]);

        Coupon::create([
            'code'                  => strtoupper(trim($request->code)),
            'allow_product_type'    => $request->allow_product_type,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id,
            'child_sub_category_id' => $request->child_sub_category_id,
            'type'                  => $request->type,
            'percentage'            => $request->type === 'discount_by_percentage' ? $request->percentage : null,
            'amount'                => $request->type === 'discount_by_amount' ? $request->amount : null,
            'quantity'              => $request->quantity,
            'quantity_limit'        => $request->quantity === 'limited' ? $request->quantity_limit : null,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'status'                => 'activated',
        ]);

        return redirect()->route('coupons.index')
                         ->with('success', 'Coupon created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $coupon        = Coupon::findOrFail($id);
        $categories    = Category::where('status', 1)->get();
        $subCategories = SubCategory::where('status', 1)->get();
        $childSubs     = ChildSubCategory::where('status', 1)->get();
        return view('admin.coupon.edit', compact('coupon', 'categories', 'subCategories', 'childSubs'));
    }

    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code'                  => 'required|string|unique:coupons,code,' . $id,
            'allow_product_type'    => 'required|in:all,category,sub_category,child_sub_category',
            'category_id'           => 'nullable|exists:categories,id',
            'sub_category_id'       => 'nullable|exists:sub_categories,id',
            'child_sub_category_id' => 'nullable|exists:child_sub_categories,id',
            'type'                  => 'required|in:discount_by_percentage,discount_by_amount',
            'percentage'            => 'nullable|numeric|min:0|max:100',
            'amount'                => 'nullable|numeric|min:0',
            'quantity'              => 'required|in:unlimited,limited',
            'quantity_limit'        => 'nullable|integer|min:1',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
        ]);

        $coupon->update([
            'code'                  => strtoupper(trim($request->code)),
            'allow_product_type'    => $request->allow_product_type,
            'category_id'           => $request->category_id,
            'sub_category_id'       => $request->sub_category_id,
            'child_sub_category_id' => $request->child_sub_category_id,
            'type'                  => $request->type,
            'percentage'            => $request->type === 'discount_by_percentage' ? $request->percentage : null,
            'amount'                => $request->type === 'discount_by_amount' ? $request->amount : null,
            'quantity'              => $request->quantity,
            'quantity_limit'        => $request->quantity === 'limited' ? $request->quantity_limit : null,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
        ]);

        return redirect()->route('coupons.index')
                         ->with('success', 'Coupon updated successfully.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:activated,deactivated',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $request->status]);
    }

    public function destroy(string $id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->route('coupons.index')
                         ->with('success', 'Coupon deleted successfully.');
    }
}
