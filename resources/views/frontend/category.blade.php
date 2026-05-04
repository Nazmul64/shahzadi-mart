{{-- resources/views/frontend/category.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ══ BASE ══ */
.cp *, .cp *::before, .cp *::after { box-sizing: border-box; }
.cp {
    font-family: 'Plus Jakarta Sans', sans-serif;
    width: 100%;
    max-width: 100%;
    margin-top: 10px;
    padding: 0 10px;
}
.cp h1, .cp h2, .cp h3 { font-family: 'Fraunces', serif; }

/* ══ CSS VARS ══ */
.cp {
    --red:       #d0152b;
    --red-dk:    #a80f22;
    --red-lt:    #fff0f2;
    --dark:      #0e0e0f;
    --text:      #2c2c30;
    --mid:       #5a5a65;
    --muted:     #9a9aaa;
    --border:    #e8e8ef;
    --light:     #f6f6f9;
    --white:     #ffffff;
    --shadow:    0 2px 16px rgba(0,0,0,.07);
    --shadow-md: 0 8px 32px rgba(0,0,0,.10);
    --shadow-lg: 0 20px 60px rgba(0,0,0,.13);
    --radius:    14px;
}

/* ══ HERO BANNER ══ */
.cp-banner {
    position: relative;
    background: var(--dark);
    border-radius: 20px;
    overflow: hidden;
    padding: 38px 46px;
    margin-bottom: 26px;
    min-height: 166px;
    display: flex;
    align-items: center;
    gap: 26px;
}
.cp-banner-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 70% 90% at 100% 50%, rgba(208,21,43,.30) 0%, transparent 65%),
        radial-gradient(ellipse 40% 60% at 0% 0%,   rgba(255,255,255,.04) 0%, transparent 60%),
        linear-gradient(160deg, #161618 0%, #0e0e0f 100%);
}
.cp-banner-ring {
    position: absolute; right: -48px; top: 50%; transform: translateY(-50%);
    width: 310px; height: 310px; border-radius: 50%; z-index: 1;
    border: 52px solid rgba(208,21,43,.06);
}
.cp-banner-ring2 {
    position: absolute; right: 62px; top: 50%; transform: translateY(-50%);
    width: 154px; height: 154px; border-radius: 50%; z-index: 1;
    border: 22px solid rgba(208,21,43,.05);
}
.cp-banner-img {
    width: 100px; height: 100px;
    border-radius: 50%; object-fit: cover;
    border: 3px solid rgba(208,21,43,.55);
    box-shadow: 0 0 0 7px rgba(208,21,43,.1), 0 10px 36px rgba(0,0,0,.5);
    position: relative; z-index: 2; flex-shrink: 0;
}
.cp-banner-img-placeholder {
    width: 100px; height: 100px; border-radius: 50%; flex-shrink: 0;
    background: rgba(208,21,43,.14);
    border: 3px solid rgba(208,21,43,.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; color: rgba(208,21,43,.75);
    position: relative; z-index: 2;
}
.cp-banner-inner { position: relative; z-index: 2; flex: 1; min-width: 0; }
.cp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 11.5px; font-weight: 600; letter-spacing: .03em;
    color: rgba(255,255,255,.38); margin-bottom: 13px;
}
.cp-breadcrumb a { color: rgba(255,255,255,.38); text-decoration: none; transition: color .2s; }
.cp-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.cp-breadcrumb .sep { font-size: 8px; color: rgba(255,255,255,.2); }
.cp-breadcrumb .cur { color: rgba(255,255,255,.88); }
.cp-banner-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }
.cp-banner-text h1 {
    font-size: 34px; font-weight: 900; color: #fff;
    line-height: 1.08; margin-bottom: 12px; letter-spacing: -.02em;
}
.cp-banner-meta { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
.cp-meta-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 13px; border-radius: 20px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.10);
    font-size: 12px; font-weight: 700;
    color: rgba(255,255,255,.55);
}
.cp-meta-chip strong { color: var(--red); font-size: 14px; }

/* ══ MAIN LAYOUT ══ */
.cp-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 22px;
    align-items: start;
}

/* ══════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════ */
.cp-sidebar {
    position: sticky;
    top: 18px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cp-sw {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.cp-sw-head {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 18px;
    border-bottom: 1.5px solid var(--border);
    background: var(--light);
}
.cp-sw-head-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: var(--red-lt);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--red); flex-shrink: 0;
}
.cp-sw-head-title {
    font-size: 11px; font-weight: 800;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--dark); flex: 1;
}
.cp-sw-body { padding: 14px 16px; }

