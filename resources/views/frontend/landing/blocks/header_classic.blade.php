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

<header class="header-classic {{ $sticky ? 'sticky-top' : '' }}" style="background: {{ $bgColor }}; color: {{ $textColor }};">
    {{-- Top Bar --}}
    @if($phone || $email)
    <div class="header-top-bar" style="background: rgba(0,0,0,0.03); border-bottom: 1px solid rgba(0,0,0,0.05); padding: 5px 0;">
        <div class="header-container">
            <div class="top-bar-inner" style="display: flex; justify-content: space-between; font-size: 13px; opacity: 0.8;">
                <div class="top-contact">
                    @if($phone) <span style="margin-right: 15px;"><i class="bi bi-telephone"></i> {{ $phone }}</span> @endif
                    @if($email) <span><i class="bi bi-envelope"></i> {{ $email }}</span> @endif
                </div>
                <div class="top-social hide-mobile">
                    🔥 সারাদেশে ক্যাশ অন ডেলিভারি
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="header-container">
        <div class="header-inner-wrap">
            <div class="logo-area">
                @if($logo)
                    <img src="{{ asset('uploads/landing/blocks/'.$logo) }}" alt="Logo">
                @else
                    <h3 class="logo-text">{{ $websetting?->site_name ?? 'LOGO' }}</h3>
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
                <a href="#order" class="btn-header-order hide-mobile">অর্ডার করুন</a>
                <button class="mobile-toggle" onclick="toggleMobileMenu()">
                    <i class="bi bi-list"></i>
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
        
        @if($phone || $email)
        <li style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
            @if($phone) <p style="font-size: 14px; margin-bottom: 10px;"><i class="bi bi-telephone"></i> {{ $phone }}</p> @endif
            @if($email) <p style="font-size: 14px;"><i class="bi bi-envelope"></i> {{ $email }}</p> @endif
        </li>
        @endif

        <li style="margin-top: 30px; list-style: none;">
            <a href="#order" class="btn-header-order" style="display: block; text-align: center;" onclick="toggleMobileMenu()">অর্ডার করুন</a>
        </li>
    </ul>
</div>

<script>
    if (typeof toggleMobileMenu !== 'function') {
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('active');
                document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : 'auto';
            }
        }
    }
</script>

<style>
    .header-classic {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        z-index: 9999;
        transition: all 0.3s ease;
        width: 100%;
        display: block !important;
        overflow-x: hidden;
    }

    .sticky-top { position: sticky; top: 0; }
    
    .header-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .header-inner-wrap {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        height: 70px;
    }
    
    .header-classic .logo-area img {
        max-height: 45px;
        width: auto;
        display: block;
    }
    
    .logo-text {
        font-weight: 800;
        font-size: 1.5rem;
        margin: 0;
        color: var(--primary) !important;
    }
    
    .nav-list {
        display: flex !important;
        list-style: none !important;
        gap: 30px !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .nav-list a { text-decoration: none; font-weight: 600; font-size: 15px; transition: 0.3s; }
    .nav-list a:hover { color: var(--primary) !important; }

    .btn-header-order {
        background: var(--primary);
        color: #fff !important;
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: 0.3s;
        border: none;
    }
    .btn-header-order:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    .mobile-toggle { background: none; border: none; font-size: 28px; color: inherit; cursor: pointer; display: none; }

    .mobile-drawer {
        position: fixed; top: 0; right: 0; width: 300px; height: 100%; background: #fff;
        z-index: 10000; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); padding: 30px; box-shadow: -10px 0 30px rgba(0,0,0,0.1);
        color: #333; transform: translateX(100%); visibility: hidden;
    }
    .mobile-drawer.active { transform: translateX(0); visibility: visible; }

    .drawer-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .close-drawer { background: none; border: none; font-size: 32px; cursor: pointer; }
    .drawer-links { list-style: none; padding: 0; }
    .drawer-links li { margin-bottom: 20px; }
    .drawer-links a { text-decoration: none; font-size: 18px; font-weight: 600; color: #333; }

    @media (max-width: 991px) {
        .desktop-nav, .hide-mobile { display: none !important; }
        .mobile-toggle { display: block !important; }
        .header-inner-wrap { height: 60px; }
    }
</style>
