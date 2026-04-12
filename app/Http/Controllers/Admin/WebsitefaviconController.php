<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Websitefavicon;
use Illuminate\Http\Request;

class WebsitefaviconController extends Controller
{
    /* ──────────────────────────────────────────
     *  GET  admin/websitefavicon
     * ────────────────────────────────────────── */
    public function index()
    {
        $setting = Websitefavicon::getSettings();
        return view('admin.websitefavicon.index', compact('setting'));
    }

    /* ──────────────────────────────────────────
     *  POST  admin/websitefavicon/upload-logo
     * ────────────────────────────────────────── */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => [
                'required',
                'file',
                'max:1024',
                function ($attribute, $value, $fail) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico'];
                    $ext     = strtolower($value->getClientOriginalExtension());
                    if (! in_array($ext, $allowed)) {
                        $fail('Only jpg, jpeg, png, gif, svg, webp, ico files are allowed.');
                    }
                },
            ],
        ]);

        $setting = Websitefavicon::getSettings();

        // পুরনো file delete
        if ($setting->favicon_logo) {
            $oldPath = public_path($setting->favicon_logo);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // নতুন file save
        $uploadDir = public_path('uploads/websitefavicon');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file     = $request->file('logo');
        $filename = time() . '_favicon.' . strtolower($file->getClientOriginalExtension());
        $file->move($uploadDir, $filename);

        $setting->favicon_logo = 'uploads/websitefavicon/' . $filename;
        $setting->save();

        return back()->with('success', 'Favicon updated successfully!');
    }

    /* ──────────────────────────────────────────
     *  POST  admin/websitefavicon/delete-logo
     * ────────────────────────────────────────── */
    public function deleteLogo(Request $request)
    {
        $setting = Websitefavicon::getSettings();

        if ($setting->favicon_logo) {
            $path = public_path($setting->favicon_logo);
            if (file_exists($path)) {
                @unlink($path);
            }
            $setting->favicon_logo = null;
            $setting->save();
        }

        return back()->with('success', 'Favicon removed successfully.');
    }

    // Resource stubs — সব admin.websitefavicon.index এ redirect করে
    public function create()                      { return redirect()->route('admin.websitefavicon.index'); }
    public function store(Request $request)       { return redirect()->route('admin.websitefavicon.index'); }
    public function show($id)                     { return redirect()->route('admin.websitefavicon.index'); }
    public function edit($id)                     { return redirect()->route('admin.websitefavicon.index'); }
    public function update(Request $request, $id) { return redirect()->route('admin.websitefavicon.index'); }
    public function destroy($id)                  { return redirect()->route('admin.websitefavicon.index'); }
}
