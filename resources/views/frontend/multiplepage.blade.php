@extends('frontend.master')

@section('main-content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════
   ROOT TOKENS
═══════════════════════════════════════════════ */
:root {
    --mp-bg:          #f9f7f4;
    --mp-surface:     #ffffff;
    --mp-border:      #e8e4de;
    --mp-ink:         #1c1917;
    --mp-ink-2:       #44403c;
    --mp-ink-3:       #78716c;
    --mp-ink-4:       #a8a29e;
    --mp-accent:      #c2410c;
    --mp-accent-soft: #fff3ef;
    --mp-accent-mid:  #fed7aa;
    --mp-gold:        #d97706;
    --mp-radius:      12px;
    --mp-radius-lg:   20px;
    --mp-shadow:      0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    --mp-shadow-lg:   0 8px 32px rgba(0,0,0,.10);
    --mp-font-serif:  'Playfair Display', Georgia, serif;
    --mp-font-sans:   'Inter', system-ui, sans-serif;
    --mp-max:         800px;
    --mp-wide:        1100px;
}

/* ═══════════════════════════════════════════════
   BASE RESET FOR THIS PAGE
═══════════════════════════════════════════════ */
.mp-root * { box-sizing: border-box; }
.mp-root {
    font-family: var(--mp-font-sans);
    background: var(--mp-bg);
    min-height: 100vh;
    color: var(--mp-ink);
}

/* ═══════════════════════════════════════════════
   TOP BAND — thin accent stripe
═══════════════════════════════════════════════ */
.mp-topband {
    height: 4px;
    background: linear-gradient(90deg, var(--mp-accent) 0%, var(--mp-gold) 60%, var(--mp-accent) 100%);
}

/* ═══════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════ */
.mp-hero {
    background: var(--mp-ink);
    position: relative;
    overflow: hidden;
    padding: 72px 24px 64px;
}

/* subtle dot-grid texture */
.mp-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

/* warm glow blob */
.mp-hero::after {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(194,65,12,.25) 0%, transparent 70%);
    pointer-events: none;
}

.mp-hero-inner {
    position: relative;
    max-width: var(--mp-max);
    margin: 0 auto;
    z-index: 1;
}

/* breadcrumb */
.mp-crumb {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    font-size: .78rem;
    font-weight: 500;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: rgba(255,255,255,.45);
    margin-bottom: 28px;
}
.mp-crumb a {
    color: rgba(255,255,255,.55);
    text-decoration: none;
    transition: color .2s;
}
.mp-crumb a:hover { color: var(--mp-accent-mid); }
.mp-crumb-sep { color: rgba(255,255,255,.2); font-size: .7rem; }
.mp-crumb-cur { color: rgba(255,255,255,.75); }

/* category pill */
.mp-hero-cat {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(194,65,12,.2);
    border: 1px solid rgba(194,65,12,.35);
    color: var(--mp-accent-mid);
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 999px;
    margin-bottom: 20px;
}
.mp-hero-cat i { font-size: .7rem; }

/* main title */
.mp-hero-title {
    font-family: var(--mp-font-serif);
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 600;
    color: #fff;
    line-height: 1.15;
    letter-spacing: -.02em;
    margin: 0 0 28px;
}
.mp-hero-title em {
    font-style: italic;
    font-weight: 400;
    color: var(--mp-accent-mid);
}

/* divider line + dot */
.mp-hero-divider {
    display: flex;
    align-items: center;
    gap: 12px;
}
.mp-hero-divider-line {
    width: 56px;
    height: 2px;
    background: linear-gradient(90deg, var(--mp-accent), transparent);
    border-radius: 2px;
}
.mp-hero-divider-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--mp-accent);
    flex-shrink: 0;
}

/* ═══════════════════════════════════════════════
   MAIN LAYOUT
═══════════════════════════════════════════════ */

@media (max-width: 900px) {
    .mp-layout { grid-template-columns: 1fr; }
    .mp-sidebar { order: -1; }
}

/* ═══════════════════════════════════════════════
   ARTICLE CARD
═══════════════════════════════════════════════ */
.mp-article {
    background: var(--mp-surface);
    border-radius: var(--mp-radius-lg);
    box-shadow: var(--mp-shadow);
    overflow: hidden;
}

