@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Brand List</h4>
                <p class="text-muted small mb-0">Manage product brands in your inventory</p>
            </div>
        </div>

        {{-- Brand Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom border-light">
                        <tr class="text-muted small">
                            <th class="ps-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">SL</th>
                            <th class="py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Thumbnail</th>
                            <th class="py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Brand Name</th>
                            <th class="text-end pe-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $key => $brand)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{ $key + 1 }}</td>
                                <td>
                                    @if($brand->photo)
                                        <img src="{{ asset('uploads/brand/' . $brand->photo) }}" 
                                             class="rounded-3 shadow-sm" 
                                             style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #f1f5f9;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">{{ $brand->name }}</td>
                                <td class="text-end pe-4">
                                    @if($brand->status === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No brands found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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
