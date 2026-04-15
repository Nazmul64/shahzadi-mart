{{-- resources/views/frontend/category.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ══ BASE ══ */
.cp *, .cp *::before, .cp *::after { box-sizing: border-box; }
.cp { font-family: 'Plus Jakarta Sans', sans-serif; }
.cp h1, .cp h2, .cp h3 { font-family: 'Fraunces', serif; }

:root {
    --red:     #d0152b;
    --red-dk:  #a80f22;
    --red-lt:  #fff0f2;
    --dark:    #0e0e0f;
    --text:    #2c2c30;
    --mid:     #5a5a65;
    --muted:   #9a9aaa;
    --border:  #e8e8ef;
    --light:   #f6f6f9;
    --white:   #ffffff;
    --shadow:  0 2px 16px rgba(0,0,0,.07);
    --shadow-md: 0 8px 32px rgba(0,0,0,.10);
    --shadow-lg: 0 20px 60px rgba(0,0,0,.13);
    --radius:  14px;
}

/* ══ HERO BANNER ══ */
.cp-banner {
    position: relative;
    background: var(--dark);
    border-radius: 20px;
    overflow: hidden;
    padding: 40px 48px;
    margin-bottom: 28px;
    min-height: 170px;
    display: flex;
    align-items: center;
    gap: 28px;
}
.cp-banner-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 70% 90% at 100% 50%, rgba(208,21,43,.32) 0%, transparent 65%),
        radial-gradient(ellipse 45% 70% at 0% 0%,   rgba(255,255,255,.04) 0%, transparent 60%),
        linear-gradient(160deg, #161618 0%, #0e0e0f 100%);
}
.cp-banner-noise {
    position: absolute; inset: 0; z-index: 1; opacity: .03;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
}
.cp-banner-ring {
    position: absolute; right: -50px; top: 50%; transform: translateY(-50%);
    width: 320px; height: 320px; border-radius: 50%; z-index: 1;
    border: 55px solid rgba(208,21,43,.07);
}
.cp-banner-ring2 {
    position: absolute; right: 60px; top: 50%; transform: translateY(-50%);
    width: 160px; height: 160px; border-radius: 50%; z-index: 1;
    border: 24px solid rgba(208,21,43,.05);
}

.cp-banner-img {
    width: 88px; height: 88px;
    border-radius: 50%; object-fit: cover;
    border: 3px solid rgba(208,21,43,.55);
    box-shadow: 0 0 0 7px rgba(208,21,43,.1), 0 10px 40px rgba(0,0,0,.5);
    position: relative; z-index: 2; flex-shrink: 0;
}
.cp-banner-img-placeholder {
    width: 88px; height: 88px; border-radius: 50%; flex-shrink: 0;
    background: rgba(208,21,43,.14);
    border: 3px solid rgba(208,21,43,.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; color: rgba(208,21,43,.75);
    position: relative; z-index: 2;
}
.cp-banner-inner { position: relative; z-index: 2; flex: 1; min-width: 0; }

.cp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 11.5px; font-weight: 600; letter-spacing: .03em;
    color: rgba(255,255,255,.38); margin-bottom: 14px;
}
.cp-breadcrumb a { color: rgba(255,255,255,.38); text-decoration: none; transition: color .2s; }
.cp-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.cp-breadcrumb .sep { font-size: 8px; color: rgba(255,255,255,.2); }
.cp-breadcrumb .cur { color: rgba(255,255,255,.88); }

.cp-banner-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.cp-banner-text h1 {
    font-size: 32px; font-weight: 900; color: #fff;
    line-height: 1.08; margin-bottom: 12px; letter-spacing: -.02em;
}
.cp-banner-meta { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.cp-meta-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 13px; border-radius: 20px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    font-size: 12px; font-weight: 700;
    color: rgba(255,255,255,.6);
}
.cp-meta-chip strong { color: var(--red); font-size: 14px; }

/* ══ LAYOUT ══ */
.cp-layout { display: grid; grid-template-columns: 1fr; gap: 0; }

/* ══ FILTER CHIPS ══ */
.cp-filter-bar {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    margin-bottom: 22px; padding-bottom: 18px;
    border-bottom: 1.5px solid var(--border);
}
.cp-filter-label {
    font-size: 10.5px; font-weight: 800; letter-spacing: .14em;
    text-transform: uppercase; color: var(--muted); margin-right: 2px;
}
.cp-chip {
    padding: 7px 17px; border-radius: 50px;
    border: 1.5px solid var(--border);
    font-size: 12.5px; font-weight: 700; color: var(--mid);
    text-decoration: none; transition: all .2s; white-space: nowrap;
    background: var(--white);
}
.cp-chip:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }
.cp-chip.active {
    background: var(--red); color: #fff; border-color: var(--red);
    box-shadow: 0 4px 16px rgba(208,21,43,.3);
}

