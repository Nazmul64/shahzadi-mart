<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mailsetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailsettingController extends Controller
{
    /**
     * Display mail settings page.
     */
    public function index()
    {
        $setting = Mailsetting::first();
        return view('admin.mailsetting.index', compact('setting'));
    }

    /**
     * Update mail settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'mail_mailer'       => 'required|string',
            'mail_host'         => 'required|string',
            'mail_port'         => 'required|string',
            'mail_username'     => 'required|string',
            'mail_password'     => 'nullable|string',
            'mail_encryption'   => 'required|string',
            'mail_from_address' => 'required|email',
            'mail_from_name'    => 'required|string',
        ]);

        $setting = Mailsetting::first();
        if (!$setting) {
            $setting = new Mailsetting();
        }

        $setting->mail_mailer       = $request->mail_mailer;
        $setting->mail_host         = $request->mail_host;
        $setting->mail_port         = $request->mail_port;
        $setting->mail_username     = $request->mail_username;
        if ($request->mail_password) {
            $setting->mail_password = $request->mail_password;
        }
        $setting->mail_encryption   = $request->mail_encryption;
        $setting->mail_from_address = $request->mail_from_address;
        $setting->mail_from_name    = $request->mail_from_name;
        $setting->save();

        return back()->with('success', 'Mail configuration updated successfully!');
    }

    /**
     * Send a test email.
     */
    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $setting = Mailsetting::first();
        if (!$setting) {
            return back()->with('error', 'Please configure mail settings first.');
        }

        try {
            // Apply settings dynamically
            config([
                'mail.mailers.smtp.host'       => $setting->mail_host,
                'mail.mailers.smtp.port'       => $setting->mail_port,
                'mail.mailers.smtp.encryption' => $setting->mail_encryption,
                'mail.mailers.smtp.username'   => $setting->mail_username,
                'mail.mailers.smtp.password'   => $setting->mail_password,
                'mail.from.address'            => $setting->mail_from_address,
                'mail.from.name'               => $setting->mail_from_name,
            ]);

            Mail::raw($request->message, function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Test Mail from Admin Panel');
            });

            return back()->with('success', 'Test email sent successfully to ' . $request->email);
        } catch (Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
