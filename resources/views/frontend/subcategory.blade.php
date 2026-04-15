{{-- resources/views/frontend/subcategory.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.sp *, .sp *::before, .sp *::after { box-sizing: border-box; }
.sp { font-family: 'Plus Jakarta Sans', sans-serif; }
.sp h1, .sp h2, .sp h3 { font-family: 'Fraunces', serif; }

:root {
    --red:     #d0152b;
    --red-dk:  #a80f22;
    --red-lt:  #fff0f2;
    --blue:    #2563eb;
    --blue-lt: #eff6ff;
    --dark:    #0e0e0f;
    --text:    #2c2c30;
    --mid:     #5a5a65;
    --muted:   #9a9aaa;
    --border:  #e8e8ef;
    --light:   #f6f6f9;
    --white:   #ffffff;
    --shadow:  0 2px 16px rgba(0,0,0,.07);
    --shadow-lg: 0 20px 60px rgba(0,0,0,.13);
    --radius:  14px;
}

/* ══ HERO BANNER ══ */
.sp-banner {
    position: relative;
    background: var(--dark);
    border-radius: 20px; overflow: hidden;
    padding: 40px 48px; margin-bottom: 28px;
    min-height: 165px;
}
.sp-banner-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 60% 80% at 100% 50%, rgba(37,99,235,.28) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at 5% 80%,  rgba(208,21,43,.15) 0%, transparent 55%),
        linear-gradient(160deg, #131520 0%, #0e0e0f 100%);
}
.sp-banner-ring {
    position: absolute; right: -40px; top: 50%; transform: translateY(-50%);
    width: 280px; height: 280px; border-radius: 50%; z-index: 1;
    border: 50px solid rgba(37,99,235,.07);
}
.sp-banner-ring2 {
    position: absolute; right: 80px; top: 50%; transform: translateY(-50%);
    width: 130px; height: 130px; border-radius: 50%; z-index: 1;
    border: 22px solid rgba(37,99,235,.05);
}
.sp-banner-inner { position: relative; z-index: 2; }

.sp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 11.5px; font-weight: 600; letter-spacing: .03em;
    color: rgba(255,255,255,.38); margin-bottom: 14px;
}
.sp-breadcrumb a { color: rgba(255,255,255,.38); text-decoration: none; transition: color .2s; }
.sp-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.sp-breadcrumb .sep { font-size: 8px; color: rgba(255,255,255,.2); }
.sp-breadcrumb .cur { color: rgba(255,255,255,.88); }

