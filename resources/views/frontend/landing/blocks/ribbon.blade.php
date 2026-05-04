@php
    $text = $block->content['text'] ?? 'Special Offer';
    $pos = $block->content['position'] ?? 'top-left';
    $color = $block->content['color'] ?? '#ff0000';
@endphp

<div class="block-ribbon-wrapper" style="position: relative; height: 0; z-index: 100;">
    <div class="premium-ribbon {{ $pos }}" style="background: {{ $color }};">
        {{ $text }}
    </div>
</div>

<style>
    .premium-ribbon {
        position: absolute;
        padding: 8px 40px;
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 1000;
    }
    .premium-ribbon.top-left {
        top: 20px;
        left: -10px;
        transform: rotate(-5deg);
    }
    .premium-ribbon.top-right {
        top: 20px;
        right: -10px;
        transform: rotate(5deg);
    }
    .premium-ribbon::after {
        content: '';
        position: absolute;
        bottom: -5px;
        border-top: 5px solid rgba(0,0,0,0.5);
        z-index: -1;
    }
    .premium-ribbon.top-left::after { left: 0; border-left: 5px solid transparent; }
    .premium-ribbon.top-right::after { right: 0; border-right: 5px solid transparent; }
</style>
