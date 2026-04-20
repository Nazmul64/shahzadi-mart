@extends('frontend.master')

@section('main-content')

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ══════════════════════════════════════════════════════
   CSS VARIABLES
══════════════════════════════════════════════════════ */
:root {
    --navy:   #0f1f4b;
    --navy2:  #1a2b6b;
    --gold:   #c8963e;
    --gold2:  #e8b45a;
    --cream:  #fdf9f3;
    --dark:   #0c0c0c;
    --muted:  #6b7280;
    --line:   rgba(200,150,62,.25);
    --ease:   cubic-bezier(.4,0,.2,1);
}

/* ── Base ── */
.ac-page * { box-sizing: border-box; margin: 0; padding: 0; }
.ac-page {
    font-family: 'DM Sans', sans-serif;
    color: var(--dark);
    background: #fff;
    overflow-x: hidden;
}

/* ══════════════════════════════════════════════════════
   HERO / BANNER SECTION
══════════════════════════════════════════════════════ */
.ac-hero {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    background: var(--navy);
}
.ac-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: .35;
    transform: scale(1.05);
    animation: heroZoom 12s ease-in-out infinite alternate;
}
@keyframes heroZoom {
    from { transform: scale(1.05); }
    to   { transform: scale(1.12); }
}
.ac-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(15,31,75,.92) 0%,
        rgba(26,43,107,.75) 60%,
        rgba(200,150,62,.15) 100%
    );
}
.ac-hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    padding: 80px 24px 60px;
}
.ac-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--gold2);
    margin-bottom: 18px;
    animation: fadeUp .6s var(--ease) both;
}
.ac-hero-eyebrow::before {
    content: '';
    display: block;
    width: 32px;
    height: 2px;
    background: var(--gold);
}
.ac-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(36px, 5vw, 64px);
    font-weight: 800;
    color: #fff;
    line-height: 1.12;
    margin-bottom: 18px;
    animation: fadeUp .7s .1s var(--ease) both;
}
.ac-hero-title span {
    color: var(--gold2);
}
.ac-hero-tagline {
    font-size: 16px;
    color: rgba(255,255,255,.75);
    font-weight: 400;
    max-width: 560px;
    line-height: 1.65;
    animation: fadeUp .7s .2s var(--ease) both;
}
/* Logo floating card */
.ac-hero-logo-card {
    position: absolute;
    top: 40px;
    right: 80px;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 16px;
    padding: 16px 20px;
    animation: fadeIn .9s .3s var(--ease) both;
}
.ac-hero-logo-card img {
    height: 56px;
    max-width: 180px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

/* ══════════════════════════════════════════════════════
   STATS BAR
══════════════════════════════════════════════════════ */
.ac-stats-bar {
    background: var(--navy2);
    padding: 0;
    position: relative;
    z-index: 10;
}
.ac-stats-inner {
    max-width: 1180px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.ac-stat-item {
    padding: 28px 24px;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,.08);
    position: relative;
    overflow: hidden;
    transition: background .3s;
}
.ac-stat-item:last-child { border-right: none; }
.ac-stat-item::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gold);
    transform: scaleX(0);
    transition: transform .4s var(--ease);
    transform-origin: left;
}
.ac-stat-item:hover::after { transform: scaleX(1); }
.ac-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 800;
    color: var(--gold2);
    display: block;
    line-height: 1;
    margin-bottom: 6px;
    counter-reset: none;
}
.ac-stat-lbl {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,.5);
}

/* ══════════════════════════════════════════════════════
   BREADCRUMB
══════════════════════════════════════════════════════ */
.ac-breadcrumb {
    background: var(--cream);
    border-bottom: 1px solid rgba(200,150,62,.2);
    padding: 13px 0;
}
.ac-breadcrumb-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    color: var(--muted);
}
.ac-breadcrumb a { color: var(--navy2); text-decoration: none; font-weight: 600; }
.ac-breadcrumb a:hover { color: var(--gold); }
.ac-breadcrumb-sep { color: var(--gold); font-size: 10px; }

