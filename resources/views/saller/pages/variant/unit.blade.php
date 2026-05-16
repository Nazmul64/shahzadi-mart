@extends('saller.master')

@section('main-content')
<div class="main-content">
    <div class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="navbar-brand">
                <i class="bi bi-shop"></i>
                <span class="d-none d-sm-inline">SELLER <strong>PORTAL</strong></span>
            </div>
        </div>
    </div>

<div class="page-content bg-light pb-5">
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Unit List</h4>
                <p class="text-muted small mb-0">Manage product units in your inventory</p>
            </div>
        </div>

        {{-- Unit Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom border-light">
                        <tr class="text-muted small">
                            <th class="ps-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">SL</th>
                            <th class="py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Unit Name</th>
                            <th class="text-end pe-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $key => $unit)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{ $key + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $unit->unit_name }}</td>
                                <td class="text-end pe-4">
                                    @if($unit->status === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No units found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<style>
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
    .custom-switch {
        width: 40px !important;
        height: 20px !important;
        cursor: not-allowed !important;
        opacity: 1 !important;
    }
    .custom-switch:checked {
        background-color: #ff3e6c !important;
        border-color: #ff3e6c !important;
    }
    .table thead th {
        padding: 15px 10px;
    }
    .table tbody td {
        padding: 15px 10px;
    }
</style>
@endsection
