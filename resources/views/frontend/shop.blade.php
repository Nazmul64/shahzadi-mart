{{-- resources/views/frontend/shop.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Syne:wght@700;800;900&display=swap');

/* ===== RESET & BASE ===== */
.smp-shop *,
.smp-shop *::before,
.smp-shop *::after {
    box-sizing: border-box;
}
.smp-shop {
    font-family: 'Hind Siliguri', sans-serif;
    --red: #e11d48;
    --red-dark: #be123c;
    --red-light: #fff1f2;
    --red-border: #fda4af;
    --dark: #0f0a0a;
    --gray: #6b7280;
    --border: #e5e7eb;
    --bg: #fafafa;
    --white: #ffffff;
    --card-shadow: 0 2px 12px rgba(0,0,0,0.07);
    --card-shadow-hover: 0 16px 40px rgba(0,0,0,0.14);
}
.smp-shop a { text-decoration: none; color: inherit; }
.smp-shop ul { list-style: none; margin: 0; padding: 0; }
.smp-shop p, .smp-shop h1, .smp-shop h2, .smp-shop h3 { margin: 0; padding: 0; }

/* ===== FLASH MESSAGES ===== */
.smp-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 18px;
}
.smp-flash--success { background: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
.smp-flash--error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

/* ===== BREADCRUMB ===== */
.smp-breadcrumb {
    font-size: 13px;
    color: var(--gray);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.smp-breadcrumb a { color: var(--gray); transition: color 0.2s; }
.smp-breadcrumb a:hover { color: var(--red); }
.smp-breadcrumb .current { color: var(--red); font-weight: 700; }

/* ===== HERO ===== */
.smp-hero {
    background: linear-gradient(135deg, #12040a 0%, #2d0a14 45%, #1a0509 100%);
    border-radius: 20px;
    padding: 50px 44px;
    margin-bottom: 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 50px rgba(0,0,0,0.4);
}
.smp-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -100px;
    width: 340px; height: 340px;
    background: radial-gradient(circle, rgba(225,29,72,0.25) 0%, transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.smp-hero::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -70px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(200,16,46,0.15) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.smp-hero-grid {
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}
.smp-hero-text { position: relative; z-index: 2; max-width: 460px; }
.smp-hero-text h1 {
    font-family: 'Syne', sans-serif;
    font-size: 46px;
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    margin-bottom: 10px;
    letter-spacing: -0.02em;
}
.smp-hero-text p {
    color: rgba(255,255,255,0.65);
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
}
.smp-hero-count {
    position: relative;
    z-index: 2;
    text-align: right;
}
.smp-hero-count-num {
    font-family: 'Syne', sans-serif;
    font-size: 80px;
    font-weight: 900;
    color: var(--red);
    line-height: 1;
    text-shadow: 0 8px 30px rgba(225,29,72,0.5);
    display: block;
}
.smp-hero-count-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-top: 6px;
}

/* ===== TOOLBAR ===== */
.smp-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 24px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px 22px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
.smp-toolbar-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.smp-toolbar-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    white-space: nowrap;
}
.smp-sort-select {
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 9px 36px 9px 14px;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Hind Siliguri', sans-serif;
    background: #f9fafb;
    color: var(--dark);
    min-width: 200px;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%239ca3af' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-color: #f9fafb;
}
.smp-sort-select:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.1); }
.smp-toolbar-info {
    font-size: 13px;
    color: var(--gray);
    font-weight: 600;
    white-space: nowrap;
}

/* ===== LAYOUT ===== */
.smp-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
}

