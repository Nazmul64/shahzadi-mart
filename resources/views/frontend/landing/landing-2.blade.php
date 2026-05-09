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

<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

@include('frontend.landing.partials.head_scripts')


<style>
    :root {
        --primary: {{ $landing->btn_color ?? '#2d6a4f' }};
        --secondary: #d8f3dc;
        --bg: {{ $landing->bg_color ?? '#f8fdf9' }};
        --text: {{ $landing->text_color ?? '#1b4332' }};
        --white: #ffffff;
    }

    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    html, body {
        font-family: 'Hind Siliguri', sans-serif;
        background: var(--bg);
        color: var(--text);
        line-height: 1.6;
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

    .default-header {
        background: var(--white);
        padding: 15px 0;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: sticky;
        top: 0; z-index: 100;
    }
    .default-header .logo { height: 40px; }

    .hero-sec { padding: 40px 0; text-align: center; }
    .hero-sec h1 {
        font-family: 'Quicksand', sans-serif;
        font-size: clamp(26px, 6vw, 38px);
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .media-box {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.3);
        margin-bottom: 40px;
        background: #fff;
        padding: 12px;
        border: 1px solid #eee;
    }
    .media-box img, .media-box video { width: 100%; border-radius: 20px; display: block; }
    .media-box iframe { width: 100%; aspect-ratio: 16/9; border: none; border-radius: 20px; box-shadow: inset 0 0 20px rgba(0,0,0,0.1); }

    .organic-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--secondary);
        color: var(--primary);
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .buy-btn {
        display: block;
        width: 100%;
        max-width: 350px;
        margin: 20px auto;
        background: var(--primary);
        color: #fff;
        text-decoration: none;
        padding: 15px 25px;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        box-shadow: 0 10px 25px rgba(45, 106, 79, 0.3);
        transition: 0.3s;
    }
    .buy-btn:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 40px rgba(45, 106, 79, 0.4); color: #fff; }

    .info-card {
        background: var(--white);
        border-radius: 40px 10px 40px 10px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border-top: 5px solid var(--primary);
    }
    .info-card h2 { color: var(--primary); margin-bottom: 20px; font-family: 'Quicksand', sans-serif; }

    .order-form-box {
        background: #ffffff;
        border-radius: 30px;
        padding: 40px;
        margin: 50px 0;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        border: 1px solid var(--secondary);
    }
    .price-tag {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 30px;
    }
    .old-p { font-size: 20px; text-decoration: line-through; color: #999; }
    .new-p { font-size: 42px; font-weight: 800; color: var(--primary); font-family: 'Quicksand', sans-serif; }

    .input-item { margin-bottom: 20px; }
    .input-item label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 15px; }
    .input-item input, .input-item select {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        border: 2px solid #edf2f4;
        font-family: inherit;
        font-size: 16px;
        transition: 0.3s;
    }
    .input-item input:focus, .input-item select:focus { border-color: var(--primary); outline: none; background: #f8fdf9; }

    .confirm-btn {
        width: 100%;
        background: var(--primary);
        color: #fff;
        padding: 20px;
        border-radius: 12px;
        border: none;
        font-size: 22px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(45, 106, 79, 0.2);
    }

    .default-footer { text-align: center; padding: 40px 0; opacity: 0.5; font-size: 14px; }

    @media (max-width: 768px) {
        .container { padding: 0 10px; width: 100%; overflow: hidden; }
        .hero-sec h1 { font-size: 26px !important; }
        h1, h2 { font-size: 1.8rem !important; }
        .order-form-box { padding: 15px !important; border-radius: 15px; margin: 20px 0; width: 100%; overflow: hidden; }
        .info-card { padding: 20px !important; }
        img { max-width: 100%; height: auto; }
        .order-grid-container { gap: 15px !important; width: 100%; }
        .order-grid-container > div { padding: 15px !important; min-width: 100% !important; }
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
<header class="default-header" data-aos="fade-down">
    <div class="container">
        @if(isset($websetting?->logo))
            <img src="{{ asset('uploads/generalsetting/' . $websetting->logo) }}" class="logo" alt="">
        @else
            <h2 style="color: var(--primary);">{{ $websetting?->site_name ?? 'Landing Page' }}</h2>
        @endif
    </div>
</header>
@endif

{{-- 2. Banner/Slider (Always after Header) --}}
@foreach($landing->blocks->whereIn('type', ['banner', 'banner_slider']) as $block)
    @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
@endforeach


<!-- SVG Wave -->
<svg style="width:100%; height:80px; display:block;" viewBox="0 0 1440 120" preserveAspectRatio="none">
    <path fill="var(--white)" d="M0,60L80,53.3C160,47,320,33,480,43.3C640,53,800,87,960,86.7C1120,87,1280,53,1360,36.7L1440,20L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
</svg>

<div class="container">
    <div class="hero-sec" data-aos="zoom-in" data-aos-duration="1000">
        <div class="organic-badge"><i class="bi bi-patch-check-fill"></i> ১০০% পিউর এবং প্রাকৃতিক</div>
        <h1>{{ $landing->title }}</h1>
        
        <div class="media-box">
            @if($landing->video_url)
                @php
                    $vurl = $landing->video_url;
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $vurl, $m)) {
                        $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1';
                    } else {
                        $embedUrl = $vurl;
                    }
                @endphp
                <iframe src="{{ $embedUrl }}" allowfullscreen loading="lazy"></iframe>
            @elseif($landing->feature_image)
                <img src="{{ asset('uploads/landing/' . $landing->feature_image) }}" alt="">
            @endif
        </div>

        <a href="#order-now" class="buy-btn" data-aos="flip-up" data-aos-delay="200">সরাসরি অর্ডার করুন</a>
    </div>

    @if($landing->short_description)
    <div class="info-card" data-aos="fade-up">
        {!! $landing->short_description !!}
    </div>
    @endif

    @if($landing->description)
    <div class="info-card" data-aos="fade-up" data-aos-delay="100">
        {!! $landing->description !!}
    </div>
    @endif

    {{-- Dynamic Blocks (Excluding Header/Footer/Banner) --}}
    @if($landing->blocks && $landing->blocks->count() > 0)
        <div class="dynamic-blocks-wrapper" style="position: relative; z-index: 1;">
            @foreach($landing->blocks->whereNotIn('type', ['header_classic', 'footer_classic', 'banner', 'banner_slider']) as $block)
                @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
            @endforeach
        </div>
    @endif



    <!-- SVG Wave -->
    <svg style="width:100%; height:80px; display:block; transform: scaleY(-1);" viewBox="0 0 1440 120" preserveAspectRatio="none">
        <path fill="var(--white)" d="M0,60L80,53.3C160,47,320,33,480,43.3C640,53,800,87,960,86.7C1120,87,1280,53,1360,36.7L1440,20L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
    </svg>

    {{-- Order Section --}}
    <div id="order" style="padding: 80px 0; background: #fff;" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title" style="text-align: center; margin-bottom: 50px; font-weight: 800;">অর্ডার নিশ্চিত করতে ফর্মটি পূরণ করুন</h2>
            @include('frontend.landing.partials.order_form')
        </div>
    </div>

    {{-- Footer Bottom --}}
    @foreach($landing->blocks->where('type', 'footer_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

    <div class="default-footer">
        &copy; {{ date('Y') }} {{ $websetting?->site_name ?? 'Shahzadi Mart' }}. All Rights Reserved.
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    $(document).ready(function() {
        AOS.init({ duration: 800, once: true });
        
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
