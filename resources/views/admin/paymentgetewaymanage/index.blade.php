@extends('admin.master')

@section('main-content')

<div class="container-fluid py-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ===================== BKASH SECTION ===================== --}}
    <div class="gateway-section mb-4">
        <h5 class="gateway-title">Bkash</h5>

        <div class="card gateway-card">
            <div class="card-body p-4">
                @if($bkash)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">User Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $bkash->username }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">App Key <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $bkash->app_key }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">App Secret <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $bkash->app_secret }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Base Url <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $bkash->base_url }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $bkash->password }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input gateway-toggle" type="checkbox" role="switch"
                                   data-id="{{ $bkash->id }}"
                                   {{ $bkash->status ? 'checked' : '' }}
                                   style="width:3rem; height:1.5rem; cursor:pointer;">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.paymentgetewaymanage.edit', $bkash->id) }}"
                       class="btn btn-bkash">Submit</a>
                </div>
                @else
                <p class="text-muted mb-2">No Bkash configuration found.</p>
                <a href="{{ route('admin.paymentgetewaymanage.create') }}?gateway=bkash"
                   class="btn btn-bkash">Add Bkash</a>
                @endif
            </div>
        </div>
    </div>

    {{-- ===================== SHURJOPAY SECTION ===================== --}}
    <div class="gateway-section mb-4">
        <h5 class="gateway-title">Shurjopay</h5>

        <div class="card gateway-card">
            <div class="card-body p-4">
                @if($shurjopay)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">User Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->username }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Prefix <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->prefix }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Success Url <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->success_url }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Return Url <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->return_url }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Base Url <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->base_url }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $shurjopay->password }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input gateway-toggle" type="checkbox" role="switch"
                                   data-id="{{ $shurjopay->id }}"
                                   {{ $shurjopay->status ? 'checked' : '' }}
                                   style="width:3rem; height:1.5rem; cursor:pointer;">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.paymentgetewaymanage.edit', $shurjopay->id) }}"
                       class="btn btn-shurjopay">Submit</a>
                </div>
                @else
                <p class="text-muted mb-2">No Shurjopay configuration found.</p>
                <a href="{{ route('admin.paymentgetewaymanage.create') }}?gateway=shurjopay"
                   class="btn btn-shurjopay">Add Shurjopay</a>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- ===================== STYLES ===================== --}}
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

    .form-control[readonly] {
        background-color: #fff;
    }

    .form-label {
        font-size: 0.85rem;
        color: #343a40;
        margin-bottom: 0.4rem;
    }

    /* Toggle switch color — blue when active */
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Bkash submit button — teal/green */
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

    /* Shurjopay submit button — indigo/purple */
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

{{-- ===================== SCRIPTS ===================== --}}
<script>
document.querySelectorAll('.gateway-toggle').forEach(function (toggle) {
    toggle.addEventListener('change', function () {
        const id = this.dataset.id;
        fetch(`/admin/paymentgetewaymanage/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            console.log('Status updated:', data.status);
        })
        .catch(err => console.error(err));
    });
});
</script>

@endsection
