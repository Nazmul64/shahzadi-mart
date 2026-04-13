@extends('admin.master')

@section('main-content')
<style>
    .ar-page{padding:28px 24px 60px;background:#f0f4f8;min-height:100vh;}
    .ar-page-header{display:flex;align-items:center;gap:14px;margin-bottom:24px;}
    .ar-back-btn{width:36px;height:36px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none;flex-shrink:0;}
    .ar-back-btn:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .ar-h2{margin:0;font-size:20px;font-weight:700;color:#1e293b;}
    .ar-sub{margin:2px 0 0;font-size:13px;color:#64748b;}
    .ar-layout{display:grid;grid-template-columns:1fr 280px;gap:22px;align-items:flex-start;}
    @media(max-width:991px){.ar-layout{grid-template-columns:1fr;}}
    .ar-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;}
    .ar-card-head{padding:15px 20px 13px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
    .ar-card-head-icon{width:30px;height:30px;background:#eff6ff;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#2d6a9f;}
    .ar-card-head h5{margin:0;font-size:14.5px;font-weight:700;color:#1e293b;}
    .ar-card-body{padding:20px;}

    /* User info bar */
    .ar-user-bar{display:flex;align-items:center;gap:14px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:11px;padding:14px 16px;margin-bottom:22px;}
    .ar-user-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #e2e8f0;}
    .ar-user-name{font-size:15px;font-weight:700;color:#1e293b;}
    .ar-user-email{font-size:12.5px;color:#64748b;margin-top:2px;}
    .ar-user-status{font-size:11px;font-weight:700;padding:2px 9px;border-radius:20px;display:inline-block;margin-top:4px;}
    .s-active  {background:#dcfce7;color:#15803d;}
    .s-inactive{background:#fee2e2;color:#dc2626;}
    .s-pending {background:#fef9c3;color:#92400e;}
    .s-suspended{background:#f1f5f9;color:#475569;}

    /* Role cards */
    .ar-role-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:11px;}
    .ar-role-card{border:1.5px solid #e2e8f0;border-radius:11px;padding:13px 14px;cursor:pointer;transition:all .15s;background:#fff;position:relative;}
    .ar-role-card:hover{border-color:#93c5fd;background:#f8fbff;}
    .ar-role-card.assigned{border-color:#2d6a9f;background:#eff6ff;}
    .ar-role-card input[type="checkbox"]{display:none;}
    .ar-role-icon{width:32px;height:32px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#475569;margin-bottom:8px;transition:all .15s;}
    .ar-role-card.assigned .ar-role-icon{background:#dbeafe;color:#2d6a9f;}
    .ar-role-name{font-size:13px;font-weight:700;color:#1e293b;display:block;}
    .ar-role-perms{font-size:11px;color:#94a3b8;margin-top:3px;display:block;}
    .ar-assigned-check{position:absolute;top:10px;right:10px;width:18px;height:18px;border-radius:50%;background:#2d6a9f;display:none;align-items:center;justify-content:center;}
    .ar-role-card.assigned .ar-assigned-check{display:flex;}
    .ar-assigned-check i{font-size:9px;color:#fff;}

    /* Side */
    .ar-side-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;}
    .ar-side-card:last-child{margin-bottom:0;}
    .ar-side-head{padding:13px 16px 11px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:8px;}
    .ar-side-head i{font-size:14px;color:#2d6a9f;}
    .ar-side-head h6{margin:0;font-size:13.5px;font-weight:700;color:#1e293b;}
    .ar-side-body{padding:15px 16px;}
    .ar-btn-save{width:100%;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);color:#fff;border:none;border-radius:9px;padding:11px 18px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:9px;box-shadow:0 3px 12px rgba(45,106,159,.28);}
    .ar-btn-back{width:100%;background:#f8fafc;color:#475569;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 18px;font-size:13.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;}
    .ar-btn-back:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .ar-stat-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:13px;}
    .ar-stat-row:last-child{border-bottom:none;padding-bottom:0;}
    .ar-stat-row:first-child{padding-top:0;}

    /* Current role badges */
    .cr-badge{display:inline-block;font-size:10.5px;font-weight:700;padding:2px 9px;border-radius:20px;margin:1px;background:#eff6ff;color:#2d6a9f;}
</style>

<div class="ar-page">
    <div class="ar-page-header">
        <a href="{{ route('admin.users.index') }}" class="ar-back-btn"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h2 class="ar-h2">Role Assign</h2>
            <p class="ar-sub">{{ $user->name }} এর রোল পরিবর্তন করুন</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;font-size:13.5px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="ar-layout">

            <div class="ar-card">
                <div class="ar-card-head">
                    <div class="ar-card-head-icon"><i class="bi bi-person-badge"></i></div>
                    <h5>রোল নির্ধারণ</h5>
                </div>
                <div class="ar-card-body">

                    {{-- User Info --}}
                    <div class="ar-user-bar">
                        <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="ar-user-avatar">
                        <div>
                            <div class="ar-user-name">{{ $user->name }}</div>
                            <div class="ar-user-email">{{ $user->email }}</div>
                            <span class="ar-user-status s-{{ $user->status ?? 'active' }}">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </div>
                    </div>

                    {{-- Role Cards --}}
                    @if($roles->isEmpty())
                        <div style="text-align:center;padding:20px 0;color:#94a3b8;">
                            <i class="bi bi-shield-x d-block mb-2 fs-4" style="opacity:.4;"></i>
                            কোনো active রোল নেই। <a href="{{ route('admin.roles.create') }}" style="color:#2d6a9f;">তৈরি করুন</a>
                        </div>
                    @else
                        <div class="ar-role-grid">
                            @foreach($roles as $role)
                            @php $isAssigned = in_array($role->id, $userRoles); @endphp
                            <label class="ar-role-card {{ $isAssigned ? 'assigned' : '' }}"
                                   id="arc-{{ $role->id }}">
                                <input type="checkbox"
                                       name="roles[]"
                                       value="{{ $role->id }}"
                                       class="ar-role-cb"
                                       {{ $isAssigned ? 'checked' : '' }}>
                                <div class="ar-assigned-check"><i class="bi bi-check-lg"></i></div>
                                <div class="ar-role-icon">
                                    <i class="bi bi-shield{{ $role->slug === 'super-admin' ? '-fill' : '' }}"></i>
                                </div>
                                <span class="ar-role-name">{{ $role->name }}</span>
                                <span class="ar-role-perms">{{ $role->permissions_count }} পারমিশন</span>
                            </label>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            <div>
                <div class="ar-side-card">
                    <div class="ar-side-body">
                        <button type="submit" class="ar-btn-save">
                            <i class="bi bi-check-lg"></i> রোল সেভ করুন
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="ar-btn-back">
                            <i class="bi bi-arrow-left"></i> ফিরে যান
                        </a>
                    </div>
                </div>

                <div class="ar-side-card">
                    <div class="ar-side-head"><i class="bi bi-person-circle"></i><h6>বর্তমান তথ্য</h6></div>
                    <div class="ar-side-body">
                        <div class="ar-stat-row">
                            <span style="color:#64748b;">যোগ দিয়েছে</span>
                            <span style="font-size:12px;">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="ar-stat-row">
                            <span style="color:#64748b;">বর্তমান রোল</span>
                            <span>
                                @forelse($user->roles as $r)
                                    <span class="cr-badge">{{ $r->name }}</span>
                                @empty
                                    <span style="color:#94a3b8;font-size:12px;">None</span>
                                @endforelse
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
document.querySelectorAll('.ar-role-cb').forEach(function (cb) {
    cb.addEventListener('change', function () {
        var card = cb.closest('.ar-role-card');
        card.classList.toggle('assigned', cb.checked);
    });
});
</script>
@endsection
