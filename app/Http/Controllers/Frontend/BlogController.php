<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query()
            ->select('id', 'blog_category_id', 'title', 'slug', 'image', 'description', 'status', 'created_at')
            ->with(['category:id,name,slug'])
            ->where('status', true);

        if ($request->has('category')) {
            $category = BlogCategory::select('id', 'slug')->where('slug', $request->category)->firstOrFail();
            $query->where('blog_category_id', $category->id);
        }

        $posts = $query->latest()->paginate(12);
        $categories = BlogCategory::select('id', 'name', 'slug')->where('status', true)->get();

        return view('frontend.pages.blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['category:id,name,slug'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $recent_posts = BlogPost::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('status', true)
            ->where('id', '!=', $post->id)
            ->latest()
            ->limit(5)
            ->get();

        $categories = BlogCategory::select('id', 'name', 'slug')
            ->where('status', true)
            ->withCount(['posts' => function($q) { $q->where('status', true); }])
            ->get();

        return view('frontend.pages.blog.show', compact('post', 'recent_posts', 'categories'));
    }
}
