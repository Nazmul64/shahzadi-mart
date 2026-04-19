{{-- resources/views/frontend/index.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.smhome-ci,
.smhome-ci * {
    font-family: 'DM Sans', sans-serif;
    box-sizing: border-box;
}
.smhome-ci h1, .smhome-ci h2 {
    font-family: 'Playfair Display', serif;
}

/* ══ HERO ══ */
.smhome-hero {
    display: grid;
    grid-template-columns: 1fr 220px;
    gap: 16px;
    margin-bottom: 24px;
}

/* ── CSS-only Slider ── */
.smhome-hero-slider {
    position: relative;
    border-radius: var(--rl);
    overflow: hidden;
    height: 300px;
    box-shadow: var(--sh2);
    border: 1px solid var(--border);
    background: #111;
}
.smhome-slides-wrap {
    display: flex;
    height: 100%;
    animation: smhome-css-slide 16s infinite;
    will-change: transform;
}
@keyframes smhome-css-slide {
    0%,20%  { transform: translateX(0%); }
    25%,45% { transform: translateX(-100%); }
    50%,70% { transform: translateX(-200%); }
    75%,95% { transform: translateX(-300%); }
    100%    { transform: translateX(0%); }
}
.smhome-slide {
    min-width: 100%;
    height: 300px;
    flex-shrink: 0;
    overflow: hidden;
}
.smhome-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Dots */
.smhome-sl-dots {
    position: absolute;
    bottom: 14px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 10;
    pointer-events: none;
}
.smhome-sl-dot {
    width: 8px;
    height: 8px;
    border-radius: 4px;
    background: rgba(255,255,255,.4);
}
.smhome-sl-dot:nth-child(1) { animation: smhome-dot-a 16s infinite 0s; }
.smhome-sl-dot:nth-child(2) { animation: smhome-dot-a 16s infinite -12s; }
.smhome-sl-dot:nth-child(3) { animation: smhome-dot-a 16s infinite -8s; }
.smhome-sl-dot:nth-child(4) { animation: smhome-dot-a 16s infinite -4s; }
@keyframes smhome-dot-a {
    0%,20%   { background: #fff; width: 24px; }
    25%,100% { background: rgba(255,255,255,.4); width: 8px; }
}

/* ── Hero Right Panel ── */
.smhome-hero-panel {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.smhome-welcome-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 20px 14px 16px;
    text-align: center;
    box-shadow: var(--sh1);
}
.smhome-welcome-card__label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 14px;
}
.smhome-auth-btns { display: flex; gap: 8px; }
.smhome-btn-reg {
    flex: 1; background: var(--light); color: var(--text);
    border: 1.5px solid var(--border); padding: 10px 4px; border-radius: 26px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
    transition: var(--t); text-decoration: none; display: flex; align-items: center; justify-content: center;
}
.smhome-btn-reg:hover { border-color: var(--red); color: var(--red); }
.smhome-btn-sign {
    flex: 1; background: var(--red); color: #fff; border: none;
    padding: 10px 4px; border-radius: 26px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
    transition: var(--t); text-decoration: none; display: flex; align-items: center; justify-content: center;
}
.smhome-btn-sign:hover { background: var(--red-d); color: #fff; }

.smhome-clearance-card {
    flex: 1;
    background: linear-gradient(145deg, var(--red) 0%, #8b0000 100%);
    color: #fff; border-radius: var(--rm);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 23px; font-weight: 900;
    line-height: 1.05; text-align: center;
    padding: 20px 10px; min-height: 100px;
    box-shadow: var(--sh-red); transition: var(--t);
    text-decoration: none; position: relative; overflow: hidden;
}
.smhome-clearance-card::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.13), transparent 55%);
}
.smhome-clearance-card small {
    font-family: 'DM Sans', sans-serif; font-size: 9px; font-weight: 800;
    letter-spacing: .2em; text-transform: uppercase; opacity: .88; margin-top: 6px; display: block;
}
.smhome-clearance-card:hover {
    transform: translateY(-3px); box-shadow: 0 12px 32px rgba(200,16,46,.45); color: #fff;
}

/* ── Mobile strip ── */
.smhome-hero-mobile-strip { display: none; gap: 10px; margin-bottom: 18px; }
.smhome-hero-mobile-strip .smhome-welcome-card { flex: 1; }
.smhome-hero-mobile-strip .smhome-clearance-card { flex: 0 0 130px; min-height: 76px; font-size: 17px; }

/* ══ CATEGORY CIRCLES ══ */
.smhome-circles-box {
    margin-bottom: 24px; overflow: hidden;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 18px; box-shadow: var(--sh1);
}
.smhome-circles-track {
    display: flex; gap: 18px; width: max-content;
    animation: smhome-marquee 34s linear infinite;
}
.smhome-circles-track:hover { animation-play-state: paused; }
@keyframes smhome-marquee { to { transform: translateX(-50%); } }
.smhome-circle-item {
    display: flex; flex-direction: column;
    align-items: center; gap: 8px; flex-shrink: 0; text-decoration: none;
}
.smhome-circle-img {
    width: 72px; height: 72px; border-radius: 50%;
    overflow: hidden; border: 2.5px solid var(--border); transition: var(--t);
}
.smhome-circle-img img { width: 100%; height: 100%; object-fit: cover; }
.smhome-circle-item:hover .smhome-circle-img {
    border-color: var(--red); transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(200,16,46,.22);
}
.smhome-circle-item p { font-size: 12.5px; font-weight: 700; color: var(--mid); text-align: center; white-space: nowrap; }
.smhome-circle-item:hover p { color: var(--red); }

/* ══ SECTION HEADER ══ */
.smhome-sec-head {
    display: flex; align-items: center; justify-content: space-between; margin: 28px 0 14px;
}
.smhome-sec-head h2 {
    font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 800; color: var(--dark);
    display: flex; align-items: center; gap: 11px; margin: 0;
}
.smhome-sec-head h2::before {
    content: ''; width: 5px; height: 24px; background: var(--red); border-radius: 3px; flex-shrink: 0;
}
.smhome-see-all {
    font-size: 12.5px; font-weight: 700; color: var(--red); letter-spacing: .07em; text-transform: uppercase;
    display: flex; align-items: center; gap: 5px; transition: gap .2s; text-decoration: none;
}
.smhome-see-all:hover { gap: 9px; color: var(--red); }

/* ══ FLASH SALE BAR ══ */
.smhome-flash-hd {
    display: flex; align-items: center; gap: 14px;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); padding: 14px 20px;
    margin-bottom: 12px; box-shadow: var(--sh1); flex-wrap: wrap;
}
.smhome-flash-title {
    font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 800; color: var(--dark);
    display: flex; align-items: center; gap: 8px; flex: 1; min-width: 130px;
}
.smhome-flash-title i { color: var(--red); animation: smhome-flash-pulse 1.4s ease-in-out infinite; }
@keyframes smhome-flash-pulse { 0%,100% { opacity: 1; } 50% { opacity: .3; } }

