<?php

namespace App\Providers;

use App\Models\Contactinfomationadmin;
use App\Models\Footercategory;
use App\Models\Pixel;
use App\Models\Tagmanager;
use App\Models\Websitefavicon;
use App\Models\Category;
use App\Models\Generalsetting;
use App\Models\FooterSetting;
use App\Models\Aiprompt;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ─── Global View Composer — সব view-এ automatically share হবে ────────
        View::composer('*', function ($view) {

            // ── Sidebar Categories ────────────────────────────────────────────
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

            // ── General Settings ──────────────────────────────────────────────
            $websetting = Generalsetting::first();
            $footerSetting = FooterSetting::getSettings();
            $aiPrompt = Aiprompt::first();

            // ── Tracking ──────────────────────────────────────────────────────
            $Pixelid         = Pixel::first();
            $GoogleAnalytics = Tagmanager::first();

            // ── Master Layout Data ────────────────────────────────────────────
            $websitefavicon          = Websitefavicon::first();
            $contactinformationadmin = Contactinfomationadmin::latest()->first();
            $pagecrate               = Footercategory::with([
                                           'pages' => fn($q) => $q->where('status', 1)
                                       ])->get();

            $view->with(compact(
                'sidebarCategories',
                'websetting',
                'Pixelid',
                'GoogleAnalytics',
                'websitefavicon',
                'contactinformationadmin',
                'pagecrate',
                'footerSetting',
                'aiPrompt'
            ));
        });

        // ─── Blade Directives for Permission & Role ───────────────────────────

        // @permission('post-view') ... @endpermission
        Blade::directive('permission', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($expression)): ?>";
        });
        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        // @role('admin') ... @endrole
        Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($expression)): ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // @anyrole(['admin', 'editor']) ... @endanyrole
        Blade::directive('anyrole', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole($expression)): ?>";
        });
        Blade::directive('endanyrole', function () {
            return "<?php endif; ?>";
        });

        // @superadmin ... @endsuperadmin
        Blade::directive('superadmin', function () {
            return "<?php if(auth()->check() && auth()->user()->isSuperAdmin()): ?>";
        });
        Blade::directive('endsuperadmin', function () {
            return "<?php endif; ?>";
        });
    }
}
