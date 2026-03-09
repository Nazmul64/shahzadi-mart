<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminauthController extends Controller
{
    public function admin_login(){
        return view('admin.admin-auth.login');
    }


public function admin_login_submit(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $credentials = [
        'email'    => $request->email,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials, $request->remember)) {

        $user = Auth::user();

        // RBAC দিয়ে check — database থেকে dynamic
        if ($user->isAdmin()) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome, ' . $user->name . '!');
        }

        Auth::logout();
        return back()->with('error', 'You are not an admin');
    }

    return back()
        ->withInput($request->only('email', 'remember'))
        ->with('error', 'Invalid email or password');
}
    public function admin_logout()
{
    Auth::logout();
    return redirect()->route('admin.login')
        ->with('success', 'Logged out successfully');
}

}
