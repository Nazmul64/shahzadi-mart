<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class ShippingChargeController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  INDEX
    // ══════════════════════════════════════════════════════════════

    public function index(Request $request)
    {
        $query = ShippingCharge::query();

        if ($request->filled('search')) {
            $query->where('area_name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $shippingCharges = $query->latest()->paginate(10)->withQueryString();

        return view('admin.shipping.index', compact('shippingCharges'));
    }

    // ══════════════════════════════════════════════════════════════
    //  CREATE
    // ══════════════════════════════════════════════════════════════

    public function create()
    {
        return view('admin.shipping.create');
    }

    // ══════════════════════════════════════════════════════════════
    //  STORE
    // ══════════════════════════════════════════════════════════════

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_name' => 'required|string|max:255|unique:shipping_charges,area_name',
            'amount'    => 'required|numeric|min:0',
            'status'    => 'required|in:active,inactive',
        ], [
            'area_name.required' => 'এলাকার নাম আবশ্যক।',
            'area_name.unique'   => 'এই এলাকার নাম ইতিমধ্যে আছে।',
            'amount.required'    => 'পরিমাণ আবশ্যক।',
            'amount.numeric'     => 'পরিমাণ সংখ্যায় দিতে হবে।',
            'amount.min'         => 'পরিমাণ ০ বা তার বেশি হতে হবে।',
        ]);

        ShippingCharge::create($validated);

        return redirect()->route('admin.shipping.index')
                         ->with('success', 'শিপিং চার্জ সফলভাবে যোগ হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  EDIT
    // ══════════════════════════════════════════════════════════════

    public function edit(ShippingCharge $shipping)
    {
        return view('admin.shipping.edit', compact('shipping'));
    }

    // ══════════════════════════════════════════════════════════════
    //  UPDATE
    // ══════════════════════════════════════════════════════════════

    public function update(Request $request, ShippingCharge $shipping)
    {
        $validated = $request->validate([
            'area_name' => 'required|string|max:255|unique:shipping_charges,area_name,' . $shipping->id,
            'amount'    => 'required|numeric|min:0',
            'status'    => 'required|in:active,inactive',
        ], [
            'area_name.required' => 'এলাকার নাম আবশ্যক।',
            'area_name.unique'   => 'এই এলাকার নাম ইতিমধ্যে আছে।',
            'amount.required'    => 'পরিমাণ আবশ্যক।',
            'amount.numeric'     => 'পরিমাণ সংখ্যায় দিতে হবে।',
            'amount.min'         => 'পরিমাণ ০ বা তার বেশি হতে হবে।',
        ]);

        $shipping->update($validated);

        return redirect()->route('admin.shipping.index')
                         ->with('success', 'শিপিং চার্জ সফলভাবে আপডেট হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  DESTROY
    // ══════════════════════════════════════════════════════════════

    public function destroy(ShippingCharge $shipping)
    {
        $shipping->delete();

        return redirect()->route('admin.shipping.index')
                         ->with('success', 'শিপিং চার্জ সফলভাবে মুছে ফেলা হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  TOGGLE STATUS
    // ══════════════════════════════════════════════════════════════

    public function toggleStatus(ShippingCharge $shipping)
    {
        $shipping->update([
            'status' => $shipping->status === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->back()->with('success', 'স্ট্যাটাস পরিবর্তন হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    //  ✅ AJAX — Active shipping areas for checkout dropdown
    //  GET /shipping/areas  (JSON response)
    // ══════════════════════════════════════════════════════════════

    public function activeAreas()
    {
        $areas = ShippingCharge::active()
                    ->orderBy('area_name')
                    ->get(['id', 'area_name', 'amount']);

        return response()->json($areas);
    }
}
