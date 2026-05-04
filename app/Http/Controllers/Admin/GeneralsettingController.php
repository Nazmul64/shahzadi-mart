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
            'logo'      => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
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
            'font_family'        => 'nullable|string|max:100',
            'font_size'          => 'nullable|integer|between:10,24',
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
            'font_family'        => $request->font_family        ?? $setting->font_family,
            'font_size'          => $request->font_size          ?? $setting->font_size,
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
            'font_family'       => 'Plus Jakarta Sans',
            'font_size'         => 14,
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
