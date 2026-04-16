<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagmanager;
use Illuminate\Http\Request;

class GoogleTagmanagerController extends Controller
{
    public function index()
    {
        $google_tag_ids = Tagmanager::latest()->get();
        return view('admin.googletagmanager.index', compact('google_tag_ids'));
    }

    public function create()
    {
        return view('admin.googletagmanager.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'google_tag_id' => 'required|string|max:255|unique:tagmanagers,google_tag_id',
        ], [
            'google_tag_id.required' => 'Google Tag ID is required.',
            'google_tag_id.unique'   => 'This Google Tag ID already exists.',
        ]);

        Tagmanager::create([
            'google_tag_id' => $request->google_tag_id,
            'status'        => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.googletagmanager.index')
            ->with('success', 'Google Tag added successfully.');
    }

    public function edit($id)
    {
        $pixel = Tagmanager::findOrFail($id);
        return view('admin.googletagmanager.edit', compact('pixel'));
    }

    public function update(Request $request, $id)
    {
        $pixel = Tagmanager::findOrFail($id);

        $request->validate([
            'google_tag_id' => 'required|string|max:255|unique:tagmanagers,google_tag_id,' . $id,
        ], [
            'google_tag_id.required' => 'Google Tag ID is required.',
            'google_tag_id.unique'   => 'This Google Tag ID is already used by another record.',
        ]);

        $pixel->update([
            'google_tag_id' => $request->google_tag_id,
            'status'        => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.googletagmanager.index')
            ->with('success', 'Google Tag updated successfully.');
    }

    public function destroy($id)
    {
        Tagmanager::findOrFail($id)->delete();
        return back()->with('success', 'Google Tag deleted successfully.');
    }
}
