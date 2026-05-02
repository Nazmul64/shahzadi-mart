@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }

.ao-wrapper {
    background: #f4f6fb;
    min-height: 100vh;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* ── Topbar ── */
.ao-topbar {
    background: #fff;
    border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ao-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }

.btn-add-new {
    background: linear-gradient(135deg, #f7617a, #e84b65);
    color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center;
    gap: 6px; text-decoration: none; transition: opacity .2s;
}
.btn-add-new:hover { opacity: .88; color: #fff; text-decoration: none; }

/* ── Tabs ── */
.ao-tabs {
    display: flex; gap: 6px; flex-wrap: wrap;
    padding: 14px 24px; background: #fff; border-bottom: 1px solid #e8eaf0;
}
.ao-tab {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
    background: #f4f6fb; color: #555; border: 1px solid #e5e7eb;
    text-decoration: none; transition: all 0.2s;
}
.ao-tab:hover { background: #e9ecef; color: #333; text-decoration: none; }
.ao-tab.active { background: #2d3748; color: #fff; border-color: #2d3748; }
.ao-tab-badge {
    background: rgba(0,0,0,0.12); border-radius: 20px;
    padding: 1px 7px; font-size: 11px;
}
.ao-tab.active .ao-tab-badge { background: rgba(255,255,255,0.25); }

/* ── Action Bar ── */
.ao-actionbar {
    background: #fff;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    border-bottom: 1px solid #e8eaf0;
}
.ao-btn {
    border: none; border-radius: 22px; padding: 8px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
    transition: opacity .2s, transform .1s;
}
.ao-btn:hover { opacity: .88; transform: translateY(-1px); text-decoration: none; }
.ao-btn:active { transform: translateY(0); }

.btn-status    { background: #9b59b6; color: #fff; }
.btn-delete    { background: #e74c3c; color: #fff; }
.btn-print     { background: #3498db; color: #fff; }
.btn-steadfast { background: #f39c12; color: #fff; }
.btn-pathao    { background: #00b894; color: #fff; }

/* ── Search ── */
.ao-search-wrap { margin-left: auto; display: flex; gap: 8px; align-items: center; }
.ao-search-input {
    border: 1px solid #dde2ec; border-radius: 22px; padding: 7px 16px;
    font-size: 13px; width: 220px; outline: none; transition: border-color .2s;
}
.ao-search-input:focus { border-color: #19cac4; }
.btn-search {
    background: #19cac4; color: #fff; border: none; border-radius: 22px;
    padding: 8px 20px; font-size: 13px; font-weight: 600; cursor: pointer;
}

/* ── Table ── */
.ao-content { padding: 20px 24px; }
.ao-table-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden;
}
.ao-table { width: 100%; border-collapse: collapse; }
.ao-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.ao-table th {
    padding: 12px 14px; font-size: 12px; font-weight: 700; color: #7a849e;
    text-transform: uppercase; letter-spacing: .4px; white-space: nowrap;
}
.ao-table tbody tr { border-bottom: 1px solid #f0f2f8; transition: background .15s; }
.ao-table tbody tr:hover { background: #fafbff; }
.ao-table tbody tr:last-child { border-bottom: none; }
.ao-table td { padding: 12px 14px; font-size: 13px; color: #3a4259; vertical-align: middle; }

.ao-checkbox { width: 16px; height: 16px; accent-color: #19cac4; cursor: pointer; }

/* ── Icon Buttons ── */
.ao-actions { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.ao-icon-btn {
    width: 30px; height: 30px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; border: 1px solid #e8eaf0;
    background: #fff; color: #555; text-decoration: none; transition: all .2s;
}
.ao-icon-btn:hover { background: #f0f2f8; color: #333; }
.ao-icon-btn.view         { color: #3498db; border-color: #bee3f8; }
.ao-icon-btn.edit         { color: #8e44ad; border-color: #e9d8fd; }
.ao-icon-btn.del          { color: #e74c3c; border-color: #fecaca; }
.ao-icon-btn.courier      { color: #f39c12; border-color: #feebc8; }
.ao-icon-btn.courier.sent { color: #fff; background: #f39c12; border-color: #f39c12; }
.ao-icon-btn.pathao-btn      { color: #00b894; border-color: #b2dfdb; }
.ao-icon-btn.pathao-btn.sent { color: #fff; background: #00b894; border-color: #00b894; }

/* ── Misc Table ── */
.ao-invoice-link { font-weight: 700; color: #3a4259; text-decoration: none; font-size: 13px; }
.ao-invoice-link:hover { color: #19cac4; }

.sf-badge {
    display: inline-block; padding: 2px 8px; border-radius: 20px;
    font-size: 10px; font-weight: 600; white-space: nowrap;
}
.sf-badge.sent        { background: #fff8e6; color: #b7791f; border: 1px solid #f6e05e; }
.sf-badge.not-sent    { background: #f4f6fb; color: #aaa;    border: 1px solid #e5e7eb; }
.sf-badge.pathao-sent { background: #e8f5e9; color: #276749; border: 1px solid #9ae6b4; }

.ao-status-select {
    border-radius: 6px; padding: 4px 8px; font-size: 12px; font-weight: 500;
    border: 1px solid #e5e7eb; cursor: pointer; outline: none;
    transition: all 0.2s; min-width: 125px;
}
.ao-status-select:focus { border-color: #2d3748; }

.order-sel[data-current="pending"]    { background: #fff8e6; color: #b7791f; border-color: #f6e05e; }
.order-sel[data-current="processing"] { background: #ebf8ff; color: #2b6cb0; border-color: #90cdf4; }
.order-sel[data-current="shipped"]    { background: #e8f5e9; color: #2e7d32; border-color: #a5d6a7; }
.order-sel[data-current="delivered"]  { background: #f0fff4; color: #276749; border-color: #9ae6b4; }
.order-sel[data-current="cancelled"]  { background: #fff5f5; color: #c53030; border-color: #feb2b2; }

.pay-sel[data-current="pending"]  { background: #fff8e6; color: #b7791f; border-color: #f6e05e; }
.pay-sel[data-current="paid"]     { background: #f0fff4; color: #276749; border-color: #9ae6b4; }
.pay-sel[data-current="failed"]   { background: #fff5f5; color: #c53030; border-color: #feb2b2; }
.pay-sel[data-current="refunded"] { background: #faf5ff; color: #6b46c1; border-color: #d6bcfa; }

.ao-date { font-size: 13px; color: #3a4259; }
.ao-time { font-size: 11px; color: #aaa; }
.ao-cust-name { font-weight: 600; font-size: 13px; color: #2d3748; }
.ao-cust-addr { font-size: 11px; color: #888; margin-top: 2px; }

/* ── Bulk Status Modal ── */
.bulk-modal-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 9999;
}
.bulk-modal-overlay.show {
    display: flex;
    align-items: center;
    justify-content: center;
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
.pm-label {
    font-size: 13px; font-weight: 600; color: #3a4259;
    display: block; margin-bottom: 6px;
}
.pm-select {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px;
    padding: 9px 12px; font-size: 13px; outline: none; color: #3a4259;
}
.pm-select:focus { border-color: #00b894; }
.pm-info-box {
    border-radius: 8px; padding: 10px 14px;
    font-size: 13px; margin-bottom: 16px; display: none;
}
.pm-info-box.success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
.pm-info-box.error   { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; }

/* ── Pagination / Empty ── */
.ao-pagination { padding: 16px 20px; border-top: 1px solid #f0f2f8; }
.ao-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.ao-empty i { font-size: 48px; display: block; margin-bottom: 12px; }

/* ── Attribute Tags ── */
.attr-tag { font-size: 10px; padding: 1px 6px; border-radius: 4px; font-weight: 600; margin-right: 3px; display: inline-block; }
.attr-color { background: #FFF5F6; color: #C8102E; border: 1px solid #FFEBEB; }
.attr-size  { background: #F0F7FF; color: #007BFF; border: 1px solid #E1EFFF; }
</style>

<div class="ao-wrapper">

    {{-- ══ Top Header ══ --}}
    <div class="ao-topbar">
        <h2>All Orders ({{ $orders->total() }})</h2>
        <a href="{{ route('admin.order.create') }}" class="btn-add-new">
            <i class="bi bi-cart-plus"></i> Add New
        </a>
    </div>

    {{-- ══ Status Tabs ══ --}}
    <div class="ao-tabs">
        <a href="{{ route('admin.order.allorder') }}"
           class="ao-tab {{ !request('status') ? 'active' : '' }}">
            All <span class="ao-tab-badge">{{ $statusCounts['all'] }}</span>
        </a>
        @foreach(['pending','processing','shipped','delivered','cancelled'] as $tab)
        <a href="{{ route('admin.order.allorder', ['status' => $tab]) }}"
           class="ao-tab {{ request('status') === $tab ? 'active' : '' }}">
            {{ ucfirst($tab) }}
            <span class="ao-tab-badge">{{ $statusCounts[$tab] }}</span>
        </a>
        @endforeach
    </div>

    {{-- ══ Action Bar ══ --}}
    <div class="ao-actionbar">

        {{-- Bulk Change Status --}}
        <button type="button" class="ao-btn btn-status" onclick="openBulkStatusModal()">
            <i class="bi bi-arrow-repeat"></i> Change Status
        </button>

        {{-- Bulk Delete --}}
        <form method="POST"
              action="{{ route('admin.order.bulk-delete') }}"
              id="bulk-delete-form"
              onsubmit="return confirmBulkDelete()">
            @csrf
            @method('DELETE')
            <div id="bulk-ids"></div>
            <button type="submit" class="ao-btn btn-delete">
                <i class="bi bi-trash3"></i> Delete Selected
            </button>
        </form>

        {{-- Bulk Steadfast Send --}}
        <form method="POST"
              action="{{ route('admin.steadfast.bulk-send') }}"
              id="bulk-steadfast-form"
              onsubmit="return confirmSteadfastSend()">
            @csrf
            <div id="bulk-steadfast-ids"></div>
            <button type="submit" class="ao-btn btn-steadfast">
                <i class="bi bi-truck"></i> Steadfast Send
            </button>
        </form>

        {{-- Print --}}
        <button type="button" class="ao-btn btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>

        {{-- Bulk Pathao Send ✅ --}}
        <button type="button" class="ao-btn btn-pathao" onclick="handleBulkPathaoClick()">
            <i class="bi bi-send"></i> Pathao
        </button>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.order.allorder') }}" class="ao-search-wrap">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="অর্ডার/নাম/ফোন খুঁজুন..." class="ao-search-input">
            <button type="submit" class="btn-search">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.order.allorder', array_filter(['status' => request('status')])) }}"
                   class="ao-btn btn-delete" style="padding:7px 14px;">
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

    {{-- ══ Table ══ --}}
    <div class="ao-content">
        <div class="ao-table-card">
            @if($orders->isEmpty())
                <div class="ao-empty">
                    <i class="bi bi-inbox"></i>
                    <p>কোনো অর্ডার পাওয়া যায়নি।</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="ao-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">
                                    <input type="checkbox" class="ao-checkbox" id="check-all"
                                           onchange="toggleAll(this)">
                                </th>
                                <th>SL</th>
                                <th>Action</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Staff</th>
                                <th>Order Status</th>
                                <th>Courier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                            @php
                                $sfOrder    = $order->steadfastOrder;
                                $isSent     = $sfOrder && $sfOrder->is_sent;
                                $pathaoOrd  = $order->pathaoOrder;
                                $pathaoSent = $pathaoOrd && $pathaoOrd->is_sent;
                            @endphp
                            <tr>
                                {{-- Checkbox --}}
                                <td>
                                    <input type="checkbox" class="ao-checkbox row-check"
                                           value="{{ $order->id }}"
                                           onchange="updateBulkIds()">
                                </td>

                                {{-- SL --}}
                                <td>{{ $orders->firstItem() + $index }}</td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ao-actions">

                                        {{-- View --}}
                                        <a href="{{ route('admin.order.show', $order->id) }}"
                                           class="ao-icon-btn view" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.order.edit', $order->id) }}"
                                           class="ao-icon-btn edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form method="POST"
                                              action="{{ route('admin.order.destroy', $order->id) }}"
                                              onsubmit="return confirm('এই অর্ডারটি মুছে ফেলতে চান?')"
                                              style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ao-icon-btn del" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                        {{-- Steadfast Single Send --}}
                                        <form method="POST"
                                              action="{{ route('admin.steadfast.send', $order->id) }}"
                                              onsubmit="return confirm('Steadfast-এ পাঠাতে চান?')"
                                              style="margin:0;">
                                            @csrf
                                            <button type="submit"
                                                    class="ao-icon-btn courier {{ $isSent ? 'sent' : '' }}"
                                                    title="{{ $isSent ? 'Sent — পুনরায় পাঠান' : 'Steadfast-এ পাঠান' }}">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>

                                        {{-- Pathao Single Send ✅ --}}
                                        <button type="button"
                                                class="ao-icon-btn pathao-btn {{ $pathaoSent ? 'sent' : '' }}"
                                                title="{{ $pathaoSent ? 'Pathao Sent — Resend' : 'Pathao-তে পাঠান' }}"
                                                onclick="handleSinglePathaoClick({{ $order->id }}, '{{ $order->order_number }}')">
                                            <i class="bi bi-send"></i>
                                        </button>

                                    </div>
                                </td>

                                {{-- Invoice --}}
                                <td>
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                       class="ao-invoice-link">
                                        {{ $order->order_number }}
                                    </a>
                                    <div style="font-size:11px;color:#aaa;">
                                        {{ $order->items->count() }} items
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="ao-date">{{ $order->created_at->format('d-m-Y') }}</div>
                                    <div class="ao-time">{{ $order->created_at->format('h:i A') }}</div>
                                </td>

                                {{-- Color --}}
                                <td>
                                    @foreach($order->items as $item)
                                        @if($item->selected_color)
                                            <span class="attr-tag attr-color">{{ $item->selected_color }}</span>
                                        @endif
                                    @endforeach
                                </td>

                                {{-- Size --}}
                                <td>
                                    @foreach($order->items as $item)
                                        @if($item->selected_size)
                                            <span class="attr-tag attr-size">{{ $item->selected_size }}</span>
                                        @endif
                                    @endforeach
                                </td>

                                {{-- Customer --}}
                                <td>
                                    <div class="ao-cust-name">{{ $order->customer_name }}</div>
                                    <div class="ao-cust-addr">{{ $order->delivery_area }}</div>
                                </td>

                                {{-- Phone --}}
                                <td>{{ $order->phone }}</td>

                                {{-- Amount --}}
                                <td>
                                    <strong>৳{{ number_format($order->total, 0) }}</strong>
                                    @if($order->discount > 0)
                                        <div style="font-size:11px;color:#28a745;">
                                            -৳{{ number_format($order->discount, 0) }} ছাড়
                                        </div>
                                    @endif
                                </td>

                                {{-- Payment Status --}}
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.order.payment-status', $order->id) }}"
                                          style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="payment_status"
                                                class="ao-status-select pay-sel"
                                                data-current="{{ $order->payment_status }}"
                                                onchange="this.form.submit()">
                                            <option value="pending"  {{ $order->payment_status === 'pending'  ? 'selected' : '' }}>Pending</option>
                                            <option value="paid"     {{ $order->payment_status === 'paid'     ? 'selected' : '' }}>Paid</option>
                                            <option value="failed"   {{ $order->payment_status === 'failed'   ? 'selected' : '' }}>Failed</option>
                                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Assign Staff --}}
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.order.assign-staff.update', $order->id) }}"
                                          style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="assigned_user_id"
                                                class="ao-status-select"
                                                style="background:#f4f6fb; border-color:#dde2ec; min-width:140px;"
                                                onchange="this.form.submit()">
                                            <option value="">-- Assign Staff --</option>
                                            @foreach($staffMembers as $staff)
                                                <option value="{{ $staff->id }}"
                                                    {{ $order->assigned_user_id == $staff->id ? 'selected' : '' }}>
                                                    {{ $staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                {{-- Order Status --}}
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.order.status', $order->id) }}"
                                          style="margin:0;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="order_status"
                                                class="ao-status-select order-sel"
                                                data-current="{{ $order->order_status }}"
                                                onchange="this.form.submit()">
                                            <option value="pending"    {{ $order->order_status === 'pending'    ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                            <option value="shipped"    {{ $order->order_status === 'shipped'    ? 'selected' : '' }}>🚚 Shipped</option>
                                            <option value="delivered"  {{ $order->order_status === 'delivered'  ? 'selected' : '' }}>✅ Delivered</option>
                                            <option value="cancelled"  {{ $order->order_status === 'cancelled'  ? 'selected' : '' }}>❌ Cancelled</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Courier Status --}}
                                <td>
                                    {{-- Steadfast Badge --}}
                                    @if($isSent)
                                        <span class="sf-badge sent">
                                            <i class="bi bi-check-circle-fill me-1"></i>Sent
                                        </span>
                                        <div style="font-size:10px;color:#888;margin-top:3px;">
                                            {{ $sfOrder->tracking_code ?? $sfOrder->consignment_id }}
                                        </div>
                                        <div style="font-size:10px;margin-top:2px;">
                                            @php
                                                $sfStatus = $sfOrder->status;
                                                $sfColor  = match($sfStatus) {
                                                    'delivered'         => '#276749',
                                                    'cancelled'         => '#c53030',
                                                    'partial_delivered' => '#2b6cb0',
                                                    default             => '#b7791f',
                                                };
                                            @endphp
                                            <span style="color:{{ $sfColor }};font-weight:600;">
                                                {{ ucfirst(str_replace('_', ' ', $sfStatus)) }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="sf-badge not-sent">SF: No</span>
                                    @endif

                                    {{-- Pathao Badge --}}
                                    @if($pathaoSent)
                                        <span class="sf-badge pathao-sent" style="margin-top:3px;display:block;">
                                            <i class="bi bi-send-fill me-1"></i>Pathao
                                        </span>
                                    @else
                                        <span class="sf-badge not-sent" style="margin-top:3px;display:block;">
                                            Pathao: No
                                        </span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ao-pagination">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>{{-- end ao-wrapper --}}


{{-- ════════════════════════════════════════════════
     BULK STATUS MODAL
════════════════════════════════════════════════ --}}
<div class="bulk-modal-overlay" id="bulk-status-overlay">
    <div class="bulk-modal">
        <h4><i class="bi bi-arrow-repeat me-2"></i>Bulk Status Change</h4>
        <select id="bulk-status-select">
            <option value="">-- স্ট্যাটাস বেছে নিন --</option>
            <option value="pending">⏳ Pending</option>
            <option value="processing">🔄 Processing</option>
            <option value="shipped">🚚 Shipped</option>
            <option value="delivered">✅ Delivered</option>
            <option value="cancelled">❌ Cancelled</option>
        </select>
        <div class="bulk-modal-btns">
            <button type="button" class="bm-cancel" onclick="closeBulkStatusModal()">বাতিল</button>
            <button type="button" class="bm-apply"  onclick="applyBulkStatus()">Apply করুন</button>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.order.bulk-status') }}" id="bulk-status-form">
    @csrf
    @method('PATCH')
    <div id="bulk-status-ids"></div>
    <input type="hidden" name="order_status" id="bulk-status-value">
</form>


{{-- ════════════════════════════════════════════════
     PATHAO MODAL  ✅ FIXED
════════════════════════════════════════════════ --}}
<div id="pathao-overlay"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);
            z-index:10000; align-items:center; justify-content:center;">

    <div style="background:#fff; border-radius:12px; padding:28px 32px;
                width:440px; max-width:95vw; box-shadow:0 8px 32px rgba(0,0,0,0.2);
                max-height:90vh; overflow-y:auto;">

        {{-- Header --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h5 style="margin:0; font-size:16px; font-weight:700; color:#2d3748;">
                <i class="bi bi-send me-2" style="color:#00b894;"></i>
                Pathao Courier
                <span id="pathao-modal-subtitle"
                      style="font-size:12px; font-weight:400; color:#aaa; margin-left:8px;"></span>
            </h5>
            <button type="button" onclick="closePathaoModal()"
                    style="background:none; border:none; font-size:22px; cursor:pointer; color:#aaa; line-height:1;">
                ×
            </button>
        </div>

        {{-- Messages --}}
        <div id="pathao-modal-info"  class="pm-info-box success"></div>
        <div id="pathao-modal-error" class="pm-info-box error"></div>

        {{-- Store --}}
        <div style="margin-bottom:14px;">
            <label class="pm-label">Store <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-store" class="pm-select">
                <option value="">Select Store...</option>
            </select>
        </div>

        {{-- City --}}
        <div style="margin-bottom:14px;">
            <label class="pm-label">City <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-city" class="pm-select" onchange="loadZones(this.value)">
                <option value="">Select City...</option>
            </select>
        </div>

        {{-- Zone --}}
        <div style="margin-bottom:14px;">
            <label class="pm-label">Zone <span style="color:#e74c3c;">*</span></label>
            <select id="pathao-zone" class="pm-select" onchange="loadAreas(this.value)">
                <option value="">Select Zone...</option>
            </select>
        </div>

        {{-- Area --}}
        <div style="margin-bottom:22px;">
            <label class="pm-label">
                Area <span style="font-size:11px; color:#aaa; font-weight:400;">(Optional)</span>
            </label>
            <select id="pathao-area" class="pm-select">
                <option value="">Select Area (Optional)...</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div style="display:flex; gap:10px; justify-content:flex-end;">
            <button type="button" onclick="closePathaoModal()"
                    style="background:#f4f6fb; color:#555; border:1px solid #e5e7eb;
                           border-radius:8px; padding:9px 22px; font-size:13px;
                           cursor:pointer; font-weight:600;">
                Close
            </button>
            <button type="button" id="pathao-submit-btn" onclick="submitPathaoOrder()"
                    style="background:#00b894; color:#fff; border:none; border-radius:8px;
                           padding:9px 22px; font-size:13px; cursor:pointer; font-weight:600;
                           display:inline-flex; align-items:center; gap:6px;">
                <i class="bi bi-send"></i> Submit
            </button>
        </div>

    </div>
</div>{{-- end pathao-overlay --}}


{{-- ════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════ --}}
<script>

/* ───────────────────────────────────────────────
   PATHAO STATE
─────────────────────────────────────────────── */
var pathaoMode    = 'single';   // 'single' | 'bulk'
var pathaoOrderId = null;
var pathaoBulkUrl = '{{ route("admin.pathao.bulk-send") }}';

/* ───────────────────────────────────────────────
   OPEN / CLOSE PATHAO MODAL
   ✅ KEY FIX: style.display ব্যবহার করো,
              class toggle নয়
─────────────────────────────────────────────── */
function openPathaoModal() {
    // Messages reset
    hidePathaoMessages();

    // Dropdowns reset
    document.getElementById('pathao-store').innerHTML = '<option value="">Loading...</option>';
    document.getElementById('pathao-city').innerHTML  = '<option value="">Loading...</option>';
    document.getElementById('pathao-zone').innerHTML  = '<option value="">Select Zone...</option>';
    document.getElementById('pathao-area').innerHTML  = '<option value="">Select Area (Optional)...</option>';

    // Submit btn reset
    var btn = document.getElementById('pathao-submit-btn');
    btn.disabled  = false;
    btn.innerHTML = '<i class="bi bi-send"></i> Submit';

    // ✅ সরাসরি inline style দিয়ে show করো
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

// Backdrop click → close
document.getElementById('pathao-overlay').addEventListener('click', function(e) {
    if (e.target === this) closePathaoModal();
});

/* ───────────────────────────────────────────────
   BULK PATHAO BUTTON
─────────────────────────────────────────────── */
function handleBulkPathaoClick() {
    var checked = document.querySelectorAll('.row-check:checked');
    if (!checked.length) {
        alert('প্রথমে অন্তত একটি অর্ডার সিলেক্ট করুন।');
        return;
    }
    pathaoMode    = 'bulk';
    pathaoOrderId = null;
    document.getElementById('pathao-modal-subtitle').textContent = checked.length + ' টি অর্ডার';
    openPathaoModal();
}

/* ───────────────────────────────────────────────
   SINGLE ROW PATHAO BUTTON
─────────────────────────────────────────────── */
function handleSinglePathaoClick(orderId, orderNumber) {
    pathaoMode    = 'single';
    pathaoOrderId = orderId;
    document.getElementById('pathao-modal-subtitle').textContent = '#' + orderNumber;
    openPathaoModal();
}

/* ───────────────────────────────────────────────
   MESSAGE HELPERS
─────────────────────────────────────────────── */
function hidePathaoMessages() {
    var infoEl  = document.getElementById('pathao-modal-info');
    var errorEl = document.getElementById('pathao-modal-error');
    infoEl.style.display  = 'none';
    errorEl.style.display = 'none';
    infoEl.innerHTML  = '';
    errorEl.innerHTML = '';
}

function showPathaoSuccess(msg) {
    var el = document.getElementById('pathao-modal-info');
    el.innerHTML     = '<i class="bi bi-check-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-error').style.display = 'none';
}

function showPathaoError(msg) {
    var el = document.getElementById('pathao-modal-error');
    el.innerHTML     = '<i class="bi bi-exclamation-circle me-1"></i>' + msg;
    el.style.display = 'block';
    document.getElementById('pathao-modal-info').style.display = 'none';
}

/* ───────────────────────────────────────────────
   DATA LOADERS
─────────────────────────────────────────────── */
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
            } else {
                sel.innerHTML += '<option value="" disabled>No cities found</option>';
            }
        })
        .catch(function() {
            document.getElementById('pathao-city').innerHTML = '<option value="">Load failed</option>';
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
        .catch(function() {
            sel.innerHTML = '<option value="">Zone load failed</option>';
        });
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
        .catch(function() {
            sel.innerHTML = '<option value="">Select Area (Optional)...</option>';
        });
}

/* ───────────────────────────────────────────────
   PATHAO SUBMIT
─────────────────────────────────────────────── */
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
        url = '/admin/orders/' + pathaoOrderId + '/send-pathao';
    } else {
        url = pathaoBulkUrl;
        document.querySelectorAll('.row-check:checked').forEach(function(cb) {
            formData.append('ids[]', cb.value);
        });
    }

    fetch(url, { method: 'POST', body: formData })
        .then(function(r) {
            if (!r.ok) {
                return r.json().then(function(err) {
                    throw new Error(err.message || 'Server error ' + r.status);
                });
            }
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

/* ───────────────────────────────────────────────
   BULK CHECKBOX HELPERS
─────────────────────────────────────────────── */
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(function(cb) {
        cb.checked = master.checked;
    });
    updateBulkIds();
}

function updateBulkIds() {
    var container = document.getElementById('bulk-ids');
    container.innerHTML = '';
    document.querySelectorAll('.row-check:checked').forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
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
    return confirm(ids.length + ' টি অর্ডার মুছে ফেলতে চান?');
}

function confirmSteadfastSend() {
    var ids = document.querySelectorAll('.row-check:checked');
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return false; }
    var container = document.getElementById('bulk-steadfast-ids');
    container.innerHTML = '';
    ids.forEach(function(cb) {
        var inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
        container.appendChild(inp);
    });
    return confirm(ids.length + ' টি অর্ডার Steadfast-এ পাঠাতে চান?');
}

/* ───────────────────────────────────────────────
   BULK STATUS MODAL
─────────────────────────────────────────────── */
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
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
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
