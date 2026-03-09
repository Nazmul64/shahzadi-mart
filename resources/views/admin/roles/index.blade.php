@extends('admin.master')

@section('main-content')

<style>
    .rbac-page        { padding: 28px 24px 60px; background: #f0f4f8; min-height: 100vh; }
    .rbac-page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .rbac-page-title  { display: flex; align-items: center; gap: 14px; }
    .rbac-title-icon  { width: 46px; height: 46px; background: linear-gradient(135deg,#1e3a5f,#2d6a9f); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff; flex-shrink: 0; }
    .rbac-title-icon  i { line-height: 1; }
    .rbac-h2          { margin: 0; font-size: 20px; font-weight: 700; color: #1e293b; }
    .rbac-sub         { margin: 2px 0 0; font-size: 13px; color: #64748b; }

    .btn-rbac-primary { background: linear-gradient(135deg,#1e3a5f,#2d6a9f); color: #fff; border: none; border-radius: 9px; padding: 9px 20px; font-size: 13.5px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; box-shadow: 0 3px 10px rgba(45,106,159,.28); transition: opacity .18s; }
    .btn-rbac-primary:hover { opacity: .88; color: #fff; text-decoration: none; }

    .rbac-table-card  { background: #fff; border-radius: 14px; box-shadow: 0 2px 14px rgba(0,0,0,.07); overflow: hidden; }
    .rbac-table-card table { margin: 0; }
    .rbac-table-card thead th { background: #1e3a5f; color: #fff; font-size: 12px; font-weight: 700; letter-spacing: .4px; text-transform: uppercase; padding: 13px 16px; border: none; }
    .rbac-table-card tbody td { padding: 12px 16px; font-size: 13.5px; color: #374151; border-color: #f1f5f9; vertical-align: middle; }
    .rbac-table-card tbody tr:hover { background: #f8fafc; }

    .badge-perm    { background: #eff6ff; color: #2d6a9f; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    .badge-users   { background: #f0fdf4; color: #15803d; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    .badge-on      { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px; }
    .badge-off     { background: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px; }
    .badge-default { background: #fef9c3; color: #92400e; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; margin-left: 5px; }

    .act-btn { font-size: 12px; font-weight: 600; padding: 4px 11px; border-radius: 7px; text-decoration: none; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: opacity .15s; white-space: nowrap; }
    .act-btn:hover { opacity: .78; text-decoration: none; }
    .act-edit   { background: #eff6ff; color: #2d6a9f; }
    .act-key    { background: #fefce8; color: #92400e; }
    .act-del    { background: #fee2e2; color: #dc2626; }

    .empty-state { text-align: center; padding: 56px 20px; color: #94a3b8; }
    .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: .4; }
</style>

<div class="rbac-page">

    {{-- Header --}}
    <div class="rbac-page-header">
        <div class="rbac-page-title">
            <div class="rbac-title-icon"><i class="bi bi-shield-lock"></i></div>
            <div>
                <h2 class="rbac-h2">Roles</h2>
                <p class="rbac-sub">সব রোল দেখুন ও পরিচালনা করুন</p>
            </div>
        </div>
        <a href="{{ route('roles.create') }}" class="btn-rbac-primary">
            <i class="bi bi-plus-lg"></i> নতুন রোল তৈরি
        </a>
    </div>

    {{-- Alerts --}}
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

    {{-- Table --}}
    <div class="rbac-table-card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>রোলের নাম</th>
                    <th>Slug</th>
                    <th>বিবরণ</th>
                    <th>পারমিশন</th>
                    <th>ইউজার</th>
                    <th>স্ট্যাটাস</th>
                    <th style="width:200px;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-semibold">{{ $role->name }}</span>
                        @if($role->is_default)
                            <span class="badge-default">Default</span>
                        @endif
                    </td>
                    <td><code style="font-size:12px;color:#2d6a9f;">{{ $role->slug }}</code></td>
                    <td style="color:#64748b;font-size:13px;">{{ $role->description ?? '—' }}</td>
                    <td>
                        <span class="badge-perm">
                            <i class="bi bi-key"></i>{{ $role->permissions_count }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-users">
                            <i class="bi bi-people"></i>{{ $role->users_count }}
                        </span>
                    </td>
                    <td>
                        @if($role->is_active)
                            <span class="badge-on">সক্রিয়</span>
                        @else
                            <span class="badge-off">নিষ্ক্রিয়</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('roles.edit', $role->id) }}" class="act-btn act-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="{{ route('roles.assignPermission', $role->id) }}" class="act-btn act-key">
                                <i class="bi bi-key"></i> Perms
                            </a>
                            @if(!in_array($role->slug, ['super-admin','admin']))
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('\'{{ addslashes($role->name) }}\' ডিলিট করবেন?')">
                                @csrf @method('DELETE')
                                <button class="act-btn act-del">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-shield-x"></i>
                            <p class="mb-0">কোনো রোল নেই। <a href="{{ route('roles.create') }}" style="color:#2d6a9f;">প্রথম রোল তৈরি করুন</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
