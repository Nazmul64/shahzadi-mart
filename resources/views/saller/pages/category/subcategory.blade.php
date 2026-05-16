@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Sub Category List</h4>
                <p class="text-muted small mb-0">Manage sub-categories for your products</p>
            </div>
        </div>

        {{-- Sub Category Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom border-light">
                        <tr class="text-muted small">
                            <th class="ps-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">SL</th>
                            <th class="py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Category Name</th>
                            <th class="py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Sub Category Name</th>
                            <th class="text-end pe-4 py-3 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $key => $subCategory)
                            <tr>
                                <td class="ps-4 fw-medium text-dark">{{ $key + 1 }}</td>
                                <td class="text-secondary fw-medium">{{ $subCategory->category->category_name ?? 'N/A' }}</td>
                                <td class="fw-bold text-dark">{{ $subCategory->sub_name }}</td>
                                <td class="text-end pe-4">
                                    @if($subCategory->status === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Active</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-medium" style="font-size: 11px;">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No sub categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .table thead th { border-top: 0; }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #f8fafc; }
    .badge { letter-spacing: 0.3px; }
</style>
@endsection
