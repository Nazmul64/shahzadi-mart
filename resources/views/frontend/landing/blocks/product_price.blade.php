@php
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $title = $block->content['title'] ?? 'আজকের বিশেষ দাম:';
    
    $p = $landing->product;
    $price = $p->discount_price ?? $p->current_price;
    $old = $p->discount_price ? $p->current_price : null;
    $padding = $block->content['padding'] ?? 30; 
@endphp

<div class="price-box" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}" style="background-color: {{ $block->content['bg_color'] ?? '#111' }}; padding: {{ $padding }}px 30px;">
    <h3 style="color: {{ $block->content['title_color'] ?? '#fff' }};">{{ $title }}</h3>
    <div>
        @if($old)<span class="old">{{ number_format($old) }}৳</span>@endif
        <span class="new" style="color: {{ $block->content['text_color'] ?? '#fff' }};">{{ number_format($price) }}৳</span>
    </div>
</div>
