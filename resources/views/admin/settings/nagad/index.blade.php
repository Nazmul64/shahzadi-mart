@extends('admin.master')

@section('main-content')
<style>
    .nagad-setup-card {
        background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 40px; max-width: 900px; margin: 0 auto;
    }
    .nagad-header {
        display: flex; align-items: center; gap: 15px; margin-bottom: 30px; border-bottom: 1px solid #f0f2f5; padding-bottom: 20px;
    }
    .nagad-header h4 { font-weight: 700; color: #2d3748; margin: 0; }
    .nagad-header .back-btn { color: #718096; text-decoration: none; font-size: 20px; }

    .form-group-row {
        display: flex; margin-bottom: 25px; align-items: flex-start;
    }
    .form-label-col {
        width: 240px; font-weight: 600; color: #4a5568; font-size: 14px; padding-top: 10px;
    }
    .form-input-col {
        flex: 1; position: relative;
    }
    .form-control-custom {
        border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; width: 100%; font-size: 14px; color: #2d3748; transition: all 0.2s;
    }
    .form-control-custom:focus {
        border-color: #3182ce; box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1); outline: none;
    }
    
    .status-switch {
        display: flex; align-items: center; gap: 10px; cursor: pointer;
    }
    .status-switch input { width: 18px; height: 18px; cursor: pointer; }
    
    .info-icon {
        color: #a0aec0; cursor: help; margin-left: 8px; font-size: 14px;
    }
    
    .btn-save-nagad {
        background: #3182ce; color: #fff; border: none; padding: 12px 40px; border-radius: 8px; font-weight: 700; cursor: pointer; transition: background 0.2s;
    }
    .btn-save-nagad:hover { background: #2c5282; }

    .logo-preview {
        width: 120px; height: 120px; border: 2px dashed #e2e8f0; border-radius: 12px; margin-top: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc;
    }
    .logo-preview img { max-width: 100%; max-height: 100%; object-fit: contain; }
</style>

<div class="p-4">
    <div class="nagad-setup-card">
        <div class="nagad-header">
            <a href="{{ route('admin.dashboard') }}" class="back-btn"><i class="bi bi-chevron-left"></i></a>
            <div>
                <h4>Nagad Payment Gateway</h4>
                <p class="text-muted small m-0">Please fill up the form</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.nagad.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Status --}}
            <div class="form-group-row">
                <div class="form-label-col">Enable/Disable</div>
                <div class="form-input-col">
                    <label class="status-switch">
                        <input type="checkbox" name="status" {{ ($setting->status ?? 0) ? 'checked' : '' }}>
                        <span style="font-weight: 400; color: #4a5568;">Enable Nagad</span>
                    </label>
                </div>
            </div>

            {{-- Mode --}}
            <div class="form-group-row">
                <div class="form-label-col">Run Mode</div>
                <div class="form-input-col">
                    <select name="mode" class="form-control-custom">
                        <option value="live" {{ ($setting->mode ?? '') == 'live' ? 'selected' : '' }}>Live</option>
                        <option value="sandbox" {{ ($setting->mode ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                    </select>
                </div>
            </div>

            {{-- Title --}}
            <div class="form-group-row">
                <div class="form-label-col">Title</div>
                <div class="form-input-col">
                    <input type="text" name="title" value="{{ $setting->title ?? 'Nagad' }}" class="form-control-custom" placeholder="e.g. Nagad">
                </div>
            </div>

            {{-- Merchant ID --}}
            <div class="form-group-row">
                <div class="form-label-col">Merchant ID</div>
                <div class="form-input-col">
                    <input type="text" name="merchant_id" value="{{ $setting->merchant_id ?? '' }}" class="form-control-custom" placeholder="Enter Merchant ID">
                </div>
            </div>

            {{-- Private Key --}}
            <div class="form-group-row">
                <div class="form-label-col">Merchant Private Key</div>
                <div class="form-input-col">
                    <textarea name="merchant_private_key" class="form-control-custom" rows="4" placeholder="-----BEGIN RSA PRIVATE KEY-----">{{ $setting->merchant_private_key ?? '' }}</textarea>
                </div>
            </div>

            {{-- Public Key --}}
            <div class="form-group-row">
                <div class="form-label-col">Nagad Gateway Server Public Key</div>
                <div class="form-input-col">
                    <textarea name="nagad_public_key" class="form-control-custom" rows="4" placeholder="-----BEGIN PUBLIC KEY-----">{{ $setting->nagad_public_key ?? '' }}</textarea>
                </div>
            </div>

            {{-- Logo --}}
            <div class="form-group-row">
                <div class="form-label-col">
                    Brand Logo
                    <i class="bi bi-question-circle-fill info-icon" title="Upload a 128x128 PNG for best results"></i>
                </div>
                <div class="form-input-col">
                    <input type="file" name="logo" class="form-control-custom" onchange="previewImage(this)">
                    <div class="logo-preview" id="preview-container">
                        @if($setting && $setting->logo)
                            <img src="{{ asset('uploads/nogad/' . $setting->logo) }}" alt="Nagad Logo">
                        @else
                            <div class="text-muted small">No Image Selected</div>
                        @endif
                    </div>
                    <p class="small text-muted mt-2">Images will be stored in <code>uploads/nogad</code></p>
                </div>
            </div>

            <div class="form-group-row mt-4">
                <div class="form-label-col"></div>
                <div class="form-input-col">
                    <button type="submit" class="btn-save-nagad">
                        Save Configuration
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const container = document.getElementById('preview-container');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