/* ══════════════════════════════════════════════════════
   SECTION WRAPPER
══════════════════════════════════════════════════════ */
.ac-section {
    padding: 80px 24px;
    max-width: 1180px;
    margin: 0 auto;
}
.ac-section-full {
    padding: 80px 0;
}
.ac-section-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ── Section Label ── */
.ac-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 12px;
}
.ac-label::before {
    content: '';
    width: 24px; height: 2px;
    background: var(--gold);
}
.ac-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 44px);
    font-weight: 800;
    color: var(--navy);
    line-height: 1.18;
    margin-bottom: 16px;
}
.ac-heading span { color: var(--gold); }
.ac-para {
    font-size: 15.5px;
    color: var(--muted);
    line-height: 1.75;
    max-width: 620px;
}
.ac-divider {
    width: 56px; height: 4px;
    background: linear-gradient(90deg, var(--gold), var(--gold2));
    border-radius: 2px;
    margin: 18px 0 28px;
}

/* ══════════════════════════════════════════════════════
   ABOUT SPLIT SECTION
══════════════════════════════════════════════════════ */
.ac-about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: center;
}
.ac-about-img-wrap {
    position: relative;
}
.ac-about-img {
    width: 100%;
    border-radius: 16px;
    object-fit: cover;
    height: 460px;
    display: block;
    box-shadow: 24px 24px 0 rgba(200,150,62,.15);
}
.ac-about-img-placeholder {
    width: 100%;
    height: 460px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 24px 24px 0 rgba(200,150,62,.15);
    color: rgba(255,255,255,.2);
    font-size: 64px;
}
/* Gold accent frame */
.ac-about-img-wrap::before {
    content: '';
    position: absolute;
    top: -16px; left: -16px;
    right: 16px; bottom: -16px;
    border: 2px solid var(--line);
    border-radius: 16px;
    pointer-events: none;
    z-index: 0;
}
.ac-about-img,
.ac-about-img-placeholder {
    position: relative;
    z-index: 1;
}
/* Founded badge */
.ac-founded-badge {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 110px;
    height: 110px;
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 5;
    box-shadow: 0 8px 32px rgba(200,150,62,.35);
}
.ac-founded-badge .year {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.ac-founded-badge .since {
    font-size: 10px;
    color: rgba(255,255,255,.8);
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ══════════════════════════════════════════════════════
   MISSION / VISION / VALUES CARDS
══════════════════════════════════════════════════════ */
.ac-mvv-section {
    background: var(--cream);
    position: relative;
    overflow: hidden;
}
.ac-mvv-section::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,150,62,.08), transparent 70%);
    pointer-events: none;
}
.ac-mvv-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.ac-mvv-card {
    background: #fff;
    border-radius: 16px;
    padding: 36px 28px;
    border: 1px solid rgba(200,150,62,.15);
    position: relative;
    overflow: hidden;
    transition: transform .35s var(--ease), box-shadow .35s var(--ease);
}
.ac-mvv-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 48px rgba(15,31,75,.1);
}
.ac-mvv-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gold), var(--gold2));
    transform: scaleX(0);
    transition: transform .4s var(--ease);
    transform-origin: left;
}
.ac-mvv-card:hover::before { transform: scaleX(1); }
.ac-mvv-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--navy), var(--navy2));
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: var(--gold2);
    flex-shrink: 0;
}
.ac-mvv-title {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 12px;
}
.ac-mvv-text {
    font-size: 14.5px;
    color: var(--muted);
    line-height: 1.72;
}