/* ===== SIDEBAR ===== */
.smp-sidebar {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 24px;
    box-shadow: var(--card-shadow);
    position: sticky;
    top: 24px;
}
.smp-sidebar-title {
    font-family: 'Syne', sans-serif;
    font-size: 16px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.smp-sidebar-bar {
    width: 4px;
    height: 20px;
    background: linear-gradient(to bottom, var(--red), var(--red-dark));
    border-radius: 4px;
    flex-shrink: 0;
}

/* Filter Sections */
.smp-filter-sec {
    margin-bottom: 22px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}
.smp-filter-sec:last-of-type { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
.smp-filter-sec-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.13em;
    text-transform: uppercase;
    color: var(--gray);
    margin-bottom: 12px;
}

/* Category List */
.smp-cat-list li { margin-bottom: 2px; }
.smp-cat-list a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--dark);
    transition: background 0.2s, color 0.2s, transform 0.15s;
}
.smp-cat-list a:hover,
.smp-cat-list a.active {
    background: var(--red-light);
    color: var(--red);
    transform: translateX(4px);
    font-weight: 600;
}
.smp-cat-count {
    font-size: 11px;
    font-weight: 700;
    background: #f3f4f6;
    color: var(--gray);
    padding: 2px 7px;
    border-radius: 20px;
    transition: background 0.2s, color 0.2s;
}
.smp-cat-list a.active .smp-cat-count,
.smp-cat-list a:hover .smp-cat-count { background: #ffe4e6; color: var(--red); }

/* Price Row */
.smp-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 2px;
}
.smp-price-sep { font-size: 16px; color: var(--gray); flex-shrink: 0; }
.smp-price-input {
    flex: 1;
    min-width: 0;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    padding: 9px 10px;
    font-size: 13px;
    font-weight: 600;
    font-family: 'Hind Siliguri', sans-serif;
    background: #f9fafb;
    color: var(--dark);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.smp-price-input::placeholder { font-weight: 400; color: #d1d5db; }
.smp-price-input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.1); }

/* Search */
.smp-search-row { display: flex; gap: 8px; }
.smp-search-input {
    flex: 1;
    min-width: 0;
    border: 1.5px solid var(--border);
    border-radius: 9px;
    padding: 9px 10px;
    font-size: 13px;
    font-weight: 500;
    font-family: 'Hind Siliguri', sans-serif;
    background: #f9fafb;
    color: var(--dark);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.smp-search-input::placeholder { font-weight: 400; color: #d1d5db; }
.smp-search-input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(225,29,72,0.1); }
.smp-search-btn {
    padding: 9px 14px;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: 9px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s, transform 0.15s;
    flex-shrink: 0;
}
.smp-search-btn:hover { background: var(--red-dark); transform: scale(1.05); }

/* Apply Button */
.smp-apply-btn {
    display: block;
    width: 100%;
    margin-top: 12px;
    padding: 12px;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Hind Siliguri', sans-serif;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    letter-spacing: 0.02em;
}
.smp-apply-btn:hover { background: var(--red-dark); transform: translateY(-1px); }

/* Reset Link */
.smp-reset-link {
    display: block;
    text-align: center;
    margin-top: 16px;
    padding: 11px;
    font-size: 13px;
    font-weight: 700;
    color: var(--gray);
    border: 1px solid var(--border);
    border-radius: 10px;
    transition: all 0.2s;
}
.smp-reset-link:hover { color: var(--red); border-color: var(--red-border); background: var(--red-light); }

/* ===== PRODUCT GRID ===== */
.smp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 18px;
}

/* ===== PRODUCT CARD ===== */
.smp-card-wrap {
    position: relative;
}

/* Badges */
.smp-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 4;
    padding: 4px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    pointer-events: none;
}
.smp-badge--discount { background: var(--red); color: #fff; }
.smp-badge--new      { background: #16a34a; color: #fff; }

/* Wishlist Button */
.smp-wish-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 4;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.95);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    color: #9ca3af;
    opacity: 0;
    transform: scale(0.75);
    transition: opacity 0.2s, transform 0.2s, color 0.15s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    text-decoration: none;
}
.smp-card-wrap:hover .smp-wish-btn { opacity: 1; transform: scale(1); }
.smp-wish-btn:hover { color: var(--red); }

/* Card Shell — div (NOT <a>) to avoid nested anchor bug */
.smp-card {
    display: flex;
    flex-direction: column;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.3s cubic-bezier(0.4,0,0.2,1),
                border-color 0.3s;
    cursor: pointer;
}
.smp-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--card-shadow-hover);
    border-color: var(--red-border);
}

/* Image */
.smp-img-wrap {
    position: relative;
    overflow: hidden;
    height: 180px;
    background: #f3f4f6;
    flex-shrink: 0;
    display: block;
}
.smp-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.smp-card:hover .smp-img { transform: scale(1.07); }

