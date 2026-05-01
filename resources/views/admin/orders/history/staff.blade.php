@extends('admin.master')

@section('main-content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('admin.order-history.index') }}" class="btn btn-sm btn-light mb-3">
            <i class="bi bi-arrow-left"></i> Back to All Activity
        </a>
        <div class="d-flex align-items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=64" 
                 class="rounded-circle border" style="width:60px;" alt="">
            <div>
                <h4 class="fw-bold text-dark m-0">{{ $user->name }}'s Activity</h4>
                <p class="text-muted small m-0">Performance tracking and history</p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-12">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Order Invoice</th>
                        <th>Status Changed To</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td style="width:180px;">
                            <div class="fw-600">{{ $history->created_at->format('d M, Y') }}</div>
                            <div class="small text-muted">{{ $history->created_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.show', $history->order_id) }}" class="fw-bold text-decoration-none">
                                {{ $history->order->order_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $history->status == 'delivered' ? 'success' : ($history->status == 'cancelled' ? 'danger' : 'primary') }}">
                                {{ ucfirst($history->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $history->comment }}
                        </td>
                    </tr>
                    @endforeach
                    @if($histories->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            No activity recorded for this staff member yet.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($histories->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $histories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
