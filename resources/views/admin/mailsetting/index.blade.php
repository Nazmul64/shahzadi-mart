@extends('admin.master')

@section('main-content')

<div class="page-header">
    <div class="page-header__left">
        <h4 class="page-title">Mail Configuration</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active" aria-current="page">Mail Configuration</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Send Test Mail Section --}}
    <div class="col-12">
        <div class="card mail-card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-send me-2 text-primary"></i>Send Test Mail
                </h6>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.mail.test') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-600">To / Recipient Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="Recipient's Email" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-600">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Message to be sent" required>This is a test email to verify the mail configuration.</textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm">
                                <i class="bi bi-send-fill me-1"></i> Send Email
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Mail Configuration Section --}}
    <div class="col-12">
        <div class="card mail-card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-gear me-2 text-primary"></i>Mail Configuration
                </h6>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.mail.update') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail Mailer</label>
                            <input type="text" name="mail_mailer" class="form-control rounded-3" value="{{ old('mail_mailer', $setting->mail_mailer ?? 'smtp') }}" placeholder="smtp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail Host</label>
                            <input type="text" name="mail_host" class="form-control rounded-3" value="{{ old('mail_host', $setting->mail_host ?? '') }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail Port</label>
                            <input type="text" name="mail_port" class="form-control rounded-3" value="{{ old('mail_port', $setting->mail_port ?? '587') }}" placeholder="587">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail User Name</label>
                            <input type="text" name="mail_username" class="form-control rounded-3" value="{{ old('mail_username', $setting->mail_username ?? '') }}" placeholder="User Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail Password</label>
                            <div class="input-group">
                                <input type="password" name="mail_password" id="mail_password" class="form-control border-end-0 rounded-start-3" placeholder="Leave blank to keep current password">
                                <span class="input-group-text bg-white border-start-0 rounded-end-3" style="cursor: pointer;" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="password_toggle_icon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail Encryption</label>
                            <select name="mail_encryption" class="form-select rounded-3">
                                <option value="tls" {{ (old('mail_encryption', $setting->mail_encryption ?? '') == 'tls') ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ (old('mail_encryption', $setting->mail_encryption ?? '') == 'ssl') ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ (old('mail_encryption', $setting->mail_encryption ?? '') == 'none') ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail From Address <span class="text-danger">*</span></label>
                            <input type="email" name="mail_from_address" class="form-control rounded-3" value="{{ old('mail_from_address', $setting->mail_from_address ?? '') }}" placeholder="noreply@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Mail From Name</label>
                            <input type="text" name="mail_from_name" class="form-control rounded-3" value="{{ old('mail_from_name', $setting->mail_from_name ?? '') }}" placeholder="Site Name">
                        </div>
                        <div class="col-12 text-end pt-2">
                            <button type="submit" class="btn btn-danger rounded-pill px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-1"></i> Save And Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 { font-weight: 600; }
    .mail-card { transition: all 0.3s ease; }
    .mail-card:hover { transform: translateY(-2px); }
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
    }
    .page-header { margin-bottom: 24px; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 18px; line-height: 1; vertical-align: middle; }
</style>

<script>
    function togglePassword() {
        const passInput = document.getElementById('mail_password');
        const icon = document.getElementById('password_toggle_icon');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

@endsection
