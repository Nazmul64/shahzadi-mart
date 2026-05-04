@php
    $logo = $block->content['logo'] ?? null;
    $desc = $block->content['description'] ?? '';
    $links = $block->content['links'] ?? [];
    $copyright = $block->content['copyright'] ?? '';
    $bgColor = $block->content['bg_color'] ?? '#111111';
    $textColor = $block->content['text_color'] ?? '#ffffff';
    
    /* Dynamic Contact Info from Builder */
    $phone = $block->content['phone'] ?? ($websetting?->phone ?? '+8801700000000');
    $email = $block->content['email'] ?? ($websetting?->email ?? 'info@example.com');
    $address = $block->content['address'] ?? ($websetting?->address ?? 'Dhaka, Bangladesh');
@endphp

<footer class="footer-classic" style="background: {{ $bgColor }}; color: {{ $textColor }};">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-col-main">
                <div class="footer-logo">
                    @if($logo)
                        <img src="{{ asset('uploads/landing/blocks/'.$logo) }}" alt="Logo">
                    @else
                        <h2 class="footer-logo-text">{{ $websetting?->site_name ?? 'LOGO' }}</h2>
                    @endif
                </div>
                <p class="footer-desc">{{ $desc ?: 'Your trusted marketplace for premium products. Quality guaranteed, delivered to your door.' }}</p>
                <div class="footer-social">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4 class="footer-head">Quick Links</h4>
                <ul class="footer-links-list">
                    @foreach($links as $link)
                        <li><a href="{{ $link['url'] }}" style="color: {{ $textColor }};">{{ $link['title'] }}</a></li>
                    @endforeach
                    @if(empty($links))
                        <li><a href="#order">Order Now</a></li>
                        <li><a href="#about">About Us</a></li>
                    @endif
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-head">Contact Us</h4>
                <div class="footer-contact-info">
                    <p><i class="bi bi-geo-alt-fill"></i> {{ $address }}</p>
                    <p><i class="bi bi-telephone-fill"></i> {{ $phone }}</p>
                    <p><i class="bi bi-envelope-fill"></i> {{ $email }}</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom-bar">
            <div class="fb-inner">
                <p>{{ $copyright ?: '© '.date('Y').' All rights reserved.' }}</p>
                <div class="payment-icons">
                    <img src="https://trust-badge.com/wp-content/uploads/2021/04/trust-badge-payment-logos.png" alt="Payments">
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-classic {
        padding: 60px 0 20px;
        width: 100%;
        display: block !important;
        position: relative;
        z-index: 10;
    }
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .footer-grid {
        display: grid !important;
        grid-template-columns: 2fr 1fr 1fr !important;
        gap: 40px;
        margin-bottom: 40px;
    }
    @media (max-width: 991px) {
        .footer-grid { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 575px) {
        .footer-grid { grid-template-columns: 1fr !important; }
    }

    .footer-logo img { max-height: 50px; margin-bottom: 20px; display: block; filter: brightness(0) invert(1); }
    .footer-logo-text { font-weight: 800; color: #fff; margin-bottom: 20px; }
    .footer-desc { opacity: 0.7; line-height: 1.6; margin-bottom: 20px; font-size: 15px; }
    
    .footer-head { font-weight: 700; margin-bottom: 25px; font-size: 18px; border-bottom: 2px solid var(--primary); display: inline-block; padding-bottom: 5px; }
    
    .footer-links-list { list-style: none !important; padding: 0 !important; margin: 0 !important; }
    .footer-links-list li { margin-bottom: 12px; }
    .footer-links-list li a { text-decoration: none !important; opacity: 0.8; transition: 0.3s; }
    .footer-links-list li a:hover { opacity: 1; padding-left: 5px; color: var(--primary) !important; }

    .footer-social { display: flex; gap: 15px; }
    .footer-social a { color: #fff; font-size: 20px; opacity: 0.7; transition: 0.3s; }
    .footer-social a:hover { opacity: 1; color: var(--primary); }

    .footer-contact-info p { margin-bottom: 12px; opacity: 0.8; display: flex; align-items: center; gap: 10px; font-size: 15px; }
    .footer-contact-info i { color: var(--primary); }

    .footer-bottom-bar { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-top: 40px; }
    .fb-inner { display: flex; justify-content: space-between; align-items: center; opacity: 0.6; font-size: 14px; }
    @media (max-width: 575px) {
        .fb-inner { flex-direction: column; text-align: center; gap: 15px; }
    }
    .payment-icons img { max-height: 35px; filter: grayscale(1) invert(1); opacity: 0.8; }
</style>
