<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->latest()->get();
        return view('admin.roles.index', compact('roles'));
    }

    // ── Create ─────────────────────────────────────────────────────────────────
    public function create()
    {
        // DB থেকে group করে আনা — hardcode নয়
        $permissions = Permission::orderBy('group')->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        return view('admin.roles.create', compact('permissions'));
    }

    // ── Store ──────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:roles,name',
            'description'   => 'nullable|string|max:255',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', true),
            'is_default'  => $request->boolean('is_default', false),
        ]);

        if ($request->filled('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', "'{$role->name}' রোল সফলভাবে তৈরি হয়েছে।");
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(Role $role)
    {
        return redirect()->route('roles.edit', $role);
    }

    // ── Edit ───────────────────────────────────────────────────────────────────
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('group')->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // ── Update ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'          => "required|string|max:100|unique:roles,name,{$role->id}",
            'description'   => 'nullable|string|max:255',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', true),
            'is_default'  => $request->boolean('is_default', false),
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', "'{$role->name}' রোল আপডেট হয়েছে।");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(Role $role)
    {
        // Protected roles — slug DB থেকে আসে
        if (in_array($role->slug, ['super-admin', 'admin'])) {
            return back()->with('error', "'{$role->name}' রোল ডিলিট করা যাবে না।");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "এই রোলে {$role->users()->count()} জন ইউজার আছে, তাই ডিলিট করা যাবে না।");
        }

        $roleName = $role->name;
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', "'{$roleName}' রোল ডিলিট হয়েছে।");
    }

    // ── Assign Permission (Dedicated Page) ─────────────────────────────────────
    public function assignPermission(Role $role)
    {
        $permissions = Permission::orderBy('group')->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.assign_permission', compact('role', 'permissions', 'rolePermissions'));
    }

    // ── Save Assigned Permission ───────────────────────────────────────────────
    public function saveAssignedPermission(Request $request, Role $role)
    {
        $request->validate([
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('roles.index')
            ->with('success', "'{$role->name}' রোলের পারমিশন সেভ হয়েছে।");
    }
}
