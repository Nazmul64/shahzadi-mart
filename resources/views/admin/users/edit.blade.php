@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { margin-bottom: 24px; }
    .usr-back-link { display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 8px; transition: color 0.2s; }
    .usr-back-link:hover { color: #1e293b; }
    .usr-header h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    
    .usr-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
    @media(max-width: 992px) { .usr-layout { grid-template-columns: 1fr; } }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); padding: 24px; margin-bottom: 24px; }
    .usr-card-title { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 20px 0; display: flex; align-items: center; gap: 10px; }
    .usr-card-title i { color: #2563eb; background: #eff6ff; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 16px; }
    
    .usr-form-group { margin-bottom: 20px; }
    .usr-label { display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; }
    .usr-input, .usr-select { width: 100%; padding: 12px 16px; font-size: 14px; color: #1e293b; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; transition: all 0.2s; outline: none; }
    .usr-input:focus, .usr-select:focus { border-color: #2563eb; background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
    .usr-input-error { border-color: #ef4444; }
    .usr-error-text { color: #ef4444; font-size: 12px; margin-top: 6px; display: block; }
    
    .role-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
    .role-check-card { position: relative; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px; cursor: pointer; transition: all 0.2s; background: #fff; display: flex; align-items: center; gap: 12px; }
    .role-check-card:hover { border-color: #93c5fd; background: #f0fdf4; }
    .role-check-card.selected { border-color: #2563eb; background: #eff6ff; }
    .role-check-card input[type="checkbox"] { display: none; }
    .role-icon { width: 36px; height: 36px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #64748b; transition: all 0.2s; }
    .role-check-card.selected .role-icon { background: #2563eb; color: #fff; }
    .role-info h6 { margin: 0; font-size: 14px; font-weight: 700; color: #1e293b; }
    .role-info p { margin: 2px 0 0; font-size: 11px; color: #64748b; }
    
    .usr-btn-submit { width: 100%; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border: none; border-radius: 10px; padding: 14px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
    .usr-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }
</style>

<div class="usr-page">
    <div class="usr-header">
        <a href="{{ route('admin.users.index') }}" class="usr-back-link"><i class="bi bi-arrow-left"></i> ইউজার লিস্টে ফিরে যান</a>
        <h2>ইউজার আপডেট করুন</h2>
        <p>ইউজারের তথ্য ও রোল আপডেট করুন</p>
    </div>

    @include('admin.partials.alerts')

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="usr-layout">
            <!-- Left Column -->
            <div>
                <div class="usr-card">
                    <h3 class="usr-card-title"><i class="bi bi-person-badge"></i> প্রাথমিক তথ্য</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="usr-form-group">
                            <label class="usr-label">ইউজারের নাম <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="usr-input {{ $errors->has('name') ? 'usr-input-error' : '' }}" value="{{ old('name', $user->name) }}" required>
                            @error('name') <span class="usr-error-text">{{ $message }}</span> @enderror
                        </div>
                        <div class="usr-form-group">
                            <label class="usr-label">ইমেইল এড্রেস <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="usr-input {{ $errors->has('email') ? 'usr-input-error' : '' }}" value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="usr-error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="usr-form-group">
                            <label class="usr-label">নতুন পাসওয়ার্ড <span style="font-size:11px; color:#94a3b8; font-weight:normal;">(পরিবর্তন না চাইলে ফাঁকা রাখুন)</span></label>
                            <input type="password" name="password" class="usr-input {{ $errors->has('password') ? 'usr-input-error' : '' }}" placeholder="নতুন পাসওয়ার্ড">
                            @error('password') <span class="usr-error-text">{{ $message }}</span> @enderror
                        </div>
                        <div class="usr-form-group">
                            <label class="usr-label">নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" name="password_confirmation" class="usr-input" placeholder="পাসওয়ার্ড পুনরায় টাইপ করুন">
                        </div>
                    </div>
                </div>

                <div class="usr-card">
                    <h3 class="usr-card-title"><i class="bi bi-shield-lock"></i> রোল আপডেট করুন</h3>
                    <p style="font-size: 13px; color: #64748b; margin-top: -10px; margin-bottom: 16px;">এই ইউজারের সিস্টেম রোল পরিবর্তন করুন।</p>
                    
                    <div class="role-grid">
                        @foreach($roles as $role)
                        @php
                            $isChecked = in_array($role->id, old('roles', $userRoles));
                        @endphp
                        <label class="role-check-card {{ $isChecked ? 'selected' : '' }}">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $isChecked ? 'checked' : '' }}>
                            <div class="role-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="role-info">
                                <h6>{{ $role->name }}</h6>
                                <p>{{ $role->permissions_count }} Permissions</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('roles') <span class="usr-error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="usr-card">
                    <h3 class="usr-card-title"><i class="bi bi-gear"></i> সেটিংস</h3>
                    <div class="usr-form-group">
                        <label class="usr-label">অ্যাকাউন্ট স্ট্যাটাস</label>
                        <select name="status" class="usr-select">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>🟢 Active (সক্রিয়)</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>🔴 Inactive (নিষ্ক্রিয়)</option>
                            <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>🟡 Pending (অপেক্ষমান)</option>
                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>⚫ Suspended</option>
                        </select>
                    </div>

                    <button type="submit" class="usr-btn-submit">
                        <i class="bi bi-check2-circle"></i> আপডেট সেভ করুন
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.role-check-card').forEach(card => {
        const checkbox = card.querySelector('input[type="checkbox"]');
        checkbox.addEventListener('change', () => {
            if(checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
    });
</script>
@endsection