/* ══ PRODUCT GRID ══ */
.smhome-prod-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 16px; margin-bottom: 32px;
}

/* ══ PRODUCT CARD ══ */
.smhome-p-card-link { text-decoration: none; color: inherit; display: block; position: relative; }
.smhome-p-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--rm); overflow: hidden; position: relative;
    transition: var(--t); display: flex; flex-direction: column; height: 100%;
}
.smhome-p-card:hover { box-shadow: var(--sh3); transform: translateY(-5px); border-color: var(--border-d); }
.smhome-p-badge {
    position: absolute; top: 10px; left: 10px;
    background: var(--red); color: #fff; font-size: 10px; font-weight: 800;
    padding: 4px 9px; border-radius: 5px; letter-spacing: .04em; z-index: 2;
}
.smhome-p-wish {
    position: absolute; top: 9px; right: 9px;
    width: 34px; height: 34px; background: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #bbb; box-shadow: 0 2px 8px rgba(0,0,0,.13);
    z-index: 10; border: none; cursor: pointer;
    transition: color .2s, background .2s, transform .2s;
    opacity: 0; pointer-events: none; text-decoration: none;
}
.smhome-p-card:hover .smhome-p-wish { opacity: 1; pointer-events: auto; }
.smhome-p-wish:hover { transform: scale(1.15); color: var(--red); background: #fff0f0; }
.smhome-p-img-wrap { position: relative; overflow: hidden; }
.smhome-p-img {
    width: 100%; height: 165px; object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s cubic-bezier(.4,0,.2,1); display: block;
}
.smhome-p-card:hover .smhome-p-img { transform: scale(1.06); }
.smhome-p-body { padding: 12px 13px 13px; display: flex; flex-direction: column; flex: 1; }
.smhome-p-name {
    font-size: 13.5px; font-weight: 600; color: var(--text);
    line-height: 1.48; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.smhome-p-price { font-size: 16px; font-weight: 900; color: var(--red); margin-bottom: 2px; }
.smhome-p-old   { font-size: 12px; color: var(--muted); text-decoration: line-through; margin-bottom: 5px; }
.smhome-p-stock { font-size: 11.5px; font-weight: 700; color: #d97706; margin-bottom: 5px; }
.smhome-p-meta  { margin-bottom: 10px; }

/* ── Star rating row ── */
.smhome-p-stars-row {
    display: flex; align-items: center; gap: 3px; margin-bottom: 3px;
}
.smhome-p-stars-row .sm-star { font-size: 11px; }
.smhome-p-stars-row .sm-star.filled { color: #f59e0b; }
.smhome-p-stars-row .sm-star.empty  { color: #d1d5db; }
.smhome-p-rc { color: var(--muted); font-size: 11px; margin-left: 4px; }

/* Add to Cart button */
.smhome-p-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0; background: var(--red); color: #fff; border: none;
    border-radius: var(--r); font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 700;
    letter-spacing: .02em; cursor: pointer; transition: var(--t);
    margin-top: auto; text-decoration: none;
}
.smhome-p-atc:hover {
    background: var(--red-d); transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(200,16,46,.35); color: #fff;
}
.smhome-p-atc:active { transform: scale(.97); }
.smhome-p-atc i { font-size: 12px; }

/* ══ RESPONSIVE ══ */
@media (max-width: 900px) {
    .smhome-hero { grid-template-columns: 1fr; }
    .smhome-hero-panel { display: none; }
    .smhome-hero-mobile-strip { display: flex; }
    .smhome-prod-grid { grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 13px; }
    .smhome-p-wish { opacity: 1; pointer-events: auto; }
}
@media (max-width: 640px) {
    .smhome-slide { height: 230px; } .smhome-hero-slider { height: 230px; }
    .smhome-hero-mobile-strip .smhome-clearance-card { flex: 0 0 110px; font-size: 15px; }
    .smhome-sec-head h2 { font-size: 20px; }
    .smhome-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 11px; }
    .smhome-p-img { height: 140px; }
    .smhome-flash-hd { padding: 11px 16px; gap: 9px; }
    .smhome-flash-title { font-size: 18px; }
}
@media (max-width: 420px) {
    .smhome-slide { height: 195px; } .smhome-hero-slider { height: 195px; }
    .smhome-hero-mobile-strip .smhome-clearance-card { flex: 0 0 96px; font-size: 14px; }
    .smhome-prod-grid { gap: 9px; }
    .smhome-p-name { font-size: 12.5px; } .smhome-p-price { font-size: 15px; }
    .smhome-p-img { height: 130px; } .smhome-circle-img { width: 63px; height: 63px; }
    .smhome-circle-item p { font-size: 11.5px; } .smhome-sec-head h2 { font-size: 18px; }
}
@media (max-width: 360px) {
    .smhome-hero-mobile-strip { flex-direction: column; }
    .smhome-hero-mobile-strip .smhome-clearance-card { flex: none; min-height: 64px; flex-direction: row; gap: 8px; font-size: 15px; }
    .smhome-prod-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

{{-- ══ Flash messages ══ --}}
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
    <div class="smhome-hero">
        <div class="smhome-hero-slider">
            <div class="smhome-slides-wrap">
                @forelse ($slider as $item)
                    <div class="smhome-slide">
                        <img src="{{ $item->photo ?? '' }}" alt="Slide">
                    </div>
                @empty
                    <div class="smhome-slide" style="background:#222;display:flex;align-items:center;justify-content:center;">
                        <span style="color:#555;font-size:14px;">No slides added yet</span>
                    </div>
                @endforelse
            </div>
            <div class="smhome-sl-dots">
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
                <div class="smhome-sl-dot"></div>
            </div>
        </div>

        <div class="smhome-hero-panel">
            <div class="smhome-welcome-card">
                <p class="smhome-welcome-card__label">Welcome Back</p>
                <div class="smhome-auth-btns">
                    <a href="{{ url('customer/register') }}" class="smhome-btn-reg">Register</a>
                    <a href="{{ url('customer/login') }}"    class="smhome-btn-sign">Sign In</a>
                </div>
            </div>
            <a href="{{ url('clearance') }}" class="smhome-clearance-card">
                CLEA-<br>RANCE
                <small>UP TO 70% OFF</small>
            </a>
        </div>
    </div>

    {{-- Mobile Strip --}}
    <div class="smhome-hero-mobile-strip">
        <div class="smhome-welcome-card" style="flex:1">
            <p class="smhome-welcome-card__label">Welcome Back</p>
            <div class="smhome-auth-btns">
                <a href="{{ url('customer/register') }}" class="smhome-btn-reg">Register</a>
                <a href="{{ url('customer/login') }}"    class="smhome-btn-sign">Sign In</a>
            </div>
        </div>
        <a href="{{ url('clearance') }}" class="smhome-clearance-card">
            CLEA-<br>RANCE
            <small>UP TO 70% OFF</small>
        </a>
    </div>

    {{-- ══ CATEGORY CIRCLES ══ --}}
    @if($categories->isNotEmpty())
    <div class="smhome-circles-box">
        <div class="smhome-circles-track">
            @foreach ($categories as $cat)
                <a href="{{ url('category/'.$cat->slug) }}" class="smhome-circle-item">
                    <div class="smhome-circle-img">
                        <img src="{{ asset('uploads/category/'.$cat->category_photo) }}" alt="{{ $cat->category_name }}" loading="lazy">
                    </div>
                    <p>{{ $cat->category_name }}</p>
                </a>
            @endforeach
            {{-- Duplicate for seamless loop --}}
            @foreach ($categories as $cat)
                <a href="{{ url('category/'.$cat->slug) }}" class="smhome-circle-item">
                    <div class="smhome-circle-img">
                        <img src="{{ asset('uploads/category/'.$cat->category_photo) }}" alt="{{ $cat->category_name }}" loading="lazy">
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
    <div class="smhome-prod-grid">
        @foreach ($flashProducts as $item)
            @php
                $displayPrice  = $item->flash_sale_price ?? $item->discount_price ?? $item->current_price;
                $originalPrice = $item->current_price;
                $discount      = ($displayPrice < $originalPrice && $originalPrice > 0)
                    ? round((($originalPrice - $displayPrice) / $originalPrice) * 100) : null;
                $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;

                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
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
                            <p class="smhome-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                            @if($displayPrice < $originalPrice)
                                <p class="smhome-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                            @endif
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock"><i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left</p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>
                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}" class="smhome-p-atc" onclick="event.stopPropagation()">
                                    <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="smhome-p-atc" style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif

    {{-- ══ NEW ARRIVALS ══ --}}
    @if($newArrivals->isNotEmpty())
    <div class="smhome-sec-head">
        <h2>New Arrivals</h2>
        <a href="{{ url('new-arrivals') }}" class="smhome-see-all">SEE ALL <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($newArrivals as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}" class="smhome-p-wish" title="উইশলিস্টে যোগ করুন" onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>
                <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                    <div class="smhome-p-card">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img" src="{{ asset('uploads/products/'.$item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>
                            <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock"><i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left</p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>
                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}" class="smhome-p-atc" onclick="event.stopPropagation()">
                                    <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="smhome-p-atc" style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif

    {{-- ══ BEST SELLERS ══ --}}
    @if($bestSellers->isNotEmpty())
    <div class="smhome-sec-head" style="margin-top:6px">
        <h2>Best Sellers</h2>
        <a href="{{ url('best-sellers') }}" class="smhome-see-all">SEE ALL <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="smhome-prod-grid">
        @foreach ($bestSellers as $item)
            @php
                $discount = ($item->discount_price && $item->current_price > 0)
                    ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                $inStock  = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $revAvg   = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->avg('rating') ?? 0;
                $revCount = \App\Models\Producreview::where('product_id',$item->id)->where('is_approved',true)->count();
            @endphp
            <div style="position:relative">
                <a href="{{ route('wishlist.add', $item->id) }}" class="smhome-p-wish" title="উইশলিস্টে যোগ করুন" onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>
                <a href="{{ route('product.detail', $item->slug) }}" class="smhome-p-card-link">
                    <div class="smhome-p-card">
                        @if($discount)
                            <span class="smhome-p-badge">-{{ $discount }}%</span>
                        @endif
                        <div class="smhome-p-img-wrap">
                            <img class="smhome-p-img" src="{{ asset('uploads/products/'.$item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smhome-p-body">
                            <p class="smhome-p-name">{{ $item->name }}</p>
                            <p class="smhome-p-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="smhome-p-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <div class="smhome-p-meta">
                                @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                                    <p class="smhome-p-stock"><i class="bi bi-fire" style="font-size:10px"></i> {{ $item->stock }} left</p>
                                @endif
                                <div class="smhome-p-stars-row">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($revAvg) ? '-fill' : '' }} sm-star {{ $s <= round($revAvg) ? 'filled' : 'empty' }}"></i>
                                    @endfor
                                    <span class="smhome-p-rc">({{ $revCount }})</span>
                                </div>
                            </div>
                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}" class="smhome-p-atc" onclick="event.stopPropagation()">
                                    <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="smhome-p-atc" style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
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

@endsection
