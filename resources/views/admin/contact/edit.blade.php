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
        --border-focus: #f59e0b;
        --text-1:     #fafafa;
        --text-2:     #a1a1aa;
        --text-3:     #52525b;
        --amber:      #f59e0b;
        --amber-2:    #fbbf24;
        --amber-bg:   rgba(245,158,11,0.1);
        --amber-border: rgba(245,158,11,0.2);
        --red:        #ef4444;
        --red-bg:     rgba(239,68,68,0.08);
        --red-border: rgba(239,68,68,0.25);
        --green:      #22c55e;
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
    .layout { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
    @media (max-width: 900px) { .layout { grid-template-columns: 1fr; } }

    /* ── Record Banner ── */
    .rec-banner {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-top: 2px solid var(--amber);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }
    .rec-avatar {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        background: var(--amber-bg);
        border: 1px solid var(--amber-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--amber-2);
        font-size: 16px;
        flex-shrink: 0;
    }
    .rec-info h3 { font-size: 14px; font-weight: 600; color: var(--text-1); }
    .rec-info p  { font-size: 12px; color: var(--text-3); margin-top: 3px; font-family: 'JetBrains Mono', monospace; }
    .rec-badges { margin-left: auto; display: flex; flex-direction: column; align-items: flex-end; gap: 5px; }
    .id-chip {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        background: var(--amber-bg);
        color: var(--amber-2);
        border: 1px solid var(--amber-border);
        padding: 4px 10px;
        border-radius: 6px;
    }
    .upd-chip {
        font-size: 11px;
        color: var(--text-3);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Form Card ── */
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
        background: var(--amber-bg);
        border: 1px solid var(--amber-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--amber-2);
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

    /* ── Form ── */
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
        box-shadow: 0 0 0 3px rgba(245,158,11,0.12);
        background: #0f0f12;
    }
    .fi::placeholder, .ft::placeholder { color: var(--text-3); }
    .fi.err, .ft.err { border-color: var(--red) !important; }
    .fi.err:focus, .ft.err:focus { box-shadow: 0 0 0 3px var(--red-bg); }
    .ft { resize: vertical; min-height: 96px; }
    .ft.mono { font-family: 'JetBrains Mono', monospace; font-size: 12.5px; color: var(--text-2); min-height: 110px; }

    .ferr { font-size: 12px; color: #fca5a5; margin-top: 6px; display: flex; align-items: center; gap: 5px; }

    .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 580px) { .grid2 { grid-template-columns: 1fr; } }
    .divider { border: none; border-top: 1px solid var(--border); margin: 22px 0; }

    .btn-update {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--amber);
        color: #000;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 700;
        padding: 11px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 0 0 1px rgba(245,158,11,0.4), 0 4px 16px rgba(245,158,11,0.15);
    }
    .btn-update:hover { background: #d97706; transform: translateY(-1px); }

    /* ── Sidebar ── */
    .sidebar { display: flex; flex-direction: column; gap: 14px; }
    .side-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .side-head {
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
    .side-body { padding: 16px; }

    .meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
        font-size: 12.5px;
    }
    .meta-row:last-child { border-bottom: none; }
    .meta-row .ml { color: var(--text-3); }
    .meta-row .mr { color: var(--text-2); font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    .warn-box {
        background: rgba(245,158,11,0.06);
        border: 1px solid rgba(245,158,11,0.15);
        border-radius: 10px;
        padding: 13px 15px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .warn-box i { color: var(--amber-2); font-size: 13px; margin-top: 1px; flex-shrink: 0; }
    .warn-box p { font-size: 12.5px; color: var(--text-2); line-height: 1.55; }
</style>

<div class="fw">

    {{-- Topbar ─────────────────────────── --}}
    <div class="topbar">
        <div>
            <h1>Edit Contact</h1>
            <p>Update existing contact information</p>
        </div>
        <a href="{{ route('admin.contact.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Record Banner ───────────────────── --}}
    <div class="rec-banner">
        <div class="rec-avatar"><i class="fas fa-pen"></i></div>
        <div class="rec-info">
            <h3>Editing Contact Record</h3>
            <p>{{ $contact->contact_number }} &nbsp;·&nbsp; {{ $contact->email }}</p>
        </div>
        <div class="rec-badges">
            <span class="id-chip"># {{ str_pad($contact->id, 4, '0', STR_PAD_LEFT) }}</span>
            <span class="upd-chip"><i class="fas fa-clock"></i> {{ $contact->updated_at->diffForHumans() }}</span>
        </div>
    </div>

    <div class="layout">

        {{-- Form ───────────────────────── --}}
        <div class="fcard">
            <div class="fcard-head">
                <div class="fcard-icon"><i class="fas fa-address-card"></i></div>
                <div>
                    <h2>Update Details</h2>
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

                <form action="{{ route('admin.contact.update', $contact->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid2">
                        <div class="fg">
                            <label for="contact_number">Contact Number <span class="req">*</span></label>
                            <input type="text"
                                   name="contact_number"
                                   id="contact_number"
                                   class="fi @error('contact_number') err @enderror"
                                   value="{{ old('contact_number', $contact->contact_number) }}"
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
                                   value="{{ old('email', $contact->email) }}"
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
                                  placeholder="Enter full physical address…">{{ old('address', $contact->address) }}</textarea>
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
                                  placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'>{{ old('google_map_embed_code', $contact->google_map_embed_code) }}</textarea>
                        @error('google_map_embed_code')
                            <div class="ferr"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="divider">

                    <button type="submit" class="btn-update">
                        <i class="fas fa-sync-alt"></i> Update Contact
                    </button>
                </form>
            </div>
        </div>

        {{-- Sidebar ────────────────────── --}}
        <div class="sidebar">

            <div class="side-card">
                <div class="side-head"><i class="fas fa-info-circle"></i> Record Info</div>
                <div class="side-body">
                    <div class="meta-row">
                        <span class="ml">Record ID</span>
                        <span class="mr">#{{ $contact->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="ml">Created</span>
                        <span class="mr">{{ $contact->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="ml">Last Modified</span>
                        <span class="mr">{{ $contact->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="ml">Map Status</span>
                        <span class="mr" style="color: {{ $contact->google_map_embed_code ? 'var(--green)' : 'var(--text-3)' }}">
                            {{ $contact->google_map_embed_code ? 'Available' : 'Not Set' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="warn-box">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Saving will overwrite the existing record. Make sure all fields are correct before updating.</p>
            </div>

        </div>
    </div>

</div>
@endsection
