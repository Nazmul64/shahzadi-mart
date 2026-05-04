@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $rating = $block->content['rating'] ?? 5;
@endphp

<div class="block-star-ratings {{ $style }}" style="background-color: {{ $bgColor }}; padding: 30px 0; text-align: center;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        @if(!empty($block->content['title']))
            <h4 style="color: {{ $textColor }}; font-weight: 700; margin-bottom: 15px; font-size: 1.2rem;">{{ $block->content['title'] }}</h4>
        @endif
        
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 5px;">
            <div style="color: #ffc107; font-size: 2rem; letter-spacing: 5px;">
                @for($i=1; $i<=5; $i++)
                    @if($i <= floor($rating))
                        <i class="bi bi-star-fill"></i>
                    @elseif($i == ceil($rating) && $rating != floor($rating))
                        <i class="bi bi-star-half"></i>
                    @else
                        <i class="bi bi-star"></i>
                    @endif
                @endfor
            </div>
            <div style="font-size: 2.2rem; font-weight: 900; color: {{ $titleColor }};">{{ $rating }}</div>
        </div>
        
        @if(!empty($block->content['count']))
            <p style="color: #888; font-weight: 600; font-size: 0.95rem;">
                <i class="bi bi-patch-check-fill text-success"></i> Based on {{ $block->content['count'] }}
            </p>
        @endif
    </div>
</div>
