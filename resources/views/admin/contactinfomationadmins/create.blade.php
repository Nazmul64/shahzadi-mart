{{-- resources/views/admin/contactinfomationadmins/create.blade.php --}}
@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }
.ci-wrapper { background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }

.ci-topbar {
    background: #fff; border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
}
.ci-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }

.btn-back {
    background: #6c757d; color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: opacity .2s;
}
.btn-back:hover { opacity: .88; color: #fff; text-decoration: none; }

.ci-content { padding: 24px; }

.ci-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    padding: 28px; max-width: 600px;
}

.ci-field { margin-bottom: 18px; }
.ci-label {
    font-size: 13px; font-weight: 600; color: #3a4259;
    display: block; margin-bottom: 7px;
}
.ci-label span { color: #e74c3c; }
.ci-input {
    width: 100%; border: 1px solid #dde2ec; border-radius: 8px;
    padding: 10px 14px; font-size: 13px; color: #3a4259;
    outline: none; transition: border-color .2s;
}
.ci-input:focus { border-color: #e53e3e; box-shadow: 0 0 0 3px rgba(229,62,62,.08); }

.ci-input-icon-wrap { position: relative; }
.ci-input-icon-wrap .ci-input { padding-left: 40px; }
.ci-input-icon {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    font-size: 15px; color: #aaa; pointer-events: none;
}

.ci-error { font-size: 12px; color: #e53e3e; margin-top: 5px; }

.btn-submit {
    background: linear-gradient(135deg, #f7617a, #e84b65);
    color: #fff; border: none; border-radius: 8px;
    padding: 12px 32px; font-size: 14px; font-weight: 700;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    transition: opacity .2s; margin-top: 6px;
}
.btn-submit:hover { opacity: .88; }
</style>

<div class="ci-wrapper">

    <div class="ci-topbar">
        <h2><i class="bi bi-person-plus-fill me-2" style="color:#e53e3e;"></i>Add Contact Info</h2>
        <a href="{{ route('admin.contactinfomationadmins.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="ci-content">

        @if($errors->any())
            <div style="background:#fff5f5;border-left:4px solid #e53e3e;padding:12px 18px;
                        font-size:13px;color:#c53030;margin-bottom:16px;border-radius:6px;max-width:600px;">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>ত্রুটি পাওয়া গেছে:</strong>
                <ul style="margin:8px 0 0 20px;padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="ci-card">
            <form method="POST" action="{{ route('admin.contactinfomationadmins.store') }}">
                @csrf

                {{-- WhatsApp URL --}}
                <div class="ci-field">
                    <label class="ci-label">WhatsApp URL <span>*</span></label>
                    <div class="ci-input-icon-wrap">
                        <i class="bi bi-whatsapp ci-input-icon" style="color:#25D366;"></i>
                        <input type="text" name="watsapp_url" class="ci-input"
                               placeholder="https://wa.me/8801XXXXXXXXX"
                               value="{{ old('watsapp_url') }}">
                    </div>
                    @error('watsapp_url')
                        <div class="ci-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Messenger URL --}}
                <div class="ci-field">
                    <label class="ci-label">Messenger URL <span>*</span></label>
                    <div class="ci-input-icon-wrap">
                        <i class="bi bi-messenger ci-input-icon" style="color:#0084ff;"></i>
                        <input type="text" name="messanger_url" class="ci-input"
                               placeholder="https://m.me/yourpage"
                               value="{{ old('messanger_url') }}">
                    </div>
                    @error('messanger_url')
                        <div class="ci-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="ci-field">
                    <label class="ci-label">Phone <span style="color:#aaa;font-weight:400;">(Optional)</span></label>
                    <div class="ci-input-icon-wrap">
                        <i class="bi bi-telephone-fill ci-input-icon" style="color:#38a169;"></i>
                        <input type="text" name="phone" class="ci-input"
                               placeholder="01XXXXXXXXX"
                               value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <div class="ci-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg"></i> Save করুন
                </button>

            </form>
        </div>

    </div>
</div>

@endsection
