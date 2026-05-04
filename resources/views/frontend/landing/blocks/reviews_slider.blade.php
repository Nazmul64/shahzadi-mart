<div class="block-reviews" style="margin-bottom: 50px; padding: 40px 0;">
    <h2 style="text-align: center; color: var(--primary); font-size: 32px; font-weight: 800; margin-bottom: 30px;">{{ $block->content['title'] ?? 'Customer Reviews' }}</h2>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <div class="swiper reviewSwiper" style="padding-bottom: 40px;">
        <div class="swiper-wrapper">
            @php
                // Fetch approved reviews for the product
                $reviews = \App\Models\Producreview::where('product_id', $landing->product_id)
                    ->approved()
                    ->latest()
                    ->take(10)
                    ->get();
            @endphp
            
            @forelse($reviews as $review)
                <div class="swiper-slide">
                    <div style="background: #fff; border-radius: 20px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border: 1px solid #f1f4f9;">
                        <div style="color: #ffc107; font-size: 20px; margin-bottom: 15px;">
                            @for($i=0; $i<$review->rating; $i++) <i class="bi bi-star-fill"></i> @endfor
                            @for($i=0; $i<(5-$review->rating); $i++) <i class="bi bi-star"></i> @endfor
                        </div>
                        <p style="font-size: 16px; color: #555; font-style: italic; margin-bottom: 20px;">"{{ Str::limit($review->review, 100) }}"</p>
                        
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--secondary); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; margin: 0 auto 15px;">
                            {{ substr($review->user->name ?? 'C', 0, 1) }}
                        </div>
                        
                        <h5 style="font-size: 18px; font-weight: 700; color: #333; margin: 0;">{{ $review->user->name ?? 'Customer' }}</h5>
                    </div>
                </div>
            @empty
                <div class="swiper-slide text-center text-muted">
                    <p>No reviews yet. Be the first to review!</p>
                </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".reviewSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        });
    });
</script>
