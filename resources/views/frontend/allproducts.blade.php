{{-- resources/views/frontend/allproducts.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.smp-allprod * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
.smp-allprod h1, .smp-allprod h2 { font-family: 'Playfair Display', serif; }

/* ── PAGE HEADER ── */
.smp-allprod-hero {
    background: linear-gradient(135deg, #111 0%, #1a0505 60%, #2d0808 100%);
    border-radius: var(--rm);
    padding: 36px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,.35);
}
.smp-allprod-hero::before {
    content: '';
    position: absolute;
    top: -40px; right: -60px;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,16,46,.22), transparent 70%);
}
.smp-allprod-hero-text h1 {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 6px;
    line-height: 1.1;
}
.smp-allprod-hero-text p {
    color: rgba(255,255,255,.55);
    font-size: 13.5px;
    font-weight: 500;
}
.smp-allprod-hero-count {
    font-family: 'Playfair Display', serif;
    font-size: 52px;
    font-weight: 900;
    color: var(--red);
    line-height: 1;
    text-shadow: 0 4px 24px rgba(200,16,46,.5);
}
.smp-allprod-hero-count span {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,.5);
    display: block;
    text-align: right;
    text-shadow: none;
    margin-top: 2px;
    letter-spacing: .12em;
    text-transform: uppercase;
}

/* ── TOOLBAR ── */
.smp-allprod-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 14px 18px;
    box-shadow: var(--sh1);
}
.smp-allprod-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    flex-wrap: wrap;
}
.smp-allprod-sort-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .1em;
    white-space: nowrap;
}
.smp-allprod-select {
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 8px 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    background: var(--light);
    cursor: pointer;
    outline: none;
    transition: border-color .2s;
}
.smp-allprod-select:focus { border-color: var(--red); }

.smp-allprod-filter-btn {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    background: var(--light);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: var(--mid);
    cursor: pointer;
    transition: all .2s;
}
.smp-allprod-filter-btn:hover {
    border-color: var(--red);
    color: var(--red);
}

.smp-allprod-view-btns {
    display: flex;
    gap: 6px;
    margin-left: auto;
}
.smp-allprod-view-btn {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    background: var(--light);
    color: var(--muted);
    cursor: pointer;
    font-size: 15px;
    transition: all .2s;
    text-decoration: none;
}
.smp-allprod-view-btn.active,
.smp-allprod-view-btn:hover {
    border-color: var(--red);
    color: var(--red);
    background: #fff0f0;
}

/* ── FILTER SIDEBAR (Drawer) ── */
.smp-allprod-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 20px;
    align-items: start;
}
.smp-allprod-sidebar {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    padding: 20px;
    box-shadow: var(--sh1);
    position: sticky;
    top: 16px;
}
.smp-allprod-sidebar-title {
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.smp-allprod-sidebar-title::before {
    content: '';
    width: 4px; height: 18px;
    background: var(--red);
    border-radius: 2px;
    flex-shrink: 0;
}
.smp-allprod-filter-sec {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}
.smp-allprod-filter-sec:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.smp-allprod-filter-sec h4 {
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .13em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
}
.smp-allprod-cat-list {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.smp-allprod-cat-list li a {
    font-size: 13px;
    font-weight: 600;
    color: var(--mid);
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 10px;
    border-radius: 7px;
    transition: all .18s;
}
.smp-allprod-cat-list li a:hover,
.smp-allprod-cat-list li a.active {
    background: #fff0f0;
    color: var(--red);
}
.smp-allprod-cat-count {
    background: var(--light);
    border-radius: 20px;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 8px;
    color: var(--muted);
}

/* Price Range */
.smp-allprod-price-inputs {
    display: flex;
    gap: 8px;
    align-items: center;
}
.smp-allprod-price-input {
    flex: 1;
    border: 1.5px solid var(--border);
    border-radius: 7px;
    padding: 7px 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
    background: var(--light);
    outline: none;
    width: 100%;
}
.smp-allprod-price-input:focus { border-color: var(--red); }
.smp-allprod-price-sep {
    font-size: 12px;
    color: var(--muted);
    flex-shrink: 0;
}
.smp-allprod-apply-btn {
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s;
}
.smp-allprod-apply-btn:hover { background: var(--red-d); }

/* Stock filter */
.smp-allprod-check-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.smp-allprod-check-list label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--mid);
    cursor: pointer;
}
.smp-allprod-check-list input[type="checkbox"] {
    accent-color: var(--red);
    width: 15px; height: 15px;
}

