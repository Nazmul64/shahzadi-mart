<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildSubCategory;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class ChildSubCategoryController extends Controller
{
    public function index()
    {
        $childSubCategories = ChildSubCategory::with('subCategory.category')->latest()->get();
        $categories         = Category::orderBy('category_name')->get();
        return view('admin.childcategory.index', compact('childSubCategories', 'categories'));
    }

    public function create()
    {
        return redirect()->route('childcategory.index');
    }

    // AJAX: SubCategories by Category ID
    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->category_id)
            ->orderBy('sub_name')
            ->get(['id', 'sub_name']);
        return response()->json($subCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'child_sub_name'  => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        ChildSubCategory::create([
            'child_sub_name'  => $request->child_sub_name,
            'slug'            => Str::slug($request->child_sub_name),
            'sub_category_id' => $request->sub_category_id,
            'featured'        => $request->featured ?? false,
            'status'          => $request->status   ?? true,
        ]);

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Sub Category Added Successfully');
    }

    public function edit(string $id)
    {
        return redirect()->route('childcategory.index');
    }

    public function update(Request $request, string $id)
    {
        $child = ChildSubCategory::findOrFail($id);

        $request->validate([
            'child_sub_name'  => 'required',
            'sub_category_id' => 'required|exists:sub_categories,id',
        ]);

        $child->update([
            'child_sub_name'  => $request->child_sub_name,
            'slug'            => Str::slug($request->child_sub_name),
            'sub_category_id' => $request->sub_category_id,
            'featured'        => $request->featured ?? $child->featured,
            'status'          => $request->status   ?? $child->status,
        ]);

        return redirect()->route('childcategory.index')
            ->with('success', 'Child Sub Category Updated Successfully');
    }

    public function childtoggleFeatured(string $id)
    {
        $child           = ChildSubCategory::findOrFail($id);
        $child->featured = !$child->featured;
        $child->save();
        return redirect()->route('childcategory.index')->with('success', 'Featured status updated');
    }

    public function childtoggleStatus(string $id)
    {
        $child         = ChildSubCategory::findOrFail($id);
        $child->status = !$child->status;
        $child->save();
        return redirect()->route('childcategory.index')->with('success', 'Status updated');
    }

    public function destroy(string $id)
    {
        ChildSubCategory::findOrFail($id)->delete();
        return redirect()->route('childcategory.index')->with('success', 'Child Sub Category Deleted Successfully');
    }
}
