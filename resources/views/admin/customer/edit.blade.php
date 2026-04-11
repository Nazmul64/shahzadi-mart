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
        --radius: 14px;
        --radius-sm: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
        --shadow-lg: 0 8px 40px rgba(0,0,0,.10);
    }

    * { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap; gap: 12px; margin-bottom: 28px;
    }
    .page-title { font-size: 22px; font-weight: 700; color: var(--ink); letter-spacing: -.3px; margin: 0 0 4px; }
    .breadcrumb { margin: 0; padding: 0; background: none; }
    .breadcrumb-item a { color: var(--ink-muted); text-decoration: none; font-size: 13px; }
    .breadcrumb-item.active { color: var(--ink-muted); font-size: 13px; }
    .breadcrumb-item + .breadcrumb-item::before { color: var(--ink-muted); }

    .form-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px; align-items: start;
    }
    @media (max-width: 900px) { .form-layout { grid-template-columns: 1fr; } }

    .form-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .form-card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
        display: flex; align-items: center; gap: 10px;
    }
    .card-header-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-header-icon svg { width: 16px; height: 16px; color: var(--accent); }
    .card-header-title { font-size: 15px; font-weight: 700; color: var(--ink); margin: 0; }
    .card-header-sub { font-size: 12px; color: var(--ink-muted); margin-top: 1px; }
    .form-card-body { padding: 24px; }

    .f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .f-row.full { grid-template-columns: 1fr; }
    @media (max-width: 600px) { .f-row { grid-template-columns: 1fr; } }

    .f-group { display: flex; flex-direction: column; gap: 6px; }
    .f-label { font-size: 12px; font-weight: 600; color: var(--ink-soft); }
    .req { color: #dc2626; }
    .f-hint { font-size: 11px; color: var(--ink-muted); margin-top: 2px; }

    .f-input, .f-select, .f-textarea {
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 9px 13px; font-size: 13px;
        color: var(--ink); background: var(--surface);
        outline: none; transition: border-color .2s, box-shadow .2s;
        font-family: 'Outfit', sans-serif; width: 100%;
    }
    .f-input:focus, .f-select:focus, .f-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,70,229,.08);
    }
    .f-input::placeholder, .f-textarea::placeholder { color: #c4c9d6; font-size: 12px; }
    .f-textarea { resize: vertical; min-height: 80px; }
    .f-input.is-error { border-color: var(--danger); }

    .f-error {
        font-size: 11px; color: var(--danger);
        display: flex; align-items: center; gap: 4px; margin-top: 2px;
    }

    /* ── Password eye ── */
    .pw-wrap { position: relative; }
    .pw-wrap .f-input { padding-right: 40px; }
    .pw-eye {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: var(--ink-muted); padding: 0;
        display: flex; align-items: center;
    }
    .pw-eye svg { width: 16px; height: 16px; }
    .pw-eye:hover { color: var(--accent); }

    /* ── Current Photo Strip ── */
    .current-photo-strip {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        margin-bottom: 14px;
    }
    .current-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        object-fit: cover; border: 2px solid var(--accent-soft); flex-shrink: 0;
    }
    .current-avatar-ph {
        width: 52px; height: 52px; border-radius: 50%;
        background: var(--accent-soft); color: var(--accent);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700; flex-shrink: 0;
    }
    .current-photo-info { flex: 1; min-width: 0; }
    .current-photo-name { font-size: 13px; font-weight: 600; color: var(--ink); }
    .current-photo-sub  { font-size: 11px; color: var(--ink-muted); margin-top: 2px; }

    /* ── Upload Area ── */
    .photo-upload-area {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        background: var(--surface-2);
        cursor: pointer; transition: all .2s;
        display: block; text-align: center; padding: 22px 20px; position: relative;
    }
    .photo-upload-area:hover { border-color: var(--accent); background: var(--accent-soft); }
    .photo-upload-area input[type="file"] { display: none; }
    .photo-preview-img {
        width: 70px; height: 70px; border-radius: 50%;
        object-fit: cover; border: 3px solid var(--accent-soft);
        margin: 0 auto 8px; display: none;
    }
    .upload-icon-wrap {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--accent-soft);
        display: flex; align-items: center; justify-content: center; margin: 0 auto 8px;
    }
    .upload-icon-wrap svg { width: 20px; height: 20px; color: var(--accent); }
    .upload-title { font-size: 13px; font-weight: 600; color: var(--ink); margin-bottom: 3px; }
    .upload-sub   { font-size: 11px; color: var(--ink-muted); line-height: 1.5; }
    .upload-badge {
        display: inline-flex; align-items: center; gap: 4px;
        margin-top: 8px; background: var(--success-soft);
        color: var(--success); border-radius: 20px;
        padding: 3px 10px; font-size: 11px; font-weight: 600;
    }

    /* ── Profile header card (sidebar) ── */
    .profile-header-card {
        background: linear-gradient(135deg, var(--ink) 0%, #1e2140 100%);
        border-radius: var(--radius);
        padding: 24px 20px;
        text-align: center;
        position: relative; overflow: hidden;
    }
    .profile-header-card::before {
        content: ''; position: absolute;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(255,255,255,.04);
        top: -80px; right: -60px;
    }
    .ph-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        object-fit: cover; border: 3px solid rgba(255,255,255,.3);
        margin: 0 auto 12px; position: relative; z-index: 1;
    }
    .ph-avatar-pl {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(255,255,255,.15); border: 3px solid rgba(255,255,255,.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; font-weight: 700; color: #fff;
        margin: 0 auto 12px; position: relative; z-index: 1;
    }
    .ph-name  { font-size: 15px; font-weight: 700; color: #fff; position: relative; z-index: 1; }
    .ph-email { font-size: 12px; color: rgba(255,255,255,.55); margin-top: 3px; position: relative; z-index: 1; }
    .ph-badges { display: flex; gap: 6px; justify-content: center; margin-top: 10px; position: relative; z-index: 1; }
    .ph-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
    }
    .ph-badge-active  { background: var(--success-soft); color: var(--success); }
    .ph-badge-blocked { background: var(--danger-soft);  color: var(--danger); }
    .ph-badge-vendor  { background: var(--warning-soft); color: var(--warning); }
    .ph-badge-cust    { background: rgba(255,255,255,.15); color: rgba(255,255,255,.8); }

    /* ── Info tiles ── */
    .info-tiles { padding: 16px 20px; display: flex; flex-direction: column; gap: 0; }
    .info-tile {
        display: flex; justify-content: space-between;
        align-items: center; padding: 9px 0;
        border-bottom: 1px dashed var(--border); font-size: 12px;
    }
    .info-tile:last-child { border-bottom: none; }
    .tile-key   { color: var(--ink-muted); font-weight: 500; }
    .tile-val   { color: var(--ink); font-weight: 600; }

    /* ── Actions Footer ── */
    .form-actions {
        display: flex; align-items: center;
        justify-content: flex-end; gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        flex-wrap: wrap;
        border-radius: 0 0 var(--radius) var(--radius);
        margin-top: 20px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface); color: var(--ink-muted);
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: 9px 18px; font-size: 13px; font-weight: 500;
        cursor: pointer; text-decoration: none; transition: all .15s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-cancel:hover { background: var(--border); color: var(--ink); }
    .btn-save {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--accent); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 10px 24px; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: background .2s, transform .15s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-save:hover { background: var(--accent-hover); transform: translateY(-1px); }
    .btn-save svg { width: 14px; height: 14px; }

    /* ── Alert ── */
    .alert-error-box {
        background: var(--danger-soft); border: 1px solid #fca5a5;
        border-radius: var(--radius-sm); padding: 12px 16px;
        margin-bottom: 20px; font-size: 13px; color: var(--danger);
    }
    .alert-error-box ul { margin: 6px 0 0 16px; padding: 0; }
    .alert-error-box li { margin-bottom: 2px; font-size: 12px; }

    /* ── Changed indicator ── */
    .changed-dot {
        display: none;
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--warning);
        margin-left: 6px;
        vertical-align: middle;
    }
