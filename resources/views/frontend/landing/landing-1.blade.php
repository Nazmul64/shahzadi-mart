<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $landing->title }} | {{ $websetting?->site_name ?? 'Landing Page' }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(isset($favicon) && $favicon->favicon_logo)
    <link rel="icon" type="image/png" href="{{ asset($favicon->favicon_logo) }}">
@endif

@include('frontend.landing.partials.head_scripts')

{{-- Dynamic Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    :root {
        --primary-color: {{ $landing->btn_color ?? '#e91e8c' }};
        --bg-color: {{ $landing->bg_color ?? '#0d0d1a' }};
        --text-color: {{ $landing->text_color ?? '#ffffff' }};
        --card-bg: rgba(255, 255, 255, 0.05);
        --border-color: rgba(255, 255, 255, 0.1);
    }

    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    html, body {
        font-family: 'Hind Siliguri', sans-serif;
        background: var(--bg-color);
        color: var(--text-color);
        line-height: 1.7;
        overflow-x: hidden;
        width: 100%;
    }


    @if($landing->is_full_width)
    .container { width: 100%; max-width: 100%; margin: 0 auto; padding: 0 15px; }
    @else
    .container { max-width: 1400px; width: 95%; margin: 0 auto; padding: 0 15px; }
    @endif

    /* Global Image Consistency */
    .block-text-image img, 
    .product-card img,
    .elegant-card-wrap img,
    .pg-product-card img {
        width: 100%;
        aspect-ratio: 1/1 !important;
        object-fit: cover !important;
        border-radius: 10px;
    }

    /* Top Bar */
    .top-bar {
        background: var(--primary-color);
        color: #fff;
        text-align: center;
        padding: 10px;
        font-weight: 600;
        font-size: 14px;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    /* Hero */
    .hero-title {
        text-align: center;
        font-family: 'Sora', sans-serif;
        font-size: clamp(22px, 5vw, 36px);
        font-weight: 800;
        margin: 20px 0;
        line-height: 1.3;
        padding: 0 10px;
        word-wrap: break-word;
    }

    .hero-media {
        border-radius: 20px;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        margin-bottom: 30px;
        background: #000;
        position: relative;
    }

    .hero-media img, .hero-media video { width: 100%; display: block; }
    .hero-media iframe { width: 100%; aspect-ratio: 16/9; border: none; }

    /* CTA */
    .cta-btn {
        display: block;
        width: 100%;
        max-width: 350px;
        margin: 20px auto;
        background: var(--primary-color);
        color: #fff;
        text-decoration: none;
        padding: 15px 30px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        animation: pulse 2s infinite;
        text-align: center;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Description */
    .content-box {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        padding: 30px;
        border-radius: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
    }
    .content-box:hover {
        transform: translateY(-5px);
    }
    .content-box h3 { margin-bottom: 15px; font-family: 'Sora', sans-serif; }

    /* Order Form */
    .order-section {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 40px;
        margin-top: 50px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; letter-spacing: 0.5px; }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-family: inherit;
    }
    .form-control:focus { outline: none; border-color: var(--primary-color); }

    .price-card {
        text-align: center;
        margin-bottom: 25px;
    }
    .price-old { text-decoration: line-through; opacity: 0.5; font-size: 18px; }
    .price-new { font-size: 36px; font-weight: 800; color: var(--primary-color); font-family: 'Sora', sans-serif; }

    .submit-btn {
        width: 100%;
        background: var(--primary-color);
        color: #fff;
        border: none;
        padding: 18px;
        border-radius: 15px;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .submit-btn:hover { opacity: 0.9; transform: translateY(-2px); }

    /* Review */
    .review-box {
        text-align: center;
        margin: 50px 0;
    }
    .review-img { max-width: 100%; border-radius: 15px; margin-bottom: 15px; border: 1px solid var(--border-color); }

    @media (max-width: 768px) {
        .container { padding: 0 10px; }
        .hero-title { font-size: 28px !important; }
        h1, h2 { font-size: 1.8rem !important; }
        p { font-size: 1rem !important; }
        .order-section { padding: 20px !important; }
        .content-box { padding: 15px !important; }
        img { max-width: 100%; height: auto; }
    }
</style>

</head>
<body>
    @include('frontend.landing.partials.body_scripts')
    {{-- 1. Header Top (Dynamic or Default) --}}
    @foreach($landing->blocks->where('type', 'header_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

    @if(!$landing->blocks->where('type', 'header_classic')->count())
    <div class="top-bar" data-aos="fade-down">
        🔥 সারাদেশে ক্যাশ অন ডেলিভারি সুবিধা! পণ্য হাতে পেয়ে টাকা দিন।
    </div>
    @endif

    {{-- 2. Banner/Slider (Always after Header) --}}
    @foreach($landing->blocks->whereIn('type', ['banner', 'banner_slider']) as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach


<div class="container">
    <h1 class="hero-title" data-aos="zoom-in" data-aos-duration="1000">{{ $landing->title }}</h1>

    <div class="hero-media" data-aos="fade-up" data-aos-duration="1200">
        @if($landing->video_url)
            @php
                $vurl = $landing->video_url;
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $vurl, $m)) {
                    $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0&rel=0&modestbranding=1';
                } elseif (preg_match('/vimeo\.com\/(\d+)/', $vurl, $m)) {
                    $embedUrl = 'https://player.vimeo.com/video/' . $m[1];
                } else {
                    $embedUrl = $vurl;
                }
            @endphp
            <iframe src="{{ $embedUrl }}" allowfullscreen loading="lazy"></iframe>
        @elseif($landing->feature_image)
            <img src="{{ asset('uploads/landing/' . $landing->feature_image) }}" alt="">
        @endif
    </div>

    <a href="#order" class="cta-btn" data-aos="zoom-in" data-aos-delay="200">অর্ডার করতে এখানে ক্লিক করুন</a>

    @if($landing->short_description)
    <div class="content-box" data-aos="fade-up">
        {!! $landing->short_description !!}
    </div>
    @endif

    @if($landing->description)
    <div class="content-box" data-aos="fade-up" data-aos-delay="100">
        {!! $landing->description !!}
    </div>
    @endif

    @if($landing->review_image || $landing->review_text)
    <div class="review-box">
        <h2 style="margin-bottom: 20px;">কাস্টমার রিভিউ</h2>
        @if($landing->review_image)
            <img src="{{ asset('uploads/landing/' . $landing->review_image) }}" class="review-img" alt="">
        @endif
        @if($landing->review_text)
            <p style="font-style: italic;">"{{ $landing->review_text }}"</p>
        @endif
    </div>
    @endif

    {{-- Dynamic Content Blocks (excluding Header/Footer/Banner) --}}
    @if($landing->blocks && $landing->blocks->count() > 0)
        <div class="dynamic-blocks-wrapper" style="position: relative; z-index: 1;">
            @foreach($landing->blocks->whereNotIn('type', ['header_classic', 'footer_classic', 'banner', 'banner_slider']) as $block)
                @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
            @endforeach
        </div>
    @endif

    {{-- Order Section --}}
    <div class="order-section container" id="order" style="margin-top: 80px; padding-bottom: 80px;" data-aos="fade-up">
        <h2 class="section-title single-line-mobile" style="text-align: center; margin-bottom: 40px; font-weight: 800; color: #fff;">অর্ডার নিশ্চিত করতে নিচের ফর্মটি পূরণ করুন</h2>
        @include('frontend.landing.partials.order_form')
    </div>

    <div style="text-align: center; margin-top: 50px; padding: 20px; opacity: 0.6; font-size: 13px;">
        &copy; {{ date('Y') }} {{ $websetting?->site_name ?? 'Shahzadi Mart' }}. All Rights Reserved.
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- AOS Animation Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    $(document).ready(function() {
        AOS.init({ duration: 800, once: true, offset: 50 });
        
        // Global addToCart compatibility
        window.addToCart = function(productData) {
            if (typeof window.addDynamicProductToCheckout === 'function') {
                window.addDynamicProductToCheckout(productData);
            } else {
                const productOption = $(`.product-option[data-id="${productData.id}"], .product-option-pro[data-id="${productData.id}"]`);
                if (productOption.length) {
                    const checkbox = productOption.find('input[type="checkbox"]');
                    if (checkbox.length && !checkbox.prop('checked')) {
                        productOption.click();
                        if (typeof window.showProToast === 'function') {
                            window.showProToast('পণ্যটি সফলভাবে যুক্ত করা হয়েছে!');
                        }
                    }
                }
            }
            const orderSection = document.getElementById('order') || document.getElementById('checkout') || document.querySelector('.order-form') || document.querySelector('.checkout-container');
            if (orderSection) {
                orderSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>


</body>
</html>
