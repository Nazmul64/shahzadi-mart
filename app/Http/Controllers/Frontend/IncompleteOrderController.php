<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\IncompleteOrder;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncompleteOrderController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  RULE:
    //  ফোন নম্বর দেওয়ার পরেই শুধু incomplete order সেভ হবে।
    //  নাম / ঠিকানা আগে থাকলেও phone ছাড়া insert হবে না।
    //  একই session-এ বারবার call হলে UPDATE করবে (upsert)।
    // ══════════════════════════════════════════════════════════════

    public function save(Request $request)
    {
        // ── Basic validation ──────────────────────────────────────
        $request->validate([
            'phone' => 'required|string|min:10|max:20',
        ]);

        $phone = trim($request->phone);

        // ── Phone হালকা sanitize (শুধু digits + leading +) ────────
        $phone = preg_replace('/[^\d+]/', '', $phone);
        if (strlen($phone) < 10) {
            return response()->json(['success' => false, 'message' => 'Invalid phone number'], 422);
        }

        // ── Cart snapshot ─────────────────────────────────────────
        $cartItems = session()->get('cart', []);
        $subtotal  = 0;
        foreach ($cartItems as $item) {
            $price     = ($item['discount_price'] ?? null) ?: $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        $discount    = (float) session()->get('coupon_discount', 0);
        $deliveryFee = 0;

        if ($request->filled('shipping_charge_id')) {
            $shipping    = ShippingCharge::find($request->shipping_charge_id);
            $deliveryFee = $shipping ? (float) $shipping->amount : 0;
        }

        $total = $subtotal - $discount + $deliveryFee;

        // ── Upsert: একই session-এ একটাই row রাখব ─────────────────
        $sessionId = session()->getId();

        IncompleteOrder::updateOrCreate(
            ['session_id' => $sessionId],       // match condition
            [
                'customer_name'    => $request->customer_name ?? null,
                'phone'            => $phone,
                'address'          => $request->address        ?? null,
                'delivery_area'    => $request->delivery_area  ?? null,
                'note'             => $request->note            ?? null,
                'payment_method'   => $request->payment_method ?? null,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'delivery_fee'     => $deliveryFee,
                'total'            => $total,
                'coupon_code'      => session()->get('coupon_code'),
                'cart_snapshot'    => $cartItems,
                'user_id'          => Auth::id(),
                'page_url'         => url()->previous(),
                'status'           => 'incomplete',
                'last_activity_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Incomplete order saved.',
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  UPDATE — যেকোনো field পরিবর্তন হলে live update
    //  (phone already saved, এখন address/area ইত্যাদি update)
    // ══════════════════════════════════════════════════════════════

    public function update(Request $request)
    {
        $sessionId = session()->getId();
        $record    = IncompleteOrder::where('session_id', $sessionId)
                                    ->where('status', 'incomplete')
                                    ->first();

        // Phone দেওয়া না থাকলে update করব না
        if (!$record) {
            return response()->json(['success' => false, 'skipped' => true]);
        }

        $deliveryFee = (float) $record->delivery_fee;
        if ($request->filled('shipping_charge_id')) {
            $shipping    = ShippingCharge::find($request->shipping_charge_id);
            $deliveryFee = $shipping ? (float) $shipping->amount : $deliveryFee;
        }

        $total = $record->subtotal - $record->discount + $deliveryFee;

        $updateData = ['last_activity_at' => now()];

        if ($request->has('customer_name'))  $updateData['customer_name']  = $request->customer_name;
        if ($request->has('address'))        $updateData['address']         = $request->address;
        if ($request->has('delivery_area'))  $updateData['delivery_area']   = $request->delivery_area;
        if ($request->has('note'))           $updateData['note']             = $request->note;
        if ($request->has('payment_method')) $updateData['payment_method']  = $request->payment_method;
        if ($request->has('shipping_charge_id')) {
            $updateData['delivery_fee'] = $deliveryFee;
            $updateData['total']        = $total;
        }

        $record->update($updateData);

        return response()->json(['success' => true]);
    }

    // ══════════════════════════════════════════════════════════════
    //  RECOVER — order complete হলে incomplete mark করুন
    //  (CheckoutController::finalizeOrder() থেকে call করবেন)
    // ══════════════════════════════════════════════════════════════

    public static function recover(): void
    {
        $sessionId = session()->getId();
        IncompleteOrder::where('session_id', $sessionId)
                       ->where('status', 'incomplete')
                       ->update(['status' => 'recovered']);
    }
}
