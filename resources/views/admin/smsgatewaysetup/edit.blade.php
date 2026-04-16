@extends('admin.master')

@section('main-content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body" style="background:#fff; border-radius:8px;">
                    <h5 class="mb-4 font-weight-bold" style="font-size:18px;">SMS Gateway</h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.Smsgatewaysetup.update', $smsgateway->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Row 1: URL, API Key, Sender ID -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="small font-weight-medium" for="url">
                                    Url <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="url"
                                    name="url"
                                    class="form-control @error('url') is-invalid @enderror"
                                    value="{{ old('url', $smsgateway->url) }}"
                                    placeholder="https://msg.elitbuzz-bd.com/smsapi"
                                >
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="small font-weight-medium" for="api_key">
                                    API Key <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="api_key"
                                    name="api_key"
                                    class="form-control @error('api_key') is-invalid @enderror"
                                    value="{{ old('api_key', $smsgateway->api_key) }}"
                                    placeholder="Your API Key"
                                >
                                @error('api_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="small font-weight-medium" for="sender_id">
                                    Senderid <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="sender_id"
                                    name="sender_id"
                                    class="form-control @error('sender_id') is-invalid @enderror"
                                    value="{{ old('sender_id', $smsgateway->sender_id) }}"
                                    placeholder="8809612472619"
                                >
                                @error('sender_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Toggle Switches -->
                        <div class="row mb-4">
                            <!-- Status -->
                            <div class="col-md-3">
                                <p class="mb-1 small text-muted">Status</p>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="status" value="1"
                                        {{ old('status', $smsgateway->status) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <!-- Order Confirm -->
                            <div class="col-md-3">
                                <p class="mb-1 small text-muted">Order confirm</p>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="order_confirm" value="1"
                                        {{ old('order_confirm', $smsgateway->order_confirm) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <!-- Forgot Password -->
                            <div class="col-md-3">
                                <p class="mb-1 small text-muted">Forgot password</p>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="forgot_password" value="1"
                                        {{ old('forgot_password', $smsgateway->forgot_password) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <!-- Password Generator -->
                            <div class="col-md-3">
                                <p class="mb-1 small text-muted">Password Generator</p>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="password_generator" value="1"
                                        {{ old('password_generator', $smsgateway->password_generator) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="btn px-4"
                                style="background-color:#28b89e; color:#fff; border-radius:5px;">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.smsgatewaysetup.smsgatewaysetup_toggle_style')

@endsection