/* Card Body */
.smp-card-body {
    padding: 14px 14px 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
}

/* Product Name */
.smp-card-name {
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.5;
    color: #1a1a1a;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 40px;
    text-decoration: none;
}
.smp-card-name:hover { color: var(--red); }

/* Price */
.smp-card-price {
    font-family: 'Syne', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: var(--red);
    line-height: 1;
    margin-bottom: 4px;
}
.smp-card-old {
    font-size: 12px;
    color: #9ca3af;
    text-decoration: line-through;
    margin-bottom: 10px;
    line-height: 1;
}

/* Meta */
.smp-card-meta { margin-bottom: 12px; }
.smp-card-stock-warn {
    font-size: 11.5px;
    color: #d97706;
    font-weight: 700;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.smp-card-stars {
    font-size: 12px;
    color: #f59e0b;
    letter-spacing: 1px;
    display: block;
}

/* ATC Button */
.smp-atc-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    font-family: 'Hind Siliguri', sans-serif;
    cursor: pointer;
    border: none;
    margin-top: auto;
    text-decoration: none;
    transition: background 0.2s, transform 0.18s, box-shadow 0.2s, color 0.2s;
    white-space: nowrap;
    letter-spacing: 0.01em;
}
.smp-atc-btn--active {
    background: var(--red);
    color: #fff !important;
}
.smp-atc-btn--active:hover {
    background: var(--red-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(225,29,72,0.32);
    color: #fff !important;
}
.smp-atc-btn--disabled {
    background: #f3f4f6;
    color: #9ca3af !important;
    cursor: not-allowed;
    pointer-events: none;
}

/* ===== EMPTY STATE ===== */
.smp-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 30px;
    color: var(--gray);
}
.smp-empty-icon {
    font-size: 60px;
    margin-bottom: 16px;
    display: block;
    opacity: 0.5;
}
.smp-empty h3 {
    font-family: 'Syne', sans-serif;
    font-size: 20px;
    font-weight: 800;
    color: #374151;
    margin-bottom: 8px;
}
.smp-empty p { font-size: 14px; }

/* ===== PAGINATION ===== */
.smp-pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
.smp-pagination .page-link {
    border-radius: 10px !important;
    padding: 9px 15px;
    font-weight: 600;
    font-size: 13.5px;
    transition: all 0.2s;
    font-family: 'Hind Siliguri', sans-serif;
}
.smp-pagination .page-item.active .page-link { background: var(--red); border-color: var(--red); }
.smp-pagination .page-link:hover { background: var(--red-light); color: var(--red); border-color: var(--red-border); }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .smp-layout { grid-template-columns: 1fr; }
    .smp-sidebar { position: static; }
}
@media (max-width: 680px) {
    .smp-hero { padding: 34px 22px; flex-direction: column; text-align: center; }
    .smp-hero-text h1 { font-size: 30px; }
    .smp-hero-count-num { font-size: 56px; }
    .smp-hero-count { text-align: center; }
    .smp-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .smp-img-wrap { height: 150px; }
}
@media (max-width: 400px) {
    .smp-hero-text h1 { font-size: 24px; }
    .smp-card-name { font-size: 12.5px; }
    .smp-card-price { font-size: 17px; }
}
</style>

