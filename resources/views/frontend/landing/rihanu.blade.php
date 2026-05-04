<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->title }} | {{ $websetting?->site_name ?? 'Shahzadi Mart' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if(isset($favicon) && $favicon->favicon_logo)
        <link rel="icon" type="image/png" href="{{ asset($favicon->favicon_logo) }}">
    @endif

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: {{ $landing->btn_color ?? '#5a9e04' }};
            --secondary-color: #4a7c0f;
            --bg-light: #f9fbf7;
            --text-dark: #2d3436;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background: {{ $landing->bg_color ?? '#ffffff' }};
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: var(--primary-color);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            color: #fff;
        }
        .header-content img { height: 50px; }
        .header-tagline { font-size: 1.2rem; font-weight: 700; }

        /* Hero Section */
        .hero {
            background: url('https://rihanu.com/wp-content/uploads/2024/09/oil-bg.jpg') center/cover no-repeat;
            padding: 60px 0;
            text-align: center;
            position: relative;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
        }
        .hero-content { position: relative; z-index: 1; }
        .hero-title {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .video-container {
            max-width: 800px;
            margin: 0 auto;
            border: 5px solid #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        .video-container iframe { width: 100%; aspect-ratio: 16/9; display: block; }

        /* Section Title */
        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 40px;
            line-height: 1.3;
        }

        /* Order Button */
        .order-btn {
            display: inline-block;
            background: var(--primary-color);
            color: #fff;
            padding: 15px 40px;
            border-radius: 5px;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(90, 158, 4, 0.4);
            border: none;
            cursor: pointer;
        }
        .order-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            color: #fff;
        }

        /* Banner */
        .info-banner {
            background: var(--primary-color);
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 40px 0;
        }

        /* Checkout Form */
        .checkout-container {
            background: #fff;
            border: 2px solid var(--primary-color);
            border-radius: 15px;
            padding: 40px;
            margin: 60px auto;
            max-width: 1000px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        .billing-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 1rem;
        }
        .form-control:focus { outline: none; border-color: var(--primary-color); }

        /* Multi-Product Selection */
        .product-selector { margin-bottom: 30px; }
        .product-option {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: var(--transition);
        }
        .product-option.active { border-color: var(--primary-color); background: #f9fbf7; }
        .product-option input { width: 20px; height: 20px; accent-color: var(--primary-color); }
        .product-option img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
        .product-info { flex: 1; }
        .product-info h4 { font-size: 1.1rem; font-weight: 700; }
        .product-qty {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .qty-btn-block { border: none; background: none; font-weight: 800; cursor: pointer; padding: 5px; }

        /* Order Summary */
        .order-summary {
            background: #fdfdfd;
            border: 1px solid #eee;
            padding: 25px;
            border-radius: 10px;
        }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500; }
        .summary-total {
            border-top: 2px solid var(--primary-color);
            padding-top: 15px;
            margin-top: 15px;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        /* Sticky Footer */
        .sticky-footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: var(--primary-color);
            padding: 10px 20px;
            display: none;
            justify-content: space-between;
            align-items: center;
            z-index: 2000;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        .sticky-footer-text { color: #fff; font-weight: 700; font-size: 1.1rem; }
        .sticky-footer .order-btn { padding: 10px 25px; font-size: 1.1rem; background: #fff; color: var(--primary-color); }

        @media (max-width: 768px) {
            .checkout-grid { grid-template-columns: 1fr; }
            .header-tagline { font-size: 0.9rem; }
            .hero-title { font-size: 1.5rem; }
            .sticky-footer { display: flex; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <div class="header-content">
                @if($websetting?->logo)
                    <img src="{{ asset($websetting->logo) }}" alt="Logo">
                @endif
                <div class="header-tagline">ঠান্ডা থেকে মুক্তি, ত্বকে আরাম</div>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="hero">
        <div class="container hero-content">
            <h1 class="hero-title">"প্রতি ঘণ্টায় ২-৩টি নিষ্পাপ প্রাণ ঝরে যাচ্ছে নিউমোনিয়ায়!"</h1>
            <div class="video-container" data-aos="zoom-in">
                @php
                    $videoID = '';
                    if(isset($landing->video_url)) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $landing->video_url, $match);
                        $videoID = $match[1] ?? '';
                    }
                @endphp
                @if($videoID)
                    <iframe src="https://www.youtube.com/embed/{{ $videoID }}?autoplay=1&mute=1" allowfullscreen></iframe>
                @else
                    <img src="{{ asset('uploads/landing/'.$landing->feature_image) }}" alt="Hero Image" style="width: 100%; height: auto;">
                @endif
            </div>
        </div>
    </section>

    <section class="container" style="padding: 40px 0; text-align: center;">
        <h2 class="section-title">"শিশুর কফ, ঠান্ডা আর শ্বাসকষ্টে দুশ্চিন্তা নয় – এখন উপশম মিলবে রিহানুর প্রাকৃতিক Cold Relief Oil-এ"</h2>
        <a href="#checkout" class="order-btn" data-aos="pulse">অর্ডার করুন</a>
    </section>

    {{-- Blocks Rendering --}}
    <div class="landing-blocks">
        @foreach($landing->blocks as $block)
            <div class="block-wrapper {{ $block->type }}" id="block-{{ $block->id }}" 
                 data-aos="{{ $block->content['aos_type'] ?? 'fade-up' }}" 
                 data-aos-duration="{{ $block->content['aos_duration'] ?? 800 }}"
                 style="background-color: {{ $block->content['bg_color'] ?? 'transparent' }}; padding: {{ ($block->content['padding'] ?? 60) }}px 0;">
                
                @if(isset($block->content['title']) && !in_array($block->type, ['rihanu_checkout']))
                    <div class="container">
                        <h2 class="section-title" style="color: {{ $block->content['title_color'] ?? 'var(--primary-color)' }};">
                            {{ $block->content['title'] }}
                        </h2>
                    </div>
                @endif

                <div class="container">
                    @includeIf('frontend.landing.blocks.' . $block->type, ['content' => $block->content, 'landing' => $landing, 'block' => $block])
                </div>
            </div>
        @endforeach
    </div>

    @if($landing->blocks->where('type', 'rihanu_checkout')->count() == 0)
        {{-- Default Checkout if block not added --}}
        <section class="container" id="checkout">
             @include('frontend.landing.blocks.rihanu_checkout', ['content' => ['title' => 'অর্ডার করতে নিচের ফর্মে আপনার তথ্য দিন'], 'landing' => $landing])
        </section>
    @endif

    <div class="sticky-footer">
        <div class="sticky-footer-text">অর্ডার করতে বাটনে ক্লিক করুন</div>
        <a href="#checkout" class="order-btn">অর্ডার করুন</a>
    </div>

    <footer style="text-align: center; padding: 60px 0; color: #888; font-size: 0.9rem; background: #f8f9fa; margin-top: 40px;">
        <div class="container">
            &copy; {{ date('Y') }} {{ $websetting?->site_name ?? 'Shahzadi Mart' }}. All Rights Reserved.
            <div style="margin-top: 10px;">
                <a href="#" style="color: #888; text-decoration: none; margin: 0 10px;">Privacy Policy</a> | 
                <a href="#" style="color: #888; text-decoration: none; margin: 0 10px;">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init({ duration: 1000, once: true });
            
            // Smooth scroll
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                var target = this.hash;
                var $target = $(target);
                if($target.length) {
                    $('html, body').stop().animate({
                        'scrollTop': $target.offset().top - 80
                    }, 900, 'swing');
                }
            });
        });
    </script>
</body>
</html>
