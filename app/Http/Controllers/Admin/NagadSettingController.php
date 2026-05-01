<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NagadSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NagadSettingController extends Controller
{
    /**
     * Display the Nagad settings form.
     */
    public function index()
    {
        $setting = NagadSetting::first();
        return view('admin.settings.nagad.index', compact('setting'));
    }

    /**
     * Update the Nagad settings.
     */
    public function update(Request $request)
    {
        $setting = NagadSetting::first() ?? new NagadSetting();

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('logo');
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($setting->logo && File::exists(public_path('uploads/nogad/' . $setting->logo))) {
                File::delete(public_path('uploads/nogad/' . $setting->logo));
            }

            $image = $request->file('logo');
            $imageName = 'nagad_logo_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Ensure directory exists
            if (!File::exists(public_path('uploads/nogad'))) {
                File::makeDirectory(public_path('uploads/nogad'), 0755, true);
            }
            
            $image->move(public_path('uploads/nogad'), $imageName);
            $data['logo'] = $imageName;
        }

        $setting->fill($data);
        $setting->save();

        return back()->with('success', 'Nagad API settings updated successfully!');
    }
}