/* article top bar */
.mp-article-bar {
    height: 3px;
    background: linear-gradient(90deg, var(--mp-accent), var(--mp-gold));
}

.mp-article-body { padding: 40px 44px 48px; }
@media (max-width: 600px) { .mp-article-body { padding: 28px 22px 36px; } }

/* ── Typography inside article ── */
.mp-prose {
    font-size: 1.02rem;
    line-height: 1.92;
    color: var(--mp-ink-2);
    font-weight: 400;
}
.mp-prose p { margin: 0 0 1.4em; }
.mp-prose p:last-child { margin-bottom: 0; }

.mp-prose h1,
.mp-prose h2,
.mp-prose h3,
.mp-prose h4 {
    font-family: var(--mp-font-serif);
    font-weight: 600;
    color: var(--mp-ink);
    line-height: 1.3;
    margin: 2em 0 .7em;
}
.mp-prose h1 { font-size: 1.8rem; }
.mp-prose h2 { font-size: 1.45rem; }
.mp-prose h3 { font-size: 1.2rem; }
.mp-prose h4 { font-size: 1.05rem; }

/* first heading no top margin */
.mp-prose > h1:first-child,
.mp-prose > h2:first-child,
.mp-prose > h3:first-child { margin-top: 0; }

.mp-prose a {
    color: var(--mp-accent);
    text-decoration: underline;
    text-underline-offset: 3px;
}
.mp-prose a:hover { color: var(--mp-gold); }

.mp-prose strong { font-weight: 600; color: var(--mp-ink); }
.mp-prose em     { font-style: italic; }

.mp-prose ul,
.mp-prose ol {
    padding-left: 1.5em;
    margin: 0 0 1.4em;
}
.mp-prose li { margin-bottom: .5em; }

.mp-prose blockquote {
    margin: 1.8em 0;
    padding: 18px 24px;
    background: var(--mp-accent-soft);
    border-left: 3px solid var(--mp-accent);
    border-radius: 0 8px 8px 0;
    font-style: italic;
    color: var(--mp-ink-2);
}
.mp-prose blockquote p { margin: 0; }

.mp-prose img {
    max-width: 100%;
    border-radius: 10px;
    margin: 1.6em 0;
    box-shadow: var(--mp-shadow);
}

.mp-prose table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.6em 0;
    font-size: .93rem;
}
.mp-prose th,
.mp-prose td {
    padding: 10px 14px;
    border: 1px solid var(--mp-border);
    text-align: left;
}
.mp-prose th {
    background: var(--mp-bg);
    font-weight: 600;
    color: var(--mp-ink);
}

.mp-prose hr {
    border: none;
    border-top: 1px solid var(--mp-border);
    margin: 2em 0;
}

.mp-prose code {
    background: #f3f4f6;
    color: var(--mp-accent);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: .88em;
}
.mp-prose pre {
    background: var(--mp-ink);
    color: #e5e7eb;
    padding: 20px 24px;
    border-radius: 10px;
    overflow-x: auto;
    font-size: .88rem;
    margin: 1.6em 0;
}
.mp-prose pre code {
    background: none;
    color: inherit;
    padding: 0;
}

/* ── Article footer ── */
.mp-article-footer {
    padding: 20px 44px 28px;
    border-top: 1px solid var(--mp-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
@media (max-width: 600px) { .mp-article-footer { padding: 16px 22px 22px; } }

.mp-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--mp-bg);
    border: 1px solid var(--mp-border);
    color: var(--mp-ink-2);
    font-size: .86rem;
    font-weight: 500;
    padding: 9px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: all .2s;
}
.mp-back-btn:hover {
    background: var(--mp-ink);
    border-color: var(--mp-ink);
    color: #fff;
    transform: translateX(-2px);
}

.mp-share-label {
    font-size: .8rem;
    color: var(--mp-ink-4);
    font-weight: 500;
    letter-spacing: .05em;
    text-transform: uppercase;
}

/* ═══════════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════════ */
.mp-sidebar { display: flex; flex-direction: column; gap: 20px; }

/* sidebar widget */
.mp-widget {
    background: var(--mp-surface);
    border-radius: var(--mp-radius);
    box-shadow: var(--mp-shadow);
    overflow: hidden;
}
.mp-widget-head {
    padding: 14px 18px;
    border-bottom: 1px solid var(--mp-border);
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--mp-ink-3);
    display: flex;
    align-items: center;
    gap: 8px;
}
.mp-widget-head i { color: var(--mp-accent); font-size: .75rem; }
.mp-widget-body { padding: 6px 0; }