.sp-banner-row { display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 20px; }
.sp-banner-row h1 {
    font-size: 31px; font-weight: 900; color: #fff;
    line-height: 1.1; letter-spacing: -.02em;
}
.sp-banner-row h1 span {
    display: block; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px; font-weight: 800; letter-spacing: .16em;
    text-transform: uppercase; color: rgba(255,255,255,.4); margin-bottom: 5px;
}
.sp-banner-stats { display: flex; gap: 12px; flex-wrap: wrap; }
.sp-stat {
    text-align: center;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px; padding: 11px 20px; min-width: 80px;
}
.sp-stat strong { display: block; font-size: 24px; font-weight: 900; color: #fff; line-height: 1; margin-bottom: 3px; }
.sp-stat span { font-size: 10.5px; font-weight: 700; color: rgba(255,255,255,.38); text-transform: uppercase; letter-spacing: .09em; }

/* ══ LAYOUT ══ */
.sp-layout { display: grid; grid-template-columns: 1fr; }

/* ══ CHILD CHIPS ══ */
.sp-child-section { margin-bottom: 26px; }
.sp-section-head {
    font-size: 11px; font-weight: 800; letter-spacing: .14em;
    text-transform: uppercase; color: var(--muted);
    margin-bottom: 13px; display: flex; align-items: center; gap: 10px;
}
.sp-section-head::after { content: ''; flex: 1; height: 1.5px; background: var(--border); border-radius: 2px; }
.sp-child-scroll {
    display: flex; gap: 9px; overflow-x: auto; padding-bottom: 5px; scrollbar-width: none;
}
.sp-child-scroll::-webkit-scrollbar { display: none; }
.sp-child-chip {
    display: flex; align-items: center; gap: 7px;
    padding: 9px 18px; background: var(--white);
    border: 1.5px solid var(--border); border-radius: 11px;
    text-decoration: none; white-space: nowrap;
    transition: all .22s; flex-shrink: 0;
}
.sp-child-chip:hover {
    border-color: var(--red); box-shadow: 0 4px 18px rgba(208,21,43,.13);
    transform: translateY(-2px);
}
.sp-child-chip.active { background: var(--red); border-color: var(--red); }
.sp-child-chip-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--red); flex-shrink: 0; transition: background .2s;
}
.sp-child-chip.active .sp-child-chip-dot { background: #fff; }
.sp-child-chip-name { font-size: 13px; font-weight: 700; color: var(--mid); transition: color .2s; }
.sp-child-chip:hover .sp-child-chip-name { color: var(--red); }
.sp-child-chip.active .sp-child-chip-name { color: #fff; }

/* ══ TOOLBAR ══ */
.sp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; gap: 10px; flex-wrap: wrap;
    padding: 13px 18px; background: var(--white);
    border: 1.5px solid var(--border); border-radius: var(--radius);
    box-shadow: var(--shadow);
}
.sp-result-text { font-size: 13px; font-weight: 600; color: var(--muted); }
.sp-result-text strong { color: var(--dark); }
.sp-sort {
    padding: 8px 14px; border: 1.5px solid var(--border); border-radius: 9px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 600;
    color: var(--text); background: var(--light); cursor: pointer; outline: none;
    transition: border-color .2s;
}
.sp-sort:focus { border-color: var(--red); }
.sp-view-btns { display: flex; gap: 5px; }
.sp-view-btn {
    width: 36px; height: 36px; border: 1.5px solid var(--border);
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--muted); cursor: pointer;
    transition: all .2s; background: var(--white);
}
.sp-view-btn.active, .sp-view-btn:hover {
    border-color: var(--red); color: var(--red); background: var(--red-lt);
}

/* ══ PRODUCT GRID ══ */
.sp-prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(196px, 1fr));
    gap: 18px;
}
.sp-prod-grid.list-view { grid-template-columns: 1fr; }

