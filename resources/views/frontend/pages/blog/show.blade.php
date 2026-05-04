@extends('frontend.master')

@section('main-content')
<style>
    :root {
        --primary-color: #3b82f6;
        --secondary-color: #1e293b;
        --accent-color: #6366f1;
        --bg-light: #f8fafc;
    }

    .progress-container {
        position: fixed;
        top: 0;
        z-index: 9999;
        width: 100%;
        height: 4px;
        background: #eee;
    }

    .progress-bar {
        height: 4px;
        background: var(--primary-color);
        width: 0%;
    }

    .blog-show-header {
        background: linear-gradient(rgba(30, 41, 59, 0.8), rgba(30, 41, 59, 0.8)), url('{{ $post->image ? asset($post->image) : "" }}');
        background-size: cover;
        background-position: center;
        padding: 120px 0 80px 0;
        color: #fff;
        margin-bottom: 60px;
    }

    .blog-content-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        margin-top: -120px;
        position: relative;
        z-index: 20;
    }

    .content-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #334155;
    }

    .content-body h2, .content-body h3 {
        color: #0f172a;
        font-weight: 800;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .content-body img {
        max-width: 100%;
        height: auto;
        border-radius: 20px;
        margin: 30px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #94a3b8;
    }

    .meta-item i {
        color: var(--primary-color);
    }

    .sidebar-widget {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        margin-bottom: 30px;
    }

    .recent-post-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .recent-post-item:hover {
        transform: translateX(5px);
    }

    .recent-thumb {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
    }

    .share-btn {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        text-decoration: none;
        transition: transform 0.3s;
    }

    .share-btn:hover {
        transform: translateY(-5px);
        color: #fff;
    }

    .facebook { background: #1877f2; }
    .twitter { background: #1da1f2; }
    .whatsapp { background: #25d366; }
</style>

<div class="progress-container">
    <div class="progress-bar" id="myBar"></div>
</div>

<div class="blog-show-header text-center">
    <div class="container">
        <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 animate__animated animate__fadeInDown">
            {{ $post->category->name ?? 'Article' }}
        </span>
        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInUp">{{ $post->title }}</h1>
        <div class="d-flex justify-content-center gap-4 animate__animated animate__fadeIn">
            <div class="meta-item text-white-50"><i class="bi bi-calendar3"></i> {{ $post->created_at->format('M d, Y') }}</div>
            <div class="meta-item text-white-50"><i class="bi bi-person"></i> Admin</div>
            <div class="meta-item text-white-50"><i class="bi bi-clock"></i> {{ ceil(str_word_count(strip_tags($post->description)) / 200) }} min read</div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="blog-content-card">
                <div class="content-body">
                    {!! $post->description !!}
                </div>

                <hr class="my-5 opacity-10">

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-dark me-2">Share this:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="share-btn whatsapp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <!-- Recent Posts Widget -->
                <div class="sidebar-widget">
                    <h5 class="fw-bold mb-4 border-start border-primary border-4 ps-3">Recent Stories</h5>
                    @if(isset($recent_posts))
                        @foreach($recent_posts as $recent)
                            <a href="{{ route('blog.show', $recent->slug) }}" class="recent-post-item">
                                @if($recent->image)
                                    <img src="{{ asset($recent->image) }}" class="recent-thumb">
                                @else
                                    <div class="recent-thumb bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="text-dark fw-bold mb-1" style="font-size: 0.95rem;">{{ Str::limit($recent->title, 45) }}</h6>
                                    <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

                <!-- Ad Widget -->
                <div class="sidebar-widget bg-dark text-white p-4">
                    <h5 class="fw-bold mb-3">Professional Funnels</h5>
                    <p class="small opacity-75 mb-4">Create high-converting landing pages in minutes with our builder.</p>
                    <a href="{{ route('admin.landing-pages.index') }}" class="btn btn-primary w-100 rounded-pill">Try it now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onscroll = function() {myFunction()};
    function myFunction() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("myBar").style.width = scrolled + "%";
    }
</script>
@endsection
