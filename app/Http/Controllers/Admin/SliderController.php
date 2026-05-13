<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

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
            'photo'       => 'required|mimes:jpg,jpeg,png,webp,gif,svg|max:5120',
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

        $this->clearHomeCache();

        return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully!');
    }

    private function clearHomeCache()
    {
        Cache::forget('home_slider');
        Cache::forget('home_categories');
        Cache::forget('home_flash_products');
        Cache::forget('home_hot_categories');
        Cache::forget('home_new_arrivals');
        Cache::forget('home_best_sellers');
        Cache::forget('home_top_rated');
        Cache::forget('home_clearance');
        Cache::forget('home_special_offers');
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
            'photo'       => 'nullable|mimes:jpg,jpeg,png,webp,gif,svg|max:5120',
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

        $this->clearHomeCache();

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

        $this->clearHomeCache();

        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully!');
    }
}
