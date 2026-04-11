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
        --accent-hover: #4338ca;
        --success: #059669;
        --success-soft: #d1fae5;
        --danger: #dc2626;
        --danger-soft: #fee2e2;
        --warning: #d97706;
        --warning-soft: #fef3c7;
        --radius: 12px;
        --radius-sm: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
        --shadow-lg: 0 8px 32px rgba(0,0,0,.12);
    }

    * { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }
    .page-title { font-size: 22px; font-weight: 700; color: var(--ink); letter-spacing: -.3px; margin: 0 0 4px; }
    .breadcrumb { margin: 0; padding: 0; background: none; }
    .breadcrumb-item a { color: var(--ink-muted); text-decoration: none; font-size: 13px; }
    .breadcrumb-item.active { color: var(--ink-muted); font-size: 13px; }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--ink-muted); }

    .main-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .card-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
    }
    .show-entries { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--ink-muted); }
    .show-entries select {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 4px 8px;
        font-size: 13px;
        color: var(--ink);
        background: var(--surface);
        outline: none;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
    }
    .top-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .search-wrap { position: relative; }
    .search-wrap input {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 7px 12px 7px 34px;
        font-size: 13px;
        width: 200px;
        outline: none;
        transition: border-color .2s;
        font-family: 'Outfit', sans-serif;
        color: var(--ink);
        background: var(--surface);
    }
    .search-wrap input:focus { border-color: var(--accent); }
    .search-wrap svg {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%);
        color: var(--ink-muted); width: 14px; height: 14px;
    }
    .btn-add {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--accent); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 8px 16px; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: background .2s, transform .15s;
        font-family: 'Outfit', sans-serif;
        text-decoration: none; white-space: nowrap;
    }
    .btn-add:hover { background: var(--accent-hover); color: #fff; transform: translateY(-1px); }

    .cust-table { width: 100%; border-collapse: collapse; }
    .cust-table thead tr { background: var(--surface-3); border-bottom: 1px solid var(--border); }
    .cust-table th {
        padding: 12px 16px; font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .6px;
        color: var(--ink-muted); white-space: nowrap;
    }
    .cust-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .cust-table tbody tr:hover { background: var(--surface-2); }
    .cust-table tbody tr:last-child { border-bottom: none; }
    .cust-table td { padding: 14px 16px; font-size: 13px; color: var(--ink); vertical-align: middle; }

    .avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .avatar-placeholder {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--accent-soft); color: var(--accent);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; flex-shrink: 0;
    }
    .customer-info { display: flex; align-items: center; gap: 10px; }
    .customer-name { font-weight: 600; color: var(--ink); font-size: 13px; }
    .customer-sub { font-size: 11px; color: var(--ink-muted); margin-top: 1px; }

    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .4px;
    }
    .badge-active  { background: var(--success-soft); color: var(--success); }
    .badge-blocked { background: var(--danger-soft);  color: var(--danger); }
    .badge-vendor  { background: var(--warning-soft); color: var(--warning); }

    .action-group { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .btn-action {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; border-radius: 6px;
        font-size: 11px; font-weight: 600;
        cursor: pointer; border: none; transition: all .15s;
        text-decoration: none; white-space: nowrap;
        font-family: 'Outfit', sans-serif;
    }
    .btn-action svg { width: 12px; height: 12px; }
    .btn-dark          { background: var(--ink);      color: #fff; }
    .btn-dark:hover    { background: var(--ink-soft); color: #fff; }
    .btn-green         { background: var(--success);  color: #fff; }
    .btn-green:hover   { background: #047857;         color: #fff; }
    .btn-red           { background: var(--danger);   color: #fff; }
    .btn-red:hover     { background: #b91c1c;         color: #fff; }
    .btn-indigo        { background: var(--accent);   color: #fff; }
    .btn-indigo:hover  { background: var(--accent-hover); color: #fff; }
    .btn-outline-muted { background: var(--surface-3); color: var(--ink-muted); border: 1px solid var(--border); }
    .btn-outline-muted:hover { background: var(--border); color: var(--ink); }

    .pagi-wrap {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
    }
    .pagi-info { font-size: 12px; color: var(--ink-muted); }
    .pagination { margin: 0; }
    .page-link {
        border-radius: 6px !important; margin: 0 2px;
        font-size: 12px; padding: 5px 10px;
        border: 1px solid var(--border); color: var(--ink-muted);
        font-family: 'Outfit', sans-serif;
    }
    .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }
    .page-link:hover { background: var(--surface-3); color: var(--ink); }

    .alert-success-custom {
        background: var(--success-soft); color: var(--success);
        border: 1px solid #a7f3d0; border-radius: var(--radius-sm);
        padding: 10px 16px; font-size: 13px;
        display: flex; align-items: center; gap: 8px;
        margin: 16px 24px 0;
    }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state svg { color: var(--border); width: 48px; height: 48px; margin-bottom: 12px; }
    .empty-state p { color: var(--ink-muted); font-size: 14px; margin: 0; }

    /* ── Modal ── */
    .modal-content {
        border: none !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-lg) !important;
        font-family: 'Outfit', sans-serif;
    }
    .modal-header-custom {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-title-custom {
        font-size: 16px; font-weight: 700; color: var(--ink);
        display: flex; align-items: center; gap: 8px;
    }
    .modal-title-custom .title-icon {
        width: 30px; height: 30px; border-radius: 8px;
        background: var(--accent-soft);
        display: inline-flex; align-items: center; justify-content: center;
    }
    .modal-title-custom .title-icon svg { width: 15px; height: 15px; color: var(--accent); }
    .modal-body-custom { padding: 20px 24px; max-height: 75vh; overflow-y: auto; }
    .modal-footer-custom {
        padding: 14px 24px 20px;
        border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: flex-end; gap: 8px;
    }
    .btn-modal-primary {
        background: var(--accent); color: #fff; border: none;
        border-radius: var(--radius-sm); padding: 9px 22px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        transition: background .2s; font-family: 'Outfit', sans-serif;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-modal-primary:hover { background: var(--accent-hover); }
    .btn-modal-cancel {
        background: var(--surface-3); color: var(--ink-muted);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 9px 18px; font-size: 13px; font-weight: 500;
        cursor: pointer; font-family: 'Outfit', sans-serif;
    }
    .btn-modal-cancel:hover { background: var(--border); color: var(--ink); }

    /* ── Form shared styles (inlined so modal works without separate CSS) ── */
    .form-section-label {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .8px; color: var(--ink-muted);
        margin: 18px 0 10px;
        display: flex; align-items: center; gap: 8px;
    }
    .form-section-label::after {
        content: ''; flex: 1; height: 1px; background: var(--border);
    }
    .f-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 12px; margin-bottom: 12px;
    }
    .f-row.full { grid-template-columns: 1fr; }
    .f-group { display: flex; flex-direction: column; gap: 5px; }
    .f-label { font-size: 12px; font-weight: 600; color: var(--ink-soft); }
    .f-label .req { color: #dc2626; margin-left: 2px; }
    .f-input, .f-select {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 8px 12px; font-size: 13px;
        color: var(--ink); background: var(--surface);
        outline: none; transition: border-color .2s, box-shadow .2s;
        font-family: 'Outfit', sans-serif; width: 100%;
    }
    .f-input:focus, .f-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,70,229,.1);
    }
    .f-input::placeholder { color: #c4c9d6; font-size: 12px; }
    .f-upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 16px; text-align: center;
        cursor: pointer; transition: all .2s;
        background: var(--surface-2);
        position: relative; display: block;
    }
    .f-upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .f-upload-zone input[type="file"] { display: none; }
    .f-upload-zone svg { width: 22px; height: 22px; color: var(--ink-muted); margin-bottom: 4px; }
    .f-upload-zone p { margin: 0; font-size: 12px; color: var(--ink-muted); }
    .f-upload-zone small { font-size: 10px; color: var(--ink-muted); }
    .f-upload-preview {
        width: 56px; height: 56px; border-radius: 50%;
        object-fit: cover; border: 2px solid var(--accent-soft); margin-bottom: 4px;
    }
    @media (max-width: 600px) { .f-row { grid-template-columns: 1fr; } }
</style>

<div class="container-fluid px-1">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h2 class="page-title">Customers</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="main-card">

        {{-- Flash --}}
        @if(session('success'))
        <div class="alert-success-custom">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;flex-shrink:0;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Top Bar --}}
        <div class="card-top-bar">
            <div class="show-entries">
                Show
                <select id="perPage">
                    <option value="10"  {{ request('per_page', 10) == 10  ? 'selected' : '' }}>10</option>
                    <option value="25"  {{ request('per_page', 10) == 25  ? 'selected' : '' }}>25</option>
                    <option value="50"  {{ request('per_page', 10) == 50  ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </div>
            <div class="top-actions">
                <div class="search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803z"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search customers…" value="{{ request('search') }}">
                </div>

                {{-- ✅ Add Customer Button — goes to dedicated create page (no modal lag) --}}
                <a href="{{ route('customer.create') }}" class="btn-add">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Add Customer
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="cust-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $i => $customer)
                    <tr>
                        <td style="color:var(--ink-muted);font-size:12px;font-family:'JetBrains Mono',monospace;">
                            {{ $customers->firstItem() + $i }}
                        </td>
                        <td>
                            <div class="customer-info">
                                @if($customer->image && file_exists(public_path($customer->image)))
                                    <img src="{{ asset($customer->image) }}" class="avatar" alt="{{ $customer->name }}">
                                @else
                                    <div class="avatar-placeholder">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-sub">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;color:var(--ink);">{{ $customer->phone }}</div>
                            <div style="font-size:11px;color:var(--ink-muted);">
                                {{ $customer->city ?? '—' }}{{ $customer->country ? ', '.$customer->country : '' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge-status {{ $customer->isBlocked() ? 'badge-blocked' : 'badge-active' }}">
                                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                                {{ $customer->isBlocked() ? 'Blocked' : 'Active' }}
                            </span>
                        </td>
                        <td>
                            @if($customer->isVendor())
                                <span class="badge-status badge-vendor">⭐ Vendor</span>
                            @else
                                <span style="font-size:12px;color:var(--ink-muted);">Customer</span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--ink-muted);">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="action-group">

                                {{-- Deposit --}}
                                <button type="button" class="btn-action btn-dark"
                                    data-bs-toggle="modal" data-bs-target="#depositModal{{ $customer->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Deposit
                                </button>

                                {{-- Make Vendor --}}
                                @if(!$customer->isVendor())
                                <button type="button" class="btn-action btn-dark"
                                    data-bs-toggle="modal" data-bs-target="#vendorModal{{ $customer->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                                    </svg>
                                    Vendor
                                </button>
                                @endif

                                {{-- View --}}
                                <a href="{{ route('customer.show', $customer->id) }}" class="btn-action btn-indigo">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    View
                                </a>

                                {{-- Edit — goes to dedicated edit page (no modal lag) --}}
                                <a href="{{ route('customer.edit', $customer->id) }}" class="btn-action btn-outline-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                    </svg>
                                    Edit
                                </a>

                                {{-- Block / Unblock --}}
                                <form action="{{ route('customer.status', $customer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action {{ $customer->isBlocked() ? 'btn-green' : 'btn-red' }}">
                                        @if($customer->isBlocked())
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        Unblock
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        Block
                                        @endif
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this customer permanently? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-red">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                <p>No customers found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
        <div class="pagi-wrap">
            <div class="pagi-info">
                Showing {{ $customers->firstItem() }} – {{ $customers->lastItem() }} of {{ $customers->total() }} entries
            </div>
            {{ $customers->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>{{-- /main-card --}}
</div>{{-- /container-fluid --}}


{{-- ══════════════════════════════════════════
     ADD CUSTOMER MODAL
══════════════════════════════════════════ --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header-custom">
                <div class="modal-title-custom" id="addCustomerModalLabel">
                    <span class="title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                        </svg>
                    </span>
                    Add New Customer
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body-custom">
                    @include('admin.customer.form', ['customer' => null])
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     PER-CUSTOMER MODALS
══════════════════════════════════════════ --}}
@foreach($customers as $customer)

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header-custom">
                    <div class="modal-title-custom">
                        <span class="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                        </span>
                        Edit — {{ $customer->name }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body-custom">
                        @include('admin.customer.form', ['customer' => $customer])
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-modal-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Update Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- VENDOR MODAL --}}
    @if(!$customer->isVendor())
    <div class="modal fade" id="vendorModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header-custom">
                    <div class="modal-title-custom">
                        <span class="title-icon" style="background:#fef3c7;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="color:#d97706;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                            </svg>
                        </span>
                        Promote to Vendor — {{ $customer->name }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.makeVendor', $customer->id) }}" method="POST">
                    @csrf
                    <div class="modal-body-custom">
                        @include('admin.customer.vendor_form')
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-modal-primary" style="background:#d97706;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Confirm Vendor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- DEPOSIT MODAL --}}
    <div class="modal fade" id="depositModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header-custom">
                    <div class="modal-title-custom">
                        <span class="title-icon" style="background:#d1fae5;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="color:#059669;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        Manage Deposit — {{ $customer->name }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body-custom">
                        <div style="display:flex;flex-direction:column;gap:5px;">
                            <label class="f-label">Amount <span class="req">*</span></label>
                            <input type="number" name="amount" min="1" step="0.01" class="f-input"
                                placeholder="Enter deposit amount" required>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;margin-top:12px;">
                            <label class="f-label">Note</label>
                            <textarea name="note" rows="2" class="f-input" style="resize:vertical;"
                                placeholder="Optional note…"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-modal-primary" style="background:#059669;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            Add Deposit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endforeach


<script>
    // ── Search on Enter ──
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            window.location.href = '{{ route("customer.index") }}?search=' + encodeURIComponent(this.value)
                + '&per_page={{ request("per_page", 10) }}';
        }
    });

    // ── Per-page dropdown ──
    document.getElementById('perPage').addEventListener('change', function() {
        const search = document.getElementById('searchInput').value;
        window.location.href = '{{ route("customer.index") }}?per_page=' + this.value
            + (search ? '&search=' + encodeURIComponent(search) : '');
    });

    // ── Image preview for upload zones ──
    function previewCustomerImg(input, uid) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const zone        = document.getElementById('uploadZone_' + uid);
            const placeholder = document.getElementById('uploadPlaceholder_' + uid);
            const img         = document.getElementById('imgPreview_' + uid);
            if (img) { img.src = e.target.result; img.style.display = ''; }
            if (placeholder) placeholder.style.display = 'none';
            const caption = zone ? zone.querySelector('p') : null;
            if (caption) caption.textContent = 'Click to change photo';
        };
        reader.readAsDataURL(input.files[0]);
    }

    // ── Bootstrap 5 modal safety init ──
    // Ensures modals work even if Bootstrap JS loads after DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function () {
        var modalEls = document.querySelectorAll('.modal');
        modalEls.forEach(function(el) {
            el.addEventListener('show.bs.modal', function () {
                document.body.classList.add('modal-open');
            });
        });
    });
</script>

@endsection
