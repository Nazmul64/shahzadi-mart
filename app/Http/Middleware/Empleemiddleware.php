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

        if (!$user || !$user->hasRole(['employee'])) {
            abort(403, 'আপনার Employee ড্যাশবোর্ডে ঢোকার অনুমতি নেই।');
        }

        return $next($request);
    }
}
