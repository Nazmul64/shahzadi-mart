<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $landing->title }}</title>

@if(isset($favicon) && $favicon->favicon_logo)
    <link rel="icon" type="image/png" href="{{ asset($favicon->favicon_logo) }}">
@endif
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Hind+Siliguri:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    :root {
        --primary: {{ $landing->btn_color ?? '#00f2ff' }};
        --bg: #050505;
        --text: #ffffff;
        --accent: #ff00ff;
    }
    body { font-family: 'Hind Siliguri', sans-serif; background: var(--bg); color: var(--text); margin: 0; padding: 0; overflow-x: hidden; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    
    .neon-border { border: 2px solid var(--primary); box-shadow: 0 0 15px var(--primary); }
    .neon-text { text-shadow: 0 0 10px var(--primary); }

    .header-bar { background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); border-bottom: 1px solid var(--primary); padding: 15px 0; position: sticky; top: 0; z-index: 1000; }
    
    .hero { padding: 80px 0; text-align: center; background: radial-gradient(circle at center, #111 0%, #000 100%); }
    .hero h1 { font-family: 'Orbitron', sans-serif; font-size: 3.5rem; margin-bottom: 30px; letter-spacing: 2px; }
    
    .media-box { position: relative; border-radius: 20px; overflow: hidden; border: 1px solid var(--primary); margin-bottom: 50px; }
    .media-box img, .media-box video { width: 100%; display: block; }
    
    .cta-glow { display: inline-block; background: var(--primary); color: #000; padding: 20px 60px; font-weight: 900; font-size: 24px; text-decoration: none; border-radius: 5px; text-transform: uppercase; box-shadow: 0 0 30px var(--primary); transition: 0.3s; }
    .cta-glow:hover { transform: scale(1.05); box-shadow: 0 0 50px var(--primary); color: #000; }

    .block-text-image img, .product-card img, .pg-product-card img {
        width: 100%; aspect-ratio: 1/1 !important; object-fit: cover !important; border: 1px solid var(--primary);
    }

    .order-form { background: #111; border: 1px solid var(--primary); padding: 50px; border-radius: 20px; margin: 80px 0; }
    .order-form input, .order-form select { background: #000; border: 1px solid #333; color: #fff; padding: 15px; width: 100%; margin-bottom: 20px; border-radius: 5px; }
    .order-form input:focus { border-color: var(--primary); outline: none; }
</style>
</head>
<body>

    @foreach($landing->blocks->where('type', 'header_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

    <div class="hero">
        <div class="container">
            <h1 class="neon-text" data-aos="zoom-in">{{ $landing->title }}</h1>
            <div class="media-box" data-aos="fade-up">
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
            <a href="#order" class="cta-glow" data-aos="pulse" data-aos-infinite="true">Buy Now</a>
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
            <h2 class="neon-text mb-4 text-center">CONFIRM YOUR ORDER</h2>
            @include('frontend.landing.partials.order_form')
        </div>
    </div>

    @foreach($landing->blocks->where('type', 'footer_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({duration:1000});</script>
</body>
</html>
