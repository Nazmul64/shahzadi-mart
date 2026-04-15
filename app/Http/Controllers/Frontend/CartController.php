<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  SHOW CART
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        // $sidebarCategories ও $websetting → AppServiceProvider View Composer থেকে আসে
        return view('frontend.cart');
    }

    // ══════════════════════════════════════════════════════════════
    //  ADD TO CART
    // ══════════════════════════════════════════════════════════════

    public function add($id)
    {
        $product = Product::where('id', $id)
                          ->where('status', 'active')
                          ->firstOrFail();

        // Stock check (unlimited products always pass)
        if (!$product->is_unlimited && ($product->stock ?? 0) < 1) {
            return redirect()->back()->with('error', 'এই পণ্যটি বর্তমানে স্টকে নেই।');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Already in cart — increase qty (respect stock limit)
            $maxQty               = $product->is_unlimited ? 999 : ($product->stock ?? 999);
            $newQty               = $cart[$id]['quantity'] + 1;
            $cart[$id]['quantity'] = min($newQty, $maxQty);
        } else {
            $cart[$id] = [
                'name'           => $product->name,
                'price'          => (float) $product->current_price,
                'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                'quantity'       => 1,
                'image'          => $product->feature_image,
                'slug'           => $product->slug,
                'category'       => $product->category->category_name ?? '',
                'category_id'    => $product->category_id,
                'product_type'   => $product->product_type,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', '"' . $product->name . '" কার্টে যোগ হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  REMOVE FROM CART
    // ══════════════════════════════════════════════════════════════

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        // কার্ট খালি হয়ে গেলে কুপনও সরাও
        if (empty($cart)) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
        }

        return redirect()->back()->with('success', 'পণ্যটি কার্ট থেকে সরানো হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    //  INCREASE QTY
    // ══════════════════════════════════════════════════════════════

    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->back();
        }

        $product = Product::find($id);
        $maxQty  = ($product && !$product->is_unlimited && $product->stock !== null)
                    ? $product->stock
                    : 999;

        if ($cart[$id]['quantity'] < $maxQty) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        } else {
            return redirect()->back()->with('info', 'সর্বোচ্চ পরিমাণে পৌঁছে গেছেন।');
        }

        return redirect()->back();
    }

    // ══════════════════════════════════════════════════════════════
    //  DECREASE QTY
    // ══════════════════════════════════════════════════════════════

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->back();
        }

        if ($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
            session()->put('cart', $cart);
        } else {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // ══════════════════════════════════════════════════════════════
    //  CLEAR ENTIRE CART
    // ══════════════════════════════════════════════════════════════

    public function clear()
    {
        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id']);
        return redirect()->route('cart')->with('success', 'কার্ট পরিষ্কার হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    //  APPLY COUPON  (DB-driven, full validation)
    // ══════════════════════════════════════════════════════════════

    public function coupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('coupon_error', 'কার্ট খালি আছে, কুপন প্রয়োগ করা যাবে না।');
        }

        // ── ১. DB থেকে কুপন খোঁজো ────────────────────────────────
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'কুপন কোডটি বৈধ নয়।');
        }

        // ── ২. Status চেক ─────────────────────────────────────────
        if ($coupon->status !== 'activated') {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'এই কুপনটি নিষ্ক্রিয়।');
        }

        // ── ৩. মেয়াদ (start_date / end_date) চেক ─────────────────
        $today = Carbon::today();

        if ($coupon->start_date && $today->lt($coupon->start_date)) {
            return redirect()->back()->with('coupon_error', 'এই কুপনটি এখনো চালু হয়নি। চালু হবে: ' . $coupon->start_date->format('d M Y'));
        }

        if ($coupon->end_date && $today->gt($coupon->end_date)) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'এই কুপনের মেয়াদ শেষ হয়ে গেছে (' . $coupon->end_date->format('d M Y') . ')।');
        }

        // ── ৪. ব্যবহারসীমা চেক ────────────────────────────────────
        if ($coupon->quantity !== 'unlimited') {
            $limit = (int) $coupon->quantity_limit;
            if ($limit > 0 && $coupon->used >= $limit) {
                return redirect()->back()->with('coupon_error', 'এই কুপনের ব্যবহারসীমা শেষ হয়ে গেছে।');
            }
        }

        // ── ৫. allow_product_type চেক ─────────────────────────────
        $subtotal = 0;

        if ($coupon->allow_product_type === 'category' && $coupon->category_id) {
            // শুধু নির্দিষ্ট category-র পণ্যে ছাড়
            $eligible = collect($cart)->filter(function ($item) use ($coupon) {
                return isset($item['category_id']) && $item['category_id'] == $coupon->category_id;
            });

            if ($eligible->isEmpty()) {
                return redirect()->back()->with('coupon_error', 'এই কুপনটি আপনার কার্টের পণ্যে প্রযোজ্য নয়।');
            }

            foreach ($eligible as $item) {
                $price     = ($item['discount_price'] ?? null) ?: $item['price'];
                $subtotal += $price * $item['quantity'];
            }
        } else {
            // সব পণ্যে প্রযোজ্য
            foreach ($cart as $item) {
                $price     = ($item['discount_price'] ?? null) ?: $item['price'];
                $subtotal += $price * $item['quantity'];
            }
        }

        // ── ৬. ডিসকাউন্ট হিসাব ────────────────────────────────────
        if ($coupon->type === 'discount_by_percentage') {
            $discount = round($subtotal * ($coupon->percentage / 100), 2);
        } else {
            // discount_by_amount
            $discount = (float) $coupon->amount;
        }

        $discount = min($discount, $subtotal); // subtotal-এর বেশি ছাড় হবে না

        // ── Session-এ রাখো ─────────────────────────────────────────
        session()->put('coupon_code',     $code);
        session()->put('coupon_discount', $discount);
        session()->put('coupon_id',       $coupon->id);

        return redirect()->back()->with('success', 'কুপন কোড সফলভাবে প্রয়োগ হয়েছে! ছাড়: ৳' . number_format($discount, 2));
    }
}