/* Subcategories */
.cp-sub-list { display: flex; flex-direction: column; gap: 4px; }
.cp-sub-item {
    display: flex; align-items: center; gap: 11px;
    padding: 9px 12px; border-radius: 10px;
    text-decoration: none; transition: all .22s;
    border: 1.5px solid transparent;
}
.cp-sub-item:hover { background: var(--red-lt); border-color: rgba(208,21,43,.18); }
.cp-sub-item.active { background: var(--red); border-color: var(--red); }
.cp-sub-img {
    width: 40px; height: 40px; border-radius: 9px;
    object-fit: cover; flex-shrink: 0;
    border: 1.5px solid var(--border); background: var(--light);
}
.cp-sub-item.active .cp-sub-img { border-color: rgba(255,255,255,.4); }
.cp-sub-icon {
    width: 40px; height: 40px; border-radius: 9px;
    background: var(--light); display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: var(--muted); border: 1.5px solid var(--border);
}
.cp-sub-name { font-size: 13px; font-weight: 700; color: var(--text); flex: 1; }
.cp-sub-item.active .cp-sub-name { color: #fff; }
.cp-sub-count { font-size: 10.5px; font-weight: 600; color: var(--muted); }
.cp-sub-item.active .cp-sub-count { color: rgba(255,255,255,.65); }

/* Price Filter */
.cp-range-wrap { margin-bottom: 16px; position: relative; }
.cp-range-track {
    position: relative; height: 5px;
    background: var(--border); border-radius: 4px; margin: 14px 0;
}
.cp-range-fill { position: absolute; height: 100%; background: var(--red); border-radius: 4px; left: 0%; right: 0%; }
input[type="range"].cp-slider {
    position: absolute; width: 100%; height: 5px; -webkit-appearance: none; appearance: none;
    background: transparent; pointer-events: none; top: 0;
}
input[type="range"].cp-slider::-webkit-slider-thumb {
    -webkit-appearance: none; appearance: none; width: 18px; height: 18px; border-radius: 50%;
    background: #fff; border: 2.5px solid var(--red); cursor: pointer; pointer-events: all;
    box-shadow: 0 2px 8px rgba(208,21,43,.28);
}
.cp-range-labels { display: flex; justify-content: space-between; font-size: 11.5px; font-weight: 700; color: var(--muted); margin-top: 6px; }
.cp-price-inputs { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
.cp-price-input {
    flex: 1; padding: 9px; border-radius: 9px; border: 1.5px solid var(--border);
    font-size: 13px; font-weight: 600; color: var(--text); background: var(--light); text-align: center;
}
.cp-price-btn {
    width: 100%; padding: 10px; border-radius: 9px; background: var(--red); color: #fff;
    border: none; font-size: 12.5px; font-weight: 700; cursor: pointer; transition: background .2s;
}

/* ══ CONTENT AREA ══ */
.cp-content { min-width: 0; }

.cp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    padding: 12px 16px; background: var(--white);
    border: 1.5px solid var(--border); border-radius: var(--radius);
    box-shadow: var(--shadow);
}
.cp-result-text { font-size: 13px; font-weight: 600; color: var(--muted); }
.cp-sort {
    padding: 8px 13px; border: 1.5px solid var(--border); border-radius: 9px;
    font-size: 13px; font-weight: 600; color: var(--text); background: var(--light);
}

/* ══ PRODUCT GRID (5 Columns) ══ */
.cp-prod-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

/* ══ PRODUCT CARD ══ */
.cp-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; overflow: hidden; position: relative;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: cp-fadeup .45s ease both;
}
@keyframes cp-fadeup { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
.cp-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-6px); border-color: rgba(208,21,43,.22); }

