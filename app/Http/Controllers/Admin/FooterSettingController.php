<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    public function index()
    {
        $setting = FooterSetting::getSettings();
        return view('admin.footer_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = FooterSetting::getSettings();

        $request->validate([
            'footer_logo'        => 'nullable|mimes:jpg,jpeg,png,gif,svg,webp|max:5120',
            'footer_description' => 'nullable|string',
            'facebook_url'       => 'nullable|url',
            'instagram_url'      => 'nullable|url',
            'twitter_url'        => 'nullable|url',
            'youtube_url'        => 'nullable|url',
            'tiktok_url'         => 'nullable|url',
            'copyright_text'     => 'nullable|string',
            'powered_by_text'    => 'nullable|string',
            'powered_by_link'    => 'nullable|url',
            'payment_methods'    => 'nullable|array',
        ]);

        $data = $request->except(['footer_logo', 'payment_methods', 'payment_logos']);
        $paymentMethods = $request->input('payment_methods', []);
        $currentPaymentData = $setting->payment_methods ?? [];
        $newPaymentData = [];

        // Handle Payment Methods and their Logos
        foreach ($paymentMethods as $method) {
            $logoName = is_array($currentPaymentData) && isset($currentPaymentData[$method]) ? $currentPaymentData[$method] : null;

            if ($request->hasFile("payment_logos.$method")) {
                // Delete old logo if exists
                if ($logoName) {
                    $oldPath = public_path('uploads/avator/' . $logoName);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                // Upload new logo
                $file = $request->file("payment_logos.$method");
                $logoName = 'pay_' . time() . '_' . str_replace(' ', '_', $method) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/avator'), $logoName);
            }

            $newPaymentData[$method] = $logoName;
        }

        $data['payment_methods'] = $newPaymentData;

        if ($request->hasFile('footer_logo')) {
            // Delete old logo
            if ($setting->footer_logo) {
                $oldPath = public_path('uploads/avator/' . $setting->footer_logo);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Upload new logo
            $file = $request->file('footer_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avator'), $filename);
            $data['footer_logo'] = $filename;
        }

        $setting->update($data);

        return back()->with('success', 'Footer settings updated successfully!');
    }
}
