<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Empleemiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole(['employee', 'manager', 'admin', 'super-admin'])) {
            abort(403, 'Employee অ্যাক্সেস প্রয়োজন।');
        }

        return $next($request);
    }
}
