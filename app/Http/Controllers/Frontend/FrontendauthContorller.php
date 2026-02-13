<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendauthContorller extends Controller
{
    public function customer_login()
    {
        return view('frontend.customer-auth.login');
    }

    public function customer_register_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Make sure to set the role
        ]);

        // Auto-login the user after registration
        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome aboard.');
    }

    public function customer_login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember ?? false)) {

            if (Auth::user()->role === 'customer') {
                // Regenerate session for security
                $request->session()->regenerate();

                return redirect()->route('user.dashboard')
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'You are not a customer.'])->withInput();
            }
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function customer_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
