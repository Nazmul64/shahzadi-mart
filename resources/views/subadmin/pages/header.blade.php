<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sub Admin Dashboard — shahzadimart Shop</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --sb: #0d1b2a;
      --sb2: #112240;
      --acc: #e63946;
      --acc2: #f4a261;
      --top: 60px;
      --sw: 225px;
      --bg: #f0f4f8;
      --card: #ffffff;
      --txt: #1a202c;
      --muted: #8896a5;
      --radius: 14px;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Sora',sans-serif; background:var(--bg); color:var(--txt); }

    /* ══ SIDEBAR ══ */
    #sidebar {
      width: var(--sw); min-height:100vh;
      background: var(--sb);
      position: fixed; top:0; left:0; z-index:1000;
      display: flex; flex-direction:column;
    }

    .sb-brand {
      padding: 18px 16px;
      display: flex; align-items:center; gap:10px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .sb-icon {
      width:40px; height:40px; border-radius:10px;
      background: linear-gradient(135deg,var(--acc),var(--acc2));
      display:flex; align-items:center; justify-content:center;
      font-weight:800; font-size:17px; color:#fff; flex-shrink:0;
    }
    .sb-brand strong { display:block; color:#fff; font-size:13.5px; }
    .sb-brand span   { font-size:10px; color:#64748b; letter-spacing:1px; text-transform:uppercase; }

    .sb-section { padding:16px 16px 4px; font-size:10px; color:#475569; letter-spacing:1.4px; text-transform:uppercase; font-weight:600; }

    .sb-menu { list-style:none; padding:0 8px; }
    .sb-menu li a {
      display:flex; align-items:center; gap:9px;
      padding:9px 12px; border-radius:8px;
      color:#94a3b8; text-decoration:none; font-size:13px; font-weight:500;
      transition:all 0.18s; margin-bottom:2px;
    }
    .sb-menu li a i { width:16px; text-align:center; font-size:12px; }
    .sb-menu li a:hover { background:rgba(255,255,255,0.06); color:#e2e8f0; }
    .sb-menu li.active a { background:rgba(230,57,70,0.18); color:#fb8b8b; }
    .sb-menu li a .nb {
      margin-left:auto; background:var(--acc);
      color:#fff; font-size:10px; padding:1px 7px; border-radius:10px; font-weight:700;
    }
    .sb-menu li a .arr { margin-left:auto; font-size:10px; }

    .sb-bottom { margin-top:auto; padding:12px 8px; border-top:1px solid rgba(255,255,255,0.06); }

    /* ══ MAIN ══ */
    #main { margin-left:var(--sw); display:flex; flex-direction:column; min-height:100vh; }

    /* ══ TOPBAR ══ */
    #topbar {
      height:var(--top); background:#fff;
      display:flex; align-items:center; padding:0 24px; gap:12px;
      box-shadow:0 1px 4px rgba(0,0,0,0.07);
      position:sticky; top:0; z-index:999;
    }
    .srch { position:relative; flex:1; max-width:280px; }
    .srch i { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; }
    .srch input {
      width:100%; padding:8px 12px 8px 32px;
      border:1.5px solid #e2e8f0; border-radius:8px;
      font-size:13px; background:#f8fafc; outline:none;
      font-family:'Sora',sans-serif; transition:border-color 0.2s;
    }
    .srch input:focus { border-color:var(--acc); background:#fff; }

    .tb-right { display:flex; align-items:center; gap:4px; margin-left:auto; }
    .tb-btn {
      width:36px; height:36px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      background:transparent; border:none; color:#64748b;
      position:relative; cursor:pointer; transition:background 0.15s;
    }
    .tb-btn:hover { background:#f1f5f9; }
    .tb-dot {
      position:absolute; top:5px; right:5px;
      width:14px; height:14px; background:var(--acc);
      border-radius:50%; font-size:8px; color:#fff;
      display:flex; align-items:center; justify-content:center; font-weight:700;
    }
    .user-chip {
      display:flex; align-items:center; gap:8px;
      padding:4px 10px; border-radius:10px;
      cursor:pointer; transition:background 0.15s; margin-left:6px;
    }
    .user-chip:hover { background:#f1f5f9; }
    .user-chip img { width:30px; height:30px; border-radius:50%; }
    .user-chip .uc-name { font-size:13px; font-weight:600; color:var(--txt); }
    .user-chip .uc-role { font-size:10px; color:var(--muted); }

    /* ══ CONTENT ══ */
    #content { padding:24px; flex:1; }

    .pg-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; }
    .pg-head h4 { font-size:20px; font-weight:800; }
    .breadcrumb { font-size:12px; margin:0; }
    .breadcrumb-item a { color:var(--muted); text-decoration:none; }
    .breadcrumb-item.active { color:var(--acc); font-weight:600; }

    /* ══ STAT CARDS ══ */
    .scard {
      border-radius:var(--radius); padding:20px 20px 16px;
      color:#fff; position:relative; overflow:hidden;
      min-height:115px; display:flex; flex-direction:column; justify-content:space-between;
      opacity:0; transform:translateY(16px);
      animation: up 0.45s forwards;
    }
    @keyframes up { to { opacity:1; transform:translateY(0); } }

    .scard .sc-lbl  { font-size:11.5px; font-weight:600; opacity:0.85; }
    .scard .sc-num  { font-size:30px; font-weight:800; line-height:1.1; }
    .scard .sc-foot { font-size:11px; opacity:0.7; }
    .scard .sc-ico  {
      position:absolute; right:14px; top:50%; transform:translateY(-50%);
      font-size:50px; opacity:0.14;
    }

    .sc-red    { background:linear-gradient(135deg,#b5172a,#e63946); animation-delay:0.05s; }
    .sc-orange { background:linear-gradient(135deg,#c1621a,#f4a261); animation-delay:0.10s; }
    .sc-teal   { background:linear-gradient(135deg,#0d7377,#14a085); animation-delay:0.15s; }
    .sc-navy   { background:linear-gradient(135deg,#1a3a5c,#2980b9); animation-delay:0.20s; }
    .sc-purple { background:linear-gradient(135deg,#512b85,#8e44ad); animation-delay:0.25s; }
    .sc-green  { background:linear-gradient(135deg,#145a32,#27ae60); animation-delay:0.30s; }

    /* ══ WHITE CARDS ══ */
    .wcard {
      background:#fff; border-radius:var(--radius);
      padding:22px; box-shadow:0 1px 6px rgba(0,0,0,0.05);
      opacity:0; animation:up 0.45s 0.3s forwards;
    }
    .wcard h6 { font-size:14px; font-weight:700; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .wcard h6 i { color:var(--acc); }

    /* ══ DONUT CHART ══ */
    .donut-wrap { position:relative; width:130px; height:130px; margin:0 auto 16px; }
    .donut-wrap svg { width:130px; height:130px; transform:rotate(-90deg); }
    .donut-bg { fill:none; stroke:#f0f4f8; stroke-width:14; }
    .donut-fg { fill:none; stroke-width:14; stroke-linecap:round; transition:stroke-dasharray 1.2s ease; }
    .donut-num {
      position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
      font-size:22px; font-weight:800; color:var(--txt);
    }
    .donut-lbl { text-align:center; font-size:13px; font-weight:600; color:var(--txt); }
    .donut-sub { text-align:center; font-size:11px; color:var(--muted); }

    /* ══ LEGEND ══ */
    .legend-item { display:flex; align-items:center; gap:8px; font-size:12px; margin-bottom:10px; }
    .legend-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
    .legend-val { margin-left:auto; font-weight:700; font-size:13px; }

    /* ══ MINI BARS ══ */
    .mini-bar-row { margin-bottom:14px; }
    .mini-bar-top { display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px; }
    .mini-bar-top span:first-child { font-weight:600; }
    .mini-bar-top span:last-child { color:var(--muted); }
    .mini-track { height:6px; background:#f0f4f8; border-radius:10px; }
    .mini-fill  { height:6px; border-radius:10px; transition:width 1.1s ease; }

    /* ══ TABLE ══ */
    .table thead th {
      font-size:11px; text-transform:uppercase; letter-spacing:0.7px;
      color:var(--muted); border-bottom:2px solid #f0f4f8; padding:8px 10px; font-weight:600;
    }
    .table tbody td { font-size:13px; padding:9px 10px; border-color:#f8fafc; vertical-align:middle; }
    .table tbody tr:hover td { background:#fafbfc; }

    .pill { font-size:11px; padding:3px 11px; border-radius:20px; font-weight:600; }
    .pill-warn    { background:#fff4e0; color:#92400e; }
    .pill-success { background:#d1fae5; color:#065f46; }
    .pill-danger  { background:#fee2e2; color:#991b1b; }
    .pill-info    { background:#dbeafe; color:#1e40af; }

    .act-btn {
      font-size:11px; padding:4px 12px; border-radius:20px;
      background:var(--sb); color:#fff; border:none; cursor:pointer;
      text-decoration:none; display:inline-flex; align-items:center; gap:4px;
      transition:background 0.15s;
    }
    .act-btn:hover { background:var(--acc); color:#fff; }

    /* ══ ACTIVITY FEED ══ */
    .feed-item { display:flex; gap:12px; margin-bottom:14px; align-items:flex-start; }
    .feed-ico {
      width:34px; height:34px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      font-size:13px; flex-shrink:0;
    }
    .feed-txt { font-size:12.5px; line-height:1.5; }
    .feed-time { font-size:11px; color:var(--muted); margin-top:2px; }

    /* ══ QUICK ACTIONS ══ */
    .qa-btn {
      display:flex; flex-direction:column; align-items:center; justify-content:center;
      gap:8px; padding:18px 10px;
      border:1.5px solid #e2e8f0; border-radius:12px;
      background:#fff; cursor:pointer; transition:all 0.2s;
      text-decoration:none; color:var(--txt);
    }
    .qa-btn:hover { border-color:var(--acc); background:#fff5f5; color:var(--acc); transform:translateY(-2px); box-shadow:0 6px 16px rgba(230,57,70,0.1); }
    .qa-btn i { font-size:20px; }
    .qa-btn span { font-size:11.5px; font-weight:600; text-align:center; }

    /* ══ TOP PRODUCTS ══ */
    .prod-item { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
    .prod-rank { width:24px; height:24px; border-radius:6px; background:var(--bg); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:var(--muted); flex-shrink:0; }
    .prod-rank.gold   { background:#fef3c7; color:#92400e; }
    .prod-rank.silver { background:#f1f5f9; color:#475569; }
    .prod-rank.bronze { background:#fde8d8; color:#c05621; }
    .prod-info { flex:1; }
    .prod-name { font-size:13px; font-weight:600; }
    .prod-cat  { font-size:11px; color:var(--muted); }
    .prod-rev  { font-size:13px; font-weight:700; color:var(--acc); }
  </style>
</head>
<body>
