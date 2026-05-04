{{-- resources/views/frontend/subcategory.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.sp *, .sp *::before, .sp *::after { box-sizing: border-box; }
.sp { font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 10px; }
.sp h1, .sp h2, .sp h3 { font-family: 'Fraunces', serif; }

/* ══ HERO BANNER ══ */
.sp-banner {
    position: relative;
    background: #0e0e0f; border-radius: 20px; overflow: hidden; padding: 40px 48px; margin-bottom: 28px; min-height: 165px;
}
.sp-banner-bg {
    position: absolute; inset: 0; z-index: 0;
    background: radial-gradient(ellipse 60% 80% at 100% 50%, rgba(37,99,235,.28) 0%, transparent 60%), linear-gradient(160deg, #131520 0%, #0e0e0f 100%);
}
.sp-banner-inner { position: relative; z-index: 2; }
.sp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap; font-size: 11.5px; font-weight: 600; color: rgba(255,255,255,.38); margin-bottom: 14px;
}
.sp-breadcrumb a { color: rgba(255,255,255,.38); text-decoration: none; }
.sp-banner-row h1 { font-size: 31px; font-weight: 900; color: #fff; line-height: 1.1; }
.sp-banner-row h1 span { display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.4); margin-bottom: 5px; }

.sp-stat { background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1); border-radius: 12px; padding: 11px 20px; min-width: 80px; text-align: center; }
.sp-stat strong { display: block; font-size: 24px; font-weight: 900; color: #fff; }
.sp-stat span { font-size: 10.5px; font-weight: 700; color: rgba(255,255,255,.38); text-transform: uppercase; }

/* ══ LAYOUT ══ */
.sp-layout { display: grid; grid-template-columns: 1fr; }

/* ══ CHILD CHIPS ══ */
.sp-child-scroll { display: flex; gap: 9px; overflow-x: auto; padding-bottom: 10px; margin-bottom: 20px; scrollbar-width: none; }
.sp-child-scroll::-webkit-scrollbar { display: none; }
.sp-child-chip { display: flex; align-items: center; gap: 7px; padding: 9px 18px; background: #fff; border: 1.5px solid #e8e8ef; border-radius: 11px; text-decoration: none; white-space: nowrap; transition: all .22s; }
.sp-child-chip:hover { border-color: #d0152b; color: #d0152b; transform: translateY(-2px); }
.sp-child-chip.active { background: #d0152b; border-color: #d0152b; color: #fff; }

/* ══ TOOLBAR ══ */
.sp-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 13px 18px; background: #fff; border: 1.5px solid #e8e8ef; border-radius: 14px; }

/* ══ GRID (5 Columns) ══ */
.sp-prod-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

/* ══ CARD ══ */
.sp-card { background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden; position: relative; transition: all .3s; display: flex; flex-direction: column; }
.sp-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: #d0152b44; }

.sp-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; }
.sp-card:hover .sp-img { transform: scale(1.06); }

.sp-card-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.sp-card-name { font-size: 18px; font-weight: 800; color: #2c2c30; text-decoration: none; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; line-height: 1.35; }
.sp-card-price { font-size: 22px; font-weight: 900; color: #d0152b; }

.sp-atc { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 12px 0; background: #d0152b; color: #fff; border-radius: 11px; font-size: 13px; font-weight: 700; text-decoration: none; margin-top: auto; }

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .sp-prod-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .sp-prod-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) { .sp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 900px) {
    .sp-banner { padding: 28px 24px; }
    .sp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .sp-img { height: 220px; }
}
@media (max-width: 500px) {
    .sp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .sp-img { height: 180px; }
}
</style>

<div class="sp content-area-inner">
    <div class="sp-banner">
        <div class="sp-banner-bg"></div>
        <div class="sp-banner-inner">
            <div class="sp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('category.page', $category->slug) }}">{{ $category->category_name }}</a>
                <span class="sep"><i class="bi bi-chevron-right"></i></span>
                <span class="cur">{{ $subCategory->sub_name }}</span>
            </div>
            <div class="sp-banner-row" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:20px;">
                <h1><span>{{ $category->category_name }}</span>{{ $subCategory->sub_name }}</h1>
                <div class="sp-stat"><strong>{{ $products->total() }}</strong><span>Products</span></div>
            </div>
        </div>
    </div>

    @if($subCategory->childCategories->count())
    <div class="sp-child-scroll">
        <a href="{{ route('subcategory.page', [$category->slug, $subCategory->slug]) }}" class="sp-child-chip active">All Types</a>
        @foreach($subCategory->childCategories as $child)
            <a href="{{ route('childcategory.page', [$category->slug, $subCategory->slug, $child->slug]) }}" class="sp-child-chip">{{ $child->child_sub_name }}</a>
        @endforeach
    </div>
    @endif

    <div class="sp-toolbar">
        <div class="sp-result-text">Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> results</div>
        <select class="sp-sort" onchange="window.location.href='?sort='+this.value">
            <option>Default Sorting</option>
            <option value="latest">Newest First</option>
        </select>
    </div>

    @if($products->isNotEmpty())
    <div class="sp-prod-grid">
        @foreach($products as $i => $item)
        <div class="sp-card">
            @if($item->discount_price) <span style="position:absolute; top:11px; left:11px; z-index:3; background:#d0152b; color:#fff; font-size:10px; font-weight:800; padding:4px 10px; border-radius:6px;">-{{ round((($item->current_price - $item->discount_price)/$item->current_price)*100) }}%</span> @endif
            <div class="sp-img-wrap">
                <img class="sp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
            </div>
            <div class="sp-card-body">
                <a href="{{ route('product.detail', $item->slug) }}" class="sp-card-name">{{ $item->name }}</a>
                <div class="sp-price-row" style="display:flex; gap:8px; align-items:baseline;">
                    <span class="sp-card-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</span>
                    @if($item->discount_price) <span style="font-size:12px; color:#9a9aaa; text-decoration:line-through;">৳ {{ number_format($item->current_price, 0) }}</span> @endif
                </div>
                <a href="{{ route('product.detail', $item->slug) }}" class="sp-atc">View Product</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="sp-pagination">{{ $products->links() }}</div>
    @endif
</div>

@endsection
