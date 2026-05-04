<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $landing->title }}</title>

@if(isset($favicon) && $favicon->favicon_logo)
    <link rel="icon" type="image/png" href="{{ asset($favicon->favicon_logo) }}">
@endif
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    :root {
        --primary: {{ $landing->btn_color ?? '#111111' }};
        --bg: #fcfcfc;
        --text: #1a1a1a;
    }
    body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 0; overflow-x: hidden; }
    .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
    
    .luxury-title { font-family: 'Playfair Display', serif; font-size: 4rem; font-weight: 900; color: #000; margin-bottom: 40px; line-height: 1.1; }
    
    .hero { padding: 120px 0; text-align: center; }
    .hero-img-wrap { padding: 20px; background: #fff; box-shadow: 0 40px 100px rgba(0,0,0,0.05); border-radius: 2px; margin-bottom: 60px; }
    .hero-img-wrap img { width: 100%; display: block; border-radius: 0; }

    .btn-luxury { display: inline-block; background: #000; color: #fff; padding: 22px 60px; font-weight: 600; font-size: 18px; text-decoration: none; border-radius: 0; letter-spacing: 2px; text-transform: uppercase; transition: 0.4s; }
    .btn-luxury:hover { background: #333; letter-spacing: 4px; }

    .block-text-image img, .product-card img, .pg-product-card img {
        width: 100%; aspect-ratio: 1/1 !important; object-fit: cover !important; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .order-form { background: #fff; padding: 80px; box-shadow: 0 50px 150px rgba(0,0,0,0.07); margin: 100px 0; border: 1px solid #eee; }
    .order-form h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 40px; }
    .order-form input, .order-form select { border: none; border-bottom: 1px solid #ddd; padding: 15px 0; width: 100%; margin-bottom: 30px; border-radius: 0; font-size: 1.1rem; }
    .order-form input:focus { border-color: #000; outline: none; }
</style>
</head>
<body>

    @foreach($landing->blocks->where('type', 'header_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

    <div class="hero">
        <div class="container">
            <h1 class="luxury-title" data-aos="fade-down">{{ $landing->title }}</h1>
            <div class="hero-img-wrap" data-aos="fade-up">
                @if($landing->video_url)
                    @php
                        $vurl = $landing->video_url;
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $vurl, $m)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1';
                        } else {
                            $embedUrl = $vurl;
                        }
                    @endphp
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                        <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                @elseif($landing->feature_image)
                    <img src="{{ asset('uploads/landing/'.$landing->feature_image) }}" alt="">
                @endif
            </div>
            <a href="#order" class="btn-luxury" data-aos="fade-up">Order Premium</a>
        </div>
    </div>

    <div class="container">
        @if($landing->blocks && $landing->blocks->count() > 0)
            <div class="dynamic-blocks-wrapper">
                @foreach($landing->blocks->where('type', '!=', 'header_classic')->where('type', '!=', 'footer_classic') as $block)
                    @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
                @endforeach
            </div>
        @endif

        <div id="order" class="order-form" data-aos="fade-up">
            <h2 class="text-center">Secure Checkout</h2>
            @include('frontend.landing.partials.order_form')
        </div>
    </div>

    @foreach($landing->blocks->where('type', 'footer_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({duration:1200});</script>
</body>
</html>
