@extends('admin.master')

@section('main-content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold mb-0">Pathao Courier - Add Settings</h5>
        <a href="{{ route('admin.pathaocourier.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card mb-4" style="border-radius: 8px;">
        <div class="card-body p-4">

            {{-- Info Box --}}
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i>
                <strong>Sandbox credentials</strong> দিয়ে আগে test করুন।
                Live এ যেতে <strong>base_url</strong> পরিবর্তন করুন এবং merchant account এর real credentials দিন।
            </div>

            <form action="{{ route('admin.pathaocourier.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Base URL --}}
                    <div class="col-md-12 mb-3">
                        <label for="base_url">
                            Base URL <span class="text-danger">*</span>
                        </label>
                        <input
                            type="url"
                            name="base_url"
                            id="base_url"
                            class="form-control @error('base_url') is-invalid @enderror"
                            value="{{ old('base_url', 'https://courier-api-sandbox.pathao.com') }}"
                            placeholder="https://courier-api-sandbox.pathao.com"
                        >
                        @error('base_url')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">
                            <strong>Sandbox:</strong> https://courier-api-sandbox.pathao.com &nbsp;|&nbsp;
                            <strong>Live:</strong> https://api-hermes.pathao.com
                        </small>
                    </div>

                    {{-- Client ID --}}
                    <div class="col-md-6 mb-3">
                        <label for="client_id">
                            Client ID <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="client_id"
                            id="client_id"
                            class="form-control @error('client_id') is-invalid @enderror"
                            value="{{ old('client_id') }}"
                            placeholder="7N1aMJQbWm"
                        >
                        @error('client_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Pathao merchant dashboard থেকে পাবেন</small>
                    </div>

                    {{-- Client Secret --}}
                    <div class="col-md-6 mb-3">
                        <label for="client_secret">
                            Client Secret <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="client_secret"
                                id="client_secret"
                                class="form-control @error('client_secret') is-invalid @enderror"
                                value="{{ old('client_secret') }}"
                                placeholder="wRcaibZkUdSNz2EI9Zyu..."
                            >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="toggleVisibility('client_secret', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('client_secret')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="col-md-6 mb-3">
                        <label for="username">
                            Username <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            placeholder="test@pathao.com"
                        >
                        @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Pathao merchant account এর email</small>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label for="password">
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="lovePathao"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="toggleVisibility('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Pathao merchant account এর password</small>
                    </div>

                    {{-- Grant Type --}}
                    <div class="col-md-6 mb-3">
                        <label for="grant_type">
                            Grant Type <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="grant_type"
                            id="grant_type"
                            class="form-control @error('grant_type') is-invalid @enderror"
                            value="{{ old('grant_type', 'password') }}"
                            placeholder="password"
                        >
                        @error('grant_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">সাধারণত <code>password</code> হয়</small>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label>Status</label><br>
                        <div class="custom-control custom-switch mt-2">
                            <input
                                type="checkbox"
                                name="status"
                                class="custom-control-input"
                                id="pathao_status"
                                checked
                            >
                            <label class="custom-control-label" for="pathao_status">Active</label>
                        </div>
                    </div>

                </div>

                <hr>

                <button type="submit" class="btn btn-success px-4"
                        style="background-color:#2ec4b6; border-color:#2ec4b6;">
                    <i class="fas fa-save"></i> Save Settings
                </button>
                <a href="{{ route('admin.pathaocourier.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times"></i> Cancel
                </a>

            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function toggleVisibility(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush

@endsection
