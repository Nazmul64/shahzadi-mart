{{-- resources/views/frontend/pages/header.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shahzadimart Shop</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset($websitefavicon->favicon_logo ?? 'default/favicon.png') }}">

    {{-- Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    {{-- jQuery (before Bootstrap JS) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    /* ═══════════════════════════════════════════════════════════
       DESIGN TOKENS
    ═══════════════════════════════════════════════════════════ */
    :root {
        --red:        #C8102E;
        --red-d:      #a00d25;
        --red-glow:   rgba(200,16,46,.12);
        --gold:       #D4A843;
        --gold-lt:    #f0c96a;
        --dark:       #0f0f0f;
        --dark2:      #1a1a1a;
        --dark3:      #242424;
        --mid:        #555;
        --light:      #f4f1ed;
        --lighter:    #faf9f7;
        --border:     #e6dfd6;
        --border-d:   #ccc3b8;
        --text:       #1e1e1e;
        --muted:      #8a8a8a;
        --white:      #ffffff;
        --sh1:        0 1px 4px rgba(0,0,0,.06);
        --sh2:        0 4px 20px rgba(0,0,0,.10);
        --sh3:        0 8px 40px rgba(0,0,0,.15);
        --sh-red:     0 6px 24px rgba(200,16,46,.25);
        --r:          5px;
        --rm:         10px;
        --rl:         16px;
        --ease:       cubic-bezier(.4,0,.2,1);
        --bounce:     cubic-bezier(.34,1.56,.64,1);
        --t:          all .22s var(--ease);
        --wrap:       1440px;
        --sb:         260px;
        --hdr:        64px;
        --mob-nav:    60px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
        font-family: 'Nunito', sans-serif;
        background: var(--lighter);
        color: var(--text);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }
    img { display: block; max-width: 100%; }
    a   { text-decoration: none; color: inherit; }
    ul  { list-style: none; padding: 0; margin: 0; }

    /* ═══════════════════════════════════════════════════════════
       TOP ANNOUNCEMENT BAR
    ═══════════════════════════════════════════════════════════ */
    .top-bar {
        background: var(--dark);
        border-bottom: 1px solid #1a1a1a;
    }
    .top-bar__in {
        max-width: var(--wrap); margin: 0 auto;
        padding: 7px 20px;
        display: flex; align-items: center; gap: 20px;
    }
    .top-bar__promo {
        flex: 1;
        font-size: 11.5px; font-weight: 700;
        color: var(--gold); letter-spacing: .07em;
        display: flex; align-items: center; gap: 7px;
    }
    .top-bar__dot {
        width: 5px; height: 5px;
        background: var(--gold); border-radius: 50%;
        animation: pulse-dot 2s ease-in-out infinite; flex-shrink: 0;
    }
    @keyframes pulse-dot {
        0%,100% { opacity: 1; transform: scale(1); }
        50%      { opacity: .4; transform: scale(.65); }
    }
    .top-bar__nav { display: flex; align-items: center; gap: 20px; }
    .top-bar__nav a {
        color: #666; font-size: 11px; font-weight: 600;
        letter-spacing: .06em; text-transform: uppercase;
        display: flex; align-items: center; gap: 5px; transition: color .2s;
    }
    .top-bar__nav a:hover { color: var(--gold); }
    .top-bar__track {
        display: flex !important; align-items: center; gap: 6px;
        color: #fff !important;
        background: var(--red) !important;
        padding: 3px 11px !important;
        border-radius: 20px !important;
        font-size: 10.5px !important;
        font-weight: 800 !important;
        letter-spacing: .06em !important;
        text-transform: uppercase !important;
        white-space: nowrap;
    }
    .top-bar__track:hover { background: var(--red-d) !important; color: #fff !important; }

    /* ═══════════════════════════════════════════════════════════
       MAIN HEADER
    ═══════════════════════════════════════════════════════════ */
    .site-hdr {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; z-index: 900;
        box-shadow: var(--sh2);
    }
    .site-hdr__in {
        max-width: var(--wrap); margin: 0 auto;
        padding: 0 20px; height: var(--hdr);
        display: flex; align-items: center; gap: 14px;
    }

    /* ── Hamburger ── */
    .hamb {
        display: none;
        background: none; border: 1.5px solid var(--border);
        cursor: pointer; padding: 7px 9px; border-radius: var(--r);
        color: var(--text); font-size: 18px; flex-shrink: 0;
        transition: var(--t); align-items: center; justify-content: center;
        line-height: 1;
    }
    .hamb:hover { border-color: var(--red); color: var(--red); background: var(--red-glow); }

    /* ── Logo ── */
    .logo {
        font-family: 'Fraunces', serif;
        font-size: 22px; font-weight: 900;
        letter-spacing: -.03em; color: var(--dark);
        white-space: nowrap; flex-shrink: 0;
        display: flex; align-items: center; gap: 1px;
    }
    .logo__dot {
        width: 6px; height: 6px; background: var(--gold);
        border-radius: 50%; margin-left: 2px; flex-shrink: 0;
        animation: pulse-dot 2.5s ease-in-out infinite;
    }

    /* ═══════════════════════════════════════════════════════════
       SEARCH WITH AJAX DROPDOWN
    ═══════════════════════════════════════════════════════════ */
    .hdr-search-wrap {
        flex: 1; position: relative; min-width: 0;
    }
    .hdr-search {
        display: flex; align-items: center;
        background: var(--light); border: 1.5px solid var(--border);
        border-radius: 50px; overflow: hidden; transition: var(--t);
    }
    .hdr-search.focused {
        border-color: var(--red); background: var(--white);
        box-shadow: 0 0 0 3px var(--red-glow);
    }
    .hdr-search.has-results {
        border-radius: 20px 20px 0 0;
        border-bottom-color: transparent;
    }
    .hdr-search input {
        flex: 1; border: none; background: transparent;
        padding: 10px 18px; font-family: 'Nunito', sans-serif;
        font-size: 13.5px; color: var(--text); outline: none; min-width: 0;
    }
    .hdr-search input::placeholder { color: var(--muted); }
    .hdr-search__btn {
        background: var(--red); color: var(--white); border: none;
        padding: 10px 22px; font-family: 'Nunito', sans-serif;
        font-size: 13px; font-weight: 800; cursor: pointer;
        display: flex; align-items: center; gap: 6px;
        white-space: nowrap; transition: var(--t); flex-shrink: 0;
        border-radius: 0 50px 50px 0;
    }
    .hdr-search.has-results .hdr-search__btn { border-radius: 0 20px 0 0; }
    .hdr-search__btn:hover { background: var(--red-d); }

    .search-clear {
        background: none; border: none; cursor: pointer;
        color: var(--muted); font-size: 14px; padding: 0 6px;
        display: none; align-items: center; transition: color .2s;
        flex-shrink: 0;
    }
    .search-clear:hover { color: var(--red); }
    .search-clear.visible { display: flex; }

    .search-dropdown {
        position: absolute; top: 100%; left: 0; right: 0;
        background: var(--white);
        border: 1.5px solid var(--red);
        border-top: none;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 12px 40px rgba(0,0,0,.14);
        z-index: 999;
        max-height: 480px; overflow-y: auto;
        display: none;
        scrollbar-width: thin; scrollbar-color: var(--border) transparent;
    }
    .search-dropdown.active { display: block; }
    .search-dropdown::-webkit-scrollbar { width: 4px; }
    .search-dropdown::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .search-loading {
        padding: 20px; text-align: center;
        color: var(--muted); font-size: 13px;
        display: none; align-items: center; justify-content: center; gap: 8px;
    }
    .search-loading.active { display: flex; }
    .search-spinner {
        width: 16px; height: 16px;
        border: 2px solid var(--border);
        border-top-color: var(--red);
        border-radius: 50%;
        animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .sd-section-hd {
        padding: 10px 16px 6px;
        font-size: 10px; font-weight: 800;
        letter-spacing: .14em; text-transform: uppercase;
        color: var(--muted);
        border-top: 1px solid var(--border);
        display: flex; align-items: center; gap: 6px;
    }
    .sd-section-hd:first-child { border-top: none; }
    .sd-section-hd i { font-size: 11px; color: var(--red); }

    .sd-cat-item {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 16px; cursor: pointer;
        transition: background .18s;
        text-decoration: none; color: var(--text);
    }
    .sd-cat-item:hover { background: var(--light); }
    .sd-cat-img {
        width: 30px; height: 30px; border-radius: 50%;
        overflow: hidden; flex-shrink: 0;
        border: 1px solid var(--border);
    }
    .sd-cat-img img { width: 100%; height: 100%; object-fit: cover; }
    .sd-cat-name { font-size: 13px; font-weight: 600; }

    .sd-prod-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 16px; cursor: pointer;
        transition: background .18s; border-bottom: 1px solid rgba(0,0,0,.04);
        text-decoration: none; color: var(--text);
    }
    .sd-prod-item:last-child { border-bottom: none; }
    .sd-prod-item:hover { background: var(--light); }
    .sd-prod-img {
        width: 48px; height: 48px; border-radius: var(--r);
        overflow: hidden; flex-shrink: 0;
        border: 1px solid var(--border);
    }
    .sd-prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .sd-prod-info { flex: 1; min-width: 0; }
    .sd-prod-name {
        font-size: 13px; font-weight: 600; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 3px;
    }
    .sd-prod-cat { font-size: 11px; color: var(--muted); font-weight: 500; }
    .sd-prod-price-wrap { text-align: right; flex-shrink: 0; }
    .sd-prod-price { font-size: 14px; font-weight: 800; color: var(--red); }
    .sd-prod-old { font-size: 11px; color: var(--muted); text-decoration: line-through; }
    .sd-prod-badge {
        display: inline-block;
        background: #fef3c7; color: #92400e;
        font-size: 9px; font-weight: 800;
        padding: 1px 6px; border-radius: 4px;
        margin-top: 2px; letter-spacing: .04em;
    }
    .sd-prod-badge.out { background: #fee2e2; color: #991b1b; }
    .sd-empty {
        padding: 28px 16px; text-align: center;
        color: var(--muted); font-size: 13px;
    }
    .sd-empty i { font-size: 28px; display: block; margin-bottom: 8px; opacity: .4; }
    .sd-view-all {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 12px; background: var(--light);
        border-top: 1px solid var(--border);
        font-size: 12.5px; font-weight: 800;
        color: var(--red); text-decoration: none;
        border-radius: 0 0 18px 18px;
        transition: background .2s;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .sd-view-all:hover { background: var(--red-glow); }
    .search-highlight {
        background: rgba(200,16,46,.12);
        color: var(--red);
        border-radius: 2px; padding: 0 1px; font-weight: 800;
    }

    /* ═══════════════════════════════════════════════════════════
       TRACK ORDER BUTTON (Desktop Header)
    ═══════════════════════════════════════════════════════════ */
    .track-order-btn {
        display: flex; align-items: center; gap: 7px;
        background: transparent;
        border: 2px solid var(--red);
        color: var(--red);
        padding: 7px 16px;
        border-radius: 50px;
        font-family: 'Nunito', sans-serif;
        font-size: 13px; font-weight: 800;
        cursor: pointer; white-space: nowrap; flex-shrink: 0;
        transition: var(--t); text-decoration: none; letter-spacing: .02em;
    }
    .track-order-btn .bi { font-size: 16px; transition: transform .3s var(--ease); }
    .track-order-btn:hover {
        background: var(--red); color: var(--white);
        box-shadow: var(--sh-red); transform: translateY(-1px);
    }
    .track-order-btn:hover .bi { transform: translateX(3px); }

    /* ═══════════════════════════════════════════════════════════
       ACTION ICONS
    ═══════════════════════════════════════════════════════════ */
    .hdr-actions { display: flex; align-items: center; gap: 2px; flex-shrink: 0; }
    .h-act {
        position: relative; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 2px;
        padding: 7px 11px; border-radius: var(--rm); color: var(--text);
        cursor: pointer; transition: var(--t); min-width: 52px;
        text-decoration: none; border: 1.5px solid transparent;
    }
    .h-act:hover {
        background: var(--red-glow); border-color: rgba(200,16,46,.15);
        color: var(--red); transform: translateY(-1px);
    }
    .h-act .bi { font-size: 20px; line-height: 1; }
    .h-act__lbl { font-size: 8.5px; font-weight: 800; letter-spacing: .09em; text-transform: uppercase; line-height: 1; }
    .h-badge {
        position: absolute; top: 3px; right: 3px;
        background: var(--red); color: #fff;
        font-size: 8.5px; font-weight: 900;
        min-width: 17px; height: 17px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px; border: 2px solid var(--white);
        animation: badge-pop .3s var(--bounce) both;
    }
    .h-badge.zero { display: none; }
    @keyframes badge-pop { from { transform: scale(0); } to { transform: scale(1); } }

    /* ═══════════════════════════════════════════════════════════
       SHARED HOVER DROPDOWN
    ═══════════════════════════════════════════════════════════ */
    .hdr-drop-wrap { position: relative; }
    .hdr-drop {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--rl); box-shadow: var(--sh3);
        z-index: 950;
        opacity: 0; visibility: hidden;
        transform: translateY(-8px) scale(.97);
        transition: all .25s var(--ease); overflow: hidden;
    }
    .hdr-drop-wrap:hover .hdr-drop { opacity: 1; visibility: visible; transform: none; }

    /* ── Account dropdown ── */
    .acct-drop { min-width: 230px; }
    .acct-drop__hd {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 16px 14px; text-align: center;
    }
    .acct-drop__hd p { color: #777; font-size: 11.5px; margin-bottom: 10px; letter-spacing: .04em; }
    .acct-drop__hd .user-greeting {
        color: #ccc; font-weight: 700; font-size: 13px;
        margin-bottom: 6px; display: block;
    }
    .acct-drop__hd .user-email {
        color: #666; font-size: 10.5px; margin-bottom: 10px; display: block;
    }

    /* ── Dashboard Button (logged in) ── */
    .acct-dash-btn {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        width: 100%; background: var(--red); color: #fff;
        border: none; padding: 9px 0; border-radius: 30px;
        font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800;
        cursor: pointer; transition: var(--t); text-decoration: none;
        letter-spacing: .03em;
    }
    .acct-dash-btn:hover { background: var(--red-d); color: #fff; }
    .acct-dash-btn .bi { font-size: 14px; }

    /* ── Sign In Button (guest) ── */
    .acct-signin {
        width: 100%; background: var(--red); color: #fff;
        border: none; padding: 9px 0; border-radius: 30px;
        font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800;
        cursor: pointer; transition: var(--t);
    }
    .acct-signin:hover { background: var(--red-d); }

    .acct-drop a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; font-size: 13px; font-weight: 600; color: var(--text);
        border-bottom: 1px solid var(--border); transition: var(--t);
    }
    .acct-drop a:last-child { border-bottom: none; }
    .acct-drop a:hover { background: var(--light); color: var(--red); padding-left: 20px; }
    .acct-drop a .bi { font-size: 14px; color: var(--muted); flex-shrink: 0; }
    .acct-drop a:hover .bi { color: var(--red); }
    .acct-drop .logout { color: var(--red); }
    .acct-drop .logout .bi { color: var(--red); }

    /* ── Wishlist Dropdown ── */
    .wish-drop { min-width: 320px; max-width: 340px; }
    .wish-drop__hd {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 13px 16px;
        display: flex; align-items: center; gap: 8px;
    }
    .wish-drop__hd i { color: #f87171; font-size: 15px; }
    .wish-drop__hd span { color: var(--white); font-size: 12px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; flex: 1; }
    .wish-drop__hd .wish-count-pill {
        background: var(--red); color: #fff;
        font-size: 10px; font-weight: 900;
        padding: 2px 8px; border-radius: 20px;
    }
    .wish-drop__body {
        max-height: 320px; overflow-y: auto;
        scrollbar-width: thin; scrollbar-color: var(--border) transparent;
    }
    .wish-drop__body::-webkit-scrollbar { width: 3px; }
    .wish-drop__body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .wish-item {
        display: flex; align-items: center; gap: 11px;
        padding: 10px 14px; border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .wish-item:last-child { border-bottom: none; }
    .wish-item:hover { background: var(--light); }
    .wish-item__img {
        width: 46px; height: 46px; border-radius: var(--r);
        overflow: hidden; flex-shrink: 0;
        border: 1px solid var(--border);
    }
    .wish-item__img img { width: 100%; height: 100%; object-fit: cover; }
    .wish-item__info { flex: 1; min-width: 0; }
    .wish-item__name {
        font-size: 12.5px; font-weight: 700; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        display: block; text-decoration: none; margin-bottom: 2px;
        transition: color .15s;
    }
    .wish-item:hover .wish-item__name { color: var(--red); }
    .wish-item__price { font-size: 13px; font-weight: 800; color: var(--red); }
    .wish-item__old  { font-size: 10.5px; color: var(--muted); text-decoration: line-through; margin-left: 4px; }
    .wish-item__add {
        width: 30px; height: 30px; flex-shrink: 0;
        background: var(--red-glow); border: 1.5px solid rgba(200,16,46,.25);
        border-radius: var(--r); color: var(--red);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; cursor: pointer; transition: var(--t);
        text-decoration: none;
    }
    .wish-item__add:hover { background: var(--red); color: var(--white); }
    .wish-drop__empty {
        padding: 30px 16px; text-align: center;
        color: var(--muted); font-size: 13px;
    }
    .wish-drop__empty i { font-size: 30px; display: block; margin-bottom: 8px; opacity: .4; }
    .wish-drop__foot {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 11px; background: var(--light);
        border-top: 1px solid var(--border);
        font-size: 12px; font-weight: 800;
        color: var(--red); text-decoration: none;
        transition: background .2s;
        letter-spacing: .04em; text-transform: uppercase;
    }
    .wish-drop__foot:hover { background: var(--red-glow); }

    /* ── Cart Dropdown ── */
    .cart-drop { min-width: 330px; max-width: 360px; }
    .cart-drop__hd {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 13px 16px;
        display: flex; align-items: center; gap: 8px;
    }
    .cart-drop__hd i { color: var(--gold); font-size: 15px; }
    .cart-drop__hd span { color: var(--white); font-size: 12px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; flex: 1; }
    .cart-drop__hd .cart-count-pill {
        background: var(--red); color: #fff;
        font-size: 10px; font-weight: 900;
        padding: 2px 8px; border-radius: 20px;
    }
    .cart-drop__body {
        max-height: 300px; overflow-y: auto;
        scrollbar-width: thin; scrollbar-color: var(--border) transparent;
    }
    .cart-drop__body::-webkit-scrollbar { width: 3px; }
    .cart-drop__body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .cart-mini-item {
        display: flex; align-items: center; gap: 11px;
        padding: 10px 14px; border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .cart-mini-item:last-child { border-bottom: none; }
    .cart-mini-item:hover { background: var(--light); }
    .cart-mini-img {
        width: 46px; height: 46px; border-radius: var(--r);
        overflow: hidden; flex-shrink: 0;
        border: 1px solid var(--border);
        position: relative;
    }
    .cart-mini-img img { width: 100%; height: 100%; object-fit: cover; }
    .cart-mini-qty {
        position: absolute; bottom: -4px; right: -4px;
        background: var(--red); color: #fff;
        font-size: 8px; font-weight: 900;
        min-width: 16px; height: 16px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        border: 1.5px solid var(--white);
    }
    .cart-mini-info { flex: 1; min-width: 0; }
    .cart-mini-name {
        font-size: 12.5px; font-weight: 700; color: var(--text);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        display: block; text-decoration: none; margin-bottom: 2px;
        transition: color .15s;
    }
    .cart-mini-item:hover .cart-mini-name { color: var(--red); }
    .cart-mini-variants { font-size: 10.5px; color: var(--muted); font-weight: 500; }
    .cart-mini-price { font-size: 13px; font-weight: 800; color: var(--red); white-space: nowrap; }
    .cart-mini-remove {
        width: 24px; height: 24px; flex-shrink: 0;
        background: #fff5f5; border: 1px solid #fecdd3;
        border-radius: 5px; color: #f43f5e;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; cursor: pointer; transition: var(--t);
        text-decoration: none;
    }
    .cart-mini-remove:hover { background: var(--red); border-color: var(--red); color: var(--white); }
    .cart-drop__empty {
        padding: 30px 16px; text-align: center;
        color: var(--muted); font-size: 13px;
    }
    .cart-drop__empty i { font-size: 30px; display: block; margin-bottom: 8px; opacity: .4; }
    .cart-drop__summary {
        padding: 12px 14px; background: var(--lighter);
        border-top: 1px solid var(--border);
    }
    .cart-drop__total {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 10px;
    }
    .cart-drop__total-lbl { font-size: 12px; font-weight: 700; color: var(--mid); text-transform: uppercase; letter-spacing: .06em; }
    .cart-drop__total-val { font-size: 17px; font-weight: 900; color: var(--dark); }
    .cart-drop__btns { display: flex; gap: 8px; }
    .cart-drop__btn {
        flex: 1; padding: 9px 10px; border-radius: var(--rm);
        font-family: 'Nunito', sans-serif; font-size: 12.5px; font-weight: 800;
        text-align: center; text-decoration: none; transition: var(--t);
        display: flex; align-items: center; justify-content: center; gap: 5px;
        cursor: pointer; border: none; letter-spacing: .02em;
    }
    .cart-drop__btn--view {
        background: var(--light); color: var(--text);
        border: 1.5px solid var(--border);
    }
    .cart-drop__btn--view:hover { border-color: var(--red); color: var(--red); background: var(--red-glow); }
    .cart-drop__btn--checkout {
        background: var(--red); color: var(--white);
    }
    .cart-drop__btn--checkout:hover { background: var(--red-d); box-shadow: var(--sh-red); }

    /* ═══════════════════════════════════════════════════════════
       NAV BAR
    ═══════════════════════════════════════════════════════════ */
    .site-nav {
        background: var(--white);
        border-bottom: 2px solid var(--border);
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }
    .site-nav__in {
        max-width: var(--wrap); margin: 0 auto;
        padding: 0 20px;
        display: flex; align-items: center;
        height: 46px;
        overflow-x: auto; scrollbar-width: none; -ms-overflow-style: none;
    }
    .site-nav__in::-webkit-scrollbar { display: none; }
    .nav-item {
        display: flex; align-items: center; gap: 7px;
        padding: 0 16px; height: 100%;
        font-size: 13px; font-weight: 700; color: var(--mid);
        white-space: nowrap; cursor: pointer; text-decoration: none;
        border-bottom: 2px solid transparent; margin-bottom: -2px;
        transition: color .2s, border-color .2s; position: relative;
    }
    .nav-item .bi, .nav-item i { font-size: 15px; flex-shrink: 0; }
    .nav-item:hover { color: var(--dark); border-color: var(--red); }
    .nav-item.active { color: var(--red); border-color: var(--red); }
    .nav-item--track {
        color: var(--red) !important; font-weight: 800;
        margin-left: auto;
        background: var(--red-glow);
        border-radius: var(--rm) var(--rm) 0 0;
        padding: 0 18px;
        border-bottom: 2px solid var(--red) !important;
    }
    .nav-item--track:hover { background: rgba(200,16,46,.18); }
    .nav-item--track .bi { animation: truck-ride 2.4s ease-in-out infinite; }
    @keyframes truck-ride {
        0%,100% { transform: translateX(0); }
        50%      { transform: translateX(4px); }
    }
    .nav-divider { width: 1px; height: 22px; background: var(--border); flex-shrink: 0; margin: 0 4px; }

    /* ── Sidebar overlay ── */
    .sidebar-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.52); backdrop-filter: blur(3px); z-index: 860;
    }
    .sidebar-overlay.active { display: block; }

    /* ═══════════════════════════════════════════════════════════
       PAGE LAYOUT
    ═══════════════════════════════════════════════════════════ */
    .page-wrap {
        max-width: var(--wrap); margin: 0 auto;
        padding: 20px 20px 60px;
        display: grid;
        grid-template-columns: var(--sb) 1fr;
        gap: 20px; align-items: start;
    }
    .content-area { min-width: 0; }
    .content-area-inner { padding: 0 4px; }

    /* ═══════════════════════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════════════════════ */
    .sidebar {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--rl); overflow: hidden;
        position: sticky; top: calc(var(--hdr) + 46px + 12px);
        max-height: calc(100vh - var(--hdr) - 46px - 24px);
        overflow-y: auto; box-shadow: var(--sh1);
        scrollbar-width: thin; scrollbar-color: var(--border) transparent;
    }
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
    .sb-head {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 13px 16px; display: flex; align-items: center; gap: 9px;
        border-bottom: 2px solid var(--red); position: sticky; top: 0; z-index: 2;
    }
    .sb-head .bi { color: var(--gold); font-size: 15px; }
    .sb-head span { color: var(--white); font-size: 10px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
    .cat-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 14px; cursor: pointer;
        border-bottom: 1px solid var(--border); transition: var(--t);
        position: relative; overflow: hidden;
    }
    .cat-row::before {
        content: ''; position: absolute; left: 0; top: 0;
        width: 3px; height: 100%; background: var(--red);
        border-radius: 0 2px 2px 0; transform: scaleY(0);
        transition: transform .22s var(--ease);
    }
    .cat-row:hover::before, .cat-row.open::before { transform: scaleY(1); }
    .cat-row:hover, .cat-row.open { background: rgba(200,16,46,.04); }
    .cat-row__left { display: flex; align-items: center; gap: 9px; min-width: 0; }
    .cat-icon {
        width: 30px; height: 30px; background: var(--light); border-radius: var(--r);
        display: flex; align-items: center; justify-content: center;
        color: var(--mid); transition: var(--t); flex-shrink: 0;
    }
    .cat-icon .bi { font-size: 14px; }
    .cat-row:hover .cat-icon, .cat-row.open .cat-icon { background: rgba(200,16,46,.1); color: var(--red); }
    .cat-row__label { font-size: 13px; font-weight: 600; color: var(--text); transition: color .2s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cat-row:hover .cat-row__label, .cat-row.open .cat-row__label { color: var(--red); }
    .cat-arrow { font-size: 11px; color: var(--muted); transition: transform .28s var(--ease); flex-shrink: 0; }
    .cat-row.open .cat-arrow { transform: rotate(180deg); color: var(--red); }
    .sub-menu { background: var(--lighter); overflow: hidden; max-height: 0; transition: max-height .38s var(--ease); border-bottom: 1px solid var(--border); }
    .sub-menu.open { max-height: 9999px; }
    .sub-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8.5px 14px 8.5px 50px; font-size: 12.5px; font-weight: 600;
        color: var(--mid); cursor: pointer; border-bottom: 1px solid rgba(0,0,0,.04);
        transition: var(--t); position: relative;
    }
    .sub-row::before { content: '›'; position: absolute; left: 34px; color: var(--border-d); font-size: 17px; line-height: 1; }
    .sub-row:hover, .sub-row.open { background: rgba(200,16,46,.07); color: var(--red); }
    .sub-row:hover::before, .sub-row.open::before { color: var(--red); }
    .sub-row__label { flex: 1; min-width: 0; }
    .sub-arrow { font-size: 9px; color: var(--muted); transition: transform .25s var(--ease); flex-shrink: 0; }
    .sub-row.open .sub-arrow { transform: rotate(90deg); color: var(--red); }
    .child-menu { max-height: 0; overflow: hidden; background: rgba(244,241,237,.55); transition: max-height .3s var(--ease); }
    .child-menu.open { max-height: 500px; }
    .child-item {
        display: block; padding: 7px 14px 7px 68px; font-size: 12px; font-weight: 500;
        color: #777; border-bottom: 1px solid rgba(0,0,0,.03); transition: var(--t); position: relative;
    }
    .child-item::before { content: '–'; position: absolute; left: 54px; color: var(--border-d); font-size: 11px; }
    .child-item:last-child { border-bottom: none; }
    .child-item:hover { background: rgba(200,16,46,.06); color: var(--red); padding-left: 72px; }
    .child-item:hover::before { color: var(--red); }

    /* ═══════════════════════════════════════════════════════════
       MOBILE BOTTOM NAV
    ═══════════════════════════════════════════════════════════ */
    .mob-nav {
        display: none; position: fixed; bottom: 0; left: 0; right: 0;
        background: var(--white); border-top: 1px solid var(--border);
        z-index: 880; box-shadow: 0 -4px 24px rgba(0,0,0,.09); height: var(--mob-nav);
    }
    .mob-nav__items {
        display: flex; justify-content: space-around; align-items: center;
        height: 100%; padding: 0 4px; padding-bottom: env(safe-area-inset-bottom);
    }
    .mob-nav__item {
        display: flex; flex-direction: column; align-items: center; gap: 2px;
        color: var(--muted); font-size: 8.5px; font-weight: 800;
        letter-spacing: .07em; text-transform: uppercase;
        padding: 6px 10px; border-radius: var(--rm); position: relative;
        cursor: pointer; text-decoration: none; flex: 1; transition: color .2s;
        background: none; border: none; font-family: 'Nunito', sans-serif;
    }
    .mob-nav__item .bi { font-size: 21px; line-height: 1; }
    .mob-nav__item.active { color: var(--red); }
    .mob-nav__item.active::after {
        content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
        width: 28px; height: 3px; background: var(--red); border-radius: 0 0 4px 4px;
    }
    .mob-nav__item--track { color: var(--red) !important; font-weight: 900 !important; }
    .mob-nav__badge {
        position: absolute; top: 3px; right: 8px;
        background: var(--red); color: #fff;
        font-size: 7.5px; font-weight: 900;
        min-width: 15px; height: 15px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid var(--white); padding: 0 2px;
    }
    .mob-nav__badge.zero { display: none; }

    /* ── Toast ── */
    #toast-container > div { border-radius: var(--rm) !important; font-family: 'Nunito', sans-serif !important; }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 1100px) {
        :root { --sb: 240px; }
        .track-order-btn .track-lbl { display: none; }
        .track-order-btn { padding: 8px 12px; gap: 0; }
        .nav-item { padding: 0 12px; font-size: 12.5px; }
    }
    @media (max-width: 900px) {
        .page-wrap { grid-template-columns: 1fr; padding: 12px 12px calc(var(--mob-nav) + 16px); gap: 14px; }
        .sidebar {
            position: fixed; top: 0; left: -290px;
            width: 280px; height: 100dvh; max-height: 100dvh;
            z-index: 870; border-radius: 0; border: none;
            border-right: 1px solid var(--border);
            transition: left .3s var(--ease); overflow-y: auto;
        }
        .sidebar.is-open { left: 0; box-shadow: 4px 0 30px rgba(0,0,0,.18); }
        .hamb { display: flex; }
        .mob-nav { display: block; }
        .track-order-btn { display: none; }
        .site-nav { display: none; }
        .wish-drop, .cart-drop { display: none !important; }
    }
    @media (max-width: 768px) {
        .site-hdr__in { height: auto; flex-wrap: wrap; padding: 8px 12px 10px; gap: 0; row-gap: 0; }
        .hamb    { order: 1; margin-right: 8px; }
        .logo    { order: 2; flex: 1; font-size: 19px; min-width: 0; }
        .hdr-actions { order: 3; flex-shrink: 0; gap: 0; margin-left: 4px; }
        .hdr-search-wrap { order: 4; flex: 0 0 100%; margin-top: 8px; }
        .hdr-search { border-radius: var(--rm); }
        .hdr-search.has-results { border-radius: var(--rm) var(--rm) 0 0; }
        .hdr-search__btn { padding: 9px 15px; font-size: 12.5px; border-radius: 0 var(--rm) var(--rm) 0; }
        .hdr-search.has-results .hdr-search__btn { border-radius: 0 var(--rm) 0 0; }
        .hdr-search input { padding: 9px 14px; font-size: 13px; }
        .h-act { padding: 6px 7px; min-width: auto; gap: 0; }
        .h-act .bi { font-size: 19px; }
        .h-act__lbl { display: none; }
        .h-badge { top: 1px; right: 0; min-width: 15px; height: 15px; font-size: 7.5px; border-width: 1.5px; }
        .top-bar__in { padding: 5px 12px; }
        .top-bar__promo { font-size: 10.5px; }
        .top-bar__track { display: none !important; }
        .search-dropdown { border-radius: 0 0 var(--rm) var(--rm); }
        .sd-view-all { border-radius: 0 0 calc(var(--rm) - 2px) calc(var(--rm) - 2px); }
    }
    @media (max-width: 400px) {
        .logo { font-size: 17px; }
        .top-bar__nav { display: none; }
        .h-act { padding: 5px 5px; }
        .h-act .bi { font-size: 18px; }
    }
    </style>

    {{-- ══ Toastr Flash ══ --}}
    @if (Session::has('success') || Session::has('error') || Session::has('info') || Session::has('coupon_error'))
    <script>
        $(document).ready(function () {
            toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 4500 };
            @if (Session::has('error'))        toastr.error("{{ Session::get('error') }}"); @endif
            @if (Session::has('success'))      toastr.success("{{ Session::get('success') }}"); @endif
            @if (Session::has('info'))         toastr.info("{{ Session::get('info') }}"); @endif
            @if (Session::has('coupon_error')) toastr.error("{{ Session::get('coupon_error') }}"); @endif
        });
    </script>
    @endif

    {{-- ══ Pre-compute header badge counts ══ --}}
    @php
        $headerCartCount    = collect(session('cart', []))->sum('quantity');
        $headerCartItems    = session('cart', []);
        $headerCartSubtotal = 0;
        foreach ($headerCartItems as $item) {
            $unitP = (!empty($item['discount_price']) && $item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
            $headerCartSubtotal += $unitP * $item['quantity'];
        }
        if (Auth::check()) {
            $headerWishItems = \App\Models\Wishlist::with('product')->where('user_id', Auth::id())->latest()->take(6)->get();
            $headerWishTotal = \App\Models\Wishlist::where('user_id', Auth::id())->count();
        } else {
            $headerWishItems = \App\Models\Wishlist::with('product')->where('session_id', session()->getId())->latest()->take(6)->get();
            $headerWishTotal = \App\Models\Wishlist::where('session_id', session()->getId())->count();
        }
        $headerWishCount = $headerWishItems->count();
    @endphp
</head>
<body>

{{-- ══ TOP ANNOUNCEMENT BAR ══ --}}
<div class="top-bar">
    <div class="top-bar__in">
        <div class="top-bar__promo">
            <span class="top-bar__dot"></span>
            <i class="bi bi-lightning-charge-fill" style="color:var(--gold);font-size:11px"></i>
            Free shipping on orders over ৳ 5,000 — Shop now!
        </div>
        <div class="top-bar__nav">
            <a href="{{ route('order.track') }}" class="top-bar__track">
                <i class="bi bi-truck"></i> অর্ডার ট্র্যাক
            </a>
            <a href="{{ route('products.all') }}"><i class="bi bi-grid-3x3-gap"></i> সব পণ্য</a>
            <a href="#"><i class="bi bi-shop"></i> Sell on Shahzadi</a>
            <a href="#"><i class="bi bi-geo-alt"></i> Our Stores</a>
        </div>
    </div>
</div>

{{-- ══ MAIN HEADER ══ --}}
<header class="site-hdr">
    <div class="site-hdr__in">

        {{-- Hamburger --}}
        <button class="hamb" onclick="toggleSidebar()" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="logo">
            <img
                src="{{ !empty($websetting?->header_logo) ? asset($websetting->header_logo) : asset('default/logo.png') }}"
                alt="Logo"
                style="height:70px; width:auto;">
            <div class="logo__dot"></div>
        </a>

        {{-- AJAX SEARCH --}}
        <div class="hdr-search-wrap" id="searchWrap">
            <div class="hdr-search" id="hdrSearch">
                <input type="search"
                       placeholder="পণ্য, ব্র্যান্ড, ক্যাটাগরি খুঁজুন…"
                       autocomplete="off"
                       id="globalSearch"
                       aria-label="Search products">
                <button class="search-clear" id="searchClear" type="button" title="Clear">
                    <i class="bi bi-x-lg"></i>
                </button>
                <button class="hdr-search__btn" onclick="doSearch()" type="button">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            <div class="search-dropdown" id="searchDropdown">
                <div class="search-loading" id="searchLoading">
                    <div class="search-spinner"></div>
                    খুঁজছি…
                </div>
                <div id="searchResults"></div>
            </div>
        </div>

        {{-- Track Order Button --}}
        <a href="{{ route('order.track') }}" class="track-order-btn" aria-label="Track Order">
            <i class="bi bi-truck"></i>
            <span class="track-lbl">অর্ডার ট্র্যাক</span>
        </a>

        {{-- Actions --}}
        <div class="hdr-actions">

            {{-- ══ ACCOUNT DROPDOWN ══ --}}
            <div class="hdr-drop-wrap">
                <div class="h-act" tabindex="0" role="button" aria-label="Account">
                    <i class="bi bi-person-circle"></i>
                    {{-- Label: login থাকলে Dashboard, না থাকলে Login --}}
                    <span class="h-act__lbl">
                        @auth Dashboard @else Login @endauth
                    </span>
                </div>
                <div class="hdr-drop acct-drop">
                    <div class="acct-drop__hd">
                        @auth
                            {{-- লগইন করা আছে: নাম ও Dashboard বাটন --}}
                            <span class="user-greeting">
                                <i class="bi bi-person-check" style="color:var(--gold);margin-right:4px;"></i>
                                {{ Auth::user()->name }}
                            </span>
                            <span class="user-email">{{ Auth::user()->email }}</span>
                            <a href="{{ route('user.dashboard') }}" class="acct-dash-btn">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        @else
                            {{-- Guest: Welcome + Sign In বাটন --}}
                            <p>Welcome to Shahzadi-mart</p>
                            <button class="acct-signin"
                                    onclick="window.location.href='{{ url('customer/login') }}'">
                                Sign In
                            </button>
                        @endauth
                    </div>

                    {{-- Dropdown লিংকসমূহ --}}
                    @auth
                        <a href="{{ route('user.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @endauth
                    <a href="{{ url('customer/account') }}">
                        <i class="bi bi-person"></i> My Account
                    </a>
                    <a href="{{ route('wishlist') }}">
                        <i class="bi bi-heart"></i> My Wishlist
                        @if($headerWishTotal > 0)
                            <span style="margin-left:auto;background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:1px 7px;border-radius:10px;">{{ $headerWishTotal }}</span>
                        @endif
                    </a>
                    <a href="{{ route('products.all') }}">
                        <i class="bi bi-grid-3x3-gap"></i> সব পণ্য
                    </a>
                    <a href="{{ url('cart') }}">
                        <i class="bi bi-bag"></i> My Orders
                    </a>
                    <a href="{{ route('order.track') }}">
                        <i class="bi bi-truck"></i> অর্ডার ট্র্যাক
                    </a>
                    @auth
                        <a href="{{ url('customer/logout') }}" class="logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    @else
                        <a href="{{ url('customer/login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <a href="{{ url('customer/register') }}">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>

            {{-- WISHLIST --}}
            <div class="hdr-drop-wrap">
                <a href="{{ route('wishlist') }}" class="h-act" title="Wishlist">
                    <i class="bi bi-heart"></i>
                    <span class="h-act__lbl">Wishlist</span>
                    <span class="h-badge {{ $headerWishTotal == 0 ? 'zero' : '' }}" id="wishBadge">{{ $headerWishTotal > 0 ? $headerWishTotal : '' }}</span>
                </a>
                <div class="hdr-drop wish-drop">
                    <div class="wish-drop__hd">
                        <i class="bi bi-heart-fill"></i>
                        <span>উইশলিস্ট</span>
                        @if($headerWishTotal > 0)
                            <span class="wish-count-pill">{{ $headerWishTotal }}</span>
                        @endif
                    </div>
                    <div class="wish-drop__body">
                        @if($headerWishItems->count() > 0)
                            @foreach($headerWishItems as $wItem)
                                @php
                                    $wp = $wItem->product;
                                    if (!$wp) continue;
                                    $wHasDisc  = $wp->discount_price && $wp->discount_price > 0;
                                    $wPrice    = $wHasDisc ? $wp->discount_price : ($wp->current_price ?? $wp->price ?? 0);
                                    $wImgSrc   = $wp->feature_image ? asset('uploads/products/' . $wp->feature_image) : asset('images/placeholder.png');
                                    $wName     = $wp->name ?? ($wp->product_name ?? 'Product');
                                    $wInStock  = $wp->is_unlimited || (($wp->stock ?? 0) > 0);
                                @endphp
                                <div class="wish-item">
                                    <div class="wish-item__img">
                                        <img src="{{ $wImgSrc }}" alt="{{ $wName }}" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                    </div>
                                    <div class="wish-item__info">
                                        <a href="{{ route('product.detail', $wp->slug) }}" class="wish-item__name">{{ $wName }}</a>
                                        <div>
                                            <span class="wish-item__price">৳ {{ number_format($wPrice, 0) }}</span>
                                            @if($wHasDisc)
                                                <span class="wish-item__old">৳ {{ number_format($wp->price, 0) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($wInStock)
                                        <a href="{{ route('wishlist.moveToCart', $wItem->id) }}" class="wish-item__add" title="কার্টে যোগ করুন">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    @else
                                        <span class="wish-item__add" style="opacity:.4;cursor:not-allowed;">
                                            <i class="bi bi-x-circle"></i>
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="wish-drop__empty">
                                <i class="bi bi-heart"></i>
                                উইশলিস্ট খালি আছে।
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('wishlist') }}" class="wish-drop__foot">
                        সম্পূর্ণ উইশলিস্ট দেখুন <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- HELP --}}
            <a href="#" class="h-act">
                <i class="bi bi-headset"></i>
                <span class="h-act__lbl">Help</span>
            </a>

            {{-- CART --}}
            <div class="hdr-drop-wrap">
                <a href="{{ url('cart') }}" class="h-act" title="Cart">
                    <i class="bi bi-cart3"></i>
                    <span class="h-act__lbl">Cart</span>
                    <span class="h-badge {{ $headerCartCount == 0 ? 'zero' : '' }}" id="cartBadge">{{ $headerCartCount > 0 ? $headerCartCount : '' }}</span>
                </a>
                <div class="hdr-drop cart-drop">
                    <div class="cart-drop__hd">
                        <i class="bi bi-cart3"></i>
                        <span>আমার কার্ট</span>
                        @if($headerCartCount > 0)
                            <span class="cart-count-pill">{{ $headerCartCount }}</span>
                        @endif
                    </div>
                    <div class="cart-drop__body">
                        @if(!empty($headerCartItems))
                            @foreach($headerCartItems as $cKey => $cItem)
                                @php
                                    $cHasDisc   = isset($cItem['discount_price']) && $cItem['discount_price'] > 0;
                                    $cUnitPrice = $cHasDisc ? $cItem['discount_price'] : $cItem['price'];
                                    $cLineTotal = $cUnitPrice * $cItem['quantity'];
                                    $cImgSrc    = !empty($cItem['image']) ? asset('uploads/products/' . $cItem['image']) : asset('images/placeholder.png');
                                    $cVariants  = [];
                                    if (!empty($cItem['selected_color'])) $cVariants[] = $cItem['selected_color'];
                                    if (!empty($cItem['selected_size']))  $cVariants[] = $cItem['selected_size'];
                                @endphp
                                <div class="cart-mini-item">
                                    <div class="cart-mini-img">
                                        <img src="{{ $cImgSrc }}" alt="{{ $cItem['name'] }}" onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                        <span class="cart-mini-qty">{{ $cItem['quantity'] }}</span>
                                    </div>
                                    <div class="cart-mini-info">
                                        <a href="{{ route('product.detail', $cItem['slug'] ?? $cKey) }}" class="cart-mini-name">{{ $cItem['name'] }}</a>
                                        @if(!empty($cVariants))
                                            <div class="cart-mini-variants">{{ implode(' · ', $cVariants) }}</div>
                                        @endif
                                        <div class="cart-mini-price">৳ {{ number_format($cLineTotal, 0) }}</div>
                                    </div>
                                    <a href="{{ route('cart.remove', $cKey) }}"
                                       class="cart-mini-remove" title="সরান"
                                       onclick="event.preventDefault(); if(confirm('সরিয়ে দেবেন?')) window.location.href=this.href;">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="cart-drop__empty">
                                <i class="bi bi-cart-x"></i>
                                কার্ট এখন খালি।
                            </div>
                        @endif
                    </div>
                    @if(!empty($headerCartItems))
                    <div class="cart-drop__summary">
                        <div class="cart-drop__total">
                            <span class="cart-drop__total-lbl">সাবটোটাল</span>
                            <span class="cart-drop__total-val">৳ {{ number_format($headerCartSubtotal, 0) }}</span>
                        </div>
                        <div class="cart-drop__btns">
                            <a href="{{ url('cart') }}" class="cart-drop__btn cart-drop__btn--view">
                                <i class="bi bi-bag"></i> কার্ট দেখুন
                            </a>
                            <a href="{{ route('checkout') }}" class="cart-drop__btn cart-drop__btn--checkout">
                                <i class="bi bi-check-circle"></i> চেকআউট
                            </a>
                        </div>
                    </div>
                    @else
                    <div style="padding:10px 14px;border-top:1px solid var(--border);">
                        <a href="{{ route('products.all') }}"
                           style="display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;background:var(--red);color:#fff;border-radius:var(--rm);font-size:13px;font-weight:800;text-decoration:none;"
                           onmouseover="this.style.background='var(--red-d)'" onmouseout="this.style.background='var(--red)'">
                            <i class="bi bi-shop"></i> শপিং শুরু করুন
                        </a>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- /.hdr-actions --}}
    </div>{{-- /.site-hdr__in --}}
</header>

{{-- ══ SECONDARY NAV BAR ══ --}}
<nav class="site-nav">
    <div class="site-nav__in">
        <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house"></i> হোম
        </a>
        <span class="nav-divider"></span>
        <a href="{{ route('products.all') }}" class="nav-item {{ request()->routeIs('products.all') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> সব পণ্য
        </a>
        <span class="nav-divider"></span>
        <a href="{{ url('shop') }}" class="nav-item {{ request()->is('shop*') ? 'active' : '' }}">
            <i class="bi bi-bag"></i> শপ
        </a>
        <span class="nav-divider"></span>
        <a href="{{ url('offers') }}" class="nav-item {{ request()->is('offers*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> অফার
        </a>
        <span class="nav-divider"></span>
        <a href="{{ url('new-arrivals') }}" class="nav-item {{ request()->is('new-arrivals*') ? 'active' : '' }}">
            <i class="bi bi-stars"></i> নতুন পণ্য
        </a>
        <span class="nav-divider"></span>
        <a href="{{ route('contact.details') }}" class="nav-item {{ request()->is('contact*') ? 'active' : '' }}">
            <i class="bi bi-telephone"></i> যোগাযোগ
        </a>
        <a href="{{ route('order.track') }}" class="nav-item nav-item--track {{ request()->routeIs('order.track*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> অর্ডার ট্র্যাক করুন
        </a>
    </div>
</nav>

{{-- Sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ══ MOBILE BOTTOM NAV ══ --}}
<nav class="mob-nav" id="mobNav">
    <div class="mob-nav__items">
        <a href="{{ url('/') }}" class="mob-nav__item {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house"></i> Home
        </a>
        <a href="{{ route('products.all') }}" class="mob-nav__item {{ request()->routeIs('products.all') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> সব পণ্য
        </a>
        <a href="{{ route('order.track') }}" class="mob-nav__item mob-nav__item--track {{ request()->routeIs('order.track*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> ট্র্যাক
        </a>
        <a href="{{ url('cart') }}" class="mob-nav__item" style="position:relative;">
            <i class="bi bi-cart3"></i> Cart
            <span class="mob-nav__badge {{ $headerCartCount == 0 ? 'zero' : '' }}" id="mobCartBadge">{{ $headerCartCount > 0 ? $headerCartCount : '' }}</span>
        </a>
        {{-- Mobile: Login থাকলে Dashboard, না থাকলে Login page --}}
        @auth
            <a href="{{ route('user.dashboard') }}" class="mob-nav__item {{ request()->routeIs('user.dashboard*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        @else
            <a href="{{ url('customer/login') }}" class="mob-nav__item {{ request()->is('customer/login*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Login
            </a>
        @endauth
    </div>
</nav>

{{-- Bootstrap 5 JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- Toastr JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
/* ════════════════════════════════════════════════════════════
   AJAX LIVE SEARCH
════════════════════════════════════════════════════════════ */
(function () {
    const input      = document.getElementById('globalSearch');
    const dropdown   = document.getElementById('searchDropdown');
    const results    = document.getElementById('searchResults');
    const loading    = document.getElementById('searchLoading');
    const clearBtn   = document.getElementById('searchClear');
    const searchBox  = document.getElementById('hdrSearch');
    const ajaxUrl    = '{{ route("search.ajax") }}';
    const searchUrl  = '{{ route("search.results") }}';

    let debounceTimer = null;
    let lastQuery     = '';
    let activeIdx     = -1;
    let currentItems  = [];

    function highlight(text, q) {
        if (!q) return text;
        const regex = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        return text.replace(regex, '<mark class="search-highlight">$1</mark>');
    }
    function openDropdown()  { dropdown.classList.add('active'); searchBox.classList.add('has-results', 'focused'); }
    function closeDropdown() { dropdown.classList.remove('active'); searchBox.classList.remove('has-results'); activeIdx = -1; currentItems = []; }
    function showLoading()   { loading.classList.add('active'); results.innerHTML = ''; openDropdown(); }
    function hideLoading()   { loading.classList.remove('active'); }

    function renderResults(data, q) {
        hideLoading(); results.innerHTML = ''; currentItems = []; activeIdx = -1;
        const hasProducts   = data.products   && data.products.length   > 0;
        const hasCategories = data.categories && data.categories.length > 0;
        if (!hasProducts && !hasCategories) {
            results.innerHTML = `<div class="sd-empty"><i class="bi bi-search"></i>"<strong>${q}</strong>" এর জন্য কোনো পণ্য পাওয়া যায়নি।</div>`;
            return;
        }
        if (hasCategories) {
            results.innerHTML += `<div class="sd-section-hd"><i class="bi bi-grid-3x3-gap"></i> ক্যাটাগরি</div>`;
            data.categories.forEach(cat => {
                const el = document.createElement('a');
                el.className = 'sd-cat-item sd-item'; el.href = cat.url;
                el.innerHTML = `<div class="sd-cat-img"><img src="${cat.image}" alt="${cat.name}" loading="lazy" onerror="this.src='{{ asset('default/no-image.png') }}'"></div><span class="sd-cat-name">${highlight(cat.name, q)}</span><i class="bi bi-chevron-right" style="color:var(--muted);font-size:11px;margin-left:auto"></i>`;
                results.appendChild(el); currentItems.push(el);
            });
        }
        if (hasProducts) {
            results.innerHTML += `<div class="sd-section-hd"><i class="bi bi-bag"></i> পণ্য</div>`;
            data.products.forEach(p => {
                const badge = p.in_stock ? `<span class="sd-prod-badge">In Stock</span>` : `<span class="sd-prod-badge out">স্টক নেই</span>`;
                const el = document.createElement('a');
                el.className = 'sd-prod-item sd-item'; el.href = p.url;
                el.innerHTML = `<div class="sd-prod-img"><img src="${p.image}" alt="${p.name}" loading="lazy" onerror="this.src='{{ asset('default/no-image.png') }}'"></div><div class="sd-prod-info"><div class="sd-prod-name">${highlight(p.name, q)}</div><div class="sd-prod-cat">${p.category}</div>${badge}</div><div class="sd-prod-price-wrap"><div class="sd-prod-price">৳ ${p.price}</div>${p.old_price ? `<div class="sd-prod-old">৳ ${p.old_price}</div>` : ''}</div>`;
                results.appendChild(el); currentItems.push(el);
            });
        }
        const viewAll = document.createElement('a');
        viewAll.className = 'sd-view-all';
        viewAll.href = `${searchUrl}?q=${encodeURIComponent(q)}`;
        viewAll.innerHTML = `সব ফলাফল দেখুন "${q}" <i class="bi bi-arrow-right"></i>`;
        results.appendChild(viewAll);
    }

    function setActive(idx) {
        currentItems.forEach((el, i) => { el.style.background = i === idx ? 'var(--light)' : ''; });
        activeIdx = idx;
    }
    function doAjaxSearch(q) {
        if (q === lastQuery) return;
        lastQuery = q;
        if (q.length < 2) { closeDropdown(); return; }
        showLoading();
        fetch(`${ajaxUrl}?q=${encodeURIComponent(q)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(data => renderResults(data, q))
            .catch(() => { hideLoading(); results.innerHTML = `<div class="sd-empty"><i class="bi bi-wifi-off"></i> নেটওয়ার্ক সমস্যা হয়েছে।</div>`; });
    }

    input.addEventListener('input', function () {
        const q = this.value.trim();
        clearBtn.classList.toggle('visible', q.length > 0);
        clearTimeout(debounceTimer);
        if (q.length < 2) { closeDropdown(); return; }
        debounceTimer = setTimeout(() => doAjaxSearch(q), 300);
    });
    input.addEventListener('keydown', function (e) {
        if (!dropdown.classList.contains('active')) return;
        if (e.key === 'ArrowDown')  { e.preventDefault(); setActive(Math.min(activeIdx + 1, currentItems.length - 1)); }
        else if (e.key === 'ArrowUp')   { e.preventDefault(); setActive(Math.max(activeIdx - 1, 0)); }
        else if (e.key === 'Enter')  { if (activeIdx >= 0 && currentItems[activeIdx]) { e.preventDefault(); currentItems[activeIdx].click(); } else { doSearch(); } }
        else if (e.key === 'Escape') { closeDropdown(); input.blur(); }
    });
    input.addEventListener('focus', function () {
        searchBox.classList.add('focused');
        const q = this.value.trim();
        if (q.length >= 2 && results.innerHTML.trim()) openDropdown();
    });
    clearBtn.addEventListener('click', function () {
        input.value = ''; clearBtn.classList.remove('visible'); closeDropdown(); lastQuery = ''; input.focus();
    });
    document.addEventListener('click', function (e) {
        if (!document.getElementById('searchWrap').contains(e.target)) {
            closeDropdown(); searchBox.classList.remove('focused');
        }
    });
})();

function doSearch() {
    const q = document.getElementById('globalSearch')?.value.trim();
    if (q) window.location.href = '{{ route("search.results") }}?q=' + encodeURIComponent(q);
}
document.getElementById('globalSearch')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') doSearch();
});

/* ── Sidebar Toggle ── */
function toggleSidebar() {
    const sb  = document.getElementById('sidebar');
    const ovl = document.getElementById('sidebarOverlay');
    if (!sb || !ovl) return;
    const open = sb.classList.toggle('is-open');
    ovl.classList.toggle('active', open);
    document.body.style.overflow = open ? 'hidden' : '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const sb = document.getElementById('sidebar');
        if (sb?.classList.contains('is-open')) toggleSidebar();
    }
});

/* ── Badge Sync (AJAX cart/wishlist update থেকে call করা হয়) ── */
function updateBadges(cartCount, wishCount) {
    const cartBadge    = document.getElementById('cartBadge');
    const mobCartBadge = document.getElementById('mobCartBadge');
    const wishBadge    = document.getElementById('wishBadge');
    if (cartBadge)    { cartBadge.textContent = cartCount > 0 ? cartCount : ''; cartBadge.classList.toggle('zero', cartCount === 0); }
    if (mobCartBadge) { mobCartBadge.textContent = cartCount > 0 ? cartCount : ''; mobCartBadge.classList.toggle('zero', cartCount === 0); }
    if (wishBadge)    { wishBadge.textContent = wishCount > 0 ? wishCount : ''; wishBadge.classList.toggle('zero', wishCount === 0); }
}
</script>
</body>
</html>
