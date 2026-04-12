@extends('admin.master')

@section('main-content')

{{-- ── Page Header ─────────────────────────────────────────────── --}}
<div class="page-header">
    <div class="page-header__left">
        <h4 class="page-title">Website Favicon</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">General Settings</li>
                <li class="breadcrumb-item active" aria-current="page">Website Favicon</li>
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

{{-- ── Favicon Card ─────────────────────────────────────────────── --}}
<div class="card favicon-wrapper">
    <div class="card-body p-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="favicon-card">

                    {{-- Head --}}
                    <div class="favicon-card__head">
                        <h6 class="favicon-card__title">Favicon</h6>
                    </div>

                    {{-- Body --}}
                    <div class="favicon-card__body">

                        {{-- Preview --}}
                        <div class="favicon-preview" id="previewFavicon">
                            @if($setting->favicon_logo)
                                <img src="{{ asset($setting->favicon_logo) }}"
                                     alt="Favicon"
                                     class="favicon-img">
                            @else
                                <span class="favicon-placeholder">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                    <small class="d-block mt-1 text-muted">No favicon set</small>
                                </span>
                            @endif
                        </div>

                        <p class="favicon-hint">
                            Recommended: <strong>32×32</strong> or <strong>64×64</strong> px
                            &nbsp;|&nbsp; .ico / .png / .svg
                        </p>

                        {{-- ✅ Upload form — route name: admin.websitefavicon.upload-logo --}}
                        <form action="{{ route('admin.websitefavicon.upload-logo') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="favicon-form">
                            @csrf

                            <div class="file-input-wrap">
                                <input type="file"
                                       name="logo"
                                       id="file_favicon"
                                       accept=".ico,.png,.jpg,.jpeg,.gif,.svg,.webp"
                                       class="file-input"
                                       onchange="previewFaviconFn(this)">
                            </div>

                            <button type="submit" class="btn-favicon-submit">
                                <i class="fas fa-upload me-1"></i> Upload
                            </button>
                        </form>

                        {{-- ✅ Delete form — route name: admin.websitefavicon.delete-logo --}}
                        @if($setting->favicon_logo)
                            <form action="{{ route('admin.websitefavicon.delete-logo') }}"
                                  method="POST"
                                  class="mt-2"
                                  onsubmit="return confirm('Remove favicon?')">
                                @csrf
                                <button type="submit" class="btn-favicon-delete">
                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                </button>
                            </form>
                        @endif

                    </div>{{-- /favicon-card__body --}}
                </div>{{-- /favicon-card --}}
            </div>
        </div>
    </div>
</div>

{{-- ── Styles ───────────────────────────────────────────────────── --}}
<style>
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
.breadcrumb-item a                          { color: #1e2a4a; text-decoration: none; }
.breadcrumb-item a:hover                    { text-decoration: underline; }
.breadcrumb-item.active                     { color: #6c757d; }
.breadcrumb-item + .breadcrumb-item::before { content: '›'; color: #aaa; }

.favicon-wrapper {
    border        : 1px solid #e3e8f0;
    border-radius : 8px;
    box-shadow    : 0 1px 4px rgba(0,0,0,.05);
}
.favicon-card {
    border        : 1px solid #dce3ee;
    border-radius : 6px;
    overflow      : hidden;
}
.favicon-card__head {
    background    : #eef1f7;
    padding       : 12px 16px;
    border-bottom : 1px solid #dce3ee;
    text-align    : center;
}
.favicon-card__title {
    font-size   : 15px;
    font-weight : 600;
    color       : #1e2a4a;
    margin      : 0;
}
.favicon-card__body {
    padding        : 24px 20px 20px;
    display        : flex;
    flex-direction : column;
    align-items    : center;
    gap            : 14px;
    background     : #fff;
}
.favicon-preview {
    width           : 100px;
    height          : 100px;
    display         : flex;
    align-items     : center;
    justify-content : center;
    background      : #f8f9fb;
    border          : 1px dashed #d0d7e2;
    border-radius   : 6px;
    padding         : 8px;
}
.favicon-img {
    max-width     : 80px;
    max-height    : 80px;
    object-fit    : contain;
    border-radius : 4px;
}
.favicon-placeholder {
    text-align  : center;
    line-height : 1.4;
}
.favicon-hint {
    font-size  : 12px;
    color      : #888;
    margin     : 0;
    text-align : center;
}
.favicon-form {
    width          : 100%;
    display        : flex;
    flex-direction : column;
    align-items    : center;
    gap            : 12px;
}
.file-input-wrap { width: 100%; display: flex; justify-content: center; }
.file-input      { font-size: 13px; color: #444; cursor: pointer; width: 100%; }
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
.btn-favicon-submit {
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
.btn-favicon-submit:hover  { background: #162038; transform: translateY(-1px); }
.btn-favicon-submit:active { transform: translateY(0); }
.btn-favicon-delete {
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
.btn-favicon-delete:hover { background: #dc3545; color: #fff; }
</style>

{{-- ── Script ────────────────────────────────────────────────────── --}}
<script>
function previewFaviconFn(input) {
    const preview = document.getElementById('previewFavicon');
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const ext  = file.name.split('.').pop().toLowerCase();

    if (ext === 'ico') {
        preview.innerHTML =
            '<span class="favicon-placeholder">' +
            '<i class="fas fa-file-image fa-2x text-muted"></i>' +
            '<small class="d-block mt-1 text-muted">' + file.name + '</small>' +
            '</span>';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.innerHTML =
            '<img src="' + e.target.result + '" alt="Preview" class="favicon-img">';
    };
    reader.readAsDataURL(file);
}
</script>

@endsection
