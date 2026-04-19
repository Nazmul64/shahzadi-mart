<?php
// ══════════════════════════════════════════════════
// app/Http/Controllers/Admin/PaymentSettingController.php
// ══════════════════════════════════════════════════

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bkash;
use App\Models\Shurjopay;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    /* ─────────────────────────────────────────────
       MAIN PAGE — Bkash + Shurjopay একসাথে
    ───────────────────────────────────────────── */
    public function index()
    {
        $bkash     = Bkash::first();
        $shurjopay = Shurjopay::first();

        return view('admin.payment.index', compact('bkash', 'shurjopay'));
    }

    /* ─────────────────────────────────────────────
       BKASH — Save / Update
    ───────────────────────────────────────────── */
    public function bkashStore(Request $request)
    {
        $request->validate([
            'username'   => 'required|string|max:255',
            'app_key'    => 'required|string|max:255',
            'app_secret' => 'required|string|max:255',
            'base_url'   => 'required|string|max:255',
            'password'   => 'required|string|max:255',
        ]);

        $data = [
            'username'   => $request->username,
            'app_key'    => $request->app_key,
            'app_secret' => $request->app_secret,
            'base_url'   => $request->base_url,
            'password'   => $request->password,
            'status'     => $request->has('status') ? 1 : 0,
        ];

        $bkash = Bkash::first();

        if ($bkash) {
            $bkash->update($data);
        } else {
            Bkash::create($data);
        }

        return redirect()->route('admin.payment.index')
                         ->with('bkash_success', 'Bkash সেটিং সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    /* ─────────────────────────────────────────────
       SHURJOPAY — Save / Update
    ───────────────────────────────────────────── */
    public function shurjopayStore(Request $request)
    {
        $request->validate([
            'username'    => 'required|string|max:255',
            'prefix'      => 'required|string|max:50',
            'success_url' => 'required|string|max:255',
            'return_url'  => 'required|string|max:255',
            'base_url'    => 'required|string|max:255',
            'password'    => 'required|string|max:255',
        ]);

        $data = [
            'username'    => $request->username,
            'prefix'      => $request->prefix,
            'success_url' => $request->success_url,
            'return_url'  => $request->return_url,
            'base_url'    => $request->base_url,
            'password'    => $request->password,
            'status'      => $request->has('status') ? 1 : 0,
        ];

        $shurjopay = Shurjopay::first();

        if ($shurjopay) {
            $shurjopay->update($data);
        } else {
            Shurjopay::create($data);
        }

        return redirect()->route('admin.payment.index')
                         ->with('shurjopay_success', 'Shurjopay সেটিং সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    /* ─────────────────────────────────────────────
       BKASH STATUS TOGGLE (optional AJAX)
    ───────────────────────────────────────────── */
    public function bkashToggle()
    {
        $bkash = Bkash::first();
        if ($bkash) {
            $bkash->update(['status' => $bkash->status ? 0 : 1]);
            return response()->json(['status' => $bkash->status]);
        }
        return response()->json(['error' => 'Not found'], 404);
    }

    /* ─────────────────────────────────────────────
       SHURJOPAY STATUS TOGGLE (optional AJAX)
    ───────────────────────────────────────────── */
    public function shurjopayToggle()
    {
        $shurjopay = Shurjopay::first();
        if ($shurjopay) {
            $shurjopay->update(['status' => $shurjopay->status ? 0 : 1]);
            return response()->json(['status' => $shurjopay->status]);
        }
        return response()->json(['error' => 'Not found'], 404);
    }
}
