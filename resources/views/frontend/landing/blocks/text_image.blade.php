@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $textColor = $block->content['text_color'] ?? '#444444';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
    $pos = $block->content['image_position'] ?? 'left';
@endphp

<div class="block-text-image {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0;">
    <div class="container">
        @if($style == 'style-1')
            <div class="row align-items-center {{ $pos == 'right' ? 'flex-row-reverse' : '' }}" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <div class="col-md-6">
                    @if(isset($block->content['image']))
                    <img src="{{ asset('uploads/landing/blocks/'.$block->content['image']) }}" style="width: 100%; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    @endif
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <h2 style="color: {{ $titleColor }}; font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">{{ $block->content['title'] ?? '' }}</h2>
                    <p style="color: {{ $textColor }}; font-size: 1.1rem; line-height: 1.7;">{!! nl2br(e($block->content['text'] ?? '')) !!}</p>
                </div>
            </div>
        @elseif($style == 'style-2')
            {{-- Modern Floating Style --}}
            <div class="row align-items-center {{ $pos == 'right' ? 'flex-row-reverse' : '' }}" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <div class="col-md-5">
                    <h2 style="color: {{ $titleColor }}; font-size: 2.2rem; font-weight: 700; margin-bottom: 25px; border-left: 5px solid var(--primary); padding-left: 20px;">{{ $block->content['title'] ?? '' }}</h2>
                    <p style="color: {{ $textColor }}; font-size: 1.1rem; line-height: 1.8; background: #f8f9fa; padding: 25px; border-radius: 15px;">{!! nl2br(e($block->content['text'] ?? '')) !!}</p>
                </div>
                <div class="col-md-7 mt-4 mt-md-0" style="position: relative;">
                    @if(isset($block->content['image']))
                    <img src="{{ asset('uploads/landing/blocks/'.$block->content['image']) }}" style="width: 100%; border-radius: 30px; transform: rotate({{ $pos == 'left' ? '2deg' : '-2deg' }});">
                    @endif
                </div>
            </div>
        @else
            {{-- Style 3: Minimal Split --}}
            <div class="row g-0 align-items-stretch {{ $pos == 'right' ? 'flex-row-reverse' : '' }}" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.05); background: #fff;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <div class="col-md-6">
                    @if(isset($block->content['image']))
                    <div class="ti-img-box" style="background: url('{{ asset('uploads/landing/blocks/'.$block->content['image']) }}') center/cover; min-height: 400px; height: 100%;"></div>
                    @endif
                </div>
                <div class="col-md-6 d-flex align-items-center" style="padding: 40px;">
                    <div>
                        <h2 style="color: {{ $titleColor }}; font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 800; margin-bottom: 20px;">{{ $block->content['title'] ?? '' }}</h2>
                        <div style="color: {{ $textColor }}; font-size: 1.1rem; line-height: 1.8;">{!! nl2br(e($block->content['text'] ?? '')) !!}</div>
                    </div>
                </div>
            </div>
            <style>
                @media (max-width: 768px) {
                    .ti-img-box { min-height: 250px !important; }
                    .block-text-image { padding: 30px 10px !important; }
                }
            </style>
        @endif
    </div>
</div>
