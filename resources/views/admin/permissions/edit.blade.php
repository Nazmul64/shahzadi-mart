@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { margin-bottom: 24px; }
    .usr-back-link { display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 8px; transition: color 0.2s; }
    .usr-back-link:hover { color: #1e293b; }
    .usr-header h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); padding: 30px; }
    .usr-form-group { margin-bottom: 24px; }
    .usr-label { display: block; font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 10px; }
    .usr-select { width: 100%; max-width: 500px; padding: 14px 16px; font-size: 15px; color: #1e293b; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; transition: all 0.2s; outline: none; cursor: pointer; }
    .usr-select:focus { border-color: #8b5cf6; background: #fff; box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); }
    
    .perm-group-title { font-size: 15px; font-weight: 700; color: #475569; margin: 30px 0 15px 0; padding-bottom: 8px; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .perm-group-left { display: flex; align-items: center; gap: 8px; }
    .perm-select-all-btn { font-size: 12px; font-weight: 600; color: #8b5cf6; background: #f5f3ff; border: 1px solid #ddd6fe; padding: 4px 10px; border-radius: 6px; cursor: pointer; transition: all 0.2s; }
    .perm-select-all-btn:hover { background: #8b5cf6; color: #fff; }
    
    .global-select-all { background: #fff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 15px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all 0.2s; width: fit-content; }
    .global-select-all:hover { border-color: #8b5cf6; background: #f5f3ff; }
    .global-select-all input { width: 18px; height: 18px; cursor: pointer; accent-color: #8b5cf6; }
    .global-select-all span { font-size: 14px; font-weight: 700; color: #1e293b; }
    .perm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
    
    .perm-check-card { position: relative; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px 16px; cursor: pointer; transition: all 0.2s; background: #fff; display: flex; align-items: center; gap: 12px; }
    .perm-check-card:hover { border-color: #c4b5fd; background: #f5f3ff; }
    .perm-check-card.selected { border-color: #8b5cf6; background: #f5f3ff; }
    .perm-check-card input[type="checkbox"] { display: none; }
    .perm-check-card::before { content: '\F272'; font-family: 'bootstrap-icons'; font-size: 18px; color: #cbd5e1; transition: color 0.2s; }
    .perm-check-card.selected::before { content: '\F26A'; color: #8b5cf6; }
    
    .perm-info h6 { margin: 0; font-size: 14px; font-weight: 600; color: #1e293b; }
    
    .usr-btn-submit { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; border: none; border-radius: 10px; padding: 14px 30px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2); display: inline-flex; align-items: center; gap: 8px; margin-top: 30px; }
    .usr-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3); }
</style>

<div class="usr-page">
    <div class="usr-header">
        <a href="{{ route('admin.permissions.index') }}" class="usr-back-link"><i class="bi bi-arrow-left"></i> পারমিশন লিস্টে ফিরে যান</a>
        <h2>ডিরেক্ট পারমিশন আপডেট করুন</h2>
        <p>ইউজারের স্পেশাল পারমিশন আপডেট করুন</p>
    </div>

    @include('admin.partials.alerts')

    <div class="usr-card">
        <form action="{{ route('admin.permissions.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="usr-form-group">
                <label class="usr-label">ইউজার সিলেক্ট করুন <span class="text-danger">*</span></label>
                <select name="user_id" class="usr-select" required>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ $user->id == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-danger" style="font-size:12px; margin-top:5px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-top: 30px;">
                <label class="usr-label">পারমিশন সিলেক্ট করুন</label>

                <label class="global-select-all" id="globalSelectAllLabel">
                    <input type="checkbox" id="globalSelectAll">
                    <span>সবগুলো সিলেক্ট করুন (Select All)</span>
                </label>

                @foreach($permissions as $group => $perms)
                    <div class="perm-group-title">
                        <div class="perm-group-left">
                            <i class="bi bi-folder2-open" style="color: #8b5cf6;"></i> {{ $group }}
                        </div>
                        <button type="button" class="perm-select-all-btn" onclick="toggleGroup('{{ Str::slug($group) }}', this)">Select Group</button>
                    </div>
                    <div class="perm-grid" data-group="{{ Str::slug($group) }}">
                        @foreach($perms as $perm)
                        @php
                            $isChecked = in_array($perm->id, old('permissions', $userPermissions));
                        @endphp
                        <label class="perm-check-card {{ $isChecked ? 'selected' : '' }}">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" {{ $isChecked ? 'checked' : '' }}>
                            <div class="perm-info">
                                <h6>{{ $perm->name }}</h6>
                            </div>
                        </label>
                        @endforeach
                    </div>
                @endforeach
                @error('permissions') <span class="text-danger" style="font-size:12px; margin-top:5px; display:block;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="usr-btn-submit">
                <i class="bi bi-check2-all"></i> পারমিশন আপডেট করুন
            </button>
        </form>
    </div>
</div>

<script>
    // Handle individual checkbox clicks
    document.querySelectorAll('.perm-check-card').forEach(card => {
        const checkbox = card.querySelector('input[type="checkbox"]');
        checkbox.addEventListener('change', () => {
            if(checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
            updateGlobalCheckbox();
            updateGroupButtons();
        });
    });

    // Global Select All
    const globalCheckbox = document.getElementById('globalSelectAll');
    globalCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.perm-check-card input[type="checkbox"]').forEach(cb => {
            cb.checked = isChecked;
            const card = cb.closest('.perm-check-card');
            if(isChecked) card.classList.add('selected');
            else card.classList.remove('selected');
        });
        updateGroupButtons();
    });

    // Toggle Group Function
    function toggleGroup(groupSlug, btn) {
        const grid = document.querySelector(`.perm-grid[data-group="${groupSlug}"]`);
        const cbs = grid.querySelectorAll('input[type="checkbox"]');
        const allChecked = Array.from(cbs).every(cb => cb.checked);
        
        cbs.forEach(cb => {
            cb.checked = !allChecked;
            const card = cb.closest('.perm-check-card');
            if(!allChecked) card.classList.add('selected');
            else card.classList.remove('selected');
        });
        
        btn.textContent = !allChecked ? 'Deselect Group' : 'Select Group';
        updateGlobalCheckbox();
    }

    function updateGlobalCheckbox() {
        const allCbs = document.querySelectorAll('.perm-check-card input[type="checkbox"]');
        const checkedCbs = document.querySelectorAll('.perm-check-card input[type="checkbox"]:checked');
        globalCheckbox.checked = allCbs.length > 0 && allCbs.length === checkedCbs.length;
        globalCheckbox.indeterminate = checkedCbs.length > 0 && checkedCbs.length < allCbs.length;
    }

    function updateGroupButtons() {
        document.querySelectorAll('.perm-grid').forEach(grid => {
            const groupSlug = grid.dataset.group;
            const btn = document.querySelector(`button[onclick="toggleGroup('${groupSlug}', this)"]`);
            if (btn) {
                const cbs = grid.querySelectorAll('input[type="checkbox"]');
                const allChecked = Array.from(cbs).every(cb => cb.checked);
                btn.textContent = allChecked ? 'Deselect Group' : 'Select Group';
            }
        });
    }

    // Initial check
    updateGlobalCheckbox();
    updateGroupButtons();
</script>
@endsection
