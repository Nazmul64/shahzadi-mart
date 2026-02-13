<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminsellerregisterapprovedController extends Controller
{
    /**
     * Display a listing of seller registrations with filtering and pagination
     */
    public function seller_register_check(Request $request)
    {
        $query = User::where('role', 'seller');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('store_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results (15 per page)
        $sellers = $query->paginate(15)->withQueryString();

        return view('admin.sellerregisterstatuslist.index', compact('sellers'));
    }

    /**
     * Approve a seller registration
     */
    public function seller_register_approve($id)
    {
        try {
            $seller = User::findOrFail($id);

            // Check if already approved
            if ($seller->status === 'active') {
                return redirect()
                    ->route('seller.register.list')
                    ->with('info', 'Seller is already approved');
            }

            $seller->status = 'active';
            $seller->save();

            // Optional: Send email notification to seller
            // Mail::to($seller->email)->send(new SellerApproved($seller));

            return redirect()
                ->route('seller.register.list')
                ->with('success', 'Seller approved successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('seller.register.list')
                ->with('error', 'Failed to approve seller: ' . $e->getMessage());
        }
    }

    /**
     * Reject a seller registration
     */
    public function seller_register_reject($id)
    {
        try {
            $seller = User::findOrFail($id);

            // Delete the seller or set status to rejected
            // Option 1: Delete
            $seller->delete();

            // Option 2: Set status to rejected (if you have this status)
            // $seller->status = 'rejected';
            // $seller->save();

            // Optional: Send email notification
            // Mail::to($seller->email)->send(new SellerRejected($seller));

            return redirect()
                ->route('seller.register.list')
                ->with('success', 'Seller rejected successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('seller.register.list')
                ->with('error', 'Failed to reject seller: ' . $e->getMessage());
        }
    }

    /**
     * Suspend an active seller
     */
    public function seller_register_suspend($id)
    {
        try {
            $seller = User::findOrFail($id);

            if ($seller->status !== 'active') {
                return redirect()
                    ->route('seller.register.list')
                    ->with('info', 'Only active sellers can be suspended');
            }

            $seller->status = 'suspended';
            $seller->save();

            // Optional: Send email notification
            // Mail::to($seller->email)->send(new SellerSuspended($seller));

            return redirect()
                ->route('seller.register.list')
                ->with('success', 'Seller suspended successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('seller.register.list')
                ->with('error', 'Failed to suspend seller: ' . $e->getMessage());
        }
    }

    /**
     * Reactivate a suspended seller
     */
    public function seller_register_reactivate($id)
    {
        try {
            $seller = User::findOrFail($id);

            if ($seller->status !== 'suspended') {
                return redirect()
                    ->route('seller.register.list')
                    ->with('info', 'Only suspended sellers can be reactivated');
            }

            $seller->status = 'active';
            $seller->save();

            // Optional: Send email notification
            // Mail::to($seller->email)->send(new SellerReactivated($seller));

            return redirect()
                ->route('seller.register.list')
                ->with('success', 'Seller reactivated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('seller.register.list')
                ->with('error', 'Failed to reactivate seller: ' . $e->getMessage());
        }
    }

    /**
     * Export sellers to Excel (optional)
     */
    public function seller_register_export(Request $request)
    {
        // You can implement Excel export using Laravel Excel package
        // For now, returning a simple CSV

        $query = User::where('role', 'seller');

        // Apply same filters as list
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('store_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sellers = $query->get();

        $filename = 'sellers_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($sellers) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Store Name',
                'Business Type',
                'Status',
                'Registration Date'
            ]);

            // Data rows
            foreach ($sellers as $seller) {
                fputcsv($file, [
                    $seller->id,
                    $seller->name,
                    $seller->email,
                    $seller->phone ?? 'N/A',
                    $seller->store_name ?? 'N/A',
                    $seller->business_type ?? 'N/A',
                    $seller->status,
                    $seller->created_at ? $seller->created_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * View detailed seller information (optional)
     */
    public function seller_register_view($id)
    {
        $seller = User::findOrFail($id);

        return view('admin.sellerregisterstatuslist.view', compact('seller'));
    }
}
