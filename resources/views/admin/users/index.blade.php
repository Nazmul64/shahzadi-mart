@extends('admin.master')

@section('main-content')
<style>
    .usr-page{padding:28px 24px 60px;background:#f0f4f8;min-height:100vh;}
    .usr-page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;}
    .usr-page-title{display:flex;align-items:center;gap:14px;}
    .usr-title-icon{width:46px;height:46px;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;flex-shrink:0;}
    .usr-h2{margin:0;font-size:20px;font-weight:700;color:#1e293b;}
    .usr-sub{margin:2px 0 0;font-size:13px;color:#64748b;}
    .btn-usr-primary{background:linear-gradient(135deg,#1e3a5f,#2d6a9f);color:#fff;border:none;border-radius:9px;padding:9px 18px;font-size:13.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 3px 10px rgba(45,106,159,.28);transition:opacity .18s;}
    .btn-usr-primary:hover{opacity:.88;color:#fff;text-decoration:none;}
    .usr-table-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;}
    .usr-table-card table{margin:0;}
    .usr-table-card thead th{background:#1e3a5f;color:#fff;font-size:12px;font-weight:700;padding:13px 16px;border:none;letter-spacing:.4px;}
    .usr-table-card tbody td{padding:11px 16px;font-size:13.5px;color:#374151;border-color:#f1f5f9;vertical-align:middle;}
    .usr-table-card tbody tr:hover{background:#f8fafc;}

    /* Avatar */
    .usr-avatar{width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid #e2e8f0;}
    .usr-name-cell{display:flex;align-items:center;gap:10px;}
    .usr-name{font-weight:600;color:#1e293b;display:block;}
    .usr-email{font-size:12px;color:#94a3b8;}

    /* Role badges */
    .role-badge{display:inline-block;font-size:10.5px;font-weight:700;padding:2px 9px;border-radius:20px;margin:1px;}
    .role-super-admin{background:#fce7f3;color:#9d174d;}
    .role-admin      {background:#ede9fe;color:#5b21b6;}
    .role-manager    {background:#dbeafe;color:#1d4ed8;}
    .role-seller     {background:#dcfce7;color:#15803d;}
    .role-customer   {background:#fef9c3;color:#92400e;}
    .role-default    {background:#f1f5f9;color:#475569;}

    /* Status badges */
    .status-active   {background:#dcfce7;color:#15803d;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;}
    .status-inactive {background:#fee2e2;color:#dc2626;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;}
    .status-pending  {background:#fef9c3;color:#92400e;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;}
    .status-suspended{background:#f1f5f9;color:#475569;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;}

    /* Action buttons */
    .act-btn{font-size:11.5px;font-weight:600;padding:4px 10px;border-radius:7px;text-decoration:none;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:3px;transition:opacity .15s;white-space:nowrap;}
    .act-btn:hover{opacity:.78;text-decoration:none;}
    .act-edit  {background:#eff6ff;color:#2d6a9f;}
    .act-toggle{background:#fefce8;color:#92400e;}
    .act-del   {background:#fee2e2;color:#dc2626;}

    .empty-state{text-align:center;padding:56px 20px;color:#94a3b8;}
    .empty-state i{font-size:40px;display:block;margin-bottom:12px;opacity:.4;}

    /* Pagination */
    .pagination{justify-content:center;margin-top:20px;}
</style>

<div class="usr-page">

    <div class="usr-page-header">
        <div class="usr-page-title">
            <div class="usr-title-icon"><i class="bi bi-people"></i></div>
            <div>
                <h2 class="usr-h2">Users</h2>
                <p class="usr-sub">সব ইউজার দেখুন ও পরিচালনা করুন</p>
            </div>
        </div>
        <a href="{{ route('users.create') }}" class="btn-usr-primary">
            <i class="bi bi-person-plus"></i> নতুন ইউজার
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;font-size:13.5px;">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" style="border-radius:10px;font-size:13.5px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="usr-table-card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>ইউজার</th>
                    <th>রোল</th>
                    <th>স্ট্যাটাস</th>
                    <th>যোগ দিয়েছে</th>
                    <th style="width:220px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td>
                        <div class="usr-name-cell">
                            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="usr-avatar">
                            <div>
                                <span class="usr-name">{{ $user->name }}</span>
                                <span class="usr-email">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @forelse($user->roles as $role)
                            @php
                                $roleClass = match($role->slug) {
                                    'super-admin' => 'role-super-admin',
                                    'admin'       => 'role-admin',
                                    'manager'     => 'role-manager',
                                    'seller'      => 'role-seller',
                                    'customer'    => 'role-customer',
                                    default       => 'role-default',
                                };
                            @endphp
                            <span class="role-badge {{ $roleClass }}">{{ $role->name }}</span>
                        @empty
                            <span style="color:#94a3b8;font-size:12px;">—</span>
                        @endforelse
                    </td>
                    <td>
                        <span class="status-{{ $user->status ?? 'active' }}">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </td>
                    <td style="font-size:12.5px;color:#64748b;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            {{-- Role Assign --}}
                            <a href="{{ route('users.edit', $user->id) }}" class="act-btn act-edit">
                                <i class="bi bi-shield-lock"></i> Role
                            </a>

                            {{-- Toggle Status (নিজেকে না) --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="act-btn act-toggle" title="Status পরিবর্তন">
                                    <i class="bi bi-toggle-{{ $user->status === 'active' ? 'on' : 'off' }}"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Delete --}}
                            @if($user->id !== auth()->id() && !$user->isSuperAdmin())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('\'{{ addslashes($user->name) }}\' ডিলিট করবেন?')">
                                @csrf @method('DELETE')
                                <button class="act-btn act-del">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p class="mb-0">কোনো ইউজার নেই।</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif

</div>
@endsection