/* ══════════════════════════════════════════════════════
   CONTACT + SOCIAL SECTION
══════════════════════════════════════════════════════ */
.ac-contact-section {
    background: var(--navy);
    position: relative;
    overflow: hidden;
}
.ac-contact-section::after {
    content: '';
    position: absolute;
    bottom: -120px; left: -120px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,150,62,.08), transparent 70%);
    pointer-events: none;
}
.ac-contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: start;
}
.ac-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}
.ac-contact-icon {
    width: 48px;
    height: 48px;
    background: rgba(200,150,62,.15);
    border: 1px solid rgba(200,150,62,.25);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--gold2);
    flex-shrink: 0;
}
.ac-contact-info-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,.4);
    margin-bottom: 4px;
}
.ac-contact-info-val {
    font-size: 15px;
    color: #fff;
    font-weight: 500;
}
.ac-contact-info-val a {
    color: #fff;
    text-decoration: none;
    transition: color .2s;
}
.ac-contact-info-val a:hover { color: var(--gold2); }

/* Social Links */
.ac-social-title {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
}
.ac-social-sub {
    font-size: 14px;
    color: rgba(255,255,255,.5);
    margin-bottom: 28px;
    line-height: 1.6;
}
.ac-social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.ac-social-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,.12);
    color: rgba(255,255,255,.8);
    background: rgba(255,255,255,.05);
    transition: all .3s var(--ease);
    backdrop-filter: blur(8px);
}
.ac-social-btn:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: #fff;
    transform: translateY(-2px);
    text-decoration: none;
}
.ac-social-btn i { font-size: 15px; }

/* ══════════════════════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════════════════════ */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
.reveal {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity .7s var(--ease), transform .7s var(--ease);
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
.reveal-delay-3 { transition-delay: .3s; }

/* ══════════════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════════════ */
@media (max-width: 991px) {
    .ac-about-grid  { grid-template-columns: 1fr; gap: 48px; }
    .ac-mvv-grid    { grid-template-columns: 1fr; }
    .ac-contact-grid{ grid-template-columns: 1fr; gap: 40px; }
    .ac-stats-inner { grid-template-columns: repeat(2, 1fr); }
    .ac-hero-logo-card { display: none; }
}
@media (max-width: 576px) {
    .ac-stats-inner { grid-template-columns: 1fr 1fr; }
    .ac-stat-item   { padding: 20px 12px; }
    .ac-stat-num    { font-size: 26px; }
}
</style>

<div class="ac-page">

{{-- ══════════════════════════════════════════════════════
     1. HERO SECTION
══════════════════════════════════════════════════════ --}}
<section class="ac-hero">

    {{-- Background --}}
    @if($aboutcompany?->banner_image)
        <div class="ac-hero-bg"
             style="background-image: url('{{ asset($aboutcompany->banner_image) }}');"></div>
    @else
        <div class="ac-hero-bg"
             style="background: linear-gradient(135deg, #0f1f4b 0%, #1a2b6b 100%);"></div>
    @endif
    <div class="ac-hero-overlay"></div>

    {{-- Logo Card --}}
    @if($aboutcompany?->logo)
    <div class="ac-hero-logo-card">
        <img src="{{ asset($aboutcompany->logo) }}" alt="{{ $aboutcompany->company_name }}">
    </div>
    @endif

    <div class="ac-hero-content">
        <div class="ac-hero-eyebrow">About Us</div>
        <h1 class="ac-hero-title">
            @if($aboutcompany?->company_name)
                {{ $aboutcompany->company_name }}
            @else
                {{ $websetting->site_name ?? 'Our Company' }}
            @endif
        </h1>
        @if($aboutcompany?->tagline)
            <p class="ac-hero-tagline">{{ $aboutcompany->tagline }}</p>
        @elseif($aboutcompany?->short_description)
            <p class="ac-hero-tagline">{{ $aboutcompany->short_description }}</p>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     2. STATS BAR
══════════════════════════════════════════════════════ --}}
@if($aboutcompany && ($aboutcompany->founded_year || $aboutcompany->total_employees || $aboutcompany->total_clients || $aboutcompany->total_projects))
<div class="ac-stats-bar">
    <div class="ac-stats-inner">
        @if($aboutcompany->founded_year)
        <div class="ac-stat-item">
            <span class="ac-stat-num">{{ $aboutcompany->founded_year }}</span>
            <div class="ac-stat-lbl">Founded</div>
        </div>
        @endif
        @if($aboutcompany->total_employees)
        <div class="ac-stat-item">
            <span class="ac-stat-num">{{ $aboutcompany->total_employees }}</span>
            <div class="ac-stat-lbl">Team Members</div>
        </div>
        @endif
        @if($aboutcompany->total_clients)
        <div class="ac-stat-item">
            <span class="ac-stat-num">{{ $aboutcompany->total_clients }}</span>
            <div class="ac-stat-lbl">Happy Clients</div>
        </div>
        @endif
        @if($aboutcompany->total_projects)
        <div class="ac-stat-item">
            <span class="ac-stat-num">{{ $aboutcompany->total_projects }}</span>
            <div class="ac-stat-lbl">Projects Done</div>
        </div>
        @endif
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     BREADCRUMB
══════════════════════════════════════════════════════ --}}
<div class="ac-breadcrumb">
    <div class="ac-breadcrumb-inner">
        <a href="{{ route('frontend') }}"><i class="bi bi-house me-1"></i>Home</a>
        <span class="ac-breadcrumb-sep"><i class="bi bi-chevron-right"></i></span>
        <span>About Company</span>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     3. ABOUT SPLIT SECTION