/* category group */
.mp-cat-group { padding: 10px 0 4px; }
.mp-cat-group:not(:first-child) { border-top: 1px solid var(--mp-border); margin-top: 2px; }

.mp-cat-title {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--mp-accent);
    padding: 4px 18px 8px;
}

.mp-cat-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    font-size: .88rem;
    color: var(--mp-ink-2);
    text-decoration: none;
    border-radius: 0;
    transition: background .15s, color .15s, padding-left .15s;
    position: relative;
}
.mp-cat-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 0;
    background: var(--mp-accent);
    border-radius: 0 3px 3px 0;
    transition: height .2s;
}
.mp-cat-link:hover { background: var(--mp-accent-soft); color: var(--mp-accent); padding-left: 22px; }
.mp-cat-link:hover::before { height: 60%; }
.mp-cat-link.active {
    background: var(--mp-accent-soft);
    color: var(--mp-accent);
    font-weight: 600;
}
.mp-cat-link.active::before { height: 60%; }
.mp-cat-link i { font-size: .65rem; color: var(--mp-ink-4); transition: color .15s; }
.mp-cat-link:hover i,
.mp-cat-link.active i { color: var(--mp-accent); }

/* info widget */
.mp-info-list { padding: 14px 18px; }
.mp-info-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid var(--mp-border);
    font-size: .84rem;
}
.mp-info-row:last-child { border-bottom: none; }
.mp-info-row i { color: var(--mp-accent); margin-top: 2px; font-size: .8rem; flex-shrink: 0; }
.mp-info-label { font-weight: 600; color: var(--mp-ink-3); min-width: 60px; }
.mp-info-val   { color: var(--mp-ink-2); flex: 1; }

/* ═══════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════ */
@media (max-width: 600px) {
    .mp-hero { padding: 52px 20px 44px; }
    .mp-layout { padding: 28px 16px 56px; gap: 20px; }
}
</style>

<div class="mp-root">

    {{-- ── Top accent band ── --}}
    <div class="mp-topband"></div>

    {{-- ══════════════════════════════════════════
         HERO
    ══════════════════════════════════════════ --}}
    <header class="mp-hero">
        <div class="mp-hero-inner">

            {{-- Breadcrumb --}}
            <nav class="mp-crumb">
                <a href="{{ url('/') }}"><i class="bi bi-house-fill"></i> Home</a>
                <span class="mp-crumb-sep"><i class="bi bi-chevron-right"></i></span>

                @if($page->footercategory)
                    <span class="mp-crumb-cur">{{ $page->footercategory->category_name }}</span>
                    <span class="mp-crumb-sep"><i class="bi bi-chevron-right"></i></span>
                @endif

                <span class="mp-crumb-cur">{{ $page->name }}</span>
            </nav>

            {{-- Category pill --}}
            @if($page->footercategory)
            <div class="mp-hero-cat">
                <i class="bi bi-folder2-open"></i>
                {{ $page->footercategory->category_name }}
            </div>
            @endif

            {{-- Title --}}
            <h1 class="mp-hero-title">{{ $page->title }}</h1>

            {{-- Decorative divider --}}
            <div class="mp-hero-divider">
                <div class="mp-hero-divider-line"></div>
                <div class="mp-hero-divider-dot"></div>
            </div>

        </div>
    </header>

    {{-- ══════════════════════════════════════════
         MAIN LAYOUT
    ══════════════════════════════════════════ --}}
    <div class="mp-layout">

        {{-- ── Article ── --}}
        <main>
            <article class="mp-article">

                <div class="mp-article-bar"></div>

                <div class="mp-article-body">
                    <div class="mp-prose">
                        {!! $page->description !!}
                    </div>
                </div>

                <div class="mp-article-footer">
                    <a href="javascript:history.back()" class="mp-back-btn">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <span class="mp-share-label">
                        <i class="bi bi-clock me-1"></i>
                        {{ $page->updated_at->format('d M Y') }}
                    </span>
                </div>

            </article>
        </main>


    </div>{{-- /.mp-layout --}}

</div>{{-- /.mp-root --}}

@endsection
