<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════════════════════

    private function wishlistQuery()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id());
        }
        return Wishlist::where('session_id', session()->getId());
    }

    private function ownerData(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id(), 'session_id' => null];
        }
        return ['user_id' => null, 'session_id' => session()->getId()];
    }

    // ══════════════════════════════════════════════════════════════
    //  SHOW WISHLIST
    // ══════════════════════════════════════════════════════════════

    public function index()
    {
        $wishlistItems = $this->wishlistQuery()
                              ->with('product.category')
                              ->latest()
                              ->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    // ══════════════════════════════════════════════════════════════
    //  ADD TO WISHLIST
    // ══════════════════════════════════════════════════════════════

    public function add($id)
    {
        $product = Product::where('id', $id)
                          ->where('status', 'active')
                          ->firstOrFail();

        $owner = $this->ownerData();

        $exists = Wishlist::where('product_id', $id)
                          ->where(function ($q) use ($owner) {
                              if ($owner['user_id']) {
                                  $q->where('user_id', $owner['user_id']);
                              } else {
                                  $q->where('session_id', $owner['session_id']);
                              }
                          })->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'পণ্যটি ইতিমধ্যে উইশলিস্টে আছে।');
        }

        Wishlist::create(array_merge($owner, ['product_id' => $id]));

        return redirect()->back()->with('success', '"' . $product->name . '" উইশলিস্টে যোগ হয়েছে!');
    }

    // ══════════════════════════════════════════════════════════════
    //  REMOVE FROM WISHLIST
    // ══════════════════════════════════════════════════════════════



    // ══════════════════════════════════════════════════════════════
    //  MOVE TO CART  ← মূল পরিবর্তন এখানে
    //  Wishlist থেকে cart-এ add করে, তারপর wishlist থেকে remove করে
    // ══════════════════════════════════════════════════════════════

    public function moveToCart($itemId)
    {
        // wishlist item খোঁজো (owner-aware)
        $wishlistItem = $this->wishlistQuery()->findOrFail($itemId);

        $product = Product::where('id', $wishlistItem->product_id)
                          ->where('status', 'active')
                          ->firstOrFail();

        // Stock check
        if (!$product->is_unlimited && ($product->stock ?? 0) < 1) {
            return redirect()->back()->with('error', 'এই পণ্যটি বর্তমানে স্টকে নেই।');
        }

        // ── Cart session-এ add ──────────────────────────────────
        $cart    = session()->get('cart', []);
        $cartKey = $product->id;

        if (isset($cart[$cartKey])) {
            $maxQty = $product->is_unlimited ? 999 : ($product->stock ?? 999);
            $cart[$cartKey]['quantity'] = min($cart[$cartKey]['quantity'] + 1, $maxQty);
        } else {
            $cart[$cartKey] = [
                'product_id'     => $product->id,
                'name'           => $product->name,
                'price'          => (float) $product->current_price,
                'discount_price' => $product->discount_price ? (float) $product->discount_price : null,
                'quantity'       => 1,
                'image'          => $product->feature_image,
                'slug'           => $product->slug,
                'category'       => $product->category->category_name ?? '',
                'category_id'    => $product->category_id,
                'product_type'   => $product->product_type,
                'selected_color' => null,
                'selected_size'  => null,
            ];
        }

        session()->put('cart', $cart);

        // ── Wishlist থেকে item delete ───────────────────────────
        $wishlistItem->delete();

        return redirect()->back()->with('success', '"' . $product->name . '" কার্টে যোগ হয়েছে এবং উইশলিস্ট থেকে সরানো হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    //  CLEAR ALL WISHLIST
    // ══════════════════════════════════════════════════════════════

    public function clear()
    {
        $this->wishlistQuery()->delete();

        return redirect()->route('wishlist')->with('success', 'উইশলিস্ট সম্পূর্ণ পরিষ্কার হয়েছে।');
    }
    public function remove($id)
{
    $wishlist = session()->get('wishlist', []);

    if (isset($wishlist[$id])) {
        unset($wishlist[$id]);
        session()->put('wishlist', $wishlist);
    }

    return redirect()->back()->with('success', 'উইশলিস্ট থেকে সরানো হয়েছে।');
}
}
