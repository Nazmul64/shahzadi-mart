<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        if ($user) {
            if ($user->isAdmin()) return route('admin.dashboard');
            if ($user->isManager()) return route('manager.dashboard');
            if ($user->isEmployee()) return route('emplee.dashboard');
            if ($user->isSeller()) return route('saller.dashboard');
            if ($user->isCustomer()) return route('user.dashboard');
        }
        return '/login';
    }
}