══════════════════════════════════════════════════════ --}}
@if($aboutcompany && ($aboutcompany->about_description || $aboutcompany->short_description || $aboutcompany->about_image))
<div style="padding: 80px 24px;">
    <div style="max-width:1180px; margin:0 auto;">
        <div class="ac-about-grid">

            {{-- Image --}}
            <div class="ac-about-img-wrap reveal">
                @if($aboutcompany->about_image)
                    <img src="{{ asset($aboutcompany->about_image) }}"
                         alt="{{ $aboutcompany->company_name }}"
                         class="ac-about-img">
                @else
                    <div class="ac-about-img-placeholder">
                        <i class="bi bi-building"></i>
                    </div>
                @endif

                @if($aboutcompany->founded_year)
                <div class="ac-founded-badge">
                    <span class="year">{{ $aboutcompany->founded_year }}</span>
                    <span class="since">Since</span>
                </div>
                @endif
            </div>

            {{-- Text --}}
            <div class="reveal reveal-delay-1">
                <div class="ac-label">Who We Are</div>
                <h2 class="ac-heading">
                    We Are <span>{{ $aboutcompany->company_name ?? 'Your Trusted' }}</span><br>Partner
                </h2>
                <div class="ac-divider"></div>

                @if($aboutcompany->short_description)
                    <p class="ac-para" style="font-weight:500;color:#374151;margin-bottom:16px;">
                        {{ $aboutcompany->short_description }}
                    </p>
                @endif

                @if($aboutcompany->about_description)
                    <p class="ac-para">{{ $aboutcompany->about_description }}</p>
                @endif

                @if($aboutcompany->website)
                    <a href="{{ $aboutcompany->website }}" target="_blank"
                       style="display:inline-flex;align-items:center;gap:8px;margin-top:28px;
                              background:var(--navy);color:#fff;padding:12px 28px;
                              border-radius:50px;font-size:13px;font-weight:600;
                              text-decoration:none;transition:background .2s;"
                       onmouseover="this.style.background='var(--gold)'"
                       onmouseout="this.style.background='var(--navy)'">
                        <i class="bi bi-globe2"></i> Visit Website
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     4. MISSION / VISION / VALUES
══════════════════════════════════════════════════════ --}}
@if($aboutcompany && ($aboutcompany->mission || $aboutcompany->vision || $aboutcompany->values))
<section class="ac-mvv-section ac-section-full">
    <div class="ac-section-inner">

        <div style="text-align:center; margin-bottom:52px;" class="reveal">
            <div class="ac-label" style="justify-content:center;">Our Foundation</div>
            <h2 class="ac-heading" style="max-width:500px;margin:0 auto 12px;">
                What <span>Drives</span> Us Every Day
            </h2>
            <div class="ac-divider" style="margin:16px auto 0;"></div>
        </div>

        <div class="ac-mvv-grid">
            @if($aboutcompany->mission)
            <div class="ac-mvv-card reveal">
                <div class="ac-mvv-icon"><i class="bi bi-bullseye"></i></div>
                <div class="ac-mvv-title">Our Mission</div>
                <p class="ac-mvv-text">{{ $aboutcompany->mission }}</p>
            </div>
            @endif

            @if($aboutcompany->vision)
            <div class="ac-mvv-card reveal reveal-delay-1">
                <div class="ac-mvv-icon"><i class="bi bi-eye"></i></div>
                <div class="ac-mvv-title">Our Vision</div>
                <p class="ac-mvv-text">{{ $aboutcompany->vision }}</p>
            </div>
            @endif

            @if($aboutcompany->values)
            <div class="ac-mvv-card reveal reveal-delay-2">
                <div class="ac-mvv-icon"><i class="bi bi-stars"></i></div>
                <div class="ac-mvv-title">Core Values</div>
                <p class="ac-mvv-text">{{ $aboutcompany->values }}</p>
            </div>
            @endif
        </div>

    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════
     5. CONTACT + SOCIAL
