@extends('admin.master')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --bg-base:    #09090b;
        --bg-surface: #111114;
        --bg-card:    #18181b;
        --bg-hover:   #1f1f23;
        --border:     #27272a;
        --border-focus: #7c3aed;
        --text-1:     #fafafa;
        --text-2:     #a1a1aa;
        --text-3:     #52525b;
        --accent:     #7c3aed;
        --accent-2:   #a78bfa;
        --accent-bg:  rgba(124,58,237,0.1);
        --red:        #ef4444;
        --red-bg:     rgba(239,68,68,0.08);
        --red-border: rgba(239,68,68,0.25);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .fw {
        font-family: 'Inter', sans-serif;
        background: var(--bg-base);
        min-height: 100vh;
        padding: 32px 36px;
    }

    /* ── Topbar ── */
    .topbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 32px;
    }
    .topbar h1 { font-size: 24px; font-weight: 700; color: var(--text-1); letter-spacing: -0.5px; }
    .topbar p  { font-size: 13px; color: var(--text-3); margin-top: 4px; }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        color: var(--text-2);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 500;
        padding: 9px 17px;
        border-radius: 9px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back:hover { border-color: #3f3f46; color: var(--text-1); background: var(--bg-hover); text-decoration: none; }

    /* ── Layout ── */
    .layout { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .layout { grid-template-columns: 1fr; } }

    /* ── Main Form Card ── */
    .fcard {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .fcard-head {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .fcard-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--accent-bg);
        border: 1px solid rgba(167,139,250,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-2);
        font-size: 14px;
        flex-shrink: 0;
    }
    .fcard-head h2 { font-size: 15px; font-weight: 600; color: var(--text-1); }
    .fcard-head p  { font-size: 12px; color: var(--text-3); margin-top: 2px; }
    .fcard-body { padding: 24px; }

    /* ── Error alert ── */
    .err-alert {
        background: var(--red-bg);
        border: 1px solid var(--red-border);
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 22px;
    }
    .err-alert ul { padding-left: 16px; }
    .err-alert li { font-size: 13px; color: #fca5a5; margin-bottom: 4px; }
    .err-alert li:last-child { margin-bottom: 0; }

    /* ── Form elements ── */
    .fg { margin-bottom: 20px; }
    .fg:last-child { margin-bottom: 0; }
    label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-3);
        margin-bottom: 8px;
    }
    label .req { color: var(--red); margin-left: 2px; }
    label .opt {
        font-size: 10.5px;
        text-transform: none;
        letter-spacing: 0;
        font-weight: 500;
        color: var(--text-3);
        background: var(--bg-surface);
        border: 1px solid var(--border);
        padding: 2px 7px;
        border-radius: 4px;
        margin-left: 6px;
    }

    .fi, .ft {
        width: 100%;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text-1);
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        padding: 11px 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .fi:focus, .ft:focus {
        border-color: var(--border-focus);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.15);
        background: #0f0f12;
    }
    .fi::placeholder, .ft::placeholder { color: var(--text-3); }
    .fi.err, .ft.err { border-color: var(--red) !important; }
    .fi.err:focus, .ft.err:focus { box-shadow: 0 0 0 3px var(--red-bg); }

    .ft { resize: vertical; min-height: 96px; }
    .ft.mono {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12.5px;
        color: var(--text-2);
        min-height: 110px;
    }

    .ferr {
        font-size: 12px;
        color: #fca5a5;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 580px) { .grid2 { grid-template-columns: 1fr; } }

    .divider { border: none; border-top: 1px solid var(--border); margin: 22px 0; }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--accent);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 600;
        padding: 11px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 0 0 1px rgba(124,58,237,0.4), 0 4px 16px rgba(124,58,237,0.2);
    }
    .btn-save:hover { background: #6d28d9; transform: translateY(-1px); }

    /* ── Sidebar ── */
    .sidebar { display: flex; flex-direction: column; gap: 14px; }
    .side-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .side-card-head {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-3);
    }
    .side-card-body { padding: 16px; }

    .tip-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }
    .tip-row:last-child { margin-bottom: 0; }
    .tip-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent);
        flex-shrink: 0;
        margin-top: 5px;
    }
    .tip-row p { font-size: 12.5px; color: var(--text-2); line-height: 1.55; }

    .req-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
    }
    .req-row:last-child { border-bottom: none; }
    .req-row i { font-size: 11px; color: var(--text-3); width: 14px; text-align: center; }
    .req-row span { font-size: 12.5px; color: var(--text-2); }
    .req-row .tag-req { font-size: 10px; font-weight: 700; color: var(--red); background: var(--red-bg); padding: 2px 6px; border-radius: 4px; margin-left: auto; }
    .req-row .tag-opt { font-size: 10px; font-weight: 700; color: var(--text-3); background: var(--bg-surface); border: 1px solid var(--border); padding: 2px 6px; border-radius: 4px; margin-left: auto; }
