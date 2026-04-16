@extends('admin.master')

@section('main-content')

<style>
/* ─── Reset & Base ─────────────────────────────────────────────────── */
* { box-sizing: border-box; }

.ao-wrapper {
    background: #f4f6fb;
    min-height: 100vh;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* ─── Top Header Bar ────────────────────────────────────────────────── */
.ao-topbar {
    background: #fff;
    border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ao-topbar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}
.btn-add-new {
    background: linear-gradient(135deg, #f7617a, #e84b65);
    color: #fff;
    border: none;
    border-radius: 22px;
    padding: 9px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: opacity .2s;
}
.btn-add-new:hover { opacity: .88; color: #fff; text-decoration: none; }

/* ─── Action Button Bar ─────────────────────────────────────────────── */
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
    border: none;
    border-radius: 22px;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: opacity .2s, transform .1s;
}
.ao-btn:hover { opacity: .88; transform: translateY(-1px); text-decoration: none; }
.ao-btn:active { transform: translateY(0); }

.btn-assign   { background: #19cac4; color: #fff; }
.btn-status   { background: #9b59b6; color: #fff; }
.btn-delete   { background: #e74c3c; color: #fff; }
.btn-print    { background: #3498db; color: #fff; }
.btn-courier  { background: #f39c12; color: #fff; }
.btn-pathao   { background: #00b894; color: #fff; }

.ao-search-wrap {
    margin-left: auto;
    display: flex;
    gap: 8px;
    align-items: center;
}
.ao-search-input {
    border: 1px solid #dde2ec;
    border-radius: 22px;
    padding: 7px 16px;
    font-size: 13px;
    width: 220px;
    outline: none;
    transition: border-color .2s;
}
.ao-search-input:focus { border-color: #19cac4; }
.btn-search {
    background: #19cac4;
    color: #fff;
    border: none;
    border-radius: 22px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

/* ─── Table Wrapper ─────────────────────────────────────────────────── */
.ao-content { padding: 20px 24px; }

.ao-table-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    overflow: hidden;
}

/* ─── Table ─────────────────────────────────────────────────────────── */
.ao-table { width: 100%; border-collapse: collapse; }
.ao-table thead tr {
    background: #f8f9fc;
    border-bottom: 2px solid #e8eaf0;
}
.ao-table th {
    padding: 12px 14px;
    font-size: 12px;
    font-weight: 700;
    color: #7a849e;
    text-transform: uppercase;
    letter-spacing: .4px;
    white-space: nowrap;
}
.ao-table tbody tr {
    border-bottom: 1px solid #f0f2f8;
    transition: background .15s;
}
.ao-table tbody tr:hover { background: #fafbff; }
.ao-table tbody tr:last-child { border-bottom: none; }
.ao-table td {
    padding: 14px 14px;
    font-size: 13px;
    color: #3a4259;
    vertical-align: middle;
}

/* ─── Checkbox ──────────────────────────────────────────────────────── */
.ao-checkbox {
    width: 16px; height: 16px;
    accent-color: #19cac4;
    cursor: pointer;
}

/* ─── Action Icons ──────────────────────────────────────────────────── */
.ao-actions { display: flex; gap: 6px; align-items: center; }
.ao-icon-btn {
    width: 30px; height: 30px;
    border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px;
    cursor: pointer;
    border: 1px solid #e8eaf0;
    background: #fff;
    color: #555;
    text-decoration: none;
    transition: all .2s;
}
.ao-icon-btn:hover { background: #f0f2f8; color: #333; }
.ao-icon-btn.view  { color: #3498db; border-color: #bee3f8; }
.ao-icon-btn.edit  { color: #8e44ad; border-color: #e9d8fd; }
.ao-icon-btn.cfg   { color: #f39c12; border-color: #feebc8; }
.ao-icon-btn.del   { color: #e74c3c; border-color: #fecaca; }

/* ─── Invoice link ──────────────────────────────────────────────────── */
.ao-invoice-link {
    font-weight: 700;
    color: #3a4259;
    text-decoration: none;
    font-size: 13px;
}
.ao-invoice-link:hover { color: #19cac4; }

/* ─── Status Badge ──────────────────────────────────────────────────── */
.ao-badge {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.badge-pending    { background: #fff8e6; color: #b7791f; border: 1px solid #f6e05e; }
.badge-processing { background: #ebf8ff; color: #2b6cb0; border: 1px solid #90cdf4; }
.badge-completed  { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
.badge-cancelled  { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }

/* ─── Date cell ─────────────────────────────────────────────────────── */
.ao-date { font-size: 13px; color: #3a4259; }
.ao-time { font-size: 11px; color: #aaa; }

/* ─── Customer name ─────────────────────────────────────────────────── */
.ao-cust-name { font-weight: 600; font-size: 13px; color: #2d3748; }
.ao-cust-addr { font-size: 11px; color: #888; margin-top: 2px; line-height: 1.4; }

/* ─── Pagination ────────────────────────────────────────────────────── */
.ao-pagination { padding: 16px 20px; border-top: 1px solid #f0f2f8; }
.ao-pagination .pagination { margin: 0; }

/* ─── Empty State ───────────────────────────────────────────────────── */
.ao-empty {
    text-align: center;
    padding: 60px 20px;
    color: #aaa;
}
.ao-empty i { font-size: 48px; display: block; margin-bottom: 12px; }
</style>

<div class="ao-wrapper">

    {{-- Top Header --}}
    <div class="ao-topbar">
        <h2>All Order ({{ $orders->total() }})</h2>
        <a href="{{ route('admin.order.create') }}" class="btn-add-new">
            <i class="bi bi-cart-plus"></i> Add New
        </a>
    </div>

    {{-- Action Bar --}}
    <div class="ao-actionbar">
        <button class="ao-btn btn-assign" onclick="assignSelected()">
            <i class="bi bi-person-plus"></i> Assign User
        </button>
        <button class="ao-btn btn-status" onclick="changeStatusSelected()">
            <i class="bi bi-plus-circle"></i> Change Status
        </button>
        <form method="POST" action="{{ route('admin.order.bulk-delete') }}" id="bulk-delete-form"
              onsubmit="return confirm('নির্বাচিত অর্ডারগুলো মুছে ফেলতে চান?')">
            @csrf
            @method('DELETE')
            <div id="bulk-ids"></div>
            <button type="submit" class="ao-btn btn-delete">
                <i class="bi bi-plus-circle"></i> Delete All
            </button>
        </form>
        <button class="ao-btn btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>
        <a href="#" class="ao-btn btn-courier">
            <i class="bi bi-truck"></i> Courier
        </a>
        <a href="#" class="ao-btn btn-pathao">
            <i class="bi bi-send"></i> pathao
        </a>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.order.allorder') }}" class="ao-search-wrap">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search" class="ao-search-input">
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Assign</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
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
                                        <a href="#" class="ao-icon-btn cfg" title="Settings">
                                            <i class="bi bi-gear"></i>
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
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                       class="ao-invoice-link">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="ao-date">{{ $order->created_at->format('d-m-Y') }}</div>
                                    <div class="ao-time">{{ $order->created_at->format('h:i:s a') }}</div>
                                </td>
                                <td>
                                    <div class="ao-cust-name">{{ $order->customer_name }}</div>
                                    <div class="ao-cust-addr">{{ $order->address }}</div>
                                </td>
                                <td>{{ $order->phone }}</td>
                                <td>
                                    <span style="font-size:12px;color:#aaa;">—</span>
                                </td>
                                <td>
                                    <strong style="font-size:13px;">৳{{ number_format($order->total, 0) }}</strong>
                                </td>
                                <td>
                                    @php
                                        $s = $order->order_status;
                                        $label = ucfirst($s);
                                    @endphp
                                    <span class="ao-badge badge-{{ $s }}">{{ $label }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="ao-pagination">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<script>
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
    updateBulkIds();
}

function updateBulkIds() {
    const container = document.getElementById('bulk-ids');
    container.innerHTML = '';
    document.querySelectorAll('.row-check:checked').forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        container.appendChild(input);
    });
    // update check-all state
    const all = document.querySelectorAll('.row-check');
    const checked = document.querySelectorAll('.row-check:checked');
    document.getElementById('check-all').indeterminate = checked.length > 0 && checked.length < all.length;
    document.getElementById('check-all').checked = checked.length === all.length && all.length > 0;
}

function assignSelected() {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return; }
    alert('Assign feature: ' + ids.join(', '));
}

function changeStatusSelected() {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
    if (!ids.length) { alert('কোনো অর্ডার নির্বাচন করুন।'); return; }
    const status = prompt('নতুন স্ট্যাটাস লিখুন (pending/processing/completed/cancelled):');
    if (status) {
        // Submit to bulk status route
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.order.bulk-status") }}';
        form.innerHTML = `@csrf <input name="_method" value="PATCH"> <input name="order_status" value="${status}">`;
        ids.forEach(id => {
            form.innerHTML += `<input name="ids[]" value="${id}">`;
        });
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
