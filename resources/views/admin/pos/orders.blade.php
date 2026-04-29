@extends('admin.master')

@section('main-content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">POS Orders</h4>
        <a href="{{ route('admin.pos.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-cash-register"></i> New Sale
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="search" class="form-control form-control-sm w-auto"
               placeholder="Search invoice..." value="{{ request('search') }}">
        <select name="status" class="form-select form-select-sm w-auto">
            <option value="">All Status</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button class="btn btn-sm btn-secondary">Filter</button>
        <a href="{{ route('admin.pos.orders') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Grand Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sessions as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $s->invoice_no }}</strong></td>
                    <td>
                        @if($s->customer)
                            {{ $s->customer->name }}<br>
                            <small class="text-muted">{{ $s->customer->phone }}</small>
                        @else
                            <span class="text-muted">Walk-in</span>
                        @endif
                    </td>
                    <td>{{ $s->items_count ?? $s->items()->count() }} items</td>
                    <td><strong>${{ number_format($s->grand_total, 2) }}</strong></td>
                    <td>{{ ucwords(str_replace('_',' ',$s->payment_method)) }}</td>
                    <td>
                        @if($s->status === 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($s->status === 'draft')
                            <span class="badge bg-warning text-dark">Draft</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                    <td>{{ $s->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <a href="{{ route('admin.pos.invoice', $s->id) }}" target="_blank"
                           class="btn btn-xs btn-outline-primary btn-sm">
                            <i class="fas fa-file-invoice"></i> Invoice
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">No POS orders found.</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $sessions->withQueryString()->links() }}
    </div>

</div>
@endsection
