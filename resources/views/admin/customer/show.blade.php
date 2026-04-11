@extends('admin.master')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --ink: #0d0f1a;
        --ink-soft: #2a2d3e;
        --ink-muted: #6b7280;
        --surface: #ffffff;
        --surface-2: #f8f9fc;
        --surface-3: #f1f3f8;
        --border: #e5e8f0;
        --accent: #4f46e5;
        --accent-soft: #ede9fe;
        --success: #059669;
        --success-soft: #d1fae5;
        --danger: #dc2626;
        --danger-soft: #fee2e2;
        --warning: #d97706;
        --warning-soft: #fef3c7;
        --radius: 12px;
        --radius-sm: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    }

    * { font-family: 'Outfit', sans-serif; }

    .page-title { font-size: 22px; font-weight: 700; color: var(--ink); letter-spacing: -.3px; margin: 0 0 4px; }
    .breadcrumb { margin: 0; padding: 0; background: none; }
    .breadcrumb-item a { color: var(--ink-muted); text-decoration: none; font-size: 13px; }
    .breadcrumb-item.active { color: var(--ink-muted); font-size: 13px; }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--ink-muted); }

    .detail-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .detail-header {
        background: linear-gradient(135deg, var(--ink) 0%, #1e2140 100%);
        padding: 32px;
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,.03);
        top: -100px;
        right: -60px;
    }

    .detail-header::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.03);
        bottom: -80px;
        right: 100px;
    }

    .avatar-lg {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,.3);
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .avatar-lg-placeholder {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        border: 3px solid rgba(255,255,255,.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .header-info { position: relative; z-index: 1; }

    .header-name {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }

    .header-email { font-size: 13px; color: rgba(255,255,255,.6); margin-bottom: 10px; }

    .header-badges { display: flex; gap: 8px; flex-wrap: wrap; }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .badge-active { background: var(--success-soft); color: var(--success); }
    .badge-blocked { background: var(--danger-soft); color: var(--danger); }
    .badge-vendor { background: var(--warning-soft); color: var(--warning); }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }

    .info-cell {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
    }

    .info-cell:nth-child(even) { border-right: none; }

    .info-cell-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--ink-muted);
        margin-bottom: 4px;
    }

    .info-cell-value {
        font-size: 14px;
        color: var(--ink);
        font-weight: 500;
    }

    .info-cell-value.muted { color: var(--ink-muted); font-style: italic; font-weight: 400; }

    /* Stats row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid var(--border);
    }

    .stat-item {
        padding: 20px 24px;
        text-align: center;
        border-right: 1px solid var(--border);
    }

    .stat-item:last-child { border-right: none; }

    .stat-num { font-size: 24px; font-weight: 700; color: var(--ink); font-family: 'JetBrains Mono', monospace; }
    .stat-label { font-size: 11px; color: var(--ink-muted); margin-top: 2px; }

    /* Footer actions */
    .detail-footer {
        padding: 16px 24px;
        background: var(--surface-2);
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--surface);
        color: var(--ink-muted);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-back:hover { background: var(--border); color: var(--ink); }

    .btn-edit-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-edit-link:hover { background: #4338ca; color: #fff; }
</style>

<div class="container-fluid px-1">

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h2 class="page-title">Customer Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">{{ $customer->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="detail-card">

        {{-- Profile Header --}}
        <div class="detail-header">
            @if($customer->image && file_exists(base_path($customer->image)))
                <img src="{{ asset($customer->image) }}" class="avatar-lg">
            @else
                <div class="avatar-lg-placeholder">{{ strtoupper(substr($customer->name,0,1)) }}</div>
            @endif
            <div class="header-info">
                <div class="header-name">{{ $customer->name }}</div>
                <div class="header-email">{{ $customer->email }}</div>
                <div class="header-badges">
                    <span class="badge-status {{ $customer->isBlocked() ? 'badge-blocked' : 'badge-active' }}">
                        <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                        {{ $customer->isBlocked() ? 'Blocked' : 'Active' }}
                    </span>
                    @if($customer->isVendor())
                        <span class="badge-status badge-vendor">⭐ Vendor</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-num">{{ $customer->created_at->diffInDays(now()) }}</div>
                <div class="stat-label">Days as Member</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">{{ $customer->isVendor() ? 'Yes' : 'No' }}</div>
                <div class="stat-label">Vendor Status</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">{{ $customer->created_at->format('Y') }}</div>
                <div class="stat-label">Member Since</div>
            </div>
        </div>

        {{-- Info Grid --}}
        <div class="info-grid">
            <div class="info-cell">
                <div class="info-cell-label">Phone</div>
                <div class="info-cell-value">{{ $customer->phone }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Fax</div>
                <div class="info-cell-value {{ $customer->fax ? '' : 'muted' }}">{{ $customer->fax ?: 'Not provided' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Address</div>
                <div class="info-cell-value">{{ $customer->address }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">City</div>
                <div class="info-cell-value {{ $customer->city ? '' : 'muted' }}">{{ $customer->city ?: '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">State / Division</div>
                <div class="info-cell-value {{ $customer->state ? '' : 'muted' }}">{{ $customer->state ?: '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Country</div>
                <div class="info-cell-value {{ $customer->country ? '' : 'muted' }}">{{ $customer->country ?: '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Postal Code</div>
                <div class="info-cell-value {{ $customer->postal_code ? '' : 'muted' }}">{{ $customer->postal_code ?: '—' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-cell-label">Member Since</div>
                <div class="info-cell-value">{{ $customer->created_at->format('d M Y, h:i A') }}</div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="detail-footer">
            <a href="{{ route('customer.index') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Back to Customers
            </a>
        </div>
    </div>

</div>

@endsection
