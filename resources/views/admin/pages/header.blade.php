<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — MultiVendor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@if (Session::has('success') || Session::has('error'))
<script>
    $(document).ready(function() {
        // Toastr options
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        // Display error message
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        // Display success message
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    });
</script>
@endif


    <style>
    /* ─── Reset & Base ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w   : 220px;
        --top-h       : 56px;
        --bg          : #f0f2f5;
        --white       : #ffffff;
        --sidebar-bg  : #1a233a;
        --sidebar-text: #a8b5cc;
        --sidebar-active: #ffffff;
        --accent      : #3d5a99;
        --border      : #e2e8f0;
        --text        : #2d3748;
        --text-muted  : #718096;
        --radius      : 6px;
        --shadow      : 0 1px 4px rgba(0,0,0,0.1);
    }

    body {
        font-family   : 'Nunito', sans-serif;
        background    : var(--bg);
        color         : var(--text);
        overflow-x    : hidden;
    }

    a { text-decoration: none; color: inherit; }

    /* ─── Sidebar ───────────────────────────────────────────── */
    #sidebar {
        position     : fixed;
        top          : 0;
        left         : 0;
        bottom       : 0;
        width        : var(--sidebar-w);
        background   : var(--sidebar-bg);
        z-index      : 1000;
        overflow-y   : auto;
        overflow-x   : hidden;
        transition   : transform 0.3s ease;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.1) transparent;
    }

    #sidebar::-webkit-scrollbar { width: 3px; }
    #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

    .sidebar-brand {
        display      : flex;
        align-items  : center;
        padding      : 0 18px;
        height       : var(--top-h);
        background   : rgba(0,0,0,0.2);
        font-size    : 18px;
        font-weight  : 800;
        color        : #fff;
        letter-spacing: -0.3px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .sidebar-brand i {
        font-size  : 20px;
        margin-right: 10px;
        color      : #7b9cda;
    }

    .sidebar-nav { padding: 8px 0 20px; }

    .sidebar-item {
        display      : flex;
        align-items  : center;
        justify-content: space-between;
        padding      : 8px 18px;
        font-size    : 13px;
        font-weight  : 600;
        color        : var(--sidebar-text);
        cursor       : pointer;
        transition   : all 0.2s;
        border-left  : 3px solid transparent;
        white-space  : nowrap;
    }

    .sidebar-item:hover {
        color        : #fff;
        background   : rgba(255,255,255,0.05);
    }

    .sidebar-item.active {
        color        : #fff;
        background   : rgba(255,255,255,0.08);
        border-left-color: #7b9cda;
    }

    .sidebar-item .item-left {
        display    : flex;
        align-items: center;
        gap        : 9px;
        flex       : 1;
        min-width  : 0;
    }

    .sidebar-item i.nav-icon {
        font-size  : 14px;
        width      : 18px;
        text-align : center;
        flex-shrink: 0;
        opacity    : 0.8;
    }

    .sidebar-item .item-text {
        white-space  : nowrap;
        overflow     : hidden;
        text-overflow: ellipsis;
    }

    .sidebar-item .arrow {
        font-size  : 10px;
        opacity    : 0.5;
        transition : transform 0.25s;
        flex-shrink: 0;
    }

    .sidebar-item.open .arrow { transform: rotate(90deg); opacity: 1; }

    /* Sub-menu */
    .sidebar-submenu {
        max-height : 0;
        overflow   : hidden;
        transition : max-height 0.3s ease;
        background : rgba(0,0,0,0.15);
    }

    .sidebar-submenu.open { max-height: 400px; }

    .sidebar-submenu a {
        display    : flex;
        align-items: center;
        gap        : 8px;
        padding    : 7px 18px 7px 44px;
        font-size  : 12.5px;
        font-weight: 500;
        color      : rgba(168,181,204,0.8);
        transition : all 0.2s;
    }

    .sidebar-submenu a:hover { color: #fff; background: rgba(255,255,255,0.04); }
    .sidebar-submenu a.active { color: #7b9cda; font-weight: 700; }
    .sidebar-submenu a i { font-size: 11px; }

    /* ─── Top Navbar ────────────────────────────────────────── */
    #topbar {
        position     : fixed;
        top          : 0;
        left         : var(--sidebar-w);
        right        : 0;
        height       : var(--top-h);
        background   : var(--white);
        border-bottom: 1px solid var(--border);
        display      : flex;
        align-items  : center;
        justify-content: space-between;
        padding      : 0 20px;
        z-index      : 900;
        box-shadow   : var(--shadow);
        transition   : left 0.3s;
    }

    .topbar-left { display: flex; align-items: center; gap: 12px; }

    #menuToggle {
        background : none;
        border     : none;
        font-size  : 22px;
        color      : var(--text-muted);
        cursor     : pointer;
        padding    : 4px 8px;
        border-radius: var(--radius);
        line-height: 1;
        transition : color 0.2s, background 0.2s;
    }

    #menuToggle:hover { color: var(--text); background: var(--bg); }

    .topbar-search {
        display      : flex;
        align-items  : center;
        background   : var(--bg);
        border       : 1px solid var(--border);
        border-radius: 20px;
        padding      : 5px 14px;
        gap          : 8px;
        width        : 220px;
    }

    .topbar-search i { color: var(--text-muted); font-size: 13px; }

    .topbar-search input {
        border     : none;
        background : transparent;
        outline    : none;
        font-size  : 13px;
        font-family: 'Nunito', sans-serif;
        color      : var(--text);
        width      : 100%;
    }

    .topbar-search input::placeholder { color: var(--text-muted); }

    .topbar-right { display: flex; align-items: center; gap: 6px; }

    .topbar-icon-btn {
        position   : relative;
        width      : 36px;
        height     : 36px;
        display    : flex;
        align-items: center;
        justify-content: center;
        background : var(--bg);
        border     : 1px solid var(--border);
        border-radius: 50%;
        color      : var(--text-muted);
        font-size  : 15px;
        cursor     : pointer;
        transition : all 0.2s;
        text-decoration: none;
    }

    .topbar-icon-btn:hover { color: var(--text); background: #e8ecf3; }

    .topbar-badge {
        position     : absolute;
        top          : -3px;
        right        : -3px;
        background   : #e53e3e;
        color        : #fff;
        font-size    : 9px;
        font-weight  : 700;
        width        : 16px;
        height       : 16px;
        border-radius: 50%;
        display      : flex;
        align-items  : center;
        justify-content: center;
        border       : 2px solid #fff;
    }

    .topbar-user {
        display    : flex;
        align-items: center;
        gap        : 8px;
        padding    : 4px 10px;
        border-radius: 20px;
        cursor     : pointer;
        transition : background 0.2s;
    }

    .topbar-user:hover { background: var(--bg); }

    .topbar-user img {
        width        : 32px;
        height       : 32px;
        border-radius: 50%;
        object-fit   : cover;
        border       : 2px solid var(--border);
    }

    .topbar-user-name {
        font-size  : 13px;
        font-weight: 700;
        color      : var(--text);
    }

    /* ─── Main Content ──────────────────────────────────────── */
    #main-content {
        margin-left  : var(--sidebar-w);
        margin-top   : var(--top-h);
        min-height   : calc(100vh - var(--top-h));
        transition   : margin-left 0.3s;
    }

    .page-wrapper { padding: 24px 22px; }

    /* ─── Page Header ───────────────────────────────────────── */
    .page-header-bar {
        display        : flex;
        align-items    : center;
        justify-content: space-between;
        margin-bottom  : 20px;
        flex-wrap      : wrap;
        gap            : 10px;
    }

    .page-header-bar h1 {
        font-size  : 20px;
        font-weight: 800;
        color      : var(--text);
        margin     : 0;
    }

    .breadcrumb { margin: 0; background: transparent; padding: 0; }
    .breadcrumb-item { font-size: 12px; }
    .breadcrumb-item a { color: var(--text-muted); }
    .breadcrumb-item.active { color: var(--text-muted); }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted); }

    /* ─── Stat Cards ────────────────────────────────────────── */
    .stat-grid {
        display              : grid;
        grid-template-columns: repeat(3, 1fr);
        gap                  : 16px;
        margin-bottom        : 20px;
    }

    @media (max-width: 768px) { .stat-grid { grid-template-columns: 1fr; } }
    @media (min-width: 769px) and (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        border-radius: 8px;
        padding      : 22px 24px;
        color        : #fff;
        position     : relative;
        overflow     : hidden;
        min-height   : 120px;
        display      : flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stat-card::after {
        content      : '';
        position     : absolute;
        right        : -20px;
        top          : -20px;
        width        : 100px;
        height       : 100px;
        border-radius: 50%;
        background   : rgba(0,0,0,0.12);
    }

    .stat-card::before {
        content      : '';
        position     : absolute;
        right        : 10px;
        top          : 10px;
        width        : 70px;
        height       : 70px;
        border-radius: 50%;
        background   : rgba(0,0,0,0.08);
    }

    .stat-card-orange  { background: linear-gradient(135deg, #ff6b35, #f7931e); }
    .stat-card-blue    { background: linear-gradient(135deg, #2196f3, #0d47a1); }
    .stat-card-teal    { background: linear-gradient(135deg, #00bcd4, #006064); }
    .stat-card-purple  { background: linear-gradient(135deg, #7c3aed, #4c1d95); }
    .stat-card-red     { background: linear-gradient(135deg, #ef4444, #991b1b); }
    .stat-card-green   { background: linear-gradient(135deg, #22c55e, #14532d); }

    .stat-card-title {
        font-size  : 13.5px;
        font-weight: 700;
        opacity    : 0.9;
        margin-bottom: 6px;
    }

    .stat-card-value {
        font-size  : 34px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 10px;
    }

    .stat-card-link a {
        display     : inline-block;
        background  : rgba(255,255,255,0.25);
        color       : #fff;
        font-size   : 11px;
        font-weight : 700;
        padding     : 4px 14px;
        border-radius: 20px;
        transition  : background 0.2s;
    }

    .stat-card-link a:hover { background: rgba(255,255,255,0.38); }

    .stat-card-icon {
        position   : absolute;
        right      : 20px;
        top        : 50%;
        transform  : translateY(-50%);
        font-size  : 52px;
        opacity    : 0.25;
        z-index    : 1;
    }

    /* ─── Circle Stats ──────────────────────────────────────── */
    .circle-stats-grid {
        display              : grid;
        grid-template-columns: repeat(4, 1fr);
        gap                  : 16px;
        margin-bottom        : 20px;
    }

    @media (max-width: 768px) { .circle-stats-grid { grid-template-columns: repeat(2, 1fr); } }

    .circle-stat-card {
        background   : var(--white);
        border-radius: 8px;
        padding      : 28px 20px;
        text-align   : center;
        box-shadow   : var(--shadow);
        border       : 1px solid var(--border);
    }

    .circle-stat-ring {
        width       : 110px;
        height      : 110px;
        border-radius: 50%;
        border      : 10px solid;
        display     : flex;
        align-items : center;
        justify-content: center;
        margin      : 0 auto 14px;
        font-size   : 24px;
        font-weight : 800;
        color       : var(--text);
    }

    .ring-gold    { border-color: #f59e0b; }
    .ring-teal    { border-color: #06b6d4; }
    .ring-purple  { border-color: #7c3aed; }
    .ring-green   { border-color: #22c55e; }

    .circle-stat-label {
        font-size  : 13px;
        font-weight: 700;
        color      : var(--text);
        margin-bottom: 2px;
    }

    .circle-stat-sublabel {
        font-size: 11px;
        color    : var(--text-muted);
    }

    /* ─── Data Card ─────────────────────────────────────────── */
    .data-card {
        background   : var(--white);
        border-radius: 8px;
        border       : 1px solid var(--border);
        box-shadow   : var(--shadow);
        overflow     : hidden;
        margin-bottom: 20px;
    }

    .data-card-header {
        display        : flex;
        align-items    : center;
        justify-content: space-between;
        padding        : 14px 20px;
        border-bottom  : 1px solid var(--border);
        background     : var(--white);
    }

    .data-card-title {
        font-size  : 14px;
        font-weight: 800;
        color      : var(--text);
        margin     : 0;
    }

    .data-card-body { padding: 0; }

    /* ─── Table ─────────────────────────────────────────────── */
    .admin-table {
        width          : 100%;
        border-collapse: collapse;
        font-size      : 13px;
    }

    .admin-table thead th {
        background   : #f8fafc;
        padding      : 10px 16px;
        font-weight  : 700;
        color        : var(--text-muted);
        font-size    : 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
        white-space  : nowrap;
    }

    .admin-table tbody tr { transition: background 0.15s; }
    .admin-table tbody tr:hover { background: #f8fafc; }

    .admin-table tbody td {
        padding    : 12px 16px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        color      : var(--text);
    }

    .admin-table tbody tr:last-child td { border-bottom: none; }

    /* ─── Badges ────────────────────────────────────────────── */
    .badge-pill {
        display     : inline-block;
        padding     : 3px 10px;
        border-radius: 20px;
        font-size   : 11px;
        font-weight : 700;
    }

    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }
    .badge-info    { background: #dbeafe; color: #1e40af; }
    .badge-purple  { background: #ede9fe; color: #5b21b6; }

    /* ─── Btn Detail ────────────────────────────────────────── */
    .btn-detail {
        display     : inline-flex;
        align-items : center;
        gap         : 5px;
        background  : #1a233a;
        color       : #fff;
        font-size   : 12px;
        font-weight : 700;
        padding     : 5px 14px;
        border-radius: 20px;
        border      : none;
        cursor      : pointer;
        text-decoration: none;
        transition  : background 0.2s;
    }

    .btn-detail:hover { background: #2d3f6b; color: #fff; }

    /* ─── Charts ────────────────────────────────────────────── */
    .chart-card {
        background   : var(--white);
        border-radius: 8px;
        border       : 1px solid var(--border);
        box-shadow   : var(--shadow);
        padding      : 20px;
        margin-bottom: 20px;
    }

    .chart-card h5 {
        font-size    : 14px;
        font-weight  : 800;
        color        : var(--text);
        margin-bottom: 16px;
    }

    /* ─── Product Img ───────────────────────────────────────── */
    .product-thumb {
        width        : 40px;
        height       : 40px;
        object-fit   : cover;
        border-radius: 6px;
        border       : 1px solid var(--border);
    }

    /* ─── Sidebar Collapsed ─────────────────────────────────── */
    body.sb-collapsed #sidebar { transform: translateX(-100%); }
    body.sb-collapsed #topbar  { left: 0; }
    body.sb-collapsed #main-content { margin-left: 0; }

    /* ─── Overlay (mobile) ──────────────────────────────────── */
    .sb-overlay {
        display   : none;
        position  : fixed;
        inset     : 0;
        z-index   : 999;
        background: rgba(0,0,0,0.5);
    }

    @media (max-width: 991px) {
        #sidebar       { transform: translateX(-100%); }
        #topbar        { left: 0 !important; }
        #main-content  { margin-left: 0 !important; }
        .sb-overlay    { display: block; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
        body.sb-open #sidebar   { transform: translateX(0); }
        body.sb-open .sb-overlay{ opacity: 1; pointer-events: auto; }
    }

    /* ─── Two-col grid ──────────────────────────────────────── */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

    .full-col { grid-column: 1 / -1; }

    /* ─── Popular products img ──────────────────────────────── */
    .pop-img {
        width: 44px; height: 44px; object-fit: cover; border-radius: 6px;
        border: 1px solid var(--border);
    }
    </style>
</head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<body>
