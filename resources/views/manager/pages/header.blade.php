<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manager Dashboard — shahzadimart shop</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --sidebar-bg: #0f172a;
      --sidebar-width: 230px;
      --accent: #6366f1;
      --accent2: #06b6d4;
      --topbar-h: 60px;
      --card-radius: 14px;
      --text-main: #1e293b;
      --text-muted: #94a3b8;
      --bg: #f1f5f9;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-main); }

    /* ── SIDEBAR ── */
    #sidebar {
      width: var(--sidebar-width);
      min-height: 100vh;
      background: var(--sidebar-bg);
      position: fixed; top: 0; left: 0; z-index: 1000;
      display: flex; flex-direction: column;
      transition: transform 0.3s;
    }

    .sidebar-brand {
      padding: 20px 18px;
      display: flex; align-items: center; gap: 10px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .brand-logo {
      width: 38px; height: 38px; border-radius: 10px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 16px; color: #fff; flex-shrink: 0;
    }
    .brand-info strong { display: block; color: #fff; font-size: 14px; font-weight: 700; }
    .brand-info span   { font-size: 10px; color: #64748b; letter-spacing: 1px; text-transform: uppercase; }

    .nav-section {
      padding: 18px 18px 6px;
      font-size: 10px; color: #475569;
      letter-spacing: 1.4px; text-transform: uppercase; font-weight: 600;
    }

    .nav-list { list-style: none; padding: 0 8px; }
    .nav-list li a {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 12px; border-radius: 8px;
      color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 500;
      transition: all 0.18s; margin-bottom: 2px;
    }
    .nav-list li a i { width: 18px; text-align: center; font-size: 13px; }
    .nav-list li a:hover { background: rgba(255,255,255,0.06); color: #e2e8f0; }
    .nav-list li.active a { background: rgba(99,102,241,0.18); color: #818cf8; }
    .nav-list li a .badge-nav {
      margin-left: auto; background: var(--accent);
      color: #fff; font-size: 10px; padding: 2px 7px; border-radius: 10px;
    }
    .nav-list li a .arrow { margin-left: auto; font-size: 10px; }

    .sidebar-footer {
      margin-top: auto; padding: 14px 8px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    /* ── MAIN ── */
    #main { margin-left: var(--sidebar-width); display: flex; flex-direction: column; min-height: 100vh; }

    /* ── TOPBAR ── */
    #topbar {
      height: var(--topbar-h); background: #fff;
      display: flex; align-items: center; padding: 0 24px; gap: 12px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.07);
      position: sticky; top: 0; z-index: 999;
    }
    .search-box { position: relative; flex: 1; max-width: 300px; }
    .search-box i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; }
    .search-box input {
      width: 100%; padding: 8px 12px 8px 34px;
      border: 1px solid #e2e8f0; border-radius: 8px;
      font-size: 13px; background: #f8fafc; outline: none;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .search-box input:focus { border-color: var(--accent); background: #fff; }

    .topbar-right { display: flex; align-items: center; gap: 4px; margin-left: auto; }
    .t-btn {
      width: 36px; height: 36px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      background: transparent; border: none; color: #64748b;
      position: relative; cursor: pointer; transition: background 0.15s;
    }
    .t-btn:hover { background: #f1f5f9; }
    .t-badge {
      position: absolute; top: 4px; right: 4px;
      width: 15px; height: 15px; background: #ef4444;
      border-radius: 50%; font-size: 9px; color: #fff;
      display: flex; align-items: center; justify-content: center; font-weight: 700;
    }
    .manager-pill {
      display: flex; align-items: center; gap: 8px;
      padding: 4px 10px; border-radius: 10px; cursor: pointer;
      transition: background 0.15s; margin-left: 6px;
    }
    .manager-pill:hover { background: #f1f5f9; }
    .manager-pill img { width: 30px; height: 30px; border-radius: 50%; }
    .manager-pill .mp-name { font-size: 13px; font-weight: 600; color: var(--text-main); }
    .manager-pill .mp-role { font-size: 10px; color: var(--text-muted); }

    /* ── CONTENT ── */
    #content { padding: 24px; flex: 1; }

    .page-top {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 22px;
    }
    .page-top h4 { font-size: 20px; font-weight: 800; color: var(--text-main); }
    .breadcrumb { font-size: 12px; margin: 0; --bs-breadcrumb-divider-color: #94a3b8; }
    .breadcrumb-item a { color: #94a3b8; text-decoration: none; }
    .breadcrumb-item.active { color: var(--accent); }

    /* ── STAT CARDS ── */
    .stat-card {
      border-radius: var(--card-radius);
      padding: 20px;
      color: #fff;
      position: relative; overflow: hidden;
      min-height: 118px;
      display: flex; flex-direction: column; justify-content: space-between;
      opacity: 0; transform: translateY(18px);
      animation: fadeUp 0.5s forwards;
    }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }

    .stat-card .sc-label { font-size: 12px; font-weight: 600; opacity: 0.85; }
    .stat-card .sc-num  { font-size: 32px; font-weight: 800; line-height: 1.1; }
    .stat-card .sc-sub  { font-size: 11px; opacity: 0.7; }
    .stat-card .sc-icon {
      position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
      font-size: 54px; opacity: 0.15;
    }
    .sc-indigo  { background: linear-gradient(135deg, #4f46e5, #818cf8); animation-delay: 0.05s; }
    .sc-cyan    { background: linear-gradient(135deg, #0891b2, #22d3ee); animation-delay: 0.10s; }
    .sc-emerald { background: linear-gradient(135deg, #059669, #34d399); animation-delay: 0.15s; }
    .sc-amber   { background: linear-gradient(135deg, #d97706, #fbbf24); animation-delay: 0.20s; }
    .sc-rose    { background: linear-gradient(135deg, #be123c, #fb7185); animation-delay: 0.25s; }
    .sc-violet  { background: linear-gradient(135deg, #7c3aed, #c084fc); animation-delay: 0.30s; }

    /* ── CHART AREA ── */
    .chart-card {
      background: #fff; border-radius: var(--card-radius);
      padding: 22px; box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      opacity: 0; animation: fadeUp 0.5s 0.3s forwards;
    }
    .chart-card .cc-head {
      display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;
    }
    .chart-card .cc-head h6 { font-size: 14px; font-weight: 700; color: var(--text-main); margin: 0; }
    .chart-card .cc-head select {
      font-size: 12px; border: 1px solid #e2e8f0; border-radius: 7px;
      padding: 4px 10px; color: #64748b; outline: none; background: #f8fafc;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Simple bar chart */
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 140px; }
    .bar-wrap  { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .bar {
      width: 100%; border-radius: 6px 6px 0 0;
      background: linear-gradient(180deg, var(--accent), #a5b4fc);
      transition: height 1s cubic-bezier(.4,0,.2,1);
      cursor: pointer; position: relative;
    }
    .bar:hover { filter: brightness(1.12); }
    .bar-tip {
      position: absolute; top: -26px; left: 50%; transform: translateX(-50%);
      background: #1e293b; color: #fff; font-size: 10px; padding: 2px 6px;
      border-radius: 4px; white-space: nowrap; opacity: 0; pointer-events: none;
      transition: opacity 0.2s;
    }
    .bar:hover .bar-tip { opacity: 1; }
    .bar-label { font-size: 10px; color: var(--text-muted); }

    /* ── MINI STATS ROW ── */
    .mini-stat {
      background: #fff; border-radius: var(--card-radius);
      padding: 18px; display: flex; align-items: center; gap: 14px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      opacity: 0; animation: fadeUp 0.5s forwards;
    }
    .mini-icon {
      width: 44px; height: 44px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; flex-shrink: 0;
    }
    .mini-stat .mi-val  { font-size: 20px; font-weight: 800; color: var(--text-main); }
    .mini-stat .mi-label{ font-size: 12px; color: var(--text-muted); font-weight: 500; }
    .mi-bg-indigo  { background: rgba(99,102,241,0.12); color: #6366f1; }
    .mi-bg-cyan    { background: rgba(6,182,212,0.12);  color: #06b6d4; }
    .mi-bg-emerald { background: rgba(5,150,105,0.12);  color: #059669; }
    .mi-bg-amber   { background: rgba(217,119,6,0.12);  color: #d97706; }

    /* ── TABLES ── */
    .table-card {
      background: #fff; border-radius: var(--card-radius);
      padding: 22px; box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      opacity: 0; animation: fadeUp 0.5s 0.4s forwards;
    }
    .table-card h6 { font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; }
    .table thead th {
      font-size: 11px; text-transform: uppercase; letter-spacing: 0.7px;
      color: var(--text-muted); border-bottom: 2px solid #f1f5f9; padding: 8px 10px;
      font-weight: 600;
    }
    .table tbody td { font-size: 13px; color: var(--text-main); padding: 9px 10px; border-color: #f8fafc; vertical-align: middle; }
    .table tbody tr:hover td { background: #f8fafc; }

    .status-pill {
      font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600;
    }
    .sp-success { background: #d1fae5; color: #065f46; }
    .sp-warning { background: #fef3c7; color: #92400e; }
    .sp-danger  { background: #fee2e2; color: #991b1b; }
    .sp-info    { background: #e0f2fe; color: #0c4a6e; }

    .btn-sm-action {
      font-size: 11px; padding: 4px 12px; border-radius: 20px;
      background: #1e293b; color: #fff; border: none; cursor: pointer;
      text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
      transition: background 0.15s;
    }
    .btn-sm-action:hover { background: var(--accent); color: #fff; }

    /* ── ACTIVITY FEED ── */
    .activity-card {
      background: #fff; border-radius: var(--card-radius);
      padding: 22px; box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      opacity: 0; animation: fadeUp 0.5s 0.45s forwards;
    }
    .activity-card h6 { font-size: 14px; font-weight: 700; margin-bottom: 16px; }
    .activity-item { display: flex; gap: 12px; margin-bottom: 14px; }
    .act-dot {
      width: 36px; height: 36px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; flex-shrink: 0;
    }
    .act-text { font-size: 12.5px; color: var(--text-main); line-height: 1.5; }
    .act-time { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

    /* ── PROGRESS ── */
    .progress-card {
      background: #fff; border-radius: var(--card-radius);
      padding: 22px; box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      opacity: 0; animation: fadeUp 0.5s 0.5s forwards;
    }
    .progress-card h6 { font-size: 14px; font-weight: 700; margin-bottom: 18px; }
    .prog-row { margin-bottom: 14px; }
    .prog-label { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; }
    .prog-label span:first-child { font-weight: 600; color: var(--text-main); }
    .prog-label span:last-child  { color: var(--text-muted); }
    .progress { height: 7px; border-radius: 10px; background: #f1f5f9; }
    .progress-bar { border-radius: 10px; transition: width 1.2s cubic-bezier(.4,0,.2,1); }
  </style>
</head>
<body>
