<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderAssignmentController extends Controller
{
    /**
     * Display a summary of order assignments per staff member.
     */
    public function index()
    {
        $staffMembers = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['manager', 'employee', 'admin']);
        })->withCount(['assignedOrders' => function($q) {
            $q->where('order_status', '!=', 'cancelled');
        }])->get();

        $unassignedCount = Order::whereNull('assigned_user_id')->count();

        return view('admin.orders.assignments.index', compact('staffMembers', 'unassignedCount'));
    }

    /**
     * Show orders assigned to a specific staff member.
     */
    public function staffOrders($id)
    {
        $staff = User::findOrFail($id);
        $orders = Order::where('assigned_user_id', $id)
            ->latest()
            ->paginate(15);

        return view('admin.orders.assignments.staff_orders', compact('staff', 'orders'));
    }

    /**
     * Bulk assign orders to a staff member.
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'staff_id' => 'required|exists:users,id',
        ]);

        Order::whereIn('id', $request->order_ids)->update([
            'assigned_user_id' => $request->staff_id
        ]);

        return back()->with('success', 'অর্ডারগুলো সফলভাবে স্টাফকে এসাইন করা হয়েছে।');
    }
}
