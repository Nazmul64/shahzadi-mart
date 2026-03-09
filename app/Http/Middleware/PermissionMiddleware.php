<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permission-based Route Protection Middleware
 * নির্দিষ্ট permission(s) থাকলেই route access দেবে।
 * Super Admin সব permission পায় — check ছাড়াই pass।
 *
 * bootstrap/app.php এ alias: 'permission' => PermissionMiddleware::class
 *
 * Route এ ব্যবহার:
 *   ->middleware('permission:order-view')
 *   ->middleware('permission:order-create,order-edit')  ← যেকোনো একটি হলেই চলবে
 */
class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
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

        // Super Admin সব permission middleware bypass করে
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Permission check — যেকোনো একটি match হলেই allow
        if (!empty($permissions) && $user->hasAnyPermission($permissions)) {
            return $next($request);
        }

        // Access denied
        if ($request->expectsJson()) {
            return response()->json([
                'error'   => 'Forbidden.',
                'message' => 'You do not have the required permission.'
            ], 403);
        }

        abort(403, 'আপনার এই কাজ করার অনুমতি নেই।');
    }
}
