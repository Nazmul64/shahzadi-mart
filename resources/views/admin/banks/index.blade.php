@extends('admin.master')

@section('main-content')
<style>
    .bank-page { padding: 30px 24px; background: #f4f7fb; min-height: 100vh; }
    .bank-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .bank-header-left h2 { margin: 0; font-size: 24px; font-weight: 700; color: #1e293b; }
    .bank-header-left p { margin: 4px 0 0; font-size: 14px; color: #64748b; }
    
    .bank-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 24px; }
    .bank-table { width: 100%; border-collapse: separate; border-spacing: 0; }
    .bank-table th { background: #f8fafc; padding: 16px 20px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; text-align: left; }
    .bank-table td { padding: 16px 20px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    
    .usr-badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; }
    .usr-badge-active { background: #dcfce7; color: #166534; }
    .usr-badge-inactive { background: #fee2e2; color: #991b1b; }
    
    .bank-btn-primary { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; transition: all 0.2s; }
    .bank-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); color: #fff; }

    .usr-actions { display: flex; gap: 8px; }
    .usr-btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; transition: all 0.2s; border: none; cursor: pointer; text-decoration: none; }
    .usr-btn-edit { background: #eff6ff; color: #2563eb; }
    .usr-btn-edit:hover { background: #2563eb; color: #fff; }
    .usr-btn-delete { background: #fef2f2; color: #ef4444; }
    .usr-btn-delete:hover { background: #ef4444; color: #fff; }
</style>

<div class="bank-page">
    <div class="bank-header">
        <div class="bank-header-left">
            <h2>Bank Management</h2>
            <p>সেলার রেজিস্ট্রেশনের জন্য ব্যাংকের তালিকা ম্যানেজ করুন</p>
        </div>
        <button class="bank-btn-primary" data-bs-toggle="modal" data-bs-target="#addBankModal">
            <i class="bi bi-plus-lg"></i> নতুন ব্যাংক যোগ করুন
        </button>
    </div>

    @include('admin.partials.alerts')

    <div class="bank-card">
        <table class="bank-table">
            <thead>
                <tr>
                    <th>ব্যাংকের নাম</th>
                    <th>স্ট্যাটাস</th>
                    <th>তৈরি হয়েছে</th>
                    <th style="text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                <tr>
                    <td><strong>{{ $bank->name }}</strong></td>
                    <td>
                        <form action="{{ route('admin.banks.toggle-status', $bank) }}" method="POST">
                            @csrf
                            <button type="submit" class="usr-badge {{ $bank->is_active ? 'usr-badge-active' : 'usr-badge-inactive' }}">
                                {{ $bank->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>{{ $bank->created_at->format('d M Y') }}</td>
                    <td style="text-align: right;">
                        <div class="usr-actions" style="justify-content: flex-end;">
                            <button class="usr-btn-icon usr-btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editBankModal{{ $bank->id }}" 
                                    title="Edit Bank">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('admin.banks.destroy', $bank) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="usr-btn-icon usr-btn-delete" title="Delete Bank">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Bank Modal -->
                <div class="modal fade" id="editBankModal{{ $bank->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.banks.update', $bank) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">ব্যাংক এডিট করুন</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">ব্যাংকের নাম</label>
                                        <input type="text" name="name" class="form-control" value="{{ $bank->name }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                                    <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #64748b;">কোনো ব্যাংক পাওয়া যায়নি</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($banks->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9;">
            {{ $banks->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add Bank Modal -->
<div class="modal fade" id="addBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.banks.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">নতুন ব্যাংক যোগ করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ব্যাংকের নাম</label>
                        <input type="text" name="name" class="form-control" placeholder="যেমন: Dutch-Bangla Bank" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