══════════════════════════════════════════════════════ --}}
@if($aboutcompany && ($aboutcompany->email || $aboutcompany->phone || $aboutcompany->address || $aboutcompany->facebook || $aboutcompany->instagram || $aboutcompany->twitter || $aboutcompany->youtube || $aboutcompany->linkedin))
<section class="ac-contact-section ac-section-full" style="position:relative;">
    <div class="ac-section-inner" style="position:relative;z-index:1;">

        <div style="margin-bottom:52px;" class="reveal">
            <div class="ac-label" style="color:var(--gold2);">Get In Touch</div>
            <h2 class="ac-heading" style="color:#fff;">
                We'd Love To <span style="color:var(--gold2);">Hear</span> From You
            </h2>
            <div class="ac-divider"></div>
        </div>

        <div class="ac-contact-grid">

            {{-- Contact Info --}}
            @if($aboutcompany->email || $aboutcompany->phone || $aboutcompany->address || $aboutcompany->website)
            <div class="reveal">
                @if($aboutcompany->email)
                <div class="ac-contact-item">
                    <div class="ac-contact-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="ac-contact-info-label">Email Address</div>
                        <div class="ac-contact-info-val">
                            <a href="mailto:{{ $aboutcompany->email }}">{{ $aboutcompany->email }}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($aboutcompany->phone)
                <div class="ac-contact-item">
                    <div class="ac-contact-icon"><i class="bi bi-telephone"></i></div>
                    <div>
                        <div class="ac-contact-info-label">Phone Number</div>
                        <div class="ac-contact-info-val">
                            <a href="tel:{{ $aboutcompany->phone }}">{{ $aboutcompany->phone }}</a>
                        </div>
                    </div>
                </div>
                @endif

                @if($aboutcompany->address)
                <div class="ac-contact-item">
                    <div class="ac-contact-icon"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <div class="ac-contact-info-label">Address</div>
                        <div class="ac-contact-info-val">{{ $aboutcompany->address }}</div>
                    </div>
                </div>
                @endif

                @if($aboutcompany->website)
                <div class="ac-contact-item">
                    <div class="ac-contact-icon"><i class="bi bi-globe2"></i></div>
                    <div>
                        <div class="ac-contact-info-label">Website</div>
                        <div class="ac-contact-info-val">
                            <a href="{{ $aboutcompany->website }}" target="_blank">{{ $aboutcompany->website }}</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            {{-- Social Links --}}
            @if($aboutcompany->facebook || $aboutcompany->instagram || $aboutcompany->twitter || $aboutcompany->youtube || $aboutcompany->linkedin)
            <div class="reveal reveal-delay-1">
                <div class="ac-social-title">Follow Us</div>
                <p class="ac-social-sub">আমাদের social media তে follow করুন এবং সর্বশেষ আপডেট পান।</p>

                <div class="ac-social-links">
                    @if($aboutcompany->facebook)
                    <a href="{{ $aboutcompany->facebook }}" target="_blank" class="ac-social-btn">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    @endif
                    @if($aboutcompany->instagram)
                    <a href="{{ $aboutcompany->instagram }}" target="_blank" class="ac-social-btn">
                        <i class="bi bi-instagram"></i> Instagram
                    </a>
                    @endif
                    @if($aboutcompany->twitter)
                    <a href="{{ $aboutcompany->twitter }}" target="_blank" class="ac-social-btn">
                        <i class="bi bi-twitter-x"></i> Twitter/X
                    </a>
                    @endif
                    @if($aboutcompany->youtube)
                    <a href="{{ $aboutcompany->youtube }}" target="_blank" class="ac-social-btn">
                        <i class="bi bi-youtube"></i> YouTube
                    </a>
                    @endif
                    @if($aboutcompany->linkedin)
                    <a href="{{ $aboutcompany->linkedin }}" target="_blank" class="ac-social-btn">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </a>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════
     EMPTY STATE (যদি কোনো data না থাকে)