/* ══ SUBCATEGORY CARDS ══ */
.cp-subcat-section { margin-bottom: 28px; }
.cp-section-head {
    font-size: 11px; font-weight: 800; letter-spacing: .14em;
    text-transform: uppercase; color: var(--muted);
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 10px;
}
.cp-section-head::after { content: ''; flex: 1; height: 1.5px; background: var(--border); border-radius: 2px; }
.cp-subcat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 12px;
}
.cp-subcat-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: var(--radius); padding: 18px 12px;
    text-align: center; text-decoration: none;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column; align-items: center; gap: 9px;
}
.cp-subcat-card:hover {
    border-color: var(--red);
    box-shadow: 0 8px 28px rgba(208,21,43,.12);
    transform: translateY(-4px);
}
.cp-subcat-card-icon {
    width: 48px; height: 48px; border-radius: 50%;
    background: var(--red-lt); color: var(--red);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; transition: all .22s;
}
.cp-subcat-card:hover .cp-subcat-card-icon { background: var(--red); color: #fff; }
.cp-subcat-card-name { font-size: 12px; font-weight: 700; color: var(--mid); line-height: 1.3; }
.cp-subcat-card:hover .cp-subcat-card-name { color: var(--red); }
.cp-subcat-card-count { font-size: 10.5px; color: var(--muted); font-weight: 600; }

/* ══ TOOLBAR ══ */
.cp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
    padding: 13px 18px;
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}
.cp-result-text { font-size: 13px; font-weight: 600; color: var(--muted); }
.cp-result-text strong { color: var(--dark); }
.cp-sort {
    padding: 8px 14px; border: 1.5px solid var(--border);
    border-radius: 9px; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: var(--text);
    background: var(--light); cursor: pointer; outline: none; transition: border-color .2s;
}
.cp-sort:focus { border-color: var(--red); }
.cp-view-btns { display: flex; gap: 5px; }
.cp-view-btn {
    width: 36px; height: 36px; border: 1.5px solid var(--border);
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--muted); cursor: pointer;
    transition: all .2s; background: var(--white);
}
.cp-view-btn.active, .cp-view-btn:hover {
    border-color: var(--red); color: var(--red); background: var(--red-lt);
}

/* ══ PRODUCT GRID ══ */
.cp-prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(196px, 1fr));
    gap: 18px;
}
.cp-prod-grid.list-view { grid-template-columns: 1fr; }

