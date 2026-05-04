@php
    $title = $block->content['title'] ?? 'Our Products';
    $productIds = $block->content['product_ids'] ?? [];
    $products = \App\Models\Product::whereIn('id', $productIds)->get();
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<section class="block-product-grid py-5" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}" style="background: {{ $block->content['bg_color'] ?? '#fff' }};">
    <div class="pg-container">
        <div class="pg-header">
            <h2 class="pg-section-title">
                <i class="bi bi-lightning-charge-fill text-danger"></i> {{ $title }}
            </h2>
            <a href="/shop" class="pg-see-all">SEE ALL <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="pg-grid">
            @foreach($products as $product)
                @php
                    $currentPrice = $product->current_price;
                    $oldPrice = $product->discount_price;
                    $discount = 0;
                    if($oldPrice > 0 && $oldPrice > $currentPrice) {
                        $discount = round((($oldPrice - $currentPrice) / $oldPrice) * 100);
                    }
                @endphp
                <div class="pg-item">
                    <div class="pg-product-card">
                        <div class="pg-img-pos">
                            @if($discount > 0)
                                <div class="pg-discount-badge">-{{ $discount }}%</div>
                            @endif
                            <div class="pg-img-wrapper">
                                <img src="{{ asset('uploads/products/'.$product->feature_image) }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                        
                        <div class="pg-content">
                            <h6 class="pg-product-name">{{ $product->name }}</h6>
                            
                            <div class="pg-price-box">
                                <span class="pg-current-price">৳{{ number_format($currentPrice) }}</span>
                                @if($oldPrice > $currentPrice)
                                    <span class="pg-old-price">৳{{ number_format($oldPrice) }}</span>
                                @endif
                            </div>

                            <div class="pg-rating">
                                <div class="pg-stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                                <span>(0)</span>
                            </div>

                                <a href="#order" class="pg-add-btn" onclick="addToCart({{ json_encode([
                                    'id' => $product->id,
                                    'name' => $product->name,
                                    'price' => (float) $product->effective_price,
                                    'image' => asset('uploads/products/'.$product->feature_image)
                                ]) }})">
                                    <i class="bi bi-cart-plus"></i> কার্টে যোগ করুন
                                </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .pg-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 15px;
    }
    .pg-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }
    .pg-section-title {
        font-weight: 800;
        color: {{ $block->content['title_color'] ?? '#111' }};
        font-size: 24px;
        margin: 0;
    }
    .pg-see-all {
        color: #d0021b;
        font-weight: 700;
        text-decoration: none;
        font-size: 14px;
        text-transform: uppercase;
    }
    
    /* Custom Grid System */
    .pg-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Desktop: 4 items */
        gap: 20px;
    }
    
    .pg-product-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .pg-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #d0021b;
    }
    
    .pg-img-pos { position: relative; }
    .pg-discount-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #d0021b;
        color: #fff;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        z-index: 2;
    }
    .pg-img-wrapper {
        aspect-ratio: 1/1;
        overflow: hidden;
        background: #f9f9f9;
    }
    .pg-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .pg-product-card:hover .pg-img-wrapper img { transform: scale(1.1); }
    
    .pg-content { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; }
    .pg-product-name {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .pg-price-box { margin-bottom: 10px; }
    .pg-current-price { font-size: 18px; font-weight: 800; color: #d0021b; }
    .pg-old-price { font-size: 13px; text-decoration: line-through; color: #999; margin-left: 8px; }
    
    .pg-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: #777;
        margin-bottom: 15px;
    }
    .pg-stars { color: #ffc107; }
    
    .pg-add-btn {
        background: #d0021b;
        color: #fff;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        margin-top: auto;
        transition: 0.3s;
    }
    .pg-add-btn:hover { background: #b00217; }

    /* Responsiveness */
    @media (max-width: 991px) {
        .pg-grid { grid-template-columns: repeat(3, 1fr); } /* Tablet: 3 items */
        .pg-section-title { font-size: 20px; }
    }
    @media (max-width: 600px) {
        .pg-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } /* Mobile: 2 items */
        .pg-container { padding: 0 10px; }
        .pg-product-name { font-size: 13px; height: 36px; }
        .pg-current-price { font-size: 16px; }
        .pg-add-btn { font-size: 12px; padding: 8px; }
    }
</style>


