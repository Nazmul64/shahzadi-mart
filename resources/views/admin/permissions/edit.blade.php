@extends('admin.master')

@section('main-content')
<style>
    .pm-page{padding:28px 24px 60px;background:#f0f4f8;min-height:100vh;}
    .pm-page-header{display:flex;align-items:center;gap:14px;margin-bottom:24px;}
    .pm-back-btn{width:36px;height:36px;border:1.5px solid #e2e8f0;border-radius:9px;background:#fff;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none;flex-shrink:0;}
    .pm-back-btn:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .pm-h2{margin:0;font-size:20px;font-weight:700;color:#1e293b;}
    .pm-sub{margin:2px 0 0;font-size:13px;color:#64748b;}
    .pm-layout{display:grid;grid-template-columns:1fr 280px;gap:22px;align-items:flex-start;}
    @media(max-width:991px){.pm-layout{grid-template-columns:1fr;}}
    .pm-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;}
    .pm-card-head{padding:15px 20px 13px;border-bottom:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;}
    .pm-card-head-icon{width:30px;height:30px;background:#eff6ff;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#2d6a9f;}
    .pm-card-head h5{margin:0;font-size:14.5px;font-weight:700;color:#1e293b;}
    .pm-card-body{padding:20px;}
    .pm-field-group{margin-bottom:16px;}
    .pm-field-group:last-child{margin-bottom:0;}
    .pm-label{display:block;font-size:11.5px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.6px;margin-bottom:7px;}
    .pm-input{display:block;width:100%;padding:10px 13px;font-size:13.5px;line-height:1.5;color:#1e293b;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:9px;transition:border-color .18s,box-shadow .18s;appearance:none;-webkit-appearance:none;box-sizing:border-box;}
    .pm-input:focus{outline:none;border-color:#2d6a9f;box-shadow:0 0 0 3px rgba(45,106,159,.12);background:#fff;}
    .pm-input.err{border-color:#ef4444;}
    .pm-err-msg{color:#ef4444;font-size:12px;margin-top:4px;}
    .pm-hint{font-size:12px;color:#94a3b8;margin-top:5px;}
    .pm-side-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;}
    .pm-side-card:last-child{margin-bottom:0;}
    .pm-side-body{padding:15px 16px;}
    .pm-btn-save{width:100%;background:linear-gradient(135deg,#1e3a5f,#2d6a9f);color:#fff;border:none;border-radius:9px;padding:11px 18px;font-size:13.5px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:9px;box-shadow:0 3px 12px rgba(45,106,159,.28);}
    .pm-btn-back{width:100%;background:#f8fafc;color:#475569;border:1.5px solid #e2e8f0;border-radius:9px;padding:10px 18px;font-size:13.5px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;}
    .pm-btn-back:hover{background:#f1f5f9;color:#1e293b;text-decoration:none;}
    .pm-stat-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #f1f5f9;font-size:13px;}
    .pm-stat-row:last-child{border-bottom:none;padding-bottom:0;}
    .pm-stat-row:first-child{padding-top:0;}
</style>

<div class="pm-page">
    <div class="pm-page-header">
        <a href="{{ route('permissions.index') }}" class="pm-back-btn"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h2 class="pm-h2">Edit Permission</h2>
            <p class="pm-sub">{{ $permission->name }} পারমিশন আপডেট করুন</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius:10px;font-size:13px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="pm-layout">
            <div class="pm-card">
                <div class="pm-card-head">
                    <div class="pm-card-head-icon"><i class="bi bi-key"></i></div>
                    <h5>পারমিশনের তথ্য</h5>
                </div>
                <div class="pm-card-body">

                    <div class="pm-field-group">
                        <label class="pm-label">নাম <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="name"
                               class="pm-input {{ $errors->has('name') ? 'err' : '' }}"
                               value="{{ old('name', $permission->name) }}" required>
                        @error('name')<div class="pm-err-msg">{{ $message }}</div>@enderror
                    </div>

                    <div class="pm-field-group">
                        <label class="pm-label">Slug <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="slug"
                               class="pm-input {{ $errors->has('slug') ? 'err' : '' }}"
                               value="{{ old('slug', $permission->slug) }}" required>
                        @error('slug')<div class="pm-err-msg">{{ $message }}</div>@enderror
                        <p class="pm-hint"><i class="bi bi-exclamation-triangle me-1 text-warning"></i>Slug পরিবর্তন করলে code এ যেখানে ব্যবহার হয়েছে সেখানেও আপডেট করতে হবে।</p>
                    </div>

                    <div class="pm-field-group">
                        <label class="pm-label">Group / Module</label>
                        <input type="text" name="group"
                               class="pm-input"
                               value="{{ old('group', $permission->group) }}"
                               placeholder="যেমন: Products, Orders"
                               list="groupList"
                               autocomplete="off">
                        <datalist id="groupList">
                            @foreach($groups as $g)
                                <option value="{{ $g }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="pm-field-group">
                        <label class="pm-label">বিবরণ</label>
                        <input type="text" name="description"
                               class="pm-input"
                               value="{{ old('description', $permission->description) }}"
                               placeholder="এই পারমিশন কিসের জন্য">
                    </div>

                </div>
            </div>

            <div>
                <div class="pm-side-card">
                    <div class="pm-side-body">
                        <button type="submit" class="pm-btn-save">
                            <i class="bi bi-check-lg"></i> আপডেট করুন
                        </button>
                        <a href="{{ route('permissions.index') }}" class="pm-btn-back">
                            <i class="bi bi-arrow-left"></i> ফিরে যান
                        </a>
                    </div>
                </div>
                <div class="pm-side-card">
                    <div class="pm-side-body">
                        <div class="pm-stat-row">
                            <span style="color:#64748b;">ব্যবহৃত রোলে</span>
                            <strong style="color:#2d6a9f;">{{ $permission->roles->count() }}</strong>
                        </div>
                        <div class="pm-stat-row">
                            <span style="color:#64748b;">তৈরির তারিখ</span>
                            <span style="color:#374151;font-size:12px;">{{ $permission->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
