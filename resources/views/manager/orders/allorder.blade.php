@extends('manager.master')

@section('content')

@php $u = auth()->user(); @endphp

<style>
.ao-wrapper { background:#f4f6fb; min-height:100vh; font-family:'Segoe UI',sans-serif; }

/* ── Topbar ── */
.ao-topbar { background:#fff; border-bottom:1px solid #e8eaf0; padding:14px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
.ao-topbar h2 { font-size:18px; font-weight:700; color:#1a2b6b; margin:0; }

/* ── Status Tabs ── */
.ao-tabs { display:flex; gap:6px; flex-wrap:wrap; padding:12px 24px; background:#fff; border-bottom:1px solid #e8eaf0; }
.ao-tab { padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; background:#f4f6fb; color:#555; border:1px solid #e5e7eb; text-decoration:none; transition:all .2s; }
.ao-tab:hover { border-color:#1a2b6b; color:#1a2b6b; }
.ao-tab.active { background:#1a2b6b; color:#fff; border-color:#1a2b6b; }

/* ── Action Bar ── */
.ao-actionbar { background:#fff; padding:10px 24px; display:flex; align-items:center; gap:8px; border-bottom:1px solid #e8eaf0; flex-wrap:wrap; }
.ao-btn { border:none; border-radius:20px; padding:7px 16px; font-size:12px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:5px; text-decoration:none; transition:all .2s; }
.btn-sf  { background:#f39c12; color:#fff; }
.btn-sf:hover { background:#d68910; color:#fff; }
.btn-pt  { background:#00b894; color:#fff; }
.btn-pt:hover { background:#00a381; color:#fff; }
.btn-del-bulk { background:#ef4444; color:#fff; }
.btn-del-bulk:hover { background:#dc2626; color:#fff; }
.bulk-count { font-size:12px; color:#666; margin-left:4px; }

/* ── Table ── */
.ao-card { background:#fff; border-radius:10px; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden; margin:20px; }
.ao-table { width:100%; border-collapse:collapse; }
.ao-table th { padding:11px 14px; font-size:11px; font-weight:700; color:#7a849e; text-transform:uppercase; background:#f8f9fc; border-bottom:1px solid #eef0f8; white-space:nowrap; }
.ao-table td { padding:12px 14px; font-size:13px; color:#2d3748; border-bottom:1px solid #f0f2f8; vertical-align:middle; }
.ao-table tbody tr:hover { background:#fafbff; }

/* Checkbox */
.cb-wrap input[type=checkbox] { width:16px; height:16px; cursor:pointer; accent-color:#1a2b6b; }

/* Action icons */
.ic-btn { width:30px; height:30px; border-radius:7px; display:inline-flex; align-items:center; justify-content:center; border:1.5px solid #e8eaf0; background:#fff; color:#555; text-decoration:none; font-size:14px; cursor:pointer; transition:all .2s; }
.ic-btn:hover { background:#1a2b6b; color:#fff; border-color:#1a2b6b; }
.ic-btn.red:hover { background:#ef4444; border-color:#ef4444; }

/* Status select */
.stat-sel { border:1.5px solid #e5e7eb; border-radius:8px; padding:4px 6px; font-size:12px; font-weight:500; background:#fff; cursor:pointer; }
.stat-sel:focus { outline:none; border-color:#1a2b6b; }

/* Staff dropdown */
.staff-sel { border:1.5px solid #e5e7eb; border-radius:8px; padding:4px 6px; font-size:12px; background:#fff; cursor:pointer; min-width:120px; }
.staff-sel:focus { outline:none; border-color:#1a2b6b; }

/* Badges */
.sf-badge { padding:2px 8px; border-radius:12px; font-size:10px; font-weight:700; }
.sf-sent { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
.sf-no   { background:#f3f4f6; color:#9ca3af; border:1px solid #e5e7eb; }

/* Invoice */
.inv-num { font-weight:700; color:#1a2b6b; font-size:13px; }
.inv-date { font-size:11px; color:#94a3b8; margin-top:2px; }

/* Attribute Tags */
.attr-tag { font-size:10px; padding:1px 5px; border-radius:4px; font-weight:700; margin-right:3px; display:inline-block; margin-top:2px; }
.attr-color { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
.attr-size  { background:#ebf8ff; color:#2b6cb0; border:1px solid #90cdf4; }
</style>

<div class="ao-wrapper">

    {{-- Topbar --}}
    <div class="ao-topbar">
        <h2><i class="bi bi-bag-check me-2"></i>Manager — All Orders
            <span class="badge bg-secondary ms-2" style="font-size:12px;">{{ $orders->total() }}</span>
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('manager.orders.create') }}" class="ao-btn" style="background:#1a2b6b;color:#fff;">
                <i class="bi bi-plus-lg"></i> New Order
            </a>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="ao-tabs">
        @php
            $tabs = ['all'=>'All','pending'=>'Pending','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled'];
            $curStatus = request('status');
        @endphp
        @foreach($tabs as $val => $label)
        <a href="{{ route('manager.orders.index', $val === 'all' ? [] : ['status'=>$val]) }}"
           class="ao-tab {{ ($val === 'all' && !$curStatus) || $curStatus === $val ? 'active' : '' }}">
            {{ $label }}
            <span style="font-size:10px;opacity:.7;">({{ $statusCounts[$val === 'all' ? 'all' : $val] ?? 0 }})</span>
        </a>
        @endforeach
    </div>

    {{-- Bulk Actions Bar --}}
    <form id="bulkForm" method="POST" action="{{ route('manager.orders.bulk-delete') }}">
        @csrf
        @method('DELETE')

        <div class="ao-actionbar">
            {{-- Steadfast Bulk Send --}}
            <button type="button" class="ao-btn btn-sf" onclick="bulkSend('steadfast')">
                <i class="bi bi-truck"></i> Steadfast Send
            </button>
            {{-- Pathao Bulk Send --}}
            <button type="button" class="ao-btn btn-pt" onclick="bulkSend('pathao')">
                <i class="bi bi-send"></i> Pathao Send
            </button>

            @if($u->isSuperAdmin() || $u->hasPermission('delete-orders'))
            {{-- Bulk Delete --}}
            <button type="button" class="ao-btn btn-del-bulk" onclick="confirmBulkDelete()">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
            @endif

            <span class="bulk-count" id="selCount">0 selected</span>

            {{-- Search --}}
            <div class="ms-auto d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control form-control-sm" placeholder="Search order / customer…" style="width:200px;border-radius:8px;">
                <button type="submit" form="searchForm" class="ao-btn" style="background:#1a2b6b;color:#fff;">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>

    <form method="GET" action="{{ route('manager.orders.index') }}" id="searchForm" style="display:none"></form>

    {{-- Table --}}
    <div class="ao-card">
        <div class="table-responsive">
            <table class="ao-table">
                <thead>
                    <tr>
                        <th class="cb-wrap" style="width:40px;">
                            <input type="checkbox" id="checkAll" title="Select All">
                        </th>
                        <th>INVOICE</th>
                        <th>ACTIONS</th>
                        <th>COLOR</th>
                        <th>SIZE</th>
                        <th>CUSTOMER</th>
                        <th>AMOUNT</th>
                        <th>ORDER STATUS</th>
                        <th>COURIER</th>
                        <th>HANDLED BY</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    @php $sf = $order->steadfastOrder; @endphp
                    <tr id="row-{{ $order->id }}">
                        <td class="cb-wrap">
                            <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="row-check" form="bulkForm">
                        </td>

                        {{-- Invoice --}}
                        <td>
                            <div class="inv-num">{{ $order->order_number }}</div>
                            <div class="inv-date">{{ $order->created_at->format('d M, h:i A') }}</div>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('manager.orders.show', $order->id) }}" class="ic-btn" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @php
                                    $isConfirmed = $order->order_status !== 'pending' || ($sf && $sf->is_sent) || $order->pathaoOrder;
                                    $canEditDelete = $u->isAdmin() || $u->isSuperAdmin() || !$isConfirmed;
                                @endphp
                                @if($canEditDelete)
                                <a href="{{ route('manager.orders.edit', $order->id) }}" class="ic-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <form method="POST" action="{{ route('manager.orders.steadfast.send', $order->id) }}" style="margin:0">
                                    @csrf
                                    <button type="submit" class="ic-btn" title="Send Steadfast"
                                            style="{{ $sf && $sf->is_sent ? 'background:#fef3c7;border-color:#fde68a;' : '' }}">
                                        <i class="bi bi-truck"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('manager.orders.pathao.send', $order->id) }}" style="margin:0">
                                    @csrf
                                    <button type="submit" class="ic-btn" title="Send Pathao">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @if($canEditDelete && ($u->isSuperAdmin() || $u->hasPermission('delete-orders')))
                                <form method="POST" action="{{ route('manager.orders.destroy', $order->id) }}" style="margin:0"
                                      onsubmit="return confirm('Delete order #{{ $order->order_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="ic-btn red" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
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

                        <td>
                            <div style="font-weight:600;">{{ $order->customer_name }}</div>
                            <div style="font-size:11px;color:#94a3b8;">{{ $order->phone }}</div>
                        </td>

                        <td style="font-weight:700;color:#1a2b6b;">৳{{ number_format($order->total, 0) }}</td>

                        <td>
                            <form method="POST" action="{{ route('manager.orders.status', $order->id) }}" style="margin:0">
                                @csrf @method('PATCH')
                                <select name="order_status" class="stat-sel" onchange="this.form.submit()">
                                    @foreach(\App\Models\Order::$orderStatuses as $val => $label)
                                        <option value="{{ $val }}" {{ $order->order_status === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>

                        <td>
                            @if($sf && $sf->is_sent)
                                <span class="sf-badge sf-sent"><i class="bi bi-truck"></i> Steadfast</span>
                            @else
                                <span class="sf-badge sf-no">Not Sent</span>
                            @endif
                        </td>

                        <td>
                            <form method="POST" action="{{ route('manager.orders.assign-staff', $order->id) }}" style="margin:0">
                                @csrf @method('PATCH')
                                <select name="assigned_user_id" class="staff-sel" onchange="this.form.submit()">
                                    <option value="">— Unassigned —</option>
                                    @foreach($staffUsers as $staff)
                                        <option value="{{ $staff->id }}"
                                            {{ $order->assigned_user_id == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem;"></i>
                            <div class="mt-2">No orders found</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span style="font-size:12px;color:#94a3b8;">
                Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </span>
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- Hidden Bulk Forms --}}
    <form id="sfBulkForm" method="POST" action="{{ route('manager.orders.steadfast.bulk-send') }}" style="display:none">
        @csrf
        <div id="sfBulkIds"></div>
    </form>
    <form id="ptBulkForm" method="POST" action="{{ route('manager.orders.pathao.bulk-send') }}" style="display:none">
        @csrf
        <div id="ptBulkIds"></div>
    </form>

</div>

<script>
const checkAll  = document.getElementById('checkAll');
const rowChecks = () => document.querySelectorAll('.row-check');
const selCount  = document.getElementById('selCount');

function updateCount() {
    const n = [...rowChecks()].filter(c => c.checked).length;
    selCount.textContent = n + ' selected';
}

checkAll.addEventListener('change', function () {
    rowChecks().forEach(c => c.checked = this.checked);
    updateCount();
});

document.addEventListener('change', function (e) {
    if (e.target.classList.contains('row-check')) {
        updateCount();
        checkAll.checked = [...rowChecks()].every(c => c.checked);
        checkAll.indeterminate = [...rowChecks()].some(c => c.checked) && !checkAll.checked;
    }
});

function confirmBulkDelete() {
    const ids = [...rowChecks()].filter(c => c.checked).map(c => c.value);
    if (!ids.length) { alert('Please select at least one order.'); return; }
    if (!confirm('Delete ' + ids.length + ' selected order(s)?')) return;
    document.getElementById('bulkForm').submit();
}

function bulkSend(courier) {
    const ids = [...rowChecks()].filter(c => c.checked).map(c => c.value);
    if (!ids.length) { alert('Please select at least one order.'); return; }
    const formId  = courier === 'steadfast' ? 'sfBulkForm' : 'ptBulkForm';
    const divId   = courier === 'steadfast' ? 'sfBulkIds'  : 'ptBulkIds';
    const form    = document.getElementById(formId);
    const div     = document.getElementById(divId);
    div.innerHTML = ids.map(id => `<input type="hidden" name="order_ids[]" value="${id}">`).join('');
    if (confirm('Send ' + ids.length + ' order(s) to ' + courier + '?')) form.submit();
}
</script>

@endsection
