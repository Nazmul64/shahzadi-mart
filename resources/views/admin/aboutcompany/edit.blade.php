@extends('admin.master')

@section('main-content')

<style>
.acf-wrapper { padding: 24px; background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
.acf-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.acf-topbar h2 { font-size: 19px; font-weight: 700; color: #2d3748; margin: 0; }
.acf-breadcrumb { font-size: 12px; color: #aaa; margin-top: 3px; }

.acf-card { background: #fff; border-radius: 10px; box-shadow: 0 1px 5px rgba(0,0,0,.06); padding: 24px; margin-bottom: 20px; }
.acf-card-title {
    font-size: 13px; font-weight: 700; color: #1a2b6b;
    text-transform: uppercase; letter-spacing: .7px;
    margin-bottom: 18px; padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
    display: flex; align-items: center; gap: 8px;
}
.acf-label { font-size: .86rem; font-weight: 600; color: #2d3748; margin-bottom: 5px; display: block; }
.acf-hint  { font-size: .75rem; color: #a0aec0; margin-top: 4px; display: block; }
.optional  { font-size: .7rem; background: #e2e8f0; color: #718096; border-radius: 10px; padding: 2px 7px; margin-left: 5px; font-weight: 500; }

/* ── Image Upload Box ── */
.img-upload-box {
    border: 2px dashed #cbd5e0; border-radius: 10px;
    min-height: 150px; background: #f8f9fa;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    cursor: pointer; transition: border-color .2s; overflow: hidden;
}
.img-upload-box:hover { border-color: #1a2b6b; }
.img-upload-box .img-placeholder { text-align: center; color: #a0aec0; padding: 16px; }
.img-upload-box .img-placeholder i { font-size: 32px; display: block; margin-bottom: 6px; }
.img-upload-box .img-placeholder span { font-size: 12px; }
.banner-box { min-height: 180px; }

/* ── Existing image preview ── */
.existing-img-wrap { position: relative; margin-bottom: 10px; }
.existing-img { width: 100%; border-radius: 8px; border: 1px solid #e9ecef; }
.existing-img.banner { height: 150px; object-fit: cover; }
.existing-img.thumb  { height: 120px; object-fit: contain; background: #f8f9fa; padding: 6px; }
.img-delete-btn {
    position: absolute; top: 6px; right: 6px;
    background: #e53e3e; color: #fff; border: none;
    border-radius: 6px; padding: 4px 10px; font-size: 11px;
    font-weight: 600; cursor: pointer; display: flex;
    align-items: center; gap: 4px;
}
.img-delete-btn:hover { background: #c53030; }
.img-label-tag {
    display: inline-block; font-size: 11px; background: #e9ecef;
    color: #4a5568; border-radius: 4px; padding: 2px 8px; margin-bottom: 8px;
}

/* ── Buttons ── */
.btn-acf { border: none; border-radius: 22px; padding: 10px 26px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: opacity .2s; }
.btn-acf:hover { opacity: .85; }
.btn-save   { background: #1a2b6b; color: #fff; }
.btn-cancel { background: #e2e8f0; color: #4a5568; }

/* ── Social ── */
.social-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
.social-row .social-icon { width: 36px; height: 36px; border-radius: 8px; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #4a5568; flex-shrink: 0; }
.social-row input { flex: 1; }

.two-col   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.three-col { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 14px; }
@media (max-width: 768px) {
    .two-col { grid-template-columns: 1fr; }
    .three-col { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="acf-wrapper">

    {{-- Topbar --}}
    <div class="acf-topbar">
        <div>
            <h2><i class="bi bi-pencil-square me-2" style="color:#1a2b6b;"></i>Edit Company Information</h2>
            <div class="acf-breadcrumb">Dashboard › Company Information › Edit</div>
        </div>
        <a href="{{ route('admin.aboutcompany.index') }}" class="btn-acf btn-cancel">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 20px;border-radius:8px;margin-bottom:16px;font-size:13px;color:#276749;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#fff5f5;border-left:4px solid #e53e3e;padding:12px 20px;border-radius:8px;margin-bottom:16px;font-size:13px;color:#c53030;">
            <strong><i class="bi bi-exclamation-circle me-1"></i>Error:</strong>
            <ul style="margin:6px 0 0;padding-left:18px;">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.aboutcompany.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- ════ LEFT ════ --}}
            <div class="col-lg-8">

                {{-- Basic Info --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-building"></i> Basic Information</div>

                    <div class="mb-3">
                        <label class="acf-label">Company Name *</label>
                        <input type="text" name="company_name" class="form-control"
                               placeholder="e.g. Shahzadi Mart Ltd." value="{{ old('company_name', $about->company_name) }}">
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Tagline <span class="optional">Optional</span></label>
                        <input type="text" name="tagline" class="form-control"
                               placeholder="e.g. Your Trusted Online Shop" value="{{ old('tagline', $about->tagline) }}">
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Short Description <span class="optional">Optional</span></label>
                        <textarea name="short_description" class="form-control" rows="3"
                                  placeholder="Hero section এর জন্য...">{{ old('short_description', $about->short_description) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="acf-label">About Description <span class="optional">Optional</span></label>
                        <textarea name="about_description" class="form-control" rows="6"
                                  placeholder="Company সম্পর্কে বিস্তারিত...">{{ old('about_description', $about->about_description) }}</textarea>
                    </div>
                </div>

                {{-- Mission / Vision / Values --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-bullseye"></i> Mission, Vision & Values</div>
                    <div class="mb-3">
                        <label class="acf-label">Mission <span class="optional">Optional</span></label>
                        <textarea name="mission" class="form-control" rows="3"
                                  placeholder="আমাদের লক্ষ্য...">{{ old('mission', $about->mission) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Vision <span class="optional">Optional</span></label>
                        <textarea name="vision" class="form-control" rows="3"
                                  placeholder="আমাদের দৃষ্টিভঙ্গি...">{{ old('vision', $about->vision) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="acf-label">Core Values <span class="optional">Optional</span></label>
                        <textarea name="values" class="form-control" rows="3"
                                  placeholder="আমাদের মূল মান...">{{ old('values', $about->values) }}</textarea>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-bar-chart"></i> Company Highlights</div>
                    <div class="three-col">
                        <div>
                            <label class="acf-label">Founded Year</label>
                            <input type="text" name="founded_year" class="form-control"
                                   placeholder="e.g. 2018" value="{{ old('founded_year', $about->founded_year) }}">
                        </div>
                        <div>
                            <label class="acf-label">Total Employees</label>
                            <input type="text" name="total_employees" class="form-control"
                                   placeholder="e.g. 50+" value="{{ old('total_employees', $about->total_employees) }}">
                        </div>
                        <div>
                            <label class="acf-label">Happy Clients</label>
                            <input type="text" name="total_clients" class="form-control"
                                   placeholder="e.g. 5000+" value="{{ old('total_clients', $about->total_clients) }}">
                        </div>
                        <div>
                            <label class="acf-label">Total Projects</label>
                            <input type="text" name="total_projects" class="form-control"
                                   placeholder="e.g. 200+" value="{{ old('total_projects', $about->total_projects) }}">
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-telephone"></i> Contact Information</div>
                    <div class="two-col mb-3">
                        <div>
                            <label class="acf-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="info@company.com" value="{{ old('email', $about->email) }}">
                        </div>
                        <div>
                            <label class="acf-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   placeholder="01XXXXXXXXX" value="{{ old('phone', $about->phone) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Website URL</label>
                        <input type="url" name="website" class="form-control"
                               placeholder="https://yoursite.com" value="{{ old('website', $about->website) }}">
                    </div>
                    <div class="mb-0">
                        <label class="acf-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"
                                  placeholder="Full address...">{{ old('address', $about->address) }}</textarea>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-share"></i> Social Media Links</div>
                    <div class="social-row">
                        <div class="social-icon" style="background:#1877f2;color:#fff;"><i class="bi bi-facebook"></i></div>
                        <input type="url" name="facebook" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ old('facebook', $about->facebook) }}">
                    </div>
                    <div class="social-row">
                        <div class="social-icon" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);color:#fff;"><i class="bi bi-instagram"></i></div>
                        <input type="url" name="instagram" class="form-control" placeholder="https://instagram.com/yourpage" value="{{ old('instagram', $about->instagram) }}">
                    </div>
                    <div class="social-row">
                        <div class="social-icon" style="background:#000;color:#fff;"><i class="bi bi-twitter-x"></i></div>
                        <input type="url" name="twitter" class="form-control" placeholder="https://twitter.com/yourpage" value="{{ old('twitter', $about->twitter) }}">
                    </div>
                    <div class="social-row">
                        <div class="social-icon" style="background:#ff0000;color:#fff;"><i class="bi bi-youtube"></i></div>
                        <input type="url" name="youtube" class="form-control" placeholder="https://youtube.com/yourchannel" value="{{ old('youtube', $about->youtube) }}">
                    </div>
                    <div class="social-row" style="margin-bottom:0;">
                        <div class="social-icon" style="background:#0a66c2;color:#fff;"><i class="bi bi-linkedin"></i></div>
                        <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/company/yourpage" value="{{ old('linkedin', $about->linkedin) }}">
                    </div>
                </div>

                {{-- SEO --}}
                <div class="acf-card" style="border:1px solid #fde68a;background:#fffbeb;">
                    <div class="acf-card-title" style="color:#b7791f;border-bottom-color:#fde68a;">
                        <i class="bi bi-search"></i> SEO Settings <span class="optional">Optional</span>
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"
                               placeholder="Page title for search engines" value="{{ old('meta_title', $about->meta_title) }}">
                    </div>
                    <div class="mb-3">
                        <label class="acf-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control"
                               placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords', $about->meta_keywords) }}">
                    </div>
                    <div class="mb-0">
                        <label class="acf-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"
                                  placeholder="Search engine description...">{{ old('meta_description', $about->meta_description) }}</textarea>
                    </div>
                </div>

            </div>

            {{-- ════ RIGHT ════ --}}
            <div class="col-lg-4">

                {{-- Status --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-toggle-on"></i> Status</div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $about->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:13px;font-weight:600;">
                            Active (Frontend এ দেখাবে)
                        </label>
                    </div>
                </div>

                {{-- Logo --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-image"></i> Company Logo</div>

                    @if($about->logo)
                        <div class="existing-img-wrap" id="logo_existing">
                            <span class="img-label-tag"><i class="bi bi-check-circle-fill" style="color:#38a169;"></i> Current Logo</span>
                            <img src="{{ asset($about->logo) }}" alt="Logo" class="existing-img thumb w-100">
                            <button type="button" class="img-delete-btn"
                                    onclick="confirmDeleteImage('logo_existing','delete_logo','logo_new_section')">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                        <input type="hidden" name="delete_logo" id="delete_logo" value="" disabled>
                    @endif

                    <div id="logo_new_section" {{ $about->logo ? 'style=display:none;' : '' }}>
                        <div class="img-upload-box" onclick="document.getElementById('logo_input').click()">
                            <img id="logo_preview" src="" style="display:none;width:100%;height:120px;object-fit:contain;">
                            <div class="img-placeholder" id="logo_placeholder">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Click to upload logo</span>
                                <small style="display:block;margin-top:4px;color:#cbd5e0;">JPG, PNG, SVG, WEBP · Max 2MB</small>
                            </div>
                        </div>
                        <input type="file" name="logo" id="logo_input" accept="image/*" class="d-none"
                               onchange="previewImage(this,'logo_preview','logo_placeholder')">
                    </div>
                </div>

                {{-- Banner Image --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-panorama"></i> Banner Image</div>

                    @if($about->banner_image)
                        <div class="existing-img-wrap" id="banner_existing">
                            <span class="img-label-tag"><i class="bi bi-check-circle-fill" style="color:#38a169;"></i> Current Banner</span>
                            <img src="{{ asset($about->banner_image) }}" alt="Banner" class="existing-img banner w-100">
                            <button type="button" class="img-delete-btn"
                                    onclick="confirmDeleteImage('banner_existing','delete_banner','banner_new_section')">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                        <input type="hidden" name="delete_banner" id="delete_banner" value="" disabled>
                    @endif

                    <div id="banner_new_section" {{ $about->banner_image ? 'style=display:none;' : '' }}>
                        <div class="img-upload-box banner-box" onclick="document.getElementById('banner_input').click()">
                            <img id="banner_preview" src="" style="display:none;width:100%;height:150px;object-fit:cover;">
                            <div class="img-placeholder" id="banner_placeholder">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Click to upload banner</span>
                                <small style="display:block;margin-top:4px;color:#cbd5e0;">JPG, PNG, WEBP · Max 4MB · 1200×400</small>
                            </div>
                        </div>
                        <input type="file" name="banner_image" id="banner_input" accept="image/*" class="d-none"
                               onchange="previewImage(this,'banner_preview','banner_placeholder')">
                    </div>
                </div>

                {{-- About Image --}}
                <div class="acf-card">
                    <div class="acf-card-title"><i class="bi bi-card-image"></i> About Section Image</div>

                    @if($about->about_image)
                        <div class="existing-img-wrap" id="about_img_existing">
                            <span class="img-label-tag"><i class="bi bi-check-circle-fill" style="color:#38a169;"></i> Current Image</span>
                            <img src="{{ asset($about->about_image) }}" alt="About Image" class="existing-img banner w-100">
                            <button type="button" class="img-delete-btn"
                                    onclick="confirmDeleteImage('about_img_existing','delete_about_image','about_img_new_section')">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                        <input type="hidden" name="delete_about_image" id="delete_about_image" value="" disabled>
                    @endif

                    <div id="about_img_new_section" {{ $about->about_image ? 'style=display:none;' : '' }}>
                        <div class="img-upload-box" onclick="document.getElementById('about_img_input').click()">
                            <img id="about_img_preview" src="" style="display:none;width:100%;height:150px;object-fit:cover;">
                            <div class="img-placeholder" id="about_img_placeholder">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Click to upload image</span>
                                <small style="display:block;margin-top:4px;color:#cbd5e0;">JPG, PNG, WEBP · Max 4MB</small>
                            </div>
                        </div>
                        <input type="file" name="about_image" id="about_img_input" accept="image/*" class="d-none"
                               onchange="previewImage(this,'about_img_preview','about_img_placeholder')">
                    </div>
                </div>

                {{-- Save Button --}}
                <button type="submit" class="btn-acf btn-save w-100" style="border-radius:8px;padding:12px;">
                    <i class="bi bi-check-lg"></i> Update করুন
                </button>

            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input, previewId, placeholderId) {
    var file = input.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var prev = document.getElementById(previewId);
        prev.src = e.target.result;
        prev.style.display = 'block';
        document.getElementById(placeholderId).style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function confirmDeleteImage(existingWrapId, hiddenInputId, newSectionId) {
    if (!confirm('এই ছবি মুছে ফেলতে চান?')) return;
    // existing preview hide
    document.getElementById(existingWrapId).style.display = 'none';
    // hidden input enable করো যাতে controller জানে delete করতে হবে
    var inp = document.getElementById(hiddenInputId);
    inp.value = '1';
    inp.disabled = false;
    // নতুন upload section দেখাও
    document.getElementById(newSectionId).style.display = 'block';
}
</script>

@endsection
