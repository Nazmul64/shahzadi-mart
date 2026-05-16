@extends('saller.master')

@section('main-content')
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="navbar-brand">POS History</div>
        </div>
    </div>

    <div class="page-content p-4">
        <div class="data-card bg-white rounded-3 shadow-sm">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Sales</h5>
                <a href="{{ route('saller.pos.index') }}" class="btn btn-primary btn-sm">New Sale</a>
            </div>
            <div class="table-responsive p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $s)
                        <tr>
                            <td><strong>{{ $s->invoice_no }}</strong></td>
                            <td>{{ $s->customer->name ?? 'Guest' }}</td>
                            <td>৳{{ number_format($s->grand_total, 2) }}</td>
                            <td>{!! $s->status_badge !!}</td>
                            <td>{{ $s->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-end">
                                <a href="{{ route('saller.pos.invoice', $s->id) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer"></i></a>
                                @if($s->status !== 'cancelled')
                                <button onclick="cancelOrder({{ $s->id }})" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</div>

<script>
function cancelOrder(id) {
    if(confirm('Are you sure you want to cancel this order?')) {
        $.post("{{ url('saller/pos/cancel-order') }}/" + id, {_token: "{{ csrf_token() }}"}, function(res) {
            if(res.success) location.reload();
            else alert(res.message);
        });
    }
}
</script>
@endsection
