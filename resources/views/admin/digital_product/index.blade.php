@extends('admin.master')

@section('main-content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Digital Products</h4>
                    <p class="mb-0">Manage your digital assets and software products</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('admin.digital-products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Digital Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('uploads/products/'.$product->feature_image) }}" 
                                                 alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        </td>
                                        <td>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small class="text-muted">SKU: {{ $product->sku }}</small>
                                        </td>
                                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                        <td>
                                            @if($product->discount_price)
                                                <span class="text-primary">৳{{ number_format($product->discount_price, 2) }}</span><br>
                                                <del class="text-muted" style="font-size: 11px;">৳{{ number_format($product->current_price, 2) }}</del>
                                            @else
                                                ৳{{ number_format($product->current_price, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.digital-products.status', $product->id) }}" 
                                               class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($product->status) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin.digital-products.edit', $product->id) }}" 
                                                   class="btn btn-primary shadow btn-xs sharp mr-1"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('admin.digital-products.destroy', $product->id) }}" 
                                                      method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
