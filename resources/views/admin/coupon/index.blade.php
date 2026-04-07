@extends('admin.master')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.cp-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f4f6fb;
    min-height: 100vh;
    padding: 32px 36px 48px;
    color: #1a2340;
}

/* ── Header ─────────────────────────────────────────── */
.cp-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
}
.cp-header-left h1 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0d2a6b;
    letter-spacing: -0.4px;
    line-height: 1.2;
}
.cp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    color: #8494b3;
    margin-top: 5px;
}
.cp-breadcrumb a { color: #8494b3; text-decoration: none; transition: color .2s; }
.cp-breadcrumb a:hover { color: #0d2a6b; }
.cp-breadcrumb-sep { font-size: 0.7rem; }

.cp-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: linear-gradient(135deg, #0d2a6b 0%, #1a47b8 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(13,42,107,0.28);
    transition: transform .18s, box-shadow .18s;
    letter-spacing: .1px;
}
.cp-add-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13,42,107,0.36);
    color: #fff;
    text-decoration: none;
}
.cp-add-btn svg { flex-shrink: 0; }

/* ── Stats Row ──────────────────────────────────────── */
.cp-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    margin-bottom: 26px;
}
.cp-stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 18px 20px;
    border: 1px solid #e8edf8;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    transition: box-shadow .2s, transform .2s;
}
.cp-stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-1px); }
.cp-stat-icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
}
.cp-stat-icon.blue  { background: #dbeafe; color: #1d4ed8; }
.cp-stat-icon.green { background: #d1fae5; color: #059669; }
.cp-stat-icon.amber { background: #fef3c7; color: #d97706; }
.cp-stat-icon.red   { background: #fee2e2; color: #dc2626; }
.cp-stat-val  { font-size: 1.5rem; font-weight: 800; color: #0d2a6b; line-height: 1; }
.cp-stat-lbl  { font-size: 0.75rem; font-weight: 600; color: #8494b3; margin-top: 3px; letter-spacing: .3px; text-transform: uppercase; }

/* ── Main Card ──────────────────────────────────────── */
.cp-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8edf8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* ── Alert ──────────────────────────────────────────── */
.cp-alert-success {
    display: flex; align-items: center; gap: 10px;
    background: #d1fae5; border-left: 4px solid #10b981;
    color: #065f46; padding: 12px 18px;
    font-size: 0.875rem; font-weight: 600;
    border-radius: 8px; margin: 20px 20px 0;
}

/* ── Controls ───────────────────────────────────────── */
.cp-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 22px;
    border-bottom: 1px solid #f0f3fa;
}
.cp-show-wrap {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.83rem; color: #5a6a85; font-weight: 600;
}
.cp-select {
    border: 1.5px solid #dde3f0;
    border-radius: 8px;
    padding: 5px 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.83rem;
    color: #1a2340;
    outline: none;
    background: #f8faff;
    cursor: pointer;
    transition: border-color .2s;
}
.cp-select:focus { border-color: #1a47b8; }

.cp-search-wrap {
    display: flex; align-items: center; gap: 8px;
}
.cp-search-box {
    position: relative;
}
.cp-search-box svg {
    position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
    color: #8494b3; pointer-events: none;
}
.cp-search-input {
    border: 1.5px solid #dde3f0;
    border-radius: 8px;
    padding: 7px 12px 7px 34px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.83rem;
    color: #1a2340;
    outline: none;
    width: 200px;
    background: #f8faff;
    transition: border-color .2s, width .3s;
}
.cp-search-input:focus { border-color: #1a47b8; width: 240px; }

/* ── Table ──────────────────────────────────────────── */
.cp-table-wrap { overflow-x: auto; }
table.cp-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.86rem;
}
.cp-table thead tr {
    background: #f8faff;
    border-bottom: 2px solid #edf0fb;
}
.cp-table th {
    padding: 12px 18px;
    text-align: left;
    font-weight: 700;
    font-size: 0.75rem;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: #5a6a85;
    white-space: nowrap;
}
.cp-table tbody tr {
    border-bottom: 1px solid #f3f5fb;
    transition: background .15s;
}
.cp-table tbody tr:hover { background: #f8faff; }
.cp-table td {
    padding: 14px 18px;
    color: #2c3a5a;
    font-weight: 500;
    vertical-align: middle;
}

/* Code chip */
.cp-code-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: #eef2ff; color: #3730a3;
    border: 1px solid #c7d2fe;
    border-radius: 7px;
    padding: 4px 10px;
    font-size: 0.82rem; font-weight: 700;
    letter-spacing: .5px;
    font-family: 'Courier New', monospace;
}

/* Type badge */
.cp-type-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: .2px;
}
.cp-type-pct  { background: #fef3c7; color: #92400e; }
.cp-type-amt  { background: #dbeafe; color: #1e40af; }

/* Amount display */
.cp-amount { font-weight: 700; color: #0d2a6b; font-size: 0.9rem; }

/* Used count */
.cp-used {
    display: inline-flex; align-items: center; gap: 4px;
    font-weight: 600; color: #5a6a85; font-size: 0.83rem;
}

/* Status toggle */
.cp-status-wrap { position: relative; display: inline-block; }
.cp-status-pill {
    display: inline-flex; align-items: center;
    border-radius: 20px;
    overflow: visible;
    font-size: 0.78rem; font-weight: 700;
    cursor: pointer;
    user-select: none;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}
.cp-status-label {
    padding: 5px 12px;
    border-radius: 20px 0 0 20px;
    color: #fff;
    white-space: nowrap;
}
.cp-status-arrow {
    padding: 5px 9px;
    border-radius: 0 20px 20px 0;
    color: #fff;
    border-left: 1px solid rgba(255,255,255,.25);
    background: rgba(0,0,0,.15);
    font-size: 0.7rem;
    transition: background .15s;
}
.cp-status-arrow:hover { background: rgba(0,0,0,.28); }
.status-active   .cp-status-label { background: #10b981; }
.status-active   .cp-status-arrow { background: rgba(0,0,0,.15); }
.status-inactive .cp-status-label { background: #ef4444; }
.status-inactive .cp-status-arrow { background: rgba(0,0,0,.15); }

.cp-status-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 28px rgba(0,0,0,.14);
    z-index: 200;
    min-width: 150px;
    overflow: hidden;
    animation: dropIn .15s ease;
}
@keyframes dropIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
.cp-status-dropdown a {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 14px;
    font-size: 0.83rem; font-weight: 600;
    color: #2c3a5a;
    text-decoration: none;
    transition: background .15s;
}
.cp-status-dropdown a:hover { background: #f3f5fb; }
.cp-status-dropdown a .dot {
    width: 8px; height: 8px; border-radius: 50%;
}
.cp-status-dropdown a:first-child .dot { background: #10b981; }
.cp-status-dropdown a:last-child  .dot { background: #ef4444; }

/* Action buttons */
.cp-actions { display: flex; align-items: center; gap: 6px; }
.cp-btn-edit {
    display: inline-flex; align-items: center; gap: 5px;
    background: #eef2ff; color: #3730a3;
    border: 1.5px solid #c7d2fe;
    border-radius: 8px; padding: 6px 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.78rem; font-weight: 700;
    text-decoration: none; cursor: pointer;
    transition: background .18s, transform .15s;
}
.cp-btn-edit:hover { background: #e0e7ff; transform: translateY(-1px); text-decoration: none; color: #3730a3; }
.cp-btn-del {
    display: inline-flex; align-items: center; justify-content: center;
    background: #fff0f0; color: #dc2626;
    border: 1.5px solid #fecaca;
    border-radius: 8px;
    width: 32px; height: 32px;
    font-size: 0.88rem; cursor: pointer;
    transition: background .18s, transform .15s;
}
.cp-btn-del:hover { background: #fee2e2; transform: translateY(-1px); }

/* Loading spinner overlay */
.cp-loading-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.cp-loading-overlay.show { display: flex; }
.cp-spinner {
    width: 40px; height: 40px;
    border: 4px solid #dde3f0;
    border-top-color: #1a47b8;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Toast notification */
.cp-toast {
    position: fixed;
    bottom: 28px; right: 28px;
    background: #0d2a6b;
    color: #fff;
    padding: 12px 22px;
    border-radius: 10px;
    font-size: 0.85rem; font-weight: 600;
    box-shadow: 0 8px 28px rgba(0,0,0,.2);
    z-index: 9999;
    opacity: 0;
    transform: translateY(12px);
    transition: opacity .3s, transform .3s;
    pointer-events: none;
}
.cp-toast.success { background: #059669; }
.cp-toast.error   { background: #dc2626; }
.cp-toast.show    { opacity: 1; transform: translateY(0); }

/* Empty state */
.cp-empty {
    text-align: center; padding: 60px 20px;
    color: #8494b3;
}
.cp-empty-icon { font-size: 3rem; margin-bottom: 14px; opacity: .45; }
.cp-empty p { font-size: 0.9rem; font-weight: 600; }

/* ── Footer ─────────────────────────────────────────── */
.cp-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding: 14px 22px;
    border-top: 1px solid #f0f3fa;
    font-size: 0.82rem;
    color: #8494b3;
    font-weight: 500;
}
.cp-pagination { display: flex; gap: 4px; }
.cp-page-btn {
    border: 1.5px solid #dde3f0;
    background: #fff;
    color: #5a6a85;
    padding: 5px 12px;
    border-radius: 7px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.8rem; font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}
.cp-page-btn:hover { border-color: #1a47b8; color: #1a47b8; }
.cp-page-btn.active {
    background: linear-gradient(135deg, #0d2a6b, #1a47b8);
    border-color: transparent; color: #fff;
    box-shadow: 0 2px 8px rgba(13,42,107,.3);
}
</style>

{{-- Loading Overlay --}}
<div class="cp-loading-overlay" id="loadingOverlay">
    <div class="cp-spinner"></div>
</div>

{{-- Toast --}}
<div class="cp-toast" id="cpToast"></div>

<div class="cp-root">

    {{-- ── Header ── --}}
    <div class="cp-header">
        <div class="cp-header-left">
            <h1>
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                     style="display:inline;vertical-align:-3px;margin-right:6px;color:#1a47b8">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                Coupons
            </h1>
            <nav class="cp-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="cp-breadcrumb-sep">›</span>
                <span>Coupons</span>
            </nav>
        </div>
        <a href="{{ route('coupons.create') }}" class="cp-add-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add New Coupon
        </a>
    </div>

    {{-- ── Stats ── --}}
    @php
        $total     = $coupons->count();
        $active    = $coupons->where('status', 'activated')->count();
        $inactive  = $coupons->where('status', 'deactivated')->count();
        $totalUsed = $coupons->sum('used');
    @endphp
    <div class="cp-stats">
        <div class="cp-stat-card">
            <div class="cp-stat-icon blue">🏷️</div>
            <div>
                <div class="cp-stat-val">{{ $total }}</div>
                <div class="cp-stat-lbl">Total Coupons</div>
            </div>
        </div>
        <div class="cp-stat-card">
            <div class="cp-stat-icon green">✅</div>
            <div>
                <div class="cp-stat-val" id="statActive">{{ $active }}</div>
                <div class="cp-stat-lbl">Active</div>
            </div>
        </div>
        <div class="cp-stat-card">
            <div class="cp-stat-icon red">❌</div>
            <div>
                <div class="cp-stat-val" id="statInactive">{{ $inactive }}</div>
                <div class="cp-stat-lbl">Inactive</div>
            </div>
        </div>
        <div class="cp-stat-card">
            <div class="cp-stat-icon amber">📊</div>
            <div>
                <div class="cp-stat-val">{{ $totalUsed }}</div>
                <div class="cp-stat-lbl">Total Used</div>
            </div>
        </div>
    </div>

    {{-- ── Main Card ── --}}
    <div class="cp-card">

        {{-- Alert --}}
        @if(session('success'))
        <div class="cp-alert-success">
            <span>✓</span> {{ session('success') }}
        </div>
        @endif

        {{-- Controls --}}
        <div class="cp-controls">
            <div class="cp-show-wrap">
                Show
                <select id="perPageSelect" class="cp-select">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                entries
            </div>
            <div class="cp-search-wrap">
                <div class="cp-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="searchInput" class="cp-search-input" placeholder="Search coupons…">
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="cp-table-wrap">
            <table class="cp-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Used</th>
                        <th>Validity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="couponBody">
                    @forelse($coupons as $i => $coupon)
                    <tr data-search="{{ strtolower($coupon->code . ' ' . ($coupon->type === 'discount_by_percentage' ? 'percentage' : 'amount')) }}">
                        <td style="color:#aab4cc;font-size:0.78rem;font-weight:700;">{{ $i + 1 }}</td>
                        <td>
                            <span class="cp-code-chip">{{ $coupon->code }}</span>
                        </td>
                        <td>
                            @if($coupon->type === 'discount_by_percentage')
                                <span class="cp-type-badge cp-type-pct">% Percentage</span>
                            @else
                                <span class="cp-type-badge cp-type-amt">$ Amount</span>
                            @endif
                        </td>
                        <td>
                            <span class="cp-amount">
                                @if($coupon->type === 'discount_by_percentage')
                                    {{ number_format($coupon->percentage, 2) }}%
                                @else
                                    ${{ number_format($coupon->amount, 2) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="cp-used">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                {{ $coupon->used ?? 0 }}
                            </span>
                        </td>
                        <td style="font-size:0.78rem;color:#8494b3;font-weight:600;">
                            @if($coupon->start_date && $coupon->end_date)
                                {{ \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') }}<br>
                                <span style="color:#aab4cc;">→</span>
                                {{ \Carbon\Carbon::parse($coupon->end_date)->format('d M Y') }}
                            @else
                                <span style="color:#c0c9db;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="cp-status-wrap" id="statusWrap_{{ $coupon->id }}">
                                <div class="cp-status-pill {{ $coupon->status === 'activated' ? 'status-active' : 'status-inactive' }}"
                                     onclick="toggleStatusDropdown(this)">
                                    <span class="cp-status-label">
                                        {{ $coupon->status === 'activated' ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="cp-status-arrow">▾</span>
                                </div>
                                <div class="cp-status-dropdown">
                                    <a href="#" onclick="changeStatus(event, {{ $coupon->id }}, 'activated')">
                                        <span class="dot"></span> Activated
                                    </a>
                                    <a href="#" onclick="changeStatus(event, {{ $coupon->id }}, 'deactivated')">
                                        <span class="dot"></span> Deactivated
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="cp-actions">
                                <a href="{{ route('coupons.edit', $coupon->id) }}" class="cp-btn-edit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this coupon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cp-btn-del" title="Delete">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="cp-empty">
                                <div class="cp-empty-icon">🏷️</div>
                                <p>No coupons found. Create your first coupon!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="cp-footer">
            <span id="showingInfo">Showing {{ $coupons->count() }} entries</span>
            <div class="cp-pagination">
                <button class="cp-page-btn">← Prev</button>
                <button class="cp-page-btn active">1</button>
                <button class="cp-page-btn">Next →</button>
            </div>
        </div>
    </div>
</div>

<script>
// ── KEY FIX: Use Blade route() helper to generate the correct URL ──
// Replace the placeholder __ID__ with the actual coupon ID in JS
const STATUS_ROUTE_TEMPLATE = "{{ route('coupons.status', ['id' => '__ID__']) }}";
const CSRF_TOKEN = "{{ csrf_token() }}";

// ── Search ───────────────────────────────────────────────
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('#couponBody tr[data-search]').forEach(row => {
        const match = row.dataset.search.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('showingInfo').textContent = 'Showing ' + visible + ' entries';
});

// ── Toast ────────────────────────────────────────────────
function showToast(message, type = 'success') {
    const toast = document.getElementById('cpToast');
    toast.textContent = message;
    toast.className = 'cp-toast ' + type + ' show';
    setTimeout(() => { toast.className = 'cp-toast'; }, 3000);
}

// ── Loading ──────────────────────────────────────────────
function setLoading(show) {
    document.getElementById('loadingOverlay').classList.toggle('show', show);
}

// ── Status dropdown toggle ───────────────────────────────
function toggleStatusDropdown(pill) {
    const dropdown = pill.nextElementSibling;
    const isOpen   = dropdown.style.display === 'block';
    document.querySelectorAll('.cp-status-dropdown').forEach(d => d.style.display = 'none');
    dropdown.style.display = isOpen ? 'none' : 'block';
}
document.addEventListener('click', function (e) {
    if (!e.target.closest('.cp-status-wrap')) {
        document.querySelectorAll('.cp-status-dropdown').forEach(d => d.style.display = 'none');
    }
});

// ── Change Status via AJAX ───────────────────────────────
function changeStatus(e, id, status) {
    e.preventDefault();

    document.querySelectorAll('.cp-status-dropdown').forEach(d => d.style.display = 'none');
    setLoading(true);

    // Build the correct URL using the Blade-generated template
    const url = STATUS_ROUTE_TEMPLATE.replace('__ID__', id);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => {
        if (!response.ok) throw new Error('Server error: ' + response.status);
        return response.json();
    })
    .then(data => {
        setLoading(false);

        if (data.success) {
            const wrap  = document.getElementById('statusWrap_' + id);
            const pill  = wrap.querySelector('.cp-status-pill');
            const label = wrap.querySelector('.cp-status-label');

            if (status === 'activated') {
                pill.classList.replace('status-inactive', 'status-active');
                label.textContent = 'Active';
            } else {
                pill.classList.replace('status-active', 'status-inactive');
                label.textContent = 'Inactive';
            }

            recalcStats();
            showToast(
                status === 'activated'
                    ? '✓ Coupon activated successfully'
                    : '✓ Coupon deactivated successfully',
                'success'
            );
        } else {
            showToast('✗ Failed to update status. Please try again.', 'error');
        }
    })
    .catch(err => {
        setLoading(false);
        console.error('Status update error:', err);
        showToast('✗ Something went wrong. Please try again.', 'error');
    });
}

// ── Recalculate stat counters after status change ────────
function recalcStats() {
    let active = 0, inactive = 0;
    document.querySelectorAll('#couponBody tr[data-search]').forEach(row => {
        const pill = row.querySelector('.cp-status-pill');
        if (pill) {
            if (pill.classList.contains('status-active'))   active++;
            if (pill.classList.contains('status-inactive')) inactive++;
        }
    });
    const elActive   = document.getElementById('statActive');
    const elInactive = document.getElementById('statInactive');
    if (elActive)   elActive.textContent   = active;
    if (elInactive) elInactive.textContent = inactive;
}
</script>

@endsection
