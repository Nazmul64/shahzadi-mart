<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ── Helper: current owner query ───────────────────────────────

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

        // $sidebarCategories ও $websetting → AppServiceProvider View Composer থেকে আসে
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

    public function remove($itemId)
    {
        $item = $this->wishlistQuery()->findOrFail($itemId);
        $item->delete();

        return redirect()->back()->with('success', 'পণ্যটি উইশলিস্ট থেকে সরানো হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    //  CLEAR ALL WISHLIST
    // ══════════════════════════════════════════════════════════════

    public function clear()
    {
        $this->wishlistQuery()->delete();

        return redirect()->route('wishlist')->with('success', 'উইশলিস্ট সম্পূর্ণ পরিষ্কার হয়েছে।');
    }
}
