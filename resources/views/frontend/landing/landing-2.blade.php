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

{{-- GTM --}}
@if($landing->gtm_id)
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $landing->gtm_id }}');</script>
@endif

{{-- Facebook Pixel --}}
@if($landing->fb_pixel_id)
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $landing->fb_pixel_id }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $landing->fb_pixel_id }}&ev=PageView&noscript=1"
/></noscript>
@endif


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
        max-width: 400px;
        margin: 30px auto;
        background: var(--primary);
        color: #fff;
        text-decoration: none;
        padding: 20px;
        border-radius: 15px;
        font-size: 22px;
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



{{-- GTM --}}
@if($landing->gtm_id)
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $landing->gtm_id }}');</script>
@endif

{{-- Facebook Pixel --}}
@if($landing->fb_pixel_id)
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $landing->fb_pixel_id }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $landing->fb_pixel_id }}&ev=PageView&noscript=1"
/></noscript>
@endif

</head>
<body style="overflow-x: hidden; width: 100%;">
@if($landing->gtm_id)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $landing->gtm_id }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif


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

    <div class="order-form-box" id="order-now" data-aos="fade-up" data-aos-duration="1000">
        <h2 style="text-align: center; margin-bottom: 40px; font-weight: 800;">অর্ডার ফর্মটি পূরণ করুন</h2>
        
        <form id="landingOrderForm">
            <input type="hidden" name="product_id" value="{{ $landing->product->id }}">
            <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">

            <div class="order-grid-container" style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">
                {{-- Left Column: Product Cart List --}}
                <div style="flex: 1; min-width: 280px; width: 100%;">
                    <div id="cart-items-wrapper" style="display: flex; flex-direction: column; gap: 15px;">
                        {{-- Cart items will be rendered here via JS --}}
                    </div>
                </div>


                {{-- Right Column: Form Fields --}}
                <div style="flex: 1; min-width: 280px; width: 100%; background: #fff; padding: 35px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">

                    <h3 style="font-size: 20px; margin-bottom: 25px; color: #333; font-weight: 700; border-bottom: 2px solid #f0f0f0; padding-bottom: 12px;">শিপিং ইনফরমেশন</h3>
                    
                    <div class="input-item">
                        <label>আপনার নাম লিখুন *</label>
                        <input type="text" name="name" placeholder="উদা: আব্দুল্লাহ" required>
                    </div>
                    
                    <div class="input-item">
                        <label>মোবাইল নাম্বার দিন *</label>
                        <input type="text" name="phone" placeholder="উদা: 017XXXXXXXX" required>
                    </div>
                    
                    <div class="input-item">
                        <label>পূর্ণ ঠিকানা (থানা ও জেলাসহ) *</label>
                        <input type="text" name="address" placeholder="উদা: মিরপুর-১০, ঢাকা" required>
                    </div>

                    <div class="input-item">
                        <label>ডেলিভারি এরিয়া *</label>
                        <select name="shipping_area" id="shipping_area" required>
                            <option value="">নির্বাচন করুন</option>
                            <option value="inside">ঢাকার ভিতরে (৭০ টাকা)</option>
                            <option value="outside">ঢাকার বাইরে (১৩০ টাকা)</option>
                        </select>
                    </div>

                    <div style="background: #f8fdf9; padding: 25px; border-radius: 18px; margin: 30px 0; border: 1px dashed var(--primary);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span style="color: #666;">ডেলিভারি চার্জ</span>
                            <span id="shipping_cost" style="font-weight: 600;">০ টাকা</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 24px; color: var(--primary); border-top: 1px solid #edf2f4; padding-top: 15px; margin-top: 15px;">
                            <span>সর্বমোট</span>
                            <span id="total_cost">{{ number_format($price) }} টাকা</span>
                        </div>
                    </div>

                    <button type="submit" class="confirm-btn" id="submitBtn" style="width: 100%; padding: 20px; font-size: 20px; font-weight: 700; border-radius: 12px;">অর্ডার নিশ্চিত করুন</button>
                </div>
            </div>
        </form>
    </div>


    {{-- Footer Bottom --}}
    @foreach($landing->blocks->where('type', 'footer_classic') as $block)
        @include('frontend.landing.blocks.'.$block->type, ['block' => $block])
    @endforeach

    <div class="default-footer">
        &copy; {{ date('Y') }} {{ $websetting?->site_name ?? 'Shahzadi Mart' }}. প্রাকৃতিক স্বাদে ভরপুর।
    </div>
