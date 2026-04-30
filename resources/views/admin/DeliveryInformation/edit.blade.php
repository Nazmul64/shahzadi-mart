@extends('admin.master')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Delivery Information</h4>
                    <a href="{{ route('admin.DeliveryInformation.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.DeliveryInformation.update', $deliveryInfo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Header --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Header</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Header Title</label>
                                    <input type="text" name="header_title"
                                           class="form-control @error('header_title') is-invalid @enderror"
                                           value="{{ old('header_title', $deliveryInfo->header_title) }}"
                                           placeholder="Enter header title">
                                    @error('header_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Home Delivery --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Home Delivery</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="home_delivery_title"
                                           class="form-control @error('home_delivery_title') is-invalid @enderror"
                                           value="{{ old('home_delivery_title', $deliveryInfo->home_delivery_title) }}"
                                           placeholder="Enter title">
                                    @error('home_delivery_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="home_delivery_description" rows="3"
                                              class="form-control @error('home_delivery_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('home_delivery_description', $deliveryInfo->home_delivery_description) }}</textarea>
                                    @error('home_delivery_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Pickup --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Pickup Facility</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="pickup_title"
                                           class="form-control @error('pickup_title') is-invalid @enderror"
                                           value="{{ old('pickup_title', $deliveryInfo->pickup_title) }}"
                                           placeholder="Enter title">
                                    @error('pickup_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="pickup_description" rows="3"
                                              class="form-control @error('pickup_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('pickup_description', $deliveryInfo->pickup_description) }}</textarea>
                                    @error('pickup_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Instant Download --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Instant Download</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="instant_download_title"
                                           class="form-control @error('instant_download_title') is-invalid @enderror"
                                           value="{{ old('instant_download_title', $deliveryInfo->instant_download_title) }}"
                                           placeholder="Enter title">
                                    @error('instant_download_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="instant_download_description" rows="3"
                                              class="form-control @error('instant_download_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('instant_download_description', $deliveryInfo->instant_download_description) }}</textarea>
                                    @error('instant_download_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Secure Payment --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Secure Payment</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="secure_title"
                                           class="form-control @error('secure_title') is-invalid @enderror"
                                           value="{{ old('secure_title', $deliveryInfo->secure_title) }}"
                                           placeholder="Enter title">
                                    @error('secure_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="secure_description" rows="3"
                                              class="form-control @error('secure_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('secure_description', $deliveryInfo->secure_description) }}</textarea>
                                    @error('secure_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Cash on Delivery --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Cash on Delivery (COD)</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="cod_title"
                                           class="form-control @error('cod_title') is-invalid @enderror"
                                           value="{{ old('cod_title', $deliveryInfo->cod_title) }}"
                                           placeholder="Enter title">
                                    @error('cod_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="cod_description" rows="3"
                                              class="form-control @error('cod_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('cod_description', $deliveryInfo->cod_description) }}</textarea>
                                    @error('cod_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Banking --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Mobile Banking</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="mobile_banking_title"
                                           class="form-control @error('mobile_banking_title') is-invalid @enderror"
                                           value="{{ old('mobile_banking_title', $deliveryInfo->mobile_banking_title) }}"
                                           placeholder="Enter title">
                                    @error('mobile_banking_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="mobile_banking_description" rows="3"
                                              class="form-control @error('mobile_banking_description') is-invalid @enderror"
                                              placeholder="Enter description">{{ old('mobile_banking_description', $deliveryInfo->mobile_banking_description) }}</textarea>
                                    @error('mobile_banking_description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Footer Company Information --}}
                        <div class="card mb-3">
                            <div class="card-header"><strong>Footer</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Company Information</label>
                                    <textarea name="footer_company_information" rows="4"
                                              class="form-control @error('footer_company_information') is-invalid @enderror"
                                              placeholder="Enter company information">{{ old('footer_company_information', $deliveryInfo->footer_company_information) }}</textarea>
                                    @error('footer_company_information')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.DeliveryInformation.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
