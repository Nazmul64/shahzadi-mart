@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-custom-reviews {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0; overflow: hidden;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px;">{{ $block->content['title'] ?? 'Real Customer Reviews' }}</h2>
        
        @if(!empty($block->content['images']) && is_array($block->content['images']))
            <div class="swiper customReviewsSwiper-{{ $block->id }}" style="padding: 50px 0;">
                <div class="swiper-wrapper">
                    @foreach($block->content['images'] as $img)
                        <div class="swiper-slide" style="width: 300px;">
                            <img src="{{ asset('uploads/landing/blocks/' . $img) }}" style="width: 100%; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next" style="color: var(--primary);"></div>
                <div class="swiper-button-prev" style="color: var(--primary);"></div>
            </div>
        @else
            <p class="text-center text-muted">No review images uploaded yet.</p>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".customReviewsSwiper-{{ $block->id }}", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: { 
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: { 
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true
        });
    });
</script>
