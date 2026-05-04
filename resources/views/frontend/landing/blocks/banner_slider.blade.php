@php
    $slides = $block->content['slides'] ?? [];
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp

<div class="block-banner-slider-section" style="padding: 15px 0;">
    <div class="slider-container-custom">
        <div class="block-banner-slider" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    @foreach($slides as $slide)
                        <div class="swiper-slide">
                            <div class="slide-img-box">
                                <img src="{{ asset('uploads/landing/blocks/'.$slide['image']) }}" alt="Banner">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper(".bannerSwiper", {
            loop: true,
            effect: 'fade',
            speed: 1000,
            fadeEffect: { crossFade: true },
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });
    });
</script>

<style>
    .slider-container-custom {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .bannerSwiper { 
        width: 100%; 
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .slide-img-box {
        width: 100%;
        height: 600px; /* High-end desktop height */
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .slide-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .swiper-button-next, .swiper-button-prev {
        width: 55px !important;
        height: 55px !important;
        background: rgba(255,255,255,0.9) !important;
        border-radius: 50% !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 22px !important;
        color: #000 !important;
        font-weight: 900 !important;
    }
    
    .swiper-pagination-bullet { width: 14px; height: 14px; background: #fff; opacity: 0.6; }
    .swiper-pagination-bullet-active { background: var(--primary) !important; opacity: 1; width: 45px; border-radius: 10px; transition: 0.4s; }

    /* Mobile Responsiveness */
    @media (max-width: 1200px) {
        .slide-img-box { height: 500px; }
    }
    @media (max-width: 991px) {
        .slide-img-box { height: 400px; }
        .swiper-button-next, .swiper-button-prev { width: 45px !important; height: 45px !important; }
    }
    @media (max-width: 768px) {
        .slider-container-custom { padding: 0 10px; }
        .slide-img-box { height: 300px; }
        .bannerSwiper { border-radius: 12px; }
        .swiper-button-next, .swiper-button-prev { display: none !important; }
    }
    @media (max-width: 480px) {
        .slide-img-box { height: 220px; }
    }
</style>
