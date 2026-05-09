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
            $sidebarCategories = \Illuminate\Support\Facades\Cache::remember('sidebar_categories', 86400, function () {
                return Category::where('status', 'active')
                    ->with([
                        'subCategories' => function ($q) {
                            $q->where('status', 'active')
                              ->with([
                                  'childCategories' => fn($q2) => $q2->where('status', 'active')
                              ]);
                        }
                    ])
                    ->get();
            });

            // ── Settings & Data ───────────────────────────────────────────────
            $websetting = \Illuminate\Support\Facades\Cache::remember('web_setting', 86400, function () {
                return Generalsetting::getSettings();
            });

            $footerSetting = \Illuminate\Support\Facades\Cache::remember('footer_setting', 86400, function () {
                return FooterSetting::getSettings();
            });

            $aiPrompt = \Illuminate\Support\Facades\Cache::remember('ai_prompt', 86400, function () {
                return Aiprompt::first();
            });

            $Pixelid = \Illuminate\Support\Facades\Cache::remember('pixel_id', 86400, function () {
                return Pixel::first();
            });

            $GoogleAnalytics = \Illuminate\Support\Facades\Cache::remember('google_analytics', 86400, function () {
                return Tagmanager::first();
            });

            $websitefavicon = \Illuminate\Support\Facades\Cache::remember('website_favicon', 86400, function () {
                return Websitefavicon::first();
            });

            $contactinformationadmin = \Illuminate\Support\Facades\Cache::remember('contact_info_admin', 86400, function () {
                return Contactinfomationadmin::latest()->first();
            });

            $pagecrate = \Illuminate\Support\Facades\Cache::remember('footer_pages', 86400, function () {
                return Footercategory::with([
                    'pages' => fn($q) => $q->where('status', 1)
                ])->get();
            });

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
            ))->with('gs', $websetting);
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
