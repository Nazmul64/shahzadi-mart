<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Portal - Responsive Dashboard</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Frameworks & Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <style>
    :root {
      --primary: #6366f1;
      --primary-glow: rgba(99, 102, 241, 0.4);
      --secondary: #64748b;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --info: #0ea5e9;
      
      --bg-body: #f8fafc;
      --bg-sidebar: #0f172a;
      --bg-card: #ffffff;
      
      --text-main: #0f172a;
      --text-muted: #64748b;
      
      --sb-w: 280px;
      --top-h: 72px;
      --radius: 16px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    
    body { 
      font-family: 'Inter', sans-serif; 
      background: var(--bg-body); 
      color: var(--text-main); 
      overflow-x: hidden;
      min-height: 100vh;
    }

    /* ─── Sidebar ───────────────────────────────────────────── */
    #sidebar {
      width: var(--sb-w); height: 100vh; background: var(--bg-sidebar);
      position: fixed; top: 0; left: 0; z-index: 2000;
      transition: var(--transition);
      display: flex; flex-direction: column;
      box-shadow: 10px 0 30px rgba(0,0,0,0.1);
    }

    .sb-brand {
      height: 90px; display: flex; align-items: center; gap: 14px; padding: 0 24px;
      text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .sb-icon { width: 40px; height: 40px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; box-shadow: 0 8px 16px var(--primary-glow); }
    .sb-brand-name { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
    .sb-brand-tag { font-size: 10px; color: #6366f1; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

    .sb-nav { flex: 1; overflow-y: auto; padding: 20px 0; }
    .sb-section { font-size: 11px; font-weight: 700; color: #475569; padding: 15px 24px 8px; text-transform: uppercase; letter-spacing: 1.5px; }
    
    .sb-item {
      display: flex; align-items: center; justify-content: space-between; padding: 12px 24px;
      color: #94a3b8; text-decoration: none; transition: var(--transition); font-size: 14px; font-weight: 600;
      border: none; background: transparent; width: 100%; text-align: left; cursor: pointer;
    }
    .sb-item:hover, .sb-item.active { color: #fff; background: rgba(255,255,255,0.03); }
    .sb-item.active { color: var(--primary); background: rgba(99,102,241,0.08); border-left: 4px solid var(--primary); padding-left: 20px; }
    .sb-ico { width: 20px; text-align: center; margin-right: 12px; font-size: 18px; opacity: 0.7; }
    .sb-arr { transition: transform 0.3s; font-size: 12px; opacity: 0.5; }
    .sb-item.open .sb-arr { transform: rotate(90deg); }
    
    .sb-sub { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; background: rgba(0,0,0,0.1); }
    .sb-sub.open { max-height: 500px; }
    .sb-sub a { display: flex; align-items: center; padding: 8px 24px 8px 56px; color: #64748b; text-decoration: none; font-size: 13px; transition: var(--transition); }
    .sb-sub a:hover, .sb-sub a.active { color: #fff; }
    .sb-sub a.active { color: var(--primary); font-weight: 700; }

    .sb-logout-wrap { padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.05); }
    .sb-logout {
      width: 100%; padding: 12px; border-radius: 12px; background: rgba(239,68,68,0.1);
      color: #ef4444; border: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; transition: var(--transition);
    }
    .sb-logout:hover { background: #ef4444; color: #fff; }

    /* ─── Main Content ──────────────────────────────────────── */
    #main { 
      margin-left: var(--sb-w); 
      min-height: 100vh; 
      transition: var(--transition);
    }

    /* Overlay for Mobile */
    .sb-overlay {
      position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
      z-index: 1999; display: none; opacity: 0; transition: opacity 0.3s;
    }

    @media (max-width: 1200px) {
      #sidebar { transform: translateX(-100%); }
      #main { margin-left: 0 !important; }
      body.sb-open #sidebar { transform: translateX(0); }
      body.sb-open .sb-overlay { display: block; opacity: 1; }
    }

    /* ─── Topbar ───────────────────────────────────────────── */
    #topbar {
      background: rgba(255,255,255,0.85); backdrop-filter: blur(10px);
      height: var(--top-h); display: flex; align-items: center;
      justify-content: space-between; padding: 0 24px; border-bottom: 1px solid #e2e8f0;
      position: sticky; top: 0; z-index: 1000;
    }
    .topbar-left { display: flex; align-items: center; gap: 16px; }
    .search-wrap { width: 300px; position: relative; }
    .search-wrap input {
      width: 100%; border: 1px solid #e2e8f0; border-radius: 12px;
      padding: 8px 12px 8px 40px; font-size: 14px; background: #f1f5f9; outline: none;
    }
    .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

    .topbar-right { display: flex; align-items: center; gap: 10px; }
    .icon-btn {
      width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center;
      justify-content: center; color: var(--text-muted); cursor: pointer; position: relative;
      transition: var(--transition); border: 1px solid #e2e8f0; background: #fff;
    }
    .icon-btn:hover { background: #f8fafc; color: var(--primary); border-color: var(--primary); }
    .badge-dot {
      position: absolute; top: -3px; right: -3px; width: 16px; height: 16px;
      background: var(--danger); border-radius: 50%; font-size: 9px; color: #fff;
      display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid #fff;
    }

    .user-pill {
      display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 4px 8px;
      border-radius: 12px; transition: var(--transition);
    }
    .user-pill:hover { background: #f1f5f9; }
    .user-pill img { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
    .user-pill .uname { font-size: 13px; font-weight: 700; color: var(--text-main); }

    @media (max-width: 768px) {
      .search-wrap { display: none; }
      #topbar { padding: 0 16px; }
      .topbar-right { gap: 6px; }
      .icon-btn { width: 34px; height: 34px; font-size: 14px; }
      .user-pill .uname { display: none; }
    }

    /* ─── Content ─────────────────────────────────────────── */
    #content { padding: 24px; }
    @media (max-width: 576px) { #content { padding: 16px; } }

    .page-header h4 { font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 20px; }
    
    /* Responsive Stat Cards */
    .stat-card {
      border-radius: var(--radius); padding: 24px; color: #fff;
      position: relative; overflow: hidden; min-height: 130px;
      display: flex; flex-direction: column; justify-content: space-between;
      transition: transform 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card .card-label { font-size: 13px; font-weight: 700; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card .card-number { font-size: 32px; font-weight: 800; }
    .stat-card .bg-icon { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 50px; opacity: 0.2; }

    .card-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .card-success { background: linear-gradient(135deg, #10b981, #059669); }
    .card-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .card-danger  { background: linear-gradient(135deg, #ef4444, #dc2626); }

    /* Responsive Grid */
    .table-card { background: #fff; border-radius: var(--radius); border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
    .table-card-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .table-card-header h6 { font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; }
    
    .table { width: 100%; min-width: 500px; } /* Ensures table content doesn't squeeze too much */
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table thead th { background: #f8fafc; color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; padding: 12px 20px; }
    .table tbody td { padding: 12px 20px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

    .btn-detail {
      background: #f1f5f9; color: var(--text-main); font-size: 12px; padding: 6px 14px;
      border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer; text-decoration: none; font-weight: 700;
    }
    .btn-detail:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
  </style>
</head>
<body>
<div class="sb-overlay" onclick="document.body.classList.remove('sb-open')"></div>
