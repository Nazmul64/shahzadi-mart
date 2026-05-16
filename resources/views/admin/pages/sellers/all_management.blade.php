@extends('admin.master')
@section('content')
<div class="content-body" style="background: #f8f9fa;">
    <div class="container-fluid">
        <div class="row page-titles mx-0 align-items-center mb-4">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4 class="font-w700 text-dark"><i class="bi bi-shop me-2 text-pink"></i>Shops</h4>
                    <p class="mb-0 text-muted">This is a shops list.</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <div class="btn-group me-2">
                    <button class="btn btn-pink btn-sm active"><i class="bi bi-grid-fill"></i></button>
                    <button class="btn btn-outline-pink btn-sm"><i class="bi bi-list-ul"></i></button>
                </div>
                <a href="{{ route('admin.sellers.create') }}" class="btn btn-pink btn-sm px-3">
                    <i class="bi bi-plus-lg me-1"></i> Add Shop
                </a>
            </div>
        </div>

        <div class="row">
            @forelse($sellers as $seller)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card shop-card shadow-sm border-0 h-100" style="border-radius: 15px; overflow: visible;">
                    {{-- Banner --}}
                    <div class="shop-banner" style="height: 100px; background: url('{{ $seller->store_banner_url }}') center/cover; border-radius: 15px 15px 0 0;">
                    </div>
                    
                    <div class="card-body pt-0 px-4 pb-4 position-relative">
                        {{-- Logo --}}
                        <div class="shop-logo-wrapper">
                            <img src="{{ $seller->store_logo_url }}" class="shop-logo shadow-sm" alt="Logo">
                        </div>

                        <div class="mt-5 text-center">
                            <h5 class="font-w700 mb-1 text-dark">{{ $seller->store_name }}</h5>
                            <p class="text-muted small mb-3">{{ $seller->email }}</p>
                        </div>

                        <div class="shop-info-stats mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small font-w600">Status</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox" 
                                       data-id="{{ $seller->id }}"
                                       {{ $seller->status == 'active' ? 'checked' : '' }}
                                       style="cursor: pointer; transform: scale(1.2);">
                            </div>
                        </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted font-w600 small">Products</span>
                                <span class="badge rounded-pill bg-secondary px-3 py-2">0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-muted font-w600 small">Orders</span>
                                <span class="badge rounded-pill bg-secondary px-3 py-2">0</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.sellers.edit', $seller->id) }}" class="btn btn-outline-pink w-100 font-w600" style="border-radius: 8px;">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shop?')" class="w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger px-3" style="border-radius: 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm py-5" style="border-radius: 15px;">
                    <i class="bi bi-shop fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No shops registered yet.</h5>
                    <a href="{{ route('admin.sellers.create') }}" class="btn btn-pink btn-sm mt-3 px-4">Create First Shop</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .text-pink { color: #d63384 !important; }
    .btn-pink { background: #d63384; border-color: #d63384; color: #fff; }
    .btn-pink:hover { background: #c22d77; border-color: #c22d77; color: #fff; }
    .btn-outline-pink { color: #d63384; border-color: #d63384; }
    .btn-outline-pink:hover { background: #d63384; color: #fff; }
    
    .shop-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .shop-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .shop-logo-wrapper {
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 80px;
        background: #fff;
        border-radius: 12px;
        padding: 5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .shop-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .form-switch .form-check-input {
        background-color: #dee2e6;
        border-color: #dee2e6;
    }
    .form-switch .form-check-input:checked {
        background-color: #d63384;
        border-color: #d63384;
    }
    
    .font-w600 { font-weight: 600; }
    .font-w700 { font-weight: 700; }
</style>
@endsection

@push('scripts')
<script>
    $(document).on('change', '.status-toggle', function() {
        let userId = $(this).data('id');
        let _token = $('meta[name="csrf-token"]').attr('content');
        let $checkbox = $(this);

        $.ajax({
            url: "/admin/sellers/toggle-status/" + userId,
            type: "POST",
            data: {
                _token: _token
            },
            beforeSend: function() {
                $checkbox.prop('disabled', true);
            },
            success: function(response) {
                $checkbox.prop('disabled', false);
                if(response.status == 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error('Failed to update status');
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                }
            },
            error: function(xhr) {
                $checkbox.prop('disabled', false);
                $checkbox.prop('checked', !$checkbox.prop('checked'));
                let errorMsg = 'Something went wrong!';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                toastr.error(errorMsg);
            }
        });
    });
</script>
@endpush
