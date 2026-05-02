@extends('emplee.master')

@section('content')

@php $u = auth()->user(); @endphp

<style>
.ao-wrapper { background:#f4f6fb; min-height:100vh; font-family:'Inter',sans-serif; }
.ao-topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:14px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
.ao-topbar h2 { font-size:18px; font-weight:700; color:#0f172a; margin:0; }
.ao-tabs { display:flex; gap:6px; flex-wrap:wrap; padding:12px 24px; background:#fff; border-bottom:1px solid #e2e8f0; }
.ao-tab { padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; background:#f4f6fb; color:#555; border:1px solid #e5e7eb; text-decoration:none; transition:all .2s; }
.ao-tab.active { background:#6366f1; color:#fff; border-color:#6366f1; }
.ao-actionbar { background:#fff; padding:10px 24px; display:flex; align-items:center; gap:8px; border-bottom:1px solid #e2e8f0; flex-wrap:wrap; }
.ao-btn { border:none; border-radius:20px; padding:7px 16px; font-size:12px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:5px; text-decoration:none; transition:all .2s; }
.btn-sf  { background:#f59e0b; color:#fff; }
.btn-pt  { background:#10b981; color:#fff; }
.btn-del-bulk { background:#ef4444; color:#fff; }
.ao-card { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,.06); overflow:hidden; margin:20px; }
.ao-table { width:100%; border-collapse:collapse; }
.ao-table th { padding:11px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; background:#f8fafc; border-bottom:1px solid #f1f5f9; }
.ao-table td { padding:12px 14px; font-size:13px; color:#1e293b; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
.ao-table tbody tr:hover { background:#fafbff; }
.cb-wrap input[type=checkbox] { width:16px; height:16px; cursor:pointer; accent-color:#6366f1; }
.ic-btn { width:30px; height:30px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #e2e8f0; background:#fff; color:#64748b; text-decoration:none; font-size:14px; cursor:pointer; transition:all .2s; }
.ic-btn:hover { background:#6366f1; color:#fff; border-color:#6366f1; }
.ic-btn.red:hover { background:#ef4444; border-color:#ef4444; }
.stat-sel { border:1px solid #e2e8f0; border-radius:8px; padding:4px 8px; font-size:12px; background:#fff; cursor:pointer; }
.staff-sel { border:1px solid #e2e8f0; border-radius:8px; padding:4px 8px; font-size:12px; background:#fff; cursor:pointer; min-width:120px; }
.sf-badge { padding:2px 8px; border-radius:12px; font-size:10px; font-weight:700; }
.sf-sent { background:#fef3c7; color:#92400e; }
.sf-no { background:#f3f4f6; color:#9ca3af; }
.inv-num { font-weight:700; color:#6366f1; }
.inv-date { font-size:11px; color:#94a3b8; }
</style>

<div class="ao-wrapper">

    <div class="ao-topbar">
        <h2><i class="bi bi-bag-check me-2"></i>Employee — Orders
            <span class="badge bg-secondary ms-2" style="font-size:11px;">{{ $orders->total() }}</span>
        </h2>
        <a href="{{ route('emplee.orders.create') }}" class="ao-btn" style="background:#6366f1;color:#fff;">
            <i class="bi bi-plus-lg"></i> New Order
        </a>
    </div>

    <div class="ao-tabs">
        @php $tabs = ['all'=>'All','pending'=>'Pending','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled']; @endphp
        @foreach($tabs as $val => $label)
        <a href="{{ route('emplee.orders.index', $val === 'all' ? [] : ['status'=>$val]) }}"
           class="ao-tab {{ ($val === 'all' && !request('status')) || request('status') === $val ? 'active' : '' }}">
            {{ $label }} ({{ $statusCounts[$val === 'all' ? 'all' : $val] ?? 0 }})
        </a>
        @endforeach
    </div>

    <form id="bulkForm" method="POST" action="{{ route('emplee.orders.bulk-delete') }}">
        @csrf @method('DELETE')

        <div class="ao-actionbar">
            <button type="button" class="ao-btn btn-sf" onclick="bulkSend('steadfast')">
                <i class="bi bi-truck"></i> Steadfast
            </button>
            <button type="button" class="ao-btn btn-pt" onclick="bulkSend('pathao')">
                <i class="bi bi-send"></i> Pathao
            </button>
            @if($u->isSuperAdmin() || $u->hasPermission('delete-orders'))
            <button type="button" class="ao-btn btn-del-bulk" onclick="confirmBulkDelete()">
                <i class="bi bi-trash"></i> Delete Selected
            </button>
            @endif
            <span id="selCount" style="font-size:12px;color:#64748b;margin-left:4px;">0 selected</span>
            <form method="GET" action="{{ route('emplee.orders.index') }}" class="ms-auto d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                       placeholder="Search…" style="width:190px;border-radius:8px;">
                <button type="submit" class="ao-btn" style="background:#6366f1;color:#fff;"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="ao-card">
            <div class="table-responsive">
                <table class="ao-table">
                    <thead>
                        <tr>
                            <th style="width:36px;" class="cb-wrap"><input type="checkbox" id="checkAll"></th>
                            <th>Invoice</th>
                            <th>Actions</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Courier</th>
                            <th>Handled By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        @php $sf = $order->steadfastOrder; @endphp
                        <tr>
                            <td class="cb-wrap"><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="row-check"></td>
                            <td>
                                <div class="inv-num">{{ $order->order_number }}</div>
                                <div class="inv-date">{{ $order->created_at->format('d M, h:i A') }}</div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('emplee.orders.show', $order->id) }}" class="ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    @php
                                        $isConfirmed = $order->order_status !== 'pending' || ($sf && $sf->is_sent) || $order->pathaoOrder;
                                        $canEditDelete = $u->isAdmin() || $u->isSuperAdmin() || !$isConfirmed;
                                    @endphp
                                    @if($canEditDelete)
                                    <a href="{{ route('emplee.orders.edit', $order->id) }}" class="ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    @endif
                                    <form method="POST" action="{{ route('emplee.orders.steadfast.send', $order->id) }}" style="margin:0">
                                        @csrf
                                        <button class="ic-btn" title="Steadfast"><i class="bi bi-truck"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('emplee.orders.pathao.send', $order->id) }}" style="margin:0">
                                        @csrf
                                        <button class="ic-btn" title="Pathao"><i class="bi bi-send"></i></button>
                                    </form>
                                    @if($canEditDelete && ($u->isSuperAdmin() || $u->hasPermission('delete-orders')))
                                    <form method="POST" action="{{ route('emplee.orders.destroy', $order->id) }}" style="margin:0"
                                          onsubmit="return confirm('Delete this order?')">
                                        @csrf @method('DELETE')
                                        <button class="ic-btn red"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $order->customer_name }}</div>
                                <small style="color:#94a3b8;">{{ $order->phone }}</small>
                            </td>
                            <td style="font-weight:700;color:#6366f1;">৳{{ number_format($order->total, 0) }}</td>
                            <td>
                                <form method="POST" action="{{ route('emplee.orders.status', $order->id) }}">
                                    @csrf @method('PATCH')
                                    <select name="order_status" class="stat-sel" onchange="this.form.submit()">
                                        @foreach(\App\Models\Order::$orderStatuses as $val => $label)
                                            <option value="{{ $val }}" {{ $order->order_status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                @if($sf && $sf->is_sent)
                                    <span class="sf-badge sf-sent"><i class="bi bi-truck"></i> Sent</span>
                                @else
                                    <span class="sf-badge sf-no">Not Sent</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('emplee.orders.assign-staff', $order->id) }}">
                                    @csrf @method('PATCH')
                                    <select name="assigned_user_id" class="staff-sel" onchange="this.form.submit()">
                                        <option value="">— Unassigned —</option>
                                        @foreach($staffUsers as $staff)
                                            <option value="{{ $staff->id }}" {{ $order->assigned_user_id == $staff->id ? 'selected' : '' }}>
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
            <div class="p-3">{{ $orders->appends(request()->query())->links() }}</div>
        </div>
    </form>

    <form id="sfBulkForm" method="POST" action="{{ route('emplee.orders.steadfast.bulk-send') }}" style="display:none">@csrf<div id="sfBulkIds"></div></form>
    <form id="ptBulkForm" method="POST" action="{{ route('emplee.orders.pathao.bulk-send') }}" style="display:none">@csrf<div id="ptBulkIds"></div></form>

</div>

<script>
const checkAll = document.getElementById('checkAll');
const rowChecks = () => document.querySelectorAll('.row-check');
const selCount = document.getElementById('selCount');

function updateCount() {
    const n = [...rowChecks()].filter(c=>c.checked).length;
    selCount.textContent = n + ' selected';
}
checkAll.addEventListener('change', function() {
    rowChecks().forEach(c => c.checked = this.checked);
    updateCount();
});
document.addEventListener('change', e => {
    if(e.target.classList.contains('row-check')) {
        updateCount();
        checkAll.checked = [...rowChecks()].every(c=>c.checked);
        checkAll.indeterminate = [...rowChecks()].some(c=>c.checked) && !checkAll.checked;
    }
});
function confirmBulkDelete() {
    const ids = [...rowChecks()].filter(c=>c.checked);
    if(!ids.length){ alert('Select at least one order.'); return; }
    if(confirm('Delete '+ids.length+' order(s)?')) document.getElementById('bulkForm').submit();
}
function bulkSend(courier) {
    const ids = [...rowChecks()].filter(c=>c.checked).map(c=>c.value);
    if(!ids.length){ alert('Select at least one order.'); return; }
    const form = document.getElementById(courier==='steadfast'?'sfBulkForm':'ptBulkForm');
    const div  = document.getElementById(courier==='steadfast'?'sfBulkIds':'ptBulkIds');
    div.innerHTML = ids.map(id=>`<input type="hidden" name="order_ids[]" value="${id}">`).join('');
    if(confirm('Send '+ids.length+' order(s) to '+(courier==='steadfast'?'Steadfast':'Pathao')+'?')) form.submit();
}
</script>

@endsection
