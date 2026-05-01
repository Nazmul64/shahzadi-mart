@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .usr-header-left h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header-left p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    .usr-btn-primary { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); transition: all 0.2s; border: none; }
    .usr-btn-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3); }
    
    .usr-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); overflow: hidden; }
    .usr-table-wrapper { overflow-x: auto; }
    .usr-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .usr-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; border-bottom: 1px solid #e2e8f0; white-space: nowrap; }
    .usr-table td { padding: 16px 20px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .usr-table tr:last-child td { border-bottom: none; }
    .usr-table tr:hover td { background: #f8fafc; }
    
    .usr-profile { display: flex; align-items: center; gap: 12px; }
    .usr-avatar { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; background: #e2e8f0; }
    .usr-info h6 { margin: 0; font-size: 14px; font-weight: 600; color: #1e293b; }
    .usr-info p { margin: 2px 0 0; font-size: 12px; color: #64748b; }
    
    .usr-badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
    .usr-badge-active { background: #dcfce7; color: #166534; }
    .usr-badge-inactive { background: #fee2e2; color: #991b1b; }
    
    .usr-role-tag { display: inline-block; padding: 3px 8px; background: #eff6ff; color: #1d4ed8; border-radius: 5px; font-size: 11px; font-weight: 600; margin: 2px; }
    
    .usr-actions { display: flex; gap: 8px; }
    .usr-btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; transition: all 0.2s; border: none; cursor: pointer; text-decoration: none; }
    .usr-btn-edit { background: #eff6ff; color: #2563eb; }
    .usr-btn-edit:hover { background: #2563eb; color: #fff; }
    .usr-btn-delete { background: #fef2f2; color: #ef4444; }
    .usr-btn-delete:hover { background: #ef4444; color: #fff; }
</style>

<div class="usr-page">
    <div class="usr-header">
        <div class="usr-header-left">
            <h2>User Management</h2>
            <p>সিস্টেমের সকল ইউজার এবং তাদের রোল ম্যানেজ করুন</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="usr-btn-primary">
            <i class="bi bi-person-plus"></i> নতুন ইউজার
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="usr-card">
        <div class="usr-table-wrapper">
            <table class="usr-table">
                <thead>
                    <tr>
                        <th>ইউজার ইনফো</th>
                        <th>রোলস</th>
                        <th>স্ট্যাটাস</th>
                        <th>তৈরি হয়েছে</th>
                        <th style="text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="usr-profile">
                                <img src="{{ $user->photo_url }}" alt="Avatar" class="usr-avatar">
                                <div class="usr-info">
                                    <h6>{{ $user->name }}</h6>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @forelse($user->roles as $role)
                                <span class="usr-role-tag">{{ $role->name }}</span>
                            @empty
                                <span class="usr-role-tag" style="background:#f1f5f9; color:#64748b;">No Role</span>
                            @endforelse
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="usr-badge usr-badge-active">Active</span>
                            @else
                                <span class="usr-badge usr-badge-inactive">{{ ucfirst($user->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 13px; color: #475569;">
                                {{ $user->created_at->format('d M Y') }}
                                <div style="font-size: 11px; color: #94a3b8;">{{ $user->created_at->format('h:i A') }}</div>
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div class="usr-actions" style="justify-content: flex-end;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="usr-btn-icon usr-btn-edit" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if(auth()->id() !== $user->id && !$user->isSuperAdmin())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="usr-btn-icon usr-btn-delete" title="Delete User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="bi bi-people" style="font-size: 32px; opacity: 0.5; display: block; margin-bottom: 10px;"></i>
                            কোনো ইউজার পাওয়া যায়নি
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
