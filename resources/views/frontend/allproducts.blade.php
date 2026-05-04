{{-- resources/views/frontend/allproducts.blade.php --}}
@extends('frontend.master')

@section('main-content')

<style>
.smp-allprod { margin-top: 15px; }

/* ══ HERO ══ */
.smp-hero {
    background: linear-gradient(135deg, #0e0e0f 0%, #2c2c30 100%);
    border-radius: 20px; padding: 40px; margin-bottom: 25px; color: #fff;
    display: flex; justify-content: space-between; align-items: center; overflow: hidden; position: relative;
}
.smp-hero::after {
    content: ''; position: absolute; right: -20px; top: -20px; width: 150px; height: 150px;
    border-radius: 50%; border: 30px solid rgba(255,255,255,.03);
}
.smp-hero-text h1 { font-size: 32px; font-weight: 900; margin-bottom: 8px; }
.smp-hero-text p { color: rgba(255,255,255,.6); font-size: 14px; }
.smp-hero-count { text-align: right; }
.smp-hero-count-num { display: block; font-size: 36px; font-weight: 900; color: #d0152b; }
.smp-hero-count-label { font-size: 12px; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: 1px; }

/* ══ LAYOUT ══ */
.smp-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    align-items: start;
}

/* ══ SIDEBAR ══ */
.smp-sidebar { background: #fff; border: 1.5px solid #e8e8ef; border-radius: 14px; padding: 20px; position: sticky; top: 20px; }
.smp-sidebar-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.smp-sidebar-bar { width: 4px; height: 18px; background: #d0152b; border-radius: 2px; }

.smp-filter-sec { margin-bottom: 24px; }
.smp-filter-sec-title { font-size: 12px; font-weight: 700; color: #9a9aaa; text-transform: uppercase; margin-bottom: 12px; }
.smp-cat-list { list-style: none; padding: 0; margin: 0; }
.smp-cat-list li { margin-bottom: 5px; }
.smp-cat-list a { display: flex; justify-content: space-between; padding: 8px 12px; border-radius: 8px; text-decoration: none; color: #2c2c30; font-size: 13.5px; font-weight: 600; transition: all .2s; }
.smp-cat-list a:hover, .smp-cat-list a.active { background: #fff0f2; color: #d0152b; }

.smp-price-row { display: flex; gap: 8px; align-items: center; margin-bottom: 12px; }
.smp-price-input { flex: 1; padding: 9px; border: 1.5px solid #e8e8ef; border-radius: 8px; font-size: 13px; text-align: center; }
.smp-apply-btn { width: 100%; padding: 10px; background: #d0152b; color: #fff; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; }

/* ══ TOOLBAR ══ */
.smp-toolbar {
    display: flex; justify-content: space-between; align-items: center;
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 14px; padding: 12px 20px; margin-bottom: 20px;
}
.smp-sort-select { padding: 8px 12px; border: 1.5px solid #e8e8ef; border-radius: 8px; font-size: 13px; outline: none; }

/* ══ GRID (5 Columns) ══ */
.smp-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

/* ══ CARD ══ */
.smp-card-wrap { position: relative; }
.smp-card {
    background: #fff; border: 1.5px solid #e8e8ef; border-radius: 16px; overflow: hidden;
    transition: all .3s; display: flex; flex-direction: column; height: 100%;
}
.smp-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); border-color: #d0152b44; }

.smp-badge { position: absolute; top: 12px; left: 12px; z-index: 2; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 800; color: #fff; }
.smp-badge--discount { background: #d0152b; }
.smp-badge--new { background: #d0152b; }

.smp-img { width: 100%; height: 280px; object-fit: cover; border-bottom: 1.5px solid #e8e8ef; transition: transform .5s; }
.smp-card:hover .smp-img { transform: scale(1.06); }

.smp-card-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
.smp-card-name { font-size: 18px; font-weight: 800; color: #2c2c30; text-decoration: none; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 48px; line-height: 1.35; }
.smp-card-price { font-size: 22px; font-weight: 900; color: #d0152b; margin-bottom: 4px; }
.smp-card-old { font-size: 13.5px; color: #9a9aaa; text-decoration: line-through; margin-bottom: 12px; }
.smp-atc-btn { width: 100%; padding: 11px; border: none; border-radius: 10px; font-weight: 700; font-size: 12.5px; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.smp-atc-btn--active { background: #d0152b; color: #fff; }

/* ══ RESPONSIVE ══ */
@media (max-width: 1700px) { .smp-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1400px) { .smp-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1100px) {
    .smp-layout { grid-template-columns: 240px 1fr; gap: 15px; }
    .smp-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
    .smp-layout { grid-template-columns: 1fr; }
    .smp-sidebar { display: none; }
    .smp-hero { padding: 25px; }
    .smp-hero-text h1 { font-size: 24px; }
    .smp-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .smp-img { height: 220px; }
}
@media (max-width: 500px) {
    .smp-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .smp-img { height: 180px; }
}
</style>

<div class="smp-allprod content-area-inner">
    <div class="smp-hero">
        <div class="smp-hero-text">
            <h1>সব পণ্য</h1>
            <p>আমাদের সম্পূর্ণ পণ্য সংগ্রহ দেখুন</p>
        </div>
        <div class="smp-hero-count">
            <span class="smp-hero-count-num">{{ $products->total() }}</span>
            <span class="smp-hero-count-label">টি পণ্য</span>
        </div>
    </div>

    <div class="smp-layout">
        <aside class="smp-sidebar">
            <div class="smp-sidebar-title"><div class="smp-sidebar-bar"></div> ফিল্টার</div>
            <div class="smp-filter-sec">
                <div class="smp-filter-sec-title">ক্যাটাগরি</div>
                <ul class="smp-cat-list">
                    <li><a href="{{ url('all-products') }}" class="{{ !request('category') ? 'active' : '' }}">সব ক্যাটাগরি</a></li>
                    @foreach($categories as $cat)
                        <li><a href="{{ url('all-products') }}?category={{ $cat->slug }}" class="{{ request('category') === $cat->slug ? 'active' : '' }}">{{ $cat->category_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="smp-filter-sec">
                <div class="smp-filter-sec-title">দামের সীমা</div>
                <form method="GET" action="{{ url('all-products') }}">
                    <div class="smp-price-row">
                        <input type="number" name="min_price" class="smp-price-input" placeholder="Min" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="smp-price-input" placeholder="Max" value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="smp-apply-btn">প্রয়োগ করুন</button>
                </form>
            </div>
        </aside>

        <main>
            <div class="smp-toolbar">
                <div class="smp-toolbar-info">Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</div>
                <select class="smp-sort-select" onchange="window.location.href='?sort='+this.value">
                    <option value="latest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                </select>
            </div>

            <div class="smp-grid">
                @foreach($products as $item)
                <div class="smp-card-wrap">
                    <div class="smp-card">
                        @if($item->discount_price) <span class="smp-badge smp-badge--discount">-{{ round((($item->current_price - $item->discount_price)/$item->current_price)*100) }}% OFF</span> @endif
                        <div class="smp-img-wrap">
                            <img class="smp-img" src="{{ asset('uploads/products/' . $item->feature_image) }}" alt="{{ $item->name }}" loading="lazy">
                        </div>
                        <div class="smp-card-body">
                            <a href="{{ route('product.detail', $item->slug) }}" class="smp-card-name">{{ $item->name }}</a>
                            <p class="smp-card-price">৳ {{ number_format($item->discount_price ?? $item->current_price, 0) }}</p>
                            @if($item->discount_price)
                                <p class="smp-card-old">৳ {{ number_format($item->current_price, 0) }}</p>
                            @endif
                            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="smp-atc-btn smp-atc-btn--active">কার্টে যোগ করুন</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="smp-pagination">{{ $products->links() }}</div>
        </main>
    </div>
</div>

@endsection
