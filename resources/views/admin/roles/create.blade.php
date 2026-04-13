@extends('admin.master')

@section('main-content')

<style>
    .r-page        { padding: 28px 24px 60px; background: #f0f4f8; min-height: 100vh; }
    .r-page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; }
    .r-back-btn    { width: 36px; height: 36px; border: 1.5px solid #e2e8f0; border-radius: 9px; background: #fff; display: inline-flex; align-items: center; justify-content: center; color: #475569; text-decoration: none; transition: all .15s; flex-shrink: 0; }
    .r-back-btn:hover { background: #f1f5f9; color: #1e293b; text-decoration: none; }
    .r-h2  { margin: 0; font-size: 20px; font-weight: 700; color: #1e293b; }
    .r-sub { margin: 2px 0 0; font-size: 13px; color: #64748b; }

    .r-layout { display: grid; grid-template-columns: 1fr 300px; gap: 22px; align-items: flex-start; }
    @media (max-width: 991px) { .r-layout { grid-template-columns: 1fr; } }

    .r-card        { background: #fff; border-radius: 14px; box-shadow: 0 2px 14px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 20px; }
    .r-card:last-child { margin-bottom: 0; }
    .r-card-head   { padding: 15px 20px 13px; border-bottom: 1.5px solid #f1f5f9; display: flex; align-items: center; gap: 10px; }
    .r-card-head-icon { width: 30px; height: 30px; background: #eff6ff; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #2d6a9f; flex-shrink: 0; }
    .r-card-head h5 { margin: 0; font-size: 14.5px; font-weight: 700; color: #1e293b; }
    .r-card-body   { padding: 20px; }

    .r-field-group { margin-bottom: 16px; }
    .r-field-group:last-child { margin-bottom: 0; }
    .r-label { display: block; font-size: 11.5px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 7px; }
    .r-input, .r-textarea { display: block; width: 100%; padding: 10px 13px; font-size: 13.5px; line-height: 1.5; color: #1e293b; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 9px; transition: border-color .18s, box-shadow .18s; appearance: none; -webkit-appearance: none; box-sizing: border-box; }
    .r-input:focus, .r-textarea:focus { outline: none; border-color: #2d6a9f; box-shadow: 0 0 0 3px rgba(45,106,159,.12); background: #fff; }
    .r-input.err, .r-textarea.err { border-color: #ef4444; }
    .r-err-msg { color: #ef4444; font-size: 12px; margin-top: 4px; }
    .r-textarea { resize: vertical; min-height: 70px; }

    .r-perm-count  { background: #eff6ff; color: #2d6a9f; font-size: 12px; font-weight: 700; padding: 4px 13px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px; }
    .r-global-btn  { font-size: 12px; font-weight: 600; padding: 5px 13px; border-radius: 7px; border: 1.5px solid #e2e8f0; background: #fff; color: #475569; cursor: pointer; transition: all .15s; }
    .r-global-btn:hover { background: #eff6ff; border-color: #93c5fd; color: #2d6a9f; }
    .r-perm-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 8px; }

    .r-perm-grid { display: grid; grid-template-columns: repeat(auto-fill,minmax(185px,1fr)); gap: 12px; }
    .r-perm-group-card { background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 11px; overflow: hidden; }
    .r-perm-group-head { background: linear-gradient(90deg,#1e3a5f,#2d6a9f); padding: 7px 12px; display: flex; align-items: center; justify-content: space-between; }
    .r-perm-group-name { font-size: 10px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #fff; }
    .r-perm-all-btn    { font-size: 10px; font-weight: 600; color: rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.3); border-radius: 4px; padding: 1px 7px; cursor: pointer; background: transparent; transition: all .15s; }
    .r-perm-all-btn:hover { background: rgba(255,255,255,.2); color: #fff; }
    .r-perm-items  { padding: 9px 11px 11px; display: flex; flex-direction: column; gap: 4px; }

    .r-check-label { display: flex; align-items: center; gap: 9px; font-size: 12.5px; color: #374151; cursor: pointer; padding: 3px 5px; border-radius: 6px; transition: background .12s; }
    .r-check-label:hover { background: #eff6ff; color: #1e3a5f; }
    .r-check-label input[type="checkbox"] { appearance: none; -webkit-appearance: none; width: 15px; height: 15px; flex-shrink: 0; border: 2px solid #cbd5e1; border-radius: 4px; background: #fff; cursor: pointer; position: relative; transition: all .15s; }
    .r-check-label input[type="checkbox"]:checked { background: #2d6a9f; border-color: #2d6a9f; }
    .r-check-label input[type="checkbox"]:checked::after { content: ''; position: absolute; top: 1px; left: 4px; width: 4px; height: 7px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg); }

    .r-side-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 14px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 16px; }
    .r-side-card:last-child { margin-bottom: 0; }
    .r-side-head { padding: 13px 16px 11px; border-bottom: 1.5px solid #f1f5f9; display: flex; align-items: center; gap: 8px; }
    .r-side-head i { font-size: 14px; color: #2d6a9f; }
    .r-side-head h6 { margin: 0; font-size: 13.5px; font-weight: 700; color: #1e293b; }
    .r-side-body { padding: 15px 16px; }

    .r-toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
    .r-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .r-toggle-row:first-child { padding-top: 0; }
    .r-toggle-label { font-size: 13px; font-weight: 500; color: #374151; }
    .r-toggle-sub   { font-size: 11px; color: #94a3b8; display: block; margin-top: 2px; }
    .r-switch       { position: relative; width: 36px; height: 20px; flex-shrink: 0; }
    .r-switch input { opacity: 0; width: 0; height: 0; }
    .r-slider       { position: absolute; inset: 0; background: #e2e8f0; border-radius: 20px; cursor: pointer; transition: background .2s; }
    .r-slider::before { content: ''; position: absolute; width: 14px; height: 14px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.18); }
    .r-switch input:checked + .r-slider { background: #2d6a9f; }
    .r-switch input:checked + .r-slider::before { transform: translateX(16px); }

    .r-btn-save { width: 100%; background: linear-gradient(135deg,#1e3a5f,#2d6a9f); color: #fff; border: none; border-radius: 9px; padding: 11px 18px; font-size: 13.5px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 9px; box-shadow: 0 3px 12px rgba(45,106,159,.28); transition: opacity .18s; }
    .r-btn-save:hover { opacity: .9; }
    .r-btn-back { width: 100%; background: #f8fafc; color: #475569; border: 1.5px solid #e2e8f0; border-radius: 9px; padding: 10px 18px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
    .r-btn-back:hover { background: #f1f5f9; color: #1e293b; text-decoration: none; }
</style>

<div class="r-page">

    <div class="r-page-header">
        <a href="{{ route('admin.roles.index') }}" class="r-back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="r-h2">নতুন রোল তৈরি করুন</h2>
            <p class="r-sub">রোলের নাম, পারমিশন ও অপশন সেট করুন</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius:10px;font-size:13px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="r-layout">

            <div>

                {{-- Basic Info --}}
                <div class="r-card">
                    <div class="r-card-head">
                        <div class="r-card-head-icon"><i class="bi bi-info-circle"></i></div>
                        <h5>মূল তথ্য</h5>
                    </div>
                    <div class="r-card-body">
                        <div class="r-field-group">
                            <label class="r-label">রোলের নাম <span style="color:#ef4444;">*</span></label>
                            <input type="text" name="name" id="roleName"
                                   class="r-input {{ $errors->has('name') ? 'err' : '' }}"
                                   value="{{ old('name') }}"
                                   placeholder="যেমন: Manager, Editor, Seller"
                                   autocomplete="off" required>
                            @error('name')
                                <div class="r-err-msg">{{ $message }}</div>
                            @enderror
                            <div style="font-size:12px;color:#64748b;margin-top:5px;">
                                Slug: <code id="slugPreview" style="background:#f1f5f9;padding:1px 6px;border-radius:4px;color:#2d6a9f;">—</code>
                            </div>
                        </div>
                        <div class="r-field-group">
                            <label class="r-label">বিবরণ <span style="color:#94a3b8;font-weight:400;">(ঐচ্ছিক)</span></label>
                            <textarea name="description" class="r-textarea"
                                      placeholder="এই রোল কী করতে পারবে সংক্ষেপে লিখুন">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="r-err-msg">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Permissions --}}
                <div class="r-card">
                    <div class="r-card-head">
                        <div class="r-card-head-icon"><i class="bi bi-key"></i></div>
                        <h5>পারমিশন</h5>
                        <span class="r-perm-count ms-auto">
                            <i class="bi bi-check-circle"></i>
                            <span id="permCount">0</span> selected
                        </span>
                    </div>
                    <div class="r-card-body">
                        @if($permissions->isEmpty())
                            <div style="text-align:center;padding:30px 0;color:#94a3b8;">
                                <i class="bi bi-key fs-3 d-block mb-2" style="opacity:.4;"></i>
                                <p class="mb-0">কোনো পারমিশন নেই। <a href="{{ route('admin.permissions.create') }}" style="color:#2d6a9f;">তৈরি করুন</a></p>
                            </div>
                        @else
                            <div class="r-perm-topbar">
                                <div class="d-flex gap-2">
                                    <button type="button" class="r-global-btn" onclick="selectAllPerms(true)">
                                        <i class="bi bi-check-all me-1"></i>সব নির্বাচন
                                    </button>
                                    <button type="button" class="r-global-btn" onclick="selectAllPerms(false)">
                                        <i class="bi bi-x-lg me-1"></i>সব বাতিল
                                    </button>
                                </div>
                            </div>
                            <div class="r-perm-grid">
                                @foreach($permissions as $group => $groupPerms)
                                    <div class="r-perm-group-card">
                                        <div class="r-perm-group-head">
                                            <span class="r-perm-group-name">{{ $group }}</span>
                                            <button type="button" class="r-perm-all-btn"
                                                    onclick="toggleGroup(this)" data-state="0">All</button>
                                        </div>
                                        <div class="r-perm-items">
                                            @foreach($groupPerms as $perm)
                                                <label class="r-check-label">
                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $perm->id }}"
                                                           class="r-perm-cb"
                                                           {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    {{ $perm->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div>

                <div class="r-side-card">
                    <div class="r-side-body">
                        <button type="submit" class="r-btn-save">
                            <i class="bi bi-check-lg"></i> রোল সেভ করুন
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="r-btn-back">
                            <i class="bi bi-arrow-left"></i> ফিরে যান
                        </a>
                    </div>
                </div>

                <div class="r-side-card">
                    <div class="r-side-head">
                        <i class="bi bi-toggles"></i>
                        <h6>অপশন</h6>
                    </div>
                    <div class="r-side-body">
                        <div class="r-toggle-row">
                            <div>
                                <span class="r-toggle-label">Active Status</span>
                                <span class="r-toggle-sub">এই রোল সক্রিয় থাকবে</span>
                            </div>
                            <label class="r-switch">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="r-slider"></span>
                            </label>
                        </div>
                        <div class="r-toggle-row">
                            <div>
                                <span class="r-toggle-label">Default Role</span>
                                <span class="r-toggle-sub">নতুন user এ auto-assign</span>
                            </div>
                            <label class="r-switch">
                                <input type="checkbox" name="is_default" value="1"
                                       {{ old('is_default') ? 'checked' : '' }}>
                                <span class="r-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="r-side-card">
                    <div class="r-side-head">
                        <i class="bi bi-lightbulb"></i>
                        <h6>টিপস</h6>
                    </div>
                    <div class="r-side-body" style="font-size:12.5px;color:#64748b;line-height:1.8;">
                        <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> রোলের নাম অবশ্যই unique হতে হবে।</p>
                        <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Slug নাম থেকে স্বয়ংক্রিয় তৈরি হবে।</p>
                        <p class="mb-1"><i class="bi bi-check2 text-success me-1"></i> Default রোল নতুন user এ auto-assign হয়।</p>
                        <p class="mb-0"><i class="bi bi-check2 text-success me-1"></i> পারমিশন পরে assign করা যাবে।</p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('roleName').addEventListener('input', function () {
    const slug = this.value.toLowerCase().trim()
        .replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/-+/g, '-');
    document.getElementById('slugPreview').textContent = slug || '—';
});
function toggleGroup(btn) {
    const card  = btn.closest('.r-perm-group-card');
    const cbs   = card.querySelectorAll('.r-perm-cb');
    const check = btn.dataset.state === '0';
    cbs.forEach(c => c.checked = check);
    btn.dataset.state = check ? '1' : '0';
    btn.textContent   = check ? 'None' : 'All';
    updateCount();
}
function selectAllPerms(checked) {
    document.querySelectorAll('.r-perm-cb').forEach(c => c.checked = checked);
    document.querySelectorAll('.r-perm-all-btn').forEach(b => {
        b.dataset.state = checked ? '1' : '0';
        b.textContent   = checked ? 'None' : 'All';
    });
    updateCount();
}
function updateCount() {
    document.getElementById('permCount').textContent =
        document.querySelectorAll('.r-perm-cb:checked').length;
}
document.querySelectorAll('.r-perm-cb').forEach(c => c.addEventListener('change', updateCount));
updateCount();
</script>

@endsection
