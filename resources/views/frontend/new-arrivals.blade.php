{{-- resources/views/frontend/new-arrivals.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
/* ═══════════════════════════════════════════════════════════
   NEW ARRIVALS PAGE STYLES
═══════════════════════════════════════════════════════════ */
.na-ci, .na-ci * { box-sizing: border-box; }

/* ── Hero Banner ── */
.na-hero {
    background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
    border-radius: var(--rl);
    padding: 36px 36px;
    margin-bottom: 26px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 24px;
}
.na-hero::before {
    content: 'NEW';
    position: absolute;
    right: -20px; top: -20px;
    font-size: 160px; font-weight: 900;
    color: rgba(255,255,255,.04);
    line-height: 1;
    font-family: 'Fraunces', serif;
    pointer-events: none;
}
.na-hero__icon {
    width: 80px; height: 80px;
    background: rgba(255,255,255,.1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 36px; color: var(--gold);
    flex-shrink: 0;
    animation: na-star-spin 4s ease-in-out infinite;
    border: 2px solid rgba(255,255,255,.15);
}
@keyframes na-star-spin {
    0%,100% { transform: rotate(-8deg) scale(1); }
    50%     { transform: rotate(8deg) scale(1.06); }
}
.na-hero__text { position: relative; z-index: 2; }
.na-hero__eyebrow {
    font-size: 11px; font-weight: 800;
    letter-spacing: .22em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 8px;
}
.na-hero__title {
    font-family: 'Fraunces', serif;
    font-size: 38px; font-weight: 900;
    color: #fff; line-height: 1.1;
    margin-bottom: 10px;
}
.na-hero__title span { color: var(--gold); }
.na-hero__sub {
    font-size: 14px;
    color: rgba(255,255,255,.65);
    font-weight: 500;
}

/* ── Sort Bar ── */
.na-sort-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 12px 18px;
    margin-bottom: 20px;
    box-shadow: var(--sh1);
}
.na-sort-bar__label {
    font-size: 12px; font-weight: 800;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); flex-shrink: 0;
}
.na-sort-bar__info {
    font-size: 13px; font-weight: 600;
    color: var(--text); margin-left: auto;
}
.na-sort-bar__info span { color: var(--red); font-weight: 800; }

/* ── Timeline Badges ── */
.na-timeline {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.na-timeline-chip {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px; font-weight: 700;
    border: 1.5px solid var(--border);
    background: var(--white); color: var(--mid);
    cursor: pointer; transition: var(--t);
    text-decoration: none; white-space: nowrap;
}
.na-timeline-chip:hover,
.na-timeline-chip.active {
    border-color: #2c5364;
    background: #2c5364;
    color: #fff;
}

/* ── Section Label ── */
.na-sec-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0 14px;
    padding-bottom: 10px;
    border-bottom: 1.5px solid var(--border);
}
.na-sec-label h2 {
    font-family: 'Fraunces', serif;
    font-size: 20px; font-weight: 800;
    color: var(--dark);
}
.na-sec-label::before {
    content: '';
    width: 4px; height: 20px;
    background: var(--gold);
    border-radius: 3px; flex-shrink: 0;
}
.na-new-badge {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 10px; font-weight: 800;
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: .07em;
    text-transform: uppercase;
}

/* ── Product Grid ── */
.na-prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(188px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

/* ── Product Card ── */
.na-p-wrap { position: relative; }
.na-p-wish {
    position: absolute;
    top: 9px; right: 9px;
    width: 34px; height: 34px;
    background: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #bbb;
    box-shadow: 0 2px 8px rgba(0,0,0,.13);
    z-index: 10; border: none; cursor: pointer;
    transition: color .2s, background .2s, transform .2s;
    opacity: 0; pointer-events: none; text-decoration: none;
}
.na-p-wrap:hover .na-p-wish { opacity: 1; pointer-events: auto; }
.na-p-wish:hover { transform: scale(1.15); color: var(--red); background: #fff0f0; }
.na-p-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    overflow: hidden; position: relative;
    transition: var(--t);
    display: flex; flex-direction: column; height: 100%;
    text-decoration: none; color: inherit;
}
.na-p-card:hover {
    box-shadow: var(--sh3);
    transform: translateY(-5px);
    border-color: var(--border-d);
}
.na-p-new-tag {
    position: absolute;
    top: 10px; left: 10px;
    background: #0ea5e9; color: #fff;
    font-size: 9.5px; font-weight: 800;
    padding: 4px 9px; border-radius: 5px;
    letter-spacing: .07em; text-transform: uppercase;
    z-index: 2;
}
.na-p-disc-tag {
    position: absolute;
    top: 10px; right: 9px;
    background: var(--red); color: #fff;
    font-size: 9.5px; font-weight: 800;
    padding: 4px 8px; border-radius: 5px;
    z-index: 2;
}
.na-p-img-wrap { position: relative; overflow: hidden; }
.na-p-img {
    width: 100%; height: 165px; object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s cubic-bezier(.4,0,.2,1); display: block;
}
.na-p-card:hover .na-p-img { transform: scale(1.06); }
.na-p-body {
    padding: 12px 13px 13px;
    display: flex; flex-direction: column; flex: 1;
}
.na-p-arrived {
    font-size: 10px; font-weight: 700;
    color: #0ea5e9;
    letter-spacing: .06em; text-transform: uppercase;
    margin-bottom: 4px;
    display: flex; align-items: center; gap: 4px;
}
.na-p-name {
    font-size: 13.5px; font-weight: 600; color: var(--text);
    line-height: 1.48; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.na-p-price { font-size: 16px; font-weight: 900; color: var(--red); margin-bottom: 2px; }
.na-p-old   { font-size: 12px; color: var(--muted); text-decoration: line-through; margin-bottom: 8px; }
.na-p-stars { color: #f59e0b; font-size: 12.5px; margin-bottom: 10px; }
.na-p-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 10px 0;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--r);
    font-family: 'Nunito', sans-serif;
    font-size: 13px; font-weight: 700;
    cursor: pointer; transition: var(--t); margin-top: auto;
    text-decoration: none;
}
.na-p-atc:hover { background: var(--red-d); transform: translateY(-1px); box-shadow: 0 5px 14px rgba(200,16,46,.35); color: #fff; }
.na-p-atc.disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; }

/* ── Empty ── */
.na-empty {
    text-align: center;
    padding: 70px 20px;
    color: var(--muted);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
}
.na-empty i { font-size: 56px; display: block; margin-bottom: 14px; opacity: .25; }
.na-empty p { font-size: 15px; font-weight: 600; }

/* ── Pagination ── */
.na-pagination {
    display: flex; justify-content: center; gap: 6px; margin: 8px 0 32px;
}
.na-pagination a,
.na-pagination span {
    padding: 8px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    font-size: 13px; font-weight: 700;
    color: var(--mid); transition: var(--t); text-decoration: none;
}
.na-pagination a:hover { border-color: var(--red); color: var(--red); }
.na-pagination .active-page { border-color: var(--red); background: var(--red); color: #fff; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .na-hero { padding: 22px 18px; flex-direction: column; gap: 12px; text-align: center; }
    .na-hero__title { font-size: 28px; }
    .na-hero__icon { width: 60px; height: 60px; font-size: 28px; }
    .na-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .na-p-img { height: 140px; }
    .na-p-wish { opacity: 1; pointer-events: auto; }
}
@media (max-width: 420px) {
    .na-prod-grid { gap: 9px; }
    .na-p-img { height: 125px; }
}
</style>

<div class="na-ci content-area-inner">

    {{-- ══ Hero ══ --}}
    <div class="na-hero">
        <div class="na-hero__icon">
            <i class="bi bi-stars"></i>
        </div>
        <div class="na-hero__text">
            <p class="na-hero__eyebrow">✦ Fresh Collection</p>
            <h1 class="na-hero__title">নতুন <span>পণ্য</span> এসেছে</h1>
            <p class="na-hero__sub">সদ্য যোগ হওয়া সব নতুন পণ্য এখানে দেখুন</p>
        </div>
    </div>

    {{-- ══ Timeline Filter ══ --}}
    <div class="na-timeline">
        <a href="{{ url('new-arrivals') }}"
           class="na-timeline-chip {{ !request('when') ? 'active' : '' }}">
            সব নতুন পণ্য
        </a>
        <a href="{{ url('new-arrivals?when=week') }}"
           class="na-timeline-chip {{ request('when') === 'week' ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i> এই সপ্তাহ
        </a>
        <a href="{{ url('new-arrivals?when=month') }}"
           class="na-timeline-chip {{ request('when') === 'month' ? 'active' : '' }}">
            <i class="bi bi-calendar-month"></i> এই মাস
        </a>
    </div>

    {{-- ══ Info Bar ══ --}}
    <div class="na-sort-bar">
        <span class="na-sort-bar__label"><i class="bi bi-stars"></i> নতুন পণ্য</span>
        @if(isset($newArrivals))
        <span class="na-sort-bar__info">
            মোট <span>{{ $newArrivals->total() }}</span> টি নতুন পণ্য
        </span>
        @endif
    </div>

    {{-- ══ Section Label ══ --}}
    <div class="na-sec-label">
        <h2>সদ্য যোগ হয়েছে</h2>
        <span class="na-new-badge">NEW</span>
    </div>

    {{-- ══ Product Grid ══ --}}
    @if(isset($newArrivals) && $newArrivals->isNotEmpty())
    <div class="na-prod-grid">
        @foreach($newArrivals as $item)
            @php
                $displayPrice  = $item->discount_price ?? $item->current_price;
                $originalPrice = $item->current_price;
                $discount      = ($item->discount_price && $originalPrice > 0)
                    ? round((($originalPrice - $item->discount_price) / $originalPrice) * 100) : null;
                $inStock       = $item->is_unlimited || ($item->stock ?? 0) > 0;
                $arrivedAt     = $item->arrived_at ? \Carbon\Carbon::parse($item->arrived_at)->diffForHumans() : null;
            @endphp
            <div class="na-p-wrap">
                <a href="{{ route('wishlist.add', $item->id) }}"
                   class="na-p-wish"
                   onclick="event.stopPropagation()">
                    <i class="bi bi-heart"></i>
                </a>
                <a href="{{ route('product.detail', $item->slug) }}" class="na-p-card">
                    <span class="na-p-new-tag">NEW</span>
                    @if($discount)
                        <span class="na-p-disc-tag">-{{ $discount }}%</span>
                    @endif
                    <div class="na-p-img-wrap">
                        <img class="na-p-img"
                             src="{{ asset('uploads/products/' . $item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy"
                             onerror="this.src='{{ asset('default/no-image.png') }}'">
                    </div>
                    <div class="na-p-body">
                        @if($arrivedAt)
                            <p class="na-p-arrived">
                                <i class="bi bi-clock"></i> {{ $arrivedAt }}
                            </p>
                        @endif
                        <p class="na-p-name">{{ $item->name }}</p>
                        <p class="na-p-price">৳ {{ number_format($displayPrice, 0) }}</p>
                        @if($item->discount_price)
                            <p class="na-p-old">৳ {{ number_format($originalPrice, 0) }}</p>
                        @endif
                        <div class="na-p-stars">★★★★☆</div>
                        @if($inStock)
                            <a href="{{ route('cart.add', $item->id) }}"
                               class="na-p-atc"
                               onclick="event.stopPropagation()">
                                <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                            </a>
                        @else
                            <span class="na-p-atc disabled">
                                <i class="bi bi-x-circle"></i> স্টক নেই
                            </span>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($newArrivals->hasPages())
    <div class="na-pagination">
        @if($newArrivals->onFirstPage())
            <span>‹ আগে</span>
        @else
            <a href="{{ $newArrivals->previousPageUrl() }}">‹ আগে</a>
        @endif

        @foreach($newArrivals->links()->elements[0] as $page => $url)
            @if($page == $newArrivals->currentPage())
                <span class="active-page">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if($newArrivals->hasMorePages())
            <a href="{{ $newArrivals->nextPageUrl() }}">পরে ›</a>
        @else
            <span>পরে ›</span>
        @endif
    </div>
    @endif

    @else
    <div class="na-empty">
        <i class="bi bi-stars"></i>
        <p>এখন কোনো নতুন পণ্য নেই। শীঘ্রই আসছে!</p>
    </div>
    @endif

</div>

@endsection
