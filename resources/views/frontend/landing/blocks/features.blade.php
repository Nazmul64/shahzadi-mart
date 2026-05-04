@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-features {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0;">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 50px;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
            {{ $block->content['title'] ?? 'Why Choose Us?' }}
        </h2>
        
        <div class="row g-4 justify-content-center">
            @if(!empty($block->content['items']))
                @foreach($block->content['items'] as $index => $item)
                    <div class="col-md-4" data-aos="{{ $aosType }}" data-aos-delay="{{ $index * 100 }}" data-aos-duration="{{ $aosDuration }}">
                        @if($style == 'style-1')
                            <div class="feature-card text-center p-4 h-100" style="background: #fff; border-radius: 20px; border: 1px solid #eee; transition: 0.3s; box-shadow: 0 10px 30px rgba(0,0,0,0.02);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-10px)'" onmouseout="this.style.borderColor='#eee'; this.style.transform='translateY(0)'">
                                <div style="width: 70px; height: 70px; background: #f1f4f9; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2rem; font-weight: 800;">{{ $index + 1 }}</div>
                                <h4 style="color: {{ $titleColor }}; font-weight: 700; margin-bottom: 15px;">{{ $item['title'] ?? '' }}</h4>
                                <p style="color: {{ $textColor }};">{{ $item['text'] ?? '' }}</p>
                            </div>
                        @elseif($style == 'style-2')
                            <div class="feature-card-dark p-4 h-100" style="background: #111; color: #fff; border-radius: 0 30px 0 30px; border-left: 4px solid var(--primary);">
                                <h4 style="color: #fff; font-weight: 700; margin-bottom: 15px;">{{ $item['title'] ?? '' }}</h4>
                                <p style="opacity: 0.8; font-size: 0.95rem;">{{ $item['text'] ?? '' }}</p>
                            </div>
                        @else
                            <div class="feature-minimal d-flex gap-3">
                                <div style="color: var(--primary); font-size: 1.5rem;"><i class="bi bi-patch-check-fill"></i></div>
                                <div>
                                    <h4 style="color: {{ $titleColor }}; font-weight: 700; font-size: 1.2rem; margin-bottom: 5px;">{{ $item['title'] ?? '' }}</h4>
                                    <p style="color: {{ $textColor }}; font-size: 0.9rem;">{{ $item['text'] ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<style>
    .feature-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
</style>
