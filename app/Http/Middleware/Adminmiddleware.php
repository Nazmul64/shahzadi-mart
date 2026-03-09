<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin Panel Gate Middleware
 * Admin panel এ ঢোকার জন্য basic check।
 * super-admin, admin, manager, sub-admin — যেকোনো একটি role থাকলে allow।
 *
 * bootstrap/app.php এ alias: 'admin' => AdminMiddleware::class
 * Route এ: ->middleware('admin')
 */
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to access admin panel.');
        }

        $user = Auth::user();

        // Inactive/Suspended account block
        if (in_array($user->status, ['inactive', 'suspended'])) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Your account has been deactivated. Contact administrator.');
        }

        // RBAC check — isAdmin() User Model এ defined
        // super-admin, admin, manager, sub-admin যেকোনো একটি হলে pass
        if (!$user->isAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'You are not authorized to access admin panel.');
        }

        return $next($request);
    }
}
