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

{{-- ── Site Configuration ───────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-edit me-2"></i>Site Name</h6>
                <form action="{{ route('admin.Generalsettings.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="form-label fw-600">Website Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $setting->site_name) }}" placeholder="Enter website name..." required>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Save Name
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-th-large me-2"></i>Layout & Menu Settings</h6>
                <form action="{{ route('admin.Generalsettings.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Hidden input to keep site_name unchanged --}}
                    <input type="hidden" name="site_name" value="{{ $setting->site_name }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Category Menu Display</label>
                                <select name="category_menu_type" class="form-select">
                                    <option value="fixed" {{ $setting->category_menu_type == 'fixed' ? 'selected' : '' }}>Fixed (Always Visible)</option>
                                    <option value="hover" {{ $setting->category_menu_type == 'hover' ? 'selected' : '' }}>Hover (Animated Header Button)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Site Layout Width</label>
                                <select name="site_layout_width" class="form-select">
                                    <option value="boxed" {{ $setting->site_layout_width == 'boxed' ? 'selected' : '' }}>Boxed (With Side Gaps)</option>
                                    <option value="full-width" {{ $setting->site_layout_width == 'full-width' ? 'selected' : '' }}>Full Width (Edge to Edge)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Products Per Row (Desktop)</label>
                                <select name="products_per_row" class="form-select">
                                    @foreach([2, 3, 4, 5, 6] as $num)
                                        <option value="{{ $num }}" {{ $setting->products_per_row == $num ? 'selected' : '' }}>{{ $num }} Products</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="fas fa-sync-alt me-1"></i> Update Layout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Theme & Typography ───────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-palette me-2"></i> Theme & Typography Settings</h6>
                <form action="{{ route('admin.Generalsettings.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Primary Color (General Accents)</label>
                                <input type="color" name="primary_color" class="form-control form-control-color w-100" value="{{ $setting->primary_color }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Button Background Color</label>
                                <input type="color" name="button_bg_color" class="form-control form-control-color w-100" value="{{ $setting->button_bg_color }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Button Text Color</label>
                                <input type="color" name="button_text_color" class="form-control form-control-color w-100" value="{{ $setting->button_text_color }}">
                            </div>
                        </div>
                        
                        <div class="col-md-12"><hr></div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Top Header Background</label>
                                <input type="color" name="top_header_bg_color" class="form-control form-control-color w-100" value="{{ $setting->top_header_bg_color }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Top Header Text Color</label>
                                <input type="color" name="top_header_text_color" class="form-control form-control-color w-100" value="{{ $setting->top_header_text_color }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Main Header Background</label>
                                <input type="color" name="main_header_bg_color" class="form-control form-control-color w-100" value="{{ $setting->main_header_bg_color }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Main Header Text Color</label>
                                <input type="color" name="main_header_text_color" class="form-control form-control-color w-100" value="{{ $setting->main_header_text_color }}">
                            </div>
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Footer Background Color</label>
                                <input type="color" name="footer_color" class="form-control form-control-color w-100" value="{{ $setting->footer_color }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Footer Text Color</label>
                                <input type="color" name="footer_text_color" class="form-control form-control-color w-100" value="{{ $setting->footer_text_color }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Base Font Size (px)</label>
                                <input type="number" name="font_size" class="form-control" value="{{ $setting->font_size }}" min="10" max="24">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Font Family</label>
                                <select name="font_family" class="form-select">
                                    <option value="Plus Jakarta Sans" {{ $setting->font_family == 'Plus Jakarta Sans' ? 'selected' : '' }}>Plus Jakarta Sans (Modern)</option>
                                    <option value="'Inter', sans-serif" {{ $setting->font_family == "'Inter', sans-serif" ? 'selected' : '' }}>Inter (Clean)</option>
                                    <option value="'Roboto', sans-serif" {{ $setting->font_family == "'Roboto', sans-serif" ? 'selected' : '' }}>Roboto (Classic)</option>
                                    <option value="'Outfit', sans-serif" {{ $setting->font_family == "'Outfit', sans-serif" ? 'selected' : '' }}>Outfit (Premium)</option>
                                    <option value="'Poppins', sans-serif" {{ $setting->font_family == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Trendy)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Category Circles Display</label>
                                <select name="category_slider_status" class="form-select">
                                    <option value="1" {{ $setting->category_slider_status == 1 ? 'selected' : '' }}>Auto Slider (Horizontal)</option>
                                    <option value="0" {{ $setting->category_slider_status == 0 ? 'selected' : '' }}>Grid Stacking (Multiple Rows)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="fas fa-save me-1"></i> Save Theme Settings
                    </button>
                </form>
                <form action="{{ route('admin.Generalsettings.reset') }}" method="POST" onsubmit="return confirm('Reset all theme settings to default?')" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger px-4">
                        <i class="fas fa-undo me-1"></i> Reset to Default
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Image Configuration ───────────────────────────────────────────── --}}
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-images me-2"></i> Image & Slider Configuration</h6>
                <form action="{{ route('admin.Generalsettings.update', $setting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Category Image Width (px)</label>
                                <input type="number" name="category_img_width" class="form-control" value="{{ $setting->category_img_width }}" min="40" max="300">
                                <small class="text-muted">Default: 80px</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Category Image Height (px)</label>
                                <input type="number" name="category_img_height" class="form-control" value="{{ $setting->category_img_height }}" min="40" max="300">
                                <small class="text-muted">Default: 80px</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Category Image Shape</label>
                                <select name="category_img_shape" class="form-select">
                                    <option value="circle" {{ $setting->category_img_shape == 'circle' ? 'selected' : '' }}>Circle (Rounded)</option>
                                    <option value="square" {{ $setting->category_img_shape == 'square' ? 'selected' : '' }}>Square (Box)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Slider Item Margin (px)</label>
                                <input type="number" name="category_slider_margin" class="form-control" value="{{ $setting->category_slider_margin }}" min="0" max="50">
                                <small class="text-muted">Space between categories</small>
                            </div>
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Global Product Image Height (px)</label>
                                <input type="number" name="product_img_height" class="form-control" value="{{ $setting->product_img_height }}" min="150" max="600">
                                <small class="text-muted">Used in product grids across all pages. Default: 280px</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 text-danger"><i class="fas fa-mobile-alt me-1"></i> Mobile Product Image Height (px)</label>
                            <input type="number" name="product_img_height_mobile" class="form-control" value="{{ $setting->product_img_height_mobile }}" min="100" max="400">
                            <small class="text-muted">Proportional height for mobile grid. Default: 160px</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600 text-danger"><i class="fas fa-mobile-alt me-1"></i> Mobile Product Font Size (px)</label>
                            <input type="number" name="product_font_size_mobile" class="form-control" value="{{ $setting->product_font_size_mobile }}" min="8" max="20">
                            <small class="text-muted">Title font size for mobile. Default: 12px</small>
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Product Image Fit</label>
                                <select name="product_img_fit" class="form-select">
                                    <option value="cover" {{ $setting->product_img_fit == 'cover' ? 'selected' : '' }}>Cover (Fill container, may crop)</option>
                                    <option value="contain" {{ $setting->product_img_fit == 'contain' ? 'selected' : '' }}>Contain (Show full image, no cropping)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-600">Show Rating Stars</label>
                                <select name="show_rating_stars" class="form-select">
                                    <option value="1" {{ $setting->show_rating_stars == 1 ? 'selected' : '' }}>Show Stars (Default)</option>
                                    <option value="0" {{ $setting->show_rating_stars == 0 ? 'selected' : '' }}>Hide Stars Globally</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="fas fa-save me-1"></i> Save Image & Feature Settings
                    </button>
                </form>
                <form action="{{ route('admin.Generalsettings.reset') }}" method="POST" onsubmit="return confirm('Reset image and theme settings to default?')" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger px-4">
                        <i class="fas fa-undo me-1"></i> Reset Images & Theme
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


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
                                    {{ $setting?->site_name ?? 'Your Logo' }}
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
