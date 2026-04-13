<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // ── Create ─────────────────────────────────────────────────────────────────
    public function create()
    {
        $roles = Role::where('is_active', true)->orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    // ── Store ──────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'nullable|array',
            'roles.*'  => 'exists:roles,id',
            'status'   => 'nullable|in:active,inactive,pending,suspended',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status ?? 'active',
        ]);

        if ($request->filled('roles')) {
            $user->roles()->attach($request->roles);
        } else {
            // Default role attach করা
            $defaultRole = Role::where('is_default', true)
                ->where('is_active', true)
                ->first();
            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', "'{$user->name}' ইউজার তৈরি হয়েছে।");
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }

    // ── Edit (Role Assign Form) ────────────────────────────────────────────────
    public function edit(User $user)
    {
        $roles     = Role::where('is_active', true)->withCount('permissions')->orderBy('name')->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    // ── Update (Save Roles) ────────────────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', "'{$user->name}' এর রোল আপডেট হয়েছে।");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'নিজেকে ডিলিট করা যাবে না।');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Super Admin ডিলিট করা যাবে না।');
        }

        $name = $user->name;
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "'{$name}' ইউজার ডিলিট হয়েছে।");
    }

    // ── Toggle Status ──────────────────────────────────────────────────────────
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'নিজের স্ট্যাটাস পরিবর্তন করা যাবে না।');
        }

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', "'{$user->name}' এর স্ট্যাটাস পরিবর্তন হয়েছে।");
    }
}
