@extends('admin.master')

@section('main-content')
<style>
    .history-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px; }
    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
    .bg-pending { background: #fff8e6; color: #b7791f; }
    .bg-processing { background: #ebf8ff; color: #2b6cb0; }
    .bg-shipped { background: #e8f5e9; color: #2e7d32; }
    .bg-delivered { background: #f0fff4; color: #276749; }
    .bg-cancelled { background: #fff5f5; color: #c53030; }
</style>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark m-0">Staff Activity History</h4>
            <p class="text-muted small">Track who confirmed or updated which orders</p>
        </div>
        
        <form method="GET" class="d-flex gap-2">
            <select name="user_id" class="form-select form-select-sm" style="width:180px;">
                <option value="">All Staff</option>
                @foreach($staffMembers as $staff)
                    <option value="{{ $staff->id }}" {{ request('user_id') == $staff->id ? 'selected' : '' }}>
                        {{ $staff->name }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width:140px;">
                <option value="">All Statuses</option>
                <option value="pending"    {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped"    {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered"  {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled"  {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary px-3">Filter</button>
            @if(request()->hasAny(['user_id', 'status']))
                <a href="{{ route('admin.order-history.index') }}" class="btn btn-sm btn-light">Reset</a>
            @endif
        </form>
    </div>

    <div class="history-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Staff Member</th>
                        <th>Order Invoice</th>
                        <th>Action / Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td>
                            <div class="fw-600">{{ $history->created_at->format('d M, Y') }}</div>
                            <div class="small text-muted">{{ $history->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($history->user->name ?? 'System') }}&background=6366f1&color=fff" 
                                     style="width:30px; height:30px; border-radius:50%;" alt="">
                                <span class="fw-600">{{ $history->user->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.show', $history->order_id) }}" class="fw-bold text-decoration-none">
                                {{ $history->order->order_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td>
                            <span class="status-pill bg-{{ $history->status }}">
                                {{ $history->status }}
                            </span>
                        </td>
                        <td class="small text-muted italic">
                            {{ $history->comment }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $histories->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
