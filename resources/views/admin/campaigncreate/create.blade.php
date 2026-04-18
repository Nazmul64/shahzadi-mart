@extends('admin.master')

@section('main-content')

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
:root {
    --brand: #5b3cf5;
    --brand-light: #ede9ff;
    --brand-dark: #3d20d6;
    --surface: #ffffff;
    --surface-2: #f8f7fc;
    --border: rgba(91,60,245,.10);
    --border-2: rgba(91,60,245,.20);
    --text-1: #14112a;
    --text-2: #5c587a;
    --text-3: #9a96b5;
    --success: #16a34a;
    --success-bg: #dcfce7;
    --radius: 14px;
    --radius-sm: 8px;
    --shadow: 0 1px 3px rgba(20,17,42,.06), 0 6px 24px rgba(91,60,245,.07);
}
* { font-family: 'DM Sans', sans-serif; }
body { background: #f3f1fb !important; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
.page-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-1); margin: 0; }
.page-title span { display: block; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 400; color: var(--text-3); margin-top: 2px; }
.btn-manage { display: inline-flex; align-items: center; gap: 7px; background: var(--surface); color: var(--brand); font-size: 14px; font-weight: 500; padding: 9px 20px; border-radius: var(--radius-sm); text-decoration: none; border: 1px solid var(--border-2); transition: all .18s; }
.btn-manage:hover { background: var(--brand-light); border-color: var(--brand); color: var(--brand); text-decoration: none; }
.form-card { background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow); border: 1px solid var(--border); overflow: hidden; }
.form-section { padding: 28px 32px; border-bottom: 1px solid var(--border); }
.form-section:last-child { border-bottom: none; }
.section-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }
.form-label { font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 7px; display: block; }
.required-dot { color: #e11d48; margin-left: 2px; }
.form-control, .form-select { border: 1px solid var(--border-2); border-radius: var(--radius-sm); font-size: 14px; color: var(--text-1); padding: 10px 14px; height: auto; background: var(--surface); transition: border-color .18s, box-shadow .18s; }
.form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(91,60,245,.12); outline: none; }
.form-control.is-invalid, .form-select.is-invalid { border-color: #e11d48; }
.invalid-feedback { font-size: 12px; color: #e11d48; margin-top: 5px; }

/* Media Type Toggle Buttons */
.media-type-group { display: flex; gap: 12px; margin-bottom: 0; }
.media-type-btn { flex: 1; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 14px 20px; border: 2px solid var(--border-2); border-radius: var(--radius-sm); cursor: pointer; transition: all .2s; background: var(--surface-2); color: var(--text-2); font-size: 14px; font-weight: 500; }
.media-type-btn:hover { border-color: var(--brand); background: var(--brand-light); color: var(--brand); }
.media-type-btn.active { border-color: var(--brand); background: var(--brand-light); color: var(--brand); }
.media-type-btn.active .media-type-icon { background: var(--brand); color: #fff; }
.media-type-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--border-2); display: flex; align-items: center; justify-content: center; font-size: 15px; transition: all .2s; }

/* File upload */
.file-upload-area { position: relative; border: 1.5px dashed var(--border-2); border-radius: var(--radius-sm); background: var(--surface-2); padding: 14px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: border-color .18s, background .18s; }
.file-upload-area:hover { border-color: var(--brand); background: var(--brand-light); }
.file-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.file-upload-icon { width: 36px; height: 36px; background: var(--brand-light); border-radius: 7px; display: flex; align-items: center; justify-content: center; color: var(--brand); font-size: 14px; flex-shrink: 0; }
.file-upload-text { flex: 1; }
.file-upload-text strong { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); }
.file-upload-text span { font-size: 11px; color: var(--text-3); }
.file-upload-btn { background: var(--brand); color: #fff; font-size: 12px; font-weight: 500; padding: 6px 14px; border-radius: 6px; white-space: nowrap; }
.img-preview-box { margin-top: 10px; display: none; align-items: center; gap: 10px; }
.img-preview-box img { width: 64px; height: 48px; object-fit: cover; border-radius: 7px; border: 1px solid var(--border-2); }
.img-preview-box span { font-size: 12px; color: var(--text-3); }

/* Video URL input */
.url-input-wrap { position: relative; }
.url-input-wrap .url-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-3); font-size: 14px; }
.url-input-wrap input { padding-left: 36px; }

