@extends('saller.master')

@section('main-content')
<div class="page-content bg-light pb-5">
    <div class="container-fluid px-lg-5">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
            <div>
                <h4 class="mb-1 fw-bold text-dark">
                    @if(request()->routeIs('saller.digital_products.index'))
                        Digital Products
                    @else
                        All Products
                    @endif
                </h4>
                <p class="text-muted small mb-0">Total {{ $products->count() }} products found in your inventory (A-Z sorted)</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('saller.digital_products.create') }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill shadow-sm bg-white">
                    <i class="bi bi-cloud-plus me-1"></i> Add Digital
                </a>
                <a href="{{ route('saller.products.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add Physical
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-check2-circle text-success fs-5"></i>
                    </div>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Product Grid --}}
        <div class="row g-4" id="product_grid">
            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 product-card transition-all">
                        {{-- Product Image --}}
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('uploads/products/'.$product->feature_image) }}" 
                                 class="w-100 h-100 object-fit-cover transition-all" alt="{{ $product->name }}">
                            
                            @if($product->product_type == 'digital' || $product->product_type == 'license')
                                <span class="position-absolute top-2 end-2 badge rounded-pill bg-info shadow-sm" style="font-size: 9px; right: 10px; top: 10px;">DIGITAL</span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate">{{ $product->name }}</h6>
                            <p class="text-muted small mb-3 text-truncate-2" style="height: 32px; line-height: 1.2;">
                                {{ strip_tags($product->short_description) }}
                            </p>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="pricing">
                                    <span class="fw-bold text-danger">৳{{ number_format($product->current_price, 0) }}</span>
                                    @if($product->discount_price)
                                        <span class="text-muted text-decoration-line-through ms-1" style="font-size: 11px;">৳{{ number_format($product->discount_price, 0) }}</span>
                                    @endif
                                </div>
                                <div class="stock">
                                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $product->stock > 0 ? 'text-success' : 'text-danger' }} rounded-pill" style="font-size: 10px;">
                                        {{ $product->stock ?? 0 }} In Stock
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <div class="form-check form-switch p-0 m-0">
                                    <input class="form-check-input status-toggle m-0" type="checkbox" 
                                           data-id="{{ $product->id }}" 
                                           {{ $product->status === 'active' ? 'checked' : '' }}
                                           style="cursor: pointer; width: 36px; height: 18px;">
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('saller.products.show', $product->id) }}" class="btn btn-sm btn-light rounded-circle shadow-xs" title="View"><i class="bi bi-eye text-primary"></i></a>
                                    <a href="{{ route('saller.products.barcode', $product->id) }}" class="btn btn-sm btn-light rounded-circle shadow-xs" title="Barcode"><i class="bi bi-upc-scan text-dark"></i></a>
                                    <a href="{{ route('saller.products.edit', $product->id) }}" class="btn btn-sm btn-light rounded-circle shadow-xs" title="Edit"><i class="bi bi-pencil text-success"></i></a>
                                    <form action="{{ route('saller.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-xs" title="Delete"><i class="bi bi-trash3 text-danger"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="opacity-25 mb-3">
                    <h5 class="text-muted">No Products Found</h5>
                    <a href="{{ route('saller.products.create') }}" class="btn btn-primary rounded-pill px-4 mt-3">Add Product</a>
                </div>
            @endforelse
        </div>
</div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .table thead th { border-top: 0; font-size: 11px; padding: 12px 10px; }
    .table tbody td { padding: 12px 10px; }
    .table tbody tr:hover { background-color: #f8fafc; }
    .dropdown-item:hover { background-color: #f1f5f9; color: #2563eb; }
    .badge { letter-spacing: 0.3px; font-size: 10px; }
    .form-switch .form-check-input:checked { background-color: #10b981; border-color: #10b981; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.status-toggle').on('change', function() {
        var productId = $(this).data('id');
        var isChecked = $(this).is(':checked');
        var label = $('.status-label-' + productId);
        
        $.ajax({
            url: '/saller/products/' + productId + '/status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.new_status === 'active') {
                    label.text('Live').removeClass('text-warning').addClass('text-success');
                } else {
                    label.text('Pending').removeClass('text-success').addClass('text-warning');
                }
            },
            error: function() {
                alert('Something went wrong!');
                $(this).prop('checked', !isChecked);
            }
        });
    });
});
</script>

@endsection

