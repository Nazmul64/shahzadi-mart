<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pixel;
use Illuminate\Http\Request;

class PixelController extends Controller
{
    public function index()
    {
        $pixels = Pixel::latest()->get();
        return view('admin.pixel.index', compact('pixels'));
    }

    public function create()
    {
        return view('admin.pixel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pixel_id' => 'required|string|max:255|unique:pixels,pixel_id',
        ], [
            'pixel_id.unique' => 'This Pixel ID already exists.',
        ]);

        Pixel::create([
            'pixel_id' => $request->pixel_id,
            'status'   => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.pixels.index')
            ->with('success', 'Pixel added successfully.');
    }

    public function edit($id)
    {
        $pixel = Pixel::findOrFail($id);
        return view('admin.pixel.edit', compact('pixel'));
    }

    public function update(Request $request, $id)
    {
        $pixel = Pixel::findOrFail($id);

        $request->validate([
            'pixel_id' => 'required|string|max:255|unique:pixels,pixel_id,' . $id,
        ], [
            'pixel_id.unique' => 'This Pixel ID is already used by another record.',
        ]);

        $pixel->update([
            'pixel_id' => $request->pixel_id,
            'status'   => $request->boolean('status') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.pixels.index')
            ->with('success', 'Pixel updated successfully.');
    }

    public function destroy($id)
    {
        Pixel::findOrFail($id)->delete();

        return back()->with('success', 'Pixel deleted successfully.');
    }
}
