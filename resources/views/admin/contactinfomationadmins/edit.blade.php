{{-- resources/views/admin/contactinfomationadmins/edit.blade.php --}}
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
.ci-input:focus { border-color: #8e44ad; box-shadow: 0 0 0 3px rgba(142,68,173,.08); }

.ci-input-icon-wrap { position: relative; }
.ci-input-icon-wrap .ci-input { padding-left: 40px; }
.ci-input-icon {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    font-size: 15px; color: #aaa; pointer-events: none;
}

.ci-error { font-size: 12px; color: #e53e3e; margin-top: 5px; }

.btn-update {
    background: linear-gradient(135deg, #8e44ad, #6c3483);
    color: #fff; border: none; border-radius: 8px;
    padding: 12px 32px; font-size: 14px; font-weight: 700;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    transition: opacity .2s; margin-top: 6px;
}
.btn-update:hover { opacity: .88; }
</style>

<div class="ci-wrapper">

    <div class="ci-topbar">
        <h2><i class="bi bi-pencil-square me-2" style="color:#8e44ad;"></i>Edit Contact Info</h2>
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
            <form method="POST"
                  action="{{ route('admin.contactinfomationadmins.update', $contactinfomationadmin->id) }}"
                  id="ci-edit-form">
                @csrf
                @method('PUT')

                {{-- WhatsApp URL --}}
                <div class="ci-field">
                    <label class="ci-label">WhatsApp URL <span>*</span></label>
                    <div class="ci-input-icon-wrap">
                        <i class="bi bi-whatsapp ci-input-icon" style="color:#25D366;"></i>
                        <input type="text" name="watsapp_url" id="prev_whatsapp" class="ci-input"
                               placeholder="https://wa.me/8801XXXXXXXXX"
                               value="{{ old('watsapp_url', $contactinfomationadmin->watsapp_url) }}"
                               oninput="updatePreview()">
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
                        <input type="text" name="messanger_url" id="prev_messenger" class="ci-input"
                               placeholder="https://m.me/yourpage"
                               value="{{ old('messanger_url', $contactinfomationadmin->messanger_url) }}"
                               oninput="updatePreview()">
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
                        <input type="text" name="phone" id="prev_phone" class="ci-input"
                               placeholder="01XXXXXXXXX"
                               value="{{ old('phone', $contactinfomationadmin->phone) }}"
                               oninput="updatePreview()">
                    </div>
                    @error('phone')
                        <div class="ci-error"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-update">
                    <i class="bi bi-arrow-repeat"></i> Update করুন
                </button>

            </form>
        </div>

        {{-- Live Preview --}}
        <div class="ci-card" style="max-width:280px;margin-top:0;">
            <div style="font-size:13px;font-weight:700;color:#2d3748;margin-bottom:14px;">
                <i class="bi bi-eye me-2" style="color:#8e44ad;"></i>লাইভ প্রিভিউ
            </div>
            <p style="font-size:11px;color:#aaa;margin-bottom:14px;">ওয়েবসাইটে এভাবে দেখাবে:</p>

            <div id="preview-widgets" style="display:flex;flex-direction:column;gap:10px;">
                <div id="prev-messenger-btn" style="display:none;align-items:center;gap:10px;background:#fff;border:1px solid #e8eaf0;border-radius:30px;padding:8px 14px;box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <span style="width:34px;height:34px;background:linear-gradient(135deg,#0078ff,#a855f7);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;flex-shrink:0;"><i class="bi bi-messenger"></i></span>
                    <span style="font-size:13px;font-weight:600;color:#2d3748;">Messenger</span>
                </div>
                <div id="prev-whatsapp-btn" style="display:none;align-items:center;gap:10px;background:#fff;border:1px solid #e8eaf0;border-radius:30px;padding:8px 14px;box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <span style="width:34px;height:34px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;flex-shrink:0;"><i class="bi bi-whatsapp"></i></span>
                    <span style="font-size:13px;font-weight:600;color:#2d3748;">WhatsApp</span>
                </div>
                <div id="prev-phone-btn" style="display:none;align-items:center;gap:10px;background:#fff;border:1px solid #e8eaf0;border-radius:30px;padding:8px 14px;box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <span style="width:34px;height:34px;background:#374151;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;flex-shrink:0;"><i class="bi bi-telephone-fill"></i></span>
                    <span id="prev-phone-text" style="font-size:13px;font-weight:600;color:#2d3748;">Call Us</span>
                </div>
                <p id="prev-empty" style="font-size:12px;color:#bbb;text-align:center;padding:16px 0;display:none;">তথ্য দিন, প্রিভিউ দেখুন</p>
            </div>

            <div style="margin-top:18px;padding-top:14px;border-top:1px solid #f0f2f8;">
                <div style="font-size:11px;font-weight:600;color:#7a849e;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">বর্তমান লিংক</div>
                <div style="font-size:11px;color:#3a4259;word-break:break-all;display:flex;flex-direction:column;gap:6px;">
                    @if($contactinfomationadmin->watsapp_url)
                    <span><i class="bi bi-whatsapp" style="color:#25d366;"></i> {{ Str::limit($contactinfomationadmin->watsapp_url, 35) }}</span>
                    @endif
                    @if($contactinfomationadmin->messanger_url)
                    <span><i class="bi bi-messenger" style="color:#0084ff;"></i> {{ Str::limit($contactinfomationadmin->messanger_url, 35) }}</span>
                    @endif
                    @if($contactinfomationadmin->phone)
                    <span><i class="bi bi-telephone-fill" style="color:#38a169;"></i> {{ $contactinfomationadmin->phone }}</span>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- end flex row --}}
</div>

<style>
.ci-content { display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap; }
</style>

<script>
function updatePreview() {
    const wa  = document.getElementById('prev_whatsapp').value.trim();
    const ms  = document.getElementById('prev_messenger').value.trim();
    const ph  = document.getElementById('prev_phone').value.trim();

    const waBtn = document.getElementById('prev-whatsapp-btn');
    const msBtn = document.getElementById('prev-messenger-btn');
    const phBtn = document.getElementById('prev-phone-btn');
    const empty = document.getElementById('prev-empty');

    waBtn.style.display = wa ? 'flex' : 'none';
    msBtn.style.display = ms ? 'flex' : 'none';
    phBtn.style.display = ph ? 'flex' : 'none';

    if (ph) document.getElementById('prev-phone-text').textContent = ph;

    const anyFilled = wa || ms || ph;
    empty.style.display = anyFilled ? 'none' : 'block';
}
// Run on page load to show existing values
updatePreview();
</script>

@endsection
