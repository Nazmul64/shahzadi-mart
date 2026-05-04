@extends('frontend.master')

@section('main-content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    :root {
        --primary-color: #3b82f6;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --card-bg: rgba(255, 255, 255, 0.9);
    }

    .blog-section {
        background-color: #f8fafc;
        background-image: radial-gradient(#cbd5e1 0.5px, transparent 0.5px);
        background-size: 24px 24px;
    }

    .hero-gradient {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        padding: 100px 0;
        margin-bottom: -50px;
    }

    .blog-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 20px 20px 0 0;
    }

    .blog-image {
        transition: transform 0.6s ease;
        object-fit: cover;
        width: 100%;
        height: 250px;
    }

    .blog-card:hover .blog-image {
        transform: scale(1.1);
    }

    .category-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary-color);
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .sidebar-widget {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        margin-bottom: 30px;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 15px;
        border-radius: 12px;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s;
        margin-bottom: 5px;
    }

    .category-link:hover, .category-link.active {
        background: var(--primary-color);
        color: #fff !important;
    }

    .search-input {
        border: 2px solid #f1f5f9;
        padding: 12px 20px;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: none;
    }

    .pagination-custom .page-link {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px !important;
        margin: 0 5px;
        border: none;
        background: #fff;
        color: var(--text-dark);
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .pagination-custom .page-item.active .page-link {
        background: var(--primary-color);
        color: #fff;
    }
</style>

<div class="blog-section pb-5">
    <!-- Hero Section -->
    <div class="hero-gradient text-center">
        <div class="container animate__animated animate__fadeIn">
            <h1 class="text-white display-4 fw-bold mb-3">Our Digital Stories</h1>
            <p class="text-white-50 lead mx-auto" style="max-width: 600px;">Explore the latest insights, trends, and tutorials from our expert team.</p>
        </div>
    </div>

    <div class="container mt-n5" style="position: relative; z-index: 10;">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Search Widget -->
                    <div class="sidebar-widget">
                        <h6 class="fw-bold mb-3">Search Blog</h6>
                        <form action="{{ route('blog.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input" placeholder="Keywords..." value="{{ request('search') }}">
                                <button class="btn btn-primary rounded-end-3 px-3" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Category Widget -->
                    <div class="sidebar-widget">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Categories</h6>
                        <div class="category-list">
                            <a href="{{ route('blog.index') }}" class="category-link {{ !request('category') ? 'active' : '' }}">
                                <span>All Categories</span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            @if(isset($categories))
                                @foreach($categories as $cat)
                                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                                       class="category-link {{ request('category') == $cat->slug ? 'active' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget bg-primary text-white text-center">
                        <i class="bi bi-envelope-paper display-4 mb-3"></i>
                        <h5 class="fw-bold mb-2">Join Newsletter</h5>
                        <p class="small opacity-75 mb-4">Get latest updates directly to your inbox.</p>
                        <div class="input-group">
                            <input type="email" class="form-control border-0" placeholder="Your Email">
                            <button class="btn btn-dark btn-sm">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Area -->
            <div class="col-lg-9">
                <div class="row g-4">
                    @if(isset($posts) && count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="col-md-6 animate__animated animate__fadeInUp">
                                <article class="blog-card border-0 h-100">
                                    <div class="image-wrapper">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            @if($post->image)
                                                <img src="{{ asset($post->image) }}" class="blog-image" alt="{{ $post->title }}">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                                    <i class="bi bi-journal-text display-1 text-muted opacity-25"></i>
                                                </div>
                                            @endif
                                            <span class="category-badge">
                                                {{ $post->category->name ?? 'General' }}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3 text-muted small">
                                            <i class="bi bi-clock me-2"></i> {{ $post->created_at->format('M d, Y') }}
                                            <span class="mx-2">•</span>
                                            <i class="bi bi-person me-1"></i> Admin
                                        </div>
                                        <h2 class="h5 fw-bold mb-3">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary">
                                                {{ Str::limit($post->title, 70) }}
                                            </a>
                                        </h2>
                                        <p class="text-muted small mb-4">
                                            {{ Str::limit(strip_tags($post->description), 120) }}
                                        </p>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                                            Read More <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="sidebar-widget text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/fogg-search-no-results.png" alt="No Results" style="width: 200px;" class="mb-4">
                                <h4 class="fw-bold">No Stories Found</h4>
                                <p class="text-muted">We couldn't find any posts matching your criteria.</p>
                                <a href="{{ route('blog.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">View All Posts</a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if(isset($posts) && method_exists($posts, 'links'))
                    <div class="mt-5 d-flex justify-content-center pagination-custom">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
