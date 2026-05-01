<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // ── Index: List Users and their Direct Permissions ─────────────────────────
    public function index()
    {
        // Users who have direct permissions
        $users = User::has('directPermissions')->with('directPermissions')->latest()->get();
        return view('admin.permissions.index', compact('users'));
    }

    // ── Create: Assign Permissions to User ─────────────────────────────────────
    public function create()
    {
        $users = User::orderBy('name')->get();
        $permissions = Permission::orderBy('group')->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        return view('admin.permissions.create', compact('users', 'permissions'));
    }

    // ── Store: Save Assigned Permissions ───────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($request->filled('permissions')) {
            $user->directPermissions()->sync($request->permissions);
        } else {
            $user->directPermissions()->detach();
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$user->name}' কে সফলভাবে পারমিশন দেওয়া হয়েছে।");
    }

    // ── Edit: Edit User's Direct Permissions ───────────────────────────────────
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $users = User::orderBy('name')->get();
        $permissions = Permission::orderBy('group')->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');
            
        $userPermissions = $user->directPermissions->pluck('id')->toArray();

        return view('admin.permissions.edit', compact('user', 'users', 'permissions', 'userPermissions'));
    }

    // ── Update: Update Assigned Permissions ────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->directPermissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$user->name}' এর পারমিশন আপডেট হয়েছে।");
    }

    // ── Destroy: Remove all direct permissions from user ───────────────────────
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->directPermissions()->detach();

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$user->name}' এর সব পারমিশন রিমুভ করা হয়েছে।");
    }
}
