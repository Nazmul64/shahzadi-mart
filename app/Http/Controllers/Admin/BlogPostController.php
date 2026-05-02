<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    private function getViewPrefix()
    {
        if (request()->routeIs('manager.*')) return 'manager.blog_post';
        if (request()->routeIs('emplee.*')) return 'emplee.blog_post';
        return 'admin.blog_post';
    }

    private function getRoutePrefix()
    {
        if (request()->routeIs('manager.*')) return 'manager.blog-posts';
        if (request()->routeIs('emplee.*')) return 'emplee.blog-posts';
        return 'admin.blog-posts';
    }

    public function index()
    {
        $posts = BlogPost::with('category')->latest()->get();
        return view($this->getViewPrefix() . '.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view($this->getViewPrefix() . '.create_edit', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/blog'), $imageName);
            $data['image'] = 'uploads/blog/' . $imageName;
        }

        BlogPost::create($data);

        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Blog Post Created Successfully');
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::where('status', true)->get();
        return view($this->getViewPrefix() . '.create_edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/blog'), $imageName);
            $data['image'] = 'uploads/blog/' . $imageName;
        }

        $post->update($data);

        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Blog Post Updated Successfully');
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }
        $post->delete();
        return redirect()->route($this->getRoutePrefix() . '.index')->with('success', 'Blog Post Deleted Successfully');
    }
}
