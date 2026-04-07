@extends('admin.master')

@section('main-content')

<style>
    .product-thumb { width: 52px; height: 44px; object-fit: cover; border-radius: 5px; border: 1px solid #e9ecef; }
    .badge-stock   { font-size: 11px; padding: 4px 8px; border-radius: 20px; }
    .action-btn    { width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 5px; }
    .price-main    { font-weight: 700; color: #2d3e6e; font-size: 14px; }
    .price-old     { font-size: 11px; text-decoration: line-through; color: #dc3545; }
    .sku-badge     { background: #f1f3f9; color: #2d3e6e; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-family: monospace; font-weight: 600; }
    .form-switch .form-check-input { width: 2.2em; height: 1.2em; cursor: pointer; }
    .form-switch .form-check-input:checked { background-color: #2d3e6e; border-color: #2d3e6e; }
    .card          { border: none; box-shadow: 0 0 10px rgba(0,0,0,.07); border-radius: 10px; }
    .table thead th { font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; font-weight: 600; border-bottom: 2px solid #f0f0f0; }
    .table tbody td { vertical-align: middle; font-size: 13px; border-color: #f5f5f5; }
    .table tbody tr:hover { background: #f8f9ff; }
    .affiliate-link { font-size: 11px; color: #2d3e6e; }
    .affiliate-link:hover { text-decoration: underline; }
    .empty-state   { padding: 50px 0; }
    .empty-state i { font-size: 48px; color: #dee2e6; }
    .no-img-thumb  { width: 52px; height: 44px; border-radius: 5px; border: 1px dashed #dee2e6; background: #f8f9fa; display: inline-flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 18px; }
</style>

<div class="container-fluid">

    {{-- Breadcrumb --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Affiliate Products</h4>
                <div class="page-title-right d-flex align-items-center gap-2">
                    <ol class="breadcrumb m-0 me-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Affiliate Products</li>
                    </ol>
                    <a href="{{ route('affiliateproduct.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus me-1"></i> Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row mb-3">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary bg-soft text-primary rounded-circle font-size-20">
                            <i class="mdi mdi-package-variant"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:12px;">Total Products</p>
                        <h5 class="mb-0 fw-bold">{{ $products->total() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success bg-soft text-success rounded-circle font-size-20">
                            <i class="mdi mdi-check-circle"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:12px;">Active</p>
                        <h5 class="mb-0 fw-bold">{{ \App\Models\AffiliateProduct::where('status','active')->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning bg-soft text-warning rounded-circle font-size-20">
                            <i class="mdi mdi-pause-circle"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:12px;">Inactive</p>
                        <h5 class="mb-0 fw-bold">{{ \App\Models\AffiliateProduct::where('status','inactive')->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body py-3 d-flex align-items-center gap-3">
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger bg-soft text-danger rounded-circle font-size-20">
                            <i class="mdi mdi-alert-circle"></i>
                        </span>
                    </div>
                    <div>
                        <p class="text-muted mb-0" style="font-size:12px;">Out of Stock</p>
                        <h5 class="mb-0 fw-bold">{{ \App\Models\AffiliateProduct::where('product_stock', 0)->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="card-title mb-0 fw-semibold">All Affiliate Products</h5>
                    <span class="badge bg-primary bg-soft text-primary">{{ $products->total() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="45">#</th>
                                    <th width="60">Image</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th width="90" class="text-center">Status</th>
                                    <th width="110" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $key => $product)
                                <tr>
                                    <td class="ps-3 text-muted">{{ $products->firstItem() + $key }}</td>

                                    {{--
                                        ✅ IMAGE FIX — Windows backslash সমস্যাও handle করে
                                        DB তে থাকে  : uploads/products/filename.jpg
                                        দেখাতে হয়  : asset('uploads/products/filename.jpg')
                                        Backslash থাকলে: str_replace দিয়ে forward slash করো
                                    --}}
                                    <td>
                                        @php
                                            $imgSrc = null;
                                            if (!empty($product->feature_image)) {
                                                $rawPath = $product->feature_image;

                                                if (str_starts_with($rawPath, 'http://') || str_starts_with($rawPath, 'https://')) {
                                                    // External URL — সরাসরি use করো
                                                    $imgSrc = $rawPath;
                                                } else {
                                                    // Local path — backslash থাকলে forward slash এ convert করো
                                                    $cleanPath = str_replace('\\', '/', $rawPath);
                                                    $imgSrc    = asset($cleanPath);
                                                }
                                            }
                                        @endphp

                                        @if($imgSrc)
                                            <img src="{{ $imgSrc }}"
                                                 alt="{{ $product->product_name }}"
                                                 class="product-thumb"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                            <span class="no-img-thumb" style="display:none;">
                                                <i class="mdi mdi-image-off"></i>
                                            </span>
                                        @else
                                            <span class="no-img-thumb">
                                                <i class="mdi mdi-image-off"></i>
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="fw-semibold mb-1" style="font-size:13px;">
                                            {{ Str::limit($product->product_name, 40) }}
                                        </div>
                                        <span class="sku-badge me-1">{{ $product->product_sku }}</span>
                                        @if($product->product_affiliate_link)
                                            <a href="{{ $product->product_affiliate_link }}" target="_blank"
                                               class="affiliate-link">
                                                <i class="mdi mdi-link-variant"></i> Link
                                            </a>
                                        @endif
                                    </td>

                                    <td>
                                        <div style="font-size:12px;">
                                            {{ optional($product->category)->name ?? '—' }}
                                            @if($product->subCategory)
                                                <br><span class="text-muted">↳ {{ $product->subCategory->sub_name ?? '' }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="price-main">${{ number_format($product->current_price, 2) }}</div>
                                        @if($product->discount_price)
                                            <div class="price-old">${{ number_format($product->discount_price, 2) }}</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($product->product_stock === null)
                                            <span class="badge bg-success badge-stock">Always Available</span>
                                        @elseif($product->product_stock > 0)
                                            <span class="badge bg-info badge-stock">{{ $product->product_stock }} left</span>
                                        @else
                                            <span class="badge bg-danger badge-stock">Out of Stock</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center mb-0">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                   role="switch"
                                                   data-id="{{ $product->id }}"
                                                   {{ $product->status === 'active' ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('affiliateproduct.show', $product->id) }}"
                                           class="btn btn-sm btn-soft-info action-btn me-1" title="View">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('affiliateproduct.edit', $product->id) }}"
                                           class="btn btn-sm btn-soft-warning action-btn me-1" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-soft-danger action-btn btn-delete"
                                                data-id="{{ $product->id }}" title="Delete">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                        <form id="delete-form-{{ $product->id }}"
                                              action="{{ route('affiliateproduct.destroy', $product->id) }}"
                                              method="POST" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state text-center">
                                            <i class="mdi mdi-package-variant-closed d-block mb-3"></i>
                                            <p class="text-muted mb-2">No affiliate products found.</p>
                                            <a href="{{ route('affiliateproduct.create') }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="mdi mdi-plus me-1"></i> Add First Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                        <small class="text-muted">
                            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results
                        </small>
                        {{ $products->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function () {

    // ── Status Toggle ──────────────────────────────────────────────
    $(document).on('change', '.status-toggle', function () {
        var id  = $(this).data('id');
        var $el = $(this);
        $.post('/admin/affiliateproduct/' + id + '/toggle-status', {
            _token: '{{ csrf_token() }}'
        })
        .done(function () {
            toastr.success('Status updated successfully!');
        })
        .fail(function () {
            $el.prop('checked', !$el.prop('checked'));
            toastr.error('Something went wrong!');
        });
    });

    // ── Delete ─────────────────────────────────────────────────────
    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete Product?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $('#delete-form-' + id).submit();
            }
        });
    });

});
</script>
@endpush
