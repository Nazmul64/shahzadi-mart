<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubadminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole(['sub-admin', 'admin', 'super-admin'])) {
            abort(403, 'Sub-Admin অ্যাক্সেস প্রয়োজন।');
        }

        return $next($request);
    }
}
