@extends('manager.master')

@section('title', isset($supplier) ? 'Edit Supplier' : 'Add Supplier')

@section('main-content')
<style>
:root {
    --pur-bg: #0f172a;
    --pur-card: #1e293b;
    --pur-border: rgba(255,255,255,0.07);
    --pur-accent: #3b82f6;
    --pur-accent2: #8b5cf6;
    --pur-text: #94a3b8;
    --pur-heading: #f1f5f9;
    --pur-input-bg: rgba(255,255,255,0.04);
}

.pm-wrap {
    padding: 28px 32px;
    min-height: 100vh;
    background: var(--pur-bg);
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
}

.pm-top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
}

.pm-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--pur-heading);
    display: flex;
    align-items: center;
    gap: 12px;
}

.pm-title i {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--pur-accent), var(--pur-accent2));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    box-shadow: 0 4px 16px rgba(59,130,246,0.35);
}

.pm-card {
    background: var(--pur-card);
    border: 1px solid var(--pur-border);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.2);
    max-width: 700px;
}

.pm-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.pm-form-full {
    grid-column: 1 / -1;
}

.pm-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: var(--pur-text);
    margin-bottom: 8px;
}

.pm-input {
    width: 100%;
    background: var(--pur-input-bg);
    border: 1px solid var(--pur-border);
    border-radius: 10px;
    color: var(--pur-heading);
    padding: 11px 16px;
    font-size: 14px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
    box-sizing: border-box;
}

.pm-input:focus {
    border-color: var(--pur-accent);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

.pm-input option { background: #1e293b; }

.pm-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    cursor: pointer;
    border: none;
}

.pm-btn-primary {
    background: linear-gradient(135deg, var(--pur-accent), var(--pur-accent2));
    color: #fff;
    box-shadow: 0 4px 14px rgba(59,130,246,0.3);
}
.pm-btn-primary:hover { transform: translateY(-1px); color: #fff; }

.pm-btn-ghost {
    background: rgba(255,255,255,0.05);
    color: var(--pur-text);
    border: 1px solid var(--pur-border);
}
.pm-btn-ghost:hover { background: rgba(255,255,255,0.1); color: var(--pur-heading); }

.pm-error { color: #f87171; font-size: 12px; margin-top: 5px; }

.pm-form-actions {
    display: flex;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--pur-border);
}
</style>

<div class="pm-wrap">
    <div class="pm-top">
        <div class="pm-title">
            <i class="bi bi-person-badge-fill"></i>
            {{ isset($supplier) ? 'Edit Supplier' : 'Add Supplier' }}
        </div>
    </div>

    <div class="pm-card">
        <form action="{{ isset($supplier) ? route('manager.suppliers.update', $supplier->id) : route('admin.suppliers.store') }}"
              method="POST">
            @csrf
            @if(isset($supplier)) @method('PUT') @endif

            <div class="pm-form-grid">
                <div>
                    <label class="pm-label">Supplier Name <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" class="pm-input" placeholder="e.g. Rahman Traders"
                        value="{{ old('name', $supplier->name ?? '') }}">
                    @error('name')<p class="pm-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="pm-label">Company Name</label>
                    <input type="text" name="company_name" class="pm-input" placeholder="Company / Business name"
                        value="{{ old('company_name', $supplier->company_name ?? '') }}">
                </div>

                <div>
                    <label class="pm-label">Phone</label>
                    <input type="text" name="phone" class="pm-input" placeholder="01XXXXXXXXX"
                        value="{{ old('phone', $supplier->phone ?? '') }}">
                </div>

                <div>
                    <label class="pm-label">Email</label>
                    <input type="email" name="email" class="pm-input" placeholder="supplier@email.com"
                        value="{{ old('email', $supplier->email ?? '') }}">
                    @error('email')<p class="pm-error">{{ $message }}</p>@enderror
                </div>

                <div class="pm-form-full">
                    <label class="pm-label">Address</label>
                    <textarea name="address" class="pm-input" rows="3"
                        placeholder="Full address of the supplier">{{ old('address', $supplier->address ?? '') }}</textarea>
                </div>

                <div>
                    <label class="pm-label">Status</label>
                    <select name="status" class="pm-input">
                        <option value="1" {{ old('status', $supplier->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $supplier->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="pm-form-actions">
                <button type="submit" class="pm-btn pm-btn-primary">
                    <i class="bi bi-check-lg"></i>
                    {{ isset($supplier) ? 'Update Supplier' : 'Save Supplier' }}
                </button>
                <a href="{{ route('manager.suppliers.index') }}" class="pm-btn pm-btn-ghost">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
