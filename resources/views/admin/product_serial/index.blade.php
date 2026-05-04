@extends('admin.master')
@section('title', 'Product Serial / Priority')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product Serial / Priority</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage Product Priority</h3>
                            <div class="card-tools">
                                <form action="{{ route('admin.product-serial.index') }}" method="GET">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right" placeholder="Search products..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <form action="{{ route('admin.product-serial.update') }}" method="POST">
                                @csrf
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Pin Product</th>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>SKU</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                        <tr @if($product->is_pinned) style="background-color: #f4f6f9;" @endif>
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" name="pinned_products[]" value="{{ $product->id }}" id="pin_{{ $product->id }}" {{ $product->is_pinned ? 'checked' : '' }}>
                                                    <label for="pin_{{ $product->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <img src="{{ asset('uploads/products/' . $product->feature_image) }}" alt="" style="width: 40px; height: 40px; object-fit: contain;">
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($product->name, 40) }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>
                                                @if($product->is_pinned)
                                                    <span class="badge badge-success"><i class="fas fa-thumbtack"></i> Pinned First</span>
                                                @else
                                                    <span class="badge badge-secondary">Normal</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No products found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                
                                <div class="mt-3 ml-3 mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Serials</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
