@extends('admin.master')

@section('main-content')

<div class="container-fluid py-4">

    {{-- ===================== BKASH CREATE SECTION ===================== --}}
    <div class="gateway-section mb-4">
        <h5 class="gateway-title">Bkash</h5>

        <div class="card gateway-card">
            <div class="card-body p-4">
                <form action="{{ route('admin.paymentgetewaymanage.store') }}" method="POST" id="bkash-form">
                    @csrf
                    <input type="hidden" name="gateway_name" value="bkash">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">User Name <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   placeholder="01738154732" value="{{ old('username') }}">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">App Key <span class="text-danger">*</span></label>
                            <input type="text" name="app_key" class="form-control @error('app_key') is-invalid @enderror"
                                   placeholder="C7MNfvn3jhMEFqFI4TdnYUe5tc" value="{{ old('app_key') }}">
                            @error('app_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">App Secret <span class="text-danger">*</span></label>
                            <input type="text" name="app_secret" class="form-control @error('app_secret') is-invalid @enderror"
                                   placeholder="1NnVYeRbCzv0FUV8gOycidcPV5ZEmyK8u8wlvM0rRztavTIlerfN" value="{{ old('app_secret') }}">
                            @error('app_secret') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Base Url <span class="text-danger">*</span></label>
                            <input type="text" name="base_url" class="form-control @error('base_url') is-invalid @enderror"
                                   placeholder="https://tokenized.pay.bka.sh/v1.2.0-beta" value="{{ old('base_url') }}">
                            @error('base_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Fr);2u[5W8C" value="{{ old('password') }}">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold d-block">Status</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="status" value="1" checked
                                       style="width:3rem; height:1.5rem; cursor:pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-bkash">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== SHURJOPAY CREATE SECTION ===================== --}}
    <div class="gateway-section mb-4">
        <h5 class="gateway-title">Shurjopay</h5>

        <div class="card gateway-card">
            <div class="card-body p-4">
                <form action="{{ route('admin.paymentgetewaymanage.store') }}" method="POST" id="shurjopay-form">
                    @csrf
                    <input type="hidden" name="gateway_name" value="shurjopay">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">User Name <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   placeholder="sp_sandbox" value="{{ old('username') }}">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Prefix <span class="text-danger">*</span></label>
                            <input type="text" name="prefix" class="form-control @error('prefix') is-invalid @enderror"
                                   placeholder="NOK" value="{{ old('prefix') }}">
                            @error('prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Success Url <span class="text-danger">*</span></label>
                            <input type="text" name="success_url" class="form-control @error('success_url') is-invalid @enderror"
                                   placeholder="https://ecom.websolutionit.com/payment-success" value="{{ old('success_url') }}">
                            @error('success_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Return Url <span class="text-danger">*</span></label>
                            <input type="text" name="return_url" class="form-control @error('return_url') is-invalid @enderror"
                                   placeholder="https://ecom.websolutionit.com/payment-cancel" value="{{ old('return_url') }}">
                            @error('return_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Base Url <span class="text-danger">*</span></label>
                            <input type="text" name="base_url" class="form-control @error('base_url') is-invalid @enderror"
                                   placeholder="https://sandbox.shurjopayment.com" value="{{ old('base_url') }}">
                            @error('base_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="pyyk97hu&6u6" value="{{ old('password') }}">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold d-block">Status</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       name="status" value="1" checked
                                       style="width:3rem; height:1.5rem; cursor:pointer;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-shurjopay">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
    .gateway-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.75rem;
    }

    .gateway-card {
        border: none;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
    }

    .form-control {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #495057;
        background-color: #fff;
        padding: 0.5rem 0.75rem;
    }

    .form-label {
        font-size: 0.85rem;
        color: #343a40;
        margin-bottom: 0.4rem;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-bkash {
        background-color: #1dbfaf;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.45rem 1.4rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-bkash:hover {
        background-color: #17a89a;
        color: #fff;
    }

    .btn-shurjopay {
        background-color: #5c5fc7;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.45rem 1.4rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .btn-shurjopay:hover {
        background-color: #4a4db5;
        color: #fff;
    }

    body {
        background-color: #f4f6f8;
    }
</style>

@endsection
