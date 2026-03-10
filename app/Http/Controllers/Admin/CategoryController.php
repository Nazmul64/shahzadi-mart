<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Category List
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    // Create Page (modal used — redirect back)
    public function create()
    {
        return redirect()->route('category.index');
    }

    // Store Category
    public function store(Request $request)
    {
        $request->validate([
            'category_name'  => 'required',
            'category_photo' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $photo = null;
        if ($request->hasFile('category_photo')) {
            $file  = $request->file('category_photo');
            $photo = time() . '.' . $file->getClientOriginalExtension();

            // Create folder if not exists
            if (!file_exists(public_path('uploads/category'))) {
                mkdir(public_path('uploads/category'), 0777, true);
            }

            $file->move(public_path('uploads/category'), $photo);
        }

        $data = [
            'category_name'  => $request->category_name,
            'category_photo' => $photo,
            'slug'           => Str::slug($request->category_name),
            'status'         => $request->status ?? 'active',
        ];

        // Only add featured if column exists
        if (\Schema::hasColumn('categories', 'featured')) {
            $data['featured'] = $request->featured ?? 'inactive';
        }

        Category::create($data);

        return redirect()->route('category.index')
            ->with('success', 'Category Added Successfully');
    }

    // Edit Page (modal used — redirect back)
    public function edit(string $id)
    {
        return redirect()->route('category.index');
    }

    // Update Category
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required',
        ]);

        $photo = $category->category_photo;
        if ($request->hasFile('category_photo')) {
            if (file_exists(public_path('uploads/category/' . $category->category_photo))) {
                unlink(public_path('uploads/category/' . $category->category_photo));
            }
            $file  = $request->file('category_photo');
            $photo = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/category'), $photo);
        }

        $data = [
            'category_name'  => $request->category_name,
            'category_photo' => $photo,
            'slug'           => Str::slug($request->category_name),
            'status'         => $request->status ?? $category->status,
        ];

        // Only update featured if column exists
        if (\Schema::hasColumn('categories', 'featured')) {
            $data['featured'] = $request->featured ?? $category->featured;
        }

        $category->update($data);

        return redirect()->route('category.index')
            ->with('success', 'Category Updated Successfully');
    }

    // Toggle Featured
    public function toggleFeatured(string $id)
    {
        $category = Category::findOrFail($id);

        if (\Schema::hasColumn('categories', 'featured')) {
            $category->featured = $category->featured === 'active' ? 'inactive' : 'active';
            $category->save();
        }

        return redirect()->route('category.index')
            ->with('success', 'Featured status updated');
    }

    // Toggle Status
    public function toggleStatus(string $id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return redirect()->route('category.index')
            ->with('success', 'Status updated');
    }

    // Delete Category
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if (file_exists(public_path('uploads/category/' . $category->category_photo))) {
            unlink(public_path('uploads/category/' . $category->category_photo));
        }

        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
