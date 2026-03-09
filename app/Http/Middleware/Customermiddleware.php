<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Customer Gate Middleware
 * Customer routes এ ঢোকার জন্য।
 * RBAC দিয়ে check — 'customer' role slug database এ থাকতে হবে।
 *
 * bootstrap/app.php এ alias: 'customer' => CustomerMiddleware::class
 * Route এ: ->middleware('customer')
 */
class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('customer.login')
                ->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        // Account status check
        if ($user->status === 'suspended') {
            Auth::logout();
            return redirect()->route('customer.login')
                ->with('error', 'Your account has been suspended. Contact support.');
        }

        if ($user->status === 'inactive') {
            Auth::logout();
            return redirect()->route('customer.login')
                ->with('error', 'Your account is inactive.');
        }

        // RBAC check — 'customer' role slug দিয়ে check
        // Admin/Seller রাও customer route access করতে পারবে না
        if (!$user->hasRole('customer')) {
            return redirect()->route('customer.login')
                ->with('error', 'Customer access required.');
        }

        return $next($request);
    }
}
