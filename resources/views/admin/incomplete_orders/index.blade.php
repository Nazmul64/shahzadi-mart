{{-- resources/views/admin/incomplete_orders/index.blade.php --}}
@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }

.io-wrapper {
    background: #f4f6fb;
    min-height: 100vh;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* ── Topbar ── */
.io-topbar {
    background: #fff;
    border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.io-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }
.io-topbar-sub { font-size: 12px; color: #aaa; margin-top: 3px; }

/* ── Tabs ── */
.io-tabs {
    display: flex; gap: 6px; flex-wrap: wrap;
    padding: 14px 24px; background: #fff; border-bottom: 1px solid #e8eaf0;
}
.io-tab {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
    background: #f4f6fb; color: #555; border: 1px solid #e5e7eb;
    text-decoration: none; transition: all 0.2s;
}
.io-tab:hover { background: #e9ecef; color: #333; text-decoration: none; }
.io-tab.active { background: #2d3748; color: #fff; border-color: #2d3748; }
.io-tab-badge {
    background: rgba(0,0,0,0.12); border-radius: 20px;
    padding: 1px 7px; font-size: 11px;
}
.io-tab.active .io-tab-badge { background: rgba(255,255,255,0.25); }
.io-tab.tab-incomplete.active { background: #e53e3e; border-color: #e53e3e; }
.io-tab.tab-recovered.active  { background: #38a169; border-color: #38a169; }
.io-tab.tab-contacted.active  { background: #3182ce; border-color: #3182ce; }

/* ── Action Bar ── */
.io-actionbar {
    background: #fff;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    border-bottom: 1px solid #e8eaf0;
}
.io-btn {
    border: none; border-radius: 22px; padding: 8px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
    transition: opacity .2s, transform .1s;
}
.io-btn:hover { opacity: .88; transform: translateY(-1px); text-decoration: none; }
.io-btn:active { transform: translateY(0); }
.btn-bulk-status   { background: #9b59b6; color: #fff; }
.btn-bulk-delete   { background: #e74c3c; color: #fff; }
.btn-steadfast     { background: #f39c12; color: #fff; }
.btn-pathao        { background: #00b894; color: #fff; }

/* ── Search ── */
.io-search-wrap { margin-left: auto; display: flex; gap: 8px; align-items: center; }
.io-search-input {
    border: 1px solid #dde2ec; border-radius: 22px; padding: 7px 16px;
    font-size: 13px; width: 220px; outline: none; transition: border-color .2s;
}
.io-search-input:focus { border-color: #e53e3e; }
.btn-search {
    background: #e53e3e; color: #fff; border: none; border-radius: 22px;
    padding: 8px 20px; font-size: 13px; font-weight: 600; cursor: pointer;
}

/* ── Stats Cards ── */
.io-stats {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 16px; padding: 20px 24px 0;
}
.io-stat-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    padding: 18px 20px;
    display: flex; align-items: center; gap: 16px;
}
.io-stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
}
.io-stat-icon.red    { background: #fff5f5; }
.io-stat-icon.green  { background: #f0fff4; }
.io-stat-icon.yellow { background: #fffbeb; }
.io-stat-icon.blue   { background: #ebf8ff; }
.io-stat-label { font-size: 12px; color: #aaa; margin-bottom: 4px; }
.io-stat-value { font-size: 24px; font-weight: 700; color: #2d3748; }

/* ── Table ── */
.io-content { padding: 20px 24px; }
.io-table-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden;
}
.io-table { width: 100%; border-collapse: collapse; }
.io-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.io-table th {
    padding: 12px 14px; font-size: 12px; font-weight: 700; color: #7a849e;
    text-transform: uppercase; letter-spacing: .4px; white-space: nowrap;
}
.io-table tbody tr { border-bottom: 1px solid #f0f2f8; transition: background .15s; }
.io-table tbody tr:hover { background: #fafbff; }
.io-table tbody tr:last-child { border-bottom: none; }
.io-table td { padding: 12px 14px; font-size: 13px; color: #3a4259; vertical-align: middle; }

.io-checkbox { width: 16px; height: 16px; accent-color: #e53e3e; cursor: pointer; }

/* ── Status Badges ── */
.io-badge {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600; white-space: nowrap;
}
.badge-incomplete { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
.badge-recovered  { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
.badge-contacted  { background: #ebf8ff; color: #2b6cb0; border: 1px solid #90cdf4; }

/* ── Action Buttons ── */
.io-actions { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.io-icon-btn {
    width: 30px; height: 30px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; border: 1px solid #e8eaf0;
    background: #fff; color: #555; text-decoration: none; transition: all .2s;
}
.io-icon-btn:hover { background: #f0f2f8; color: #333; }
.io-icon-btn.view    { color: #3498db; border-color: #bee3f8; }
.io-icon-btn.call    { color: #38a169; border-color: #9ae6b4; }
.io-icon-btn.del     { color: #e74c3c; border-color: #fecaca; }
.io-icon-btn.contact { color: #3182ce; border-color: #90cdf4; }
.io-icon-btn.recover { color: #38a169; border-color: #9ae6b4; }
.io-icon-btn.sf-btn       { color: #f39c12; border-color: #feebc8; }
.io-icon-btn.sf-btn.sent  { color: #fff; background: #f39c12; border-color: #f39c12; }
.io-icon-btn.pa-btn       { color: #00b894; border-color: #b2dfdb; }
.io-icon-btn.pa-btn.sent  { color: #fff; background: #00b894; border-color: #00b894; }

/* ── Cart Snapshot ── */
.io-cart-items { font-size: 11px; color: #888; }
.io-cart-item  { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px; }

/* ── Cust Info ── */
.io-cust-name { font-weight: 600; font-size: 13px; color: #2d3748; }
.io-cust-addr { font-size: 11px; color: #888; margin-top: 2px; }

/* ── Amount ── */
.io-amount { font-weight: 700; color: #2d3748; }

/* ── Date ── */
.io-date { font-size: 13px; color: #3a4259; }
.io-time { font-size: 11px; color: #aaa; }

/* ── Courier badges ── */
.sf-badge {
    display: inline-block; padding: 2px 8px; border-radius: 20px;
    font-size: 10px; font-weight: 600; white-space: nowrap;
}
.sf-badge.sent        { background: #fff8e6; color: #b7791f; border: 1px solid #f6e05e; }
.sf-badge.not-sent    { background: #f4f6fb; color: #aaa;    border: 1px solid #e5e7eb; }
.sf-badge.pathao-sent { background: #e8f5e9; color: #276749; border: 1px solid #9ae6b4; }

/* ── Pagination / Empty ── */
.io-pagination { padding: 16px 20px; border-top: 1px solid #f0f2f8; }
.io-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.io-empty i { font-size: 48px; display: block; margin-bottom: 12px; }

/* ── Tip Banner ── */
.io-tip-banner {
    background: linear-gradient(135deg, #fff5f5, #fff);
    border: 1px solid #fed7d7;
    border-left: 4px solid #e53e3e;
    border-radius: 8px;
    padding: 12px 18px;
    font-size: 13px;
    color: #742a2a;
    margin: 16px 24px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── Bulk Status Modal ── */
.bulk-modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 9999;
}
.bulk-modal-overlay.show {
    display: flex; align-items: center; justify-content: center;
}
.bulk-modal {
    background: #fff; border-radius: 12px; padding: 28px 32px;
    width: 340px; box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}
.bulk-modal h4 { margin: 0 0 18px; font-size: 16px; font-weight: 700; color: #2d3748; }
.bulk-modal select {
    width: 100%; padding: 9px 12px; border-radius: 8px;
    border: 1px solid #dde2ec; font-size: 14px; margin-bottom: 18px; outline: none;
}
.bulk-modal select:focus { border-color: #9b59b6; }
.bulk-modal-btns { display: flex; gap: 10px; justify-content: flex-end; }
.bm-cancel {
    background: #f4f6fb; color: #555; border: 1px solid #e5e7eb;
    border-radius: 8px; padding: 8px 20px; font-size: 13px; cursor: pointer; font-weight: 600;
}
.bm-apply {
    background: #9b59b6; color: #fff; border: none;
    border-radius: 8px; padding: 8px 20px; font-size: 13px; cursor: pointer; font-weight: 600;
}

/* ── Pathao Modal ── */
.pm-label { font-size: 13px; font-weight: 600; color: #3a4259; display: block; margin-bottom: 6px; }
.pm-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px;
    padding: 9px 12px; font-size: 13px; outline: none; color: #3a4259;
}
.pm-select:focus { border-color: #00b894; }
.pm-info-box { border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; display: none; }
.pm-info-box.success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
.pm-info-box.error   { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; }
</style>

<div class="io-wrapper">

    {{-- ══ Topbar ══ --}}
    <div class="io-topbar">
        <div>
            <h2>Incomplete Orders</h2>
            <div class="io-topbar-sub">
                যারা checkout শুরু করেছেন কিন্তু অর্ডার complete করেননি
            </div>
        </div>
        <a href="{{ route('admin.order.allorder') }}"
           style="background:#6c757d;color:#fff;border:none;border-radius:22px;
                  padding:9px 20px;font-size:13px;font-weight:600;
                  display:inline-flex;align-items:center;gap:6px;text-decoration:none;">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    {{-- ══ Tip Banner ══ --}}
    @if(($statusCounts['incomplete'] ?? 0) > 0)
    <div class="io-tip-banner">
        <i class="bi bi-exclamation-circle-fill" style="color:#e53e3e;font-size:18px;flex-shrink:0;"></i>
        <span>
            <strong>{{ $statusCounts['incomplete'] }}টি incomplete অর্ডার</strong> আছে।
            এই কাস্টমারদের call করে অর্ডার complete করতে সাহায্য করুন।
        </span>
    </div>
    @endif

    {{-- ══ Stats ══ --}}
    <div class="io-stats">
        <div class="io-stat-card">
            <div class="io-stat-icon red">🛒</div>
            <div>
                <div class="io-stat-label">মোট Incomplete</div>
                <div class="io-stat-value" style="color:#e53e3e;">{{ $statusCounts['incomplete'] }}</div>
            </div>
        </div>
        <div class="io-stat-card">
            <div class="io-stat-icon green">✅</div>
            <div>
                <div class="io-stat-label">Recovered</div>
                <div class="io-stat-value" style="color:#38a169;">{{ $statusCounts['recovered'] }}</div>
            </div>
        </div>
        <div class="io-stat-card">
            <div class="io-stat-icon blue">📞</div>
            <div>
                <div class="io-stat-label">Contacted</div>
                <div class="io-stat-value" style="color:#3182ce;">{{ $statusCounts['contacted'] ?? 0 }}</div>
            </div>
        </div>
        <div class="io-stat-card">
            <div class="io-stat-icon yellow">📊</div>
            <div>
                <div class="io-stat-label">মোট এন্ট্রি</div>
                <div class="io-stat-value">{{ $statusCounts['all'] }}</div>
            </div>
        </div>
    </div>

    {{-- ══ Tabs ══ --}}
    <div class="io-tabs">
        <a href="{{ route('admin.incomplete-orders.index', ['status' => 'all']) }}"
           class="io-tab {{ $status === 'all' ? 'active' : '' }}">
            All <span class="io-tab-badge">{{ $statusCounts['all'] }}</span>
        </a>
        <a href="{{ route('admin.incomplete-orders.index', ['status' => 'incomplete']) }}"
           class="io-tab tab-incomplete {{ $status === 'incomplete' ? 'active' : '' }}">
            🔴 Incomplete <span class="io-tab-badge">{{ $statusCounts['incomplete'] }}</span>
        </a>
        <a href="{{ route('admin.incomplete-orders.index', ['status' => 'contacted']) }}"
           class="io-tab tab-contacted {{ $status === 'contacted' ? 'active' : '' }}">
            📞 Contacted <span class="io-tab-badge">{{ $statusCounts['contacted'] ?? 0 }}</span>
        </a>
        <a href="{{ route('admin.incomplete-orders.index', ['status' => 'recovered']) }}"
           class="io-tab tab-recovered {{ $status === 'recovered' ? 'active' : '' }}">
            ✅ Recovered <span class="io-tab-badge">{{ $statusCounts['recovered'] }}</span>
        </a>
    </div>

    {{-- ══ Action Bar ══ --}}
    <div class="io-actionbar">

        {{-- Bulk Status Change --}}
        <button type="button" class="io-btn btn-bulk-status" onclick="openBulkStatusModal()">
            <i class="bi bi-arrow-repeat"></i> Change Status
        </button>

        {{-- Bulk Delete --}}
        <form method="POST"
              action="{{ route('admin.incomplete-orders.bulk-delete') }}"
              id="bulk-delete-form"
              onsubmit="return confirmBulkDelete()">
            @csrf
            @method('DELETE')
            <div id="bulk-ids"></div>
            <button type="submit" class="io-btn btn-bulk-delete">
                <i class="bi bi-trash3"></i> Delete Selected
            </button>
        </form>

        {{-- Bulk Steadfast Send --}}
        <form method="POST"
              action="{{ route('admin.incomplete-orders.steadfast.bulk-send') }}"
              id="bulk-steadfast-form"
              onsubmit="return confirmSteadfastBulk()">
            @csrf
            <div id="bulk-steadfast-ids"></div>
            <button type="submit" class="io-btn btn-steadfast">
                <i class="bi bi-truck"></i> Steadfast Send
            </button>
        </form>

        {{-- Bulk Pathao Send --}}
        <button type="button" class="io-btn btn-pathao" onclick="handleBulkPathaoClick()">
            <i class="bi bi-send"></i> Pathao
        </button>

        {{-- Search --}}
        <form method="GET"
              action="{{ route('admin.incomplete-orders.index') }}"
              class="io-search-wrap">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="নাম/ফোন খুঁজুন..." class="io-search-input">
            <button type="submit" class="btn-search">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.incomplete-orders.index', ['status' => $status]) }}"
                   class="io-btn btn-bulk-delete" style="padding:7px 14px;">
                    <i class="bi bi-x"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- ══ Alerts ══ --}}
    @if(session('success'))
        <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 24px;font-size:13px;color:#276749;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fff5f5;border-left:4px solid #e53e3e;padding:12px 24px;font-size:13px;color:#c53030;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div style="background:#fffbeb;border-left:4px solid #f6e05e;padding:12px 24px;font-size:13px;color:#b7791f;">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
        </div>
    @endif

    {{-- ══ Table ══ --}}
    <div class="io-content">
        <div class="io-table-card">
            @if($orders->isEmpty())
                <div class="io-empty">
                    <i class="bi bi-inbox"></i>
                    <p>কোনো incomplete অর্ডার পাওয়া যায়নি।</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="io-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">
                                    <input type="checkbox" class="io-checkbox" id="check-all"
                                           onchange="toggleAll(this)">
                                </th>
                                <th>SL</th>
                                <th>Action</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Area</th>
                                <th>Cart Items</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Courier</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                            @php
                                $cart       = $order->cart_snapshot ?? [];
                                $itemCount  = is_array($cart) ? count($cart) : 0;
                                $sfOrder    = $order->steadfastOrder;
                                $isSfSent   = $sfOrder && $sfOrder->is_sent;
                                $pathaoOrd  = $order->pathaoOrder;
                                $isPaSent   = $pathaoOrd && $pathaoOrd->is_sent;
                            @endphp
                            <tr>
                                {{-- Checkbox --}}
                                <td>
                                    <input type="checkbox" class="io-checkbox row-check"
                                           value="{{ $order->id }}"
                                           onchange="updateBulkIds()">
                                </td>

                                {{-- SL --}}
                                <td>{{ $orders->firstItem() + $index }}</td>

                                {{-- Actions --}}
                                <td>
                                    <div class="io-actions">

                                        {{-- View --}}
                                        <a href="{{ route('admin.incomplete-orders.show', $order->id) }}"
                                           class="io-icon-btn view" title="বিস্তারিত">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Call --}}
                                        @if($order->phone)
                                        <a href="tel:{{ $order->phone }}"
                                           class="io-icon-btn call" title="Call করুন">
                                            <i class="bi bi-telephone"></i>
                                        </a>
                                        @endif

                                        {{-- Mark Contacted --}}
                                        @if($order->status === 'incomplete')
                                        <form method="POST"
                                              action="{{ route('admin.incomplete-orders.contacted', $order->id) }}"
                                              style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="io-icon-btn contact"
                                                    title="Contacted mark করুন">
                                                <i class="bi bi-telephone-fill"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Mark Recovered --}}
                                        @if(in_array($order->status, ['incomplete', 'contacted']))
                                        <form method="POST"
                                              action="{{ route('admin.incomplete-orders.recovered', $order->id) }}"
                                              style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="io-icon-btn recover"
                                                    title="Recovered mark করুন">
                                                <i class="bi bi-check2-circle"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Steadfast Single Send --}}
                                        <form method="POST"
                                              action="{{ route('admin.incomplete-orders.steadfast.send', $order->id) }}"
                                              onsubmit="return confirm('Steadfast-এ পাঠাতে চান?')"
                                              style="margin:0;">
                                            @csrf
                                            <button type="submit"
                                                    class="io-icon-btn sf-btn {{ $isSfSent ? 'sent' : '' }}"
                                                    title="{{ $isSfSent ? 'SF Sent — পুনরায় পাঠান' : 'Steadfast-এ পাঠান' }}">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>

                                        {{-- Pathao Single Send --}}
                                        <button type="button"
                                                class="io-icon-btn pa-btn {{ $isPaSent ? 'sent' : '' }}"
                                                title="{{ $isPaSent ? 'Pathao Sent — Resend' : 'Pathao-তে পাঠান' }}"
                                                onclick="handleSinglePathaoClick({{ $order->id }})">
                                            <i class="bi bi-send"></i>
                                        </button>

                                        {{-- Delete --}}
                                        <form method="POST"
                                              action="{{ route('admin.incomplete-orders.destroy', $order->id) }}"
                                              onsubmit="return confirm('মুছে ফেলতে চান?')"
                                              style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="io-icon-btn del" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                                {{-- Customer --}}
                                <td>
                                    <div class="io-cust-name">{{ $order->customer_name ?: '—' }}</div>
                                    @if($order->address)
                                        <div class="io-cust-addr">{{ Str::limit($order->address, 35) }}</div>
                                    @endif
                                </td>

                                {{-- Phone --}}
                                <td>
                                    <a href="tel:{{ $order->phone }}"
                                       style="color:#38a169;font-weight:600;text-decoration:none;">
                                        <i class="bi bi-telephone-fill me-1"></i>{{ $order->phone }}
                                    </a>
                                </td>

                                {{-- Area --}}
                                <td>{{ $order->delivery_area ?: '—' }}</td>

                                {{-- Cart Items --}}
                                <td>
                                    <div class="io-cart-items">
                                        @if($itemCount > 0)
                                            @foreach(array_slice($cart, 0, 2) as $item)
                                                <div class="io-cart-item">
                                                    • {{ $item['name'] ?? 'Product' }}
                                                    (×{{ $item['quantity'] ?? 1 }})
                                                </div>
                                            @endforeach
                                            @if($itemCount > 2)
                                                <div style="color:#aaa;font-size:10px;">+{{ $itemCount - 2 }} আরো...</div>
                                            @endif
                                        @else
                                            <span style="color:#ccc;">—</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Total --}}
                                <td>
                                    @if($order->total > 0)
                                        <div class="io-amount">৳{{ number_format($order->total, 0) }}</div>
                                        @if($order->delivery_fee > 0)
                                            <div style="font-size:10px;color:#aaa;">
                                                + ৳{{ number_format($order->delivery_fee, 0) }} shipping
                                            </div>
                                        @endif
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>

                                {{-- Payment Method --}}
                                <td>
                                    @if($order->payment_method)
                                        <span style="text-transform:uppercase;font-size:11px;font-weight:700;
                                                     color:#6b7280;background:#f3f4f6;
                                                     padding:2px 8px;border-radius:20px;">
                                            {{ $order->payment_method }}
                                        </span>
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="io-badge badge-{{ $order->status }}">
                                        @if($order->status === 'incomplete') 🔴
                                        @elseif($order->status === 'recovered') ✅
                                        @else 📞
                                        @endif
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                {{-- Courier --}}
                                <td>
                                    @if($isSfSent)
                                        <span class="sf-badge sent">
                                            <i class="bi bi-check-circle-fill me-1"></i>SF
                                        </span>
                                        @if($sfOrder->tracking_code ?? $sfOrder->consignment_id)
                                        <div style="font-size:10px;color:#888;margin-top:3px;">
                                            {{ $sfOrder->tracking_code ?? $sfOrder->consignment_id }}
                                        </div>
                                        @endif
                                    @else
                                        <span class="sf-badge not-sent">SF: No</span>
                                    @endif

                                    @if($isPaSent)
                                        <span class="sf-badge pathao-sent" style="margin-top:3px;display:block;">
                                            <i class="bi bi-send-fill me-1"></i>Pathao
                                        </span>
                                    @else
                                        <span class="sf-badge not-sent" style="margin-top:3px;display:block;">
                                            Pathao: No
                                        </span>
                                    @endif
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="io-date">{{ $order->created_at->format('d-m-Y') }}</div>
                                    <div class="io-time">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="io-pagination">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>{{-- end io-wrapper --}}


{{-- ════════════════════════════════════════════════
     BULK STATUS MODAL
════════════════════════════════════════════════ --}}
<div class="bulk-modal-overlay" id="bulk-status-overlay">
    <div class="bulk-modal">
        <h4><i class="bi bi-arrow-repeat me-2"></i>Bulk Status Change</h4>
        <select id="bulk-status-select">
            <option value="">-- স্ট্যাটাস বেছে নিন --</option>
            <option value="incomplete">🔴 Incomplete</option>
            <option value="contacted">📞 Contacted</option>
            <option value="recovered">✅ Recovered</option>
        </select>
        <div class="bulk-modal-btns">
            <button class="bm-cancel" onclick="closeBulkStatusModal()">বাতিল</button>
            <button class="bm-apply" onclick="applyBulkStatus()">Apply করুন</button>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.incomplete-orders.bulk-status') }}" id="bulk-status-form">
    @csrf
    @method('PATCH')
    <div id="bulk-status-ids"></div>
    <input type="hidden" name="status" id="bulk-status-value">
</form>


{{-- ════════════════════════════════════════════════
     PATHAO MODAL
════════════════════════════════════════════════ --}}
<div id="pathao-overlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);
            z-index:10000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:28px 32px;
                width:440px;max-width:95vw;box-shadow:0 8px 32px rgba(0,0,0,0.2);
                max-height:90vh;overflow-y:auto;">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h5 style="margin:0;font-size:16px;font-weight:700;color:#2d3748;">
                <i class="bi bi-send me-2" style="color:#00b894;"></i>
                Pathao Courier
                <span id="pathao-modal-subtitle"
                      style="font-size:12px;font-weight:400;color:#aaa;margin-left:8px;"></span>
            </h5>
            <button type="button" onclick="closePathaoModal()"
                    style="background:none;border:none;font-size:22px;cursor:pointer;color:#aaa;line-height:1;">×</button>
        </div>

        <div id="pathao-modal-info"  class="pm-info-box success"></div>
        <div id="pathao-modal-error" class="pm-info-box error"></div>

        <div style="margin-bottom:14px;">
            <label class="pm-label">Store <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-store" class="pm-select"><option value="">Select Store...</option></select>
        </div>
        <div style="margin-bottom:14px;">
            <label class="pm-label">City <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-city" class="pm-select" onchange="loadZones(this.value)">
                <option value="">Select City...</option>
            </select>
        </div>
        <div style="margin-bottom:14px;">
            <label class="pm-label">Zone <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-zone" class="pm-select" onchange="loadAreas(this.value)">
                <option value="">Select Zone...</option>
            </select>
        </div>
        <div style="margin-bottom:22px;">
            <label class="pm-label">Area <span style="font-size:11px;color:#aaa;font-weight:400;">(Optional)</span></label>
            <select id="pathao-area" class="pm-select"><option value="">Select Area (Optional)...</option></select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button type="button" onclick="closePathaoModal()"
                    style="background:#f4f6fb;color:#555;border:1px solid #e5e7eb;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;">Close</button>
            <button type="button" id="pathao-submit-btn" onclick="submitPathaoOrder()"
                    style="background:#00b894;color:#fff;border:none;border-radius:8px;
                           padding:9px 22px;font-size:13px;cursor:pointer;font-weight:600;
                           display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-send"></i> Submit
            </button>
        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════ --}}
<script>
/* ── State ── */
var pathaoMode    = 'single';
var pathaoOrderId = null;
var pathaoBulkUrl = '{{ route("admin.incomplete-orders.pathao.bulk-send") }}';

/* ── Pathao Modal ── */
function openPathaoModal() {
    hidePathaoMessages();
    document.getElementById('pathao-store').innerHTML = '<option value="">Loading...</option>';
    document.getElementById('pathao-city').innerHTML  = '<option value="">Loading...</option>';
    document.getElementById('pathao-zone').innerHTML  = '<option value="">Select Zone...</option>';
    document.getElementById('pathao-area').innerHTML  = '<option value="">Select Area (Optional)...</option>';
    var btn = document.getElementById('pathao-submit-btn');
    btn.disabled  = false;
    btn.innerHTML = '<i class="bi bi-send"></i> Submit';
    var overlay = document.getElementById('pathao-overlay');
    overlay.style.display        = 'flex';
    overlay.style.alignItems     = 'center';
    overlay.style.justifyContent = 'center';
    loadStores();
    loadCities();
}

function closePathaoModal() {
    document.getElementById('pathao-overlay').style.display = 'none';
}

document.getElementById('pathao-overlay').addEventListener('click', function(e) {
    if (e.target === this) closePathaoModal();
});

function handleBulkPathaoClick() {
    var checked = document.querySelectorAll('.row-check:checked');
    if (!checked.length) { alert('প্রথমে অন্তত একটি অর্ডার সিলেক্ট করুন।'); return; }
    pathaoMode    = 'bulk';
    pathaoOrderId = null;
    document.getElementById('pathao-modal-subtitle').textContent = checked.length + ' টি অর্ডার';
    openPathaoModal();
}

function handleSinglePathaoClick(orderId) {
    pathaoMode    = 'single';
    pathaoOrderId = orderId;
    document.getElementById('pathao-modal-subtitle').textContent = '#INC-' + orderId;
    openPathaoModal();
}

/* ── Messages ── */
function hidePathaoMessages() {
    ['pathao-modal-info','pathao-modal-error'].forEach(function(id) {
        var el = document.getElementById(id);
        el.style.display = 'none';
        el.innerHTML = '';
    });
}

function showPathaoSuccess(msg) {
    var el = document.getElementById('pathao-modal-info');
    el.innerHTML = '<i class="bi bi-check-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-error').style.display = 'none';
}

function showPathaoError(msg) {
    var el = document.getElementById('pathao-modal-error');
    el.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-info').style.display = 'none';
}

/* ── Data Loaders (existing Pathao AJAX routes reuse) ── */
function loadStores() {
    fetch('{{ route("admin.pathao.stores") }}')
        .then(function(r) { return r.json(); })
        .then(function(res) {
            var sel = document.getElementById('pathao-store');
            sel.innerHTML = '<option value="">Select Store...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(function(s) {
                    sel.innerHTML += '<option value="' + s.store_id + '">' + s.store_name + '</option>';
                });
            } else {
                sel.innerHTML += '<option value="" disabled>No stores found</option>';
            }
        })
        .catch(function() {
            document.getElementById('pathao-store').innerHTML = '<option value="">Load failed</option>';
            showPathaoError('Store load করতে সমস্যা। API token চেক করুন।');
        });
}

function loadCities() {
    fetch('{{ route("admin.pathao.cities") }}')
        .then(function(r) { return r.json(); })
        .then(function(res) {
            var sel = document.getElementById('pathao-city');
            sel.innerHTML = '<option value="">Select City...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(function(c) {
                    sel.innerHTML += '<option value="' + c.city_id + '">' + c.city_name + '</option>';
                });
            }
        })
        .catch(function() {
            showPathaoError('City load করতে সমস্যা।');
        });
}

function loadZones(cityId) {
    if (!cityId) return;
    var sel = document.getElementById('pathao-zone');
    sel.innerHTML = '<option value="">Loading zones...</option>';
    document.getElementById('pathao-area').innerHTML = '<option value="">Select Area (Optional)...</option>';
    fetch('{{ route("admin.pathao.zones") }}?city_id=' + cityId)
        .then(function(r) { return r.json(); })
        .then(function(res) {
            sel.innerHTML = '<option value="">Select Zone...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(function(z) {
                    sel.innerHTML += '<option value="' + z.zone_id + '">' + z.zone_name + '</option>';
                });
            }
        })
        .catch(function() { sel.innerHTML = '<option value="">Zone load failed</option>'; });
}

function loadAreas(zoneId) {
    if (!zoneId) return;
    var sel = document.getElementById('pathao-area');
    sel.innerHTML = '<option value="">Loading areas...</option>';
    fetch('{{ route("admin.pathao.areas") }}?zone_id=' + zoneId)
        .then(function(r) { return r.json(); })
        .then(function(res) {
            sel.innerHTML = '<option value="">Select Area (Optional)...</option>';
            if (res.success && res.data && res.data.length) {
                res.data.forEach(function(a) {
                    sel.innerHTML += '<option value="' + a.area_id + '">' + a.area_name + '</option>';
                });
            }
        })
        .catch(function() { sel.innerHTML = '<option value="">Select Area (Optional)...</option>'; });
}

/* ── Pathao Submit ── */
function submitPathaoOrder() {
    var store_id = document.getElementById('pathao-store').value;
    var city_id  = document.getElementById('pathao-city').value;
    var zone_id  = document.getElementById('pathao-zone').value;
    var area_id  = document.getElementById('pathao-area').value;

    if (!store_id) { showPathaoError('Store নির্বাচন করুন।'); return; }
    if (!city_id)  { showPathaoError('City নির্বাচন করুন।');  return; }
    if (!zone_id)  { showPathaoError('Zone নির্বাচন করুন।');  return; }

    var btn = document.getElementById('pathao-submit-btn');
    btn.disabled  = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Sending...';
    hidePathaoMessages();

    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) {
        showPathaoError('CSRF token পাওয়া যাচ্ছে না।');
        btn.disabled  = false;
        btn.innerHTML = '<i class="bi bi-send"></i> Submit';
        return;
    }

    var formData = new FormData();
    formData.append('_token',   csrfMeta.getAttribute('content'));
    formData.append('store_id', store_id);
    formData.append('city_id',  city_id);
    formData.append('zone_id',  zone_id);
    if (area_id) formData.append('area_id', area_id);

    var url;
    if (pathaoMode === 'single') {
        url = '/admin/incomplete-orders/' + pathaoOrderId + '/pathao-send';
    } else {
        url = pathaoBulkUrl;
        document.querySelectorAll('.row-check:checked').forEach(function(cb) {
            formData.append('ids[]', cb.value);
        });
    }

    fetch(url, { method: 'POST', body: formData })
        .then(function(r) {
            if (!r.ok) return r.json().then(function(err) { throw new Error(err.message || 'Server error ' + r.status); });
            return r.json();
        })
        .then(function(res) {
            if (res.success) {
                showPathaoSuccess(res.message || 'সফলভাবে Pathao-তে পাঠানো হয়েছে!');
                setTimeout(function() { closePathaoModal(); location.reload(); }, 1800);
            } else {
                showPathaoError(res.message || 'Something went wrong। আবার চেষ্টা করুন।');
            }
        })
        .catch(function(e) { showPathaoError('Error: ' + e.message); })
        .finally(function() {
            btn.disabled  = false;
            btn.innerHTML = '<i class="bi bi-send"></i> Submit';
        });
}

/* ── Checkbox ── */
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(function(cb) { cb.checked = master.checked; });
    updateBulkIds();
}

function updateBulkIds() {
    var container = document.getElementById('bulk-ids');
    container.innerHTML = '';
    document.querySelectorAll('.row-check:checked').forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = cb.value;
        container.appendChild(inp);
    });
    var all     = document.querySelectorAll('.row-check');
    var checked = document.querySelectorAll('.row-check:checked');
    var master  = document.getElementById('check-all');
    master.indeterminate = checked.length > 0 && checked.length < all.length;
    master.checked       = all.length > 0 && checked.length === all.length;
}

function confirmBulkDelete() {
    var ids = document.querySelectorAll('.row-check:checked');
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return false; }
    return confirm(ids.length + 'টি incomplete অর্ডার মুছে ফেলতে চান?');
}

function confirmSteadfastBulk() {
    var ids = document.querySelectorAll('.row-check:checked');
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return false; }
    var container = document.getElementById('bulk-steadfast-ids');
    container.innerHTML = '';
    ids.forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = cb.value;
        container.appendChild(inp);
    });
    return confirm(ids.length + 'টি অর্ডার Steadfast-এ পাঠাতে চান?');
}

/* ── Bulk Status Modal ── */
function openBulkStatusModal() {
    var ids = document.querySelectorAll('.row-check:checked');
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return; }
    document.getElementById('bulk-status-overlay').classList.add('show');
}

function closeBulkStatusModal() {
    document.getElementById('bulk-status-overlay').classList.remove('show');
    document.getElementById('bulk-status-select').value = '';
}

function applyBulkStatus() {
    var status = document.getElementById('bulk-status-select').value;
    if (!status) { alert('একটি স্ট্যাটাস বেছে নিন।'); return; }
    var ids       = document.querySelectorAll('.row-check:checked');
    var container = document.getElementById('bulk-status-ids');
    container.innerHTML = '';
    ids.forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = cb.value;
        container.appendChild(inp);
    });
    document.getElementById('bulk-status-value').value = status;
    document.getElementById('bulk-status-form').submit();
}

document.getElementById('bulk-status-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeBulkStatusModal();
});
</script>

@endsection
