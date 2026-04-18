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

.ao-actions { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.ao-icon-btn {
    width: 30px; height: 30px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; border: 1px solid #e8eaf0;
    background: #fff; color: #555; text-decoration: none; transition: all .2s;
}
.ao-icon-btn:hover { background: #f0f2f8; color: #333; }
.ao-icon-btn.view    { color: #3498db; border-color: #bee3f8; }
.ao-icon-btn.edit    { color: #8e44ad; border-color: #e9d8fd; }
.ao-icon-btn.del     { color: #e74c3c; border-color: #fecaca; }
.ao-icon-btn.courier { color: #f39c12; border-color: #feebc8; }
.ao-icon-btn.courier.sent { color: #fff; background: #f39c12; border-color: #f39c12; }

.ao-invoice-link { font-weight: 700; color: #3a4259; text-decoration: none; font-size: 13px; }
.ao-invoice-link:hover { color: #19cac4; }

.sf-badge {
    display: inline-block; padding: 2px 8px; border-radius: 20px;
    font-size: 10px; font-weight: 600; white-space: nowrap;
}
.sf-badge.sent     { background: #fff8e6; color: #b7791f; border: 1px solid #f6e05e; }
.sf-badge.not-sent { background: #f4f6fb; color: #aaa;    border: 1px solid #e5e7eb; }

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

.bulk-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.45); z-index: 9999;
    align-items: center; justify-content: center;
}
.bulk-modal-overlay.show { display: flex; }
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

.ao-pagination { padding: 16px 20px; border-top: 1px solid #f0f2f8; }
.ao-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.ao-empty i { font-size: 48px; display: block; margin-bottom: 12px; }
</style>

<div class="ao-wrapper">

    {{-- Top Header --}}
    <div class="ao-topbar">
        <h2>All Orders ({{ $orders->total() }})</h2>
        <a href="{{ route('admin.order.create') }}" class="btn-add-new">
            <i class="bi bi-cart-plus"></i> Add New
        </a>
    </div>

    {{-- Status Tabs --}}
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

    {{-- Action Bar --}}
    <div class="ao-actionbar">

        {{-- Bulk Change Status --}}
        <button class="ao-btn btn-status" onclick="openBulkStatusModal()">
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

        <button class="ao-btn btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>

        <a href="#" class="ao-btn btn-pathao">
            <i class="bi bi-send"></i> Pathao
        </a>

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

    {{-- Alerts --}}
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

    {{-- Table --}}
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
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Order Status</th>
                                <th>Courier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                            @php
                                $sfOrder = $order->steadfastOrder;
                                $isSent  = $sfOrder && $sfOrder->is_sent;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="ao-checkbox row-check"
                                           value="{{ $order->id }}"
                                           onchange="updateBulkIds()">
                                </td>

                                <td>{{ $orders->firstItem() + $index }}</td>

                                <td>
                                    <div class="ao-actions">
                                        <a href="{{ route('admin.order.show', $order->id) }}"
                                           class="ao-icon-btn view" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.order.edit', $order->id) }}"
                                           class="ao-icon-btn edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
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

                                        {{-- Single Steadfast Send --}}
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
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                       class="ao-invoice-link">
                                        {{ $order->order_number }}
                                    </a>
                                    <div style="font-size:11px;color:#aaa;">
                                        {{ $order->items->count() }} items
                                    </div>
                                </td>

                                <td>
                                    <div class="ao-date">{{ $order->created_at->format('d-m-Y') }}</div>
                                    <div class="ao-time">{{ $order->created_at->format('h:i A') }}</div>
                                </td>

                                <td>
                                    <div class="ao-cust-name">{{ $order->customer_name }}</div>
                                    <div class="ao-cust-addr">{{ $order->delivery_area }}</div>
                                </td>

                                <td>{{ $order->phone }}</td>

                                <td>
                                    <strong>৳{{ number_format($order->total, 0) }}</strong>
                                    @if($order->discount > 0)
                                        <div style="font-size:11px;color:#28a745;">
                                            -৳{{ number_format($order->discount, 0) }} ছাড়
                                        </div>
                                    @endif
                                </td>

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

                                <td>
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
                                        <span class="sf-badge not-sent">Not Sent</span>
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

</div>

{{-- Bulk Status Modal --}}
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
            <button class="bm-cancel" onclick="closeBulkStatusModal()">বাতিল</button>
            <button class="bm-apply" onclick="applyBulkStatus()">Apply করুন</button>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.order.bulk-status') }}" id="bulk-status-form">
    @csrf
    @method('PATCH')
    <div id="bulk-status-ids"></div>
    <input type="hidden" name="order_status" id="bulk-status-value">
</form>

<script>
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
    updateBulkIds();
}

function updateBulkIds() {
    const container = document.getElementById('bulk-ids');
    container.innerHTML = '';
    document.querySelectorAll('.row-check:checked').forEach(cb => {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
        container.appendChild(inp);
    });
    const all     = document.querySelectorAll('.row-check');
    const checked = document.querySelectorAll('.row-check:checked');
    const master  = document.getElementById('check-all');
    master.indeterminate = checked.length > 0 && checked.length < all.length;
    master.checked       = all.length > 0 && checked.length === all.length;
}

function confirmBulkDelete() {
    const ids = [...document.querySelectorAll('.row-check:checked')];
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return false; }
    return confirm(ids.length + 'টি অর্ডার মুছে ফেলতে চান?');
}

function confirmSteadfastSend() {
    const ids = [...document.querySelectorAll('.row-check:checked')];
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return false; }
    const container = document.getElementById('bulk-steadfast-ids');
    container.innerHTML = '';
    ids.forEach(cb => {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
        container.appendChild(inp);
    });
    return confirm(ids.length + 'টি অর্ডার Steadfast-এ পাঠাতে চান?');
}

function openBulkStatusModal() {
    const ids = [...document.querySelectorAll('.row-check:checked')];
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return; }
    document.getElementById('bulk-status-overlay').classList.add('show');
}

function closeBulkStatusModal() {
    document.getElementById('bulk-status-overlay').classList.remove('show');
    document.getElementById('bulk-status-select').value = '';
}

function applyBulkStatus() {
    const status = document.getElementById('bulk-status-select').value;
    if (!status) { alert('একটি স্ট্যাটাস বেছে নিন।'); return; }
    const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
    const idsContainer = document.getElementById('bulk-status-ids');
    idsContainer.innerHTML = '';
    ids.forEach(id => {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = id;
        idsContainer.appendChild(inp);
    });
    document.getElementById('bulk-status-value').value = status;
    document.getElementById('bulk-status-form').submit();
}

document.getElementById('bulk-status-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeBulkStatusModal();
});
</script>

@endsection
