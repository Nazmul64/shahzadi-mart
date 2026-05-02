@extends('frontend.master')

@section('main-content')

{{-- Hero / Page Banner Section --}}
<section style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    {{-- Background Decorations --}}
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -80px; left: -80px; width: 400px; height: 400px; background: rgba(255,255,255,0.02); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div style="display: inline-flex; align-items: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; padding: 8px 20px; margin-bottom: 20px;">
                    <i class="fas fa-shield-alt" style="color: #e2b96f; margin-right: 8px;"></i>
                    <span style="color: rgba(255,255,255,0.8); font-size: 13px; letter-spacing: 1px; text-transform: uppercase;">Legal Document</span>
                </div>
                <h1 style="color: #ffffff; font-size: 48px; font-weight: 700; margin-bottom: 15px; line-height: 1.2;">
                    Privacy <span style="color: #e2b96f;">Policy</span>
                </h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 500px; margin: 0 auto 25px;">
                    Your privacy is critically important to us.
                </p>
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center" style="background: transparent; padding: 0; margin: 0;">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" style="color: #e2b96f; text-decoration: none;">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.5);">
                            Privacy Policy
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

{{-- Main Content Section --}}
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">

            {{-- Main Content --}}
            <div class="col-lg-9">

                @if($privacyPolicy)

                {{-- Last Updated Badge --}}
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 35px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 4px; height: 40px; background: linear-gradient(180deg, #e2b96f, #c9973a); border-radius: 2px;"></div>
                        <div>
                            <p style="margin: 0; color: #999; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Document Title</p>
                            <h5 style="margin: 0; color: #1a1a2e; font-weight: 700;">{{ $privacyPolicy->title ?? 'Privacy Policy' }}</h5>
                        </div>
                    </div>
                    <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 8px 16px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-clock" style="color: #856404;"></i>
                        <span style="color: #856404; font-size: 13px; font-weight: 500;">
                            Last Updated: {{ optional($privacyPolicy->updated_at)->format('d F, Y') ?? date('d F, Y') }}
                        </span>
                    </div>
                </div>

                {{-- Introduction Notice Box --}}
                <div style="background: linear-gradient(135deg, #e8f4fd, #dbeafe); border-left: 4px solid #3b82f6; border-radius: 0 12px 12px 0; padding: 20px 25px; margin-bottom: 35px;">
                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                        <div style="background: #3b82f6; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                            <i class="fas fa-lock" style="color: white; font-size: 16px;"></i>
                        </div>
                        <div>
                            <h6 style="color: #1e40af; font-weight: 700; margin-bottom: 6px; font-size: 15px;">Privacy Commitment</h6>
                            <p style="color: #1e3a8a; margin: 0; font-size: 14px; line-height: 1.7;">
                                We are committed to protecting your personal information and your right to privacy.
                                By accessing <strong>{{ $websetting->site_name ?? config('app.name') }}</strong>, you agree to our collection and use of information in relation to this policy.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Main Content Card --}}
                <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 30px rgba(0,0,0,0.08); overflow: hidden;">

                    {{-- Card Header --}}
                    <div style="background: linear-gradient(135deg, #1a1a2e, #16213e); padding: 25px 35px; display: flex; align-items: center; gap: 15px;">
                        <div style="background: rgba(226,185,111,0.2); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shield-virus" style="color: #e2b96f; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h4 style="color: #ffffff; margin: 0; font-weight: 700; font-size: 20px;">Full Privacy Policy</h4>
                            <p style="color: rgba(255,255,255,0.5); margin: 0; font-size: 13px;">Read all terms before proceeding</p>
                        </div>
                    </div>

                    {{-- Content Body --}}
                    <div style="padding: 40px 35px;">
                        <div class="terms-content" style="color: #4a5568; font-size: 15px; line-height: 1.9;">
                            {!! $privacyPolicy->content ?? '<p>No content available.</p>' !!}
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div style="background: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 35px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #6c757d; font-size: 13px;">
                            <i class="fas fa-user-shield" style="color: #28a745;"></i>
                            <span>Your data is secure with us.</span>
                        </div>
                        <button onclick="window.print()"
                                style="background: transparent; border: 1px solid #dee2e6; color: #6c757d; padding: 8px 18px; border-radius: 8px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;"
                                onmouseover="this.style.background='#e9ecef'"
                                onmouseout="this.style.background='transparent'">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>

                </div>

                @else
                {{-- Empty State --}}
                <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 30px rgba(0,0,0,0.08); padding: 80px 40px; text-align: center;">
                    <div style="background: #f8f9fa; width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                        <i class="fas fa-file-alt" style="font-size: 40px; color: #ced4da;"></i>
                    </div>
                    <h4 style="color: #495057; font-weight: 700; margin-bottom: 12px;">No Policy Available</h4>
                    <p style="color: #adb5bd; font-size: 15px; margin-bottom: 25px;">Privacy Policy content has not been added yet.</p>
                    <a href="{{ url('/') }}"
                       style="background: #e2b96f; color: #1a1a2e; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- Content Styling --}}
<style>
    .terms-content h1, .terms-content h2, .terms-content h3,
    .terms-content h4, .terms-content h5, .terms-content h6 {
        color: #1a1a2e;
        font-weight: 700;
        margin-top: 30px;
        margin-bottom: 12px;
    }
    .terms-content h2 { font-size: 22px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
    .terms-content h3 { font-size: 18px; color: #2d3748; }
    .terms-content p  { margin-bottom: 16px; }
    .terms-content ul, .terms-content ol {
        padding-left: 25px;
        margin-bottom: 16px;
    }
    .terms-content ul li, .terms-content ol li {
        margin-bottom: 8px;
        line-height: 1.8;
    }
    .terms-content ul li::marker { color: #e2b96f; }
    .terms-content a { color: #e2b96f; text-decoration: underline; }
    .terms-content strong { color: #1a1a2e; }
    .terms-content blockquote {
        background: #f8f9fa;
        border-left: 4px solid #e2b96f;
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 0 8px 8px 0;
        color: #6c757d;
        font-style: italic;
    }

    @media (max-width: 768px) {
        section h1 { font-size: 32px !important; }
        .terms-content { font-size: 14px !important; }
        div[style*="padding: 40px 35px"] { padding: 25px 20px !important; }
        div[style*="padding: 25px 35px"] { padding: 20px !important; }
        div[style*="padding: 30px 35px"] { padding: 20px !important; }
        div[style*="padding: 20px 35px"] { padding: 15px 20px !important; }
    }

    @media print {
        section:first-child, .breadcrumb, button { display: none !important; }
        .terms-content { font-size: 12pt !important; }
    }
</style>

@endsection
