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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // ─── Global View Composer — frontend view-এ automatically share হবে ───
        // NOTE: '*' এর বদলে specific patterns — এতে admin/sub-views-এ
        //       unnecessary queries হবে না।
        View::composer('*', function ($view) {
            $websetting = Generalsetting::getSettings();

            $view->with([
                'sidebarCategories' => Category::where('status', 'active')
                        ->orderBy('category_name', 'asc')
                        ->with([
                            'subCategories' => function ($q) {
                                $q->where('status', 'active')
                                  ->orderBy('sub_name', 'asc')
                                  ->with([
                                      'childCategories' => function ($q2) {
                                          $q2->where('status', 'active')
                                             ->orderBy('child_sub_name', 'asc');
                                      }
                                  ]);
                            }
                        ])
                        ->get(),

                'websetting'             => $websetting,
                'gs'                     => $websetting,

                'footerSetting'          => FooterSetting::getSettings(),
                'aiPrompt'               => Aiprompt::first(),
                'Pixelid'                => Pixel::first(),
                'GoogleAnalytics'        => Tagmanager::first(),
                'websitefavicon'         => Websitefavicon::first(),
                'contactinformationadmin' => Contactinfomationadmin::latest()->first(),

                'pagecrate' => Footercategory::with([
                        'pages' => fn($q) => $q->where('status', 1)
                    ])->get(),

                'aboutCompany'           => \App\Models\AboutForCompany::first(),
                'navLanding' => \App\Models\LandingPage::where('status', 1)->latest()->first(),
                'sharedDeliveryInfo' => \App\Models\DeliveryInformation::first(),
            ]);
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
