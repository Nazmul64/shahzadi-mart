@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-gallery {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 20px;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px;">
            {{ $block->content['title'] ?? 'Our Gallery' }}
        </h2>
        
        @if(!empty($block->content['images']))
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; max-width: 1400px; margin: 0 auto;">
                @foreach($block->content['images'] as $index => $img)
                    <div style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); cursor: pointer;" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                        <img src="{{ asset('uploads/landing/blocks/' . $img) }}" style="width: 100%; height: 300px; object-fit: cover; transition: 0.5s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
