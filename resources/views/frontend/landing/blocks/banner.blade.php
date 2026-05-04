@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#ffffff';
    $textColor = $block->content['text_color'] ?? '#eeeeee';
    $bgColor = $block->content['bg_color'] ?? 'transparent';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-banner {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0; overflow: hidden;">
    <div class="container">
        @if($style == 'style-1')
            {{-- Modern Glass Style --}}
            <div class="banner-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px; padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <div style="flex: 1; min-width: 300px;">
                    <h1 style="color: {{ $titleColor }}; font-size: 3rem; font-weight: 800; line-height: 1.2; margin-bottom: 20px;">{!! nl2br(e($block->content['title'] ?? '')) !!}</h1>
                    <p style="color: {{ $textColor }}; font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9;">{{ $block->content['subtitle'] ?? '' }}</p>
                    <a href="#order" class="btn btn-primary btn-lg" style="padding: 15px 40px; border-radius: 50px; font-weight: 700; text-transform: uppercase;">{{ $block->content['btn_text'] ?? 'Order Now' }}</a>
                </div>
                @if(isset($block->content['image']))
                <div style="flex: 1; min-width: 300px; text-align: center;">
                    <img src="{{ asset('uploads/landing/blocks/'.$block->content['image']) }}" style="max-width: 100%; border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                </div>
                @endif
            </div>

        @elseif($style == 'style-2')
            {{-- Premium Dark Centered --}}
            <div class="banner-centered" style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <h1 style="color: {{ $titleColor }}; font-size: 3.5rem; font-weight: 900; margin-bottom: 25px;">{!! nl2br(e($block->content['title'] ?? '')) !!}</h1>
                <p style="color: {{ $textColor }}; font-size: 1.3rem; margin-bottom: 35px;">{{ $block->content['subtitle'] ?? '' }}</p>
                <div class="mb-5">
                    <a href="#order" class="btn btn-primary btn-lg px-5 py-3 shadow-lg">{{ $block->content['btn_text'] ?? 'Order Now' }}</a>
                </div>
                @if(isset($block->content['image']))
                <img src="{{ asset('uploads/landing/blocks/'.$block->content['image']) }}" style="max-width: 100%; height: auto; border-radius: 20px;">
                @endif
            </div>

        @else
            {{-- Style 3: Clean Side-by-Side --}}
            <div class="row align-items-center" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
                <div class="col-md-6">
                    <h1 style="color: {{ $titleColor }}; font-size: 2.8rem; font-weight: 700; margin-bottom: 20px;">{!! nl2br(e($block->content['title'] ?? '')) !!}</h1>
                    <div style="width: 60px; height: 5px; background: var(--primary); margin-bottom: 25px;"></div>
                    <p style="color: {{ $textColor }}; font-size: 1.1rem; margin-bottom: 30px;">{{ $block->content['subtitle'] ?? '' }}</p>
                    <a href="#order" class="btn btn-outline-light btn-lg">{{ $block->content['btn_text'] ?? 'Order Now' }}</a>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    @if(isset($block->content['image']))
                    <img src="{{ asset('uploads/landing/blocks/'.$block->content['image']) }}" style="width: 100%; border-radius: 0 50px 0 50px;">
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
