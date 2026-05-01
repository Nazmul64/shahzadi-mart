@extends('admin.master')

@section('main-content')
<style>
    .usr-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .usr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .usr-header-left h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }
    .usr-header-left p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    .usr-btn-primary { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2); transition: all 0.2s; border: none; }
    .usr-btn-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3); }
    
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
    
    .usr-perm-tag { display: inline-block; padding: 4px 10px; background: #f5f3ff; color: #7c3aed; border-radius: 6px; font-size: 12px; font-weight: 600; margin: 2px; }
    
    .usr-actions { display: flex; gap: 8px; }
    .usr-btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; transition: all 0.2s; border: none; cursor: pointer; text-decoration: none; }
    .usr-btn-edit { background: #f5f3ff; color: #7c3aed; }
    .usr-btn-edit:hover { background: #7c3aed; color: #fff; }
    .usr-btn-delete { background: #fef2f2; color: #ef4444; }
    .usr-btn-delete:hover { background: #ef4444; color: #fff; }
</style>

<div class="usr-page">
    <div class="usr-header">
        <div class="usr-header-left">
            <h2>User Direct Permissions</h2>
            <p>ইউজারদের সরাসরি দেওয়া স্পেশাল পারমিশন ম্যানেজ করুন</p>
        </div>
        <a href="{{ route('admin.permissions.create') }}" class="usr-btn-primary">
            <i class="bi bi-key"></i> পারমিশন অ্যাসাইন করুন
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="usr-card">
        <div class="usr-table-wrapper">
            <table class="usr-table">
                <thead>
                    <tr>
                        <th>ইউজার</th>
                        <th>সরাসরি দেওয়া পারমিশনস</th>
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
                            @forelse($user->directPermissions as $perm)
                                <span class="usr-perm-tag">
                                    <i class="bi bi-check-circle"></i> {{ $perm->name }}
                                </span>
                            @empty
                                <span class="usr-perm-tag" style="background:#f1f5f9; color:#64748b;">
                                    <i class="bi bi-x-circle"></i> কোনো ডিরেক্ট পারমিশন নেই
                                </span>
                            @endforelse
                        </td>
                        <td style="text-align: right;">
                            <div class="usr-actions" style="justify-content: flex-end;">
                                <a href="{{ route('admin.permissions.edit', $user->id) }}" class="usr-btn-icon usr-btn-edit" title="Edit Permissions">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.permissions.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('এই ইউজারের সব ডিরেক্ট পারমিশন রিমুভ করবেন?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="usr-btn-icon usr-btn-delete" title="Remove All Direct Permissions">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 40px; color: #64748b;">
                            কোনো ইউজারের ডিরেক্ট পারমিশন নেই
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
