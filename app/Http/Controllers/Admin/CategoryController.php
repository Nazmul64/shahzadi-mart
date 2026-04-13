<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name'  => 'required|string|max:255',
            'category_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photo = null;
        if ($request->hasFile('category_photo')) {
            $file  = $request->file('category_photo');
            $photo = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $uploadPath = public_path('uploads/category');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $photo);
        }

        Category::create([
            'category_name'  => $request->category_name,
            'category_photo' => $photo,
            'slug'           => Str::slug($request->category_name),
            'status'         => $request->status   ?? 'active',
            'featured'       => $request->featured  ?? 'inactive',
        ]);

        return redirect()->route('admin.category.index')
            ->with('success', 'Category Added Successfully');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name'  => 'required|string|max:255',
            'category_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photo = $category->category_photo;

        if ($request->hasFile('category_photo')) {
            $oldPath = public_path('uploads/category/' . $category->category_photo);
            if ($category->category_photo && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file  = $request->file('category_photo');
            $photo = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $uploadPath = public_path('uploads/category');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $photo);
        }

        $category->update([
            'category_name'  => $request->category_name,
            'category_photo' => $photo,
            'slug'           => Str::slug($request->category_name),
            'status'         => $request->status   ?? $category->status,
            'featured'       => $request->featured  ?? $category->featured,
        ]);

        return redirect()->route('admin.category.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function toggleFeatured(string $id)
    {
        $category = Category::findOrFail($id);
        $category->featured = $category->featured === 'active' ? 'inactive' : 'active';
        $category->save();

        return redirect()->route('admin.category.index')
            ->with('success', 'Featured status updated');
    }

    public function toggleStatus(string $id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return redirect()->route('admin.category.index')
            ->with('success', 'Status updated');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $oldPath = public_path('uploads/category/' . $category->category_photo);
        if ($category->category_photo && file_exists($oldPath)) {
            unlink($oldPath);
        }

        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
