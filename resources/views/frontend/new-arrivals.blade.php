{{-- resources/views/frontend/new-arrivals.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
/* ══════════════════════════════════════════════════════
   NEW ARRIVALS — Fresh Modern Design
   Font: Hind Siliguri (Bengali) + Inter
══════════════════════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;600;700;800;900&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.na-page {
    max-width: 1140px;
    margin: 0 auto;
    padding: 24px 16px 60px;
    font-family: 'Hind Siliguri', 'Inter', sans-serif;
}

/* ══════════════════════════════════
   HERO BANNER
══════════════════════════════════ */
.na-hero {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 28px;
    background: #050d1a;
    padding: 44px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    min-height: 200px;
}

/* animated gradient mesh background */
.na-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 15% 50%, rgba(14,165,233,.28) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 20%, rgba(99,102,241,.22) 0%, transparent 50%),
        radial-gradient(ellipse at 60% 90%, rgba(16,185,129,.15) 0%, transparent 45%);
    pointer-events: none;
}

/* big watermark text */
.na-hero::after {
    content: 'NEW';
    position: absolute;
    right: 32px;
    top: 50%;
    transform: translateY(-50%);
    font-family: 'Inter', sans-serif;
    font-size: 120px;
    font-weight: 900;
    color: rgba(255,255,255,.04);
    letter-spacing: -4px;
    pointer-events: none;
    line-height: 1;
    user-select: none;
}

.na-hero__left { position: relative; z-index: 2; }

.na-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(14,165,233,.18);
    border: 1px solid rgba(14,165,233,.35);
    border-radius: 30px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #38bdf8;
    margin-bottom: 16px;
}

.na-hero__title {
    font-family: 'Inter', sans-serif;
    font-size: 42px;
    font-weight: 900;
    color: #ffffff;
    line-height: 1.08;
    margin-bottom: 12px;
    letter-spacing: -1px;
}
.na-hero__title .hl {
    background: linear-gradient(90deg, #38bdf8, #818cf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.na-hero__sub {
    font-size: 14px;
    color: rgba(255,255,255,.55);
    font-weight: 400;
    font-family: 'Hind Siliguri', sans-serif;
}

/* right side animated icon block */
.na-hero__right {
    position: relative;
    z-index: 2;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.na-hero__orb {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #6366f1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    color: #fff;
    animation: na-float 3.5s ease-in-out infinite;
    box-shadow: 0 0 40px rgba(14,165,233,.45), 0 0 80px rgba(99,102,241,.2);
}
@keyframes na-float {
    0%,100% { transform: translateY(0) rotate(-3deg); }
    50%      { transform: translateY(-10px) rotate(3deg); }
}
.na-hero__count {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 10px;
    padding: 6px 16px;
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,.75);
    font-family: 'Hind Siliguri', sans-serif;
    white-space: nowrap;
}
.na-hero__count b { color: #38bdf8; }

/* ══════════════════════════════════
   FILTER CHIPS
══════════════════════════════════ */
.na-filters {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.na-filter-chip {
    padding: 7px 18px;
    border-radius: 30px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all .2s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Hind Siliguri', sans-serif;
    cursor: pointer;
}
.na-filter-chip:hover,
.na-filter-chip.is-active {
    border-color: #0ea5e9;
    background: #0ea5e9;
    color: #fff;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(14,165,233,.3);
    transform: translateY(-1px);
}
.na-filter-chip .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: currentColor;
    opacity: .6;
}

/* ══════════════════════════════════
   SECTION HEADING
══════════════════════════════════ */
.na-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1.5px solid #f1f5f9;
}
.na-heading__left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.na-heading__bar {
    width: 4px;
    height: 24px;
    background: linear-gradient(180deg, #0ea5e9, #6366f1);
    border-radius: 3px;
    flex-shrink: 0;
}
.na-heading__title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    font-family: 'Inter', sans-serif;
}
.na-heading__badge {
    font-size: 9.5px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 4px 11px;
    border-radius: 20px;
    background: #e0f2fe;
    color: #0369a1;
}
.na-heading__total {
    font-size: 13px;
    color: #94a3b8;
    font-weight: 600;
    font-family: 'Hind Siliguri', sans-serif;
}
.na-heading__total span { color: #0ea5e9; font-weight: 800; }

/* ══════════════════════════════════
   PRODUCT GRID
══════════════════════════════════ */
.na-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

/* ══════════════════════════════════
   PRODUCT CARD
══════════════════════════════════ */
.na-wrap {
    position: relative;
    display: flex;
    flex-direction: column;
}

/* Wishlist button */
.na-wish {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,.92);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: #94a3b8;
    box-shadow: 0 2px 10px rgba(0,0,0,.12);
    z-index: 10;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
    opacity: 0;
    pointer-events: none;
    backdrop-filter: blur(4px);
}
.na-wrap:hover .na-wish { opacity: 1; pointer-events: auto; }
.na-wish:hover { transform: scale(1.18); color: #ef4444; background: #fff; }

/* Card */
.na-card {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 1px solid #e8edf2;
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    position: relative;
    transition: all .25s cubic-bezier(.4,0,.2,1);
}
.na-card:hover {
    box-shadow: 0 12px 32px rgba(0,0,0,.1);
    transform: translateY(-6px);
    border-color: #cbd5e1;
    text-decoration: none;
    color: inherit;
}

/* NEW badge — top left */
.na-badge-new {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(90deg, #0ea5e9, #6366f1);
    color: #fff;
    font-size: 9px;
    font-weight: 800;
    padding: 3px 9px;
    border-radius: 5px;
    letter-spacing: .1em;
    text-transform: uppercase;
    z-index: 2;
}

/* Discount badge — top right */
.na-badge-disc {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #ef4444;
    color: #fff;
    font-size: 9px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 5px;
    z-index: 2;
}

/* Image */
.na-img-wrap {
    width: 100%;
    height: 190px;
    overflow: hidden;
    background: #f8fafc;
    flex-shrink: 0;
}
.na-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .35s ease;
}
.na-card:hover .na-img { transform: scale(1.06); }

/* Body */
.na-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 13px 13px 14px;
    border-top: 1px solid #f1f5f9;
}

/* Arrived timestamp */
.na-arrived {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    font-weight: 700;
    color: #0ea5e9;
    letter-spacing: .05em;
    text-transform: uppercase;
    margin-bottom: 5px;
    font-family: 'Inter', sans-serif;
}

/* Name */
.na-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.5;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: calc(13px * 1.5 * 2);
    font-family: 'Hind Siliguri', sans-serif;
}

