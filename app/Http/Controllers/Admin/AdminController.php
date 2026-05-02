<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ─────────────────────────────────────────────
    //  Shared: statusCounts helper
    // ─────────────────────────────────────────────
    private function getStatusCounts(): array
    {
        return [
            'all'        => Order::count(),
            'pending'    => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'completed'  => Order::where('order_status', 'completed')->count(),
            'cancelled'  => Order::where('order_status', 'cancelled')->count(),
        ];
    }

    // ─────────────────────────────────────────────
    //  Dashboard
    // ─────────────────────────────────────────────
    public function admin_dashboard()
    {
        $ordersPending    = Order::where('order_status', 'pending')->count();
        $ordersProcessing = Order::where('order_status', 'processing')->count();
        $ordersCompleted  = Order::where('order_status', 'completed')->count();
        $totalProducts    = Product::count();

        $salesLast30 = Order::where('order_status', 'completed')
                            ->where('created_at', '>=', now()->subDays(30))
                            ->sum('total');

        $salesAllTime = Order::where('order_status', 'completed')->sum('total');

        $recentOrders = Order::with('items')->latest()->take(5)->get();

        $popularProducts = Product::withCount('orderItems')
                                  ->orderByDesc('order_items_count')
                                  ->take(5)
                                  ->get();

        $salesChart = Order::where('order_status', 'completed')
                           ->where('created_at', '>=', now()->subDays(29)->startOfDay())
                           ->selectRaw('DATE(created_at) as date, SUM(total) as amount')
                           ->groupBy('date')
                           ->orderBy('date')
                           ->pluck('amount', 'date');

        $chartLabels = [];
        $chartData   = [];
        for ($i = 29; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $chartData[]   = (float) ($salesChart[$date] ?? 0);
        }

        // ✅ Fix: statusCounts এখন properly pass হচ্ছে
        $statusCounts = $this->getStatusCounts();

        return view('admin.index', compact(
            'ordersPending', 'ordersProcessing', 'ordersCompleted',
            'totalProducts', 'salesLast30', 'salesAllTime',
            'recentOrders', 'popularProducts',
            'chartLabels', 'chartData',
            'statusCounts'
        ));
    }

    // ─────────────────────────────────────────────
    //  All Orders
    // ─────────────────────────────────────────────
    public function all_order(Request $request)
    {
        $query = Order::with('items')->latest();

        // Status filter
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders       = $query->paginate(15);
        $statusCounts = $this->getStatusCounts();
        // Staff = users who have manager or employee role (can handle orders)
        $staffUsers   = User::whereHas('roles', fn($q) => $q->whereIn('slug', ['manager','employee','admin','super-admin']))
                            ->where('status', 'active')->get(['id','name']);

        if (request()->routeIs('manager.*')) {
            return view('manager.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
        } elseif (request()->routeIs('emplee.*')) {
            return view('emplee.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
        }

        return view('admin.orders.allorder', compact('orders', 'statusCounts', 'staffUsers'));
    }

    // ─────────────────────────────────────────────
    //  Order Detail
    // ─────────────────────────────────────────────
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // ─────────────────────────────────────────────
    //  Update Order Status
    // ─────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return back()->with('success', 'অর্ডার স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Update Payment Status
    // ─────────────────────────────────────────────
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'পেমেন্ট স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Delete Order
    // ─────────────────────────────────────────────
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'অর্ডারটি মুছে ফেলা হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Assign Staff to Order
    // ─────────────────────────────────────────────
    public function assignStaff(Request $request, $id)
    {
        $request->validate([
            'assigned_user_id' => 'nullable|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['assigned_user_id' => $request->assigned_user_id ?: null]);

        return back()->with('success', 'স্টাফ অ্যাসাইন আপডেট হয়েছে।');
    }

    // ─────────────────────────────────────────────
    //  Bulk Delete Orders
    // ─────────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'order_ids'   => 'required|array',
            'order_ids.*' => 'exists:orders,id',
        ]);

        Order::whereIn('id', $request->order_ids)->delete();

        return back()->with('success', count($request->order_ids) . 'টি অর্ডার মুছে ফেলা হয়েছে।');
    }
}
