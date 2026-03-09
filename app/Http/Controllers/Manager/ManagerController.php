<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function manager_login()
    {
        if (Auth::check() && Auth::user()->load('roles')->isManager()) {
            return redirect()->route('manager.dashboard');
        }

        return view('manager.auth.login');
    }

    public function manager_login_submit(Request $request)
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

        // Manager role নেই
        if (!$user->isManager()) {
            return back()->withErrors([
                'email' => 'Access denied. Manager account only.',
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

            return redirect()->route('manager.dashboard')
                ->with('success', 'Login successful. Welcome to the Manager panel!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    public function manager_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('manager.login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function manager_dashboard()
    {
        return view('manager.index');
    }
}
