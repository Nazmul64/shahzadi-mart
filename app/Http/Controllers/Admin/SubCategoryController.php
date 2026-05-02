<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->get();
        $categories    = Category::where('status', 'active')->get();
        
        if (request()->routeIs('manager.*')) {
            return view('manager.subcategory.index', compact('subCategories', 'categories'));
        } elseif (request()->routeIs('emplee.*')) {
            return view('emplee.subcategory.index', compact('subCategories', 'categories'));
        }
        
        return view('admin.subcategory.index', compact('subCategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_name'    => 'required|string|max:255',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'sub_name'    => $request->sub_name,
            'slug'        => Str::slug($request->sub_name),
            'featured'    => $request->featured  ?? 'inactive',
            'status'      => $request->status    ?? 'active',
        ]);

        $route = 'admin.subcategory.index';
        if (request()->routeIs('manager.*')) $route = 'manager.subcategory.index';
        if (request()->routeIs('emplee.*')) $route = 'emplee.subcategory.index';

        return redirect()->route($route)
            ->with('success', 'Sub Category Added Successfully');
    }

    public function edit(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories  = Category::where('status', 'active')->get();
        return view('admin.subcategory.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_name'    => 'required|string|max:255',
        ]);

        $subCategory->update([
            'category_id' => $request->category_id,
            'sub_name'    => $request->sub_name,
            'slug'        => Str::slug($request->sub_name),
            'featured'    => $request->featured ?? $subCategory->featured,
            'status'      => $request->status   ?? $subCategory->status,
        ]);

        return redirect()->route('admin.subcategory.index')
            ->with('success', 'Sub Category Updated Successfully');
    }

    public function toggleFeatured(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->featured = $subCategory->featured === 'active' ? 'inactive' : 'active';
        $subCategory->save();

        return redirect()->route('admin.subcategory.index')
            ->with('success', 'Featured status updated');
    }

    public function toggleStatus(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->status = $subCategory->status === 'active' ? 'inactive' : 'active';
        $subCategory->save();

        return redirect()->route('admin.subcategory.index')
            ->with('success', 'Status updated');
    }

    public function destroy(string $id)
    {
        SubCategory::findOrFail($id)->delete();

        $route = 'admin.subcategory.index';
        if (request()->routeIs('manager.*')) $route = 'manager.subcategory.index';
        if (request()->routeIs('emplee.*')) $route = 'emplee.subcategory.index';

        return redirect()->route($route)
            ->with('success', 'Sub Category Deleted Successfully');
    }
}
