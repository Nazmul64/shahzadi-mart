@php
    $style = $block->content['style_variation'] ?? 'style-1';
    $titleColor = $block->content['title_color'] ?? '#1a2b6b';
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $aosType = ($block->content['aos_type'] ?? 'fade-up') == 'none' ? '' : ($block->content['aos_type'] ?? 'fade-up');
    $aosDuration = $block->content['aos_duration'] ?? 800;
@endphp
<style>
    .block-custom-reviews .swiper-slide {
        transition: all 0.4s ease;
        padding: 20px 10px;
    }
    .review-img-card {
        background: #fff;
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #f1f1f1;
        transition: 0.3s;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .block-custom-reviews .swiper-slide-active .review-img-card {
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    .review-img-card img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .review-img-card { padding: 10px; border-radius: 12px; height: auto !important; }
        .review-img-card img { height: 320px !important; }
        .block-custom-reviews { padding: 40px 0 !important; }
        .block-custom-reviews h2 { font-size: 1.6rem !important; margin-bottom: 20px !important; padding: 0 15px; }
        .block-custom-reviews .swiper-button-next, 
        .block-custom-reviews .swiper-button-prev { display: none !important; }
        .block-custom-reviews .swiper-pagination { bottom: 15px !important; }
        .block-custom-reviews .swiper-slide { padding: 10px 5px !important; }
    }
    .block-custom-reviews .swiper-button-next, 
    .block-custom-reviews .swiper-button-prev {
        background: #fff;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        color: var(--primary);
    }
    .block-custom-reviews .swiper-button-next::after, 
    .block-custom-reviews .swiper-button-prev::after {
        font-size: 18px;
        font-weight: bold;
    }
    .block-custom-reviews .swiper-pagination-bullet {
        background: #ccc;
        opacity: 0.5;
    }
    .block-custom-reviews .swiper-pagination-bullet-active {
        background: var(--primary);
        width: 25px;
        border-radius: 4px;
        opacity: 1;
    }
</style>

<div class="block-custom-reviews {{ $style }}" style="background-color: {{ $bgColor }}; padding: 60px 0; overflow: hidden;" data-aos="{{ $aosType }}" data-aos-duration="{{ $aosDuration }}">
    <div class="container">
        <h2 style="color: {{ $titleColor }}; text-align: center; font-size: 2.5rem; font-weight: 800; margin-bottom: 40px;">{{ $block->content['title'] ?? 'Real Customer Reviews' }}</h2>
        
        @if(!empty($block->content['images']) && is_array($block->content['images']))
            <div class="swiper customReviewsSwiper-{{ $block->id }}" style="padding: 30px 0 60px 0;">
                <div class="swiper-wrapper">
                    @foreach($block->content['images'] as $img)
                        <div class="swiper-slide">
                            <div class="review-img-card">
                                <img src="{{ asset('uploads/landing/blocks/' . $img) }}" alt="Review">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
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
            slidesPerView: 1.2,
            spaceBetween: 20,
            centeredSlides: false,
            grabCursor: true,
            loop: true,
            autoplay: { 
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: { 
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    centeredSlides: true,
                },
                480: {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            }
        });
    });
</script>
