<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  SHOW CHECKOUT PAGE
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'কার্ট খালি আছে।');
        }

        return view('frontend.checkout');
    }

    // ══════════════════════════════════════════════════════════════
    //  PLACE ORDER
    // ══════════════════════════════════════════════════════════════

    public function place(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:120',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:500',
            'delivery_area'    => 'required|string|max:100',
            'shipping_charge_id' => 'nullable|exists:shipping_charges,id',
            'note'             => 'nullable|string|max:500',
            'payment_method'   => 'required|in:cod,bkash,shurjopay,uddoktapay,aamarpay',
        ]);

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'কার্ট খালি আছে।');
        }

        // ── Delivery fee: DB থেকে নাও, না পেলে fallback ──────────
        $deliveryFee = 0;
        if ($request->filled('shipping_charge_id')) {
            $shippingRecord = ShippingCharge::active()
                                ->find($request->shipping_charge_id);
            $deliveryFee = $shippingRecord ? (float) $shippingRecord->amount : 0;
        }

        // ── Calculate totals ────────────────────────────────────
        $subtotal = 0;
        $discount = (float) session()->get('coupon_discount', 0);

        foreach ($cartItems as $item) {
            $price     = ($item['discount_price'] ?? null) ?: $item['price'];
            $subtotal += $price * $item['quantity'];
        }

        $total = $subtotal - $discount + $deliveryFee;

        // ── Route to payment gateway if not COD ─────────────────
        if ($request->payment_method !== 'cod') {
            return $this->redirectToGateway($request, $subtotal, $discount, $deliveryFee, $total);
        }

        // ── Create order (DB transaction) ────────────────────────
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'user_id'        => Auth::id(),
                'customer_name'  => $request->customer_name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'delivery_area'  => $request->delivery_area,
                'note'           => $request->note,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status'   => 'pending',
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'delivery_fee'   => $deliveryFee,
                'total'          => $total,
                'coupon_code'    => session()->get('coupon_code'),
            ]);

            foreach ($cartItems as $cartKey => $item) {
                // ✅ product_id: item এ stored (variant-aware cart key এর জন্য)
                $productId = $item['product_id'] ?? $cartKey;
                $unitPrice = ($item['discount_price'] ?? null) ?: $item['price'];

                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $productId,
                    'product_name'   => $item['name'],
                    'product_image'  => $item['image'] ?? null,
                    'product_slug'   => $item['slug'] ?? null,
                    'price'          => $unitPrice,
                    'original_price' => $item['price'],
                    'quantity'       => $item['quantity'],
                    'subtotal'       => $unitPrice * $item['quantity'],
                    // ✅ color & size যদি orders_items table এ column থাকে
                    'selected_color' => $item['selected_color'] ?? null,
                    'selected_size'  => $item['selected_size'] ?? null,
                ]);

                // ── Stock কমাও ──────────────────────────────────
                $product = Product::find($productId);
                if ($product && !$product->is_unlimited && $product->stock !== null) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // ── কুপন used count ──────────────────────────────────
            $couponId = session()->get('coupon_id');
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used');
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'অর্ডার প্রক্রিয়া করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
        }

        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id']);

        return redirect()->route('order.success', $order->order_number)
                         ->with('success', 'আপনার অর্ডার সফলভাবে সম্পন্ন হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  ORDER SUCCESS PAGE
    // ══════════════════════════════════════════════════════════════

    public function success($orderNumber)
    {
        $order = Order::with('items')
                      ->where('order_number', $orderNumber)
                      ->firstOrFail();

        return view('frontend.order_success', compact('order'));
    }

    // ══════════════════════════════════════════════════════════════
    //  PAYMENT GATEWAY REDIRECT (placeholder)
    // ══════════════════════════════════════════════════════════════

    private function redirectToGateway(
        Request $request,
        float $subtotal,
        float $discount,
        float $deliveryFee,
        float $total
    ) {
        session()->put('pending_order', [
            'customer_name'  => $request->customer_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'delivery_area'  => $request->delivery_area,
            'note'           => $request->note,
            'payment_method' => $request->payment_method,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'delivery_fee'   => $deliveryFee,
            'total'          => $total,
            'coupon_code'    => session()->get('coupon_code'),
            'coupon_id'      => session()->get('coupon_id'),
        ]);

        return redirect()->back()
                         ->with('info', $request->payment_method . ' gateway শীঘ্রই চালু হবে। Cash on Delivery ব্যবহার করুন।');
    }
}
