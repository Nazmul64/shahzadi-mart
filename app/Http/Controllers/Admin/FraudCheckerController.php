<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\SteadfastOrder;
use App\Models\FraudProfile;

class FraudCheckerController extends Controller
{
    public function check(Request $request)
    {
        $phone = $request->input('phone');
        
        if (!$phone) {
            return response()->json(['error' => 'Phone number is required'], 400);
        }

        // Get fraud profile
        $profile = FraudProfile::where('phone', $phone)->first();

        // Get all orders for this phone number
        $orders = Order::where('phone', $phone)->get();

        $totalOrders = $orders->count();
        $lastIp = $orders->sortByDesc('created_at')->first()?->ip_address;
        
        if ($totalOrders === 0) {
            return response()->json([
                'status' => 'new_customer',
                'message' => 'No previous orders found for this phone number.',
                'phone' => $phone,
                'ip_address' => $lastIp,
                'is_blocked' => $profile?->is_blocked ?? false,
                'manual_status' => $profile?->status ?? 'none'
            ]);
        }

        // Status counts
        $delivered = $orders->where('order_status', 'delivered')->count();
        $cancelled = $orders->where('order_status', 'cancelled')->count();
        $returned  = $orders->where('order_status', 'returned')->count(); 
        $pending   = $orders->whereIn('order_status', ['pending', 'processing', 'shipped'])->count();

        // Payment method breakdown
        $bkashCount = $orders->where('payment_method', 'bkash')->count();
        $nagadCount = $orders->where('payment_method', 'nagad')->count();
        $codCount   = $orders->where('payment_method', 'cod')->count();

        // Calculate Success Rate
        $completedOrders = $delivered + $cancelled + $returned;
        $successRate = $completedOrders > 0 ? round(($delivered / $completedOrders) * 100) : 0;

        // Determine Risk
        $isFake = false;
        $fraudScore = "Low Risk (Real User)";
        $fraudColor = "success";

        // Manual status overrides automated scoring
        if ($profile && $profile->status !== 'none') {
            if ($profile->status === 'fake') {
                $isFake = true;
                $fraudScore = "MANUALLY MARKED AS FAKE";
                $fraudColor = "danger";
            } else {
                $fraudScore = "MANUALLY MARKED AS TRUSTED";
                $fraudColor = "success";
            }
        } else {
            if ($completedOrders > 0) {
                if ($successRate < 30 && $cancelled > 2) {
                    $isFake = true;
                    $fraudScore = "High Risk (Fake / Refused Parcels)";
                    $fraudColor = "danger";
                } elseif ($successRate < 60) {
                    $fraudScore = "Medium Risk (Some Cancellations)";
                    $fraudColor = "warning";
                } else {
                    $fraudScore = "Low Risk (Trusted User)";
                    $fraudColor = "success";
                }
            } else {
                $fraudScore = "New/Pending User";
                $fraudColor = "info";
            }
        }

        // Courier History
        $orderIds = $orders->pluck('id')->toArray();
        $steadfastCount = SteadfastOrder::whereIn('order_id', $orderIds)->count();
        $steadfastDelivered = SteadfastOrder::whereIn('order_id', $orderIds)->where('status', 'delivered')->count();
        $steadfastCancelled = SteadfastOrder::whereIn('order_id', $orderIds)->whereIn('status', ['cancelled', 'returned'])->count();

        return response()->json([
            'status' => 'success',
            'phone' => $phone,
            'ip_address' => $lastIp,
            'is_blocked' => $profile?->is_blocked ?? false,
            'manual_status' => $profile?->status ?? 'none',
            'total_orders' => $totalOrders,
            'delivered' => $delivered,
            'cancelled' => $cancelled + $returned,
            'pending' => $pending,
            'success_rate' => $successRate,
            'bkash_count' => $bkashCount,
            'nagad_count' => $nagadCount,
            'cod_count' => $codCount,
            'fraud_score' => $fraudScore,
            'fraud_color' => $fraudColor,
            'is_fake' => $isFake,
            'courier_stats' => [
                'steadfast_total' => $steadfastCount,
                'steadfast_delivered' => $steadfastDelivered,
                'steadfast_cancelled' => $steadfastCancelled,
            ],
            'recent_orders' => $orders->sortByDesc('created_at')->take(5)->map(function($o) {
                return [
                    'order_number' => $o->order_number,
                    'date' => $o->created_at->format('d M Y'),
                    'status' => ucfirst($o->order_status),
                    'total' => $o->total,
                    'method' => strtoupper($o->payment_method)
                ];
            })->values()
        ]);
    }

    public function toggleBlock(Request $request)
    {
        $phone = $request->input('phone');
        $profile = FraudProfile::firstOrNew(['phone' => $phone]);
        
        $profile->is_blocked = !$profile->is_blocked;
        $profile->blocked_at = $profile->is_blocked ? now() : null;
        $profile->ip_address = $request->input('ip_address');
        $profile->save();

        return response()->json([
            'status' => 'success',
            'is_blocked' => $profile->is_blocked,
            'message' => $profile->is_blocked ? 'Customer has been blocked.' : 'Customer has been unblocked.'
        ]);
    }

    public function updateManualStatus(Request $request)
    {
        $phone = $request->input('phone');
        $status = $request->input('status');
        
        $profile = FraudProfile::firstOrNew(['phone' => $phone]);
        $profile->status = $status;
        $profile->save();

        return response()->json([
            'status' => 'success',
            'manual_status' => $profile->status,
            'message' => 'Customer marked as ' . ucfirst($status)
        ]);
    }

    public function blockedList()
    {
        $profiles = FraudProfile::where('is_blocked', true)->orWhere('status', 'fake')->orderByDesc('updated_at')->paginate(20);
        return view('admin.fraud.blocked_list', compact('profiles'));
    }
}
