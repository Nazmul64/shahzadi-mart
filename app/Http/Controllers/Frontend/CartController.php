<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════════
    //  CART INDEX  ─ GET /cart
    // ══════════════════════════════════════════════════════════════════════════

    public function index(): View
    {
        $cartItems      = session()->get('cart', []);
        $couponCode     = session()->get('coupon_code');
        $couponDiscount = session()->get('coupon_discount', 0);

        return view('frontend.cart', compact('cartItems', 'couponCode', 'couponDiscount'));
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  ADD TO CART  ─ POST /cart/add/{id}
    //
    //  JS থেকে FormData তে _token এবং X-CSRF-TOKEN header দুটোই পাঠানো হচ্ছে।
    //  Laravel built-in VerifyCsrfToken middleware যেকোনো একটা পেলেই pass করে।
    // ══════════════════════════════════════════════════════════════════════════

    public function add(Request $request, int $id): JsonResponse|RedirectResponse
    {
        /* ── Product খোঁজো ─────────────────────────────────────────────── */
        $product = Product::where('id', $id)
                          ->where('status', 'active')
                          ->firstOrFail();

        /* ── স্টক চেক ──────────────────────────────────────────────────── */
        if (! $product->is_unlimited && ($product->stock ?? 0) < 1) {
            $msg = '"' . $product->name . '" স্টকে নেই।';

            return $this->isAjax($request)
                ? response()->json([
                    'success'    => false,
                    'message'    => $msg,
                    'cart_count' => $this->cartCount(),
                ], 422)
                : redirect()->back()->with('error', $msg);
        }

        /* ── Input sanitize ─────────────────────────────────────────────── */
        $selectedColor = trim((string) $request->input('selected_color', '')) ?: null;
        $selectedSize  = trim((string) $request->input('selected_size',  '')) ?: null;
        $qty           = max(1, (int) $request->input('quantity', 1));

        /* ── Cart key: product + variant combo ──────────────────────────── */
        $cartKey = $this->buildCartKey($product->id, $selectedColor, $selectedSize);

        /* ── সর্বোচ্চ qty ───────────────────────────────────────────────── */
        $maxQty = $product->is_unlimited ? 9999 : (int) ($product->stock ?? 9999);

        /* ── Session আপডেট ──────────────────────────────────────────────── */
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = min($cart[$cartKey]['quantity'] + $qty, $maxQty);
        } else {
            $cart[$cartKey] = [
                'product_id'     => $product->id,
                'name'           => $product->name,
                'slug'           => $product->slug,
                'price'          => (float) $product->current_price,
                'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                'quantity'       => min($qty, $maxQty),
                'image'          => $product->feature_image,
                'category'       => $product->category->category_name ?? '',
                'category_id'    => $product->category_id,
                'product_type'   => $product->product_type ?? 'physical',
                'selected_color' => $selectedColor,
                'selected_size'  => $selectedSize,
            ];
        }

        session()->put('cart', $cart);

        /* ── Response ───────────────────────────────────────────────────── */
        $successMsg = '"' . $product->name . '" কার্টে যোগ হয়েছে!';

        return $this->isAjax($request)
            ? response()->json([
                'success'    => true,
                'message'    => $successMsg,
                'cart_count' => $this->cartCount(),
                'cart_key'   => $cartKey,
            ])
            : redirect()->back()->with('success', $successMsg);
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  REMOVE FROM CART  ─ POST /cart/remove/{key}
    //  (আগে GET ছিল, এখন POST — CSRF protection এর জন্য)
    // ══════════════════════════════════════════════════════════════════════════

    public function remove(Request $request, string $key): JsonResponse|RedirectResponse
    {
        $cart = session()->get('cart', []);
        $name = $cart[$key]['name'] ?? 'পণ্যটি';
        unset($cart[$key]);
        session()->put('cart', $cart);

        $msg = '"' . $name . '" কার্ট থেকে সরানো হয়েছে।';

        return $this->isAjax($request)
            ? response()->json([
                'success'    => true,
                'message'    => $msg,
                'cart_count' => $this->cartCount(),
            ])
            : redirect()->back()->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  INCREASE QTY  ─ POST /cart/increase/{key}
    // ══════════════════════════════════════════════════════════════════════════

    public function increase(Request $request, string $key): JsonResponse|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $product = Product::find($cart[$key]['product_id']);
            $maxQty  = ($product && ! $product->is_unlimited)
                       ? (int) ($product->stock ?? 9999)
                       : 9999;
            $cart[$key]['quantity'] = min($cart[$key]['quantity'] + 1, $maxQty);
            session()->put('cart', $cart);
        }

        return $this->isAjax($request)
            ? response()->json([
                'success'    => true,
                'quantity'   => $cart[$key]['quantity'] ?? 1,
                'cart_count' => $this->cartCount(),
                'subtotal'   => $this->lineSubtotal($cart[$key] ?? []),
                'cart_total' => $this->cartTotal($cart),
            ])
            : redirect()->back();
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  DECREASE QTY  ─ POST /cart/decrease/{key}
    // ══════════════════════════════════════════════════════════════════════════

    public function decrease(Request $request, string $key): JsonResponse|RedirectResponse
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($cart[$key]['quantity'] <= 1) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity']--;
            }
            session()->put('cart', $cart);
        }

        return $this->isAjax($request)
            ? response()->json([
                'success'    => true,
                'quantity'   => $cart[$key]['quantity'] ?? 0,
                'removed'    => ! isset($cart[$key]),
                'cart_count' => $this->cartCount(),
                'subtotal'   => $this->lineSubtotal($cart[$key] ?? []),
                'cart_total' => $this->cartTotal($cart),
            ])
            : redirect()->back();
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  CLEAR CART  ─ POST /cart/clear
    // ══════════════════════════════════════════════════════════════════════════

    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id']);

        return $this->isAjax($request)
            ? response()->json([
                'success'    => true,
                'message'    => 'কার্ট পরিষ্কার হয়েছে।',
                'cart_count' => 0,
            ])
            : redirect()->route('cart.index')->with('success', 'কার্ট পরিষ্কার হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  APPLY COUPON  ─ POST /cart/coupon
    // ══════════════════════════════════════════════════════════════════════════

    public function coupon(Request $request): RedirectResponse
    {
        $request->validate(['coupon_code' => 'required|string|max:50']);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))
                        ->where('status', 'active')
                        ->where(function ($q) {
                            $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                        })
                        ->first();

        if (! $coupon) {
            return redirect()->back()->with('error', 'কুপন কোডটি সঠিক নয় বা মেয়াদ শেষ।');
        }

        if ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
            return redirect()->back()->with('error', 'কুপনটির ব্যবহার সীমা শেষ।');
        }

        $cartItems = session()->get('cart', []);
        $subtotal  = collect($cartItems)->sum(
            fn ($i) => (($i['discount_price'] ?? null) ?: $i['price']) * $i['quantity']
        );

        $discount = $coupon->type === 'percent'
            ? round($subtotal * $coupon->value / 100, 2)
            : min((float) $coupon->value, $subtotal);

        session()->put('coupon_code',     $coupon->code);
        session()->put('coupon_discount', $discount);
        session()->put('coupon_id',       $coupon->id);

        return redirect()->back()->with(
            'success',
            'কুপন প্রয়োগ হয়েছে! ৳' . number_format($discount, 2) . ' ছাড় পেয়েছেন।'
        );
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  CART COUNT (AJAX badge refresh)  ─ GET /cart/count
    // ══════════════════════════════════════════════════════════════════════════

    public function count(): JsonResponse
    {
        return response()->json(['cart_count' => $this->cartCount()]);
    }

    // ══════════════════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════════════════

    private function buildCartKey(int $productId, ?string $color, ?string $size): string
    {
        return $productId
             . ($color ? '_c' . substr(md5($color), 0, 8) : '')
             . ($size  ? '_s' . substr(md5($size),  0, 8) : '');
    }

    private function cartCount(): int
    {
        return (int) collect(session()->get('cart', []))->sum('quantity');
    }

    private function lineSubtotal(array $item): float
    {
        if (empty($item)) return 0.0;
        $price = ($item['discount_price'] ?? null) ?: $item['price'];

        return round((float) $price * (int) ($item['quantity'] ?? 1), 2);
    }

    private function cartTotal(array $cart): float
    {
        return round(
            collect($cart)->sum(fn ($i) => $this->lineSubtotal($i)),
            2
        );
    }

    /**
     * AJAX request কিনা নির্ণয়।
     * Laravel এর ajax() = X-Requested-With header চেক করে।
     * wantsJson() / expectsJson() = Accept header চেক করে।
     */
    private function isAjax(Request $request): bool
    {
        return $request->ajax()
            || $request->wantsJson()
            || $request->expectsJson();
    }
}
