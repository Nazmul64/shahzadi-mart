<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Campaigncreate;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    // Promo Codes
    public function promoCodes()
    {
        // For now, listing all coupons. In future, can filter by seller_id if column exists.
        $coupons = Coupon::latest()->get();
        return view('saller.pages.promotion.promo_code.index', compact('coupons'));
    }

    public function createPromoCode()
    {
        return view('saller.pages.promotion.promo_code.create');
    }

    public function storePromoCode(Request $request)
    {
        $request->validate([
            'code'           => 'required|unique:coupons,code',
            'type'           => 'required',
            'amount'         => 'nullable|numeric',
            'percentage'     => 'nullable|numeric',
            'quantity'       => 'required|integer',
            'quantity_limit' => 'required|integer',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date',
        ]);

        Coupon::create([
            'code'           => $request->code,
            'type'           => $request->type,
            'amount'         => $request->type === 'discount_by_amount' ? $request->amount : null,
            'percentage'     => $request->type === 'discount_by_percentage' ? $request->percentage : null,
            'quantity'       => 'limited',
            'quantity_limit' => $request->quantity_limit,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'status'         => 'activated',
        ]);

        return redirect()->route('saller.promotion.promo_code.index')->with('success', 'Promo Code created successfully');
    }

    public function editPromoCode($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('saller.pages.promotion.promo_code.edit', compact('coupon'));
    }

    public function updatePromoCode(Request $request, $id)
    {
        $request->validate([
            'code'           => 'required|unique:coupons,code,'.$id,
            'type'           => 'required',
            'amount'         => 'nullable|numeric',
            'percentage'     => 'nullable|numeric',
            'quantity_limit' => 'required|integer',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code'           => $request->code,
            'type'           => $request->type,
            'amount'         => $request->type === 'discount_by_amount' ? $request->amount : null,
            'percentage'     => $request->type === 'discount_by_percentage' ? $request->percentage : null,
            'quantity_limit' => $request->quantity_limit,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            // Status stays the same unless we add a status toggle in edit form
        ]);

        return redirect()->route('saller.promotion.promo_code.index')->with('success', 'Promo Code updated successfully');
    }

    public function updatePromoCodeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:activated,deactivated'
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function deletePromoCode($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('saller.promotion.promo_code.index')->with('success', 'Promo Code deleted successfully');
    }

    // Flash Deals
    public function flashDeals()
    {
        $deals = Campaigncreate::latest()->get();
        return view('saller.pages.promotion.flash_deals.index', compact('deals'));
    }

    // Banner Setup
    public function bannerSetup()
    {
        $banners = Slider::latest()->get();
        return view('saller.pages.promotion.banner_setup.index', compact('banners'));
    }
}
