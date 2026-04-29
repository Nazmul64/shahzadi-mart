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
        <span class="flash-badge">{{ $discount }}% OFF</span>
    @endif

    <img src="{{ $imgUrl }}"
         alt="{{ $product->name }}"
         loading="lazy"
         onerror="this.src='{{ asset('images/no-image.png') }}'">

    <div class="p-name">{{ $product->name }}</div>

    <div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap">
        <span class="p-price">${{ number_format($price, 1) }}</span>
        @if($oldPrice && $oldPrice > $price)
            <span class="p-old-price">${{ number_format($oldPrice, 1) }}</span>
        @endif
    </div>

    <div class="p-stock">
        {{ $soldCount }} Sold &nbsp;|&nbsp;
        @if($product->is_unlimited)
            ∞ Left
        @else
            {{ $product->stock ?? 0 }} Left
        @endif
    </div>
</div>
@empty
<div style="grid-column:1/-1;text-align:center;padding:40px;color:#9ca3af">
    <i class="fas fa-box-open" style="font-size:36px;margin-bottom:8px;display:block"></i>
    No products found.
</div>
@endforelse
