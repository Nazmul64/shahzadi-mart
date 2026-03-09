<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleeController extends Controller
{
    // Employee Dashboard
    public function emplee_dashboard()
    {
        return view('emplee.index');
    }

    // Show Login Page
    public function emplee()
    {
        return view('emplee.auth.login');
    }

    // Login Submit
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('emplee.dashboard')
                ->with('success', 'Login successful. Welcome to the employee panel!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    // Logout
    public function emplee_logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('emplee.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
