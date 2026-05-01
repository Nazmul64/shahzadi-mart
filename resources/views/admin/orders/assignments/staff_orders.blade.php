@extends('admin.master')

@section('main-content')
<div class="p-4">
    <div class="mb-4">
        <a href="{{ route('admin.order.assignments.index') }}" class="btn btn-sm btn-light mb-3">
            <i class="bi bi-arrow-left"></i> Back to Summary
        </a>
        <h4 class="fw-bold text-dark">Orders Assigned to: {{ $staff->name }}</h4>
        <p class="text-muted">Total {{ $orders->total() }} orders found</p>
    </div>

    <div class="card border-0 shadow-sm rounded-12 overflow-hidden">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="fw-bold">{{ $order->order_number }}</td>
                    <td>
                        <div class="fw-600">{{ $order->customer_name }}</div>
                        <div class="small text-muted">{{ $order->phone }}</div>
                    </td>
                    <td>৳{{ number_format($order->total, 0) }}</td>
                    <td>
                        <span class="badge rounded-pill bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'cancelled' ? 'danger' : 'warning') }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
