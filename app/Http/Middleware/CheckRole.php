<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check() || !auth()->user()->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            abort(403, 'আপনার এই পাতায় প্রবেশের অনুমতি নেই।');
        }

        return $next($request);
    }
}
