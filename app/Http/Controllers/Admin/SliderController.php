<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo'       => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $uploadPath = public_path('uploads/slider');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $photo     = $request->file('photo');
        $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
        $photo->move($uploadPath, $photoName);

        Slider::create([
            'photo'       => 'uploads/slider/' . $photoName,
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully!');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $photoPath = $slider->photo;

        if ($request->hasFile('photo')) {
            $oldPhotoPath = public_path($slider->photo);
            if (File::exists($oldPhotoPath)) {
                File::delete($oldPhotoPath);
            }

            $uploadPath = public_path('uploads/slider');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $photo     = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move($uploadPath, $photoName);
            $photoPath = 'uploads/slider/' . $photoName;
        }

        $slider->update([
            'photo'       => $photoPath,
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(string $id)
    {
        $slider       = Slider::findOrFail($id);
        $oldPhotoPath = public_path($slider->photo);

        if (File::exists($oldPhotoPath)) {
            File::delete($oldPhotoPath);
        }

        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully!');
    }
}
