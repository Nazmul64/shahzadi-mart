@extends('emplee.master')
<style>
/* ═══════════════════════════════════════════════════════════════
   CHAT PANEL — Two-column layout
═══════════════════════════════════════════════════════════════ */
.chat-wrap {
    display        : flex;
    height         : calc(100vh - 130px);
    min-height     : 500px;
    border-radius  : 14px;
    overflow       : hidden;
    box-shadow     : 0 4px 24px rgba(0,0,0,.10);
    background     : #fff;
    border         : 1px solid #e8ecf0;
}

/* ── LEFT: Session list ── */
.chat-sidebar {
    width          : 300px;
    flex-shrink    : 0;
    display        : flex;
    flex-direction : column;
    border-right   : 1px solid #eef0f3;
    background     : #f7f8fa;
}
.chat-sidebar__header {
    padding        : 16px;
    border-bottom  : 1px solid #eef0f3;
    background     : #fff;
}
.chat-sidebar__title {
    font-size      : 14px;
    font-weight    : 700;
    color          : #1e293b;
    margin         : 0 0 10px;
    display        : flex;
    align-items    : center;
    gap            : 7px;
}
.chat-sidebar__search {
    position       : relative;
}
.chat-sidebar__search input {
    width          : 100%;
    padding        : 7px 12px 7px 32px;
    border         : 1px solid #e2e8f0;
    border-radius  : 20px;
    font-size      : 12.5px;
    outline        : none;
    background     : #f7f8fa;
    color          : #334155;
    transition     : border-color .2s;
}
.chat-sidebar__search input:focus { border-color: #25d366; background: #fff; }
.chat-sidebar__search i {
    position       : absolute;
    left           : 11px;
    top            : 50%;
    transform      : translateY(-50%);
    color          : #94a3b8;
    font-size      : 12px;
}
.chat-session-list {
    flex           : 1;
    overflow-y     : auto;
    scrollbar-width: thin;
    scrollbar-color: #dde1e7 transparent;
}
.chat-session-list::-webkit-scrollbar       { width: 4px; }
.chat-session-list::-webkit-scrollbar-thumb { background: #dde1e7; border-radius: 4px; }

.session-item {
    display        : flex;
    align-items    : center;
    gap            : 10px;
    padding        : 11px 14px;
    cursor         : pointer;
    border-bottom  : 1px solid #f1f3f5;
    text-decoration: none;
    transition     : background .15s;
    position       : relative;
}
.session-item:hover           { background: #edf4ff; }
.session-item.active          { background: #e8f5e9; border-left: 3px solid #25d366; }
.session-item.has-unread      { background: #fff8e1; }
.session-item.active.has-unread { background: #e8f5e9; }

.session-avatar {
    width          : 38px;
    height         : 38px;
    border-radius  : 50%;
    display        : flex;
    align-items    : center;
    justify-content: center;
    font-size      : 14px;
    font-weight    : 700;
    color          : #fff;
    flex-shrink    : 0;
}
.session-info    { flex: 1; min-width: 0; }
.session-name {
    font-size      : 13px;
    font-weight    : 600;
    color          : #1e293b;
    white-space    : nowrap;
    overflow       : hidden;
    text-overflow  : ellipsis;
    margin         : 0;
}
.session-preview {
    font-size      : 11.5px;
    color          : #94a3b8;
    white-space    : nowrap;
    overflow       : hidden;
    text-overflow  : ellipsis;
    margin         : 2px 0 0;
}
.session-meta {
    display        : flex;
    flex-direction : column;
    align-items    : flex-end;
    gap            : 4px;
    flex-shrink    : 0;
}
.session-time  { font-size: 10px; color: #b0b8c4; }
.unread-dot {
    width          : 18px;
    height         : 18px;
    border-radius  : 50%;
    background     : #ef4444;
    color          : #fff;
    font-size      : 10px;
    font-weight    : 700;
    display        : flex;
    align-items    : center;
    justify-content: center;
}
.status-dot {
    width          : 8px;
    height         : 8px;
    border-radius  : 50%;
    border         : 2px solid #fff;
    position       : absolute;
    bottom         : 10px;
    left           : 40px;
}
.status-dot.active   { background: #22c55e; }
.status-dot.closed   { background: #94a3b8; }
.status-dot.pending  { background: #f59e0b; }

/* ── RIGHT: Chat window ── */
.chat-main {
    flex           : 1;
    display        : flex;
    flex-direction : column;
    min-width      : 0;
    background     : #fff;
}
.chat-main__header {
    padding        : 12px 18px;
    border-bottom  : 1px solid #eef0f3;
    display        : flex;
    align-items    : center;
    gap            : 12px;
    background     : #fff;
    flex-shrink    : 0;
}
.chat-main__avatar {
    width          : 40px;
    height         : 40px;
    border-radius  : 50%;
    display        : flex;
    align-items    : center;
    justify-content: center;
    font-size      : 15px;
    font-weight    : 700;
    color          : #fff;
    flex-shrink    : 0;
}
.chat-main__name   { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
.chat-main__sub    { font-size: 11.5px; color: #94a3b8; margin: 2px 0 0; }
.chat-main__actions { margin-left: auto; display: flex; gap: 8px; align-items: center; }

.chat-body {
    flex           : 1;
    overflow-y     : auto;
    padding        : 18px 20px;
    display        : flex;
    flex-direction : column;
    gap            : 10px;
    background     : #f8fafc;
    scrollbar-width: thin;
    scrollbar-color: #dde1e7 transparent;
}
.chat-body::-webkit-scrollbar       { width: 4px; }
.chat-body::-webkit-scrollbar-thumb { background: #dde1e7; border-radius: 4px; }

/* bubbles */
.bubble-wrap { display: flex; flex-direction: column; }
.bubble-wrap.out { align-items: flex-end; }
.bubble-wrap.in  { align-items: flex-start; }
.bubble-sender   { font-size: 11px; color: #94a3b8; margin-bottom: 3px; padding: 0 4px; }
.bubble {
    max-width      : 70%;
    padding        : 10px 15px;
    border-radius  : 18px;
    font-size      : 13.5px;
    line-height    : 1.6;
    word-break     : break-word;
    box-shadow     : 0 1px 4px rgba(0,0,0,.07);
}
.bubble.out { background: #25d366; color: #fff; border-bottom-right-radius: 4px; }
.bubble.in  { background: #fff;    color: #1e293b; border-bottom-left-radius: 4px; }
.bubble-time {
    font-size      : 10.5px;
    color          : #b0b8c4;
    margin-top     : 4px;
    padding        : 0 4px;
    display        : flex;
    align-items    : center;
    gap            : 4px;
}

.chat-empty {
    flex           : 1;
    display        : flex;
    flex-direction : column;
    align-items    : center;
    justify-content: center;
    color          : #cbd5e1;
    gap            : 10px;
}
.chat-empty i  { font-size: 48px; opacity: .35; }
.chat-empty p  { font-size: 13px; margin: 0; }

/* ── Footer / input ── */
.chat-footer {
    padding        : 10px 14px;
    border-top     : 1px solid #eef0f3;
    background     : #fff;
    display        : flex;
    gap            : 8px;
    align-items    : center;
    flex-shrink    : 0;
}
.chat-footer input {
    flex           : 1;
    border         : 1px solid #e2e8f0;
    border-radius  : 24px;
    padding        : 10px 18px;
    font-size      : 13.5px;
    outline        : none;
    color          : #1e293b;
    transition     : border-color .2s;
}
.chat-footer input:focus { border-color: #25d366; }
.chat-send-btn {
    width          : 40px;
    height         : 40px;
    border-radius  : 50%;
    background     : #25d366;
    border         : none;
    color          : #fff;
    font-size      : 15px;
    display        : flex;
    align-items    : center;
    justify-content: center;
    cursor         : pointer;
    flex-shrink    : 0;
    transition     : background .2s, transform .15s;
}
.chat-send-btn:hover   { background: #1dba58; transform: scale(1.08); }
.chat-closed-banner {
    padding        : 12px;
    text-align     : center;
    background     : #f1f5f9;
    color          : #94a3b8;
    font-size      : 12.5px;
    border-top     : 1px solid #eef0f3;
}

/* date separator */
.date-sep {
    display        : flex;
    align-items    : center;
    gap            : 10px;
    margin         : 6px 0;
}
.date-sep span {
    font-size      : 10.5px;
    color          : #b0b8c4;
    white-space    : nowrap;
    background     : #f8fafc;
    padding        : 0 8px;
}
.date-sep::before,
.date-sep::after  { content: ''; flex: 1; height: 1px; background: #e8ecf0; }

@media (max-width: 768px) {
    .chat-sidebar { width: 100%; border-right: none; }
    .chat-wrap    { flex-direction: column; height: auto; }
    .chat-main    { min-height: 400px; }
}
</style>


@section('content')
  <!-- TOPBAR -->
  @include('emplee.pages.topbar')

  <!-- CONTENT -->
  <div id="content">
<div class="page-wrapper" style="padding:16px 20px">

    {{-- ══ Page title ══ --}}
    <div class="d-flex align-items-center gap-3 mb-3">
        <a href="{{ route('emplee.chat.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <div>
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-chat-dots-fill text-success me-2"></i>Live Chat
            </h5>
        </div>
        <span class="badge bg-danger ms-auto px-3 py-2" id="globalUnreadBadge" style="display:none">
            <i class="bi bi-bell-fill me-1"></i><span id="globalUnreadNum">0</span> unread
        </span>
    </div>

    {{-- ══ Two-panel chat ══ --}}
    <div class="chat-wrap">

        {{-- ════ LEFT: Session sidebar ════ --}}
        <div class="chat-sidebar">
            <div class="chat-sidebar__header">
                <p class="chat-sidebar__title">
                    <i class="bi bi-people-fill text-success"></i> Conversations
                    @php
                        $totalUnread = $allSessions->sum(fn($s) => $s->unread_count ?? 0);
                    @endphp
                    @if($totalUnread > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $totalUnread }}</span>
                    @endif
                </p>
                <div class="chat-sidebar__search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="sessionSearch" placeholder="Search conversations…"
                           oninput="filterSessions(this.value)">
                </div>
            </div>

            <div class="chat-session-list" id="sessionList">
                @forelse($allSessions as $s)
                @php
                    $isActive  = $s->id === $chatSession->id;
                    $unread    = $s->unread_count ?? 0;
                    $lastMsg   = $s->messages->first();
                    $avatarBg  = $s->user_id ? '#3b82f6' : '#64748b';
                    $initial   = strtoupper(substr($s->display_name ?? $s->guest_name ?? 'G', 0, 1));
                    $name      = $s->display_name ?? $s->guest_name ?? 'Guest';
                    $preview   = $lastMsg ? Str::limit($lastMsg->message, 35) : 'No messages yet';
                @endphp
                <a href="{{ route('emplee.chat.show', $s->id) }}"
                   class="session-item {{ $isActive ? 'active' : '' }} {{ $unread > 0 && !$isActive ? 'has-unread' : '' }}"
                   data-name="{{ strtolower($name) }}">

                    {{-- Online dot --}}
                    <div class="session-avatar" style="background:{{ $avatarBg }}">{{ $initial }}</div>
                    <span class="status-dot {{ $s->status }}"></span>

                    <div class="session-info">
                        <p class="session-name">{{ $name }}</p>
                        <p class="session-preview">
                            @if($lastMsg)
                                @if($lastMsg->sender_type === 'admin')
                                    <span style="color:#22c55e;font-size:11px">You: </span>
                                @endif
                                {{ $preview }}
                            @else
                                No messages yet
                            @endif
                        </p>
                    </div>

                    <div class="session-meta">
                        <span class="session-time">
                            {{ $s->last_activity_at?->diffForHumans(null, true) ?? '—' }}
                        </span>
                        @if($unread > 0 && !$isActive)
                        <span class="unread-dot">{{ $unread > 9 ? '9+' : $unread }}</span>
                        @endif
                    </div>
                </a>
                @empty
                <div class="text-center py-5 text-muted small">
                    <i class="bi bi-chat-square-dots d-block mb-2" style="font-size:28px;opacity:.3"></i>
                    No conversations yet
                </div>
                @endforelse
            </div>
        </div>{{-- /.chat-sidebar --}}

        {{-- ════ RIGHT: Chat window ════ --}}
        <div class="chat-main">

            {{-- Header --}}
            <div class="chat-main__header">
                <div class="chat-main__avatar"
                     style="background:{{ $chatSession->user_id ? '#3b82f6' : '#25d366' }}">
                    {{ strtoupper(substr($chatSession->display_name ?? $chatSession->guest_name ?? 'G', 0, 1)) }}
                </div>
                <div>
                    <p class="chat-main__name">
                        {{ $chatSession->display_name ?? ($chatSession->guest_name ?? 'Guest') }}
                    </p>
                    <p class="chat-main__sub">
                        @if($chatSession->user_id)
                            <i class="bi bi-person-check-fill text-primary me-1"></i>Registered
                            · {{ $chatSession->user?->email }}
                        @else
                            <i class="bi bi-person me-1"></i>Guest
                            · {{ $chatSession->guest_email ?? '—' }}
                        @endif
                        &nbsp;|&nbsp; Session #{{ $chatSession->id }}
                    </p>
                </div>

                <div class="chat-main__actions">
                    <span class="badge bg-{{ $chatSession->status === 'active' ? 'success' : ($chatSession->status === 'pending' ? 'warning' : 'secondary') }} px-3 py-2">
                        @if($chatSession->status === 'active')
                            <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#fff;margin-right:5px;animation:pulse 1.5s infinite"></span>
                        @endif
                        {{ ucfirst($chatSession->status) }}
                    </span>
                    @if($chatSession->status !== 'closed')
                    <button class="btn btn-sm btn-outline-danger" onclick="closeSession()">
                        <i class="bi bi-x-circle me-1"></i>Close Chat
                    </button>
                    @endif
                </div>
            </div>

            {{-- Messages --}}
            <div class="chat-body" id="chatBody">
                @php $prevDate = null; @endphp

                @forelse($messages as $msg)
                @php
                    $isAdmin  = $msg->sender_type === 'admin';
                    $msgDate  = $msg->created_at->toDateString();
                @endphp

                {{-- Date separator --}}
                @if($msgDate !== $prevDate)
                <div class="date-sep">
                    <span>{{ $msg->created_at->isToday() ? 'Today' : ($msg->created_at->isYesterday() ? 'Yesterday' : $msg->created_at->format('d M Y')) }}</span>
                </div>
                @php $prevDate = $msgDate; @endphp
                @endif

                <div class="bubble-wrap {{ $isAdmin ? 'out' : 'in' }}">
                    @if(! $isAdmin)
                    <span class="bubble-sender">
                        {{ $msg->user?->name ?? $chatSession->guest_name ?? 'Guest' }}
                    </span>
                    @endif

                    <div class="bubble {{ $isAdmin ? 'out' : 'in' }}">{{ $msg->message }}</div>

                    <div class="bubble-time">
                        {{ $msg->created_at->format('g:i A') }}
                        @if($isAdmin)
                        <i class="bi bi-check2{{ $msg->is_read ? '-all' : '' }}"
                           style="font-size:12px;color:{{ $msg->is_read ? '#60a5fa' : '#94a3b8' }}"></i>
                        @endif
                    </div>
                </div>

                @empty
                <div class="chat-empty" id="chatEmpty">
                    <i class="bi bi-chat-dots"></i>
                    <p>No messages yet. Send the first message!</p>
                </div>
                @endforelse
            </div>

            {{-- Footer --}}
            @if($chatSession->status !== 'closed')
            <div class="chat-footer">
                <input type="text"
                       id="replyInput"
                       placeholder="Type a reply and press Enter…"
                       onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();adminSend();}">
                <button class="chat-send-btn" onclick="adminSend()" title="Send">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
            @else
            <div class="chat-closed-banner">
                <i class="bi bi-lock-fill me-1"></i>This chat session has been closed.
            </div>
            @endif

        </div>{{-- /.chat-main --}}

    </div>{{-- /.chat-wrap --}}
</div>

<style>
@keyframes pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.6; transform:scale(1.4); }
}
</style>

<script>
/* ═══════════════════════════════════════════════════════════
   Variables
═══════════════════════════════════════════════════════════ */
var LAST_ID      = {{ $messages->last()?->id ?? 0 }};
var IS_CLOSED    = {{ $chatSession->status === 'closed' ? 'true' : 'false' }};
var CSRF         = '{{ csrf_token() }}';
var REPLY_URL    = '{{ route("emplee.chat.reply",    $chatSession->id) }}';
var POLL_URL     = '{{ route("emplee.chat.messages", $chatSession->id) }}';
var CLOSE_URL    = '{{ route("emplee.chat.close",    $chatSession->id) }}';
var UNREAD_URL   = '{{ route("emplee.chat.unread") }}';
var INDEX_URL    = '{{ route("emplee.chat.index") }}';
var pollTimer;

/* ── Scroll to bottom ──────────────────────────────────── */
function scrollBot() {
    var b = document.getElementById('chatBody');
    if (b) b.scrollTop = b.scrollHeight;
}
scrollBot();

/* ── Send admin reply ──────────────────────────────────── */
function adminSend() {
    var inp  = document.getElementById('replyInput');
    var text = inp.value.trim();
    if (!text) return;
    inp.value    = '';
    inp.disabled = true;

    fetch(REPLY_URL, {
        method  : 'POST',
        headers : { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF },
        body    : JSON.stringify({ message: text })
    })
    .then(r => r.json())
    .then(d => {
        inp.disabled = false;
        inp.focus();
        if (d.success) {
            addBubble(d.message);
            LAST_ID = d.message.id;
        }
    })
    .catch(() => { inp.disabled = false; });
}

/* ── Add a bubble to the DOM ───────────────────────────── */
function addBubble(msg, animate) {
    // Remove empty state
    var empty = document.getElementById('chatEmpty');
    if (empty) empty.remove();

    var body    = document.getElementById('chatBody');
    var isAdmin = msg.is_own;
    var wrap    = document.createElement('div');
    wrap.className = 'bubble-wrap ' + (isAdmin ? 'out' : 'in');
    if (animate) { wrap.style.opacity = '0'; wrap.style.transition = 'opacity .3s'; }

    var senderHtml = '';
    if (!isAdmin) {
        senderHtml = '<span class="bubble-sender">' + _esc(msg.sender_name) + '</span>';
    }

    var readIcon = isAdmin
        ? '<i class="bi bi-check2' + (msg.is_read ? '-all' : '') + '" style="font-size:12px;color:' + (msg.is_read ? '#60a5fa' : '#94a3b8') + '"></i>'
        : '';

    wrap.innerHTML = senderHtml
        + '<div class="bubble ' + (isAdmin ? 'out' : 'in') + '">' + _esc(msg.message) + '</div>'
        + '<div class="bubble-time">' + _esc(msg.time) + readIcon + '</div>';

    body.appendChild(wrap);
    scrollBot();

    if (animate) { requestAnimationFrame(() => { wrap.style.opacity = '1'; }); }
}

/* ── Poll new messages every 3 s ───────────────────────── */
function pollMessages() {
    if (IS_CLOSED) return;
    fetch(POLL_URL + '?after_id=' + LAST_ID, { headers: { 'X-CSRF-TOKEN': CSRF } })
    .then(r => r.json())
    .then(d => {
        if (d.success && d.messages.length) {
            d.messages.forEach(m => { addBubble(m, true); LAST_ID = m.id; });
        }
    })
    .catch(() => {});
}
pollTimer = setInterval(pollMessages, 3000);

/* ── Global unread badge ───────────────────────────────── */
function refreshUnread() {
    fetch(UNREAD_URL).then(r => r.json()).then(d => {
        var el = document.getElementById('globalUnreadBadge');
        var nm = document.getElementById('globalUnreadNum');
        if (el && nm) {
            nm.textContent  = d.count;
            el.style.display = d.count > 0 ? 'inline-block' : 'none';
        }
    }).catch(() => {});
}
refreshUnread();
setInterval(refreshUnread, 10000);

/* ── Close session ─────────────────────────────────────── */
function closeSession() {
    if (!confirm('Close this chat session?')) return;
    fetch(CLOSE_URL, {
        method  : 'POST',
        headers : { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) { clearInterval(pollTimer); window.location.href = INDEX_URL; }
    })
    .catch(() => {});
}

/* ── Session search filter ─────────────────────────────── */
function filterSessions(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#sessionList .session-item').forEach(function(el) {
        el.style.display = el.dataset.name.includes(q) ? 'flex' : 'none';
    });
}

/* ── XSS escape ────────────────────────────────────────── */
function _esc(s) {
    if (!s) return '';
    return String(s)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
    </div>
  </div><!-- /content -->
@endsection