/* ── PRODUCT GRID ── */
.smp-allprod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 16px;
}

/* ── PRODUCT CARD ── */
.smp-ap-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    position: relative;
}
.smp-ap-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--rm);
    overflow: hidden;
    position: relative;
    transition: var(--t);
    display: flex;
    flex-direction: column;
    height: 100%;
}
.smp-ap-card:hover {
    box-shadow: var(--sh3);
    transform: translateY(-5px);
    border-color: var(--border-d);
}
.smp-ap-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: var(--red);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 9px;
    border-radius: 5px;
    letter-spacing: .04em;
    z-index: 2;
}
.smp-ap-new-badge {
    position: absolute;
    top: 10px; left: 10px;
    background: #059669;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 9px;
    border-radius: 5px;
    letter-spacing: .04em;
    z-index: 2;
}
.smp-ap-wish {
    position: absolute;
    top: 9px; right: 9px;
    width: 34px; height: 34px;
    background: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    color: #bbb;
    box-shadow: 0 2px 8px rgba(0,0,0,.13);
    z-index: 10;
    border: none;
    cursor: pointer;
    transition: color .2s, background .2s, transform .2s;
    opacity: 0;
    pointer-events: none;
    text-decoration: none;
}
.smp-ap-card:hover .smp-ap-wish {
    opacity: 1;
    pointer-events: auto;
}
.smp-ap-wish:hover {
    transform: scale(1.15);
    color: var(--red);
    background: #fff0f0;
}
.smp-ap-img-wrap { position: relative; overflow: hidden; }
.smp-ap-img {
    width: 100%; height: 165px;
    object-fit: cover;
    border-bottom: 1px solid var(--border);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: block;
}
.smp-ap-card:hover .smp-ap-img { transform: scale(1.06); }
.smp-ap-body {
    padding: 12px 13px 13px;
    display: flex; flex-direction: column; flex: 1;
}
.smp-ap-name {
    font-size: 13.5px; font-weight: 600;
    color: var(--text); line-height: 1.48;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.smp-ap-price {
    font-size: 16px; font-weight: 900;
    color: var(--red); margin-bottom: 2px;
}
.smp-ap-old {
    font-size: 12px; color: var(--muted);
    text-decoration: line-through; margin-bottom: 5px;
}
.smp-ap-stock {
    font-size: 11.5px; font-weight: 700;
    color: #d97706; margin-bottom: 5px;
}
.smp-ap-stars { color: #f59e0b; font-size: 12.5px; }
.smp-ap-meta { margin-bottom: 10px; }
.smp-ap-atc {
    display: flex; align-items: center; justify-content: center;
    gap: 7px; width: 100%; padding: 11px 0;
    background: var(--red); color: #fff;
    border: none; border-radius: var(--r);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    cursor: pointer; transition: var(--t);
    margin-top: auto; text-decoration: none;
}
.smp-ap-atc:hover {
    background: var(--red-d); color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(200,16,46,.35);
}

/* ── EMPTY STATE ── */
.smp-allprod-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 24px;
}
.smp-allprod-empty-icon {
    font-size: 56px;
    color: var(--border-d);
    margin-bottom: 16px;
}
.smp-allprod-empty h3 {
    font-family: 'Playfair Display', serif;
    font-size: 22px; color: var(--mid);
    margin-bottom: 8px;
}
.smp-allprod-empty p {
    font-size: 14px; color: var(--muted);
}

/* ── PAGINATION ── */
.smp-allprod-pagination {
    margin-top: 32px;
    display: flex;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}
.smp-allprod-pagination .page-item .page-link {
    border: 1.5px solid var(--border);
    border-radius: 8px !important;
    color: var(--mid);
    font-weight: 700;
    font-size: 13px;
    padding: 8px 14px;
    transition: all .2s;
}
.smp-allprod-pagination .page-item.active .page-link {
    background: var(--red);
    border-color: var(--red);
    color: #fff;
}
.smp-allprod-pagination .page-item .page-link:hover {
    border-color: var(--red);
    color: var(--red);
}

/* ── BREADCRUMB ── */
.smp-allprod-bc {
    display: flex; align-items: center; gap: 6px;
    margin-bottom: 18px; flex-wrap: wrap;
}
.smp-allprod-bc a {
    font-size: 12.5px; font-weight: 600;
    color: var(--muted); text-decoration: none;
    transition: color .2s;
}
.smp-allprod-bc a:hover { color: var(--red); }
.smp-allprod-bc span {
    font-size: 12px; color: var(--muted);
}
.smp-allprod-bc .current {
    font-size: 12.5px; font-weight: 700;
    color: var(--red);
}

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .smp-allprod-layout { grid-template-columns: 1fr; }
    .smp-allprod-sidebar { display: none; }
    .smp-ap-wish { opacity: 1; pointer-events: auto; }
}
@media (max-width: 640px) {
    .smp-allprod-grid { grid-template-columns: repeat(2, 1fr); gap: 11px; }
    .smp-ap-img { height: 140px; }
    .smp-allprod-hero { padding: 24px 20px; }
    .smp-allprod-hero-text h1 { font-size: 24px; }
    .smp-allprod-hero-count { font-size: 38px; }
}
@media (max-width: 420px) {
    .smp-ap-img { height: 130px; }
    .smp-ap-name { font-size: 12.5px; }
    .smp-ap-price { font-size: 15px; }
}
</style>

