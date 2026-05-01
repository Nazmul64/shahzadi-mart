<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function manager_login()
    {
        if (Auth::check() && Auth::user()->load('roles')->isManager()) {
            return redirect()->route('manager.dashboard');
        }

        return view('manager.auth.login');
    }

    public function manager_login_submit(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // roles সহ user load করো
        $user = User::with('roles')->where('email', $request->email)->first();

        // User নেই
        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->withInput();
        }

        // Manager role নেই
        if (!$user->isManager()) {
            return back()->withErrors([
                'email' => 'Access denied. Manager account only.',
            ])->withInput();
        }

        // Account active নয়
        if (in_array($user->status, ['inactive', 'suspended', 'pending'])) {
            return back()->withErrors([
                'email' => 'Your account is not active. Contact administrator.',
            ])->withInput();
        }

        // Password check
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('manager.dashboard')
                ->with('success', 'Login successful. Welcome to the Manager panel!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function manager_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('manager.login')
            ->with('success', 'You have been logged out successfully.');
    }

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

    public function manager_dashboard()
    {
        $ordersPending    = Order::where('order_status', 'pending')->count();
        $ordersProcessing = Order::where('order_status', 'processing')->count();
        $ordersCompleted  = Order::where('order_status', 'completed')->count();
        $totalProducts    = Product::count();

        $salesLast30 = Order::where('order_status', 'completed')
                            ->where('created_at', '>=', now()->subDays(30))
                            ->count();

        $salesAllTime = Order::where('order_status', 'completed')->count();

        $recentOrders = Order::with('items')->latest()->take(5)->get();

        $popularProducts = Product::withCount('orderItems')
                                  ->orderByDesc('order_items_count')
                                  ->take(5)
                                  ->get();

        $salesChart = Order::where('order_status', 'completed')
                           ->where('created_at', '>=', now()->subDays(29)->startOfDay())
                           ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                           ->groupBy('date')
                           ->orderBy('date')
                           ->pluck('count', 'date');

        $chartLabels = [];
        $chartData   = [];
        for ($i = 29; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $chartData[]   = $salesChart[$date] ?? 0;
        }

        $statusCounts = $this->getStatusCounts();

        return view('manager.index', compact(
            'ordersPending', 'ordersProcessing', 'ordersCompleted',
            'totalProducts', 'salesLast30', 'salesAllTime',
            'recentOrders', 'popularProducts',
            'chartLabels', 'chartData',
            'statusCounts'
        ));
    }
}
