@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $strings = explode(',', $block->content['strings'] ?? 'Quality, Trust, Speed');
    $stringsJson = json_encode(array_map('trim', $strings));
@endphp

<div class="block-typing {{ $style }}" style="background-color: {{ $bgColor }}; padding: 50px 20px; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: #333; line-height: 1.2;">
            {{ $block->content['prefix'] ?? '' }}
            <span class="typed-text-{{ $block->id }}" style="color: {{ $titleColor }}; border-bottom: 5px solid {{ $titleColor }};"></span>
            {{ $block->content['suffix'] ?? '' }}
        </h2>
    </div>
</div>

<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Typed('.typed-text-{{ $block->id }}', {
            strings: {!! $stringsJson !!},
            typeSpeed: 60,
            backSpeed: 40,
            backDelay: 2000,
            loop: true,
            cursorChar: '|'
        });
    });
</script>
