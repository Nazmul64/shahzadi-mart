@extends('admin.master')
@section('title', 'Add Google Tag')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap');

    .pf-wrap { font-family: 'DM Sans', sans-serif; background: #0c0e14; min-height: 100vh; padding: 2.5rem 2rem; display: flex; flex-direction: column; align-items: center; }
    .pf-inner { width: 100%; max-width: 560px; }
    .pf-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .pf-title { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 700; color: #f0f0f0; }
    .pf-title span { color: #7c6ef7; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1.1rem; background: transparent; border: 1px solid #1e2130; color: #9499b7; font-size: 0.8rem; border-radius: 9px; text-decoration: none; transition: all 0.2s; }
    .btn-back:hover { border-color: #7c6ef7; color: #7c6ef7; }

    .form-card { background: #13151f; border: 1px solid #1e2130; border-radius: 18px; padding: 2.25rem; }
    .field-group { margin-bottom: 1.75rem; }
    .field-label { display: block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.9px; color: #555a72; margin-bottom: 0.65rem; }
    .field-label em { color: #e24b4a; font-style: normal; }
    .field-hint { display: block; margin-top: 0.4rem; font-size: 0.75rem; color: #3d4157; }

    .field-input { width: 100%; padding: 0.85rem 1.1rem; background: #0c0e14; border: 1px solid #1e2130; border-radius: 10px; color: #d8daf0; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box; }
    .field-input::placeholder { color: #363952; }
    .field-input:focus { border-color: #7c6ef7; box-shadow: 0 0 0 3px rgba(124, 110, 247, 0.12); }
    .field-input.is-invalid { border-color: #e24b4a; }
    .field-error { margin-top: 0.5rem; font-size: 0.78rem; color: #e24b4a; }

    .toggle-row { display: flex; align-items: center; gap: 1rem; }
    .toggle-label-text { font-size: 0.875rem; color: #9499b7; }
    .toggle { position: relative; display: inline-block; width: 44px; height: 24px; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; background: #1e2130; border-radius: 24px; cursor: pointer; transition: background 0.25s; }
    .toggle-slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #555a72; border-radius: 50%; transition: transform 0.25s, background 0.25s; }
    .toggle input:checked + .toggle-slider { background: rgba(52, 211, 153, 0.2); }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); background: #34d399; }

    .divider { height: 1px; background: #1e2130; margin: 1.75rem 0; }
    .btn-submit { width: 100%; padding: 0.9rem; background: #7c6ef7; color: #fff; font-family: 'DM Sans', sans-serif; font-size: 0.925rem; font-weight: 500; border: none; border-radius: 11px; cursor: pointer; transition: background 0.2s, transform 0.15s; letter-spacing: 0.3px; }
    .btn-submit:hover { background: #6a5ce8; transform: translateY(-1px); }
    .btn-submit:active { transform: translateY(0); }
</style>

<div class="pf-wrap">
    <div class="pf-inner">

        <div class="pf-header">
            <h1 class="pf-title">Add <span>Google Tag</span></h1>
            <a href="{{ route('admin.googletagmanager.index') }}" class="btn-back">
                ← Back to List
            </a>
        </div>

        <div class="form-card">
            <form action="{{ route('admin.googletagmanager.store') }}" method="POST">
                @csrf

                <div class="field-group">
                    <label class="field-label">Google Tag ID <em>*</em></label>
                    <input type="text"
                           name="google_tag_id"
                           value="{{ old('google_tag_id') }}"
                           class="field-input @error('google_tag_id') is-invalid @enderror"
                           placeholder="e.g. GT-XXXXXXX or GTM-XXXXXXX"
                           required>
                    <span class="field-hint">Enter your Google Tag Manager or Google Analytics 4 Tag ID.</span>
                    @error('google_tag_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Status</label>
                    <div class="toggle-row">
                        <label class="toggle">
                            <input type="checkbox" name="status" value="1" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label-text">Active by default</span>
                    </div>
                </div>

                <div class="divider"></div>

                <button type="submit" class="btn-submit">Save Google Tag</button>
            </form>
        </div>

    </div>
</div>

@endsection
