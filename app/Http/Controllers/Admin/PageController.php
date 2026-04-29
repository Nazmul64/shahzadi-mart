<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footercategory;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pagescreate.index', compact('pages'));
    }

    public function create()
    {
        $categories = Footercategory::latest()->get();
        return view('admin.pagescreate.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:footercategories,id',
            'status'      => 'nullable',
        ]);

        Page::create([
            'name'        => $request->name,
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status'      => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return view('admin.pagescreate.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $categories = Footercategory::latest()->get();
        return view('admin.pagescreate.edit', compact('page', 'categories'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:footercategories,id',
            'status'      => 'nullable',
        ]);

        $page->update([
            'name'        => $request->name,
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status'      => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
