<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footercategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FootercategoryController extends Controller
{
    // সব Footer Category দেখাবে
    public function index()
    {
        $footercategories = Footercategory::latest()->get();
        return view('admin.footercategory.index', compact('footercategories'));
    }

    // Create form দেখাবে
    public function create()
    {
        return view('admin.footercategory.create');
    }

    // নতুন Category save করবে
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255',
        ]);

        Footercategory::create([
            'category_name' => $request->category_name,
            'category_slug' => $request->category_slug
                ? Str::slug($request->category_slug)
                : Str::slug($request->category_name),
        ]);

        return redirect()->route('admin.footercategory.index')
            ->with('success', 'Footer Category সফলভাবে তৈরি হয়েছে!');
    }

    // Edit form দেখাবে
    public function edit(string $id)
    {
        $footercategory = Footercategory::findOrFail($id);
        return view('admin.footercategory.edit', compact('footercategory'));
    }

    // Category আপডেট করবে
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255',
        ]);

        $footercategory = Footercategory::findOrFail($id);
        $footercategory->update([
            'category_name' => $request->category_name,
            'category_slug' => $request->category_slug
                ? Str::slug($request->category_slug)
                : Str::slug($request->category_name),
        ]);

        return redirect()->route('admin.footercategory.index')
            ->with('success', 'Footer Category সফলভাবে আপডেট হয়েছে!');
    }

    // Category delete করবে
    public function destroy(string $id)
    {
        $footercategory = Footercategory::findOrFail($id);
        $footercategory->delete();

        return redirect()->route('admin.footercategory.index')
            ->with('success', 'Footer Category সফলভাবে মুছে ফেলা হয়েছে!');
    }
    public function show(string $id)
{
    $footercategory = Footercategory::findOrFail($id);
    return view('admin.footercategory.show', compact('footercategory'));
}
}
