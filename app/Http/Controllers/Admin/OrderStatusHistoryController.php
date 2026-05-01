<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Http\Request;

class OrderStatusHistoryController extends Controller
{
    /**
     * Display a global history of order status changes.
     */
    public function index(Request $request)
    {
        $query = OrderStatusHistory::with(['order', 'user'])->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $histories = $query->paginate(30);
        
        $staffMembers = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['super-admin', 'admin', 'manager', 'employee']);
        })->get(['id', 'name']);

        return view('admin.orders.history.index', compact('histories', 'staffMembers'));
    }

    /**
     * Display stats for staff productivity.
     */
    public function staffActivity($userId)
    {
        $user = User::findOrFail($userId);
        $histories = OrderStatusHistory::with('order')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(20);

        return view('admin.orders.history.staff', compact('user', 'histories'));
    }
}
