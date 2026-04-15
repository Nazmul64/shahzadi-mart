@extends('admin.master')

@section('main-content')
<style>
    :root {
        --primary: #6c5ce7;
        --primary-light: #f0eeff;
        --success: #00b894;
        --danger: #e8192c;
        --dark: #1a1a2e;
        --text: #374151;
        --muted: #9ca3af;
        --border: #e5e7eb;
        --bg: #f8f9fb;
        --card: #ffffff;
    }

    .page-wrapper { padding: 24px; background: var(--bg); min-height: 100vh; }

    .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .page-title i { color: #f59e0b; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--bg);
        color: var(--text);
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--border);
        transition: all .2s;
    }
    .btn-back:hover { border-color: var(--primary); color: var(--primary); }

    /* Edit info strip */
    .edit-strip {
        background: #fffbeb;
        border: 1.5px solid #fde68a;
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 13px;
        color: #92400e;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .form-card {
        background: var(--card);
        border-radius: 16px;
        border: 1.5px solid var(--border);
        overflow: hidden;
        max-width: 800px;
    }
    .form-card-head {
        padding: 18px 26px;
        border-bottom: 1.5px solid var(--border);
        background: linear-gradient(135deg, #fffbeb, #fff);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-head h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .form-card-head i { color: #f59e0b; font-size: 20px; }
    .form-card-body { padding: 28px 26px; }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        margin-bottom: 22px;
    }
    .form-group { display: flex; flex-direction: column; gap: 7px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-label .required { color: var(--danger); }
    .form-label i { color: var(--primary); font-size: 13px; }

    .form-control {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 14px;
        color: var(--text);
        outline: none;
        transition: border .2s, box-shadow .2s;
        background: var(--bg);
        width: 100%;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(108,92,231,.12);
        background: #fff;
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .invalid-feedback { font-size: 12px; color: var(--danger); font-weight: 600; }

    .toggle-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        background: var(--bg);
        border-radius: 10px;
        border: 1.5px solid var(--border);
    }
    .toggle-switch { position: relative; display: inline-block; width: 52px; height: 28px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0;
        background: #d1d5db;
        border-radius: 28px;
        cursor: pointer;
        transition: background .3s;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 22px; height: 22px;
        left: 3px; top: 3px;
        background: #fff;
        border-radius: 50%;
        transition: transform .3s;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--success); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(24px); }
    .toggle-text { font-size: 14px; font-weight: 600; color: var(--text); }
    .toggle-desc { font-size: 12px; color: var(--muted); margin-top: 2px; }

    .form-actions { display: flex; gap: 12px; align-items: center; padding-top: 8px; }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f59e0b;
        color: #fff;
        padding: 13px 28px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .btn-submit:hover { background: #d97706; transform: scale(1.01); }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--bg);
        color: var(--muted);
        padding: 13px 22px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid var(--border);
        transition: all .2s;
    }
    .btn-cancel:hover { border-color: var(--danger); color: var(--danger); }

    @media(max-width:576px){ .form-grid { grid-template-columns: 1fr; } }
</style>

<div class="page-wrapper">

    {{-- Top Bar --}}
    <div class="top-bar">
        <h1 class="page-title">
            <i class="bi bi-pencil-square"></i> শিপিং চার্জ সম্পাদনা
        </h1>
        <a href="{{ route('admin.shipping.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> ফিরে যান
        </a>
    </div>

    {{-- Edit Info Strip --}}
    <div class="edit-strip">
        <i class="bi bi-info-circle-fill"></i>
        আপনি এখন <strong>"{{ $shipping->area_name }}"</strong> শিপিং চার্জটি সম্পাদনা করছেন।
    </div>

    <div class="form-card">
        <div class="form-card-head">
            <i class="bi bi-pencil-fill"></i>
            <h2>তথ্য আপডেট করুন</h2>
        </div>
        <div class="form-card-body">

            <form action="{{ route('admin.shipping.update', $shipping->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    {{-- Area Name --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-geo-alt-fill"></i>
                            এলাকার নাম <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="area_name"
                               class="form-control @error('area_name') is-invalid @enderror"
                               placeholder="যেমন: ঢাকা, চট্টগ্রাম..."
                               value="{{ old('area_name', $shipping->area_name) }}">
                        @error('area_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-currency-dollar"></i>
                            চার্জ পরিমাণ (৳) <span class="required">*</span>
                        </label>
                        <input type="number"
                               name="amount"
                               class="form-control @error('amount') is-invalid @enderror"
                               placeholder="যেমন: 70"
                               value="{{ old('amount', $shipping->amount) }}"
                               min="0"
                               step="0.01">
                        @error('amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group full">
                        <label class="form-label">
                            <i class="bi bi-toggle-on"></i>
                            স্ট্যাটাস
                        </label>
                        <div class="toggle-wrap">
                            <label class="toggle-switch">
                                <input type="checkbox"
                                       name="status"
                                       value="active"
                                       {{ old('status', $shipping->status) === 'active' ? 'checked' : '' }}
                                       id="statusToggle">
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <div class="toggle-text" id="statusText">
                                    {{ $shipping->status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </div>
                                <div class="toggle-desc">এই শিপিং চার্জটি চেকআউটে দেখাবে</div>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="inactive" id="statusHidden">
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-arrow-repeat"></i> আপডেট করুন
                    </button>
                    <a href="{{ route('admin.shipping.index') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> বাতিল
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    const toggle = document.getElementById('statusToggle');
    const text   = document.getElementById('statusText');
    const hidden = document.getElementById('statusHidden');

    function updateStatus() {
        if (toggle.checked) {
            text.textContent = 'সক্রিয়';
            hidden.disabled  = true;
        } else {
            text.textContent = 'নিষ্ক্রিয়';
            hidden.disabled  = false;
        }
    }
    toggle.addEventListener('change', updateStatus);
    updateStatus();
</script>
@endsection
