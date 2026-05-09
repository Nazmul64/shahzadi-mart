{{-- resources/views/frontend/childcategory.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=DM+Sans:wght@400;500;600;700;800&display=swap');

.chp *, .chp *::before, .chp *::after { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }
.chp h1, .chp h2, .chp h3 { font-family: 'Playfair Display', serif; }

.chp { margin-top: 10px; }

/* ══ LAYOUT ══ */
.chp-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 22px;
    align-items: start;
}

/* ══ HERO BANNER ══ */
.chp-banner {
    position: relative;
    background: linear-gradient(135deg, #0d1f0a 0%, #1a3d12 55%, #122b0d 100%);
    border-radius: 16px; overflow: hidden; padding: 36px 44px; margin-bottom: 24px; min-height: 145px;
}
.chp-banner::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 55% 75% at 92% 50%, rgba(34,197,94,.2), transparent);
}
.chp-banner-inner { position: relative; z-index: 1; }
.chp-breadcrumb {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap; font-size: 12px; font-weight: 600; color: rgba(255,255,255,.4); margin-bottom: 14px;
}
.chp-breadcrumb a { color: rgba(255,255,255,.4); text-decoration: none; }
.chp-banner-left h1 { font-size: 28px; font-weight: 900; color: #fff; line-height: 1.15; }
.chp-banner-left h1 span { display: block; font-family: 'DM Sans', sans-serif; font-size: 11px; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; color: rgba(34,197,94,.7); margin-bottom: 5px; }

.chp-pill { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12); color: rgba(255,255,255,.7); display: flex; align-items: center; gap: 6px; }

/* ══ TOOLBAR ══ */
.chp-toolbar {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; padding: 12px 16px; background: #fff; border: 1px solid #ebebeb; border-radius: 12px;
}

/* ══ PRODUCT GRID (5 Columns) ══ */
.chp-prod-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

/* ══ PRODUCT CARD ══ */
.chp-card {
    background: #fff; border: 1px solid #ebebeb; border-radius: 14px; overflow: hidden; position: relative; transition: all .28s; display: flex; flex-direction: column;
}
.chp-card:hover { box-shadow: 0 14px 40px rgba(0,0,0,.11); transform: translateY(-5px); border-color: rgba(34,197,94,.25); }

.chp-img-wrap { position: relative; overflow: hidden; background: #f8f8f8; }
.chp-img { width: 100%; height: 280px; object-fit: cover; display: block; border-bottom: 1px solid #ebebeb; transition: transform .38s; }
.chp-card:hover .chp-img { transform: scale(1.07); }

.chp-card-body { padding: 13px 14px 14px; display: flex; flex-direction: column; flex: 1; }
.chp-card-name { font-size: 18px; font-weight: 800; color: #333; line-height: 1.4; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; }
.chp-card-price { font-size: 22px; font-weight: 900; color: #c8102e; display: block; }
.chp-card-old { font-size: 13.5px; color: #aaa; text-decoration: line-through; display: block; margin-bottom: 12px; }

.chp-atc {
    display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: #c8102e; color: #fff; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; margin-top: auto;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .chp-prod-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .chp-prod-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) {
    .chp-layout { grid-template-columns: 250px 1fr; gap: 15px; }
    .chp-prod-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
    .chp-layout { grid-template-columns: 1fr; }
    .sidebar { display: none; }
    .chp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .chp-img { height: 220px; }
}
@media (max-width: 500px) {
    .chp-prod-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .chp-img { height: 180px; }
}
</style>

<div class="chp content-area-inner">
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
                    <h1><span>{{ $subCategory->sub_name }}</span> {{ $childCategory->child_sub_name }}</h1>
                </div>
                <div class="chp-pill">
                    <div class="dot"></div>
                    <strong>{{ $products->total() }}</strong> Products
                </div>
            </div>
        </div>
    </div>

    <div class="chp-layout">
        @include('frontend.pages.category')

        <div>
            <div class="chp-toolbar">
                <span class="chp-result-text">Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> results</span>
                <select class="chp-sort">
                    <option>Default Sorting</option>
                    <option>Newest First</option>
                </select>
            </div>

            @if($products->isNotEmpty())
            <div class="chp-prod-grid" id="chpProdGrid">
                @foreach($products as $i => $item)
                @php
                    $displayPrice = $item->discount_price ?? $item->current_price;
                    $discount = ($item->discount_price && $item->current_price > 0) ? round((($item->current_price - $item->discount_price) / $item->current_price) * 100) : null;
                @endphp
                <div class="chp-card" style="animation-delay:{{ $i * 0.05 }}s">
                    @if($discount) <span class="chp-badge">-{{ $discount }}%</span> @endif
                    <div class="chp-img-wrap">
                        <img class="chp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                    </div>
                    <div class="chp-card-body">
                        <div class="chp-card-name">{{ $item->name }}</div>
                        <span class="chp-card-price">৳ {{ number_format($displayPrice, 0) }}</span>
                        @if($item->discount_price)
                            <span class="chp-card-old">৳ {{ number_format($item->current_price, 0) }}</span>
                        @endif
                        <a href="{{ route('product.detail', $item->slug) }}" class="chp-atc">View Product</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="chp-pagination">{{ $products->links() }}</div>
            @else
            <div class="chp-empty">
                <h3>No Products Found</h3>
                <p>No products available in <strong>{{ $childCategory->child_sub_name }}</strong> yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ── Tracking for Child Category Page ──
    (function() {
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({
                'event': 'view_item_list',
                'ecommerce': {
                    'currency': 'BDT',
                    'item_list_name': '{{ addslashes($childCategory->child_sub_name) }}',
                    'items': [
                        @foreach($products as $i => $item)
                        {
                            'item_name': '{{ addslashes($item->name) }}',
                            'item_id': '{{ $item->id }}',
                            'price': {{ (float)($item->discount_price ?? $item->current_price) }},
                            'item_category': '{{ addslashes($category->category_name) }}',
                            'item_variant': '{{ addslashes($childCategory->child_sub_name) }}',
                            'index': {{ $i + 1 }}
                        },
                        @endforeach
                    ]
                }
            });
        }
    })();
</script>
@endpush

@endsection
