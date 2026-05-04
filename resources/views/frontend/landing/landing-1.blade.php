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
        font-size: clamp(24px, 5vw, 40px);
        font-weight: 800;
        margin: 30px 0;
        line-height: 1.3;
    }

    .hero-media {
        border-radius: 30px;
        overflow: hidden;
        border: 8px solid #fff;
        box-shadow: 0 30px 100px rgba(0,0,0,0.4);
        margin-bottom: 40px;
        background: #000;
        position: relative;
    }

    .hero-media img, .hero-media video { width: 100%; display: block; }
    .hero-media iframe { width: 100%; aspect-ratio: 16/9; border: none; }

    /* CTA */
    .cta-btn {
        display: block;
        width: fit-content;
        margin: 30px auto;
        background: var(--primary-color);
        color: #fff;
        text-decoration: none;
        padding: 18px 50px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 20px;
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
<body>
@if($landing->gtm_id)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $landing->gtm_id }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif
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
    <div class="order-section" id="order" data-aos="fade-up" data-aos-duration="1000">
        <h2 style="text-align: center; margin-bottom: 40px; font-weight: 800; color: #fff;">অর্ডার ফর্মটি পূরণ করুন</h2>
        
        <form id="landingOrderForm">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="landing_page_id" value="{{ $landing->id }}">

            <div class="order-grid-container" style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start; width: 100%; overflow: hidden;">
                {{-- Left Column: Product Summary --}}
            <div class="order-grid-container" style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start; width: 100%; overflow: hidden;">
                {{-- Left Column: Product Cart List --}}
                <div style="flex: 1; min-width: 280px; width: 100%;">
                    <div id="cart-items-wrapper" style="display: flex; flex-direction: column; gap: 15px;">
                        {{-- Cart items will be rendered here via JS --}}
                    </div>
                </div>


                {{-- Right Column: Form Fields --}}
                <div style="flex: 1; min-width: 280px; width: 100%; background: rgba(255,255,255,0.02); padding: 35px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">

                    <h3 style="font-size: 18px; margin-bottom: 25px; color: #fff; font-weight: 700; border-bottom: 2px solid rgba(255,255,255,0.1); padding-bottom: 12px;">শিপিং ইনফরমেশন</h3>
                    
                    <div class="form-group">
                        <label>আপনার নাম *</label>
                        <input type="text" name="name" class="form-control" placeholder="আপনার নাম লিখুন" required>
                    </div>
                    <div class="form-group">
                        <label>মোবাইল নাম্বার *</label>
                        <input type="text" name="phone" class="form-control" placeholder="আপনার মোবাইল নাম্বার লিখুন" required>
                    </div>
                    <div class="form-group">
                        <label>বিস্তারিত ঠিকানা *</label>
                        <input type="text" name="address" class="form-control" placeholder="গ্রাম/মহল্লা, থানা, জেলা" required>
                    </div>
                    
                    <div class="form-group">
                        <label>ডেলিভারি এরিয়া *</label>
                        <select name="shipping_area" id="shipping_area" class="form-control" required>
                            <option value="">এরিয়া নির্বাচন করুন</option>
                            <option value="inside">ঢাকার ভিতরে (৭০ টাকা)</option>
                            <option value="outside">ঢাকার বাইরে (১৩০ টাকা)</option>
                        </select>
                    </div>

                    <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 18px; margin: 30px 0; border: 1px dashed var(--primary-color);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span style="color: #bbb;">ডেলিভারি চার্জ</span>
                            <span id="shipping_cost" style="color: #fff;">০ টাকা</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 24px; color: var(--primary-color); border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; margin-top: 15px;">
                            <span>সর্বমোট</span>
                            <span id="total_cost">{{ number_format($price) }} টাকা</span>
                        </div>
                    </div>

                    <button type="submit" class="order-btn" id="submitBtn" style="width: 100%; border-radius: 12px; padding: 20px; font-size: 18px; font-weight: 700;">অর্ডার নিশ্চিত করুন</button>
                </div>
            </div>
        </form>
    </div>


    <div style="text-align: center; margin-top: 50px; padding: 20px; opacity: 0.6; font-size: 13px;">
        &copy; {{ date('Y') }} {{ $websetting?->site_name ?? 'Shahzadi Mart' }}. All Rights Reserved.
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- AOS Animation Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    let cart = [];
    
    // Initialize with main product
    const mainProduct = {!! json_encode([
        'id' => $product->id,
        'name' => $product->name,
        'price' => (float) ($product->discount_price ?? $product->current_price),
        'image' => asset('uploads/products/'.$product->feature_image),
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
                <div class="cart-item" style="display: flex; gap: 15px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); align-items: center;">
                    <img src="${item.image}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" alt="${item.name}">
                    <div style="flex: 1;">
                        <h6 style="margin: 0 0 5px; font-weight: 700; font-size: 14px; color: #fff;">${item.name}</h6>
                        <div style="color: var(--primary-color); font-weight: 800; font-size: 16px;">৳${item.price.toLocaleString()}</div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 20px;">
                                <button type="button" onclick="updateQty(${index}, -1)" style="border:none; background:none; color:#fff; cursor:pointer; font-weight:800;">-</button>
                                <span style="font-weight:800; color:#fff; min-width: 15px; text-align:center;">${item.qty}</span>
                                <button type="button" onclick="updateQty(${index}, 1)" style="border:none; background:none; color:#fff; cursor:pointer; font-weight:800;">+</button>
                            </div>
                            <button type="button" onclick="removeFromCart(${index})" style="border:none; background:none; color:#ff4d4d; cursor:pointer;"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div style="font-weight: 800; font-size: 16px; color: #fff;">৳${(item.price * item.qty).toLocaleString()}</div>
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
        // Option: Scroll to order form
        const orderSection = document.getElementById('order');
        if(orderSection) orderSection.scrollIntoView({ behavior: 'smooth' });
    }

    $(document).ready(function() {
        AOS.init({ duration: 800, once: true, offset: 50 });
        $('#shipping_area').on('change', renderCart);
        renderCart();

        $('#landingOrderForm').on('submit', function(e) {
            e.preventDefault();
            if (cart.length === 0) {
                alert('আপনার কার্ট খালি!');
                return;
            }
            const btn = $('#submitBtn');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> প্রসেসিং...');
            
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
                    if(res.success) window.location.href = res.redirect;
                    else { alert(res.message); btn.prop('disabled', false).html('অর্ডার নিশ্চিত করুন'); }
                },
                error: function(xhr) {
                    alert('সমস্যা হয়েছে: ' + (xhr.responseJSON?.message || 'Error'));
                    btn.prop('disabled', false).html('অর্ডার নিশ্চিত করুন');
                }
            });
        });
    });
</script>


</body>
</html>
