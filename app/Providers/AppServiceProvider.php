<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

    // ─── Global View Composer ─────────────────────────────────────────────
        // সব frontend view-এ $sidebarCategories ও $websetting automatically পাবে
        // আর কোনো controller-এ manually pass করতে হবে না
        View::composer('frontend.*', function ($view) {

            $sidebarCategories = Category::where('status', 'active')
                ->with([
                    'subCategories' => function ($q) {
                        $q->where('status', 'active')
                          ->with([
                              'childCategories' => fn($q2) => $q2->where('status', 'active')
                          ]);
                    }
                ])
                ->get();

            $websetting = Generalsetting::first();

            $view->with(compact('sidebarCategories', 'websetting'));
        });
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
