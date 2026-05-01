<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole('customer')) {
            abort(403, 'Customer অ্যাক্সেস প্রয়োজন।');
        }

        return $next($request);
    }
}