══════════════════════════════════════════════════════ --}}
@if(!$aboutcompany)
<div style="padding:120px 24px; text-align:center; background:var(--cream);">
    <div style="font-size:64px; color:#e2e8f0; margin-bottom:20px;">
        <i class="bi bi-building"></i>
    </div>
    <h3 style="font-family:'Playfair Display',serif; font-size:28px; color:var(--navy); margin-bottom:12px;">
        Coming Soon
    </h3>
    <p style="color:var(--muted); font-size:15px;">Company information শীঘ্রই যোগ করা হবে।</p>
    <a href="{{ route('frontend') }}"
       style="display:inline-flex;align-items:center;gap:8px;margin-top:24px;
              background:var(--navy);color:#fff;padding:12px 28px;
              border-radius:50px;font-size:13px;font-weight:600;text-decoration:none;">
        <i class="bi bi-house"></i> Back to Home
    </a>
</div>
@endif

{{-- SEO Meta (in head) --}}
@if($aboutcompany?->meta_title)
@push('meta')
    <title>{{ $aboutcompany->meta_title }}</title>
    @if($aboutcompany->meta_description)
        <meta name="description" content="{{ $aboutcompany->meta_description }}">
    @endif
    @if($aboutcompany->meta_keywords)
        <meta name="keywords" content="{{ $aboutcompany->meta_keywords }}">
    @endif
@endpush
@endif

</div>{{-- end ac-page --}}

<script>
// ── Scroll Reveal ──────────────────────────────────────────
(function () {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    els.forEach(function (el) { observer.observe(el); });
})();

// ── Stats counter animation ────────────────────────────────
(function () {
    var nums = document.querySelectorAll('.ac-stat-num');
    nums.forEach(function (el) {
        var raw = el.textContent.trim();
        var num = parseInt(raw.replace(/[^0-9]/g, ''), 10);
        var suffix = raw.replace(/[0-9]/g, '');
        if (isNaN(num)) return;

        var observer = new IntersectionObserver(function (entries) {
            if (!entries[0].isIntersecting) return;
            observer.disconnect();
            var start = 0;
            var duration = 1600;
            var startTime = null;
            function step(ts) {
                if (!startTime) startTime = ts;
                var progress = Math.min((ts - startTime) / duration, 1);
                var ease = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(ease * num) + suffix;
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }, { threshold: .5 });

        observer.observe(el);
    });
})();
</script>

@endsection
