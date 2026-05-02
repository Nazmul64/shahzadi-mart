<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producreview;
use Illuminate\Http\Request;

class AdminproductReviewController extends Controller
{
    // ─── সব রিভিউ লিস্ট + ফিল্টার ─────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Producreview::with(['product', 'user'])->latest();

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_approved', $request->status === 'approved');
        }

        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search by product name or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('review', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15)->withQueryString();

        if (request()->routeIs('manager.*')) {
            return view('manager.reviews.index', compact('reviews'));
        }

        return view('admin.reviews.index', compact('reviews'));
    }

    // ─── একটি রিভিউ Approve করা ────────────────────────────────────────────
    public function approve($id)
    {
        $review = Producreview::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'রিভিউটি সফলভাবে অনুমোদন করা হয়েছে।');
    }

    // ─── একটি রিভিউ Unapprove করা (publish থেকে সরানো) ───────────────────
    public function unapprove($id)
    {
        $review = Producreview::findOrFail($id);
        $review->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'রিভিউটি unpublish করা হয়েছে।');
    }

    // ─── একটি রিভিউ Delete করা ─────────────────────────────────────────────
    public function destroy($id)
    {
        $review = Producreview::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'রিভিউটি মুছে ফেলা হয়েছে।');
    }

    // ─── Bulk Action (approve / unapprove / delete) ─────────────────────────
    public function bulk(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids    = array_filter(explode(',', $request->input('selected_ids', '')));

        if (empty($ids)) {
            return redirect()->back()->with('error', 'কোনো রিভিউ সিলেক্ট করা হয়নি।');
        }

        switch ($action) {
            case 'approve':
                Producreview::whereIn('id', $ids)->update(['is_approved' => true]);
                return redirect()->back()->with('success', count($ids) . ' টি রিভিউ অনুমোদন করা হয়েছে।');

            case 'unapprove':
                Producreview::whereIn('id', $ids)->update(['is_approved' => false]);
                return redirect()->back()->with('success', count($ids) . ' টি রিভিউ unpublish করা হয়েছে।');

            case 'delete':
                Producreview::whereIn('id', $ids)->delete();
                return redirect()->back()->with('success', count($ids) . ' টি রিভিউ মুছে ফেলা হয়েছে।');

            default:
                return redirect()->back()->with('error', 'অজানা action।');
        }
    }

    // ─── পুরনো POST route (backward compat) ────────────────────────────────
    public function reviewadmin(Request $request)
    {
        $reviewId = $request->input('review_id');
        $action   = $request->input('action');

        $review = Producreview::find($reviewId);
        if (!$review) {
            return redirect()->back()->with('error', 'রিভিউ খুঁজে পাওয়া যায়নি।');
        }

        if ($action === 'approve') {
            $review->update(['is_approved' => true]);
            return redirect()->back()->with('success', 'রিভিউ অনুমোদিত হয়েছে।');
        } elseif ($action === 'reject') {
            $review->delete();
            return redirect()->back()->with('success', 'রিভিউ প্রত্যাখ্যাত হয়েছে।');
        }

        return redirect()->back()->with('error', 'অজানা action।');
    }
}
