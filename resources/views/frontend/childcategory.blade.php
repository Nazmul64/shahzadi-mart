{{-- resources/views/frontend/childcategory.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.chp *, .chp *::before, .chp *::after { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }
.chp h1, .chp h2, .chp h3 { font-family: 'Playfair Display', serif; }

/* ══ LAYOUT ══ */
.chp-layout {
    display: grid;
    grid-template-columns: 268px 1fr;
    gap: 22px;
    align-items: start;
}

/* ══ HERO BANNER ══ */
.chp-banner {
    position: relative;
    background: linear-gradient(135deg, #0d1f0a 0%, #1a3d12 55%, #122b0d 100%);
    border-radius: 16px;
    overflow: hidden;
    padding: 36px 44px;
    margin-bottom: 24px;
    min-height: 145px;
}
.chp-banner::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 75% at 92% 50%, rgba(34,197,94,.2), transparent),
        radial-gradient(ellipse 35% 55% at 8% 20%, rgba(200,16,46,.12), transparent);
}
.chp-banner::after {
    content: '';
    position: absolute;
    right: 40px; top: 50%; transform: translateY(-50%);
    width: 130px; height: 130px;
    border-radius: 50%;
    border: 30px solid rgba(34,197,94,.07);
}
.chp-banner-inner { position: relative; z-index: 1; }
.chp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    font-size: 12px; font-weight: 600;
    color: rgba(255,255,255,.4); margin-bottom: 14px;
}
.chp-breadcrumb a { color: rgba(255,255,255,.4); text-decoration: none; transition: color .2s; }
.chp-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.chp-breadcrumb .sep { font-size: 9px; }
.chp-breadcrumb .cur { color: rgba(255,255,255,.9); }
.chp-banner-row { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.chp-banner-left h1 { font-size: 28px; font-weight: 900; color: #fff; line-height: 1.15; }
.chp-banner-left h1 span {
    display: block; font-family: 'DM Sans', sans-serif;
    font-size: 11px; font-weight: 800;
    letter-spacing: .15em; text-transform: uppercase;
    color: rgba(34,197,94,.7); margin-bottom: 5px;
}
.chp-pill-row { display: flex; gap: 8px; flex-wrap: wrap; }
.chp-pill {
    padding: 6px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    color: rgba(255,255,255,.7);
    display: flex; align-items: center; gap: 6px;
}
.chp-pill strong { color: #fff; }
.chp-pill .dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }

/* ══ SIBLING CHILD CATEGORIES ══ */
.chp-siblings { margin-bottom: 22px; }
.chp-siblings-head {
    font-size: 11.5px; font-weight: 800;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--muted, #aaa); margin-bottom: 10px;
    display: flex; align-items: center; gap: 8px;
}
.chp-siblings-head::after { content: ''; flex: 1; height: 1px; background: var(--border, #ebebeb); }
.chp-siblings-scroll {
    display: flex; gap: 8px; overflow-x: auto;
    padding-bottom: 4px; scrollbar-width: none;
}
.chp-siblings-scroll::-webkit-scrollbar { display: none; }
.chp-sib {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 14px;
    background: var(--white, #fff);
    border: 1.5px solid var(--border, #ebebeb);
    border-radius: 10px; text-decoration: none;
    white-space: nowrap; flex-shrink: 0; transition: all .2s;
}
.chp-sib:hover { border-color: #22c55e; transform: translateY(-2px); box-shadow: 0 4px 14px rgba(34,197,94,.15); }
.chp-sib.current { background: #f0fdf4; border-color: #22c55e; }
.chp-sib-dot { width: 7px; height: 7px; border-radius: 50%; background: #d0d0d0; flex-shrink: 0; }
.chp-sib.current .chp-sib-dot { background: #22c55e; }
.chp-sib:hover .chp-sib-dot { background: #22c55e; }
.chp-sib-name { font-size: 12.5px; font-weight: 700; color: var(--mid, #555); }
.chp-sib.current .chp-sib-name { color: #15803d; }
.chp-sib:hover .chp-sib-name { color: #15803d; }

/* ══ TOOLBAR ══ */
.chp-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px; gap: 10px; flex-wrap: wrap;
    padding: 12px 16px;
    background: var(--white, #fff);
    border: 1px solid var(--border, #ebebeb);
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.chp-result-text { font-size: 13px; font-weight: 600; color: var(--muted, #aaa); }
.chp-result-text strong { color: var(--dark, #111); }
.chp-sort {
    padding: 8px 12px;
    border: 1.5px solid var(--border, #ebebeb);
    border-radius: 9px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 600;
    color: var(--text, #333);
    background: var(--light, #f8f8f8);
    cursor: pointer; outline: none;
}
.chp-sort:focus { border-color: #22c55e; }
.chp-view-btns { display: flex; gap: 4px; }
.chp-view-btn {
    width: 34px; height: 34px;
    border: 1.5px solid var(--border, #ebebeb);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: var(--muted, #aaa);
    cursor: pointer; transition: all .2s; background: var(--white, #fff);
}
.chp-view-btn.active, .chp-view-btn:hover { border-color: #22c55e; color: #22c55e; }

/* ══ PRODUCT GRID ══ */
.chp-prod-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(188px, 1fr));
    gap: 15px;
}
.chp-prod-grid.list-view { grid-template-columns: 1fr; }

/* ══ PRODUCT CARD ══ */
.chp-card {
    background: var(--white, #fff);
    border: 1px solid var(--border, #ebebeb);
    border-radius: 14px;
    overflow: hidden; position: relative;
    transition: all .28s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: chp-fadeup .4s ease both;
}
@keyframes chp-fadeup {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.chp-card:hover {
    box-shadow: 0 14px 40px rgba(0,0,0,.11);
    transform: translateY(-5px);
    border-color: rgba(34,197,94,.25);
}
.chp-badge {
    position: absolute; top: 10px; left: 10px; z-index: 3;
    background: var(--red, #c8102e); color: #fff;
    font-size: 10px; font-weight: 800;
    padding: 4px 9px; border-radius: 6px;
}
.chp-wish {
    position: absolute; top: 9px; right: 9px; z-index: 3;
    width: 34px; height: 34px;
    background: rgba(255,255,255,.95); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; color: #ccc;
    box-shadow: 0 2px 10px rgba(0,0,0,.12);
    border: none; cursor: pointer; transition: all .22s;
    opacity: 0; pointer-events: none;
}
.chp-card:hover .chp-wish, .chp-wish.wished { opacity: 1; pointer-events: auto; }
.chp-wish.wished { color: var(--red, #c8102e); background: #fff0f0; }
.chp-wish:hover { transform: scale(1.15); color: var(--red, #c8102e); }
.chp-img-wrap { position: relative; overflow: hidden; background: #f8f8f8; }
.chp-img {
    width: 100%; height: 168px; object-fit: cover; display: block;
    border-bottom: 1px solid var(--border, #ebebeb);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
}
.chp-card:hover .chp-img { transform: scale(1.07); }
.chp-quickview {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(13,31,10,.85); color: #fff;
    font-size: 12px; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    text-align: center; padding: 10px;
    transform: translateY(100%); transition: transform .25s ease;
    text-decoration: none; display: block; backdrop-filter: blur(4px);
}
.chp-card:hover .chp-quickview { transform: translateY(0); }
.chp-card-body { padding: 13px 14px 14px; display: flex; flex-direction: column; flex: 1; }
.chp-card-child {
    font-size: 10.5px; font-weight: 800;
    letter-spacing: .1em; text-transform: uppercase;
    color: #16a34a; margin-bottom: 5px;
}
.chp-card-name {
    font-size: 13.5px; font-weight: 600; color: var(--text, #333);
    line-height: 1.45; margin-bottom: 8px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.chp-card-stars { color: #f59e0b; font-size: 11.5px; margin-bottom: 8px; }
.chp-card-stars span { color: var(--muted, #aaa); font-size: 11px; margin-left: 3px; }
.chp-card-price { font-size: 17px; font-weight: 900; color: var(--red, #c8102e); display: block; }
.chp-card-old { font-size: 12px; color: var(--muted, #aaa); text-decoration: line-through; display: block; margin-top: 1px; margin-bottom: 11px; }
.chp-stock { margin-bottom: 10px; }
.chp-stock-label { font-size: 11px; font-weight: 700; color: #d97706; display: flex; align-items: center; gap: 4px; margin-bottom: 4px; }
.chp-stock-track { height: 3px; background: #f0f0f0; border-radius: 2px; overflow: hidden; }
.chp-stock-fill { height: 100%; background: linear-gradient(90deg,#f59e0b,#ef4444); border-radius: 2px; }
.chp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px 0;
    background: var(--red, #c8102e); color: #fff;
    border: none; border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 700;
    cursor: pointer; transition: all .22s;
    margin-top: auto; text-decoration: none;
}
.chp-atc:hover { background: #a50d25; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(200,16,46,.38); }

/* LIST VIEW */
.chp-prod-grid.list-view .chp-card { flex-direction: row; }
.chp-prod-grid.list-view .chp-img-wrap { width: 175px; flex-shrink: 0; }
.chp-prod-grid.list-view .chp-img { height: 140px; border-bottom: none; border-right: 1px solid var(--border,#ebebeb); }
.chp-prod-grid.list-view .chp-card-body { padding: 16px 18px; }
.chp-prod-grid.list-view .chp-card-name { -webkit-line-clamp: 1; font-size: 15px; }
.chp-prod-grid.list-view .chp-atc { max-width: 200px; }

/* EMPTY */
.chp-empty {
    text-align: center; padding: 80px 20px;
    background: var(--white, #fff);
    border: 1.5px dashed var(--border, #ebebeb);
    border-radius: 16px;
}
.chp-empty-icon { font-size: 52px; color: #e0e0e0; margin-bottom: 18px; display: block; animation: float 3s ease-in-out infinite; }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
.chp-empty h3 { font-size: 20px; color: var(--dark, #111); margin-bottom: 8px; font-family: 'Playfair Display', serif; }
.chp-empty p { font-size: 14px; color: var(--muted, #aaa); font-weight: 500; }
.chp-empty-link {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 18px; padding: 11px 24px;
    background: var(--red, #c8102e); color: #fff;
    border-radius: 10px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: all .2s;
}
.chp-empty-link:hover { background: #a50d25; transform: translateY(-2px); }

/* PAGINATION */
.chp-pagination { margin-top: 32px; display: flex; justify-content: center; }
.chp-pagination .pagination { display: flex; gap: 5px; list-style: none; padding: 0; margin: 0; }
.chp-pagination .page-item .page-link {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--border, #ebebeb);
    font-size: 13px; font-weight: 700;
    color: var(--mid, #555); text-decoration: none;
    transition: all .2s; background: var(--white, #fff);
}
.chp-pagination .page-item.active .page-link { background: var(--red, #c8102e); border-color: var(--red, #c8102e); color: #fff; box-shadow: 0 4px 12px rgba(200,16,46,.3); }
.chp-pagination .page-item .page-link:hover { border-color: #22c55e; color: #22c55e; }

@media(max-width:960px) { .chp-layout { grid-template-columns: 1fr; } .sidebar { display: none; } .chp-banner { padding: 24px 22px; } .chp-banner-left h1 { font-size: 22px; } }
@media(max-width:640px) { .chp-prod-grid { grid-template-columns: repeat(2,1fr); gap: 11px; } .chp-img { height: 140px; } .chp-prod-grid.list-view .chp-card { flex-direction: column; } .chp-prod-grid.list-view .chp-img-wrap { width: 100%; } .chp-prod-grid.list-view .chp-img { height: 145px; border-right: none; border-bottom: 1px solid var(--border,#ebebeb); } }
</style>

<div class="chp content-area-inner">

    {{-- ══ HERO BANNER ══ --}}
    <div class="chp-banner">
        <div class="chp-banner-inner">
            <div class="chp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('category.page', $category->slug) }}">{{ $category->category_name }}</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('subcategory.page', [$category->slug, $subCategory->slug]) }}">{{ $subCategory->sub_name }}</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <span class="cur">{{ $childCategory->child_sub_name }}</span>
            </div>
            <div class="chp-banner-row">
                <div class="chp-banner-left">
                    <h1>
                        <span>{{ $subCategory->sub_name }}</span>
                        {{ $childCategory->child_sub_name }}
                    </h1>
                </div>
                <div class="chp-pill-row">
                    <div class="chp-pill">
                        <div class="dot"></div>
                        <strong>{{ $products->total() }}</strong> Products
                    </div>
                    <div class="chp-pill">
                        <i class="bi bi-check2-circle" style="color:#22c55e;font-size:13px"></i>
                        In Stock Available
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="chp-layout">

        {{-- Sidebar --}}
        @include('frontend.pages.category')

        {{-- Main --}}
        <div>

            {{-- ── Sibling Child Categories ── --}}
            @if(isset($siblingChildren) && $siblingChildren->count() > 1)
            <div class="chp-siblings">
                <div class="chp-siblings-head">Related Types</div>
                <div class="chp-siblings-scroll">
                    @foreach($siblingChildren as $sib)
                    <a href="{{ route('childcategory.page', [$category->slug, $subCategory->slug, $sib->slug]) }}"
                       class="chp-sib {{ $sib->id === $childCategory->id ? 'current' : '' }}">
                        <div class="chp-sib-dot"></div>
                        <span class="chp-sib-name">{{ $sib->child_sub_name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Toolbar ── --}}
            <div class="chp-toolbar">
                <span class="chp-result-text">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                    of <strong>{{ $products->total() }}</strong> results
                </span>
                <div style="display:flex;gap:9px;align-items:center">
                    <select class="chp-sort">
                        <option>Default Sorting</option>
                        <option>Newest First</option>
                        <option>Price: Low → High</option>
                        <option>Price: High → Low</option>
                    </select>
                    <div class="chp-view-btns">
                        <button class="chp-view-btn active" onclick="chpView('grid')" id="chpGridBtn"><i class="bi bi-grid-3x3-gap"></i></button>
                        <button class="chp-view-btn" onclick="chpView('list')" id="chpListBtn"><i class="bi bi-list-ul"></i></button>
                    </div>
                </div>
            </div>

            {{-- ── Products ── --}}
            @if($products->isNotEmpty())
            <div class="chp-prod-grid" id="chpProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0)
                        ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                    $stockPct = ($item->stock && !$item->is_unlimited && $item->stock <= 50)
                        ? max(10, ($item->stock / 50) * 100) : null;
                @endphp
                <div class="chp-card" style="animation-delay:{{ $i * 0.05 }}s">
                    @if($discount) <span class="chp-badge">-{{ $discount }}%</span> @endif
                    <button class="chp-wish" onclick="chpWish(this)"><i class="bi bi-heart"></i></button>
                    <div class="chp-img-wrap">
                        <img class="chp-img"
                             src="{{ asset('uploads/products/' . $item->feature_image) }}"
                             alt="{{ $item->name }}" loading="lazy">
                        <a href="{{ route('product.detail', $item->slug) }}" class="chp-quickview">
                            <i class="bi bi-eye me-1"></i> Quick View
                        </a>
                    </div>
                    <div class="chp-card-body">
                        <div class="chp-card-child">{{ $childCategory->child_sub_name }}</div>
                        <div class="chp-card-name">{{ $item->name }}</div>
                        <div class="chp-card-stars">★★★★☆ <span>(0)</span></div>
                        <span class="chp-card-price">KSh {{ number_format($displayPrice, 0) }}</span>
                        @if($item->discount_price)
                            <span class="chp-card-old">KSh {{ number_format($item->current_price, 0) }}</span>
                        @endif
                        @if($stockPct !== null && $item->stock <= 20)
                        <div class="chp-stock">
                            <div class="chp-stock-label">
                                <i class="bi bi-fire" style="font-size:10px"></i>
                                Only {{ $item->stock }} left!
                            </div>
                            <div class="chp-stock-track">
                                <div class="chp-stock-fill" style="width:{{ 100 - $stockPct }}%"></div>
                            </div>
                        </div>
                        @endif
                        <a href="{{ route('product.detail', $item->slug) }}" class="chp-atc">
                            <i class="bi bi-cart-plus"></i> View Product
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="chp-pagination">{{ $products->links() }}</div>

            @else
            <div class="chp-empty">
                <i class="bi bi-inbox chp-empty-icon"></i>
                <h3>No Products Found</h3>
                <p>No products available in <strong>{{ $childCategory->child_sub_name }}</strong> yet.</p>
                <a href="{{ route('subcategory.page', [$category->slug, $subCategory->slug]) }}"
                   class="chp-empty-link">
                    <i class="bi bi-arrow-left"></i> Browse {{ $subCategory->sub_name }}
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function chpWish(btn) {
    btn.classList.toggle('wished');
    const i = btn.querySelector('i');
    i.classList.toggle('bi-heart'); i.classList.toggle('bi-heart-fill');
}
function chpView(v) {
    const grid = document.getElementById('chpProdGrid');
    document.getElementById('chpGridBtn').classList.toggle('active', v === 'grid');
    document.getElementById('chpListBtn').classList.toggle('active', v === 'list');
    grid.classList.toggle('list-view', v === 'list');
}
</script>

@endsection