/* ══ PRODUCT CARD ══ */
.cp-card {
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 16px; overflow: hidden; position: relative;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: cp-fadeup .45s ease both;
}
@keyframes cp-fadeup {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.cp-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-6px);
    border-color: rgba(208,21,43,.22);
}
.cp-badge {
    position: absolute; top: 11px; left: 11px; z-index: 3;
    background: var(--red); color: #fff;
    font-size: 10px; font-weight: 800; letter-spacing: .04em;
    padding: 4px 10px; border-radius: 6px;
    box-shadow: 0 2px 8px rgba(208,21,43,.4);
}
.cp-wish {
    position: absolute; top: 10px; right: 10px; z-index: 3;
    width: 36px; height: 36px; background: rgba(255,255,255,.95);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #ccc; box-shadow: 0 2px 12px rgba(0,0,0,.12);
    border: none; cursor: pointer; transition: all .22s;
    opacity: 0; pointer-events: none;
}
.cp-card:hover .cp-wish, .cp-wish.wished { opacity: 1; pointer-events: auto; }
.cp-wish.wished { color: var(--red); background: #fff0f2; }
.cp-wish:hover { transform: scale(1.18); color: var(--red); }

.cp-img-wrap { position: relative; overflow: hidden; background: var(--light); }
.cp-img {
    width: 100%; height: 172px; object-fit: cover; display: block;
    border-bottom: 1.5px solid var(--border);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
.cp-card:hover .cp-img { transform: scale(1.06); }
.cp-quickview {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(14,14,15,.88); color: #fff;
    font-size: 11.5px; font-weight: 800; letter-spacing: .08em;
    text-transform: uppercase; text-align: center; padding: 11px;
    transform: translateY(100%); transition: transform .28s ease;
    backdrop-filter: blur(6px); text-decoration: none; display: block;
}
.cp-card:hover .cp-quickview { transform: translateY(0); }

.cp-card-body { padding: 14px 15px 15px; display: flex; flex-direction: column; flex: 1; }
.cp-card-cat {
    font-size: 10px; font-weight: 800; letter-spacing: .12em;
    text-transform: uppercase; color: var(--red); margin-bottom: 5px;
}
.cp-card-name {
    font-size: 13.5px; font-weight: 600; color: var(--text);
    line-height: 1.45; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.cp-card-stars { color: #f59e0b; font-size: 11.5px; margin-bottom: 9px; letter-spacing: .05em; }
.cp-card-stars span { color: var(--muted); font-size: 11px; margin-left: 3px; font-family: 'Plus Jakarta Sans', sans-serif; }
.cp-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 2px; flex-wrap: wrap; }
.cp-card-price { font-size: 18px; font-weight: 800; color: var(--red); }
.cp-card-old { font-size: 12.5px; color: var(--muted); text-decoration: line-through; }
.cp-stock { margin: 10px 0; }
.cp-stock-label {
    font-size: 11px; font-weight: 700; color: #d97706;
    display: flex; align-items: center; gap: 4px; margin-bottom: 5px;
}
.cp-stock-track { height: 4px; background: #f0f0f0; border-radius: 3px; overflow: hidden; }
.cp-stock-fill { height: 100%; background: linear-gradient(90deg, #f59e0b, #ef4444); border-radius: 3px; }
.cp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 12px 0;
    background: var(--red); color: #fff; border: none; border-radius: 11px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 700; cursor: pointer;
    transition: all .22s; margin-top: auto; text-decoration: none;
}
.cp-atc:hover {
    background: var(--red-dk); transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(208,21,43,.38); color: #fff;
}

/* ══ LIST VIEW ══ */
.cp-prod-grid.list-view .cp-card { flex-direction: row; }
.cp-prod-grid.list-view .cp-img-wrap { width: 185px; flex-shrink: 0; }
.cp-prod-grid.list-view .cp-img { height: 145px; border-bottom: none; border-right: 1.5px solid var(--border); }
.cp-prod-grid.list-view .cp-card-body { padding: 18px 20px; }
.cp-prod-grid.list-view .cp-card-name { -webkit-line-clamp: 1; font-size: 15.5px; }
.cp-prod-grid.list-view .cp-atc { max-width: 210px; }

/* ══ EMPTY STATE ══ */
.cp-empty {
    text-align: center; padding: 90px 24px;
    background: var(--white); border: 2px dashed var(--border); border-radius: 20px;
}
.cp-empty-icon {
    font-size: 56px; color: #d8d8e8; margin-bottom: 20px; display: block;
    animation: float 3.5s ease-in-out infinite;
}
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
.cp-empty h3 { font-size: 22px; color: var(--dark); margin-bottom: 8px; }
.cp-empty p { font-size: 14px; color: var(--muted); font-weight: 500; }

/* ══ PAGINATION ══ */
.cp-pagination { margin-top: 36px; display: flex; justify-content: center; }
.cp-pagination .pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
.cp-pagination .page-item .page-link {
    width: 40px; height: 40px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--border); font-size: 13px; font-weight: 700;
    color: var(--mid); text-decoration: none; transition: all .2s;
    background: var(--white); font-family: 'Plus Jakarta Sans', sans-serif;
}
.cp-pagination .page-item.active .page-link {
    background: var(--red); border-color: var(--red); color: #fff;
    box-shadow: 0 4px 14px rgba(208,21,43,.35);
}
.cp-pagination .page-item .page-link:hover { border-color: var(--red); color: var(--red); background: var(--red-lt); }

/* ══ RESPONSIVE ══ */
@media(max-width:768px) {
    .cp-banner { padding: 28px 24px; gap: 18px; }
    .cp-banner-text h1 { font-size: 25px; }
    .cp-banner-img, .cp-banner-img-placeholder { width: 68px; height: 68px; font-size: 24px; }
}
@media(max-width:640px) {
    .cp-prod-grid { grid-template-columns: repeat(2,1fr); gap: 12px; }
    .cp-img { height: 145px; }
    .cp-prod-grid.list-view .cp-card { flex-direction: column; }
    .cp-prod-grid.list-view .cp-img-wrap { width: 100%; }
    .cp-prod-grid.list-view .cp-img { height: 148px; border-right: none; border-bottom: 1.5px solid var(--border); }
}
</style>

<div class="cp content-area-inner">

    {{-- ══ HERO BANNER ══ --}}
    <div class="cp-banner">
        <div class="cp-banner-bg"></div>
        <div class="cp-banner-noise"></div>
        <div class="cp-banner-ring"></div>
        <div class="cp-banner-ring2"></div>

        @if($category->category_photo)
            <img class="cp-banner-img"
                 src="{{ asset('uploads/category/' . $category->category_photo) }}"
                 alt="{{ $category->category_name }}">
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
                            <i class="bi bi-box2" style="font-size:12px;color:rgba(255,255,255,.4)"></i>
                            <strong>{{ $products->total() }}</strong> Products
                        </div>
                        @if($category->subCategories->count())
                        <div class="cp-meta-chip">
                            <i class="bi bi-diagram-3" style="font-size:12px;color:rgba(255,255,255,.4)"></i>
                            <strong>{{ $category->subCategories->count() }}</strong> Subcategories
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="cp-layout">
        <div>

            {{-- ── Sub-Category Filter Chips ── --}}
            @if($category->subCategories->count())
            <div class="cp-filter-bar">
                <span class="cp-filter-label">Filter:</span>
                <a href="{{ route('category.page', $category->slug) }}" class="cp-chip active">All</a>
                @foreach($category->subCategories as $sub)
                    <a href="{{ route('subcategory.page', [$category->slug, $sub->slug]) }}"
                       class="cp-chip">{{ $sub->sub_name }}</a>
                @endforeach
            </div>
            @endif

            {{-- ── Sub Category Cards ── --}}
            @if($category->subCategories->count())
            <div class="cp-subcat-section">
                <div class="cp-section-head">Browse Subcategories</div>
                <div class="cp-subcat-grid">
                    @foreach($category->subCategories as $sub)
                    <a href="{{ route('subcategory.page', [$category->slug, $sub->slug]) }}"
                       class="cp-subcat-card">
                        <div class="cp-subcat-card-icon"><i class="bi bi-tag"></i></div>
                        <div class="cp-subcat-card-name">{{ $sub->sub_name }}</div>
                        <div class="cp-subcat-card-count">{{ $sub->childCategories->count() }} types</div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Toolbar ── --}}
            <div class="cp-toolbar">
                <span class="cp-result-text">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                    of <strong>{{ $products->total() }}</strong> results
                </span>
                <div style="display:flex;gap:9px;align-items:center">
                    <select class="cp-sort">
                        <option>Default Sorting</option>
                        <option>Newest First</option>
                        <option>Price: Low → High</option>
                        <option>Price: High → Low</option>
                        <option>Best Rated</option>
                    </select>
                    <div class="cp-view-btns">
                        <button class="cp-view-btn active" onclick="cpView('grid')" id="cpGridBtn" title="Grid View"><i class="bi bi-grid-3x3-gap"></i></button>
                        <button class="cp-view-btn" onclick="cpView('list')" id="cpListBtn" title="List View"><i class="bi bi-list-ul"></i></button>
                    </div>
                </div>
            </div>

            {{-- ── Products ── --}}
            @if($products->isNotEmpty())
            <div class="cp-prod-grid" id="cpProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $stockPct = ($item->stock && !$item->is_unlimited && $item->stock <= 50)
                        ? max(10, ($item->stock / 50) * 100) : null;
                @endphp
                <div class="cp-card" style="animation-delay:{{ $i * 0.055 }}s">
                    @if($discount) <span class="cp-badge">-{{ $discount }}%</span> @endif
                    <button class="cp-wish" onclick="cpWish(this)" title="Wishlist"><i class="bi bi-heart"></i></button>
                    <div class="cp-img-wrap">
                        <img class="cp-img"
                             src="{{ asset('uploads/products/' . $item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy">
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-quickview">
                            <i class="bi bi-eye me-1"></i> Quick View
                        </a>
                    </div>
                    <div class="cp-card-body">
                        <div class="cp-card-cat">{{ $category->category_name }}</div>
                        <div class="cp-card-name">{{ $item->name }}</div>
                        <div class="cp-card-stars">★★★★☆ <span>(0)</span></div>
                        <div class="cp-price-row">
                            <span class="cp-card-price">KSh {{ number_format($displayPrice, 0) }}</span>
                            @if($item->discount_price)
                                <span class="cp-card-old">KSh {{ number_format($item->current_price, 0) }}</span>
                            @endif
                        </div>
                        @if($stockPct !== null && $item->stock <= 20)
                        <div class="cp-stock">
                            <div class="cp-stock-label">
                                <i class="bi bi-fire" style="font-size:10px"></i>
                                Only {{ $item->stock }} left!
                            </div>
                            <div class="cp-stock-track">
                                <div class="cp-stock-fill" style="width:{{ 100 - $stockPct }}%"></div>
                            </div>
                        </div>
                        @endif
                        <a href="{{ route('product.detail', $item->slug) }}" class="cp-atc">
                            <i class="bi bi-cart-plus"></i> View Product
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cp-pagination">{{ $products->links() }}</div>

            @else
            <div class="cp-empty">
                <i class="bi bi-box-seam cp-empty-icon"></i>
                <h3>No Products Found</h3>
                <p>No products available in <strong>{{ $category->category_name }}</strong> yet.</p>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function cpWish(btn) {
    btn.classList.toggle('wished');
    const i = btn.querySelector('i');
    i.classList.toggle('bi-heart');
    i.classList.toggle('bi-heart-fill');
}
function cpView(v) {
    const grid = document.getElementById('cpProdGrid');
    document.getElementById('cpGridBtn').classList.toggle('active', v === 'grid');
    document.getElementById('cpListBtn').classList.toggle('active', v === 'list');
    grid.classList.toggle('list-view', v === 'list');
}
</script>

@endsection
