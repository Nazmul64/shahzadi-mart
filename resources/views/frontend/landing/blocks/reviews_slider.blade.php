<style>
    .reviewSwiper-pro {
        padding: 40px 0 60px 0 !important;
    }
    .review-card-premium {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        margin: 10px;
    }
    .review-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    }
    .review-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .review-badge-text { font-size: 0.95rem; color: #718096; font-weight: 500; }
    .review-circle-badge {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: #fff;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 4px 10px rgba(79, 172, 254, 0.3);
    }
    .review-row-between { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .review-tag { font-size: 0.85rem; color: #2ecc71; font-weight: 700; background: #e8f8f0; padding: 4px 10px; border-radius: 20px; }
    .review-date { font-size: 0.85rem; color: #a0aec0; }
    .review-user-name { font-size: 1.25rem; font-weight: 800; color: #1a202c; margin: 0; }
    .review-stars { color: #f1c40f; font-size: 0.9rem; }
    .review-text-content {
        font-size: 1.05rem;
        color: #4a5568;
        line-height: 1.7;
        font-style: italic;
        margin-top: 20px;
        flex-grow: 1;
        position: relative;
    }
    .review-text-content::before {
        content: '"';
        font-size: 40px;
        color: rgba(0,0,0,0.05);
        position: absolute;
        top: -20px;
        left: -10px;
        font-family: serif;
    }

    .reviewSwiper-pro .swiper-pagination-bullet-active {
        background: var(--primary);
        width: 30px;
        border-radius: 5px;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .review-card-premium { padding: 20px; margin: 5px; }
        .review-user-name { font-size: 1.1rem; }
        .review-text-content { font-size: 0.95rem; margin-top: 15px; }
        .review-badge-text { font-size: 0.85rem; }
        .block-reviews h2 { font-size: 26px !important; margin-bottom: 30px !important; }
        .review-circle-badge { width: 30px; height: 30px; font-size: 12px; }
    }
</style>

<div class="block-reviews" style="margin-bottom: 80px; padding: 80px 0; background: #fdfdfd;">
    <div class="container">
        <h2 style="text-align: center; color: var(--primary); font-size: 36px; font-weight: 900; margin-bottom: 50px;">{{ $block->content['title'] ?? 'কাস্টমার ফিডব্যাক' }}</h2>
        
        <div class="swiper reviewSwiper-pro">
            <div class="swiper-wrapper">
                @php
                    $reviews = \App\Models\Producreview::where('product_id', $landing->product_id)
                        ->approved()
                        ->latest()
                        ->take(12)
                        ->get();
                @endphp
                
                @forelse($reviews as $review)
                    <div class="swiper-slide">
                        <div class="review-card-premium">
                            <div class="review-card-header">
                                <span class="review-badge-text">Customer Feedback</span>
                                <div class="review-circle-badge">{{ $review->rating }}★</div>
                            </div>

                            <div class="review-row-between mb-3">
                                <span class="review-tag"><i class="bi bi-patch-check-fill"></i> Verified Buyer</span>
                                <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>

                            <div class="review-row-between mb-1">
                                <h3 class="review-user-name">{{ $review->user->name ?? 'Happy Customer' }}</h3>
                                <div class="review-stars">
                                    @for($i=0; $i<$review->rating; $i++) <i class="bi bi-star-fill"></i> @endfor
                                    @for($i=0; $i<(5-$review->rating); $i++) <i class="bi bi-star"></i> @endfor
                                </div>
                            </div>

                            <p class="review-text-content">{{ $review->review }}</p>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="review-card-premium text-center text-muted">
                            <p>এখনো কোনো রিভিউ নেই। প্রথম রিভিউটি আপনিই দিন!</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper(".reviewSwiper-pro", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: ".swiper-pagination", clickable: true },
                breakpoints: {
                    640: { slidesPerView: 1.5, spaceBetween: 20 },
                    768: { slidesPerView: 2, spaceBetween: 30 },
                    1024: { slidesPerView: 3, spaceBetween: 30 }
                }
            });
        }
    });
</script>
