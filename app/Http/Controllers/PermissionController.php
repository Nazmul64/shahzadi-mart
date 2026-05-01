<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::withCount('roles')
            ->orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = Permission::getAllGroups();
        return view('admin.permissions.create', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:permissions,name',
            'slug'        => 'required|string|max:100|unique:permissions,slug',
            'group'       => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        Permission::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->slug),
            'group'       => $request->group ?: null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$request->name}' পারমিশন তৈরি হয়েছে।");
    }

    public function show(Permission $permission): RedirectResponse
    {
        return redirect()->route('admin.permissions.edit', $permission);
    }

    public function edit(Permission $permission)
    {
        $groups = Permission::getAllGroups();
        return view('admin.permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $request->validate([
            'name'        => "required|string|max:100|unique:permissions,name,{$permission->id}",
            'slug'        => "required|string|max:100|unique:permissions,slug,{$permission->id}",
            'group'       => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $permission->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->slug),
            'group'       => $request->group ?: null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$permission->name}' পারমিশন আপডেট হয়েছে।");
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $name = $permission->name;
        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', "'{$name}' পারমিশন ডিলিট হয়েছে।");
    }

    public function bulkCreate(Request $request): RedirectResponse
    {
        $request->validate([
            'group'   => 'required|string|max:100',
            'actions' => 'required|string',
        ]);

        $group   = trim($request->group);
        $actions = collect(explode(',', $request->actions))
            ->map(fn ($a) => trim($a))
            ->filter()
            ->unique();

        $created = 0;
        foreach ($actions as $action) {
            $name = $group . ' ' . ucfirst($action);
            $slug = Str::slug($name);

            Permission::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'slug' => $slug, 'group' => $group]
            );
            $created++;
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', "{$created} টি পারমিশন তৈরি হয়েছে (Group: {$group})।");
    }
}
