<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = Permission::getAllGroups();
        return view('admin.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group' => 'required|string',
            'description' => 'nullable|string'
        ]);

        Permission::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'group' => $request->group,
            'description' => $request->description
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission তৈরি হয়েছে!');
    }

    public function edit(Permission $permission)
    {
        $groups = Permission::getAllGroups();
        return view('admin.permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'group' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $permission->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'group' => $request->group,
            'description' => $request->description
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission আপডেট হয়েছে!');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission মুছে ফেলা হয়েছে!');
    }
}
