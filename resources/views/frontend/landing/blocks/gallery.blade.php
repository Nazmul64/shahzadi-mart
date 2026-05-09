@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<style>
    .block-gallery .container { overflow: hidden; }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    .gallery-item {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        cursor: pointer;
    }
    .gallery-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: 0.5s;
    }
    .gallery-item img:hover { transform: scale(1.1); }

    @media (max-width: 1024px) {
        .gallery-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .gallery-item { border-radius: 12px; }
        .gallery-item img { height: 200px; }
        .block-gallery h2 { font-size: 1.8rem !important; margin-bottom: 25px !important; }
    }
</style>

<div class="block-gallery {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px;">
            {{ $block->content['title'] ?? 'Our Gallery' }}
        </h2>
        
        @if(!empty($block->content['images']))
            <div class="gallery-grid">
                @foreach($block->content['images'] as $index => $img)
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                        <img src="{{ asset('uploads/landing/blocks/' . $img) }}">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
