<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Generalsetting;
use Illuminate\Http\Request;

use App\Models\Websitefavicon;

class LandingPageController extends Controller
{
    public function show($slug)
    {
        $landing = LandingPage::where('slug', $slug)->where('status', true)->with('product')->firstOrFail();
        $websetting = Generalsetting::first();
        $favicon = Websitefavicon::first();
        $shippingCharges = \App\Models\ShippingCharge::active()->get();
        
        // Render the chosen template
        // Templates should be in resources/views/frontend/landing/
        $viewPath = "frontend.landing." . $landing->template_name;
        
        if (!view()->exists($viewPath)) {
            // Fallback to default if template doesn't exist
            $viewPath = "frontend.landing.landing-1";
        }

        return view($viewPath, compact('landing', 'websetting', 'favicon', 'shippingCharges'));
    }
}
