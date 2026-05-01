<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of payment history.
     */
    public function index(Request $request)
    {
        $query = Order::latest();

        // Filters
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('transaction_id', 'like', "%$search%");
            });
        }

        $orders = $query->paginate(30);

        return view('admin.payments.index', compact('orders'));
    }
}
