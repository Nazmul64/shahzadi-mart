@extends('admin.master')

@section('main-content')
<style>
    .assign-card {
        background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 24px;
    }
    .staff-pill {
        display: flex; align-items: center; gap: 12px;
    }
    .staff-pill img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #f0f2f5; }
    .staff-name { font-weight: 600; color: #2d3748; }
    .staff-role { font-size: 11px; color: #718096; text-transform: uppercase; }
    
    .count-badge {
        padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;
    }
    .bg-light-blue { background: #eef2ff; color: #4f46e5; }
    .bg-light-green { background: #f0fdf4; color: #16a34a; }
</style>

<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0">Order Assignments</h4>
        <div class="d-flex gap-3">
            <div class="assign-card p-3 d-flex align-items-center gap-3">
                <div class="bg-light-blue p-2 rounded">
                    <i class="bi bi-person-badge fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Total Staff</div>
                    <div class="fw-bold">{{ $staffMembers->count() }}</div>
                </div>
            </div>
            <div class="assign-card p-3 d-flex align-items-center gap-3">
                <div class="bg-light-green p-2 rounded">
                    <i class="bi bi-cart-x fs-4"></i>
                </div>
                <div>
                    <div class="small text-muted">Unassigned Orders</div>
                    <div class="fw-bold">{{ $unassignedCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="assign-card">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Staff Member</th>
                    <th>Assigned Orders</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staffMembers as $staff)
                <tr>
                    <td>
                        <div class="staff-pill">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->name) }}&background=6366f1&color=fff" alt="">
                            <div>
                                <div class="staff-name">{{ $staff->name }}</div>
                                <div class="staff-role">{{ $staff->roles->first()->name ?? 'Staff' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="count-badge bg-light-blue">
                            {{ $staff->assigned_orders_count }} Orders
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.order.assignments.staff', $staff->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View Orders
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
