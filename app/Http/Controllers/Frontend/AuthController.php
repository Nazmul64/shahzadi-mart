<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Login Form
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('admin.roles.index');
        return view('auth.login');
    }

    // ── Login Submit
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.roles.index'));
        }

        return back()->withErrors(['email' => 'Email বা Password ভুল।'])->withInput();
    }

    // ── Register Form
    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('admin.roles.index');
        return view('auth.register');
    }

    // ── Register Submit
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Default role auto-assign
        $defaultRole = Role::where('is_default', 1)->first();
        if ($defaultRole) {
            $user->roles()->attach($defaultRole->id);
        }

        Auth::login($user);
        return redirect()->route('admin.roles.index');
    }

    // ── Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
