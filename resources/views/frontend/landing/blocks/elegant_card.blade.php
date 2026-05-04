@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-elegant-card {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <div class="elegant-card-wrap" style="max-width: 800px; margin: 0 auto; background: #fff; border-radius: 40px; overflow: hidden; display: flex; flex-wrap: wrap; box-shadow: 0 30px 70px rgba(0,0,0,0.1); border: 1px solid #eee;">
            @if(!empty($block->content['image']))
            <div style="flex: 1; min-width: 300px; position: relative; min-height: 300px;">
                <img src="{{ asset('uploads/landing/blocks/' . $block->content['image']) }}" style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover;">
            </div>
            @endif
            <div style="flex: 1.2; min-width: 300px; padding: 50px; display: flex; flex-direction: column; justify-content: center;">
                <h2 style="color: {{ $titleColor }}; font-weight: 800; font-size: 2.2rem; margin-bottom: 20px;">{{ $block->content['title'] ?? '' }}</h2>
                <p style="color: {{ $textColor }}; font-size: 1.1rem; line-height: 1.7; margin-bottom: 30px;">{!! nl2br(e($block->content['text'] ?? '')) !!}</p>
                
                @if(!empty($block->content['btn_text']))
                <a href="{{ $block->content['btn_url'] ?? '#' }}" class="btn btn-primary btn-lg px-5 py-3 shadow-lg" style="width: fit-content; border-radius: 50px; font-weight: 700; background: var(--primary); border: none;">
                    {{ $block->content['btn_text'] }}
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .elegant-card-wrap { border-radius: 20px !important; }
        .elegant-card-wrap > div { padding: 30px !important; }
        .block-elegant-card { padding: 30px 10px !important; }
    }
</style>
