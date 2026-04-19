<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FrontendauthContorller extends Controller
{
    // ─── Show Login / Register Page ──────────────────────────────────────────
    public function customer_login()
    {
        // যদি already logged in থাকে redirect করো
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('frontend.customer-auth.login');
    }

    // ─── customer_register (GET) — same login view, signup tab active ─────────
    public function customer_register()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('frontend.customer-auth.login');
    }

    // ─── Register Submit ──────────────────────────────────────────────────────
    public function customer_register_submit(Request $request)
    {
        // ── Validation ──
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Name is required.',
            'email.required'     => 'Email is required.',
            'email.unique'       => 'This email is already registered.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        try {
            // ── Create User ──
            $userData = [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'status'   => 'active',
            ];

            // phone column যদি users table-এ থাকে তাহলে add করো
            if ($request->filled('phone')) {
                $userData['phone'] = $request->phone;
            }

            $user = User::create($userData);

            // ── Role Assign (যদি Role model ও roles() relationship থাকে) ──
            // Role model না থাকলে এই block skip হবে — error হবে না
            if (class_exists(\App\Models\Role::class)) {
                try {
                    $customerRole = \App\Models\Role::where('slug', 'customer')
                                        ->orWhere('name', 'customer')
                                        ->first();
                    if ($customerRole && method_exists($user, 'roles')) {
                        $user->roles()->attach($customerRole->id);
                    }
                } catch (\Exception $roleEx) {
                    // Role assign fail হলেও registration চলবে
                    Log::warning('Role assign failed: ' . $roleEx->getMessage());
                }
            }

            // ── Auto Login ──
            Auth::login($user);

            return redirect()->route('user.dashboard')
                ->with('success', 'Registration successful! Welcome, ' . $user->name . '!');

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Registration DB error: ' . $e->getMessage());

            // Duplicate entry check
            if ($e->getCode() == 23000) {
                return back()
                    ->withErrors(['email' => 'This email or phone is already registered.'])
                    ->withInput($request->except('password', 'password_confirmation'));
            }

            return back()
                ->withErrors(['email' => 'Registration failed. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation'));

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());

            return back()
                ->withErrors(['email' => 'Something went wrong. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    // ─── Login Submit ─────────────────────────────────────────────────────────
    public function customer_login_submit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Enter a valid email.',
            'password.required' => 'Password is required.',
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        // ── Check user exists & status ──
        $user = User::where('email', $request->email)->first();

        if ($user && isset($user->status) && $user->status === 'banned') {
            return back()
                ->withErrors(['email' => 'Your account has been suspended.'])
                ->withInput($request->only('email'));
        }

        // ── Attempt Login ──
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $loggedUser = Auth::user();

            // ── Admin / Staff কে customer dashboard-এ ঢুকতে দেওয়া হবে না ──
            // Role check — hasRole() method থাকলে use করো, না থাকলে skip
            if (method_exists($loggedUser, 'hasRole')) {
                // Admin হলে logout করে admin panel-এ পাঠাও
                if ($loggedUser->hasRole('admin') || $loggedUser->hasRole('super-admin')) {
                    Auth::logout();
                    return back()
                        ->withErrors(['email' => 'Please use the admin login panel.'])
                        ->withInput($request->only('email'));
                }
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Welcome back, ' . $loggedUser->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput($request->only('email'));
    }

    // ─── Logout ───────────────────────────────────────────────────────────────
    public function customer_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
