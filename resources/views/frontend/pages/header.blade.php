{{-- resources/views/frontend/pages/header.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shahzadi-mart — Premium Shopping</title>

    {{-- ── Google Fonts ── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- ── Bootstrap Icons CDN ── --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- ── Toastr ── --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
    /* ═══════════════════════════════════════════════════════════
       RESET & TOKENS
    ═══════════════════════════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --red:      #C8102E;
        --red-d:    #a00d25;
        --red-glow: rgba(200,16,46,.12);
        --gold:     #D4A843;
        --gold-lt:  #f0c96a;
        --dark:     #0f0f0f;
        --dark2:    #1a1a1a;
        --dark3:    #242424;
        --mid:      #555;
        --light:    #f4f1ed;
        --lighter:  #faf9f7;
        --border:   #e6dfd6;
        --border-d: #ccc3b8;
        --text:     #1e1e1e;
        --muted:    #8a8a8a;
        --white:    #ffffff;
        --sh1:      0 1px 4px rgba(0,0,0,.06);
        --sh2:      0 4px 20px rgba(0,0,0,.10);
        --sh3:      0 8px 40px rgba(0,0,0,.15);
        --sh-red:   0 6px 24px rgba(200,16,46,.25);
        --r:        5px;
        --rm:       10px;
        --rl:       16px;
        --ease:     cubic-bezier(.4,0,.2,1);
        --bounce:   cubic-bezier(.34,1.56,.64,1);
        --t:        all .22s var(--ease);
        --wrap:     1440px;
        --sb:       260px;
        --hdr:      64px;
        --mob-nav:  60px;
    }

    html { scroll-behavior: smooth; }
    body {
        font-family: 'Nunito', sans-serif;
        background: var(--lighter);
        color: var(--text);
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }
    img  { display: block; max-width: 100%; }
    a    { text-decoration: none; color: inherit; }
    ul   { list-style: none; }

    /* ═══════════════════════════════════════════════════════════
       TOP ANNOUNCEMENT BAR
    ═══════════════════════════════════════════════════════════ */
    .top-bar {
        background: var(--dark);
        border-bottom: 1px solid #1a1a1a;
        position: relative; overflow: hidden;
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
    @keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.65)} }
    .top-bar__nav { display: flex; align-items: center; gap: 20px; }
    .top-bar__nav a {
        color: #666; font-size: 11px; font-weight: 600;
        letter-spacing: .06em; text-transform: uppercase;
        display: flex; align-items: center; gap: 5px; transition: color .2s;
    }
    .top-bar__nav a:hover { color: var(--gold); }

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

    /* Hamburger */
    .hamb {
        display: none;
        background: none; border: 1.5px solid var(--border);
        cursor: pointer; padding: 7px 9px; border-radius: var(--r);
        color: var(--text); font-size: 18px; flex-shrink: 0;
        transition: var(--t); align-items: center; justify-content: center;
        line-height: 1;
    }
    .hamb:hover { border-color: var(--red); color: var(--red); background: var(--red-glow); }

    /* Logo */
    .logo {
        font-family: 'Fraunces', serif;
        font-size: 22px; font-weight: 900;
        letter-spacing: -.03em; color: var(--dark);
        white-space: nowrap; flex-shrink: 0;
        display: flex; align-items: center; gap: 1px;
    }
    .logo em { color: var(--red); font-style: normal; }
    .logo__dot {
        width: 6px; height: 6px; background: var(--gold);
        border-radius: 50%; margin-left: 2px; flex-shrink: 0;
        animation: pulse-dot 2.5s ease-in-out infinite;
    }

    /* Search */
    .hdr-search {
        flex: 1; display: flex; align-items: center;
        background: var(--light); border: 1.5px solid var(--border);
        border-radius: 50px; overflow: hidden; transition: var(--t); min-width: 0;
    }
    .hdr-search:focus-within {
        border-color: var(--red); background: var(--white);
        box-shadow: 0 0 0 3px var(--red-glow);
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
    .hdr-search__btn:hover { background: var(--red-d); }

    /* ═══════════════════════════════════════════════════════════
       TRACK ORDER BUTTON
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
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        transition: var(--t);
        text-decoration: none;
        letter-spacing: .02em;
    }
    .track-order-btn .bi {
        font-size: 16px;
        transition: transform .3s var(--ease);
    }
    .track-order-btn:hover {
        background: var(--red);
        color: var(--white);
        box-shadow: var(--sh-red);
        transform: translateY(-1px);
    }
    .track-order-btn:hover .bi {
        transform: translateX(3px);
    }

    /* Track Order Modal */
    .track-modal-backdrop {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,.55);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center; justify-content: center;
    }
    .track-modal-backdrop.open { display: flex; }
    .track-modal {
        background: var(--white);
        border-radius: var(--rl);
        padding: 36px 32px 32px;
        width: 100%; max-width: 440px;
        margin: 16px;
        box-shadow: var(--sh3);
        position: relative;
        animation: modal-in .3s var(--bounce) both;
    }
    @keyframes modal-in {
        from { opacity: 0; transform: translateY(20px) scale(.96); }
        to   { opacity: 1; transform: none; }
    }
    .track-modal__close {
        position: absolute; top: 14px; right: 14px;
        background: var(--light); border: none; cursor: pointer;
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--mid); transition: var(--t);
    }
    .track-modal__close:hover { background: var(--red); color: var(--white); }
    .track-modal__icon {
        width: 56px; height: 56px;
        background: var(--red-glow);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .track-modal__icon .bi { font-size: 26px; color: var(--red); }
    .track-modal h3 {
        font-family: 'Fraunces', serif;
        font-size: 22px; font-weight: 800;
        text-align: center; color: var(--dark);
        margin-bottom: 6px;
    }
    .track-modal p {
        text-align: center; font-size: 13px;
        color: var(--muted); margin-bottom: 22px;
    }
    .track-modal__field {
        display: flex; flex-direction: column; gap: 6px;
        margin-bottom: 14px;
    }
    .track-modal__field label {
        font-size: 12px; font-weight: 800;
        letter-spacing: .07em; text-transform: uppercase;
        color: var(--mid);
    }
    .track-modal__field input {
        border: 1.5px solid var(--border);
        border-radius: var(--rm);
        padding: 11px 14px;
        font-family: 'Nunito', sans-serif;
        font-size: 13.5px; color: var(--text);
        outline: none; transition: var(--t);
        background: var(--light);
    }
    .track-modal__field input:focus {
        border-color: var(--red);
        background: var(--white);
        box-shadow: 0 0 0 3px var(--red-glow);
    }
    .track-modal__field input::placeholder { color: var(--muted); }
    .track-modal__submit {
        width: 100%;
        background: var(--red); color: var(--white);
        border: none; border-radius: 50px;
        padding: 12px 0;
        font-family: 'Nunito', sans-serif;
        font-size: 14px; font-weight: 800;
        cursor: pointer; transition: var(--t);
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin-top: 8px;
    }
    .track-modal__submit:hover {
        background: var(--red-d);
        box-shadow: var(--sh-red);
        transform: translateY(-1px);
    }

    /* Action Icons */
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
    .h-act__lbl {
        font-size: 8.5px; font-weight: 800;
        letter-spacing: .09em; text-transform: uppercase; line-height: 1;
    }
    .h-badge {
        position: absolute; top: 3px; right: 3px;
        background: var(--red); color: #fff;
        font-size: 8.5px; font-weight: 900;
        min-width: 17px; height: 17px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 3px; border: 2px solid var(--white);
        animation: badge-pop .3s var(--bounce) both;
    }
    @keyframes badge-pop { from{transform:scale(0)} to{transform:scale(1)} }

    /* Account dropdown */
    .acct { position: relative; }
    .acct-drop {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--rl); box-shadow: var(--sh3);
        min-width: 215px; z-index: 950;
        opacity: 0; visibility: hidden;
        transform: translateY(-8px) scale(.97);
        transition: all .25s var(--ease); overflow: hidden;
    }
    .acct:hover .acct-drop { opacity: 1; visibility: visible; transform: none; }
    .acct-drop__hd {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 16px 14px; text-align: center;
    }
    .acct-drop__hd p { color: #777; font-size: 11.5px; margin-bottom: 10px; letter-spacing: .04em; }
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

    /* Overlay */
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
        gap: 20px;
        align-items: start;
    }
    .content-area { min-width: 0; }

    /* ═══════════════════════════════════════════════════════════
       SIDEBAR BASE
    ═══════════════════════════════════════════════════════════ */
    .sidebar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--rl);
        overflow: hidden;
        position: sticky;
        top: calc(var(--hdr) + 12px);
        max-height: calc(100vh - var(--hdr) - 24px);
        overflow-y: auto;
        box-shadow: var(--sh1);
        scrollbar-width: thin;
        scrollbar-color: var(--border) transparent;
    }
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .sb-head {
        background: linear-gradient(135deg, var(--dark) 0%, var(--dark3) 100%);
        padding: 13px 16px;
        display: flex; align-items: center; gap: 9px;
        border-bottom: 2px solid var(--red);
        position: sticky; top: 0; z-index: 2;
    }
    .sb-head .bi { color: var(--gold); font-size: 15px; }
    .sb-head span {
        color: var(--white); font-size: 10px; font-weight: 800;
        letter-spacing: .16em; text-transform: uppercase;
    }

    /* cat-row */
    .cat-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 14px; cursor: pointer;
        border-bottom: 1px solid var(--border);
        transition: var(--t); position: relative; overflow: hidden;
    }
    .cat-row::before {
        content: ''; position: absolute; left: 0; top: 0;
        width: 3px; height: 100%;
        background: var(--red); border-radius: 0 2px 2px 0;
        transform: scaleY(0); transition: transform .22s var(--ease);
    }
    .cat-row:hover::before,
    .cat-row.open::before { transform: scaleY(1); }
    .cat-row:hover,
    .cat-row.open { background: rgba(200,16,46,.04); }
    .cat-row__left { display: flex; align-items: center; gap: 9px; min-width: 0; }
    .cat-icon {
        width: 30px; height: 30px; background: var(--light); border-radius: var(--r);
        display: flex; align-items: center; justify-content: center;
        color: var(--mid); transition: var(--t); flex-shrink: 0;
    }
    .cat-icon .bi { font-size: 14px; }
    .cat-row:hover .cat-icon,
    .cat-row.open .cat-icon { background: rgba(200,16,46,.1); color: var(--red); }
    .cat-row__label {
        font-size: 13px; font-weight: 600; color: var(--text);
        transition: color .2s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .cat-row:hover .cat-row__label,
    .cat-row.open .cat-row__label { color: var(--red); }
    .cat-arrow {
        font-size: 11px; color: var(--muted);
        transition: transform .28s var(--ease); flex-shrink: 0;
    }
    .cat-row.open .cat-arrow { transform: rotate(180deg); color: var(--red); }

    /* sub-menu */
    .sub-menu {
        background: var(--lighter);
        overflow: hidden; max-height: 0;
        transition: max-height .38s var(--ease);
        border-bottom: 1px solid var(--border);
    }
    .sub-menu.open { max-height: 9999px; }

    /* sub-row */
    .sub-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8.5px 14px 8.5px 50px;
        font-size: 12.5px; font-weight: 600; color: var(--mid);
        cursor: pointer; border-bottom: 1px solid rgba(0,0,0,.04);
        transition: var(--t); position: relative;
    }
    .sub-row::before {
        content: '›'; position: absolute; left: 34px;
        color: var(--border-d); font-size: 17px; line-height: 1;
    }
    .sub-row:hover, .sub-row.open { background: rgba(200,16,46,.07); color: var(--red); }
    .sub-row:hover::before, .sub-row.open::before { color: var(--red); }
    .sub-row__label { flex: 1; min-width: 0; }
    .sub-arrow {
        font-size: 9px; color: var(--muted);
        transition: transform .25s var(--ease); flex-shrink: 0;
    }
    .sub-row.open .sub-arrow { transform: rotate(90deg); color: var(--red); }

    /* child-menu */
    .child-menu {
        max-height: 0; overflow: hidden;
        background: rgba(244,241,237,.55);
        transition: max-height .3s var(--ease);
    }
    .child-menu.open { max-height: 500px; }
    .child-item {
        display: block; padding: 7px 14px 7px 68px;
        font-size: 12px; font-weight: 500; color: #777;
        border-bottom: 1px solid rgba(0,0,0,.03);
        transition: var(--t); position: relative;
    }
    .child-item::before {
        content: '–'; position: absolute; left: 54px;
        color: var(--border-d); font-size: 11px;
    }
    .child-item:last-child { border-bottom: none; }
    .child-item:hover { background: rgba(200,16,46,.06); color: var(--red); padding-left: 72px; }
    .child-item:hover::before { color: var(--red); }

    /* ═══════════════════════════════════════════════════════════
       MOBILE BOTTOM NAV
    ═══════════════════════════════════════════════════════════ */
    .mob-nav {
        display: none;
        position: fixed; bottom: 0; left: 0; right: 0;
        background: var(--white); border-top: 1px solid var(--border);
        z-index: 880; box-shadow: 0 -4px 24px rgba(0,0,0,.09);
        height: var(--mob-nav);
    }
    .mob-nav__items {
        display: flex; justify-content: space-around; align-items: center;
        height: 100%;
        padding: 0 4px;
        padding-bottom: env(safe-area-inset-bottom);
    }
    .mob-nav__item {
        display: flex; flex-direction: column; align-items: center; gap: 2px;
        color: var(--muted); font-size: 8.5px; font-weight: 800;
        letter-spacing: .07em; text-transform: uppercase;
        padding: 6px 10px; border-radius: var(--rm);
        position: relative; cursor: pointer; text-decoration: none;
        flex: 1; transition: color .2s;
    }
    .mob-nav__item .bi { font-size: 21px; line-height: 1; }
    .mob-nav__item.active { color: var(--red); }
    .mob-nav__item.active::after {
        content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%);
        width: 28px; height: 3px; background: var(--red); border-radius: 0 0 4px 4px;
    }
    /* Track Order mobile nav item — special highlight */
    .mob-nav__item--track { color: var(--red); }
    .mob-nav__item--track .bi { font-size: 20px; }
    .mob-nav__badge {
        position: absolute; top: 3px; right: 8px;
        background: var(--red); color: #fff;
        font-size: 7.5px; font-weight: 900;
        min-width: 15px; height: 15px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid var(--white); padding: 0 2px;
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE — Tablet ≤ 1100px
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 1100px) {
        :root { --sb: 240px; }
        /* Hide track order text label on tablet, show icon only */
        .track-order-btn .track-lbl { display: none; }
        .track-order-btn { padding: 8px 12px; gap: 0; }
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE — Mobile ≤ 900px
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 900px) {
        .page-wrap {
            grid-template-columns: 1fr;
            padding: 12px 12px calc(var(--mob-nav) + 16px);
            gap: 14px;
        }
        .sidebar {
            position: fixed;
            top: 0; left: -290px;
            width: 280px; height: 100dvh;
            max-height: 100dvh;
            z-index: 870;
            border-radius: 0;
            border: none;
            border-right: 1px solid var(--border);
            transition: left .3s var(--ease);
            overflow-y: auto;
        }
        .sidebar.is-open { left: 0; box-shadow: 4px 0 30px rgba(0,0,0,.18); }
        .hamb { display: flex; }
        .mob-nav { display: block; }

        /* Hide desktop Track Order button — available in bottom nav */
        .track-order-btn { display: none; }
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE — Phone ≤ 768px — Two-row header
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .site-hdr__in {
            height: auto;
            flex-wrap: wrap;
            padding: 8px 12px 10px;
            gap: 0;
            row-gap: 0;
        }

        /* Row 1 */
        .hamb    { order: 1; margin-right: 8px; }
        .logo    { order: 2; flex: 1; font-size: 19px; min-width: 0; }
        .hdr-actions {
            order: 3; flex-shrink: 0; gap: 0; margin-left: 4px;
        }

        /* Row 2 */
        .hdr-search {
            order: 4; flex: 0 0 100%;
            margin-top: 8px; border-radius: var(--rm);
        }
        .hdr-search__btn {
            padding: 9px 15px; font-size: 12.5px;
            border-radius: 0 var(--rm) var(--rm) 0;
        }
        .hdr-search input { padding: 9px 14px; font-size: 13px; }

        /* Compact action icons */
        .h-act { padding: 6px 7px; min-width: auto; gap: 0; }
        .h-act .bi { font-size: 19px; }
        .h-act__lbl { display: none; }
        .h-badge { top: 1px; right: 0; min-width: 15px; height: 15px; font-size: 7.5px; border-width: 1.5px; }

        /* Compact top bar */
        .top-bar__in { padding: 5px 12px; }
        .top-bar__promo { font-size: 10.5px; }
    }

    @media (max-width: 400px) {
        .logo { font-size: 17px; }
        .top-bar__nav { display: none; }
        .h-act { padding: 5px 5px; }
        .h-act .bi { font-size: 18px; }
        /* NOTE: Track Order stays visible in bottom nav — DO NOT hide it here */
    }

    /* Track modal responsive */
    @media (max-width: 480px) {
        .track-modal { padding: 28px 20px 24px; }
        .track-modal h3 { font-size: 19px; }
    }

    /* ── Toast ── */
    #toast-container > div { border-radius: var(--rm) !important; font-family: 'Nunito', sans-serif !important; }
    </style>

    {{-- Toastr flash --}}
    @if (Session::has('success') || Session::has('error'))
    <script>
        $(document).ready(function () {
            toastr.options = {
                closeButton: true, progressBar: true,
                positionClass: "toast-top-right", timeOut: 4500,
            };
            @if (Session::has('error'))   toastr.error("{{ Session::get('error') }}"); @endif
            @if (Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        });
    </script>
    @endif
</head>
<body>

{{-- ── TOP BAR ── --}}
<div class="top-bar">
    <div class="top-bar__in">
        <div class="top-bar__promo">
            <span class="top-bar__dot"></span>
            <i class="bi bi-lightning-charge-fill" style="color:var(--gold);font-size:11px"></i>
            Free shipping on orders over KSh 5,000 — Shop now!
        </div>
        <div class="top-bar__nav">
            <a href="#"><i class="bi bi-shop"></i> Sell on Shahzadi</a>
            <a href="#"><i class="bi bi-geo-alt"></i> Our Stores</a>
        </div>
    </div>
</div>

{{-- ── MAIN HEADER ── --}}
<header class="site-hdr">
    <div class="site-hdr__in">

        {{-- Hamburger --}}
        <button class="hamb" onclick="toggleSidebar()" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="logo">
            Shahzadi<em>-mart</em><span class="logo__dot"></span>
        </a>

        {{-- Search --}}
        <div class="hdr-search">
            <input type="search" placeholder="Search products, brands, categories…"
                   autocomplete="off" id="globalSearch">
            <button class="hdr-search__btn" onclick="doSearch()">
                <i class="bi bi-search"></i> Search
            </button>
        </div>

        {{-- ── TRACK ORDER BUTTON (desktop only — hidden on mobile via CSS) ── --}}
        <button class="track-order-btn" onclick="openTrackModal()" aria-label="Track Order">
            <i class="bi bi-truck"></i>
            <span class="track-lbl">Track Order</span>
        </button>

        {{-- Actions --}}
        <div class="hdr-actions">

            {{-- Account --}}
            <div class="acct">
                <div class="h-act" tabindex="0" role="button">
                    <i class="bi bi-person-circle"></i>
                    <span class="h-act__lbl">Account</span>
                </div>
                <div class="acct-drop">
                    <div class="acct-drop__hd">
                        <p>Welcome to Shahzadi-mart</p>
                        <button class="acct-signin"
                            onclick="window.location.href='{{ url('customer/login') }}'">Sign In</button>
                    </div>
                    <a href="{{ url('customer/account') }}">
                        <i class="bi bi-person"></i> My Account</a>
                    <a href="#">
                        <i class="bi bi-bag"></i> My Orders</a>
                    <a href="#">
                        <i class="bi bi-heart"></i> Favourites</a>
                    <a href="#" class="logout">
                        <i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>

            {{-- Wishlist --}}
            <a href="#" class="h-act">
                <i class="bi bi-heart"></i>
                <span class="h-act__lbl">Wishlist</span>
                <span class="h-badge" id="wishBadge">0</span>
            </a>

            {{-- Help --}}
            <a href="#" class="h-act">
                <i class="bi bi-headset"></i>
                <span class="h-act__lbl">Help</span>
            </a>

            {{-- Cart --}}
            <a href="{{ url('cart') }}" class="h-act">
                <i class="bi bi-cart3"></i>
                <span class="h-act__lbl">Cart</span>
                <span class="h-badge" id="cartBadge">0</span>
            </a>
        </div>
    </div>
</header>

{{-- Sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ── TRACK ORDER MODAL ── --}}
<div class="track-modal-backdrop" id="trackModalBackdrop">
    <div class="track-modal" role="dialog" aria-modal="true" aria-labelledby="trackModalTitle">
        <button class="track-modal__close" id="trackModalCloseBtn" aria-label="Close">
            <i class="bi bi-x"></i>
        </button>

        <div class="track-modal__icon">
            <i class="bi bi-truck"></i>
        </div>

        <h3 id="trackModalTitle">Track Your Order</h3>
        <p>Enter your order number or phone number to get real-time delivery updates.</p>

        <div class="track-modal__field">
            <label for="trackOrderInput">Order Number / Phone</label>
            <input type="text" id="trackOrderInput"
                   placeholder="e.g. SM-20241234 or 0712345678"
                   autocomplete="off">
        </div>

        <button class="track-modal__submit" id="trackSubmitBtn">
            <i class="bi bi-search"></i> Track My Order
        </button>
    </div>
</div>

{{-- ── MOBILE BOTTOM NAV ── --}}
{{-- NOTE: Track Order is the 3rd item — always visible on mobile --}}
<nav class="mob-nav" id="mobNav">
    <div class="mob-nav__items">

        <a href="{{ url('/') }}" class="mob-nav__item active">
            <i class="bi bi-house"></i>
            Home
        </a>

        <a href="#" class="mob-nav__item" onclick="toggleSidebar(); return false;">
            <i class="bi bi-grid"></i>
            Categories
        </a>

        {{-- ★ Track Order — always shown on mobile ★ --}}
        <button class="mob-nav__item mob-nav__item--track"
                onclick="openTrackModal()"
                style="background:none;border:none;cursor:pointer;">
            <i class="bi bi-truck"></i>
            Track
        </button>

        <a href="{{ url('cart') }}" class="mob-nav__item" style="position:relative;">
            <i class="bi bi-cart3"></i>
            Cart
            <span class="mob-nav__badge" id="mobCartBadge">0</span>
        </a>

        <a href="{{ url('customer/account') }}" class="mob-nav__item">
            <i class="bi bi-person-circle"></i>
            Account
        </a>

    </div>
</nav>

<script>
/* ── Search ── */
function doSearch() {
    const q = document.getElementById('globalSearch')?.value.trim();
    if (q) window.location.href = '/search?q=' + encodeURIComponent(q);
}
document.getElementById('globalSearch')?.addEventListener('keypress', function(e){
    if (e.key === 'Enter') doSearch();
});

/* ── Sidebar ── */
function toggleSidebar() {
    const sb  = document.getElementById('sidebar');
    const ovl = document.getElementById('sidebarOverlay');
    if (!sb || !ovl) return;
    const open = sb.classList.toggle('is-open');
    ovl.classList.toggle('active', open);
    document.body.style.overflow = open ? 'hidden' : '';
}

/* ── Track Order Modal ── */
function openTrackModal() {
    document.getElementById('trackModalBackdrop').classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('trackOrderInput')?.focus(), 100);
}

function closeTrackModal() {
    document.getElementById('trackModalBackdrop').classList.remove('open');
    document.body.style.overflow = '';
}

/* Close when clicking backdrop (outside modal box) */
document.getElementById('trackModalBackdrop').addEventListener('click', function(e) {
    if (e.target === this) closeTrackModal();
});

/* Close button */
document.getElementById('trackModalCloseBtn').addEventListener('click', closeTrackModal);

/* Submit */
function doTrackOrder() {
    const val = document.getElementById('trackOrderInput')?.value.trim();
    if (!val) {
        document.getElementById('trackOrderInput').focus();
        return;
    }
    window.location.href = '/track-order?q=' + encodeURIComponent(val);
}

document.getElementById('trackSubmitBtn').addEventListener('click', doTrackOrder);

document.getElementById('trackOrderInput')?.addEventListener('keypress', function(e){
    if (e.key === 'Enter') doTrackOrder();
});

/* Escape key closes modals */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const sb = document.getElementById('sidebar');
        if (sb?.classList.contains('is-open')) toggleSidebar();
        closeTrackModal();
    }
});
</script>
</body>
</html>
