<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────
    public function index()
    {
        // DB থেকে group করে আনা — hardcode নয়
        $permissions = Permission::withCount('roles')
            ->orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy(fn ($p) => $p->group ?? 'General');

        return view('admin.permissions.index', compact('permissions'));
    }

    // ── Create ─────────────────────────────────────────────────────────────────
    public function create()
    {
        $groups = Permission::getAllGroups(); // DB থেকে
        return view('admin.permissions.create', compact('groups'));
    }

    // ── Store ──────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
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

        return redirect()->route('permissions.index')
            ->with('success', "'{$request->name}' পারমিশন তৈরি হয়েছে।");
    }

    // ── Show ───────────────────────────────────────────────────────────────────
    public function show(Permission $permission)
    {
        return redirect()->route('permissions.edit', $permission);
    }

    // ── Edit ───────────────────────────────────────────────────────────────────
    public function edit(Permission $permission)
    {
        $groups = Permission::getAllGroups();
        return view('admin.permissions.edit', compact('permission', 'groups'));
    }

    // ── Update ─────────────────────────────────────────────────────────────────
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
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

        return redirect()->route('permissions.index')
            ->with('success', "'{$permission->name}' পারমিশন আপডেট হয়েছে।");
    }

    // ── Destroy ────────────────────────────────────────────────────────────────
    public function destroy(Permission $permission)
    {
        $name = $permission->name;
        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', "'{$name}' পারমিশন ডিলিট হয়েছে।");
    }

    // ── Bulk Create ────────────────────────────────────────────────────────────
    public function bulkCreate(Request $request)
    {
        $request->validate([
            'group'   => 'required|string|max:100',
            'actions' => 'required|string',
        ]);

        $group   = trim($request->group);
        $actions = array_filter(array_map('trim', explode(',', $request->actions)));

        if (empty($actions)) {
            return back()->with('error', 'কমপক্ষে একটি action দিন।');
        }

        $created = 0;
        $skipped = 0;

        foreach ($actions as $action) {
            // e.g. group="Products" + action="view" → name="Products View", slug="products-view"
            $name = $group . ' ' . ucfirst($action);
            $slug = Str::slug($name);

            if (Permission::where('slug', $slug)->exists()) {
                $skipped++;
                continue;
            }

            Permission::create([
                'name'  => $name,
                'slug'  => $slug,
                'group' => $group,
            ]);
            $created++;
        }

        $msg = "{$created}টি পারমিশন তৈরি হয়েছে।";
        if ($skipped > 0) {
            $msg .= " {$skipped}টি আগে থেকেই ছিল, skip হয়েছে।";
        }

        return redirect()->route('permissions.index')->with('success', $msg);
    }
}
