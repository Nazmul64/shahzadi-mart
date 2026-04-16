@extends('admin.master')

@section('main-content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Success / Error Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body" style="background:#fff; border-radius:8px;">
                    <h5 class="mb-4 font-weight-bold" style="font-size:18px;">SMS Gateway</h5>

                    @if($smsgateway)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted small">Url <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $smsgateway->url }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">API Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $smsgateway->api_key }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Senderid <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $smsgateway->sender_id }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <p class="mb-1 small text-muted">Status</p>
                            <div class="custom-toggle {{ $smsgateway->status ? 'active' : '' }}"></div>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1 small text-muted">Order confirm</p>
                            <div class="custom-toggle {{ $smsgateway->order_confirm ? 'active' : '' }}"></div>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1 small text-muted">Forgot password</p>
                            <div class="custom-toggle {{ $smsgateway->forgot_password ? 'active' : '' }}"></div>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1 small text-muted">Password Generator</p>
                            <div class="custom-toggle {{ $smsgateway->password_generator ? 'active' : '' }}"></div>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('admin.Smsgatewaysetup.edit', $smsgateway->id) }}"
                           class="btn btn-success px-4"
                           style="background-color:#28b89e; border-color:#28b89e; border-radius:5px;">
                            Edit
                        </a>
                    </div>

                    @else
                    <p class="text-muted">No SMS Gateway configured yet.</p>
                    <a href="{{ route('admin.Smsgatewaysetup.create') }}"
                       class="btn btn-success px-4"
                       style="background-color:#28b89e; border-color:#28b89e; border-radius:5px;">
                        + Add Gateway
                    </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Toggle Switch Display */
.custom-toggle {
    width: 48px;
    height: 26px;
    background-color: #ccc;
    border-radius: 50px;
    position: relative;
    cursor: default;
}
.custom-toggle::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 20px;
    height: 20px;
    background: #fff;
    border-radius: 50%;
    transition: 0.3s;
}
.custom-toggle.active {
    background-color: #28b89e;
}
.custom-toggle.active::after {
    left: calc(100% - 23px);
}
</style>

@endsection