/* Video preview */
.video-preview-wrap { margin-top: 10px; display: none; }
.video-preview-wrap video { width: 100%; max-height: 200px; border-radius: var(--radius-sm); border: 1px solid var(--border-2); background: #000; }
.video-divider { display: flex; align-items: center; gap: 12px; margin: 16px 0; }
.video-divider span { font-size: 12px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .5px; white-space: nowrap; }
.video-divider::before, .video-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

/* Toggle */
.toggle-row { display: flex; align-items: center; gap: 14px; }
.toggle-wrap { position: relative; display: inline-block; width: 48px; height: 27px; }
.toggle-wrap input { opacity: 0; width: 0; height: 0; }
.toggle-track { position: absolute; cursor: pointer; inset: 0; background: #d1d5db; border-radius: 34px; transition: .25s; }
.toggle-wrap input:checked + .toggle-track { background: var(--brand); }
.toggle-knob { position: absolute; height: 21px; width: 21px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .25s; pointer-events: none; }
.toggle-wrap input:checked ~ .toggle-knob { transform: translateX(21px); }
.toggle-label { font-size: 13px; font-weight: 500; color: var(--text-2); }
.toggle-sub { font-size: 12px; color: var(--text-3); }

/* Footer */
.form-footer { display: flex; align-items: center; gap: 12px; padding: 24px 32px; background: var(--surface-2); border-top: 1px solid var(--border); }
.btn-save { display: inline-flex; align-items: center; gap: 8px; background: var(--brand); color: #fff; font-size: 14px; font-weight: 600; padding: 11px 28px; border-radius: var(--radius-sm); border: none; cursor: pointer; transition: background .18s, transform .15s, box-shadow .18s; box-shadow: 0 2px 8px rgba(91,60,245,.28); }
.btn-save:hover { background: var(--brand-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(91,60,245,.38); }
.btn-cancel { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: var(--text-2); font-size: 14px; font-weight: 500; padding: 11px 20px; border-radius: var(--radius-sm); border: 1px solid var(--border-2); cursor: pointer; text-decoration: none; transition: all .15s; }
.btn-cancel:hover { background: var(--surface-2); color: var(--text-1); text-decoration: none; }
.form-tip { margin-left: auto; font-size: 12px; color: var(--text-3); }
.form-tip span { color: #e11d48; }
.alert-errors { background: #fff1f2; border: 1px solid #fecdd3; border-radius: var(--radius-sm); padding: 14px 18px; margin-bottom: 20px; font-size: 13px; color: #be123c; }
.alert-errors ul { margin: 6px 0 0; padding-left: 18px; }
.note-editor.note-frame { border-radius: var(--radius-sm) !important; border: 1px solid var(--border-2) !important; }
.note-toolbar { background: var(--surface-2) !important; border-bottom: 1px solid var(--border) !important; border-radius: var(--radius-sm) var(--radius-sm) 0 0 !important; }

/* Animated section show/hide */
.media-fields { animation: fadeIn .25s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container-fluid py-1">

    <div class="page-header">
        <h4 class="page-title">
            Create Campaign
            <span>Fill in the details to launch a new landing page</span>
        </h4>
        <a href="{{ route('admin.campaigncreate.index') }}" class="btn-manage">
            <i class="fas fa-list-ul"></i> Manage Campaigns
        </a>
    </div>

    @if($errors->any())
    <div class="alert-errors">
        <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.campaigncreate.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <div class="form-section">
                <div class="section-label">Basic Information</div>
                <div class="mb-4">
                    <label class="form-label">Landing Page Title <span class="required-dot">*</span></label>
                    <input type="text" name="title" placeholder="e.g. Summer Sale Campaign"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-0">
                    <label class="form-label">Product <span class="required-dot">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                        <option value="">Select a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Media Type Selector --}}
            <div class="form-section">
                <div class="section-label">Media Type <span class="required-dot">*</span></div>
                <input type="hidden" name="media_type" id="media_type_input" value="{{ old('media_type', 'Image') }}">
                <div class="media-type-group">
                    <div class="media-type-btn {{ old('media_type', 'Image') === 'Image' ? 'active' : '' }}"
                         onclick="setMediaType('Image')">
                        <div class="media-type-icon"><i class="fas fa-image"></i></div>
                        <div>
                            <div style="font-weight:600;">Image</div>
                            <div style="font-size:11px;color:var(--text-3);margin-top:1px;">Upload JPG, PNG, WebP</div>
                        </div>
                    </div>
                    <div class="media-type-btn {{ old('media_type') === 'Video' ? 'active' : '' }}"
                         onclick="setMediaType('Video')">
                        <div class="media-type-icon"><i class="fas fa-video"></i></div>
                        <div>
                            <div style="font-weight:600;">Video</div>
                            <div style="font-size:11px;color:var(--text-3);margin-top:1px;">Upload file or paste URL</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image Fields --}}
            <div class="form-section media-fields" id="image_fields"
                 style="{{ old('media_type') === 'Video' ? 'display:none' : '' }}">
                <div class="section-label">Campaign Images</div>

                <div class="mb-4">
                    <label class="form-label">Primary Image <span class="required-dot">*</span></label>
                    <div class="file-upload-area" onclick="document.getElementById('image_input').click()">
                        <div class="file-upload-icon"><i class="fas fa-image"></i></div>
                        <div class="file-upload-text">
                            <strong id="image_name">Click to upload primary image</strong>
                            <span>PNG, JPG, WebP up to 2MB</span>
                        </div>
                        <span class="file-upload-btn">Browse</span>
                        <input type="file" id="image_input" name="image" accept="image/*"
                               onchange="previewFile(this, 'image_name', 'image_prev')">
                    </div>
                    <div class="img-preview-box" id="image_prev">
                        <img src="" alt=""><span>Preview</span>
                    </div>
                    @error('image')<div class="invalid-feedback d-block mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Secondary Image</label>
                        <div class="file-upload-area" onclick="document.getElementById('image_two_input').click()">
                            <div class="file-upload-icon"><i class="fas fa-images"></i></div>
                            <div class="file-upload-text">
                                <strong id="image_two_name">Upload secondary image</strong>
                                <span>Optional</span>
                            </div>
                            <input type="file" id="image_two_input" name="image_two" accept="image/*"
                                   onchange="previewFile(this, 'image_two_name', 'image_two_prev')">
                        </div>
                        <div class="img-preview-box" id="image_two_prev"><img src="" alt=""><span>Preview</span></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tertiary Image</label>
                        <div class="file-upload-area" onclick="document.getElementById('image_three_input').click()">
                            <div class="file-upload-icon"><i class="fas fa-clone"></i></div>
                            <div class="file-upload-text">
                                <strong id="image_three_name">Upload tertiary image</strong>
                                <span>Optional</span>
                            </div>
                            <input type="file" id="image_three_input" name="image_three" accept="image/*"
                                   onchange="previewFile(this, 'image_three_name', 'image_three_prev')">
                        </div>
                        <div class="img-preview-box" id="image_three_prev"><img src="" alt=""><span>Preview</span></div>
                    </div>
                </div>
            </div>

            {{-- Video Fields --}}
            <div class="form-section media-fields" id="video_fields"
                 style="{{ old('media_type') === 'Video' ? '' : 'display:none' }}">
                <div class="section-label">Campaign Video</div>

                <div class="mb-3">
                    <label class="form-label">Upload Video File</label>
                    <div class="file-upload-area" onclick="document.getElementById('video_input').click()">
                        <div class="file-upload-icon"><i class="fas fa-film"></i></div>
                        <div class="file-upload-text">
                            <strong id="video_name">Click to upload video</strong>
                            <span>MP4, MOV, AVI, WebM up to 50MB</span>
                        </div>
                        <span class="file-upload-btn">Browse</span>
                        <input type="file" id="video_input" name="video" accept="video/*"
                               onchange="previewVideo(this)">
                    </div>
                    <div class="video-preview-wrap" id="video_preview_wrap">
                        <video controls id="video_preview_player"></video>
                    </div>
                    @error('video')<div class="invalid-feedback d-block mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="video-divider"><span>OR</span></div>

                <div>
                    <label class="form-label">Video URL</label>
                    <div class="url-input-wrap">
                        <i class="fas fa-link url-icon"></i>
                        <input type="url" name="video_url" id="video_url"
                               class="form-control @error('video_url') is-invalid @enderror"
                               value="{{ old('video_url') }}"
                               placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div style="font-size:11px;color:var(--text-3);margin-top:5px;">
                        <i class="fas fa-info-circle me-1"></i> YouTube, Vimeo or any direct video URL
                    </div>
                </div>
            </div>

            {{-- Review --}}
            <div class="form-section">
                <div class="section-label">Review & Social Proof</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Review Text <span class="required-dot">*</span></label>
                        <input type="text" name="review" placeholder="e.g. 4.8/5 from 1,200+ customers"
                               class="form-control @error('review') is-invalid @enderror"
                               value="{{ old('review') }}">
                        @error('review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Review Image <span class="required-dot">*</span></label>
                        <div class="file-upload-area" onclick="document.getElementById('review_image_input').click()">
                            <div class="file-upload-icon"><i class="fas fa-star"></i></div>
                            <div class="file-upload-text">
                                <strong id="review_image_name">Upload review screenshot</strong>
                                <span>Required</span>
                            </div>
                            <input type="file" id="review_image_input" name="review_image" accept="image/*"
                                   onchange="previewFile(this, 'review_image_name', 'review_image_prev')">
                        </div>
                        <div class="img-preview-box" id="review_image_prev"><img src="" alt=""><span>Preview</span></div>
                        @error('review_image')<div class="invalid-feedback d-block mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="form-section">
                <div class="section-label">Page Content</div>
                <div class="mb-4">
                    <label class="form-label">Short Description</label>
                    <textarea name="short_description" id="short_description" class="form-control" rows="4">{{ old('short_description') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Full Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Status --}}
            <div class="form-section">
                <div class="section-label">Visibility</div>
                <div class="toggle-row">
                    <label class="toggle-wrap">
                        <input type="checkbox" name="status" value="1" {{ old('status', '1') ? 'checked' : '' }}>
                        <div class="toggle-track"></div>
                        <div class="toggle-knob"></div>
                    </label>
                    <div>
                        <div class="toggle-label">Campaign Active</div>
                        <div class="toggle-sub">When enabled, this campaign is publicly visible</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <button type="submit" class="btn-save">
                    <i class="fas fa-check"></i> Save Campaign
                </button>
                <a href="{{ route('admin.campaigncreate.index') }}" class="btn-cancel">Cancel</a>
                <div class="form-tip"><span>*</span> Required fields</div>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script>
const snConfig = { height: 150, placeholder: 'Enter your text here...', toolbar: [
    ['style',['bold','italic','underline','clear']],
    ['color',['color']],
    ['para',['ul','ol','paragraph']],
    ['table',['table']],
    ['insert',['link','picture']],
    ['misc',['fullscreen','codeview']],
]};
$('#short_description').summernote(snConfig);
$('#description').summernote({...snConfig, height: 180});

function setMediaType(type) {
    document.getElementById('media_type_input').value = type;
    document.querySelectorAll('.media-type-btn').forEach(btn => btn.classList.remove('active'));
    event.currentTarget.classList.add('active');

    if (type === 'Image') {
        document.getElementById('image_fields').style.display = '';
        document.getElementById('video_fields').style.display = 'none';
    } else {
        document.getElementById('image_fields').style.display = 'none';
        document.getElementById('video_fields').style.display = '';
    }
}

function previewFile(input, nameId, prevId) {
    const nameEl = document.getElementById(nameId);
    const prevEl = document.getElementById(prevId);
    if (input.files && input.files[0]) {
        nameEl.textContent = input.files[0].name;
        const reader = new FileReader();
        reader.onload = e => {
            prevEl.querySelector('img').src = e.target.result;
            prevEl.style.display = 'flex';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewVideo(input) {
    const nameEl = document.getElementById('video_name');
    const wrap   = document.getElementById('video_preview_wrap');
    const player = document.getElementById('video_preview_player');
    if (input.files && input.files[0]) {
        nameEl.textContent = input.files[0].name;
        player.src = URL.createObjectURL(input.files[0]);
        wrap.style.display = 'block';
    }
}
</script>

@endsection
