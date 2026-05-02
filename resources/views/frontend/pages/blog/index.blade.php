@extends('frontend.master')

@section('main-content')
<div class="blog-container py-5 px-3">
    {{-- Schema.org for SEO --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Blog",
      "name": "Shahzadi Mart Blog",
      "description": "Latest trends, updates and stories from Shahzadi Mart."
    }
    </script>
    
    <style>
        .font-sm { font-size: 0.875rem; }
        .hover-up { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .hover-up:hover { transform: translateY(-8px); box-shadow: 0 1.5rem 3.5rem rgba(0,0,0,0.1) !important; }
        .blog-img-zoom { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .card:hover .blog-img-zoom { transform: scale(1.1); }
        .hover-bg-light:hover { background-color: #f1f5f9; color: var(--bs-primary) !important; }
        .hover-primary:hover { color: var(--bs-primary) !important; }
        .bg-primary-soft { background-color: rgba(59, 130, 246, 0.1); }
        .pagination { gap: 5px; }
        .page-link { border-radius: 8px !important; border: none; background: #f8fafc; color: #475569; font-weight: 600; }
        .page-item.active .page-link { background: var(--bs-primary); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    </style>

    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="fw-bold display-5 mb-2">Our Latest Stories</h1>
            <p class="text-muted lead">Stay updated with the latest trends, news, and insights.</p>
        </div>
    </div>

    <div class="row">
        {{-- Sidebar --}}
        <div class="col-lg-3 d-none d-lg-block">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 border-start border-primary border-4 ps-3">Categories</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <a href="{{ route('blog.index') }}" 
                                   class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ !request('category') ? 'bg-primary text-white shadow-sm' : 'text-dark hover-bg-light' }}">
                                    <span>All Posts</span>
                                    <i class="bi bi-chevron-right small"></i>
                                </a>
                            </li>
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $cat)
                                    <li class="mb-2">
                                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                                           class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ request('category') == $cat->slug ? 'bg-primary text-white shadow-sm' : 'text-dark hover-bg-light' }}">
                                            <span>{{ $cat->name }}</span>
                                            <i class="bi bi-chevron-right small"></i>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Posts Grid --}}
        <div class="col-lg-9">
            <div class="row g-4">
                @if(isset($posts) && count($posts) > 0)
                    @foreach($posts as $post)
                        <div class="col-md-6 col-xl-4">
                            <article class="card h-100 border-0 shadow-sm hover-up overflow-hidden rounded-4">
                                <a href="{{ route('blog.show', $post->slug) }}" class="overflow-hidden position-relative d-block">
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" 
                                             class="card-img-top blog-img-zoom" 
                                             alt="{{ $post->title }}" 
                                             loading="lazy"
                                             style="height: 220px; object-fit: cover; width: 100%;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                            <i class="bi bi-image text-muted display-4"></i>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-white text-primary shadow-sm px-3 py-2 rounded-pill font-sm fw-bold">
                                            {{ $post->category->name ?? 'News' }}
                                        </span>
                                    </div>
                                </a>
                                <div class="card-body p-4">
                                    <h2 class="h5 card-title fw-bold mb-3">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ Str::limit($post->title, 60) }}
                                        </a>
                                    </h2>
                                    <p class="card-text text-muted font-sm mb-0">
                                        {{ Str::limit(strip_tags($post->description), 110) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-0 p-4 pt-0">
                                    <hr class="my-3 opacity-10">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2">
                                                <i class="bi bi-calendar3 text-primary small"></i>
                                            </div>
                                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                                            Read <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                        </div>
                        <h4 class="text-muted fw-bold">No stories found here.</h4>
                        <p class="text-muted">We're working on bringing more content soon!</p>
                        <a href="{{ route('blog.index') }}" class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm">Explore All Posts</a>
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if(isset($posts) && method_exists($posts, 'links'))
                <div class="mt-5 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
