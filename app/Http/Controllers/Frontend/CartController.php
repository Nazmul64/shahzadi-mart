<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.cart');
    }

    public function add(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('status', 'active')->firstOrFail();

        if (!$product->is_unlimited && ($product->stock ?? 0) < 1) {
            return redirect()->back()->with('error', 'এই পণ্যটি বর্তমানে স্টকে নেই।');
        }

        $cart          = session()->get('cart', []);
        $selectedColor = $request->query('color');
        $selectedSize  = $request->query('size');

        $cartKey = $id;
        if ($selectedColor || $selectedSize) {
            $cartKey = $id . '_' . md5(($selectedColor ?? '') . '_' . ($selectedSize ?? ''));
        }

        if (isset($cart[$cartKey])) {
            $maxQty = $product->is_unlimited ? 999 : ($product->stock ?? 999);
            $cart[$cartKey]['quantity'] = min($cart[$cartKey]['quantity'] + 1, $maxQty);
        } else {
            $cart[$cartKey] = [
                'product_id'     => $id,
                'name'           => $product->name,
                'price'          => (float) $product->current_price,
                'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                'quantity'       => 1,
                'image'          => $product->feature_image,
                'slug'           => $product->slug,
                'category'       => $product->category->category_name ?? '',
                'category_id'    => $product->category_id,
                'product_type'   => $product->product_type,
                'selected_color' => $selectedColor,
                'selected_size'  => $selectedSize,
            ];
        }

        session()->put('cart', $cart);

        $variantInfo = '';
        if ($selectedColor) $variantInfo .= " (Color: {$selectedColor}";
        if ($selectedSize)  $variantInfo .= ($selectedColor ? ', ' : ' (') . "Size: {$selectedSize}";
        if ($variantInfo)   $variantInfo .= ')';

        return redirect()->back()->with('success', '"' . $product->name . '"' . $variantInfo . ' কার্টে যোগ হয়েছে!');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        if (empty($cart)) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
        }
        return redirect()->back()->with('success', 'পণ্যটি কার্ট থেকে সরানো হয়েছে।');
    }

    public function increase($key)
    {
        $cart = session()->get('cart', []);
        if (!isset($cart[$key])) return redirect()->back();

        $productId = $cart[$key]['product_id'] ?? $key;
        $product   = Product::find($productId);
        $maxQty    = ($product && !$product->is_unlimited && $product->stock !== null) ? $product->stock : 999;

        if ($cart[$key]['quantity'] < $maxQty) {
            $cart[$key]['quantity']++;
            session()->put('cart', $cart);
        } else {
            return redirect()->back()->with('info', 'সর্বোচ্চ পরিমাণে পৌঁছে গেছেন।');
        }
        return redirect()->back();
    }

    public function decrease($key)
    {
        $cart = session()->get('cart', []);
        if (!isset($cart[$key])) return redirect()->back();

        if ($cart[$key]['quantity'] > 1) {
            $cart[$key]['quantity']--;
            session()->put('cart', $cart);
        } else {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function clear()
    {
        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id']);
        return redirect()->route('cart')->with('success', 'কার্ট পরিষ্কার হয়েছে।');
    }

    public function coupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string|max:50']);

        $code = strtoupper(trim($request->coupon_code));
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('coupon_error', 'কার্ট খালি আছে, কুপন প্রয়োগ করা যাবে না।');
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'কুপন কোডটি বৈধ নয়।');
        }
        if ($coupon->status !== 'activated') {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'এই কুপনটি নিষ্ক্রিয়।');
        }

        $today = Carbon::today();
        if ($coupon->start_date && $today->lt($coupon->start_date)) {
            return redirect()->back()->with('coupon_error', 'এই কুপনটি এখনো চালু হয়নি। চালু হবে: ' . $coupon->start_date->format('d M Y'));
        }
        if ($coupon->end_date && $today->gt($coupon->end_date)) {
            session()->forget(['coupon_code', 'coupon_discount', 'coupon_id']);
            return redirect()->back()->with('coupon_error', 'এই কুপনের মেয়াদ শেষ হয়ে গেছে (' . $coupon->end_date->format('d M Y') . ')।');
        }
        if ($coupon->quantity !== 'unlimited') {
            $limit = (int) $coupon->quantity_limit;
            if ($limit > 0 && $coupon->used >= $limit) {
                return redirect()->back()->with('coupon_error', 'এই কুপনের ব্যবহারসীমা শেষ হয়ে গেছে।');
            }
        }

        $subtotal = 0;
        if ($coupon->allow_product_type === 'category' && $coupon->category_id) {
            $eligible = collect($cart)->filter(fn($item) => isset($item['category_id']) && $item['category_id'] == $coupon->category_id);
            if ($eligible->isEmpty()) {
                return redirect()->back()->with('coupon_error', 'এই কুপনটি আপনার কার্টের পণ্যে প্রযোজ্য নয়।');
            }
            foreach ($eligible as $item) {
                $price     = ($item['discount_price'] ?? null) ?: $item['price'];
                $subtotal += $price * $item['quantity'];
            }
        } else {
            foreach ($cart as $item) {
                $price     = ($item['discount_price'] ?? null) ?: $item['price'];
                $subtotal += $price * $item['quantity'];
            }
        }

        $discount = $coupon->type === 'discount_by_percentage'
            ? round($subtotal * ($coupon->percentage / 100), 2)
            : (float) $coupon->amount;

        $discount = min($discount, $subtotal);

        session()->put('coupon_code',     $code);
        session()->put('coupon_discount', $discount);
        session()->put('coupon_id',       $coupon->id);

        return redirect()->back()->with('success', 'কুপন কোড সফলভাবে প্রয়োগ হয়েছে! ছাড়: ৳' . number_format($discount, 2));
    }
}
