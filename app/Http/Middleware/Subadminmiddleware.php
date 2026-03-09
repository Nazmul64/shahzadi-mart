<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubadminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('subadmin.login')
                ->with('error', 'Please login to access the sub admin panel.');
        }

        $user = Auth::user()->load('roles');

        if (in_array($user->status, ['inactive', 'suspended', 'pending'])) {
            Auth::logout();
            return redirect()->route('subadmin.login')
                ->with('error', 'Your account has been deactivated. Contact administrator.');
        }

        if (!$user->isSubAdmin()) {
            Auth::logout();
            return redirect()->route('subadmin.login')
                ->with('error', 'You are not authorized to access the sub admin panel.');
        }

        return $next($request);
    }
}
