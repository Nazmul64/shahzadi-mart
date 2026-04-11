@extends('admin.master')

@section('main-content')

{{-- ── Page Header ─────────────────────────────────────────────── --}}
<div class="page-header">
    <div class="page-header__left">
        <h4 class="page-title">Website Logo</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">General Settings</li>
                <li class="breadcrumb-item active" aria-current="page">Website Logo</li>
            </ol>
        </nav>
    </div>
</div>

{{-- ── Flash Alerts ─────────────────────────────────────────────── --}}
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

{{-- ── Validation Errors ────────────────────────────────────────── --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ── Logo Cards ───────────────────────────────────────────────── --}}
<div class="card logo-wrapper">
    <div class="card-body p-4">
        <div class="row g-4">

            {{-- ── Helper macro: renders one logo card ── --}}
            @foreach([
                ['type' => 'header_logo',  'label' => 'Header Logo',  'preview_id' => 'previewHeader'],
                ['type' => 'footer_logo',  'label' => 'Footer Logo',  'preview_id' => 'previewFooter'],
                ['type' => 'invoice_logo', 'label' => 'Invoice Logo', 'preview_id' => 'previewInvoice'],
            ] as $logo)

            <div class="col-12 col-md-4">
                <div class="logo-card">

                    {{-- Head --}}
                    <div class="logo-card__head">
                        <h6 class="logo-card__title">{{ $logo['label'] }}</h6>
                    </div>

                    {{-- Body --}}
                    <div class="logo-card__body">

                        {{-- Preview --}}
                        <div class="logo-preview" id="{{ $logo['preview_id'] }}">
                            @if($setting->{$logo['type']})
                                <img src="{{ asset($setting->{$logo['type']}) }}"
                                     alt="{{ $logo['label'] }}"
                                     class="logo-img">
                            @else
                                <span class="logo-placeholder">
                                    {{ $setting->site_name ?? 'Your Logo' }}
                                </span>
                            @endif
                        </div>

                        {{-- Upload form --}}
                        <form action="{{ route('admin.Generalsettings.upload-logo') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="logo-form">
                            @csrf
                            <input type="hidden" name="logo_type" value="{{ $logo['type'] }}">

                            <div class="file-input-wrap">
                                <input type="file"
                                       name="logo"
                                       id="file_{{ $logo['type'] }}"
                                       accept="image/*"
                                       class="file-input"
                                       onchange="previewLogo(this, '{{ $logo['preview_id'] }}')">
                            </div>

                            <button type="submit" class="btn-logo-submit">
                                <i class="fas fa-upload me-1"></i> Upload
                            </button>
                        </form>

                        {{-- Delete form (only shown when logo exists) --}}
                        @if($setting->{$logo['type']})
                            <form action="{{ route('admin.Generalsettings.delete-logo') }}"
                                  method="POST"
                                  class="mt-2"
                                  onsubmit="return confirm('Remove {{ $logo['label'] }}?')">
                                @csrf
                                <input type="hidden" name="logo_type" value="{{ $logo['type'] }}">
                                <button type="submit" class="btn-logo-delete">
                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                </button>
                            </form>
                        @endif

                    </div>{{-- /logo-card__body --}}
                </div>{{-- /logo-card --}}
            </div>{{-- /col --}}

            @endforeach

        </div>{{-- /row --}}
    </div>
</div>

{{-- ── Styles ───────────────────────────────────────────────────── --}}
<style>
/* Page header */
.page-header {
    display         : flex;
    align-items     : flex-start;
    justify-content : space-between;
    margin-bottom   : 22px;
}
.page-title {
    font-size   : 20px;
    font-weight : 700;
    color       : #1e2a4a;
    margin      : 0 0 4px;
}
.breadcrumb {
    background : none;
    padding    : 0;
    margin     : 0;
    font-size  : 13px;
}
.breadcrumb-item a { color: #1e2a4a; text-decoration: none; }
.breadcrumb-item a:hover { text-decoration: underline; }
.breadcrumb-item.active { color: #6c757d; }
.breadcrumb-item + .breadcrumb-item::before { content: '›'; color: #aaa; }

/* Card wrapper */
.logo-wrapper {
    border        : 1px solid #e3e8f0;
    border-radius : 8px;
    box-shadow    : 0 1px 4px rgba(0,0,0,.05);
}

/* Individual logo card */
.logo-card {
    border        : 1px solid #dce3ee;
    border-radius : 6px;
    overflow      : hidden;
    height        : 100%;
}
.logo-card__head {
    background    : #eef1f7;
    padding       : 12px 16px;
    border-bottom : 1px solid #dce3ee;
    text-align    : center;
}
.logo-card__title {
    font-size   : 15px;
    font-weight : 600;
    color       : #1e2a4a;
    margin      : 0;
}
.logo-card__body {
    padding         : 24px 20px 20px;
    display         : flex;
    flex-direction  : column;
    align-items     : center;
    gap             : 16px;
    background      : #fff;
}

/* Preview box */
.logo-preview {
    width       : 100%;
    min-height  : 90px;
    display     : flex;
    align-items : center;
    justify-content: center;
    background  : #f8f9fb;
    border      : 1px dashed #d0d7e2;
    border-radius: 6px;
    padding     : 12px;
}
.logo-img {
    max-width    : 180px;
    max-height   : 80px;
    object-fit   : contain;
    border-radius: 4px;
}
.logo-placeholder {
    font-size      : 22px;
    font-weight    : 800;
    color          : #c4cad6;
    letter-spacing : -.02em;
    font-family    : Georgia, serif;
    text-align     : center;
}

/* Upload form */
.logo-form {
    width           : 100%;
    display         : flex;
    flex-direction  : column;
    align-items     : center;
    gap             : 14px;
}
.file-input-wrap { width: 100%; display: flex; justify-content: center; }
.file-input { font-size: 13px; color: #444; cursor: pointer; width: 100%; }
.file-input::-webkit-file-upload-button {
    background    : #fff;
    border        : 1px solid #aaa;
    border-radius : 3px;
    padding       : 4px 10px;
    font-size     : 12px;
    cursor        : pointer;
    margin-right  : 8px;
    color         : #333;
}
.file-input::-webkit-file-upload-button:hover { background: #f0f0f0; }

/* Submit button */
.btn-logo-submit {
    background    : #1e2a4a;
    color         : #fff;
    border        : none;
    border-radius : 5px;
    padding       : 9px 32px;
    font-size     : 14px;
    font-weight   : 600;
    cursor        : pointer;
    transition    : background .2s, transform .15s;
    width         : 100%;
    max-width     : 180px;
}
.btn-logo-submit:hover  { background: #162038; transform: translateY(-1px); }
.btn-logo-submit:active { transform: translateY(0); }

/* Delete button */
.btn-logo-delete {
    background    : transparent;
    border        : 1px solid #dc3545;
    color         : #dc3545;
    border-radius : 5px;
    padding       : 6px 20px;
    font-size     : 12px;
    font-weight   : 600;
    cursor        : pointer;
    transition    : background .2s, color .2s;
    width         : 100%;
    max-width     : 180px;
}
.btn-logo-delete:hover { background: #dc3545; color: #fff; }
</style>

{{-- ── Script ────────────────────────────────────────────────────── --}}
<script>
function previewLogo(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        preview.innerHTML =
            '<img src="' + e.target.result + '" alt="Preview" class="logo-img">';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>

@endsection