/* Price */
.na-price {
    font-size: 17px;
    font-weight: 800;
    color: #ef4444;
    margin-bottom: 2px;
    font-family: 'Inter', sans-serif;
    letter-spacing: -.3px;
}
.na-old {
    font-size: 12px;
    color: #94a3b8;
    text-decoration: line-through;
    margin-bottom: 7px;
    font-family: 'Inter', sans-serif;
}

/* Stars */
.na-stars {
    color: #f59e0b;
    font-size: 12px;
    letter-spacing: 1.5px;
    margin-bottom: 11px;
}

.na-spacer { flex: 1; min-height: 4px; }

/* Add to Cart */
.na-atc {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 10px 0;
    background: linear-gradient(90deg, #0ea5e9, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    font-family: 'Hind Siliguri', sans-serif;
    transition: all .2s ease;
    flex-shrink: 0;
    line-height: 1.4;
}
.na-atc:hover {
    background: linear-gradient(90deg, #0284c7, #4f46e5);
    color: #fff;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(14,165,233,.38);
    transform: translateY(-1px);
}
.na-atc--out {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
    pointer-events: none;
}

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.na-empty {
    text-align: center;
    padding: 64px 20px;
    background: #fff;
    border: 1.5px dashed #e2e8f0;
    border-radius: 16px;
}
.na-empty i { font-size: 52px; display: block; margin-bottom: 14px; color: #cbd5e1; }
.na-empty p { font-size: 15px; font-weight: 600; color: #64748b; font-family: 'Hind Siliguri', sans-serif; }

/* ══════════════════════════════════
   PAGINATION
══════════════════════════════════ */
.na-pages {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin: 4px 0 30px;
    flex-wrap: wrap;
}
.na-pages a,
.na-pages span {
    padding: 8px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    transition: all .18s;
    text-decoration: none;
    display: inline-block;
    line-height: 1.4;
    min-width: 38px;
    text-align: center;
}
.na-pages a:hover { border-color: #0ea5e9; color: #0ea5e9; background: #f0f9ff; }
.na-pages .is-cur { border-color: #0ea5e9; background: #0ea5e9; color: #fff; }
.na-pages span.disabled { opacity: .4; cursor: default; }

/* ══════════════════════════════════
   RESPONSIVE
══════════════════════════════════ */
@media (max-width: 900px) {
    .na-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .na-hero { padding: 28px 22px; flex-direction: column; gap: 20px; }
    .na-hero__title { font-size: 30px; }
    .na-hero__orb { width: 80px; height: 80px; font-size: 32px; }
    .na-hero::after { display: none; }
    .na-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .na-img-wrap { height: 155px; }
    .na-wish { opacity: 1; pointer-events: auto; }
}
@media (max-width: 420px) {
    .na-grid { gap: 9px; }
    .na-img-wrap { height: 130px; }
    .na-name { font-size: 12px; }
    .na-atc { font-size: 11.5px; padding: 9px 0; }
    .na-hero__title { font-size: 24px; }
}
</style>

<div class="na-page">

    {{-- ══════════ HERO ══════════ --}}
    <div class="na-hero">
        <div class="na-hero__left">
            <div class="na-hero__eyebrow">
                <i class="bi bi-stars"></i> Fresh Collection
            </div>
            <h1 class="na-hero__title">
                নতুন <span class="hl">পণ্য</span><br>এসেছে!
            </h1>
            <p class="na-hero__sub">সদ্য যোগ হওয়া সব নতুন পণ্য এখানে দেখুন</p>
        </div>
        <div class="na-hero__right">
            <div class="na-hero__orb">
                <i class="bi bi-box-seam"></i>
            </div>
            @if(isset($newArrivals))
                <div class="na-hero__count">
                    মোট <b>{{ $newArrivals->total() }}</b> টি পণ্য
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════ FILTER CHIPS ══════════ --}}
    <div class="na-filters">
        <a href="{{ url('new-arrivals') }}"
           class="na-filter-chip {{ !request('when') ? 'is-active' : '' }}">
            <span class="dot"></span> সব পণ্য
        </a>
        <a href="{{ url('new-arrivals?when=week') }}"
           class="na-filter-chip {{ request('when') === 'week' ? 'is-active' : '' }}">
            <i class="bi bi-calendar-week"></i> এই সপ্তাহ
        </a>
        <a href="{{ url('new-arrivals?when=month') }}"
           class="na-filter-chip {{ request('when') === 'month' ? 'is-active' : '' }}">
            <i class="bi bi-calendar-month"></i> এই মাস
        </a>
    </div>

    {{-- ══════════ SECTION HEADING ══════════ --}}
    <div class="na-heading">
        <div class="na-heading__left">
            <div class="na-heading__bar"></div>
            <h2 class="na-heading__title">সদ্য যোগ হয়েছে</h2>
            <span class="na-heading__badge">NEW</span>
        </div>
        @if(isset($newArrivals))
            <div class="na-heading__total">
                মোট <span>{{ $newArrivals->total() }}</span> পণ্য
            </div>
        @endif
    </div>

    {{-- ══════════ PRODUCT GRID ══════════ --}}
    @if(isset($newArrivals) && $newArrivals->isNotEmpty())

        <div class="na-grid">
            @foreach($newArrivals as $item)
                @php
                    $displayPrice  = $item->discount_price ?? $item->current_price;
                    $originalPrice = $item->current_price;
                    $discount      = ($item->discount_price && $originalPrice > 0)
                        ? round((($originalPrice - $item->discount_price) / $originalPrice) * 100) : null;
                    $inStock       = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    $arrivedAt     = isset($item->arrived_at)
                        ? \Carbon\Carbon::parse($item->arrived_at)->diffForHumans() : null;
                @endphp

                <div class="na-wrap">
                    {{-- Wishlist --}}
                    <a href="{{ route('wishlist.add', $item->id) }}"
                       class="na-wish"
                       onclick="event.stopPropagation(); event.preventDefault();"
                       title="উইশলিস্টে যোগ করুন">
                        <i class="bi bi-heart"></i>
                    </a>

                    <a href="{{ route('product.detail', $item->slug) }}" class="na-card">

                        {{-- NEW tag --}}
                        <span class="na-badge-new">NEW</span>

                        {{-- Discount tag --}}
                        @if($discount)
                            <span class="na-badge-disc">-{{ $discount }}%</span>
                        @endif

                        {{-- Image --}}
                        <div class="na-img-wrap">
                            <img class="na-img"
                                 src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('default/no-image.png') }}'">
                        </div>

                        {{-- Body --}}
                        <div class="na-body">
                            @if($arrivedAt)
                                <p class="na-arrived">
                                    <i class="bi bi-clock"></i> {{ $arrivedAt }}
                                </p>
                            @endif

                            <p class="na-name">{{ $item->name }}</p>

                            <p class="na-price">৳ {{ number_format($displayPrice, 0) }}</p>

                            @if($item->discount_price && $item->discount_price < $originalPrice)
                                <p class="na-old">৳ {{ number_format($originalPrice, 0) }}</p>
                            @endif

                            <div class="na-stars" aria-label="রেটিং">★★★★☆</div>

                            <div class="na-spacer"></div>

                            @if($inStock)
                                <a href="{{ route('cart.add', $item->id) }}"
                                   class="na-atc"
                                   onclick="event.stopPropagation()">
                                    <i class="bi bi-cart-plus-fill"></i> কার্টে যোগ করুন
                                </a>
                            @else
                                <span class="na-atc na-atc--out">
                                    <i class="bi bi-x-circle"></i> স্টক নেই
                                </span>
                            @endif
                        </div>

                    </a>
                </div>

            @endforeach
        </div>

        {{-- ══════════ PAGINATION ══════════ --}}
        @if($newArrivals->hasPages())
            <div class="na-pages">

                @if($newArrivals->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $newArrivals->previousPageUrl() }}">‹</a>
                @endif

                @foreach($newArrivals->links()->elements[0] as $page => $url)
                    @if($page == $newArrivals->currentPage())
                        <span class="is-cur">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($newArrivals->hasMorePages())
                    <a href="{{ $newArrivals->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif

            </div>
        @endif

    @else

        {{-- ══════════ EMPTY STATE ══════════ --}}
        <div class="na-empty">
            <i class="bi bi-box-seam"></i>
            <p>এখন কোনো নতুন পণ্য নেই। শীঘ্রই আসছে!</p>
        </div>

    @endif

</div>

@endsection
