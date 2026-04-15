<?php

// app/Http/Controllers/Frontend/OrderTrackController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    /**
     * Show the order tracking page (GET).
     */
    public function index()
    {
        return view('frontend.order_track');
    }

    /**
     * Process the tracking form (POST).
     */
    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string|max:50',
            'phone'        => 'required|string|max:20',
        ]);

        $order = Order::with('items')
            ->where('order_number', trim($request->order_number))
            ->where('phone',        trim($request->phone))
            ->first();

        if (! $order) {
            return redirect()->back()
                ->withInput()
                ->with('track_error', 'অর্ডারটি পাওয়া যায়নি। অর্ডার নম্বর ও ফোন নম্বর সঠিকভাবে দিন।');
        }

        return view('frontend.order_track', compact('order'));
    }
}