<div class="smp-shop content-area-inner">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="smp-flash smp-flash--success">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="smp-flash smp-flash--error">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Breadcrumb --}}
    <nav class="smp-breadcrumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i> হোম</a>
        <span>/</span>
        <span class="current" aria-current="page">শপ</span>
    </nav>

    {{-- Hero --}}
    <div class="smp-hero">
        <div class="smp-hero-grid"></div>
        <div class="smp-hero-text">
            <h1>আমাদের শপ</h1>
            <p>প্রিমিয়াম কোয়ালিটির সকল পণ্য এক ছাদের নিচে</p>
        </div>
        <div class="smp-hero-count">
            <span class="smp-hero-count-num">{{ $products->total() }}</span>
            <span class="smp-hero-count-label">টি পণ্য পাওয়া গেছে</span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="smp-toolbar">
        <div class="smp-toolbar-left">
            <span class="smp-toolbar-label">সাজানো:</span>
            <form method="GET" action="{{ url('shop') }}" id="smpSortForm">
                @foreach(['category','search','min_price','max_price'] as $param)
                    @if(request($param))
                        <input type="hidden" name="{{ $param }}" value="{{ request($param) }}">
                    @endif
                @endforeach
                <select name="sort" class="smp-sort-select" onchange="this.form.submit()" aria-label="পণ্য সাজানো">
                    @php
                        $sorts = [
                            'latest'     => 'সর্বশেষ যোগ হয়েছে',
                            'price_low'  => 'দাম: কম → বেশি',
                            'price_high' => 'দাম: বেশি → কম',
                            'name_asc'   => 'নাম (A → Z)',
                            'discount'   => 'সর্বোচ্চ ছাড়',
                        ];
                        $currentSort = request('sort', 'latest');
                    @endphp
                    @foreach($sorts as $val => $label)
                        <option value="{{ $val }}" {{ $currentSort === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="smp-toolbar-info">
            {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
            <span style="color:#d1d5db;">of</span>
            {{ $products->total() }} পণ্য
        </div>
    </div>

    {{-- Layout --}}
    <div class="smp-layout">

        {{-- Sidebar --}}
        <aside class="smp-sidebar" aria-label="ফিল্টার প্যানেল">
            <div class="smp-sidebar-title">
                <div class="smp-sidebar-bar"></div>
                <i class="bi bi-sliders2-vertical"></i>
                ফিল্টার
            </div>

            <form method="GET" action="{{ url('shop') }}" id="smpFilterForm">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                {{-- Categories --}}
                @if(isset($categories) && $categories->isNotEmpty())
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">ক্যাটাগরি</div>
                    <ul class="smp-cat-list">
                        <li>
                            <a href="{{ url('shop') }}{{ request('sort') ? '?sort='.request('sort') : '' }}"
                               class="{{ !request('category') ? 'active' : '' }}">
                                <span>সব পণ্য</span>
                                <span class="smp-cat-count">{{ $products->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ url('shop') }}?category={{ $cat->slug }}{{ request('sort') ? '&sort='.request('sort') : '' }}"
                               class="{{ request('category') === $cat->slug ? 'active' : '' }}">
                                <span>{{ $cat->category_name }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">দামের রেঞ্জ</div>
                    <div class="smp-price-row">
                        <input type="number"
                               name="min_price"
                               class="smp-price-input"
                               placeholder="সর্বনিম্ন"
                               value="{{ request('min_price') }}"
                               min="0"
                               aria-label="সর্বনিম্ন দাম">
                        <span class="smp-price-sep">–</span>
                        <input type="number"
                               name="max_price"
                               class="smp-price-input"
                               placeholder="সর্বোচ্চ"
                               value="{{ request('max_price') }}"
                               min="0"
                               aria-label="সর্বোচ্চ দাম">
                    </div>
                    <button type="submit" class="smp-apply-btn">
                        <i class="bi bi-funnel-fill"></i> ফিল্টার প্রয়োগ করুন
                    </button>
                </div>

                {{-- Search --}}
                <div class="smp-filter-sec">
                    <div class="smp-filter-sec-title">পণ্য খুঁজুন</div>
                    <div class="smp-search-row">
                        <input type="text"
                               name="search"
                               class="smp-search-input"
                               placeholder="নাম বা কীওয়ার্ড..."
                               value="{{ request('search') }}"
                               aria-label="পণ্য সার্চ">
                        <button type="submit" class="smp-search-btn" aria-label="সার্চ করুন">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                {{-- Reset --}}
                <a href="{{ url('shop') }}" class="smp-reset-link">
                    <i class="bi bi-arrow-counterclockwise"></i> সব ফিল্টার রিসেট
                </a>
            </form>
        </aside>

        {{-- Products --}}
        <main>
            <div class="smp-grid">
                @forelse($products as $item)
                    @php
                        $displayPrice  = $item->discount_price ?? $item->current_price;
                        $originalPrice = $item->current_price;
                        $hasDiscount   = $displayPrice < $originalPrice && $originalPrice > 0;
                        $discountPct   = $hasDiscount
                            ? round((($originalPrice - $displayPrice) / $originalPrice) * 100)
                            : null;
                        $inStock  = $item->is_unlimited || (($item->stock ?? 0) > 0);
                        $lowStock = !$item->is_unlimited && isset($item->stock) && $item->stock > 0 && $item->stock <= 8;
                    @endphp

                    {{-- Card Wrapper --}}
                    <div class="smp-card-wrap">

                        {{-- Discount / New Badge --}}
                        @if($discountPct)
                            <span class="smp-badge smp-badge--discount">-{{ $discountPct }}% OFF</span>
                        @elseif(!empty($item->is_new_arrival))
                            <span class="smp-badge smp-badge--new">NEW</span>
                        @endif

                        {{-- Wishlist Button --}}
                        <a href="{{ route('wishlist.add', $item->id) }}"
                           class="smp-wish-btn"
                           title="উইশলিস্টে যোগ করুন"
                           aria-label="উইশলিস্টে যোগ করুন">
                            <i class="bi bi-heart"></i>
                        </a>

                        {{--
                            ✅ FIX: Card is a <div> — NOT an <a>.
                            Nested <a> tags are invalid HTML and break layout.
                            Image and title each have their own <a> link.
                        --}}
                        <div class="smp-card"
                             onclick="window.location='{{ route('product.detail', $item->slug) }}'"
                             role="article"
                             aria-label="{{ $item->name }}">

                            {{-- Product Image (link) --}}
                            <a href="{{ route('product.detail', $item->slug) }}"
                               class="smp-img-wrap"
                               tabindex="-1"
                               aria-hidden="true">
                                <img class="smp-img"
                                     src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                     alt="{{ $item->name }}"
                                     loading="lazy"
                                     width="300"
                                     height="180">
                            </a>

                            {{-- Card Body --}}
                            <div class="smp-card-body">

                                {{-- Product Name (link) --}}
                                <a href="{{ route('product.detail', $item->slug) }}"
                                   class="smp-card-name"
                                   onclick="event.stopPropagation()">
                                    {{ $item->name }}
                                </a>

                                {{-- Current Price --}}
                                <p class="smp-card-price">৳&nbsp;{{ number_format($displayPrice, 0) }}</p>

                                {{-- Original Price (if discounted) --}}
                                @if($hasDiscount)
                                    <p class="smp-card-old">৳&nbsp;{{ number_format($originalPrice, 0) }}</p>
                                @endif

                                {{-- Meta: Stock Warning + Stars --}}
                                <div class="smp-card-meta">
                                    @if($lowStock)
                                        <p class="smp-card-stock-warn">
                                            <i class="fas fa-fire"></i>
                                            মাত্র {{ $item->stock }}টি বাকি
                                        </p>
                                    @endif
                                    <span class="smp-card-stars" aria-label="রেটিং ৪/৫">★★★★☆</span>
                                </div>

                                {{-- Add to Cart / Out of Stock Button --}}
                                @if($inStock)
                                    <a href="{{ route('cart.add', $item->id) }}"
                                       class="smp-atc-btn smp-atc-btn--active"
                                       onclick="event.stopPropagation()"
                                       aria-label="{{ $item->name }} কার্টে যোগ করুন">
                                        <i class="fas fa-shopping-cart"></i>
                                        কার্টে যোগ করুন
                                    </a>
                                @else
                                    <span class="smp-atc-btn smp-atc-btn--disabled"
                                          aria-label="স্টক আউট">
                                        <i class="fas fa-times-circle"></i>
                                        স্টক আউট
                                    </span>
                                @endif

                            </div>{{-- /.smp-card-body --}}
                        </div>{{-- /.smp-card --}}
                    </div>{{-- /.smp-card-wrap --}}

                @empty
                    <div class="smp-empty">
                        <span class="smp-empty-icon" aria-hidden="true">🛍️</span>
                        <h3>কোনো পণ্য মিলেনি</h3>
                        <p>ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="smp-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </main>

    </div>{{-- /.smp-layout --}}
</div>{{-- /.smp-shop --}}

@endsection