</style>

<div class="container-fluid px-1">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h2 class="page-title">Edit Customer</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">{{ $customer->name }}</li>
                </ol>
            </nav>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('customer.show', $customer->id) }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                View Profile
            </a>
            <a href="{{ route('customer.index') }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <form action="{{ route('customer.update', $customer->id) }}" method="POST"
          enctype="multipart/form-data" id="editForm">
        @csrf @method('PUT')

        <div class="form-layout">

            {{-- ══ LEFT ══ --}}
            <div>

                {{-- Errors --}}
                @if($errors->any())
                <div class="alert-error-box">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- ── Basic Info ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-header-title">Basic Information</div>
                            <div class="card-header-sub">Update customer's personal details</div>
                        </div>
                    </div>
                    <div class="form-card-body">

                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="name" id="field_name"
                                    class="f-input @error('name') is-error @enderror"
                                    placeholder="e.g. John Doe"
                                    value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <span class="f-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="f-group">
                                <label class="f-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" id="field_email"
                                    class="f-input @error('email') is-error @enderror"
                                    placeholder="e.g. john@email.com"
                                    value="{{ old('email', $customer->email) }}" required>
                                @error('email')
                                    <span class="f-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Phone <span class="req">*</span></label>
                                <input type="text" name="phone"
                                    class="f-input @error('phone') is-error @enderror"
                                    placeholder="+880 1XXXXXXXXX"
                                    value="{{ old('phone', $customer->phone) }}" required>
                                @error('phone')
                                    <span class="f-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="f-group">
                                <label class="f-label">Fax</label>
                                <input type="text" name="fax" class="f-input"
                                    placeholder="Fax number (optional)"
                                    value="{{ old('fax', $customer->fax) }}">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Address ── --}}
                <div class="form-card" style="margin-top:20px;">
                    <div class="form-card-header">
                        <div class="card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-header-title">Address</div>
                            <div class="card-header-sub">Update billing / delivery address</div>
                        </div>
                    </div>
                    <div class="form-card-body">

                        <div class="f-row full">
                            <div class="f-group">
                                <label class="f-label">Street Address <span class="req">*</span></label>
                                <input type="text" name="address"
                                    class="f-input @error('address') is-error @enderror"
                                    placeholder="House / Street / Area"
                                    value="{{ old('address', $customer->address) }}" required>
                                @error('address')
                                    <span class="f-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">City</label>
                                <input type="text" name="city" class="f-input"
                                    placeholder="City"
                                    value="{{ old('city', $customer->city) }}">
                            </div>
                            <div class="f-group">
                                <label class="f-label">State / Division</label>
                                <input type="text" name="state" class="f-input"
                                    placeholder="State / Division"
                                    value="{{ old('state', $customer->state) }}">
                            </div>
                        </div>

                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Country</label>
                                <select name="country" class="f-select">
                                    <option value="">Select Country</option>
                                    @foreach(['Bangladesh','India','USA','UK','Canada','Australia','Saudi Arabia','UAE','Pakistan','Other'] as $c)
                                    <option value="{{ $c }}" {{ old('country', $customer->country) == $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Postal Code</label>
                                <input type="text" name="postal_code" class="f-input"
                                    placeholder="Postal / ZIP"
                                    value="{{ old('postal_code', $customer->postal_code) }}">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── Security ── --}}
                <div class="form-card" style="margin-top:20px;">
                    <div class="form-card-header">
                        <div class="card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-header-title">Change Password</div>
                            <div class="card-header-sub">Leave blank to keep the current password</div>
                        </div>
                    </div>
                    <div class="form-card-body">

                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">New Password</label>
                                <div class="pw-wrap">
                                    <input type="password" name="password" id="pw1"
                                        class="f-input"
                                        placeholder="New password (min 6 chars)">
                                    <button type="button" class="pw-eye" onclick="togglePw('pw1',this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Confirm New Password</label>
                                <div class="pw-wrap">
                                    <input type="password" name="password_confirmation" id="pw2"
                                        class="f-input"
                                        placeholder="Re-enter new password">
                                    <button type="button" class="pw-eye" onclick="togglePw('pw2',this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <p class="f-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:12px;height:12px;display:inline;vertical-align:middle;color:var(--accent);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                            </svg>
                            Leave both fields empty to keep the current password unchanged.
                        </p>

                    </div>
                </div>

                {{-- ── Actions ── --}}
                <div class="form-actions">
                    <a href="{{ route('customer.index') }}" class="btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn-save">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>{{-- /left --}}

            {{-- ══ RIGHT Sidebar ══ --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Profile Header --}}
                <div class="profile-header-card">
                    @if($customer->image && file_exists(public_path($customer->image)))
                        <img src="{{ asset($customer->image) }}" class="ph-avatar" alt="{{ $customer->name }}" id="sidebarAvatar">
                    @else
                        <div class="ph-avatar-pl" id="sidebarAvatarPl">{{ strtoupper(substr($customer->name,0,1)) }}</div>
                    @endif
                    <div class="ph-name">{{ $customer->name }}</div>
                    <div class="ph-email">{{ $customer->email }}</div>
                    <div class="ph-badges">
                        <span class="ph-badge {{ $customer->isBlocked() ? 'ph-badge-blocked' : 'ph-badge-active' }}">
                            <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                            {{ $customer->isBlocked() ? 'Blocked' : 'Active' }}
                        </span>
                        @if($customer->isVendor())
                            <span class="ph-badge ph-badge-vendor">⭐ Vendor</span>
                        @else
                            <span class="ph-badge ph-badge-cust">Customer</span>
                        @endif
                    </div>
                </div>

                {{-- Account Info ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon" style="background:#f0fdf4;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="color:#059669;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-header-title">Account Info</div>
                            <div class="card-header-sub">Read-only details</div>
                        </div>
                    </div>
                    <div class="info-tiles">
                        <div class="info-tile">
                            <span class="tile-key">Customer ID</span>
                            <span class="tile-val" style="font-family:'JetBrains Mono',monospace;font-size:12px;">#{{ $customer->id }}</span>
                        </div>
                        <div class="info-tile">
                            <span class="tile-key">Member Since</span>
                            <span class="tile-val">{{ $customer->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="info-tile">
                            <span class="tile-key">Days Active</span>
                            <span class="tile-val">{{ $customer->created_at->diffInDays(now()) }} days</span>
                        </div>
                        <div class="info-tile">
                            <span class="tile-key">Last Updated</span>
                            <span class="tile-val">{{ $customer->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Photo Update ── --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-header-title">Update Photo</div>
                            <div class="card-header-sub">JPG, PNG, WEBP · Max 2 MB</div>
                        </div>
                    </div>
                    <div class="form-card-body" style="padding:16px;">

                        {{-- Current photo strip --}}
                        <div class="current-photo-strip">
                            @if($customer->image && file_exists(public_path($customer->image)))
                                <img src="{{ asset($customer->image) }}" class="current-avatar" alt="Current">
                            @else
                                <div class="current-avatar-ph">{{ strtoupper(substr($customer->name,0,1)) }}</div>
                            @endif
                            <div class="current-photo-info">
                                <div class="current-photo-name">Current photo</div>
                                <div class="current-photo-sub">Upload below to replace it</div>
                            </div>
                        </div>

                        {{-- Upload zone --}}
                        <label class="photo-upload-area" id="photoZone">
                            <img src="" class="photo-preview-img" id="photoPreview" alt="Preview">
                            <div id="photoPlaceholder">
                                <div class="upload-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </div>
                                <div class="upload-title">Click to replace</div>
                                <div class="upload-sub">or drag &amp; drop here</div>
                            </div>
                            <div class="upload-badge" id="photoBadge" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:11px;height:11px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                New photo ready
                            </div>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                onchange="previewPhoto(this)">
                        </label>

                    </div>
                </div>

            </div>{{-- /sidebar --}}

        </div>{{-- /form-layout --}}
    </form>

</div>

<script>
    // ── Photo Preview ──
    function previewPhoto(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const img   = document.getElementById('photoPreview');
            const ph    = document.getElementById('photoPlaceholder');
            const badge = document.getElementById('photoBadge');
            img.src = e.target.result;
            img.style.display = 'block';
            ph.style.display  = 'none';
            badge.style.display = 'inline-flex';

            // Update sidebar avatar live
            const sAvatar   = document.getElementById('sidebarAvatar');
            const sAvatarPl = document.getElementById('sidebarAvatarPl');
            if (sAvatar)   { sAvatar.src = e.target.result; sAvatar.style.display = 'block'; }
            if (sAvatarPl) { sAvatarPl.style.display = 'none'; }
        };
        reader.readAsDataURL(input.files[0]);
    }

    // ── Password Toggle ──
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.style.color = isText ? 'var(--ink-muted)' : 'var(--accent)';
    }

    // ── Unsaved changes warning ──
    let formChanged = false;
    document.getElementById('editForm').addEventListener('change', () => { formChanged = true; });
    document.getElementById('editForm').addEventListener('submit', () => { formChanged = false; });
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>

@endsection
