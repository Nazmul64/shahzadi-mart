{{-- resources/views/frontend/offers.blade.php --}}
@extends('frontend.master')

@section('main-content')
<div class="blog-container py-5 px-3">
    {{-- Schema.org BlogPosting for Google Ranking --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ $post->title }}",
      "image": "{{ $post->image ? asset($post->image) : asset('default/logo.png') }}",
      "author": {
        "@type": "Organization",
        "name": "Shahzadi Mart"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Shahzadi Mart",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('default/logo.png') }}"
        }
      },
      "datePublished": "{{ $post->created_at->toIso8601String() }}",
      "description": "{{ Str::limit(strip_tags($post->description), 160) }}"
    }
    </script>

    <div class="row justify-content-center">
        {{-- Main Post Content --}}
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-5">
                <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ route('frontend') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Blog</a></li>
                    <li class="breadcrumb-item active fw-bold text-primary">{{ $post->category->name ?? 'Article' }}</li>
                </ol>
            </nav>

            <article class="blog-post">
                <header class="mb-4">
                    <h1 class="fw-bold display-4 mb-4 text-dark lh-sm">{{ $post->title }}</h1>
                    
                    <div class="d-flex align-items-center mb-5 text-muted bg-light p-3 rounded-4">
                        <div class="d-flex align-items-center me-4">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            <span>{{ $post->created_at->format('F d, Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center me-4">
                            <i class="bi bi-tag me-2 text-primary"></i>
                            <span>{{ $post->category->name ?? 'General' }}</span>
                        </div>
                        <div class="ms-auto d-none d-md-block">
                            <span class="text-primary fw-bold"><i class="bi bi-clock-history me-1"></i> {{ ceil(str_word_count(strip_tags($post->description)) / 200) }} min read</span>
                        </div>
                    </div>
                </header>

                @if($post->image)
                    <figure class="mb-5 rounded-4 overflow-hidden shadow-lg border">
                        <img src="{{ asset($post->image) }}" 
                             class="img-fluid w-100" 
                             alt="{{ $post->title }}"
                             loading="eager" {{-- First image on page should be eager for LCP --}}
                             style="max-height: 500px; object-fit: cover;">
                    </figure>
                @endif

                <section class="blog-content font-lg lh-lg text-dark mb-5 pe-lg-4">
                    {!! $post->description !!}
                </section>

                {{-- Share Interaction --}}
                <footer class="mt-5">
                    <div class="card bg-primary text-white border-0 rounded-4 p-4 shadow-sm overflow-hidden position-relative">
                        <div class="position-absolute top-0 end-0 p-3 opacity-25">
                            <i class="bi bi-share display-1"></i>
                        </div>
                        <div class="row align-items-center position-relative">
                            <div class="col-md-7">
                                <h4 class="fw-bold mb-2">Did you enjoy this article?</h4>
                                <p class="mb-0 opacity-75">Share it with your friends and help us grow!</p>
                            </div>
                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                <div class="d-flex gap-2 justify-content-md-end">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                                       target="_blank" class="btn btn-white text-primary fw-bold rounded-pill px-3">
                                        <i class="bi bi-facebook me-1"></i> Share
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" 
                                       target="_blank" class="btn btn-white text-info fw-bold rounded-pill px-3">
                                        <i class="bi bi-twitter-x me-1"></i> Post
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </article>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4 mt-5 mt-lg-0">
            <aside class="sticky-top" style="top: 100px;">
                {{-- Recent Posts --}}
                <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Recent Stories</h5>
                        @foreach($recent_posts as $recent)
                            <div class="d-flex align-items-center mb-4 gap-3 group">
                                <div style="width: 70px; height: 70px; flex-shrink: 0;" class="rounded-3 overflow-hidden shadow-sm">
                                    @if($recent->image)
                                        <img src="{{ asset($recent->image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold line-clamp-2" style="font-size: 0.95rem;">
                                        <a href="{{ route('blog.show', $recent->slug) }}" class="text-dark text-decoration-none hover-primary transition">{{ $recent->title }}</a>
                                    </h6>
                                    <small class="text-muted"><i class="bi bi-clock small me-1"></i>{{ $recent->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Category List --}}
                <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Explore Categories</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categories as $cat)
                                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                                   class="badge bg-light text-dark text-decoration-none p-3 rounded-pill hover-bg-primary transition border">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
    .font-lg { font-size: 1.15rem; }
    .lh-lg { line-height: 1.8; }
    .btn-white { background: #fff; color: #000; }
    .btn-white:hover { background: #f8fafc; transform: translateY(-2px); }
    .transition { transition: all 0.3s ease; }
    .hover-primary:hover { color: var(--bs-primary) !important; }
    .hover-bg-primary:hover { background: var(--bs-primary) !important; color: #fff !important; border-color: var(--bs-primary) !important; }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .blog-content { color: #1e293b; }
    .blog-content p { margin-bottom: 1.5rem; }
    .blog-content h2, .blog-content h3 { font-weight: 700; margin-top: 2.5rem; margin-bottom: 1.25rem; color: #0f172a; }
    .blog-content img { max-width: 100%; height: auto; border-radius: 1.25rem; margin: 2.5rem 0; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .blog-content blockquote {
        border-left: 6px solid var(--bs-primary);
        padding: 1.5rem 2.5rem;
        background: #f1f5f9;
        border-radius: 0 1.25rem 1.25rem 0;
        margin: 2.5rem 0;
        font-style: italic;
        font-size: 1.25rem;
        color: #334155;
    }
    .breadcrumb-item + .breadcrumb-item::before { content: "\F285"; font-family: "bootstrap-icons"; font-size: 10px; color: #cbd5e1; }
</style>
@endsection
