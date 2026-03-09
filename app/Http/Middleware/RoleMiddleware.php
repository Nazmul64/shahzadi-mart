<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role-based Route Protection Middleware
 * নির্দিষ্ট role(s) থাকলেই route access দেবে।
 *
 * bootstrap/app.php এ alias: 'role' => RoleMiddleware::class
 *
 * Route এ ব্যবহার:
 *   ->middleware('role:super-admin')
 *   ->middleware('role:admin,manager')        ← যেকোনো একটি হলেই চলবে
 *   ->middleware('role:super-admin,admin,manager')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login to continue.');
        }

        $user = Auth::user();

        // Account status check
        if (in_array($user->status, ['inactive', 'suspended'])) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Your account has been deactivated.');
        }

        // Super Admin সব role middleware bypass করে
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Role check — যেকোনো একটি match হলেই allow
        if (!empty($roles) && $user->hasAnyRole($roles)) {
            return $next($request);
        }

        // Access denied
        if ($request->expectsJson()) {
            return response()->json([
                'error'   => 'Unauthorized.',
                'message' => 'You do not have the required role.'
            ], 403);
        }

        abort(403, 'আপনার এই পেজে প্রবেশের অনুমতি নেই।');
    }
}