/* ══ PRODUCT CARD ══ */
.sp-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; overflow: hidden; position: relative;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: sp-fadeup .45s ease both;
}
@keyframes sp-fadeup {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.sp-card:hover {
    box-shadow: var(--shadow-lg); transform: translateY(-6px);
    border-color: rgba(208,21,43,.22);
}
.sp-badge {
    position: absolute; top: 11px; left: 11px; z-index: 3;
    background: var(--red); color: #fff;
    font-size: 10px; font-weight: 800; letter-spacing: .04em;
    padding: 4px 10px; border-radius: 6px;
    box-shadow: 0 2px 8px rgba(208,21,43,.4);
}
.sp-wish {
    position: absolute; top: 10px; right: 10px; z-index: 3;
    width: 36px; height: 36px; background: rgba(255,255,255,.95);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #ccc; box-shadow: 0 2px 12px rgba(0,0,0,.12);
    border: none; cursor: pointer; transition: all .22s;
    opacity: 0; pointer-events: none;
}
.sp-card:hover .sp-wish, .sp-wish.wished { opacity: 1; pointer-events: auto; }
.sp-wish.wished { color: var(--red); background: #fff0f2; }
.sp-wish:hover { transform: scale(1.18); color: var(--red); }

.sp-img-wrap { position: relative; overflow: hidden; background: var(--light); }
.sp-img {
    width: 100%; height: 172px; object-fit: cover; display: block;
    border-bottom: 1.5px solid var(--border);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
.sp-card:hover .sp-img { transform: scale(1.06); }
.sp-quickview {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(10,22,40,.88); color: #fff;
    font-size: 11.5px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; text-align: center; padding: 11px;
    transform: translateY(100%); transition: transform .28s ease;
    backdrop-filter: blur(6px); text-decoration: none; display: block;
}
.sp-card:hover .sp-quickview { transform: translateY(0); }
.sp-card-body { padding: 14px 15px 15px; display: flex; flex-direction: column; flex: 1; }
.sp-card-sub {
    font-size: 10px; font-weight: 800; letter-spacing: .12em;
    text-transform: uppercase; color: var(--blue); margin-bottom: 5px;
}
.sp-card-name {
    font-size: 13.5px; font-weight: 600; color: var(--text);
    line-height: 1.45; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.sp-card-stars { color: #f59e0b; font-size: 11.5px; margin-bottom: 9px; letter-spacing: .05em; }
.sp-card-stars span { color: var(--muted); font-size: 11px; margin-left: 3px; }
.sp-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px; flex-wrap: wrap; }
.sp-card-price { font-size: 18px; font-weight: 800; color: var(--red); }
.sp-card-old { font-size: 12.5px; color: var(--muted); text-decoration: line-through; }
.sp-stock-note {
    font-size: 11px; font-weight: 700; color: #d97706;
    display: flex; align-items: center; gap: 4px; margin-bottom: 8px;
}
.sp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 12px 0; background: var(--red); color: #fff;
    border: none; border-radius: 11px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; cursor: pointer;
    transition: all .22s; margin-top: auto; text-decoration: none;
}
.sp-atc:hover {
    background: var(--red-dk); transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(208,21,43,.38); color: #fff;
}

/* LIST VIEW */
.sp-prod-grid.list-view .sp-card { flex-direction: row; }
.sp-prod-grid.list-view .sp-img-wrap { width: 185px; flex-shrink: 0; }
.sp-prod-grid.list-view .sp-img { height: 145px; border-bottom: none; border-right: 1.5px solid var(--border); }
.sp-prod-grid.list-view .sp-card-body { padding: 18px 20px; }
.sp-prod-grid.list-view .sp-card-name { -webkit-line-clamp: 1; font-size: 15.5px; }
.sp-prod-grid.list-view .sp-atc { max-width: 210px; }

/* EMPTY */
.sp-empty {
    text-align: center; padding: 90px 24px;
    background: var(--white); border: 2px dashed var(--border); border-radius: 20px;
}
.sp-empty-icon { font-size: 56px; color: #d8d8e8; margin-bottom: 20px; display: block; animation: float 3.5s ease-in-out infinite; }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
.sp-empty h3 { font-size: 22px; color: var(--dark); margin-bottom: 8px; }
.sp-empty p { font-size: 14px; color: var(--muted); font-weight: 500; }

/* PAGINATION */
.sp-pagination { margin-top: 36px; display: flex; justify-content: center; }
.sp-pagination .pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
.sp-pagination .page-item .page-link {
    width: 40px; height: 40px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--border); font-size: 13px; font-weight: 700;
    color: var(--mid); text-decoration: none; transition: all .2s;
    background: var(--white); font-family: 'Plus Jakarta Sans', sans-serif;
}
.sp-pagination .page-item.active .page-link {
    background: var(--red); border-color: var(--red); color: #fff;
    box-shadow: 0 4px 14px rgba(208,21,43,.35);
}
.sp-pagination .page-item .page-link:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }

/* RESPONSIVE */
@media(max-width:768px) {
    .sp-banner { padding: 28px 24px; }
    .sp-banner-row h1 { font-size: 24px; }
    .sp-banner-stats { display: none; }
}
@media(max-width:640px) {
    .sp-prod-grid { grid-template-columns: repeat(2,1fr); gap: 12px; }
    .sp-img { height: 145px; }
    .sp-prod-grid.list-view .sp-card { flex-direction: column; }
    .sp-prod-grid.list-view .sp-img-wrap { width: 100%; }
    .sp-prod-grid.list-view .sp-img { height: 148px; border-right: none; border-bottom: 1.5px solid var(--border); }
}
</style>

<div class="sp content-area-inner">

    {{-- ══ HERO BANNER ══ --}}
    <div class="sp-banner">
        <div class="sp-banner-bg"></div>
        <div class="sp-banner-ring"></div>
        <div class="sp-banner-ring2"></div>
        <div class="sp-banner-inner">
            <div class="sp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('category.page', $category->slug) }}">{{ $category->category_name }}</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <span class="cur">{{ $subCategory->sub_name }}</span>
            </div>
            <div class="sp-banner-row">
                <h1>
                    <span>{{ $category->category_name }}</span>
                    {{ $subCategory->sub_name }}
                </h1>
                <div class="sp-banner-stats">
                    <div class="sp-stat">
                        <strong>{{ $products->total() }}</strong>
                        <span>Products</span>
                    </div>
                    @if($subCategory->childCategories->count())
                    <div class="sp-stat">
                        <strong>{{ $subCategory->childCategories->count() }}</strong>
                        <span>Types</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="sp-layout">
        <div>

            {{-- ── Child Category Chips ── --}}
            @if($subCategory->childCategories->count())
            <div class="sp-child-section">
                <div class="sp-section-head">Filter by Type</div>
                <div class="sp-child-scroll">
                    <a href="{{ route('subcategory.page', [$category->slug, $subCategory->slug]) }}"
                       class="sp-child-chip active">
                        <div class="sp-child-chip-dot"></div>
                        <span class="sp-child-chip-name">All Types</span>
                    </a>
                    @foreach($subCategory->childCategories as $child)
                    <a href="{{ route('childcategory.page', [$category->slug, $subCategory->slug, $child->slug]) }}"
                       class="sp-child-chip">
                        <div class="sp-child-chip-dot"></div>
                        <span class="sp-child-chip-name">{{ $child->child_sub_name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Toolbar ── --}}
            <div class="sp-toolbar">
                <span class="sp-result-text">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                    of <strong>{{ $products->total() }}</strong> results
                </span>
                <div style="display:flex;gap:9px;align-items:center">
                    <select class="sp-sort">
                        <option>Default Sorting</option>
                        <option>Newest First</option>
                        <option>Price: Low → High</option>
                        <option>Price: High → Low</option>
                        <option>Best Rated</option>
                    </select>
                    <div class="sp-view-btns">
                        <button class="sp-view-btn active" onclick="spView('grid')" id="spGridBtn" title="Grid View"><i class="bi bi-grid-3x3-gap"></i></button>
                        <button class="sp-view-btn" onclick="spView('list')" id="spListBtn" title="List View"><i class="bi bi-list-ul"></i></button>
                    </div>
                </div>
            </div>

            {{-- ── Products ── --}}
            @if($products->isNotEmpty())
            <div class="sp-prod-grid" id="spProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                @endphp
                <div class="sp-card" style="animation-delay:{{ $i * 0.055 }}s">
                    @if($discount) <span class="sp-badge">-{{ $discount }}%</span> @endif
                    <button class="sp-wish" onclick="spWish(this)" title="Wishlist"><i class="bi bi-heart"></i></button>
                    <div class="sp-img-wrap">
                        <img class="sp-img"
                             src="{{ asset('uploads/products/' . $item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy">
                        <a href="{{ route('product.detail', $item->slug) }}" class="sp-quickview">
                            <i class="bi bi-eye me-1"></i> Quick View
                        </a>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-card-sub">{{ $subCategory->sub_name }}</div>
                        <div class="sp-card-name">{{ $item->name }}</div>
                        <div class="sp-card-stars">★★★★☆ <span>(0)</span></div>
                        <div class="sp-price-row">
                            <span class="sp-card-price">KSh {{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price)
                                <span class="sp-card-old">KSh {{ number_format($item->current_price, 0) }}</span>
                            @endif
                        </div>
                        @if(!$item->is_unlimited && $item->stock !== null && $item->stock <= 10)
                        <div class="sp-stock-note">
                            <i class="bi bi-fire" style="font-size:10px"></i> Only {{ $item->stock }} left!
                        </div>
                        @endif
                        <a href="{{ route('product.detail', $item->slug) }}" class="sp-atc">
                            <i class="bi bi-cart-plus"></i> View Product
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="sp-pagination">{{ $products->links() }}</div>

            @else
            <div class="sp-empty">
                <i class="bi bi-inbox sp-empty-icon"></i>
                <h3>No Products Found</h3>
                <p>No products available in <strong>{{ $subCategory->sub_name }}</strong> yet.</p>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function spWish(btn) {
    btn.classList.toggle('wished');
    const i = btn.querySelector('i');
    i.classList.toggle('bi-heart');
    i.classList.toggle('bi-heart-fill');
}
function spView(v) {
    const grid = document.getElementById('spProdGrid');
    document.getElementById('spGridBtn').classList.toggle('active', v === 'grid');
    document.getElementById('spListBtn').classList.toggle('active', v === 'list');
    grid.classList.toggle('list-view', v === 'list');
}
</script>

@endsection
