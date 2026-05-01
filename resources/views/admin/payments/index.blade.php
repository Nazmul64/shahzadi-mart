@extends('admin.master')

@section('main-content')
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark m-0">Payment History</h4>
            <p class="text-muted small m-0">Track all gateway transactions and payment statuses</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm rounded-12 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.payment.history') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Order # / Phone / TrxID" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="payment_method" class="form-select form-select-sm">
                        <option value="">All Methods</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                        <option value="bkash" {{ request('payment_method') == 'bkash' ? 'selected' : '' }}>bKash</option>
                        <option value="nagad" {{ request('payment_method') == 'nagad' ? 'selected' : '' }}>Nagad</option>
                        <option value="shurjopay" {{ request('payment_method') == 'shurjopay' ? 'selected' : '' }}>ShurjoPay</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary px-4">Filter</button>
                    <a href="{{ route('admin.payment.history') }}" class="btn btn-sm btn-light border">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-12 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Order Details</th>
                            <th>Method</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $order->created_at->format('d M, Y') }}</div>
                                <div class="small text-muted">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="text-decoration-none fw-bold">
                                    {{ $order->order_number }}
                                </a>
                                <div class="small text-muted">{{ $order->phone }}</div>
                            </td>
                            <td>
                                @php
                                    $method = strtolower($order->payment_method);
                                @endphp
                                @if($method == 'bkash')
                                    <span class="badge bg-soft-pink text-pink border">bKash</span>
                                @elseif($method == 'nagad')
                                    <span class="badge bg-soft-red text-red border">Nagad</span>
                                @elseif($method == 'shurjopay')
                                    <span class="badge bg-soft-orange text-orange border">ShurjoPay</span>
                                @else
                                    <span class="badge bg-light text-dark border">{{ strtoupper($method) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($order->transaction_id)
                                    <code class="bg-light p-1 rounded text-dark">{{ $order->transaction_id }}</code>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">৳{{ number_format($order->total, 2) }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @if($orders->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No payment records found.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 py-3 ps-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .rounded-12 { border-radius: 12px !important; }
    .bg-soft-pink { background: #fff0f8; }
    .text-pink { color: #E2136E; }
    .bg-soft-red { background: #fff1f1; }
    .text-red { color: #f12a24; }
    .bg-soft-orange { background: #fff7ed; }
    .text-orange { color: #f97316; }
    .badge { padding: 5px 10px; font-weight: 600; }
</style>
@endsection
