<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaigncreate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CampaigncreateController extends Controller
{
    protected string $uploadPath      = 'uploads/campaigncreate';
    protected string $uploadVideoPath = 'uploads/campaigncreate/videos';

    /* ─── Helpers ─────────────────────────────────────────── */

    private function uploadImage($file, ?string $oldFile = null): string
    {
        $uploadDir = public_path($this->uploadPath);
        if (!File::exists($uploadDir)) File::makeDirectory($uploadDir, 0755, true);

        if ($oldFile && File::exists(public_path($oldFile))) File::delete(public_path($oldFile));

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        return $this->uploadPath . '/' . $filename;
    }

    private function uploadVideo($file, ?string $oldFile = null): string
    {
        $uploadDir = public_path($this->uploadVideoPath);
        if (!File::exists($uploadDir)) File::makeDirectory($uploadDir, 0755, true);

        if ($oldFile && File::exists(public_path($oldFile))) File::delete(public_path($oldFile));

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        return $this->uploadVideoPath . '/' . $filename;
    }

    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) File::delete(public_path($path));
    }

    /* ─── CRUD ────────────────────────────────────────────── */

    public function index()
    {
        $campaigns = Campaigncreate::with('product')->latest()->paginate(10);
        return view('admin.campaigncreate.index', compact('campaigns'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.campaigncreate.create', compact('products'));
    }

    public function store(Request $request)
    {
        $isVideo = $request->media_type === 'Video';

        $rules = [
            'title'             => 'required|string|max:255',
            'product_id'        => 'required|exists:products,id',
            'media_type'        => 'required|in:Image,Video',
            'review'            => 'required|string',
            'review_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
        ];

        if ($isVideo) {
            $rules['video']     = 'nullable|file|mimes:mp4,mov,avi,webm|max:51200';
            $rules['video_url'] = 'nullable|url';
        } else {
            $rules['image']       = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules['image_two']   = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules['image_three'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        $request->validate($rules);

        $data = $request->only(['title', 'product_id', 'media_type', 'review', 'short_description', 'description', 'video_url']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($isVideo) {
            if ($request->hasFile('video')) {
                $data['video'] = $this->uploadVideo($request->file('video'));
            }
        } else {
            foreach (['image', 'image_two', 'image_three'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field));
                }
            }
        }

        if ($request->hasFile('review_image')) {
            $data['review_image'] = $this->uploadImage($request->file('review_image'));
        }

        Campaigncreate::create($data);

        return redirect()->route('admin.campaigncreate.index')
            ->with('success', 'Landing page created successfully.');
    }

    public function show(string $id)
    {
        $campaign = Campaigncreate::with('product')->findOrFail($id);
        return view('admin.campaigncreate.show', compact('campaign'));
    }

    public function edit(string $id)
    {
        $campaign = Campaigncreate::findOrFail($id);
        $products  = Product::all();
        return view('admin.campaigncreate.edit', compact('campaign', 'products'));
    }

    public function update(Request $request, string $id)
    {
        $campaign = Campaigncreate::findOrFail($id);
        $isVideo  = $request->media_type === 'Video';

        $rules = [
            'title'             => 'required|string|max:255',
            'product_id'        => 'required|exists:products,id',
            'media_type'        => 'required|in:Image,Video',
            'review'            => 'required|string',
            'review_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
        ];

        if ($isVideo) {
            $rules['video']     = 'nullable|file|mimes:mp4,mov,avi,webm|max:51200';
            $rules['video_url'] = 'nullable|url';
        } else {
            $rules['image']       = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules['image_two']   = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            $rules['image_three'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        $request->validate($rules);

        $data = $request->only(['title', 'product_id', 'media_type', 'review', 'short_description', 'description', 'video_url']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($isVideo) {
            if ($request->hasFile('video')) {
                $data['video'] = $this->uploadVideo($request->file('video'), $campaign->video);
            }
            // clear image fields if switching to video
            if ($campaign->media_type !== 'Video') {
                foreach (['image', 'image_two', 'image_three'] as $f) $this->deleteFile($campaign->$f);
                $data['image'] = $data['image_two'] = $data['image_three'] = null;
            }
        } else {
            foreach (['image', 'image_two', 'image_three'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $campaign->$field);
                }
            }
            // clear video if switching to image
            if ($campaign->media_type !== 'Image') {
                $this->deleteFile($campaign->video);
                $data['video'] = $data['video_url'] = null;
            }
        }

        if ($request->hasFile('review_image')) {
            $data['review_image'] = $this->uploadImage($request->file('review_image'), $campaign->review_image);
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigncreate.index')
            ->with('success', 'Landing page updated successfully.');
    }

    public function destroy(string $id)
    {
        $campaign = Campaigncreate::findOrFail($id);

        foreach (['image', 'image_two', 'image_three', 'review_image', 'video'] as $field) {
            $this->deleteFile($campaign->$field);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigncreate.index')
            ->with('success', 'Landing page deleted successfully.');
    }
}
