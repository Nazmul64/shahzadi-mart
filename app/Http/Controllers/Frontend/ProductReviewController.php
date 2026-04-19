<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Producreview;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    // ─── রিভিউ সাবমিট (POST) ─────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'nullable|string|max:1000',
        ]);

        $userId    = Auth::id();
        $productId = $request->product_id;

        // আগে রিভিউ দিয়েছে কিনা চেক
        $existing = Producreview::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($existing) {
            // আপডেট করো
            $existing->update([
                'rating'  => $request->rating,
                'review'  => $request->review,
                'is_approved' => false, // re-submitted → pending again
            ]);

            return redirect()->back()->with('success', 'রিভিউ আপডেট হয়েছে। অনুমোদনের পর প্রকাশিত হবে।');
        }

        // নতুন রিভিউ তৈরি
        Producreview::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'order_id'   => $request->order_id ?? null,
            'rating'     => $request->rating,
            'review'     => $request->review,
            'is_approved'=> false,
        ]);

        return redirect()->back()->with('success', 'রিভিউ জমা হয়েছে। অনুমোদনের পর প্রকাশিত হবে।');
    }

    // ─── ইউজার ড্যাশবোর্ডে Pending Reviews ──────────────────────────────────
    // (FrontendController::user_dashboard() এ ইতোমধ্যে orders আছে,
    //  তাই এখানে শুধু delivered orders-এর unreviewed items দেখাবো)
    // এটা সরাসরি view-তে handle হবে, আলাদা method দরকার নেই।

    // ─── Admin: সব রিভিউ দেখো ────────────────────────────────────────────────
    public function adminIndex()
    {
        $reviews = Producreview::with(['user', 'product'])
                               ->latest()
                               ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    // ─── Admin: Approve / Reject ──────────────────────────────────────────────
    public function approve($id)
    {
        $review = Producreview::findOrFail($id);
        $review->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'রিভিউ অনুমোদন করা হয়েছে।');
    }

    public function reject($id)
    {
        $review = Producreview::findOrFail($id);
        $review->update(['is_approved' => false]);
        return redirect()->back()->with('success', 'রিভিউ বাতিল করা হয়েছে।');
    }

    public function destroy($id)
    {
        Producreview::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'রিভিউ মুছে ফেলা হয়েছে।');
    }
}
