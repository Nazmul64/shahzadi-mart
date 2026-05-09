@php
    $logo = $block->content['logo'] ?? null;
    $menu = $block->content['menu_items'] ?? [];
    $sticky = $block->content['sticky'] ?? true;
    $bgColor = $block->content['bg_color'] ?? '#ffffff';
    $textColor = $block->content['text_color'] ?? '#333333';
    
    /* Dynamic Contact Info for Header */
    $phone = $block->content['phone'] ?? ($websetting?->phone ?? '');
    $email = $block->content['email'] ?? ($websetting?->email ?? '');
@endphp

<header class="header-classic" id="mainHeader" style="background: {{ $bgColor }};">
    {{-- Top Bar - Ultra Clean --}}
    @if($phone || $email)
    <div class="header-top-bar" id="headerTopBar" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 8px 0; background: #fdfdfd;">
        <div class="header-container">
            <div class="top-bar-inner" style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 500;">
                <div class="top-contact" style="display: flex; gap: 20px;">
                    @if($phone) <span style="display: flex; align-items: center; gap: 5px; color: #666;"><i class="bi bi-telephone-fill" style="color: var(--primary);"></i> {{ $phone }}</span> @endif
                    @if($email) <span class="hide-mobile" style="display: flex; align-items: center; gap: 5px; color: #666;"><i class="bi bi-envelope-fill" style="color: var(--primary);"></i> {{ $email }}</span> @endif
                </div>
                <div class="top-social" style="color: var(--primary); font-weight: 700;">
                    <i class="bi bi-lightning-charge-fill"></i> সারাদেশে ক্যাশ অন ডেলিভারি
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="header-container main-nav-container">
        <div class="header-inner-wrap">
            <div class="logo-area">
                @if($logo)
                    <a href="/"><img src="{{ asset('uploads/landing/blocks/'.$logo) }}" alt="Logo"></a>
                @else
                    <a href="/" style="text-decoration: none;"><h3 class="logo-text">{{ $websetting?->site_name ?? 'LOGO' }}</h3></a>
                @endif
            </div>
            
            <nav class="desktop-nav">
                <ul class="nav-list">
                    @foreach($menu as $item)
                        <li><a href="{{ $item['url'] }}" style="color: {{ $textColor }};">{{ $item['title'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <div class="header-actions">
                <a href="#order" class="btn-header-order hide-mobile">অর্ডার করুন <i class="bi bi-cart-plus-fill ms-1"></i></a>
                <button class="mobile-toggle" onclick="toggleMobileMenu()">
                    <i class="bi bi-grid-fill"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobileMenu" class="mobile-drawer">
    <div class="drawer-header">
        <div class="logo-text">{{ $websetting?->site_name ?? 'LOGO' }}</div>
        <button class="close-drawer" onclick="toggleMobileMenu()">&times;</button>
    </div>
    <ul class="drawer-links">
        @foreach($menu as $item)
            <li><a href="{{ $item['url'] }}" onclick="toggleMobileMenu()">{{ $item['title'] }}</a></li>
        @endforeach
        
        <li style="margin-top: 30px; list-style: none;">
            <a href="#order" class="btn-header-order" style="display: block; text-align: center; font-size: 18px;" onclick="toggleMobileMenu()">অর্ডার করুন</a>
        </li>

        @if($phone || $email)
        <li style="border-top: 1px solid #eee; margin-top: 30px; padding-top: 30px;">
            @if($phone) <p style="font-size: 15px; margin-bottom: 12px; font-weight: 600;"><i class="bi bi-telephone-fill me-2"></i> {{ $phone }}</p> @endif
            @if($email) <p style="font-size: 15px; font-weight: 600;"><i class="bi bi-envelope-fill me-2"></i> {{ $email }}</p> @endif
        </li>
        @endif
    </ul>
</div>

<script>
    (function() {
        const header = document.getElementById('mainHeader');
        const topBar = document.getElementById('headerTopBar');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 150) {
                header.classList.add('is-sticky');
                if (topBar) topBar.style.display = 'none';
            } else {
                header.classList.remove('is-sticky');
                if (topBar) topBar.style.display = 'block';
            }
        });

        if (typeof toggleMobileMenu !== 'function') {
            window.toggleMobileMenu = function() {
                const menu = document.getElementById('mobileMenu');
                if (menu) {
                    menu.classList.toggle('active');
                    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : 'auto';
                }
            }
        }
    })();
</script>

<style>
    .header-classic {
        background: #fff;
        z-index: 9999;
        width: 100%;
        display: block !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .header-classic.is-sticky {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        animation: slideInHeader 0.4s ease forwards;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px);
    }

    @keyframes slideInHeader {
        from { transform: translateY(-100%); }
        to { transform: translateY(0); }
    }

    .header-classic.is-sticky .header-inner-wrap { height: 70px; }
    
    .header-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .header-inner-wrap {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        height: 85px;
        transition: 0.3s;
    }
    
    .header-classic .logo-area img {
        max-height: 55px;
        width: auto;
        display: block;
        transition: 0.3s;
    }
    .header-classic.is-sticky .logo-area img { max-height: 45px; }
    
    .logo-text {
        font-weight: 900;
        font-size: 1.8rem;
        margin: 0;
        color: var(--primary) !important;
        font-family: 'Sora', sans-serif;
    }
    
    .nav-list {
        display: flex !important;
        list-style: none !important;
        gap: 15px !important;
        margin: 0 !important;
        padding: 0 !important;
        align-items: center;
    }
    .nav-list li a { 
        text-decoration: none; 
        font-weight: 700; 
        font-size: 15px; 
        transition: all 0.3s ease;
        padding: 10px 18px;
        border-radius: 12px;
        color: #333;
        font-family: 'Sora', sans-serif;
        display: inline-block;
    }
    .nav-list li a:hover { 
        background: rgba(var(--primary-rgb, 255, 77, 77), 0.08);
        color: var(--primary) !important;
        transform: translateY(-2px);
    }
    .nav-list li a::after { display: none !important; }

    .header-actions { display: flex; align-items: center; gap: 20px; }

    .mobile-toggle { 
        background: rgba(0,0,0,0.03); 
        border: none; 
        font-size: 24px; 
        color: var(--primary); 
        cursor: pointer; 
        display: none; 
        width: 45px;
        height: 45px;
        border-radius: 12px;
        transition: 0.3s;
    }
    .mobile-toggle:hover { background: rgba(0,0,0,0.07); }

    .mobile-drawer {
        position: fixed; top: 0; right: 0; width: 320px; height: 100%; background: #fff;
        z-index: 10000; transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1); padding: 40px 30px; box-shadow: -20px 0 50px rgba(0,0,0,0.15);
        color: #333; transform: translateX(100%); visibility: hidden;
    }
    .mobile-drawer.active { transform: translateX(0); visibility: visible; }

    .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; }
    .close-drawer { background: none; border: none; font-size: 35px; cursor: pointer; color: #999; }
    .drawer-links { list-style: none; padding: 0; }
    .drawer-links li { margin-bottom: 25px; }
    .drawer-links a { text-decoration: none; font-size: 20px; font-weight: 700; color: #1a2b6b; }

    @media (max-width: 991px) {
        .desktop-nav, .hide-mobile { display: none !important; }
        .mobile-toggle { display: flex !important; align-items: center; justify-content: center; }
        .header-inner-wrap { height: 75px; }
        .logo-text { font-size: 1.5rem; }
    }
</style>
