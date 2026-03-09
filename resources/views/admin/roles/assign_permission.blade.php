@extends('admin.master')

@section('main-content')

<style>
    .ap-page{padding:28px 24px 60px;background:#f0f4f8;min-height:100vh;}
    .ap-page-header{display:flex;align-items:center;gap:14px;margin-bottom:24px;}
    .ap-back-btn{width:36px;height:36px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none;flex-shrink:0;}
    .ap-back-btn:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .ap-h2{margin:0;font-size:20px;font-weight:700;color:#1e293b;}
    .ap-sub{margin:2px 0 0;font-size:13px;color:#64748b;}
    .ap-layout{display:grid;grid-template-columns:1fr 280px;gap:22px;align-items:flex-start;}
    @media(max-width:991px){.ap-layout{grid-template-columns:1fr;}}
    .ap-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;}
    .ap-card-head{padding:15px 20px 13px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
    .ap-card-head h5{margin:0;font-size:14.5px;font-weight:700;color:#1e293b;}
    .ap-card-body{padding:20px;}
    .role-info-bar{background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:11px;padding:13px 16px;margin-bottom:20px;display:flex;align-items:center;gap:13px;flex-wrap:wrap;}
    .role-info-icon{width:42px;height:42px;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;flex-shrink:0;}
    .role-info-name{font-size:14.5px;font-weight:700;color:#1e293b;}
    .role-info-meta{font-size:12px;color:#64748b;margin-top:3px;}
    .ap-perm-count{background:#eff6ff;color:#2d6a9f;font-size:12px;font-weight:700;padding:4px 13px;border-radius:20px;display:inline-flex;align-items:center;gap:5px;margin-left:auto;}
    .ap-global-btn{font-size:12px;font-weight:600;padding:5px 13px;border-radius:7px;border:1.5px solid #e2e8f0;background:#fff;color:#475569;cursor:pointer;transition:all .15s;}
    .ap-global-btn:hover{background:#eff6ff;border-color:#93c5fd;color:#2d6a9f;}
    .ap-perm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(185px,1fr));gap:12px;}
    .ap-perm-group-card{background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:11px;overflow:hidden;}
    .ap-perm-group-head{background:linear-gradient(90deg,#1e3a5f,#2d6a9f);padding:7px 12px;display:flex;align-items:center;justify-content:space-between;}
    .ap-perm-group-name{font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#fff;}
    .ap-perm-all-btn{font-size:10px;font-weight:600;color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.3);border-radius:4px;padding:1px 7px;cursor:pointer;background:transparent;}
    .ap-perm-items{padding:9px 11px 11px;display:flex;flex-direction:column;gap:4px;}
    .ap-check-label{display:flex;align-items:center;gap:9px;font-size:12.5px;color:#374151;cursor:pointer;padding:3px 5px;border-radius:6px;transition:background .12s;}
    .ap-check-label:hover{background:#eff6ff;color:#1e3a5f;}
    .ap-check-label input[type="checkbox"]{appearance:none;-webkit-appearance:none;width:15px;height:15px;flex-shrink:0;border:2px solid #cbd5e1;border-radius:4px;background:#fff;cursor:pointer;position:relative;transition:all .15s;}
    .ap-check-label input[type="checkbox"]:checked{background:#2d6a9f;border-color:#2d6a9f;}
    .ap-check-label input[type="checkbox"]:checked::after{content:'';position:absolute;top:1px;left:4px;width:4px;height:7px;border:2px solid #fff;border-top:none;border-left:none;transform:rotate(45deg);}
    .ap-side-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;}
    .ap-side-card:last-child{margin-bottom:0;}
    .ap-side-body{padding:15px 16px;}
    .ap-btn-save{width:100%;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);color:#fff;border:none;border-radius:9px;padding:11px 18px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:9px;box-shadow:0 3px 12px rgba(45,106,159,.28);transition:opacity .18s;}
    .ap-btn-save:hover{opacity:.9;}
    .ap-btn-back{width:100%;background:#f8fafc;color:#475569;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 18px;font-size:13.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;}
    .ap-btn-back:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
</style>

<div class="ap-page">

    <div class="ap-page-header">
        <a href="{{ route('roles.index') }}" class="ap-back-btn"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h2 class="ap-h2">Permissions Assign</h2>
            <p class="ap-sub">{{ $role->name }} রোলের পারমিশন নির্ধারণ করুন</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;font-size:13.5px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('roles.saveAssignedPermission', $role->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="ap-layout">

            <div class="ap-card">
                <div class="ap-card-head">
                    <i class="bi bi-shield" style="color:#2d6a9f;font-size:18px;"></i>
                    <h5>{{ $role->name }}</h5>
                    <span class="ap-perm-count">
                        <i class="bi bi-check-circle"></i>
                        <span id="permCount">0</span> selected
                    </span>
                </div>
                <div class="ap-card-body">

                    {{-- Role Info --}}
                    <div class="role-info-bar">
                        <div class="role-info-icon"><i class="bi bi-shield"></i></div>
                        <div>
                            <div class="role-info-name">{{ $role->name }}</div>
                            <div class="role-info-meta">
                                Slug: <code>{{ $role->slug }}</code>
                                &nbsp;·&nbsp; {{ $role->users()->count() }} জন ইউজার
                                &nbsp;·&nbsp; {{ $role->is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;gap:8px;margin-bottom:18px;">
                        <button type="button" class="ap-global-btn" onclick="selectAllPerms(true)">
                            <i class="bi bi-check-all me-1"></i>সব নির্বাচন
                        </button>
                        <button type="button" class="ap-global-btn" onclick="selectAllPerms(false)">
                            <i class="bi bi-x-lg me-1"></i>সব বাতিল
                        </button>
                    </div>

                    @if($permissions->isEmpty())
                        <div style="text-align:center;padding:30px 0;color:#94a3b8;">
                            <i class="bi bi-key fs-3 d-block mb-2" style="opacity:.4;"></i>
                            <p class="mb-0">কোনো পারমিশন নেই। <a href="{{ route('permissions.create') }}" style="color:#2d6a9f;">তৈরি করুন</a></p>
                        </div>
                    @else
                        <div class="ap-perm-grid">
                            @foreach($permissions as $group => $groupPerms)
                                <div class="ap-perm-group-card">
                                    <div class="ap-perm-group-head">
                                        <span class="ap-perm-group-name">{{ $group }}</span>
                                        <button type="button" class="ap-perm-all-btn"
                                                onclick="toggleGroup(this)" data-state="0">All</button>
                                    </div>
                                    <div class="ap-perm-items">
                                        @foreach($groupPerms as $perm)
                                            <label class="ap-check-label">
                                                <input type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $perm->id }}"
                                                       class="ap-perm-cb"
                                                       {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
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

            <div>
                <div class="ap-side-card">
                    <div class="ap-side-body">
                        <button type="submit" class="ap-btn-save">
                            <i class="bi bi-check-lg"></i> পারমিশন সেভ করুন
                        </button>
                        <a href="{{ route('roles.index') }}" class="ap-btn-back">
                            <i class="bi bi-arrow-left"></i> ফিরে যান
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function toggleGroup(btn) {
    const card  = btn.closest('.ap-perm-group-card');
    const cbs   = card.querySelectorAll('.ap-perm-cb');
    const check = btn.dataset.state === '0';
    cbs.forEach(c => c.checked = check);
    btn.dataset.state = check ? '1' : '0';
    btn.textContent   = check ? 'None' : 'All';
    updateCount();
}
function selectAllPerms(checked) {
    document.querySelectorAll('.ap-perm-cb').forEach(c => c.checked = checked);
    document.querySelectorAll('.ap-perm-all-btn').forEach(b => {
        b.dataset.state = checked ? '1' : '0';
        b.textContent   = checked ? 'None' : 'All';
    });
    updateCount();
}
function updateCount() {
    document.getElementById('permCount').textContent =
        document.querySelectorAll('.ap-perm-cb:checked').length;
}
document.querySelectorAll('.ap-perm-cb').forEach(c => c.addEventListener('change', updateCount));
updateCount();
</script>

@endsection
