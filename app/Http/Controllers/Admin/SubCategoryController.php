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
        $categories    = Category::orderBy('category_name')->get();
        return view('admin.subcategory.index', compact('subCategories', 'categories'));
    }

    public function create()
    {
        return redirect()->route('subcategory.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_name'    => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::create([
            'sub_name'    => $request->sub_name,
            'slug'        => Str::slug($request->sub_name),
            'category_id' => $request->category_id,
            'featured'    => $request->featured ?? 'inactive',
            'status'      => $request->status   ?? 'active',
        ]);

        return redirect()->route('subcategory.index')
            ->with('success', 'Sub Category Added Successfully');
    }

    public function edit(string $id)
    {
        return redirect()->route('subcategory.index');
    }

    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $request->validate([
            'sub_name'    => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subCategory->update([
            'sub_name'    => $request->sub_name,
            'slug'        => Str::slug($request->sub_name),
            'category_id' => $request->category_id,
            'featured'    => $request->featured ?? $subCategory->featured,
            'status'      => $request->status   ?? $subCategory->status,
        ]);

        return redirect()->route('subcategory.index')
            ->with('success', 'Sub Category Updated Successfully');
    }

    public function toggleFeatured(string $id)
    {
        $sub           = SubCategory::findOrFail($id);
        $sub->featured = $sub->featured === 'active' ? 'inactive' : 'active';
        $sub->save();
        return redirect()->route('subcategory.index')->with('success', 'Featured status updated');
    }

    public function toggleStatus(string $id)
    {
        $sub         = SubCategory::findOrFail($id);
        $sub->status = $sub->status === 'active' ? 'inactive' : 'active';
        $sub->save();
        return redirect()->route('subcategory.index')->with('success', 'Status updated');
    }

    public function destroy(string $id)
    {
        SubCategory::findOrFail($id)->delete();
        return redirect()->route('subcategory.index')->with('success', 'Sub Category Deleted Successfully');
    }
}
