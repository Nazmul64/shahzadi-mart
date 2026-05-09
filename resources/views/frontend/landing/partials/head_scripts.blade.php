@php
    $gs = \App\Models\Generalsetting::first();
    $final_gtm_id = ($gs->gtm_status && $gs->gtm_id) ? $gs->gtm_id : null;
    $final_ga_id = ($gs->analytics_status && $gs->analytics_id) ? $gs->analytics_id : null;
    $final_fb_pixel_id = ($gs->facebook_pixel_status && $gs->facebook_pixel_id) ? $gs->facebook_pixel_id : null;
@endphp

@if($final_gtm_id)
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $final_gtm_id }}');</script>
<!-- End Google Tag Manager -->
@endif

@if($final_ga_id)
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $final_ga_id }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $final_ga_id }}');
</script>
@endif

@if($final_fb_pixel_id)
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $final_fb_pixel_id }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $final_fb_pixel_id }}&ev=PageView&noscript=1"
/></noscript>
@endif

<style>
    #pro-toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    .pro-toast {
        background: #1a2b6b;
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        animation: toast-slide-in 0.4s ease forwards;
        border-left: 4px solid #10b981;
    }
    @keyframes toast-slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .pro-toast.fade-out {
        animation: toast-fade-out 0.4s ease forwards;
    }
    @keyframes toast-fade-out {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    /* Global Resets */
    * { 
        box-sizing: border-box !important; 
    }
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden !important;
        width: 100% !important;
        position: relative;
    }

    /* Global Container/Full-Width Control */
    @if($landing->is_full_width)
        .container, .pg-container, .ps-container { 
            width: 100% !important; 
            max-width: 100% !important; 
            padding-left: 15px !important; 
            padding-right: 15px !important; 
            margin: 0 auto !important;
        }
    @else
        .container, .pg-container, .ps-container { 
            max-width: 1200px !important; 
            width: 95% !important; 
            margin-left: auto !important; 
            margin-right: auto !important; 
            padding-left: 15px !important; 
            padding-right: 15px !important; 
        }
    @endif

    /* Global Button Design Redesign */
    .cta-btn, .buy-btn, .confirm-btn-pro, .order-btn, .btn-header-order, .sticky-btn {
        background: linear-gradient(45deg, var(--primary-color, #ff4d4d), var(--primary-color, #ff4d4d)) !important;
        background-color: var(--primary-color, #ff4d4d) !important;
        color: #fff !important;
        border: none !important;
        padding: 15px 35px !important;
        border-radius: 50px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        display: block !important;
        width: fit-content !important;
        margin: 25px auto !important;
        text-align: center;
        cursor: pointer;
    }

    .cta-btn:hover, .buy-btn:hover, .confirm-btn-pro:hover, .order-btn:hover {
        transform: translateY(-3px) scale(1.02) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3) !important;
        filter: brightness(1.1);
    }

    /* Sticky Header Enforcement */
    .header-classic, .header-bar, .default-header, header {
        position: sticky !important;
        top: 0 !important;
        z-index: 1000 !important;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1) !important;
    }

    /* Global Responsive Adjustments */
    @media (max-width: 768px) {
        .container, .pg-container, .ps-container, .header-container, .footer-container, .order-form-container { 
            width: 100% !important; 
            max-width: 100% !important;
            padding-left: 15px !important; 
            padding-right: 15px !important; 
            margin-left: 0 !important;
            margin-right: 0 !important;
            box-sizing: border-box !important;
            float: none !important;
        }
        
        .cta-btn, .buy-btn, .confirm-btn-pro, .btn-header-order, .order-btn {
            width: 90% !important;
            padding: 12px 20px !important;
            font-size: 16px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            display: block !important;
        }

        h1, h2, h3, .section-title { 
            font-size: 1.25rem !important; 
            word-wrap: break-word !important; 
            text-align: center !important; 
            width: 100% !important;
            padding: 0 5px !important;
            line-height: 1.2 !important;
        }
        
        .single-line-mobile {
            white-space: nowrap !important;
            font-size: clamp(14px, 4vw, 18px) !important;
        }
        
        p { font-size: 0.95rem !important; text-align: center !important; }
        
        img { 
            max-width: 100% !important; 
            height: auto !important; 
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
    /* Premium Button Design */
    .cta-btn, .submit-btn, .elegant-cta-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, #000 150%) !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        backdrop-filter: blur(5px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }
    .cta-btn:hover, .submit-btn:hover, .elegant-cta-btn:hover {
        transform: translateY(-5px) scale(1.02) !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4), 0 0 20px var(--primary-color) !important;
        filter: brightness(1.1);
    }
    .cta-btn::after, .submit-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        transition: 0.6s;
    }
    .cta-btn:hover::after, .submit-btn:hover::after {
        left: 120%;
    }
</style>
<script>
    window.showProToast = function(message) {
        var container = document.getElementById('pro-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'pro-toast-container';
            document.body.appendChild(container);
        }
        var toast = document.createElement('div');
        toast.className = 'pro-toast';
        toast.innerHTML = `<i class="bi bi-check-circle-fill" style="color: #10b981;"></i> ${message}`;
        container.appendChild(toast);
        
        setTimeout(function() {
            toast.classList.add('fade-out');
            setTimeout(function() { toast.remove(); }, 400);
        }, 3000);
    };
</script>
<script>
    // ── GTM/GA4 DataLayer Events ──
    (function() {
        window.dataLayer = window.dataLayer || [];
        
        @php
            $lProd = $landing->product;
            $pPrice = (float)($lProd->discount_price ?? $lProd->current_price ?? 0);
        @endphp

        @if($lProd)
        @php
            $formattedPrice = number_format($pPrice, 2, '.', '');
        @endphp
        // 1. view_item on Page Load
        window.dataLayer.push({
            'event': 'view_item',
            'ecommerce': {
                'currency': 'BDT',
                'value': {{ $formattedPrice }},
                'items': [{
                    'item_name': '{{ addslashes($lProd->name) }}',
                    'item_id': '{{ $lProd->id }}',
                    'price': {{ $formattedPrice }},
                    'item_brand': '{{ addslashes($gs->site_name) }}',
                    'quantity': 1
                }]
            }
        });

        // 2. add_to_cart on CTA Click
        document.addEventListener('click', function(e) {
            if (e.target.closest('.cta-btn, .buy-btn, .order-btn')) {
                window.dataLayer.push({
                    'event': 'add_to_cart',
                    'ecommerce': {
                        'currency': 'BDT',
                        'value': {{ $formattedPrice }},
                        'items': [{
                            'item_name': '{{ addslashes($lProd->name) }}',
                            'item_id': '{{ $lProd->id }}',
                            'price': {{ $formattedPrice }},
                            'item_brand': '{{ addslashes($gs->site_name) }}',
                            'quantity': 1
                        }]
                    }
                });
            }
        });
        @endif
    })();
</script>
