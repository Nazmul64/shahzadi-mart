<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use Illuminate\Http\Request;

class GeneralsettingController extends Controller
{
    /* ─────────────────────────────────────
     *  Website Logo page  (index)
     * ───────────────────────────────────── */
    public function index()
    {
        $setting = Generalsetting::getSettings();
        return view('admin.generalsetting.index', compact('setting'));
    }

    /* ─────────────────────────────────────
     *  Upload Header / Footer / Invoice logo
     *  POST  /admin/Generalsettings/upload-logo
     * ───────────────────────────────────── */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:header_logo,footer_logo,invoice_logo',
            'logo'      => 'required|mimes:jpg,jpeg,png,gif,svg,webp|max:5120',
        ]);

        $setting  = Generalsetting::getSettings();
        $logoType = $request->input('logo_type');

        /* ── Delete old file if it exists ── */
        if ($setting->$logoType) {
            $oldPath = public_path($setting->$logoType);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        /* ── Save new file to public/uploads/generalsetting ── */
        $uploadDir = public_path('uploads/generalsetting');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file     = $request->file('logo');
        $filename = time() . '_' . $logoType . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        /* ── Update DB ── */
        $setting->$logoType = 'uploads/generalsetting/' . $filename;
        $setting->save();

        $label = ucfirst(str_replace('_', ' ', $logoType));

        return back()->with('success', $label . ' updated successfully!');
    }

    /* ─────────────────────────────────────
     *  Delete a logo
     *  POST  /admin/Generalsettings/delete-logo
     * ───────────────────────────────────── */
    public function deleteLogo(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:header_logo,footer_logo,invoice_logo',
        ]);

        $setting  = Generalsetting::getSettings();
        $logoType = $request->input('logo_type');

        if ($setting->$logoType) {
            $path = public_path($setting->$logoType);
            if (file_exists($path)) {
                @unlink($path);
            }
            $setting->$logoType = null;
            $setting->save();
        }

        return back()->with('success', 'Logo removed successfully.');
    }

    /* ─────────────────────────────────────
     *  Required stubs for resource route
     * ───────────────────────────────────── */
    public function create()
    {
        return redirect()->route('admin.Generalsettings.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.Generalsettings.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.Generalsettings.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.Generalsettings.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'site_name'          => 'nullable|string|max:255',
            'category_menu_type' => 'nullable|string|in:fixed,hover',
            'site_layout_width'  => 'nullable|string|in:boxed,full-width',
            'products_per_row'   => 'nullable|integer|between:2,6',
            'primary_color'      => 'nullable|string|max:20',
            'header_color'       => 'nullable|string|max:20',
            'footer_color'       => 'nullable|string|max:20',
            'header_text_color'  => 'nullable|string|max:20',
            'footer_text_color'  => 'nullable|string|max:20',
            'top_header_bg_color' => 'nullable|string|max:20',
            'top_header_text_color' => 'nullable|string|max:20',
            'main_header_bg_color' => 'nullable|string|max:20',
            'main_header_text_color' => 'nullable|string|max:20',
            'button_bg_color' => 'nullable|string|max:20',
            'button_text_color' => 'nullable|string|max:20',
            'category_slider_status' => 'nullable|integer|in:0,1',
            'font_family'        => 'nullable|string|max:100',
            'font_size'          => 'nullable|integer|between:10,24',
            'category_img_width' => 'nullable|integer|between:40,300',
            'category_img_height' => 'nullable|integer|between:40,300',
            'category_img_shape' => 'nullable|string|in:circle,square',
            'product_img_height' => 'nullable|integer|between:150,600',
            'product_img_fit'    => 'nullable|string|in:cover,contain',
            'category_slider_margin' => 'nullable|integer|between:0,50',
            'show_rating_stars' => 'nullable|integer|in:0,1',
            'product_img_height_mobile' => 'nullable|integer|between:100,400',
            'product_font_size_mobile' => 'nullable|integer|between:8,20',
            'marquee_status' => 'nullable|integer|in:0,1',
            'marquee_text' => 'nullable|string',
            'payment_discount_status' => 'nullable|integer|in:0,1',
            'payment_discount_percentage' => 'nullable|numeric|between:0,100',
            'analytics_id' => 'nullable|string|max:255',
            'analytics_status' => 'nullable|integer|in:0,1',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'facebook_pixel_status' => 'nullable|integer|in:0,1',
            'gtm_id' => 'nullable|string|max:255',
            'gtm_status' => 'nullable|integer|in:0,1',
        ]);

        $setting = Generalsetting::getSettings();
        $setting->update([
            'site_name'          => $request->site_name          ?? $setting->site_name,
            'category_menu_type' => $request->category_menu_type ?? $setting->category_menu_type,
            'site_layout_width'  => $request->site_layout_width  ?? $setting->site_layout_width,
            'products_per_row'   => $request->products_per_row   ?? $setting->products_per_row,
            'primary_color'      => $request->primary_color      ?? $setting->primary_color,
            'header_color'       => $request->header_color       ?? $setting->header_color,
            'footer_color'       => $request->footer_color       ?? $setting->footer_color,
            'header_text_color'  => $request->header_text_color  ?? $setting->header_text_color,
            'footer_text_color'  => $request->footer_text_color  ?? $setting->footer_text_color,
            'top_header_bg_color' => $request->top_header_bg_color ?? $setting->top_header_bg_color,
            'top_header_text_color' => $request->top_header_text_color ?? $setting->top_header_text_color,
            'main_header_bg_color' => $request->main_header_bg_color ?? $setting->main_header_bg_color,
            'main_header_text_color' => $request->main_header_text_color ?? $setting->main_header_text_color,
            'button_bg_color' => $request->button_bg_color ?? $setting->button_bg_color,
            'button_text_color' => $request->button_text_color ?? $setting->button_text_color,
            'category_slider_status' => $request->has('category_slider_status') ? $request->category_slider_status : $setting->category_slider_status,
            'font_family'        => $request->font_family        ?? $setting->font_family,
            'font_size'          => $request->font_size          ?? $setting->font_size,
            'category_img_width' => $request->category_img_width ?? $setting->category_img_width,
            'category_img_height' => $request->category_img_height ?? $setting->category_img_height,
            'category_img_shape' => $request->category_img_shape ?? $setting->category_img_shape,
            'product_img_height' => $request->product_img_height ?? $setting->product_img_height,
            'product_img_fit'    => $request->product_img_fit    ?? $setting->product_img_fit,
            'category_slider_margin' => $request->category_slider_margin ?? $setting->category_slider_margin,
            'show_rating_stars' => $request->has('show_rating_stars') ? $request->show_rating_stars : $setting->show_rating_stars,
            'product_img_height_mobile' => $request->product_img_height_mobile ?? $setting->product_img_height_mobile,
            'product_font_size_mobile' => $request->product_font_size_mobile ?? $setting->product_font_size_mobile,
            'marquee_status' => $request->has('marquee_status') ? 1 : 0,
            'marquee_text' => $request->marquee_text ?? $setting->marquee_text,
            'payment_discount_status' => $request->has('payment_discount_status') ? 1 : 0,
            'payment_discount_percentage' => $request->payment_discount_percentage ?? $setting->payment_discount_percentage,
            'analytics_id' => $request->analytics_id ?? $setting->analytics_id,
            'analytics_status' => $request->has('analytics_status') ? 1 : 0,
            'facebook_pixel_id' => $request->facebook_pixel_id ?? $setting->facebook_pixel_id,
            'facebook_pixel_status' => $request->has('facebook_pixel_status') ? 1 : 0,
            'gtm_id' => $request->gtm_id ?? $setting->gtm_id,
            'gtm_status' => $request->has('gtm_status') ? 1 : 0,
        ]);

        \Illuminate\Support\Facades\Cache::forget('web_setting');
        \Illuminate\Support\Facades\Cache::forget('sidebar_categories');

        return back()->with('success', 'General settings updated successfully!');
    }

    public function resetTheme()
    {
        $setting = Generalsetting::getSettings();
        $setting->update([
            'primary_color'     => '#be0318',
            'header_color'      => '#ffffff',
            'footer_color'      => '#ffffff',
            'header_text_color' => '#333333',
            'footer_text_color' => '#333333',
            'top_header_bg_color' => '#0B1121',
            'top_header_text_color' => '#94a3b8',
            'main_header_bg_color' => '#ffffff',
            'main_header_text_color' => '#333333',
            'button_bg_color' => '#be0318',
            'button_text_color' => '#ffffff',
            'category_slider_status' => 1,
            'font_family'       => 'Plus Jakarta Sans',
            'font_size'         => 14,
            'category_img_width' => 80,
            'category_img_height' => 80,
            'category_img_shape' => 'circle',
            'product_img_height' => 280,
            'product_img_fit'    => 'cover',
            'category_slider_margin' => 10,
            'show_rating_stars' => 1,
            'product_img_height_mobile' => 160,
            'product_font_size_mobile' => 12,
        ]);

        \Illuminate\Support\Facades\Cache::forget('web_setting');
        \Illuminate\Support\Facades\Cache::forget('sidebar_categories');

        return back()->with('success', 'Theme settings reset to default successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.Generalsettings.index');
    }
}
