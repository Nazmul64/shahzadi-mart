<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmpleeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check login
        if (!Auth::check()) {
            return redirect()->route('emplee.login')
                ->with('error', 'Please login to access the employee panel.');
        }

        $user = Auth::user();

        // Check account status
        if (in_array($user->status, ['inactive', 'suspended'])) {
            Auth::logout();

            return redirect()->route('emplee.login')
                ->with('error', 'Your account has been deactivated. Contact administrator.');
        }

        // Role check — $user->role নয়, roles() relationship ব্যবহার করো
        $allowedRoles = ['super-admin', 'admin', 'manager', 'sub-admin', 'employee'];

        if (!$user->hasAnyRole($allowedRoles)) {
            Auth::logout();

            return redirect()->route('emplee.login')
                ->with('error', 'You are not authorized to access the employee panel.');
        }

        return $next($request);
    }
}
