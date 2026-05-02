<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Show the profile edit page based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('admin.profile.index', compact('user'));
        } elseif ($user->isManager()) {
            return view('manager.profile.index', compact('user'));
        } elseif ($user->isEmployee()) {
            return view('emplee.profile.index', compact('user'));
        }

        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    /**
     * Update basic profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && File::exists(public_path('uploads/avator/' . $user->photo))) {
                File::delete(public_path('uploads/avator/' . $user->photo));
            }

            $image = $request->file('photo');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/avator'), $name);
            $data['photo'] = $name;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে।');
    }
}
