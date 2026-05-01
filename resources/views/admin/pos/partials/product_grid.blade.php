{{-- resources/views/admin/pos/partials/product_grid.blade.php --}}
@forelse($products as $product)
@php
    $price    = $product->effective_price;
    $oldPrice = ($product->is_flash_sale_active && $product->flash_sale_price)
                    ? $product->current_price
                    : ($product->discount_price ? $product->current_price : null);
    $discount = null;
    if ($oldPrice && $oldPrice > $price) {
        $discount = round((($oldPrice - $price) / $oldPrice) * 100, 2);
    }
    $imgUrl   = $product->feature_image
                    ? asset('uploads/products/' . $product->feature_image)
                    : asset('images/no-image.png');
    $variants = json_encode($product->variants ?? []);
    $soldCount = $product->orderItems()->count();
@endphp
<div class="product-card"
     onclick="addToCart(
         {{ $product->id }},
         {{ json_encode($product->name) }},
         {{ json_encode($product->sku ?? '') }},
         {{ json_encode($product->feature_image ?? '') }},
         {{ $price }},
         {{ $oldPrice ?? 'null' }},
         {{ $product->is_unlimited ? 'true' : 'false' }},
         {{ $product->stock ?? 0 }},
         {{ $variants }}
     )">

    @if($discount)
        <span class="flash-badge">-{{ round($discount) }}%</span>
    @endif

    <div style="position:relative; overflow:hidden; border-radius:var(--radius);">
        <img src="{{ $imgUrl }}"
             alt="{{ $product->name }}"
             loading="lazy"
             onerror="this.src='{{ asset('images/no-image.png') }}'">
    </div>

    <div class="p-name">{{ $product->name }}</div>

    <div class="p-price-row">
        <span class="p-price">${{ number_format($price, 2) }}</span>
        @if($oldPrice && $oldPrice > $price)
            <span class="p-old-price">${{ number_format($oldPrice, 2) }}</span>
        @endif
    </div>

    <div class="p-stock">
        <i class="fas fa-shopping-cart" style="font-size:9px; margin-right:2px; opacity:0.7;"></i> {{ $soldCount }} Sold
        &nbsp;·&nbsp;
        <i class="fas fa-box" style="font-size:9px; margin-right:2px; opacity:0.7;"></i>
        @if($product->is_unlimited)
            ∞
        @else
            {{ $product->stock ?? 0 }}
        @endif
    </div>
</div>
@empty
<div style="grid-column:1/-1;text-align:center;padding:40px;color:#9ca3af">
    <i class="fas fa-box-open" style="font-size:36px;margin-bottom:8px;display:block"></i>
    No products found.
</div>
@endforelse