</div>

<script>
    let cart = [];
    
    // Initialize with main product
    const mainProduct = {!! json_encode([
        'id' => $landing->product->id,
        'name' => $landing->product->name,
        'price' => (float) ($landing->product->discount_price ?? $landing->product->current_price),
        'image' => asset('uploads/products/'.$landing->product->feature_image),
        'qty' => 1
    ]) !!};


    cart.push(mainProduct);

    function renderCart() {
        const wrapper = $('#cart-items-wrapper');
        wrapper.empty();
        
        let subtotalTotal = 0;

        cart.forEach((item, index) => {
            subtotalTotal += item.price * item.qty;
            const itemHtml = `
                <div class="cart-item" style="display: flex; gap: 15px; background: #fff; padding: 15px; border-radius: 15px; border: 1px solid #f0f0f0; align-items: center;">
                    <img src="${item.image}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" alt="${item.name}">
                    <div style="flex: 1;">
                        <h6 style="margin: 0 0 5px; font-weight: 700; font-size: 14px;">${item.name}</h6>
                        <div style="color: var(--primary); font-weight: 800; font-size: 16px;">৳${item.price.toLocaleString()}</div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                            <div style="display: flex; align-items: center; gap: 8px; background: #f8f9fa; padding: 4px 10px; border-radius: 20px; border: 1px solid #eee;">
                                <button type="button" onclick="updateQty(${index}, -1)" style="border:none; background:none; cursor:pointer; font-weight:800;">-</button>
                                <span style="font-weight:800; min-width: 20px; text-align:center;">${item.qty}</span>
                                <button type="button" onclick="updateQty(${index}, 1)" style="border:none; background:none; cursor:pointer; font-weight:800;">+</button>
                            </div>
                            <button type="button" onclick="removeFromCart(${index})" style="border:none; background:none; color:#ff4d4d; cursor:pointer;"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div style="font-weight: 800; font-size: 16px;">৳${(item.price * item.qty).toLocaleString()}</div>
                </div>
            `;
            wrapper.append(itemHtml);
        });

        const area = $('#shipping_area').val();
        let shipping = 0;
        if (area === 'inside') shipping = 70;
        else if (area === 'outside') shipping = 130;
        
        const grandTotal = subtotalTotal + shipping;

        $('#shipping_cost').text(shipping + ' টাকা');
        $('#total_cost').text(grandTotal.toLocaleString() + ' টাকা');
    }

    window.updateQty = function(index, change) {
        cart[index].qty += change;
        if (cart[index].qty < 1) cart[index].qty = 1;
        renderCart();
    }

    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        renderCart();
    }

    window.addToCart = function(productData) {
        const existing = cart.find(i => i.id === productData.id);
        if (existing) {
            existing.qty += 1;
        } else {
            productData.qty = 1;
            cart.push(productData);
        }
        renderCart();
        const orderSection = document.getElementById('order-now');
        if(orderSection) orderSection.scrollIntoView({ behavior: 'smooth' });
    }


    $(document).ready(function() {
        AOS.init({ duration: 800, once: true, offset: 50 });
        
        $('#shipping_area').on('change', renderCart);
        renderCart();

        $('#landingOrderForm').on('submit', function(e) {
            e.preventDefault();
            if (cart.length === 0) {
                alert('আপনার কার্ট খালি! অনুগ্রহ করে প্রোডাক্ট যোগ করুন।');
                return;
            }
            const btn = $('#submitBtn');
            btn.prop('disabled', true).text('অর্ডার প্রসেস হচ্ছে...');
            
            const formData = $(this).serializeArray();
            const data = {};
            formData.forEach(item => data[item.name] = item.value);
            data.cart = cart;
            data._token = "{{ csrf_token() }}";
            data.landing_source = "landing_page";

            $.ajax({
                url: "{{ route('order.store') }}",
                method: "POST",
                data: data,
                success: function(res) {
                    if(res.success) {
                        window.location.href = res.redirect;
                    } else {
                        alert(res.message);
                        btn.prop('disabled', false).text('অর্ডার নিশ্চিত করুন');
                    }
                },
                error: function(xhr) {
                    alert('দুঃখিত! কোনো একটি সমস্যা হয়েছে। ' + (xhr.responseJSON?.message || ''));
                    btn.prop('disabled', false).text('অর্ডার নিশ্চিত করুন');
                }
            });
        });
    });
</script>


</body>
</html>
