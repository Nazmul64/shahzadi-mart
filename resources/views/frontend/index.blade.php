{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif
@if(session('info'))
<div class="alert alert-info d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
</div>
@endif

<div class="smhome-ci content-area-inner">

    {{-- ══ HERO ══ --}}
    @php
        $gs = \App\Models\Generalsetting::getSettings();
        $slideCount = $slider->count();
        $slideDuration = 4; // seconds per slide
        $totalDuration = $slideCount > 0 ? $slideCount * $slideDuration : 16;
    @endphp

    @if($slideCount > 0)
    <style>
        .smhome-slides-wrap {
            animation: smhome-dyn-slide {{ $totalDuration }}s infinite !important;
        }
        @keyframes smhome-dyn-slide {
            @for($i = 0; $i < $slideCount; $i++)
                @php
                    $startPct = ($i / $slideCount) * 100;
                    $pausePct = $startPct + ((80 / $slideCount) * ($slideCount == 1 ? 0 : 1)); // wait before sliding
                @endphp
                {{ $startPct }}%, {{ $pausePct }}% { transform: translateX(-{{ $i * 100 }}%); }
            @endfor
            100% { transform: translateX(0%); }
        }

        @for($i = 0; $i < $slideCount; $i++)
            .smhome-sl-dot:nth-child({{ $i + 1 }}) {
                animation: smhome-dyn-dot {{ $totalDuration }}s infinite {{ -($slideCount - $i) * $slideDuration }}s !important;
            }
        @endfor
        @keyframes smhome-dyn-dot {
            0%, {{ 80 / $slideCount }}% { background: #fff; width: 24px; }
            {{ 100 / $slideCount }}%, 100% { background: rgba(255,255,255,.4); width: 8px; }
        }

        /* Dynamic Category Styles */
        .smhome-circle-img {
            width: {{ $gs->category_img_width }}px !important;
            height: {{ $gs->category_img_height }}px !important;
            border-radius: {{ $gs->category_img_shape == 'circle' ? '50%' : '12px' }} !important;
        }
        .smhome-circle-item {
            margin: 0 {{ $gs->category_slider_margin }}px !important;
            width: {{ $gs->category_img_width }}px !important;
        }
        .smhome-circle-item p {
            width: {{ $gs->category_img_width }}px !important;
        }
    </style>
    @else
    <style>
        /* Dynamic Category Styles (when no slider) */
        .smhome-circle-img {
            width: {{ $gs->category_img_width }}px !important;
            height: {{ $gs->category_img_height }}px !important;
            border-radius: {{ $gs->category_img_shape == 'circle' ? '50%' : '12px' }} !important;
        }
        .smhome-circle-item {
            margin: 0 {{ $gs->category_slider_margin }}px !important;
            width: {{ $gs->category_img_width }}px !important;
        }
        .smhome-circle-item p {
            width: {{ $gs->category_img_width }}px !important;
        }
    </style>
    @endif

    @php
        $latestLanding = $navLanding ?? null;
    @endphp

    <div class="smhome-hero">
        <div class="smhome-hero-slider">
            <div class="smhome-slides-wrap">
                @forelse ($slider as $index => $item)
                    <div class="smhome-slide">
                        <img src="{{ asset($item->photo) }}" alt="Slide" {{ $index === 0 ? 'loading="eager"' : 'loading="lazy"' }}>
                    </div>
                @empty
                    <div class="smhome-slide"
                         style="background:#222;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#555;font-size:14px;">No slides added yet</span>
                    </div>
                @endforelse
            </div>
            <div class="smhome-sl-dots">
                @foreach ($slider as $index => $item)
                    <div class="smhome-sl-dot {{ $index === 0 ? 'active' : '' }}"></div>
                @endforeach
            </div>
        </div>


    </div>

    @if($latestLanding)
    <div class="smhome-landing-mobile-btn-wrap d-md-none">
        <a href="{{ url('l/'.$latestLanding->slug) }}" class="smhome-landing-mobile-btn">
            <i class="bi bi-stars"></i> {{ $latestLanding->title }} <i class="bi bi-chevron-right"></i>
        </a>
    </div>
    @endif


    {{-- ══ CATEGORY CIRCLES ══ --}}
    @if($categories->isNotEmpty())
    <div class="smhome-circles-box">
        <div class="smhome-circles-track {{ $gs->category_slider_status == 1 ? 'owl-carousel owl-theme' : 'grid-mode' }}" id="catCircles">
            @foreach ($categories as $cat)
                <a href="{{ url('category/'.$cat->slug) }}" class="smhome-circle-item">
                    <div class="smhome-circle-img">
                        <img src="{{ asset('uploads/category/'.$cat->category_photo) }}"
                             alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══ FLASH SALES ══ --}}
    @if($flashProducts->isNotEmpty())
    <div class="smhome-flash-hd">
        <div class="smhome-flash-title">
            <i class="bi bi-lightning-charge-fill"></i> Flash Sales
        </div>
        <a href="{{ url('flash-sales') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-section-container" id="sec-flash">
        <div class="smhome-prod-grid">
            @foreach ($flashProducts as $index => $item)
                @php
                    $displayPrice  = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                    $originalPrice = $item->current_price;
                    $discount      = ($displayPrice < $originalPrice && $originalPrice > 0)
                        ? round((($originalPrice - $displayPrice) / $originalPrice) * 100) : null;
                    if ($discount < 0) $discount = null;
                    $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    $revAvg   = $item->reviews_avg_rating ?? 0;
                    $revCount = $item->reviews_count ?? 0;
                @endphp
                <div class="smhome-p-item {{ $index >= 10 ? 'smhome-p-hidden' : '' }}" style="position:relative">
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                       onclick="event.stopPropagation()">
                        <i class="bi bi-heart"></i>
                    </a>

                    <div class="smhome-p-card" 
                         onclick="window.location='{{ route('product.detail', $item->slug) }}'"
                         style="cursor: pointer;">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img"
                                 src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>

                            <div class="smhome-p-price-row" style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
                                <p class="smhome-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                                @if($displayPrice < $originalPrice)
                                    <p class="smhome-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                                @endif
                            </div>
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock">
                                        <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                    </p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>

                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', $item->id) }}"
                                    method="POST"
                                    class="smhome-order-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to_checkout" value="1">
                                    <button type="submit" class="smhome-p-order-btn" style="border:none; width:100%;">
                                        অর্ডার করুন
                                    </button>
                                </form>
                            @else
                                <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                    স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if($flashProducts->count() > 10)
            <div class="smhome-load-more-wrap">
                <button class="smhome-load-more-btn" data-target="sec-flash">
                    লোড মোর <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        @endif
    </div>
    @endif

    {{-- ══ NEW ARRIVALS ══ --}}
    @if($newArrivals->isNotEmpty())
    <div class="smhome-sec-head">
        <h2>New Arrivals</h2>
        <a href="{{ url('new-arrivals') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-section-container" id="sec-new">
        <div class="smhome-prod-grid">
            @foreach ($newArrivals as $index => $item)
                @php
                    $discount = ($item->discount_price && $item->current_price > 0 && $item->discount_price < $item->current_price)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    $revAvg   = $item->reviews_avg_rating ?? 0;
                    $revCount = $item->reviews_count ?? 0;
                @endphp
                <div class="smhome-p-item {{ $index >= 10 ? 'smhome-p-hidden' : '' }}" style="position:relative">
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                       onclick="event.stopPropagation()">
                        <i class="bi bi-heart"></i>
                    </a>

                    <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                        <div class="smhome-p-card">
                            @if($discount)
                                <span class="smhome-p-badge">-{{ $discount }}%</span>
                            @endif
                            <div class="smhome-p-img-wrap">
                                <img class="smhome-p-img"
                                     src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                     alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="smhome-p-body">
                                <p class="smhome-p-name">{{ $item->name }}</p>

                                <div class="smhome-p-price-row" style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
                                    <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                                    @if($item->discount_price)
                                        <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                                    @endif
                                </div>
                                <div class="smhome-p-meta">
                                    @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                        <p class="smhome-p-stock">
                                            <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                        </p>
                                    @endif
                                    <div class="smhome-p-stars-row">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                        @endfor
                                        <span class="smhome-p-rc">({{ $revCount }})</span>
                                    </div>
                                </div>

                                @if($inStock)
                                    <form
                                        action="{{ route('cart.add', $item->id) }}"
                                        method="POST"
                                        class="smhome-order-form"
                                        onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to_checkout" value="1">
                                        <button type="submit" class="smhome-p-order-btn">
                                            অর্ডার করুন
                                        </button>
                                    </form>
                                @else
                                    <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                        স্টক নেই
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        @if($newArrivals->count() > 10)
            <div class="smhome-load-more-wrap">
                <button class="smhome-load-more-btn" data-target="sec-new">
                    লোড মোর <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        @endif
    </div>
    @endif

    {{-- ══ BEST SELLERS ══ --}}
    @if($bestSellers->isNotEmpty())
    <div class="smhome-sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="{{ url('best-sellers') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-section-container" id="sec-best">
        <div class="smhome-prod-grid">
            @foreach ($bestSellers as $index => $item)
                @php
                    $discount = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    $revAvg   = $item->reviews_avg_rating ?? 0;
                    $revCount = $item->reviews_count ?? 0;
                @endphp
                <div class="smhome-p-item {{ $index >= 10 ? 'smhome-p-hidden' : '' }}" style="position:relative">
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                       onclick="event.stopPropagation()">
                        <i class="bi bi-heart"></i>
                    </a>

                    <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                        <div class="smhome-p-card">
                            @if($discount)
                                <span class="smhome-p-badge">-{{ $discount }}%</span>
                            @endif
                            <div class="smhome-p-img-wrap">
                                <img class="smhome-p-img"
                                     src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                     alt="{{ $item->name }}" loading="lazy">
                            </div>
                            <div class="smhome-p-body">
                                <p class="smhome-p-name">{{ $item->name }}</p>

                                <div class="smhome-p-price-row" style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
                                    <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                                    @if($item->discount_price)
                                        <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                                    @endif
                                </div>
                                <div class="smhome-p-meta">
                                    @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                        <p class="smhome-p-stock">
                                            <i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left
                                        </p>
                                    @endif
                                    <div class="smhome-p-stars-row">
                                        @for($s=1;$s<=5;$s++)
                                            <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                        @endfor
                                        <span class="smhome-p-rc">({{ $revCount }})</span>
                                    </div>
                                </div>

                                @if($inStock)
                                    <form
                                        action="{{ route('cart.add', $item->id) }}"
                                        method="POST"
                                        class="smhome-order-form"
                                        onclick="event.stopPropagation()">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="redirect_to_checkout" value="1">
                                        <button type="submit" class="smhome-p-order-btn">
                                            অর্ডার করুন
                                        </button>
                                    </form>
                                @else
                                    <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                        স্টক নেই
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        @if($bestSellers->count() > 10)
            <div class="smhome-load-more-wrap">
                <button class="smhome-load-more-btn" data-target="sec-best">
                    লোড মোর <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        @endif
    </div>
    @endif


    {{-- ══ DIGITAL PRODUCTS ══ --}}
    @if($digitalProducts->isNotEmpty())
    <div class="smhome-sec-head" style="margin-top:12px">
        <h2>Digital Products</h2>
        <a href="{{ url('shop?type=digital') }}" class="smhome-see-all">
            SEE ALL <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($digitalProducts as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = $item->reviews_avg_rating ?? 0;
                $revCount = $item->reviews_count ?? 0;
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="smhome-p-wish" title="উইশলিস্টে যোগ করুন"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>

                <a href="{{ route('digital.product.detail', $item->slug) }}" class="smhome-p-card-link">
                    <div class="smhome-p-card">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img"
                                 src="{{ asset('uploads/products/'.$item->feature_image) }}"
                                 alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>

                            <div class="smhome-p-price-row" style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
                                <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                                @if($item->discount_price)
                                    <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                                @endif
                            </div>
                            <div class="smhome-p-meta">
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>

                            @if($inStock)
                                <form
                                    action="{{ route('cart.add', ['id' => $item->id, 'type' => 'digital']) }}"
                                    method="POST"
                                    class="smhome-order-form"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="redirect_to_checkout" value="1">
                                    <button type="submit" class="smhome-p-order-btn">
                                        অর্ডার করুন
                                    </button>
                                </form>
                            @else
                                <span class="smhome-p-order-btn smhome-p-order-btn--out">
                                    স্টক নেই
                                </span>
                            @endif

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif
</div>{{-- /.smhome-ci --}}

<style>
.smhome-circle-item {
    width: {{ $gs->category_img_width ?? 80 }}px;
    margin: 0 auto;
}
@if($gs->category_slider_status != 1)
.smhome-circles-track.grid-mode {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax({{ $gs->category_img_width ?? 80 }}px, 1fr));
    gap: 20px;
}
@endif
.smhome-circles-track.owl-carousel {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow: hidden !important;
}
.smhome-circles-track.owl-carousel .owl-stage-outer {
    width: 100%;
}
</style>

@if($gs->category_slider_status == 1)
<script>
$(document).ready(function(){
    var catMargin = {{ $gs->category_slider_margin ?? 10 }};
    
    $("#catCircles").owlCarousel({
        loop: true,
        margin: catMargin,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        smartSpeed: 800,
        autoWidth: true, /* Let items take their own width */
        items: 10 /* High enough so it doesn't restrict */
    });

    // Load More Logic
    $('.smhome-load-more-btn').on('click', function() {
        var targetId = $(this).data('target');
        var $container = $('#' + targetId);
        var $hiddenItems = $container.find('.smhome-p-hidden');
        
        // Show next 10 items
        $hiddenItems.slice(0, 10).each(function(index) {
            var $item = $(this);
            $item.css('display', 'block');
            setTimeout(function() {
                $item.removeClass('smhome-p-hidden').addClass('smhome-p-reveal');
            }, index * 50); // Staggered animation
        });

        // Hide button if no more items
        if ($container.find('.smhome-p-hidden').length === 0) {
            $(this).parent().fadeOut();
        }
    });
});
</script>
@endif

<style>
/* Load More Styles */
.smhome-p-hidden {
    display: none;
    opacity: 0;
    transform: translateY(20px);
}
.smhome-p-reveal {
    animation: smhomeFadeUp 0.5s ease forwards;
}
@keyframes smhomeFadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.smhome-load-more-wrap {
    display: flex;
    justify-content: center;
    margin-top: 25px;
    margin-bottom: 20px;
}
.smhome-load-more-btn {
    background: #fff;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 10px 35px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}
.smhome-load-more-btn:hover {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 4px 15px rgba(190, 3, 24, 0.2);
}
</style>

@endsection