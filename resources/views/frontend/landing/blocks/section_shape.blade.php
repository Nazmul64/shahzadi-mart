@php
    $type = $block->content['shape_type'] ?? 'wave';
    $color = $block->content['shape_color'] ?? '#ffffff';
    $isBottom = $block->content['is_bottom'] ?? true;
    $opacity = $block->content['opacity'] ?? 0.2; /* Default to very light opacity */
    $zIndex = -1; /* Always behind everything */
@endphp

<div class="section-shape-wrapper" style="position: relative; line-height: 0; width: 100%; overflow: hidden; {{ $isBottom ? 'margin-top: -150px;' : 'margin-bottom: -150px;' }} z-index: {{ $zIndex }} !important; pointer-events: none; opacity: {{ $opacity }};">
    @if($type == 'wave')
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto; fill: {{ $color }}; {{ !$isBottom ? 'transform: rotate(180deg);' : '' }}">
            <path d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,149.3C672,149,768,203,864,218.7C960,235,1056,213,1152,186.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    @elseif($type == 'curve')
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto; fill: {{ $color }}; {{ !$isBottom ? 'transform: rotate(180deg);' : '' }}">
            <path d="M0,320L1440,160L1440,320L0,320Z"></path>
        </svg>
    @elseif($type == 'triangle')
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto; fill: {{ $color }}; {{ !$isBottom ? 'transform: rotate(180deg);' : '' }}">
            <path d="M720,0L1440,320L0,320Z"></path>
        </svg>
    @elseif($type == 'slant')
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto; fill: {{ $color }}; {{ !$isBottom ? 'transform: rotate(180deg);' : '' }}">
            <path d="M0,0L1440,320L1440,320L0,320Z"></path>
        </svg>
    @endif
</div>
