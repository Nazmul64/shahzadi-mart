<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Genius Shop - Admin Panel</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; overflow-x: hidden; }

    /* Sidebar */
    #sidebar {
      width: 220px; min-height: 100vh; background: #1a2035;
      position: fixed; top: 0; left: 0; z-index: 1000;
      display: flex; flex-direction: column;
      transition: width 0.3s;
    }
    #sidebar .brand {
      padding: 18px 20px; display: flex; align-items: center; gap: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    #sidebar .brand-icon {
      width: 38px; height: 38px; background: #4e9ef5; border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: #fff; font-size: 16px; flex-shrink: 0;
    }
    #sidebar .brand-text { color: #fff; line-height: 1.2; }
    #sidebar .brand-text strong { font-size: 14px; display: block; }
    #sidebar .brand-text span { font-size: 10px; color: #aab; letter-spacing: 1px; text-transform: uppercase; }

    .sidebar-section { padding: 14px 0 4px 20px; font-size: 10px; color: #6b7fa3; letter-spacing: 1.5px; text-transform: uppercase; }

    .sidebar-menu { list-style: none; padding: 0; margin: 0; }
    .sidebar-menu li a {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px; color: #aab8d4; text-decoration: none;
      font-size: 13.5px; transition: all 0.2s; border-left: 3px solid transparent;
    }
    .sidebar-menu li a:hover, .sidebar-menu li.active a {
      color: #fff; background: rgba(255,255,255,0.06);
      border-left-color: #4e9ef5;
    }
    .sidebar-menu li.active a { color: #4e9ef5; }
    .sidebar-menu li a i { width: 18px; text-align: center; font-size: 13px; }
    .sidebar-menu li a .arrow { margin-left: auto; font-size: 11px; }

    .sidebar-bottom { padding: 14px 0; border-top: 1px solid rgba(255,255,255,0.08); margin-top: auto; }

    /* Main */
    #main { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }

    /* Topbar */
    #topbar {
      background: #fff; height: 58px; display: flex; align-items: center;
      padding: 0 24px; gap: 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.08);
      position: sticky; top: 0; z-index: 999;
    }
    #topbar .search-wrap { flex: 1; max-width: 320px; position: relative; }
    #topbar .search-wrap input {
      width: 100%; border: 1px solid #e0e4ed; border-radius: 8px;
      padding: 7px 12px 7px 36px; font-size: 13px; background: #f8f9fc; outline: none;
    }
    #topbar .search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 13px; }
    #topbar .topbar-icons { display: flex; align-items: center; gap: 6px; margin-left: auto; }
    .icon-btn {
      width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center;
      justify-content: center; color: #6b7fa3; cursor: pointer; position: relative;
      transition: background 0.2s; border: none; background: transparent;
    }
    .icon-btn:hover { background: #f0f2f5; }
    .icon-btn .badge-dot {
      position: absolute; top: 4px; right: 4px; width: 16px; height: 16px;
      background: #e53935; border-radius: 50%; font-size: 9px; color: #fff;
      display: flex; align-items: center; justify-content: center; font-weight: 700;
    }
    .user-pill {
      display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 4px 8px;
      border-radius: 8px; transition: background 0.2s;
    }
    .user-pill:hover { background: #f0f2f5; }
    .user-pill img { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
    .user-pill .uname { font-size: 13px; font-weight: 600; color: #2d3a5e; }
    .user-pill .uarrow { font-size: 11px; color: #aaa; }

    /* Content */
    #content { padding: 24px; flex: 1; }
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
    .page-header h4 { font-size: 20px; font-weight: 700; color: #2d3a5e; margin: 0; }
    .breadcrumb { font-size: 12px; margin: 0; }
    .breadcrumb-item a { color: #6b7fa3; text-decoration: none; }

    /* Stat Cards */
    .stat-card {
      border-radius: 14px; padding: 22px 22px 18px; color: #fff;
      position: relative; overflow: hidden; height: 130px;
      display: flex; flex-direction: column; justify-content: space-between;
    }
    .stat-card .card-label { font-size: 13px; font-weight: 600; opacity: 0.9; }
    .stat-card .card-number { font-size: 36px; font-weight: 800; line-height: 1; }
    .stat-card .card-btn {
      display: inline-block; background: rgba(255,255,255,0.22); color: #fff;
      font-size: 12px; padding: 4px 14px; border-radius: 20px; text-decoration: none;
      border: none; cursor: pointer; transition: background 0.2s;
    }
    .stat-card .card-btn:hover { background: rgba(255,255,255,0.38); color: #fff; }
    .stat-card .bg-icon {
      position: absolute; right: 18px; top: 50%; transform: translateY(-50%);
      font-size: 62px; opacity: 0.18;
    }
    .card-orange  { background: linear-gradient(135deg, #f7931e, #f4a637); }
    .card-blue    { background: linear-gradient(135deg, #1565c0, #1e88e5); }
    .card-teal    { background: linear-gradient(135deg, #00897b, #26a69a); }
    .card-purple  { background: linear-gradient(135deg, #6a1b9a, #ab47bc); }
    .card-red     { background: linear-gradient(135deg, #b71c1c, #e53935); }
    .card-green   { background: linear-gradient(135deg, #2e7d32, #43a047); }

    /* Donut circles */
    .circle-card { background: #fff; border-radius: 14px; padding: 24px 16px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .circle-wrap { position: relative; width: 100px; height: 100px; margin: 0 auto 14px; }
    .circle-wrap svg { width: 100px; height: 100px; transform: rotate(-90deg); }
    .circle-wrap .circle-bg { fill: none; stroke: #f0f2f5; stroke-width: 10; }
    .circle-wrap .circle-fg { fill: none; stroke-width: 10; stroke-linecap: round; transition: stroke-dasharray 1s ease; }
    .circle-wrap .circle-num {
      position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
      font-size: 22px; font-weight: 800; color: #2d3a5e;
    }
    .circle-label { font-size: 13px; font-weight: 600; color: #2d3a5e; margin-bottom: 2px; }
    .circle-sub { font-size: 11px; color: #aab; }

    /* Table section */
    .table-card { background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .table-card h6 { font-size: 15px; font-weight: 700; color: #2d3a5e; margin-bottom: 18px; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7fa3; border-bottom: 2px solid #f0f2f5; padding: 8px 10px; }
    .table tbody td { font-size: 13px; color: #2d3a5e; vertical-align: middle; padding: 9px 10px; border-color: #f5f6fa; }
    .btn-detail {
      background: #1a2035; color: #fff; font-size: 11px; padding: 5px 14px;
      border-radius: 20px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
      transition: background 0.2s;
    }
    .btn-detail:hover { background: #4e9ef5; color: #fff; }
  </style>
</head>
<body>
