<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminController extends Controller
{
    public function subadmin_login()
    {
        if (Auth::check() && Auth::user()->load('roles')->isSubAdmin()) {
            return redirect()->route('subadmin.dashboard');
        }

        return view('subadmin.auth.login');
    }

    public function subadmin_login_submit(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // roles সহ user load করো
        $user = User::with('roles')->where('email', $request->email)->first();

        // User নেই
        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->withInput();
        }

        // Sub Admin role নেই
        if (!$user->isSubAdmin()) {
            return back()->withErrors([
                'email' => 'Access denied. Sub Admin account only.',
            ])->withInput();
        }

        // Account active নয়
        if (in_array($user->status, ['inactive', 'suspended', 'pending'])) {
            return back()->withErrors([
                'email' => 'Your account is not active. Contact administrator.',
            ])->withInput();
        }

        // Password check
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('subadmin.dashboard')
                ->with('success', 'Login successful. Welcome to the Sub Admin panel!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function subadmin_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('subadmin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function subadmin_dashboard()
    {
        return view('subadmin.index');
    }
}
