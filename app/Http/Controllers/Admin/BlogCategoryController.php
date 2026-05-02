<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    private function getViewPrefix()
    {
        if (request()->routeIs('manager.*')) return 'manager.blog_category';
        if (request()->routeIs('emplee.*')) return 'emplee.blog_category';
        return 'admin.blog_category';
    }

    private function getRoutePrefix()
    {
        if (request()->routeIs('manager.*')) return 'manager.blog-categories';
        if (request()->routeIs('emplee.*')) return 'emplee.blog-categories';
        return 'admin.blog-categories';
    }

    public function index()
    {
        $categories = BlogCategory::latest()->get();
        return view($this->getViewPrefix() . '.index', compact('categories'));
    }

    public function create()
    {
        return view($this->getViewPrefix() . '.create_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status'),
        ]);

        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Category Created Successfully');
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view($this->getViewPrefix() . '.create_edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status'),
        ]);

        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();
        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Category Deleted Successfully');
    }
}
