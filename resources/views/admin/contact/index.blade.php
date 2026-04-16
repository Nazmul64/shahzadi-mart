@extends('admin.master')

@section('main-content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --bg-base:    #09090b;
        --bg-surface: #111114;
        --bg-card:    #18181b;
        --bg-hover:   #1f1f23;
        --border:     #27272a;
        --border-light: #3f3f46;
        --text-1:     #fafafa;
        --text-2:     #a1a1aa;
        --text-3:     #52525b;
        --accent:     #7c3aed;
        --accent-2:   #a78bfa;
        --accent-bg:  rgba(124,58,237,0.12);
        --green:      #22c55e;
        --green-bg:   rgba(34,197,94,0.1);
        --red:        #ef4444;
        --red-bg:     rgba(239,68,68,0.1);
        --amber:      #f59e0b;
        --amber-bg:   rgba(245,158,11,0.1);
        --sky:        #38bdf8;
        --sky-bg:     rgba(56,189,248,0.1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .cw {
        font-family: 'Inter', sans-serif;
        background: var(--bg-base);
        min-height: 100vh;
        padding: 32px 36px;
    }

    /* ── Topbar ── */
    .topbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 32px;
    }
    .topbar-left h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-1);
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    .topbar-left p {
        font-size: 13px;
        color: var(--text-3);
        margin-top: 4px;
    }

    .btn-new {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--accent);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 0 0 1px rgba(124,58,237,0.4), 0 4px 16px rgba(124,58,237,0.25);
    }
    .btn-new:hover { background: #6d28d9; color: #fff; text-decoration: none; transform: translateY(-1px); }
    .btn-new i { font-size: 11px; }

    /* ── Toast ── */
    .toast {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--bg-card);
        border: 1px solid rgba(34,197,94,0.3);
        border-left: 3px solid var(--green);
        border-radius: 10px;
        padding: 13px 18px;
        color: var(--green);
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 24px;
        animation: toastIn 0.35s ease;
    }
    @keyframes toastIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .stat-icon.purple { background: var(--accent-bg); color: var(--accent-2); }
    .stat-icon.green  { background: var(--green-bg);  color: var(--green);    }
    .stat-icon.sky    { background: var(--sky-bg);    color: var(--sky);      }
    .stat-info p { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-3); }
    .stat-info h3 { font-size: 22px; font-weight: 700; color: var(--text-1); margin-top: 2px; }

    /* ── Table Card ── */
    .tcard {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .tcard-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-surface);
    }
    .tcard-head h2 {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-1);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tcard-head h2 i { color: var(--text-3); font-size: 13px; }
    .count-chip {
        background: var(--accent-bg);
        color: var(--accent-2);
        font-size: 11px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
        border: 1px solid rgba(167,139,250,0.2);
    }

    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--bg-surface); border-bottom: 1px solid var(--border); }
    thead th {
        padding: 11px 20px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-3);
        text-align: left;
    }
    tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--bg-hover); }
    tbody td { padding: 14px 20px; font-size: 13.5px; color: var(--text-2); vertical-align: middle; }

    .cell-serial {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11.5px;
        color: var(--text-3);
        font-weight: 500;
    }
    .cell-phone {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12.5px;
        color: var(--accent-2);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .cell-phone i { font-size: 10px; color: var(--text-3); }
    .cell-email {
        color: var(--sky);
        font-size: 13px;
    }
    .cell-addr {
        color: var(--text-2);
        font-size: 13px;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .badge-yes { background: var(--green-bg); color: var(--green); border: 1px solid rgba(34,197,94,0.2); }
    .badge-no  { background: var(--bg-hover);  color: var(--text-3); border: 1px solid var(--border); }

    /* ── Actions ── */
    .acts { display: flex; align-items: center; gap: 5px; }
    .act {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
        text-decoration: none;
        border: 1px solid var(--border);
        background: var(--bg-surface);
        cursor: pointer;
        transition: all 0.17s;
        color: var(--text-2);
    }
    .act:hover { border-color: var(--border-light); transform: translateY(-1px); }
    .act-v:hover { background: var(--sky-bg);   color: var(--sky);   border-color: rgba(56,189,248,0.3);  }
    .act-e:hover { background: var(--amber-bg); color: var(--amber); border-color: rgba(245,158,11,0.3);  }
    .act-d:hover { background: var(--red-bg);   color: var(--red);   border-color: rgba(239,68,68,0.3);   }

    /* ── Empty ── */
    .empty {
        padding: 70px 20px;
        text-align: center;
    }
    .empty-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--text-3);
        margin-bottom: 14px;
    }
    .empty p { font-size: 14px; color: var(--text-3); font-weight: 500; }
    .empty span { font-size: 12.5px; color: var(--text-3); margin-top: 4px; display: block; }

    @media (max-width: 768px) {
        .cw { padding: 20px 16px; }
        .stats-row { grid-template-columns: 1fr; }
    }
</style>

<div class="cw">

    {{-- Top ─────────────────────────────── --}}
    <div class="topbar">
        <div class="topbar-left">
            <h1>Contacts</h1>
            <p>Manage contact details & location info</p>
        </div>
        <a href="{{ route('admin.contact.create') }}" class="btn-new">
            <i class="fas fa-plus"></i> New Contact
        </a>
    </div>

    {{-- Toast ──────────────────────────── --}}
    @if(session('success'))
        <div class="toast">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats ──────────────────────────── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-address-book"></i></div>
            <div class="stat-info">
                <p>Total Contacts</p>
                <h3>{{ $contacts->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-map-marker-alt"></i></div>
            <div class="stat-info">
                <p>With Map</p>
                <h3>{{ $contacts->whereNotNull('google_map_embed_code')->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon sky"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <p>Active Emails</p>
                <h3>{{ $contacts->whereNotNull('email')->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- Table ──────────────────────────── --}}
    <div class="tcard">
        <div class="tcard-head">
            <h2>
                <i class="fas fa-table"></i>
                All Records
            </h2>
            <span class="count-chip">{{ $contacts->count() }} entries</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Contact Number</th>
                    <th>Email Address</th>
                    <th>Address</th>
                    <th>Map</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $i => $contact)
                <tr>
                    <td><span class="cell-serial">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></td>
                    <td>
                        <span class="cell-phone">
                            <i class="fas fa-phone"></i>
                            {{ $contact->contact_number }}
                        </span>
                    </td>
                    <td><span class="cell-email">{{ $contact->email }}</span></td>
                    <td><span class="cell-addr" title="{{ $contact->address }}">{{ Str::limit($contact->address, 45) }}</span></td>
                    <td>
                        @if($contact->google_map_embed_code)
                            <span class="badge badge-yes"><i class="fas fa-circle" style="font-size:6px;"></i> Available</span>
                        @else
                            <span class="badge badge-no"><i class="fas fa-minus" style="font-size:8px;"></i> None</span>
                        @endif
                    </td>
                    <td>
                        <div class="acts">
                            <a href="{{ route('admin.contact.show', $contact->id) }}" class="act act-v" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.contact.edit', $contact->id) }}" class="act act-e" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Delete this contact?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act act-d" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty">
                            <div class="empty-icon"><i class="fas fa-address-book"></i></div>
                            <p>No contacts yet</p>
                            <span>Click "New Contact" to add the first one</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