.cp-badge {
    position: absolute; top: 11px; left: 11px; z-index: 3;
    background: var(--red); color: #fff; font-size: 10px; font-weight: 800;
    padding: 4px 10px; border-radius: 6px;
}
.cp-wish {
    position: absolute; top: 10px; right: 10px; z-index: 3;
    width: 34px; height: 34px; background: rgba(255,255,255,.95);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #ccc; box-shadow: 0 2px 10px rgba(0,0,0,.12);
    border: none; cursor: pointer; transition: all .22s; opacity: 0;
}
.cp-card:hover .cp-wish, .cp-wish.wished { opacity: 1; }
.cp-wish.wished { color: var(--red); background: #fff0f2; }

.cp-img-wrap { position: relative; overflow: hidden; background: var(--light); }
.cp-img {
    width: 100%; height: 280px; object-fit: cover; display: block;
    border-bottom: 1.5px solid var(--border); transition: transform .4s; background: #f9fafb;
}
.cp-card:hover .cp-img { transform: scale(1.06); }

.cp-card-body { padding: 13px 14px 14px; display: flex; flex-direction: column; flex: 1; }
.cp-card-cat { font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--red); margin-bottom: 5px; }
.cp-card-name {
    font-size: 18px; font-weight: 800; color: var(--text); line-height: 1.4; margin-bottom: 9px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px;
}
.cp-card-stars { color: #f59e0b; font-size: 11px; margin-bottom: 8px; }
.cp-price-row { display: flex; align-items: baseline; gap: 7px; margin-bottom: 12px; }
.cp-card-price { font-size: 22px; font-weight: 900; color: var(--red); }
.cp-card-old { font-size: 13.5px; color: var(--muted); text-decoration: line-through; }

.cp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0; background: var(--red); color: #fff;
    border-radius: 11px; font-size: 12.5px; font-weight: 700; text-decoration: none;
}
.cp-atc:hover { background: var(--red-dk); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(208,21,43,.38); color: #fff; }

/* ══ MOBILE TOGGLE ══ */
.cp-sidebar-toggle {
    display: none; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 16px; background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--radius); margin-bottom: 14px; font-size: 13px; font-weight: 700; cursor: pointer;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .cp-prod-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .cp-prod-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { 
    .cp-layout { grid-template-columns: 240px 1fr; gap: 18px; } 
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
}
@media (max-width: 900px) {
    .cp-layout { grid-template-columns: 1fr; }
    .cp-sidebar { display: none; }
    .cp-sidebar.open { display: flex; }
    .cp-sidebar-toggle { display: flex; }
    .cp-banner { padding: 26px 22px; }
    .cp-banner-text h1 { font-size: 26px; }
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .cp-img { height: 220px; }
}
@media (max-width: 500px) {
    .cp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .cp-img { height: 180px; }
    .cp-card-name { font-size: 12px; }
}
</style>

<div class="cp">

    <div class="cp-banner">
        <div class="cp-banner-bg"></div>
        <div class="cp-banner-ring"></div>
        <div class="cp-banner-ring2"></div>

        @if($category->category_photo)
            <img class="cp-banner-img" src="{{ asset('uploads/category/' . $category->category_photo) }}" alt="{{ $category->category_name }}">
        @else
            <div class="cp-banner-img-placeholder"><i class="bi bi-grid"></i></div>
        @endif

        <div class="cp-banner-inner">
            <div class="cp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <span class="cur">{{ $category->category_name }}</span>
            </div>
            <div class="cp-banner-row">
                <div class="cp-banner-text">
                    <h1>{{ $category->category_name }}</h1>
                    <div class="cp-banner-meta">
                        <div class="cp-meta-chip">
                            <i class="bi bi-box2"></i> <strong>{{ $products->total() }}</strong> Products
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="cp-sidebar-toggle" onclick="document.getElementById('cpSidebar').classList.toggle('open')">
        <i class="bi bi-sliders"></i> Filters & Categories
        <i class="bi bi-chevron-down" style="margin-left:auto;font-size:11px;"></i>
    </button>

    <div class="cp-layout">

        <aside class="cp-sidebar" id="cpSidebar">
            @if($category->subCategories->count())
            <div class="cp-sw">
                <div class="cp-sw-head">
                    <div class="cp-sw-head-icon"><i class="bi bi-diagram-3"></i></div>
                    <span class="cp-sw-head-title">Subcategories</span>
                </div>
                <div class="cp-sw-body" style="padding:10px 12px;">
                    <div class="cp-sub-list">
                        <a href="{{ route('category.page', $category->slug) }}" class="cp-sub-item {{ !request('sub') ? 'active' : '' }}">
                            <div class="cp-sub-icon"><i class="bi bi-grid-fill"></i></div>
                            <span class="cp-sub-name">All Products</span>
                        </a>
                        @foreach($category->subCategories as $sub)
                        <a href="{{ route('subcategory.page', [$category->slug, $sub->slug]) }}" class="cp-sub-item">
                            @if(!empty($sub->sub_photo))
                                <img class="cp-sub-img" src="{{ asset('uploads/subcategory/' . $sub->sub_photo) }}" alt="">
                            @else
                                <div class="cp-sub-icon"><i class="bi bi-tag"></i></div>
                            @endif
                            <span class="cp-sub-name">{{ $sub->sub_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="cp-sw">
                <div class="cp-sw-head">
                    <div class="cp-sw-head-icon"><i class="bi bi-cash-stack"></i></div>
                    <span class="cp-sw-head-title">Price Range</span>
                </div>
                <div class="cp-sw-body">
                    <div class="cp-range-wrap">
                        <div class="cp-range-track" id="cpRangeTrack">
                            <div class="cp-range-fill" id="cpRangeFill"></div>
                            <input type="range" class="cp-slider" id="cpRangeMin" min="0" max="100000" value="0" step="500">
                            <input type="range" class="cp-slider" id="cpRangeMax" min="0" max="100000" value="100000" step="500">
                        </div>
                        <div class="cp-range-labels">
                            <span id="cpRangeMinLabel">৳ 0</span>
                            <span id="cpRangeMaxLabel">৳ 100,000</span>
                        </div>
                    </div>
                    <div class="cp-price-inputs">
                        <input type="number" class="cp-price-input" id="cpPriceMin" value="0">
                        <input type="number" class="cp-price-input" id="cpPriceMax" value="100000">
                    </div>
                    <button class="cp-price-btn" onclick="applyPriceFilter()">Apply Filter</button>
                </div>
            </div>
        </aside>

        <div class="cp-content">
            <div class="cp-toolbar">
                <span class="cp-result-text">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong>
                </span>
                <select class="cp-sort">
                    <option>Default Sorting</option>
                    <option>Newest First</option>
                </select>
            </div>

            @if($products->isNotEmpty())
            <div class="cp-prod-grid" id="cpProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount     = ($item->discount_price && $item->current_price > 0) ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                @endphp
                <div class="cp-card" style="animation-delay:{{ $i * 0.05 }}s">
                    @if($discount) <span class="cp-badge">-{{ $discount }}%</span> @endif
                    <button class="cp-wish" onclick="this.classList.toggle('wished')"><i class="bi bi-heart"></i></button>
                    <div class="cp-img-wrap">
                        <img class="cp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="cp-card-body">
                        <div class="cp-card-cat">{{ $category->category_name }}</div>
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-card-name">{{ $item->name }}</a>
                        <div class="cp-card-stars">★★★★☆</div>
                        <div class="cp-price-row">
                            <span class="cp-card-price">৳ {{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price) <span class="cp-card-old">৳ {{ number_format($item->current_price, 0) }}</span> @endif
                        </div>
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-atc">View Product</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cp-pagination">{{ $products->links() }}</div>
            @else
            <div class="cp-empty">
                <i class="bi bi-box-seam cp-empty-icon"></i>
                <h3>No Products Found</h3>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
(function () {
    const minEl = document.getElementById('cpRangeMin'), maxEl = document.getElementById('cpRangeMax');
    const fill = document.getElementById('cpRangeFill'), minInp = document.getElementById('cpPriceMin'), maxInp = document.getElementById('cpPriceMax');
    const minLbl = document.getElementById('cpRangeMinLabel'), maxLbl = document.getElementById('cpRangeMaxLabel');
    function update() {
        let lo = +minEl.value, hi = +maxEl.value;
        if(lo > hi - 1000) { minEl.value = hi - 1000; lo = hi - 1000; }
        const pct = v => (v / 100000) * 100;
        fill.style.left = pct(lo) + '%'; fill.style.right = (100 - pct(hi)) + '%';
        minLbl.textContent = '৳ ' + lo.toLocaleString(); maxLbl.textContent = '৳ ' + hi.toLocaleString();
        minInp.value = lo; maxInp.value = hi;
    }
    minEl.oninput = update; maxEl.oninput = update;
    update();
})();
function applyPriceFilter() {
    const min = document.getElementById('cpPriceMin').value, max = document.getElementById('cpPriceMax').value;
    const url = new URL(window.location.href);
    url.searchParams.set('min_price', min); url.searchParams.set('max_price', max);
    window.location.href = url.href;
}
</script>

@endsection
