<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $landing->title }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(isset($favicon) && $favicon->favicon_logo)
    <link rel="icon" type="image/png" href="{{ asset($favicon->favicon_logo) }}">
@endif

<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

@include('frontend.landing.partials.head_scripts')

    <style>
    :root {
        --primary: {{ $landing->btn_color ?? '#ff4d4d' }};
        --bg: {{ $landing->bg_color ?? '#ffffff' }};
        --text: {{ $landing->text_color ?? '#222222' }};
    }

    html, body {
        font-family: 'Hind Siliguri', sans-serif;
        background: var(--bg);
        color: var(--text);
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
    }
    @if($landing->is_full_width)
    .wrap { width: 100%; max-width: 100%; margin: 0 auto; padding-bottom: 80px; position: relative; padding-left: 15px; padding-right: 15px; }
    @else
    .wrap { max-width: 1200px; width: 95%; margin: 0 auto; padding-bottom: 80px; position: relative; padding-left: 15px; padding-right: 15px; border: 1px solid #eee; background: #fff; box-shadow: 0 0 50px rgba(0,0,0,0.05); min-height: 100vh; }
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

    .header-notice { background: var(--primary); color: #fff; text-align: center; padding: 15px; font-weight: 700; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; }
    
    .hero-box { padding: 40px 20px; text-align: center; border-bottom: 1px solid #eee; background: #fff; }
    .hero-box h1 { font-size: 32px; font-weight: 800; line-height: 1.3; margin-bottom: 30px; color: #111; }
    
    .main-media { 
        width: 100%; 
        border-radius: 20px; 
        box-shadow: 0 40px 100px rgba(0,0,0,0.2); 
        border: 8px solid #fff; 
        overflow: hidden;
        background: #000;
        margin-bottom: 30px;
    }
    .main-media img, .main-media video { width: 100%; display: block; }
    .main-media iframe { width: 100%; aspect-ratio: 16/9; border: none; display: block; }
    
    .price-box { background: #111; color: #fff; padding: 30px; margin: 0; text-align: center; display: flex; align-items: center; justify-content: center; gap: 20px; }
    .price-box h3 { margin: 0; font-size: 20px; opacity: 0.8; font-weight: 400; }
    .price-box .old { text-decoration: line-through; color: #888; font-size: 18px; margin-right: 10px; }
    .price-box .new { color: #fff; font-size: 40px; font-weight: 800; }

    .feature-list { list-style: none; padding: 30px; margin: 0; background: #fafafa; border-bottom: 1px solid #eee; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .feature-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 16px; font-weight: 600; }
    .feature-list li i { color: var(--primary); font-size: 20px; }

    .order-form { background: #fff; padding: 50px 30px; margin: 0; }
    .order-form h2 { text-align: center; margin-top: 0; color: #111; font-size: 28px; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 1px; }

    .input-group { margin-bottom: 20px; }
    .input-group label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; text-transform: uppercase; color: #555; }
    .input-group input, .input-group select { width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 0; box-sizing: border-box; font-family: inherit; font-size: 16px; transition: 0.3s; }
    .input-group input:focus, .input-group select:focus { border-color: var(--primary); outline: none; }

    .btn-submit { width: 100%; background: var(--primary); color: #fff; border: none; padding: 20px; border-radius: 0; font-size: 20px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .btn-submit:hover { background: #111; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    .sticky-footer { position: fixed; bottom: 0; left: 0; right: 0; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 15px; border-top: 1px solid #eee; display: flex; justify-content: center; z-index: 100; box-shadow: 0 -5px 20px rgba(0,0,0,0.05); }
    .sticky-btn { background: #111; color: #fff; text-decoration: none; padding: 16px 40px; font-weight: 800; font-size: 18px; width: 100%; max-width: 600px; text-align: center; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .sticky-btn:hover { background: var(--primary); }

    .review-wrap { padding: 50px 30px; text-align: center; background: #fff; border-top: 1px solid #eee; }
    .review-wrap img { max-width: 100%; border-radius: 0; border: 1px solid #eee; padding: 10px; }
    
    @media (max-width: 768px) {
        .wrap { padding-left: 10px; padding-right: 10px; }
        .feature-list { grid-template-columns: 1fr; padding: 20px; }
        .price-box { flex-direction: column; gap: 10px; padding: 20px; }
        .hero-box h1 { font-size: 24px !important; }
        .order-form { padding: 30px 15px !important; }
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
    <div class="header-notice" data-aos="fade-down">🔥 অফারটি শেষ হওয়ার আগে অর্ডার করুন!</div>
    @endif

    {{-- 2. Banner/Slider (Always after Header) --}}
    @foreach($landing->blocks->whereIn('type', ['banner', 'banner_slider']) as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach


<div class="wrap">
    @php
        $p = $landing->product;
        $price = $p ? ($p->discount_price ?? $p->current_price) : 0;
        $old = ($p && $p->discount_price) ? $p->current_price : null;
    @endphp

    {{-- Dynamic Blocks (Excluding Header/Footer/Banner/Slider which are handled outside) --}}
    @if($landing->blocks && $landing->blocks->count() > 0)
        <div class="dynamic-blocks-wrapper" style="position: relative; z-index: 1;">
            @foreach($landing->blocks->whereNotIn('type', ['header_classic', 'footer_classic', 'banner', 'banner_slider']) as $block)
                @if(view()->exists('frontend.landing.blocks.' . $block->type))
                    <div style="padding: 0 0px;">
                        @include('frontend.landing.blocks.' . $block->type, ['block' => $block])
                    </div>
                @endif
            @endforeach
        </div>
    @else
        {{-- Fallback if no blocks added yet --}}
        <div class="hero-box">
            <h1 data-aos="fade-up">{{ $landing->title }}</h1>
            <div class="main-media" data-aos="zoom-in" data-aos-delay="200">
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
                    <img src="{{ asset('uploads/landing/'.$landing->feature_image) }}" alt="">
                @endif
            </div>
        </div>

        <div class="price-box" data-aos="fade-up">
            <h3>আজকের বিশেষ দাম:</h3>
            <div>
                @if($old)<span class="old">{{ number_format($old) }}৳</span>@endif
                <span class="new">{{ number_format($price) }}৳</span>
            </div>
        </div>

        @if($landing->short_description)
        <div style="padding: 30px; font-size: 18px; line-height: 1.8;" data-aos="fade-up">
            {!! $landing->short_description !!}
        </div>
        @endif

        <ul class="feature-list" data-aos="fade-up">
            <li><i class="bi bi-check2-square"></i> কোয়ালিটি নিশ্চিত করে ডেলিভারি</li>
            <li><i class="bi bi-check2-square"></i> সারা বাংলাদেশে হোম ডেলিভারি</li>
            <li><i class="bi bi-check2-square"></i> পণ্য চেক করে টাকা দেওয়ার সুযোগ</li>
            <li><i class="bi bi-check2-square"></i> দ্রুত কাস্টমার সাপোর্ট</li>
        </ul>
    @endif

    <div id="order" style="padding: 80px 0; background: #fff;" data-aos="fade-up">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 50px; font-weight: 800; font-size: 32px; color: var(--primary);">অর্ডার নিশ্চিত করতে ফর্মটি পূরণ করুন</h2>
            @include('frontend.landing.partials.order_form')
        </div>
    </div>

    @if($landing->review_image)
    <div class="review-wrap">
        <h3>কাস্টমার ফিডব্যাক</h3>
        <img src="{{ asset('uploads/landing/'.$landing->review_image) }}" alt="">
    </div>
    @endif
    {{-- Footer Bottom --}}
    @foreach($landing->blocks->where('type', 'footer_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach
</div>

<div class="sticky-footer">
    <a href="#order" class="sticky-btn">অর্ডার করতে এখানে ক্লিক করুন</a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