<div class="smp-allprod content-area-inner">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fff0f1;color:#e8192c;border:1px solid #fecdd3;padding:10px 18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:12px;border-radius:8px;">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="smp-allprod-bc">
        <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i> হোম</a>
        <span>/</span>
        <span class="current">সব পণ্য</span>
    </div>

    {{-- Hero Header --}}
    <div class="smp-allprod-hero">
        <div class="smp-allprod-hero-text">
            <h1>সব পণ্য</h1>
            <p>আমাদের সম্পূর্ণ পণ্য সংগ্রহ দেখুন</p>
        </div>
        <div class="smp-allprod-hero-count">
            {{ $products->total() }}
            <span>টি পণ্য পাওয়া গেছে</span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="smp-allprod-toolbar">
        <div class="smp-allprod-toolbar-left">
            <span class="smp-allprod-sort-label">সাজান:</span>
            <form method="GET" action="{{ url('all-products') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('min_price'))
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                @endif
                @if(request('max_price'))
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                @endif
                @if(request('in_stock'))
                    <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="sort" class="smp-allprod-select" onchange="this.form.submit()">
                    <option value="latest"     {{ request('sort','latest') == 'latest'     ? 'selected' : '' }}>সর্বশেষ</option>
                    <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>দাম: কম → বেশি</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>দাম: বেশি → কম</option>
                    <option value="name_asc"   {{ request('sort') == 'name_asc'   ? 'selected' : '' }}>নাম: A → Z</option>
                    <option value="discount"   {{ request('sort') == 'discount'   ? 'selected' : '' }}>সর্বোচ্চ ছাড়</option>
                </select>
            </form>
        </div>

        <div class="smp-allprod-view-btns">
            <span class="smp-allprod-view-btn active" title="Grid view">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </span>
        </div>
    </div>

    {{-- Main Layout --}}
    <div class="smp-allprod-layout">

        {{-- Sidebar Filters --}}
        <aside class="smp-allprod-sidebar">
            <div class="smp-allprod-sidebar-title">ফিল্টার করুন</div>

            <form method="GET" action="{{ url('all-products') }}" id="filterForm">
                <input type="hidden" name="sort" value="{{ request('sort','latest') }}">

                {{-- Categories --}}
                @if($categories->isNotEmpty())
                <div class="smp-allprod-filter-sec">
                    <h4>ক্যাটাগরি</h4>
                    <ul class="smp-allprod-cat-list">
                        <li>
                            <a href="{{ url('all-products') }}?sort={{ request('sort','latest') }}"
                               class="{{ !request('category') ? 'active' : '' }}">
                                সব ক্যাটাগরি
                                <span class="smp-allprod-cat-count">{{ $products->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ url('all-products') }}?category={{ $cat->slug }}&sort={{ request('sort','latest') }}"
                                   class="{{ request('category') == $cat->slug ? 'active' : '' }}">
                                    {{ $cat->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="smp-allprod-filter-sec">
                    <h4>দামের সীমা</h4>
                    <div class="smp-allprod-price-inputs">
                        <input type="number" name="min_price" placeholder="সর্বনিম্ন"
                               class="smp-allprod-price-input"
                               value="{{ request('min_price') }}">
                        <span class="smp-allprod-price-sep">—</span>
                        <input type="number" name="max_price" placeholder="সর্বোচ্চ"
                               class="smp-allprod-price-input"
                               value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="smp-allprod-apply-btn">
                        <i class="bi bi-funnel-fill"></i> ফিল্টার প্রয়োগ করুন
                    </button>
                </div>

                {{-- Stock --}}
                <div class="smp-allprod-filter-sec">
                    <h4>স্টক</h4>
                    <div class="smp-allprod-check-list">
                        <label>
                            <input type="checkbox" name="in_stock" value="1"
                                   {{ request('in_stock') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            শুধু স্টকে আছে এমন পণ্য
                        </label>
                    </div>
                </div>

                {{-- Search --}}
                <div class="smp-allprod-filter-sec">
                    <h4>পণ্য খুঁজুন</h4>
                    <div style="display:flex;gap:6px;">
                        <input type="text" name="search" placeholder="পণ্যের নাম..."
                               class="smp-allprod-price-input"
                               value="{{ request('search') }}"
                               style="flex:1">
                        <button type="submit" style="padding:7px 12px;background:var(--red);color:#fff;border:none;border-radius:7px;cursor:pointer;font-size:14px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                {{-- Reset --}}
                <a href="{{ url('all-products') }}"
                   style="display:flex;align-items:center;justify-content:center;gap:6px;font-size:12.5px;font-weight:700;color:var(--muted);text-decoration:none;margin-top:4px;transition:color .2s;"
                   onmouseover="this.style.color='var(--red)'" onmouseout="this.style.color='var(--muted)'">
                    <i class="bi bi-arrow-counterclockwise"></i> ফিল্টার রিসেট করুন
                </a>
            </form>
        </aside>

        {{-- Products --}}
        <div>
            <div class="smp-allprod-grid">
                @forelse($products as $item)
                    @php
                        $displayPrice  = $item->discount_price ?? $item->current_price;
                        $originalPrice = $item->current_price;
                        $discount = ($displayPrice < $originalPrice && $originalPrice > 0)
                            ? round((($originalPrice - $displayPrice) / $originalPrice) * 100)
                            : null;
                        $inStock = $item->is_unlimited || ($item->stock ?? 0) > 0;
                    @endphp

                    <div style="position:relative">
                        <a href="{{ route('wishlist.add', $item->id) }}"
                           class="smp-ap-wish"
                           title="উইশলিস্টে যোগ করুন"
                           onclick="event.stopPropagation()">
                            <i class="bi bi-heart"></i>
                        </a>

                        <a href="{{ route('product.detail', $item->slug) }}"
                           class="smp-ap-card-link">
                            <div class="smp-ap-card">
                                @if($discount)
                                    <span class="smp-ap-badge">-{{ $discount }}%</span>
                                @elseif($item->is_new_arrival)
                                    <span class="smp-ap-new-badge">NEW</span>
                                @endif

                                <div class="smp-ap-img-wrap">
                                    <img class="smp-ap-img"
                                         src="{{ asset('uploads/products/' . $item->feature_image) }}"
                                         alt="{{ $item->name }}" loading="lazy">
                                </div>
                                <div class="smp-ap-body">
                                    <p class="smp-ap-name">{{ $item->name }}</p>
                                    <p class="smp-ap-price">৳ {{ number_format($displayPrice, 0) }}</p>
                                    @if($displayPrice < $originalPrice)
                                        <p class="smp-ap-old">৳ {{ number_format($originalPrice, 0) }}</p>
                                    @endif
                                    <div class="smp-ap-meta">
                                        @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10 && $item->stock > 0)
                                            <p class="smp-ap-stock">
                                                <i class="fas fa-fire-flame-curved" style="font-size:10px"></i>
                                                {{ $item->stock }} টি বাকি
                                            </p>
                                        @endif
                                        <span class="smp-ap-stars">★★★★☆</span>
                                    </div>

                                    @if($inStock)
                                        <a href="{{ route('cart.add', $item->id) }}"
                                           class="smp-ap-atc"
                                           onclick="event.stopPropagation()">
                                            <i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন
                                        </a>
                                    @else
                                        <span class="smp-ap-atc"
                                              style="background:#e5e7eb;color:#9ca3af;cursor:not-allowed;">
                                            <i class="fas fa-times-circle"></i> স্টক নেই
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>

                @empty
                    <div class="smp-allprod-empty">
                        <div class="smp-allprod-empty-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h3>কোনো পণ্য পাওয়া যায়নি</h3>
                        <p>আপনার ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="smp-allprod-pagination">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>{{-- /.smp-allprod-layout --}}

</div>{{-- /.smp-allprod --}}

@endsection
