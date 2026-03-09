<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('manager.login')
                ->with('error', 'Please login to access the manager panel.');
        }

        // roles সহ fresh load করো
        $user = Auth::user()->load('roles');

        if (in_array($user->status, ['inactive', 'suspended'])) {
            Auth::logout();
            return redirect()->route('manager.login')
                ->with('error', 'Your account has been deactivated. Contact administrator.');
        }

        if (!$user->isManager()) {
            Auth::logout();
            return redirect()->route('manager.login')
                ->with('error', 'You are not authorized to access the manager panel.');
        }

        return $next($request);
    }
}
