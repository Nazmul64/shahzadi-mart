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
        return redirect()->route('admin.Generalsettings.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.Generalsettings.index');
    }
}
