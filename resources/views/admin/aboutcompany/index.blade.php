@extends('admin.master')

@section('main-content')

<style>
.ac-wrapper { padding: 24px; background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }

/* ── Topbar ── */
.ac-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.ac-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }
.ac-topbar-sub { font-size: 12px; color: #aaa; margin-top: 3px; }
.btn-ac { border: none; border-radius: 22px; padding: 9px 22px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; transition: opacity .2s; }
.btn-ac:hover { opacity: .85; text-decoration: none; }
.btn-primary-ac { background: #1a2b6b; color: #fff; }
.btn-edit-ac    { background: #3182ce; color: #fff; }
.btn-del-ac     { background: #e53e3e; color: #fff; }

/* ── Empty State ── */
.ac-empty { background: #fff; border-radius: 12px; box-shadow: 0 1px 6px rgba(0,0,0,.06); padding: 60px 30px; text-align: center; }
.ac-empty i { font-size: 56px; color: #cbd5e0; display: block; margin-bottom: 14px; }
.ac-empty p { color: #aaa; font-size: 15px; margin-bottom: 20px; }

/* ── Info Card ── */
.ac-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 6px rgba(0,0,0,.06); overflow: hidden; }
.ac-banner { width: 100%; height: 220px; object-fit: cover; display: block; background: #e9ecef; }
.ac-banner-placeholder { width: 100%; height: 220px; background: linear-gradient(135deg, #1a2b6b, #3182ce); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.3); font-size: 48px; }

.ac-body { padding: 28px 32px; }
.ac-header { display: flex; align-items: center; gap: 20px; margin-bottom: 24px; }
.ac-logo { width: 80px; height: 80px; object-fit: contain; border-radius: 12px; border: 2px solid #e9ecef; background: #f8f9fa; padding: 6px; }
.ac-logo-placeholder { width: 80px; height: 80px; background: #e9ecef; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 28px; }
.ac-company-name { font-size: 22px; font-weight: 800; color: #1a202c; margin: 0; }
.ac-tagline { font-size: 13px; color: #718096; margin-top: 4px; }

/* ── Stats ── */
.ac-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
.ac-stat { background: #f8f9fc; border-radius: 10px; padding: 16px 18px; text-align: center; border: 1px solid #e9ecef; }
.ac-stat-val { font-size: 22px; font-weight: 800; color: #1a2b6b; }
.ac-stat-label { font-size: 11px; color: #aaa; margin-top: 4px; text-transform: uppercase; letter-spacing: .5px; }

/* ── Sections ── */
.ac-sections { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
.ac-section { background: #f8f9fc; border-radius: 10px; padding: 18px 20px; border: 1px solid #e9ecef; }
.ac-section-title { font-size: 12px; font-weight: 700; color: #1a2b6b; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 10px; display: flex; align-items: center; gap-6px; }
.ac-section-text { font-size: 13px; color: #4a5568; line-height: 1.6; }

/* ── Contact / Social ── */
.ac-contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.ac-contact-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #4a5568; }
.ac-contact-item i { color: #1a2b6b; font-size: 14px; width: 18px; }
.ac-social-row { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
.ac-social-link { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; background: #e9ecef; color: #2d3748; }
.ac-social-link:hover { background: #1a2b6b; color: #fff; text-decoration: none; }

/* ── Full-width sections ── */
.ac-full-section { background: #f8f9fc; border-radius: 10px; padding: 18px 20px; border: 1px solid #e9ecef; margin-bottom: 14px; }

/* ── Action Bar ── */
.ac-actions { display: flex; gap: 10px; padding-top: 20px; border-top: 1px solid #f0f2f8; }

/* ── Status Badge ── */
.ac-status { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.ac-status.active   { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
.ac-status.inactive { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }

/* ── SEO Badge ── */
.ac-seo-section { background: #fffbeb; border: 1px solid #f6e05e; border-radius: 10px; padding: 16px 20px; }
.ac-seo-section .ac-section-title { color: #b7791f; }

@media (max-width: 768px) {
    .ac-stats { grid-template-columns: repeat(2, 1fr); }
    .ac-sections { grid-template-columns: 1fr; }
    .ac-contact-grid { grid-template-columns: 1fr; }
}
</style>

<div class="ac-wrapper">

    {{-- Topbar --}}
    <div class="ac-topbar">
        <div>
            <h2><i class="bi bi-building me-2" style="color:#1a2b6b;"></i>Company Information</h2>
            <div class="ac-topbar-sub">Dashboard › Company Information</div>
        </div>
        @if(!$about)
            <a href="{{ route('admin.aboutcompany.create') }}" class="btn-ac btn-primary-ac">
                <i class="bi bi-plus-lg"></i> Add Company Info
            </a>
        @else
            <div style="display:flex;gap:8px;">
                <span class="ac-status {{ $about->is_active ? 'active' : 'inactive' }}">
                    <i class="bi bi-circle-fill" style="font-size:7px;"></i>
                    {{ $about->is_active ? 'Active' : 'Inactive' }}
                </span>
                <a href="{{ route('admin.aboutcompany.edit', $about->id) }}" class="btn-ac btn-edit-ac">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        @endif
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 20px;border-radius:8px;margin-bottom:16px;font-size:13px;color:#276749;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div style="background:#ebf8ff;border-left:4px solid #3182ce;padding:12px 20px;border-radius:8px;margin-bottom:16px;font-size:13px;color:#2b6cb0;">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
        </div>
    @endif

    {{-- Empty State --}}
    @if(!$about)
        <div class="ac-empty">
            <i class="bi bi-building"></i>
            <p>এখনো কোনো company information যোগ করা হয়নি।</p>
            <a href="{{ route('admin.aboutcompany.create') }}" class="btn-ac btn-primary-ac">
                <i class="bi bi-plus-lg"></i> Company Info যোগ করুন
            </a>
        </div>

    {{-- Data Card --}}
    @else
        <div class="ac-card">

            {{-- Banner --}}
            @if($about->banner_image)
                <img src="{{ asset($about->banner_image) }}" alt="Banner" class="ac-banner">
            @else
                <div class="ac-banner-placeholder"><i class="bi bi-image"></i></div>
            @endif

            <div class="ac-body">

                {{-- Header --}}
                <div class="ac-header">
                    @if($about->logo)
                        <img src="{{ asset($about->logo) }}" alt="Logo" class="ac-logo">
                    @else
                        <div class="ac-logo-placeholder"><i class="bi bi-building"></i></div>
                    @endif
                    <div>
                        <div class="ac-company-name">{{ $about->company_name }}</div>
                        @if($about->tagline)
                            <div class="ac-tagline">{{ $about->tagline }}</div>
                        @endif
                        @if($about->website)
                            <a href="{{ $about->website }}" target="_blank"
                               style="font-size:12px;color:#3182ce;text-decoration:none;">
                                <i class="bi bi-link-45deg"></i>{{ $about->website }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Stats --}}
                @if($about->founded_year || $about->total_employees || $about->total_clients || $about->total_projects)
                <div class="ac-stats">
                    @if($about->founded_year)
                    <div class="ac-stat">
                        <div class="ac-stat-val">{{ $about->founded_year }}</div>
                        <div class="ac-stat-label">Founded</div>
                    </div>
                    @endif
                    @if($about->total_employees)
                    <div class="ac-stat">
                        <div class="ac-stat-val">{{ $about->total_employees }}</div>
                        <div class="ac-stat-label">Employees</div>
                    </div>
                    @endif
                    @if($about->total_clients)
                    <div class="ac-stat">
                        <div class="ac-stat-val">{{ $about->total_clients }}</div>
                        <div class="ac-stat-label">Clients</div>
                    </div>
                    @endif
                    @if($about->total_projects)
                    <div class="ac-stat">
                        <div class="ac-stat-val">{{ $about->total_projects }}</div>
                        <div class="ac-stat-label">Projects</div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Short Description --}}
                @if($about->short_description)
                <div class="ac-full-section" style="margin-bottom:14px;">
                    <div class="ac-section-title"><i class="bi bi-text-paragraph me-1"></i> Short Description</div>
                    <div class="ac-section-text">{{ $about->short_description }}</div>
                </div>
                @endif

                {{-- Mission / Vision / Values --}}
                @if($about->mission || $about->vision || $about->values)
                <div class="ac-sections">
                    @if($about->mission)
                    <div class="ac-section">
                        <div class="ac-section-title"><i class="bi bi-bullseye me-1"></i> Mission</div>
                        <div class="ac-section-text">{{ $about->mission }}</div>
                    </div>
                    @endif
                    @if($about->vision)
                    <div class="ac-section">
                        <div class="ac-section-title"><i class="bi bi-eye me-1"></i> Vision</div>
                        <div class="ac-section-text">{{ $about->vision }}</div>
                    </div>
                    @endif
                    @if($about->values)
                    <div class="ac-section" style="{{ ($about->mission && $about->vision) ? 'grid-column: 1 / -1;' : '' }}">
                        <div class="ac-section-title"><i class="bi bi-stars me-1"></i> Core Values</div>
                        <div class="ac-section-text">{{ $about->values }}</div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- About Description --}}
                @if($about->about_description)
                <div class="ac-full-section">
                    <div class="ac-section-title"><i class="bi bi-info-circle me-1"></i> About Description</div>
                    <div class="ac-section-text">{!! nl2br(e($about->about_description)) !!}</div>
                </div>
                @endif

                {{-- About Image --}}
                @if($about->about_image)
                <div style="margin-bottom:14px;">
                    <img src="{{ asset($about->about_image) }}" alt="About Image"
                         style="width:100%;max-height:300px;object-fit:cover;border-radius:10px;">
                </div>
                @endif

                {{-- Contact + Social --}}
                <div class="ac-sections">
                    @if($about->email || $about->phone || $about->address)
                    <div class="ac-section">
                        <div class="ac-section-title"><i class="bi bi-telephone me-1"></i> Contact Info</div>
                        <div class="ac-contact-grid">
                            @if($about->email)
                            <div class="ac-contact-item"><i class="bi bi-envelope"></i> {{ $about->email }}</div>
                            @endif
                            @if($about->phone)
                            <div class="ac-contact-item"><i class="bi bi-telephone"></i> {{ $about->phone }}</div>
                            @endif
                            @if($about->address)
                            <div class="ac-contact-item" style="grid-column: 1 / -1;"><i class="bi bi-geo-alt"></i> {{ $about->address }}</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($about->facebook || $about->instagram || $about->twitter || $about->youtube || $about->linkedin)
                    <div class="ac-section">
                        <div class="ac-section-title"><i class="bi bi-share me-1"></i> Social Links</div>
                        <div class="ac-social-row">
                            @if($about->facebook)
                            <a href="{{ $about->facebook }}" target="_blank" class="ac-social-link">
                                <i class="bi bi-facebook"></i> Facebook
                            </a>
                            @endif
                            @if($about->instagram)
                            <a href="{{ $about->instagram }}" target="_blank" class="ac-social-link">
                                <i class="bi bi-instagram"></i> Instagram
                            </a>
                            @endif
                            @if($about->twitter)
                            <a href="{{ $about->twitter }}" target="_blank" class="ac-social-link">
                                <i class="bi bi-twitter-x"></i> Twitter
                            </a>
                            @endif
                            @if($about->youtube)
                            <a href="{{ $about->youtube }}" target="_blank" class="ac-social-link">
                                <i class="bi bi-youtube"></i> YouTube
                            </a>
                            @endif
                            @if($about->linkedin)
                            <a href="{{ $about->linkedin }}" target="_blank" class="ac-social-link">
                                <i class="bi bi-linkedin"></i> LinkedIn
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- SEO --}}
                @if($about->meta_title || $about->meta_description || $about->meta_keywords)
                <div class="ac-seo-section" style="margin-bottom:14px;">
                    <div class="ac-section-title"><i class="bi bi-search me-1"></i> SEO Information</div>
                    @if($about->meta_title)
                    <div style="font-size:13px;color:#4a5568;margin-bottom:6px;">
                        <strong>Meta Title:</strong> {{ $about->meta_title }}
                    </div>
                    @endif
                    @if($about->meta_keywords)
                    <div style="font-size:13px;color:#4a5568;margin-bottom:6px;">
                        <strong>Keywords:</strong> {{ $about->meta_keywords }}
                    </div>
                    @endif
                    @if($about->meta_description)
                    <div style="font-size:13px;color:#4a5568;">
                        <strong>Description:</strong> {{ $about->meta_description }}
                    </div>
                    @endif
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="ac-actions">
                    <a href="{{ route('admin.aboutcompany.edit', $about->id) }}" class="btn-ac btn-edit-ac">
                        <i class="bi bi-pencil"></i> Edit Information
                    </a>
                    <form method="POST"
                          action="{{ route('admin.aboutcompany.destroy', $about->id) }}"
                          onsubmit="return confirm('সব তথ্য এবং ছবি মুছে ফেলা হবে। নিশ্চিত?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-ac btn-del-ac">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @endif

</div>

@endsection
