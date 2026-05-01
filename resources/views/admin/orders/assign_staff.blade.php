@extends('admin.master')

@section('main-content')
<div class="p-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-12">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold m-0">Assign Staff to Order</h5>
                    <p class="text-muted small">Order: {{ $order->order_number }}</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Customer</small>
                                <strong>{{ $order->customer_name }}</strong>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted d-block">Total Amount</small>
                                <strong>৳{{ number_format($order->total, 0) }}</strong>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.order.assign-staff.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="form-label fw-600">Select Staff Member</label>
                            <select name="assigned_user_id" class="form-select form-select-lg border-2">
                                <option value="">-- Unassigned --</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}" {{ $order->assigned_user_id == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                This staff member will be responsible for processing this order.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                Update Assignment
                            </button>
                            <a href="{{ route('admin.order.allorder') }}" class="btn btn-light btn-lg rounded-pill">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
