<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AllorderController extends Controller
{
    // ── All Orders List ───────────────────────────────────────────
    public function allorder(Request $request)
    {
        $query = Order::with(['items'])->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_number',    'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone',         'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = Order::selectRaw("
            COUNT(*)                                AS all_count,
            SUM(order_status = 'pending')           AS pending,
            SUM(order_status = 'processing')        AS processing,
            SUM(order_status = 'shipped')           AS shipped,
            SUM(order_status = 'delivered')         AS delivered,
            SUM(order_status = 'cancelled')         AS cancelled
        ")->first();

        $statusCounts = [
            'all'        => (int) ($counts->all_count  ?? 0),
            'pending'    => (int) ($counts->pending    ?? 0),
            'processing' => (int) ($counts->processing ?? 0),
            'shipped'    => (int) ($counts->shipped    ?? 0),
            'delivered'  => (int) ($counts->delivered  ?? 0),
            'cancelled'  => (int) ($counts->cancelled  ?? 0),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    // ── Order Details ─────────────────────────────────────────────
    public function show($id)
    {
        $order = Order::with(['items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // ── Update Order Status ───────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        Order::findOrFail($id)->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', 'অর্ডার স্ট্যাটাস সফলভাবে আপডেট হয়েছে।');
    }

    // ── Update Payment Status ─────────────────────────────────────
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        Order::findOrFail($id)->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'পেমেন্ট স্ট্যাটাস সফলভাবে আপডেট হয়েছে।');
    }

    // ── Delete Single Order ───────────────────────────────────────
    public function destroy($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', 'অর্ডার সফলভাবে মুছে ফেলা হয়েছে।');
    }

    // ── Bulk Delete ───────────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:orders,id',
        ]);

        $orders = Order::whereIn('id', $request->ids)->with('items')->get();

        foreach ($orders as $order) {
            $order->items()->delete();
            $order->delete();
        }

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', count($request->ids) . 'টি অর্ডার মুছে ফেলা হয়েছে।');
    }

    // ── Bulk Status Change ────────────────────────────────────────
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids'          => 'required|array|min:1',
            'ids.*'        => 'integer|exists:orders,id',
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        Order::whereIn('id', $request->ids)
             ->update(['order_status' => $request->order_status]);

        return redirect()
            ->route('admin.order.allorder')
            ->with('success', count($request->ids) . 'টি অর্ডারের স্ট্যাটাস আপডেট হয়েছে।');
    }
}
