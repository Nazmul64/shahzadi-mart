<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutForCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutForCompanyController extends Controller
{
    // ── Helper: image upload to uploads/aboutcompany/ ─────────────────
    private function uploadImage($file, ?string $oldPath = null): string
    {
        $dir = public_path('uploads/aboutcompany');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // পুরানো ছবি delete করো
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);

        return 'uploads/aboutcompany/' . $filename;
    }

    // ── Helper: image delete ──────────────────────────────────────────
    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // INDEX — শুধু একটাই row থাকবে (singleton pattern)
    // ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $about = AboutForCompany::first();
        return view('admin.aboutcompany.index', compact('about'));
    }

    // ─────────────────────────────────────────────────────────────────
    // CREATE
    // ─────────────────────────────────────────────────────────────────
    public function create()
    {
        // যদি ইতিমধ্যে data আছে তাহলে edit এ redirect করো
        $existing = AboutForCompany::first();
        if ($existing) {
            return redirect()->route('admin.aboutcompany.edit', $existing->id)
                ->with('info', 'Company info আছে। এখানে edit করুন।');
        }

        return view('admin.aboutcompany.create');
    }

    // ─────────────────────────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'company_name'      => 'required|string|max:255',
            'tagline'           => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'about_description' => 'nullable|string',
            'mission'           => 'nullable|string',
            'vision'            => 'nullable|string',
            'values'            => 'nullable|string',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'about_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'founded_year'      => 'nullable|string|max:10',
            'total_employees'   => 'nullable|string|max:50',
            'total_clients'     => 'nullable|string|max:50',
            'total_projects'    => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:30',
            'address'           => 'nullable|string|max:500',
            'website'           => 'nullable|url|max:255',
            'facebook'          => 'nullable|url|max:255',
            'instagram'         => 'nullable|url|max:255',
            'twitter'           => 'nullable|url|max:255',
            'youtube'           => 'nullable|url|max:255',
            'linkedin'          => 'nullable|url|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string|max:500',
        ]);

        $data = $request->except(['logo', 'banner_image', 'about_image', '_token']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo'))         $data['logo']         = $this->uploadImage($request->file('logo'));
        if ($request->hasFile('banner_image')) $data['banner_image'] = $this->uploadImage($request->file('banner_image'));
        if ($request->hasFile('about_image'))  $data['about_image']  = $this->uploadImage($request->file('about_image'));

        AboutForCompany::create($data);

        return redirect()->route('admin.aboutcompany.index')
            ->with('success', 'Company information সফলভাবে সংরক্ষণ করা হয়েছে।');
    }

    // ─────────────────────────────────────────────────────────────────
    // SHOW
    // ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $about = AboutForCompany::findOrFail($id);
        return view('admin.aboutcompany.show', compact('about'));
    }

    // ─────────────────────────────────────────────────────────────────
    // EDIT
    // ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $about = AboutForCompany::findOrFail($id);
        return view('admin.aboutcompany.edit', compact('about'));
    }

    // ─────────────────────────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $about = AboutForCompany::findOrFail($id);

        $request->validate([
            'company_name'      => 'required|string|max:255',
            'tagline'           => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'about_description' => 'nullable|string',
            'mission'           => 'nullable|string',
            'vision'            => 'nullable|string',
            'values'            => 'nullable|string',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'about_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'founded_year'      => 'nullable|string|max:10',
            'total_employees'   => 'nullable|string|max:50',
            'total_clients'     => 'nullable|string|max:50',
            'total_projects'    => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:30',
            'address'           => 'nullable|string|max:500',
            'website'           => 'nullable|url|max:255',
            'facebook'          => 'nullable|url|max:255',
            'instagram'         => 'nullable|url|max:255',
            'twitter'           => 'nullable|url|max:255',
            'youtube'           => 'nullable|url|max:255',
            'linkedin'          => 'nullable|url|max:255',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|string|max:500',
        ]);

        $data = $request->except(['logo', 'banner_image', 'about_image', '_token', '_method']);
        $data['is_active'] = $request->boolean('is_active');

        // ── Image update: নতুন আসলে পুরানো delete করে নতুন save ──
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadImage($request->file('logo'), $about->logo);
        }
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->uploadImage($request->file('banner_image'), $about->banner_image);
        }
        if ($request->hasFile('about_image')) {
            $data['about_image'] = $this->uploadImage($request->file('about_image'), $about->about_image);
        }

        // ── Image delete (remove button) ──
        if ($request->has('delete_logo')) {
            $this->deleteImage($about->logo);
            $data['logo'] = null;
        }
        if ($request->has('delete_banner')) {
            $this->deleteImage($about->banner_image);
            $data['banner_image'] = null;
        }
        if ($request->has('delete_about_image')) {
            $this->deleteImage($about->about_image);
            $data['about_image'] = null;
        }

        $about->update($data);

        return redirect()->route('admin.aboutcompany.index')
            ->with('success', 'Company information সফলভাবে আপডেট করা হয়েছে।');
    }

    // ─────────────────────────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $about = AboutForCompany::findOrFail($id);

        $this->deleteImage($about->logo);
        $this->deleteImage($about->banner_image);
        $this->deleteImage($about->about_image);

        $about->delete();

        return redirect()->route('admin.aboutcompany.index')
            ->with('success', 'Company information মুছে ফেলা হয়েছে।');
    }
}
