{{-- resources/views/admin/contactinfomationadmins/index.blade.php --}}
@extends('admin.master')

@section('main-content')

<style>
* { box-sizing: border-box; }
.ci-wrapper { background: #f4f6fb; min-height: 100vh; font-family: 'Segoe UI', sans-serif; }

.ci-topbar {
    background: #fff; border-bottom: 1px solid #e8eaf0;
    padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
}
.ci-topbar h2 { font-size: 20px; font-weight: 700; color: #2d3748; margin: 0; }

.btn-add {
    background: linear-gradient(135deg, #f7617a, #e84b65);
    color: #fff; border: none; border-radius: 22px;
    padding: 9px 20px; font-size: 13px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none; transition: opacity .2s;
}
.btn-add:hover { opacity: .88; color: #fff; text-decoration: none; }

.ci-content { padding: 24px; }

.ci-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden;
}

.ci-table { width: 100%; border-collapse: collapse; }
.ci-table thead tr { background: #f8f9fc; border-bottom: 2px solid #e8eaf0; }
.ci-table th {
    padding: 12px 16px; font-size: 12px; font-weight: 700; color: #7a849e;
    text-transform: uppercase; letter-spacing: .4px; white-space: nowrap; text-align: left;
}
.ci-table tbody tr { border-bottom: 1px solid #f0f2f8; transition: background .15s; }
.ci-table tbody tr:hover { background: #fafbff; }
.ci-table tbody tr:last-child { border-bottom: none; }
.ci-table td { padding: 13px 16px; font-size: 13px; color: #3a4259; vertical-align: middle; }

.ci-link {
    color: #3498db; text-decoration: none; font-size: 13px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px; display: block;
}
.ci-link:hover { text-decoration: underline; }

.ci-actions { display: flex; gap: 6px; align-items: center; }
.ci-icon-btn {
    width: 30px; height: 30px; border-radius: 6px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; border: 1px solid #e8eaf0;
    background: #fff; color: #555; text-decoration: none; transition: all .2s;
}
.ci-icon-btn:hover { background: #f0f2f8; color: #333; }
.ci-icon-btn.edit { color: #8e44ad; border-color: #e9d8fd; }
.ci-icon-btn.del  { color: #e74c3c; border-color: #fecaca; }

.ci-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.ci-empty i { font-size: 48px; display: block; margin-bottom: 12px; }

.ci-phone {
    display: inline-flex; align-items: center; gap: 5px;
    color: #38a169; font-weight: 600; text-decoration: none; font-size: 13px;
}
.ci-phone:hover { text-decoration: underline; }
</style>

<div class="ci-wrapper">

    <div class="ci-topbar">
        <h2><i class="bi bi-person-lines-fill me-2" style="color:#e53e3e;"></i>Contact Info</h2>
        <a href="{{ route('admin.contactinfomationadmins.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Add New
        </a>
    </div>

    <div class="ci-content">

        @if(session('success'))
            <div style="background:#f0fff4;border-left:4px solid #38a169;padding:12px 18px;
                        font-size:13px;color:#276749;margin-bottom:16px;border-radius:6px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="ci-card">
            @if($contacts->isEmpty())
                <div class="ci-empty">
                    <i class="bi bi-person-x"></i>
                    <p>কোনো contact info পাওয়া যায়নি।</p>
                    <a href="{{ route('admin.contactinfomationadmins.create') }}" class="btn-add" style="display:inline-flex;">
                        <i class="bi bi-plus-lg"></i> প্রথমটি যোগ করুন
                    </a>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="ci-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">SL</th>
                                <th>WhatsApp URL</th>
                                <th>Messenger URL</th>
                                <th>Phone</th>
                                <th style="width:100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $i => $contact)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <a href="{{ $contact->watsapp_url }}" target="_blank" class="ci-link">
                                        <i class="bi bi-whatsapp me-1" style="color:#25D366;"></i>
                                        {{ $contact->watsapp_url }}
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ $contact->messanger_url }}" target="_blank" class="ci-link">
                                        <i class="bi bi-messenger me-1" style="color:#0084ff;"></i>
                                        {{ $contact->messanger_url }}
                                    </a>
                                </td>

                                <td>
                                    @if($contact->phone)
                                        <a href="tel:{{ $contact->phone }}" class="ci-phone">
                                            <i class="bi bi-telephone-fill"></i>
                                            {{ $contact->phone }}
                                        </a>
                                    @else
                                        <span style="color:#ccc;">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="ci-actions">
                                        <a href="{{ route('admin.contactinfomationadmins.edit', $contact->id) }}"
                                           class="ci-icon-btn edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.contactinfomationadmins.destroy', $contact->id) }}"
                                              onsubmit="return confirm('মুছে ফেলতে চান?')"
                                              style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ci-icon-btn del" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
