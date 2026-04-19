@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }

.pay-wrapper {
    background: #f4f6fb;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    padding: 0;
}

.pay-topbar {
    background: #fff;
    border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pay-topbar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.pay-content { padding: 24px; }

/* ── Section Card ── */
.pay-section {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    margin-bottom: 24px;
    overflow: hidden;
}

.pay-section-title {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f2f8;
    background: #fafbff;
}

.pay-form-body {
    padding: 24px;
}

/* ── Grid ── */
.pay-row {
    display: grid;
    gap: 20px;
    margin-bottom: 20px;
}
.pay-row.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
.pay-row.cols-2 { grid-template-columns: 1fr 1fr; }
.pay-row.cols-1 { grid-template-columns: 1fr; }

/* ── Form Groups ── */
.pay-group { display: flex; flex-direction: column; gap: 6px; }

.pay-label {
    font-size: 13px;
    font-weight: 600;
    color: #3a4259;
}
.pay-label span { color: #e74c3c; margin-left: 2px; }

.pay-input {
    border: 1px solid #dde2ec;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
    color: #2d3748;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
    background: #fff;
}
.pay-input:focus {
    border-color: #19cac4;
    box-shadow: 0 0 0 3px rgba(25,202,196,.1);
}

/* ── Toggle Switch ── */
.toggle-wrap {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.toggle-label-text {
    font-size: 13px;
    font-weight: 600;
    color: #3a4259;
}
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
    margin-top: 6px;
}
.toggle-switch input { display: none; }
.toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #cbd5e0;
    border-radius: 34px;
    transition: .3s;
}
.toggle-slider:before {
    content: '';
    position: absolute;
    width: 22px;
    height: 22px;
    left: 3px;
    bottom: 3px;
    background: #fff;
    border-radius: 50%;
    transition: .3s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-slider { background: #19cac4; }
.toggle-switch input:checked + .toggle-slider:before { transform: translateX(24px); }

/* ── Submit Button ── */
.pay-submit-row {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.pay-btn-bkash {
    background: #19cac4;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 28px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity .2s;
}
.pay-btn-bkash:hover { opacity: .88; }

.pay-btn-shurjo {
    background: #6c3483;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 28px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: opacity .2s;
}
.pay-btn-shurjo:hover { opacity: .88; }

/* ── Alerts ── */
.pay-alert {
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pay-alert.success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
.pay-alert.error   { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; }

@media (max-width: 768px) {
    .pay-row.cols-3 { grid-template-columns: 1fr; }
    .pay-row.cols-2 { grid-template-columns: 1fr; }
}
</style>

<div class="pay-wrapper">

    <div class="pay-topbar">
        <h2><i class="bi bi-credit-card me-2"></i>Payment Settings</h2>
    </div>

    <div class="pay-content">

        {{-- ════════════════════════════
             BKASH SECTION
        ════════════════════════════ --}}
        <div class="pay-section">
            <div class="pay-section-title">
                <i class="bi bi-phone me-2" style="color:#e2136e;"></i> Bkash
            </div>
            <div class="pay-form-body">

                @if(session('bkash_success'))
                    <div class="pay-alert success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('bkash_success') }}
                    </div>
                @endif

                @if($errors->hasBag('bkash'))
                    <div class="pay-alert error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ $errors->getBag('bkash')->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.payment.bkash.store') }}">
                    @csrf

                    {{-- Row 1: Username | App Key | App Secret --}}
                    <div class="pay-row cols-3">
                        <div class="pay-group">
                            <label class="pay-label">User Name <span>*</span></label>
                            <input type="text" name="username" class="pay-input"
                                   value="{{ old('username', $bkash->username ?? '') }}"
                                   placeholder="01XXXXXXXXX">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">App Key <span>*</span></label>
                            <input type="text" name="app_key" class="pay-input"
                                   value="{{ old('app_key', $bkash->app_key ?? '') }}"
                                   placeholder="App Key">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">App Secret <span>*</span></label>
                            <input type="text" name="app_secret" class="pay-input"
                                   value="{{ old('app_secret', $bkash->app_secret ?? '') }}"
                                   placeholder="App Secret">
                        </div>
                    </div>

                    {{-- Row 2: Base URL | Password | Status --}}
                    <div class="pay-row cols-3">
                        <div class="pay-group">
                            <label class="pay-label">Base Url <span>*</span></label>
                            <input type="text" name="base_url" class="pay-input"
                                   value="{{ old('base_url', $bkash->base_url ?? '') }}"
                                   placeholder="https://tokenized.pay.bka.sh/v1.2.0-beta">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">Password <span>*</span></label>
                            <input type="text" name="password" class="pay-input"
                                   value="{{ old('password', $bkash->password ?? '') }}"
                                   placeholder="Password">
                        </div>
                        <div class="toggle-wrap">
                            <span class="toggle-label-text">Status</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="status" value="1"
                                       {{ (old('status', $bkash->status ?? 1)) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="pay-submit-row">
                        <button type="submit" class="pay-btn-bkash">
                            <i class="bi bi-check2-circle me-1"></i> Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>


        {{-- ════════════════════════════
             SHURJOPAY SECTION
        ════════════════════════════ --}}
        <div class="pay-section">
            <div class="pay-section-title">
                <i class="bi bi-bag-check me-2" style="color:#6c3483;"></i> Shurjopay
            </div>
            <div class="pay-form-body">

                @if(session('shurjopay_success'))
                    <div class="pay-alert success">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('shurjopay_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.payment.shurjopay.store') }}">
                    @csrf

                    {{-- Row 1: Username | Prefix | Success URL --}}
                    <div class="pay-row cols-3">
                        <div class="pay-group">
                            <label class="pay-label">User Name <span>*</span></label>
                            <input type="text" name="username" class="pay-input"
                                   value="{{ old('username', $shurjopay->username ?? '') }}"
                                   placeholder="sp_sandbox">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">Prefix <span>*</span></label>
                            <input type="text" name="prefix" class="pay-input"
                                   value="{{ old('prefix', $shurjopay->prefix ?? '') }}"
                                   placeholder="NOK">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">Success Url <span>*</span></label>
                            <input type="text" name="success_url" class="pay-input"
                                   value="{{ old('success_url', $shurjopay->success_url ?? '') }}"
                                   placeholder="https://yoursite.com/payment-success">
                        </div>
                    </div>

                    {{-- Row 2: Return URL | Base URL | Password --}}
                    <div class="pay-row cols-3">
                        <div class="pay-group">
                            <label class="pay-label">Return Url <span>*</span></label>
                            <input type="text" name="return_url" class="pay-input"
                                   value="{{ old('return_url', $shurjopay->return_url ?? '') }}"
                                   placeholder="https://yoursite.com/payment-cancel">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">Base Url <span>*</span></label>
                            <input type="text" name="base_url" class="pay-input"
                                   value="{{ old('base_url', $shurjopay->base_url ?? '') }}"
                                   placeholder="https://sandbox.shurjopayment.com">
                        </div>
                        <div class="pay-group">
                            <label class="pay-label">Password <span>*</span></label>
                            <input type="text" name="password" class="pay-input"
                                   value="{{ old('password', $shurjopay->password ?? '') }}"
                                   placeholder="Password">
                        </div>
                    </div>

                    {{-- Row 3: Status --}}
                    <div class="pay-row cols-1">
                        <div class="toggle-wrap">
                            <span class="toggle-label-text">Status</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="status" value="1"
                                       {{ (old('status', $shurjopay->status ?? 1)) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="pay-submit-row">
                        <button type="submit" class="pay-btn-shurjo">
                            <i class="bi bi-check2-circle me-1"></i> Submit
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>{{-- end pay-content --}}
</div>{{-- end pay-wrapper --}}

@endsection
