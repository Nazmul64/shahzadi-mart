<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // ── Index: List Users and their Roles ──────────────────────────────────────
    public function index()
    {
        // Fetch users who have roles, or all users. Let's fetch all users so he can see who has what.
        $users = User::with('roles')->latest()->get();
        return view('admin.roles.index', compact('users'));
    }

    // ── Create: Assign Role to User ────────────────────────────────────────────
    public function create()
    {
        $users = User::orderBy('name')->get();
        $roles = Role::where('is_active', true)->orderBy('name')->get();

        return view('admin.roles.create', compact('users', 'roles'));
    }

    // ── Store: Save Assigned Role ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('admin.roles.index')
            ->with('success', "'{$user->name}' কে সফলভাবে রোল অ্যাসাইন করা হয়েছে।");
    }

    // ── Edit: Edit User's Roles ────────────────────────────────────────────────
    public function edit(User $role) // Here $role is actually a User because the route binds to 'role' param but we will pass user ID. Wait, Laravel implicit binding might try to find a Role.
    {
        // To fix Route Model Binding mismatch (since route parameter is {role} but we want User):
        $user = User::findOrFail($role->id ?? request()->route('role'));
        
        $users = User::orderBy('name')->get();
        $roles = Role::where('is_active', true)->orderBy('name')->get();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admin.roles.edit', compact('user', 'users', 'roles', 'userRoles'));
    }

    // ── Update: Update Assigned Role ───────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles'   => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', "'{$user->name}' এর রোল আপডেট হয়েছে।");
    }

    // ── Destroy: Remove all roles from user ────────────────────────────────────
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->isSuperAdmin() && auth()->id() !== $user->id) {
            return back()->with('error', 'Super Admin এর রোল ডিলিট করা যাবে না।');
        }

        $user->roles()->detach();

        return redirect()->route('admin.roles.index')
            ->with('success', "'{$user->name}' এর সব রোল রিমুভ করা হয়েছে।");
    }
}
