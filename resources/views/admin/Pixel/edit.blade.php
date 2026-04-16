@extends('admin.master')
@section('title', 'Edit Pixel')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap');

    .pf-wrap { font-family: 'DM Sans', sans-serif; background: #0c0e14; min-height: 100vh; padding: 2.5rem 2rem; display: flex; flex-direction: column; align-items: center; }
    .pf-inner { width: 100%; max-width: 560px; }
    .pf-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .pf-title { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 700; color: #f0f0f0; }
    .pf-title span { color: #fac775; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 0.55rem 1.1rem; background: transparent; border: 1px solid #1e2130; color: #9499b7; font-size: 0.8rem; border-radius: 9px; text-decoration: none; transition: all 0.2s; }
    .btn-back:hover { border-color: #fac775; color: #fac775; }

    .form-card { background: #13151f; border: 1px solid #1e2130; border-radius: 18px; padding: 2.25rem; }

    .edit-meta { display: flex; align-items: center; gap: 10px; margin-bottom: 1.75rem; padding: 0.75rem 1rem; background: rgba(250, 199, 117, 0.06); border: 1px solid rgba(250, 199, 117, 0.15); border-radius: 10px; }
    .edit-meta svg { width: 16px; height: 16px; color: #fac775; flex-shrink: 0; }
    .edit-meta span { font-size: 0.8rem; color: #9499b7; }
    .edit-meta strong { color: #fac775; font-weight: 500; }

    .field-group { margin-bottom: 1.75rem; }
    .field-label { display: block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.9px; color: #555a72; margin-bottom: 0.65rem; }
    .field-label em { color: #e24b4a; font-style: normal; }
    .field-input { width: 100%; padding: 0.85rem 1.1rem; background: #0c0e14; border: 1px solid #1e2130; border-radius: 10px; color: #d8daf0; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box; }
    .field-input::placeholder { color: #363952; }
    .field-input:focus { border-color: #fac775; box-shadow: 0 0 0 3px rgba(250, 199, 117, 0.1); }
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

    .btn-row { display: flex; gap: 10px; }
    .btn-cancel { flex: 1; padding: 0.9rem; background: transparent; border: 1px solid #1e2130; color: #9499b7; font-family: 'DM Sans', sans-serif; font-size: 0.9rem; border-radius: 11px; cursor: pointer; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .btn-cancel:hover { border-color: #555a72; color: #c8cbe0; }
    .btn-update { flex: 2; padding: 0.9rem; background: #fac775; color: #0c0e14; font-family: 'DM Sans', sans-serif; font-size: 0.925rem; font-weight: 600; border: none; border-radius: 11px; cursor: pointer; transition: background 0.2s, transform 0.15s; }
    .btn-update:hover { background: #efb84f; transform: translateY(-1px); }
</style>

<div class="pf-wrap">
    <div class="pf-inner">

        <div class="pf-header">
            <h1 class="pf-title">Edit <span>Pixel</span></h1>
            <a href="{{ route('admin.pixels.index') }}" class="btn-back">
                ← Back to List
            </a>
        </div>

        <div class="form-card">

            <div class="edit-meta">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Editing pixel ID <strong>#{{ $pixel->id }}</strong></span>
            </div>

            <form action="{{ route('admin.pixels.update', $pixel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field-group">
                    <label class="field-label">Pixel ID <em>*</em></label>
                    <input type="text"
                           name="pixel_id"
                           value="{{ old('pixel_id', $pixel->pixel_id) }}"
                           class="field-input @error('pixel_id') is-invalid @enderror"
                           required>
                    @error('pixel_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Status</label>
                    <div class="toggle-row">
                        <label class="toggle">
                            <input type="checkbox" name="status" value="1" {{ $pixel->status ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label-text">{{ $pixel->status ? 'Currently Active' : 'Currently Inactive' }}</span>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="btn-row">
                    <a href="{{ route('admin.pixels.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-update">Update Pixel</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
