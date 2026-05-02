@extends('admin.master')

@section('main-content')

<div class="page-header">
    <div class="page-header__left">
        <h4 class="page-title">Footer Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Configuration</li>
                <li class="breadcrumb-item active" aria-current="page">Footer Settings</li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.footer-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- Brand Section --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-3">Brand Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Footer Logo</label>
                        <div class="logo-preview-box mb-2">
                            @if($setting->footer_logo)
                                <img src="{{ asset('uploads/avator/' . $setting->footer_logo) }}" id="logoPreview" class="img-thumbnail" style="max-height: 100px;">
                            @else
                                <div id="logoPreview" class="text-muted border p-3 text-center" style="max-height: 100px;">No Logo Uploaded</div>
                            @endif
                        </div>
                        <input type="file" name="footer_logo" class="form-control" onchange="previewImage(this, 'logoPreview')">
                        <small class="text-muted">Recommended: Transparent PNG, max 2MB. Saved to uploads/avator.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Footer Description</label>
                        <textarea name="footer_description" class="form-control" rows="3">{{ $setting->footer_description }}</textarea>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-3">Social Media Links</h5>
                    <div class="mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                            <input type="url" name="facebook_url" class="form-control" placeholder="Facebook URL" value="{{ $setting->facebook_url }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                            <input type="url" name="instagram_url" class="form-control" placeholder="Instagram URL" value="{{ $setting->instagram_url }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                            <input type="url" name="twitter_url" class="form-control" placeholder="Twitter URL" value="{{ $setting->twitter_url }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                            <input type="url" name="youtube_url" class="form-control" placeholder="YouTube URL" value="{{ $setting->youtube_url }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                            <input type="url" name="tiktok_url" class="form-control" placeholder="TikTok URL" value="{{ $setting->tiktok_url }}">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Copyright & Powered By --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-3">Copyright & Credits</h5>
                    <div class="mb-3">
                        <label class="form-label">Copyright Text</label>
                        <input type="text" name="copyright_text" class="form-control" value="{{ $setting->copyright_text }}">
                        <small class="text-muted">Example: Shahzadi-mart. All rights reserved.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Powered By Text</label>
                        <input type="text" name="powered_by_text" class="form-control" value="{{ $setting->powered_by_text }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Powered By URL</label>
                        <input type="url" name="powered_by_link" class="form-control" value="{{ $setting->powered_by_link }}">
                    </div>
                </div>

                {{-- Payment Methods --}}
                <div class="col-12 col-md-6">
                    <h5 class="mb-3">Enabled Payment Methods</h5>
                    <div class="row g-2">
                        @php
                            $methods = ['VISA', 'M-PESA', 'PAYPAL', 'MASTERCARD', 'AIRTEL'];
                            $enabledMethods = $setting->payment_methods ?? [];
                        @endphp
                        @foreach($methods as $method)
                        <div class="col-6 col-sm-4">
                            <div class="form-check card p-2">
                                <input class="form-check-input ms-1" type="checkbox" name="payment_methods[]" value="{{ $method }}" id="pay_{{ $method }}" {{ in_array($method, $enabledMethods) ? 'checked' : '' }}>
                                <label class="form-check-label ms-4" for="pay_{{ $method }}">
                                    {{ $method }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                        <i class="fas fa-save me-1"></i> Save All Settings
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
.page-header { display: flex; justify-content: space-between; margin-bottom: 25px; }
.page-title { font-weight: 800; color: #0b1121; }
.card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.form-label { font-weight: 600; color: #475569; font-size: 14px; }
.input-group-text { background: #f8fafc; border-color: #e2e8f0; color: #64748b; }
.form-control { border-radius: 8px; border-color: #e2e8f0; padding: 10px 15px; }
.form-control:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); border-color: #3b82f6; }
.btn-primary { background: #0b1121; border: none; border-radius: 8px; transition: all 0.3s; }
.btn-primary:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(11, 17, 33, 0.2); }
.logo-preview-box { background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; min-height: 120px; }
.form-check.card { cursor: pointer; transition: 0.2s; border: 1px solid #e2e8f0; }
.form-check.card:hover { border-color: #3b82f6; background: #f0f9ff; }
.breadcrumb-item a { color: #64748b; text-decoration: none; }
</style>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 100px;">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
