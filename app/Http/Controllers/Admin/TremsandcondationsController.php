<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tremsandcondation;
use Illuminate\Http\Request;

class TremsandcondationsController extends Controller
{
    public function index()
    {
        $terms = Tremsandcondation::latest()->get();
        return view('admin.tremsandcondation.index', compact('terms'));
    }

    public function create()
    {
        return view('admin.tremsandcondation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:active,inactive',
        ]);

        Tremsandcondation::create($request->all());

        return redirect()->route('admin.tremsandcondation.index')
                         ->with('success', 'Terms & Conditions created successfully!');
    }

    public function show(string $id)
    {
        $term = Tremsandcondation::findOrFail($id);
        return view('admin.tremsandcondation.show', compact('term'));
    }

    public function edit(string $id)
    {
        $term = Tremsandcondation::findOrFail($id);
        return view('admin.tremsandcondation.edit', compact('term'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:active,inactive',
        ]);

        $term = Tremsandcondation::findOrFail($id);
        $term->update($request->all());

        return redirect()->route('admin.tremsandcondation.index')
                         ->with('success', 'Terms & Conditions updated successfully!');
    }

    public function destroy(string $id)
    {
        $term = Tremsandcondation::findOrFail($id);
        $term->delete();

        return redirect()->route('admin.tremsandcondation.index')
                         ->with('success', 'Terms & Conditions deleted successfully!');
    }
}
