<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole(['manager'])) {
            abort(403, 'আপনার Manager ড্যাশবোর্ডে ঢোকার অনুমতি নেই।');
        }

        return $next($request);
    }
}