</style>

<div class="fw">

    {{-- Topbar ──────────────────────────── --}}
    <div class="topbar">
        <div>
            <h1>Add Contact</h1>
            <p>Fill in the form to create a new contact record</p>
        </div>
        <a href="{{ route('admin.contact.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="layout">

        {{-- Main Form ──────────────────── --}}
        <div class="fcard">
            <div class="fcard-head">
                <div class="fcard-icon"><i class="fas fa-address-card"></i></div>
                <div>
                    <h2>Contact Information</h2>
                    <p>Fields marked * are required</p>
                </div>
            </div>
            <div class="fcard-body">

                @if($errors->any())
                    <div class="err-alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.contact.store') }}" method="POST">
                    @csrf

                    <div class="grid2">
                        <div class="fg">
                            <label for="contact_number">Contact Number <span class="req">*</span></label>
                            <input type="text"
                                   name="contact_number"
                                   id="contact_number"
                                   class="fi @error('contact_number') err @enderror"
                                   value="{{ old('contact_number') }}"
                                   placeholder="+880 1XXX-XXXXXX">
                            @error('contact_number')
                                <div class="ferr"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="fg">
                            <label for="email">Email Address <span class="req">*</span></label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="fi @error('email') err @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="you@example.com">
                            @error('email')
                                <div class="ferr"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="fg">
                        <label for="address">Address <span class="req">*</span></label>
                        <textarea name="address"
                                  id="address"
                                  class="ft @error('address') err @enderror"
                                  placeholder="Enter full physical address…">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="ferr"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="divider">

                    <div class="fg">
                        <label for="google_map_embed_code">
                            Google Map Embed Code <span class="opt">Optional</span>
                        </label>
                        <textarea name="google_map_embed_code"
                                  id="google_map_embed_code"
                                  class="ft mono @error('google_map_embed_code') err @enderror"
                                  placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'>{{ old('google_map_embed_code') }}</textarea>
                        @error('google_map_embed_code')
                            <div class="ferr"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="divider">

                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Contact
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar ────────────────────── --}}
        <div class="sidebar">

            <div class="side-card">
                <div class="side-card-head">
                    <i class="fas fa-list-ul"></i> Field Summary
                </div>
                <div class="side-card-body">
                    <div class="req-row">
                        <i class="fas fa-phone"></i>
                        <span>Contact Number</span>
                        <span class="tag-req">Required</span>
                    </div>
                    <div class="req-row">
                        <i class="fas fa-envelope"></i>
                        <span>Email Address</span>
                        <span class="tag-req">Required</span>
                    </div>
                    <div class="req-row">
                        <i class="fas fa-map-pin"></i>
                        <span>Address</span>
                        <span class="tag-req">Required</span>
                    </div>
                    <div class="req-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Map Embed Code</span>
                        <span class="tag-opt">Optional</span>
                    </div>
                </div>
            </div>

            <div class="side-card">
                <div class="side-card-head">
                    <i class="fas fa-lightbulb"></i> Tips
                </div>
                <div class="side-card-body">
                    <div class="tip-row">
                        <div class="tip-dot"></div>
                        <p>Use international format for phone numbers, e.g. <strong>+880 1700-000000</strong></p>
                    </div>
                    <div class="tip-row">
                        <div class="tip-dot"></div>
                        <p>Get the embed code from Google Maps → Share → Embed a map</p>
                    </div>
                    <div class="tip-row">
                        <div class="tip-dot"></div>
                        <p>Only one contact record is shown on the website at a time</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
