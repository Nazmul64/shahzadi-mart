<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ─── Blade Directives for Permission & Role ────────────────────────────

        /**
         * @permission
         * Usage in blade: @permission('post-view') ... @endpermission
         */
        Blade::directive('permission', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($expression)): ?>";
        });
        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        /**
         * @role
         * Usage in blade: @role('admin') ... @endrole
         */
        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($expression)): ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        /**
         * @anyrole
         * Usage: @anyrole(['admin', 'editor']) ... @endanyrole
         */
        Blade::directive('anyrole', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($expression)): ?>";
        });
        Blade::directive('endanyrole', function () {
            return "<?php endif; ?>";
        });

        /**
         * @superadmin
         * Usage: @superadmin ... @endsuperadmin
         */
        Blade::directive('superadmin', function () {
            return "<?php if(auth()->check() && auth()->user()->isSuperAdmin()): ?>";
        });
        Blade::directive('endsuperadmin', function () {
            return "<?php endif; ?>";
        });
    }
}
