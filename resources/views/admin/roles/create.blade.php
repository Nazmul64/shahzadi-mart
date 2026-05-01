@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { margin-bottom: 24px; }
    .usr-back-link { display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 8px; transition: color 0.2s; }
    .usr-back-link:hover { color: #1e293b; }
    .usr-header h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); padding: 30px; max-width: 800px; }
    .usr-form-group { margin-bottom: 24px; }
    .usr-label { display: block; font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .usr-select { width: 100%; padding: 14px 16px; font-size: 15px; color: #1e293b; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; transition: all 0.2s; outline: none; cursor: pointer; }
    .usr-select:focus { border-color: #10b981; background: #fff; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
    
    .role-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .role-check-card { position: relative; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.2s; background: #fff; display: flex; align-items: center; gap: 14px; }
    .role-check-card:hover { border-color: #34d399; background: #ecfdf5; }
    .role-check-card.selected { border-color: #10b981; background: #ecfdf5; }
    .role-check-card input[type="checkbox"] { display: none; }
    .role-icon { width: 40px; height: 40px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #64748b; transition: all 0.2s; }
    .role-check-card.selected .role-icon { background: #10b981; color: #fff; }
    .role-info h6 { margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; }
    
    .usr-btn-submit { background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; border-radius: 10px; padding: 14px 30px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); display: inline-flex; align-items: center; gap: 8px; }
    .usr-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3); }
</style>

<div class="usr-page">
    <div class="usr-header">
        <a href="{{ route('admin.roles.index') }}" class="usr-back-link"><i class="bi bi-arrow-left"></i> রোল লিস্টে ফিরে যান</a>
        <h2>রোল অ্যাসাইন করুন</h2>
        <p>ড্রপডাউন থেকে ইউজার সিলেক্ট করে তাকে রোল প্রদান করুন</p>
    </div>

    @include('admin.partials.alerts')

    <div class="usr-card">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            
            <div class="usr-form-group">
                <label class="usr-label">ইউজার সিলেক্ট করুন <span class="text-danger">*</span></label>
                <select name="user_id" class="usr-select" required>
                    <option value="" disabled selected>-- ইউজার নির্বাচন করুন --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-danger" style="font-size:12px; margin-top:5px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div class="usr-form-group">
                <label class="usr-label">রোল সিলেক্ট করুন</label>
                <div class="role-grid">
                    @foreach($roles as $role)
                    <label class="role-check-card {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                        <div class="role-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="role-info">
                            <h6>{{ $role->name }}</h6>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('roles') <span class="text-danger" style="font-size:12px; margin-top:5px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="usr-btn-submit">
                    <i class="bi bi-check2-all"></i> সেভ করুন
                </button>
            </div>
        </form>
    </div>
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
