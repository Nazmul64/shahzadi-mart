@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#ffffff';
    $textColor = $block->content['text_color'] ?? '#eeeeee';
    $bgColor = $block->content['bg_color'] ?? 'var(--primary)';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-cta {{ $style }}" style="background-color: {{ $bgColor }}; padding: 80px 20px; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; font-size: 3rem; font-weight: 800; margin-bottom: 20px;">{!! nl2br(e($block->content['title'] ?? '')) !!}</h2>
        <p style="color: {{ $textColor }}; font-size: 1.3rem; max-width: 700px; margin: 0 auto 40px; opacity: 0.9;">{{ $block->content['subtitle'] ?? '' }}</p>
        <a href="#order" class="btn btn-light btn-lg px-5 py-3 fw-bold shadow" style="border-radius: 50px; text-transform: uppercase;">{{ $block->content['btn_text'] ?? 'Order Now' }}</a>
    </div>
</div>

<style>
    .block-cta .btn-buy:hover { transform: scale(1.05); box-shadow: 0 15px 25px rgba(0,0,0,0.3); }
</style>
