@extends('admin.master')

@section('main-content')
<style>
    .usr-page{padding:28px 24px 60px;background:#f0f4f8;min-height:100vh;}
    .usr-page-header{display:flex;align-items:center;gap:14px;margin-bottom:24px;}
    .usr-back-btn{width:36px;height:36px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none;flex-shrink:0;}
    .usr-back-btn:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .usr-h2{margin:0;font-size:20px;font-weight:700;color:#1e293b;}
    .usr-sub{margin:2px 0 0;font-size:13px;color:#64748b;}
    .usr-layout{display:grid;grid-template-columns:1fr 280px;gap:22px;align-items:flex-start;}
    @media(max-width:991px){.usr-layout{grid-template-columns:1fr;}}
    .usr-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;}
    .usr-card:last-child{margin-bottom:0;}
    .usr-card-head{padding:15px 20px 13px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
    .usr-card-head-icon{width:30px;height:30px;background:#eff6ff;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#2d6a9f;}
    .usr-card-head h5{margin:0;font-size:14.5px;font-weight:700;color:#1e293b;}
    .usr-card-body{padding:20px;}
    .usr-field-group{margin-bottom:16px;}
    .usr-field-group:last-child{margin-bottom:0;}
    .usr-label{display:block;font-size:11.5px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.6px;margin-bottom:7px;}
    .usr-input,.usr-select{display:block;width:100%;padding:10px 13px;font-size:13.5px;line-height:1.5;color:#1e293b;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;transition:border-color .18s,box-shadow .18s;appearance:none;-webkit-appearance:none;box-sizing:border-box;}
    .usr-input:focus,.usr-select:focus{outline:none;border-color:#2d6a9f;box-shadow:0 0 0 3px rgba(45,106,159,.12);background:#fff;}
    .usr-input.err{border-color:#ef4444;}
    .usr-err-msg{color:#ef4444;font-size:12px;margin-top:4px;}
    .usr-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    @media(max-width:640px){.usr-row{grid-template-columns:1fr;}}

    /* Role checkboxes */
    .role-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:9px;}
    .role-check-card{border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 13px;cursor:pointer;transition:all .15s;background:#fff;}
    .role-check-card:hover{border-color:#93c5fd;background:#eff6ff;}
    .role-check-card.selected{border-color:#2d6a9f;background:#eff6ff;}
    .role-check-card input[type="checkbox"]{display:none;}
    .role-check-name{font-size:13px;font-weight:700;color:#1e293b;display:block;margin-top:5px;}
    .role-check-perms{font-size:11px;color:#94a3b8;margin-top:2px;}
    .role-check-icon{width:28px;height:28px;background:#f1f5f9;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;}
    .role-check-card.selected .role-check-icon{background:#dbeafe;color:#2d6a9f;}

    /* Side */
    .usr-side-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;}
    .usr-side-card:last-child{margin-bottom:0;}
    .usr-side-body{padding:15px 16px;}
    .usr-btn-save{width:100%;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);color:#fff;border:none;border-radius:9px;padding:11px 18px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:9px;box-shadow:0 3px 12px rgba(45,106,159,.28);}
    .usr-btn-back{width:100%;background:#f8fafc;color:#475569;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 18px;font-size:13.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;}
    .usr-btn-back:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
</style>

<div class="usr-page">
    <div class="usr-page-header">
        <a href="{{ route('admin.users.index') }}" class="usr-back-btn"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h2 class="usr-h2">নতুন ইউজার তৈরি</h2>
            <p class="usr-sub">তথ্য পূরণ করুন ও রোল নির্ধারণ করুন</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius:10px;font-size:13px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="usr-layout">
            <div>

                {{-- Personal Info --}}
                <div class="usr-card">
                    <div class="usr-card-head">
                        <div class="usr-card-head-icon"><i class="bi bi-person"></i></div>
                        <h5>ব্যক্তিগত তথ্য</h5>
                    </div>
                    <div class="usr-card-body">
                        <div class="usr-row">
                            <div class="usr-field-group">
                                <label class="usr-label">পূর্ণ নাম <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="name"
                                       class="usr-input {{ $errors->has('name') ? 'err' : '' }}"
                                       value="{{ old('name') }}"
                                       placeholder="ইউজারের নাম" required>
                                @error('name')<div class="usr-err-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="usr-field-group">
                                <label class="usr-label">Email <span style="color:#ef4444;">*</span></label>
                                <input type="email" name="email"
                                       class="usr-input {{ $errors->has('email') ? 'err' : '' }}"
                                       value="{{ old('email') }}"
                                       placeholder="user@example.com" required>
                                @error('email')<div class="usr-err-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="usr-row">
                            <div class="usr-field-group">
                                <label class="usr-label">পাসওয়ার্ড <span style="color:#ef4444;">*</span></label>
                                <input type="password" name="password"
                                       class="usr-input {{ $errors->has('password') ? 'err' : '' }}"
                                       placeholder="কমপক্ষে ৮ অক্ষর" required>
                                @error('password')<div class="usr-err-msg">{{ $message }}</div>@enderror
                            </div>
                            <div class="usr-field-group">
                                <label class="usr-label">পাসওয়ার্ড নিশ্চিত করুন <span style="color:#ef4444;">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="usr-input"
                                       placeholder="আবার টাইপ করুন" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Roles --}}
                <div class="usr-card">
                    <div class="usr-card-head">
                        <div class="usr-card-head-icon"><i class="bi bi-shield-lock"></i></div>
                        <h5>রোল নির্বাচন করুন</h5>
                    </div>
                    <div class="usr-card-body">
                        @if($roles->isEmpty())
                            <div style="text-align:center;padding:20px 0;color:#94a3b8;">
                                <i class="bi bi-shield-x d-block mb-2 fs-4" style="opacity:.4;"></i>
                                কোনো active রোল নেই। <a href="{{ route('admin.roles.create') }}" style="color:#2d6a9f;">তৈরি করুন</a>
                            </div>
                        @else
                            <div class="role-grid">
                                @foreach($roles as $role)
                                <label class="role-check-card {{ (in_array($role->id, old('roles', [])) || $role->is_default) ? 'selected' : '' }}"
                                       id="rc-{{ $role->id }}">
                                    <input type="checkbox"
                                           name="roles[]"
                                           value="{{ $role->id }}"
                                           {{ (in_array($role->id, old('roles', [])) || $role->is_default) ? 'checked' : '' }}>
                                    <div class="role-check-icon">
                                        <i class="bi bi-shield{{ $role->slug === 'super-admin' ? '-fill' : '' }}"></i>
                                    </div>
                                    <span class="role-check-name">{{ $role->name }}</span>
                                    @if($role->is_default)
                                        <span class="role-check-perms" style="color:#15803d;">Default</span>
                                    @endif
                                </label>
                                @endforeach
                            </div>
                            @error('roles')<div class="usr-err-msg mt-2">{{ $message }}</div>@enderror
                        @endif
                    </div>
                </div>

            </div>

            <div>
                <div class="usr-side-card">
                    <div class="usr-side-body">
                        <button type="submit" class="usr-btn-save">
                            <i class="bi bi-check-lg"></i> ইউজার তৈরি করুন
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="usr-btn-back">
                            <i class="bi bi-arrow-left"></i> ফিরে যান
                        </a>
                    </div>
                </div>

                <div class="usr-side-card">
                    <div class="usr-side-body">
                        <div class="usr-field-group" style="margin-bottom:0;">
                            <label class="usr-label">Status</label>
                            <select name="status" class="usr-select">
                                <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Active</option>
                                <option value="inactive"  {{ old('status') === 'inactive'  ? 'selected' : '' }}>Inactive</option>
                                <option value="pending"   {{ old('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Role card toggle visual
document.querySelectorAll('.role-check-card').forEach(function (card) {
    var cb = card.querySelector('input[type="checkbox"]');
    if (cb) {
        cb.addEventListener('change', function () {
            card.classList.toggle('selected', cb.checked);
        });
    }
});
</script>
@endsection
