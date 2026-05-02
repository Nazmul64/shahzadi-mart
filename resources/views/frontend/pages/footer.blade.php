{{-- resources/views/frontend/pages/footer.blade.php --}}

{{-- ── FOOTER ── --}}
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-accent"></div>
        <div class="footer-grid">

            {{-- Brand Column --}}
            <div class="footer-col footer-col--brand">
                <a href="{{ url('/') }}" class="foot-logo">
                    @if($footerSetting->footer_logo)
                        <img src="{{ asset('uploads/avator/' . $footerSetting->footer_logo) }}" alt="Logo" style="max-height: 50px;">
                    @else
                        Shahzadi<em>-mart</em><span class="foot-logo__dot"></span>
                    @endif
                </a>
                <p class="foot-desc">{{ $footerSetting->footer_description }}</p>
                <div class="newsletter">
                    <div class="newsletter__label"><i class="bi bi-envelope-fill"></i> Subscribe for exclusive deals</div>
                    <div class="newsletter__row">
                        <input type="email" id="nlEmail" class="newsletter__input" placeholder="your@email.com" autocomplete="email">
                        <button class="newsletter__btn" type="button" onclick="subscribeNewsletter()">Subscribe</button>
                    </div>
                </div>
                <div class="socials">
                    @if($footerSetting->facebook_url) <a href="{{ $footerSetting->facebook_url }}" class="soc-btn" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a> @endif
                    @if($footerSetting->instagram_url) <a href="{{ $footerSetting->instagram_url }}" class="soc-btn" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a> @endif
                    @if($footerSetting->twitter_url) <a href="{{ $footerSetting->twitter_url }}" class="soc-btn" target="_blank" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a> @endif
                    @if($footerSetting->youtube_url) <a href="{{ $footerSetting->youtube_url }}" class="soc-btn" target="_blank" aria-label="YouTube"><i class="bi bi-youtube"></i></a> @endif
                    @if($footerSetting->tiktok_url) <a href="{{ $footerSetting->tiktok_url }}" class="soc-btn" target="_blank" aria-label="TikTok"><i class="bi bi-tiktok"></i></a> @endif
                </div>
            </div>
           @foreach($pagecrate as $footercat)
            @if($footercat->pages->isNotEmpty())
            <div class="footer-col">

                <h4 class="footer-col__title">{{ $footercat->category_name }}</h4>

                <ul class="footer-col__list">
                    @foreach($footercat->pages as $page)
                    <li>
                        <a href="{{ route('multi.plepage', $page->id) }}">
                            <i class="bi bi-chevron-right"></i>
                            {{ $page->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
            @endif
        @endforeach

        </div>{{-- /.footer-grid --}}

        <div class="footer-btm">
            <p class="footer-btm__copy">
                &copy; {{ date('Y') }} {{ $footerSetting->copyright_text }}. Made with
                <i class="bi bi-heart-fill" style="color:var(--red);font-size:10px;margin:0 3px"></i>
                by <a href="{{ $footerSetting->powered_by_link }}" target="_blank" style="color:inherit; text-decoration:none;"><strong style="color:#555">{{ $footerSetting->powered_by_text }}</strong></a>
            </p>
            <div class="pay-badges">
                @if($footerSetting->payment_methods)
                    @foreach($footerSetting->payment_methods as $method)
                        <span class="pay-b">{{ $method }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</footer>

{{-- ── FLOATING CHAT WIDGET ── --}}
{{-- ✅ fc-notif (লাল dot) সম্পূর্ণ সরানো হয়েছে --}}
<div class="fc-wrap" id="fcWrap">
    <div class="fc-sub-list" id="fcSubList">
        <div class="fc-sub-item">
            <span class="fc-label">Live Chat</span>
            <a href="#" class="fc-sub-btn fc-sub-btn--chat" aria-label="Live Chat"
               onclick="openLiveChat(); return false;"><i class="bi bi-chat-dots-fill"></i></a>
        </div>
        <div class="fc-sub-item">
            <span class="fc-label">Messenger</span>
            <a href="https://m.me/YourPageName" target="_blank" rel="noopener"
               class="fc-sub-btn fc-sub-btn--messenger" aria-label="Messenger"><i class="bi bi-messenger"></i></a>
        </div>
        <div class="fc-sub-item">
            <span class="fc-label">WhatsApp</span>
            <a href="https://wa.me/254700000000" target="_blank" rel="noopener"
               class="fc-sub-btn fc-sub-btn--whatsapp" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
        <div class="fc-sub-item">
            <span class="fc-label">Call Us</span>
            <a href="tel:+254700000000" class="fc-sub-btn fc-sub-btn--phone" aria-label="Call Us">
                <i class="bi bi-telephone-fill"></i>
            </a>
        </div>
    </div>
    <button class="fc-main-btn" id="fcMainBtn" type="button" onclick="toggleFloatChat()" aria-label="Contact us">
        <i class="bi bi-chat-dots-fill fc-icon-open"  id="fcIconOpen"></i>
        <i class="bi bi-x-lg          fc-icon-close" id="fcIconClose"></i>
    </button>
</div>

{{-- ── LIVE CHAT MODAL ── --}}
<div class="lc-overlay" id="lcOverlay" onclick="closeLiveChat()"></div>
<div class="lc-modal" id="lcModal" role="dialog" aria-label="Live Chat">

    {{-- Header --}}
    <div class="lc-header">
        <div class="lc-header__info">
            <div class="lc-avatar"><i class="bi bi-headset"></i></div>
            <div>
                <p class="lc-header__name">Shahzadi-mart Support</p>
                <p class="lc-header__status"><span class="lc-dot"></span> <span id="lcStatusText">Online now</span></p>
            </div>
        </div>
        <button class="lc-close" type="button" onclick="closeLiveChat()" aria-label="Close chat">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- ── STEP 1: Guest info form ── --}}
    @guest
    <div class="lc-guest-form" id="lcGuestForm">
        <div class="lc-gf-inner">
            <p class="lc-gf-title">👋 Hi there! Before we chat…</p>
            <input type="text"  id="lcGuestName"  class="lc-gf-input" placeholder="Your Name *"  maxlength="100">
            <input type="email" id="lcGuestEmail" class="lc-gf-input" placeholder="Your Email *" maxlength="191">
            <button class="lc-gf-btn" type="button" onclick="startChat()">
                <i class="bi bi-chat-dots-fill me-1"></i> Start Chat
            </button>
        </div>
    </div>
    @endguest

    {{-- ── STEP 2: Chat body ── --}}
    <div class="lc-body" id="lcBody" style="display:none"></div>

    {{-- ── STEP 3: Message input ── --}}
    <div class="lc-footer" id="lcFooter" style="display:none">
        <input type="text" id="lcInput" class="lc-input" placeholder="Type a message…"
               onkeydown="if(event.key==='Enter') sendLCMsg()">
        <button class="lc-send" type="button" onclick="sendLCMsg()" aria-label="Send message">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>

</div>{{-- /.lc-modal --}}


<script>
/* ══════════════════════════════════════════════════════════════
   CHAT API URLS
══════════════════════════════════════════════════════════════ */
var _chatUrl = {
    start    : '{{ url("/chat/start") }}',
    send     : '{{ url("/chat/send") }}',
    messages : '{{ url("/chat/messages") }}',
    close    : '{{ url("/chat/close") }}'
};

/* ── State ── */
var _fcOpen        = false;
var _lcSessionUuid = null;
var _lcLastMsgId   = 0;
var _lcPollTimer   = null;
var _lcStarted     = false;
var _isLoggedIn    = @auth true @else false @endauth;
var _csrfToken     = '{{ csrf_token() }}';

/* ══ Floating chat toggle ════════════════════════════════════ */
function toggleFloatChat() {
    _fcOpen = !_fcOpen;
    document.getElementById('fcMainBtn').classList.toggle('is-open', _fcOpen);
    document.getElementById('fcSubList').classList.toggle('is-open', _fcOpen);
}

document.addEventListener('click', function (e) {
    var wrap = document.getElementById('fcWrap');
    if (_fcOpen && wrap && !wrap.contains(e.target)) {
        _fcOpen = false;
        document.getElementById('fcMainBtn').classList.remove('is-open');
        document.getElementById('fcSubList').classList.remove('is-open');
    }
});

/* ══ Open / Close modal ══════════════════════════════════════ */
function openLiveChat() {
    document.getElementById('lcModal').classList.add('is-open');
    document.getElementById('lcOverlay').classList.add('is-open');
    _fcOpen = false;
    document.getElementById('fcMainBtn').classList.remove('is-open');
    document.getElementById('fcSubList').classList.remove('is-open');

    if (_isLoggedIn && !_lcStarted) {
        startChat();
        return;
    }

    if (!_isLoggedIn && !_lcStarted) {
        var storedUuid = localStorage.getItem('lc_session_uuid');
        if (storedUuid) {
            _lcSessionUuid = storedUuid;
            startChat(true);
        }
    }

    @if(isset($fbPixelId) && $fbPixelId)
    if (typeof fbq === 'function') fbq('track', 'Contact');
    @endif
}

function closeLiveChat() {
    document.getElementById('lcModal').classList.remove('is-open');
    document.getElementById('lcOverlay').classList.remove('is-open');
    stopPolling();
}

/* ══ Start / resume chat ════════════════════════════════════ */
function startChat(isResume) {
    var payload = {};

    if (!_isLoggedIn && !isResume) {
        var nameEl  = document.getElementById('lcGuestName');
        var emailEl = document.getElementById('lcGuestEmail');
        var name    = nameEl  ? nameEl.value.trim()  : '';
        var email   = emailEl ? emailEl.value.trim() : '';
        if (!name)                         { _lcAlert('Please enter your name.');     return; }
        if (!email || !email.includes('@')){ _lcAlert('Please enter a valid email.'); return; }
        payload.guest_name  = name;
        payload.guest_email = email;
    }

    if (!_isLoggedIn && isResume && _lcSessionUuid) {
        payload.session_uuid = _lcSessionUuid;
    }

    fetch(_chatUrl.start, {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfToken },
        body    : JSON.stringify(payload)
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (!d.success) {
            if (isResume) {
                localStorage.removeItem('lc_session_uuid');
                _lcSessionUuid = null;
                var gf = document.getElementById('lcGuestForm');
                if (gf) gf.style.display = 'flex';
            }
            _lcAlert(d.message || 'Could not start chat. Please try again.');
            return;
        }

        _lcSessionUuid = d.session_uuid;
        _lcStarted     = true;

        if (!_isLoggedIn) {
            localStorage.setItem('lc_session_uuid', _lcSessionUuid);
        }

        var guestForm = document.getElementById('lcGuestForm');
        if (guestForm) guestForm.style.display = 'none';
        document.getElementById('lcBody').style.display   = 'flex';
        document.getElementById('lcFooter').style.display = 'flex';

        var chatBody = document.getElementById('lcBody');
        chatBody.innerHTML = '';
        if (d.messages && d.messages.length) {
            d.messages.forEach(function (m) { appendBubble(m); });
            _lcLastMsgId = d.messages[d.messages.length - 1].id;
        } else {
            appendInBubble('Hello! 👋 Welcome to <strong>Shahzadi-mart</strong>. How can we help you today?');
        }

        _lcScrollBottom();
        startPolling();

        setTimeout(function () {
            var inp = document.getElementById('lcInput');
            if (inp) inp.focus();
        }, 300);
    })
    .catch(function () {
        _lcAlert('Network error. Please check your connection and try again.');
    });
}

/* ══ Send message ═══════════════════════════════════════════ */
function sendLCMsg() {
    var input = document.getElementById('lcInput');
    if (!input) return;
    var text = input.value.trim();
    if (!text) return;
    input.value = '';

    var payload = { message: text };
    if (!_isLoggedIn && _lcSessionUuid) payload.session_uuid = _lcSessionUuid;

    fetch(_chatUrl.send, {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfToken },
        body    : JSON.stringify(payload)
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (d.success) {
            appendBubble(d.message);
            _lcLastMsgId = d.message.id;
            _lcScrollBottom();
        }
    })
    .catch(function () {});
}

/* ══ Polling ═══════════════════════════════════════════════ */
function startPolling() {
    stopPolling();
    _lcPollTimer = setInterval(pollMessages, 3000);
}

function stopPolling() {
    if (_lcPollTimer) { clearInterval(_lcPollTimer); _lcPollTimer = null; }
}

function pollMessages() {
    if (!_lcStarted) return;
    var url = _chatUrl.messages + '?after_id=' + _lcLastMsgId;
    if (!_isLoggedIn && _lcSessionUuid) {
        url += '&session_uuid=' + encodeURIComponent(_lcSessionUuid);
    }
    fetch(url, { headers: { 'X-CSRF-TOKEN': _csrfToken } })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (d.success && d.messages && d.messages.length) {
            d.messages.forEach(function (m) {
                appendBubble(m);
                _lcLastMsgId = m.id;
            });
            _lcScrollBottom();
        }
    })
    .catch(function () {});
}

/* ══ Bubble helpers ════════════════════════════════════════ */
function appendBubble(msg) {
    var chatBody = document.getElementById('lcBody');
    var isOwn    = msg.is_own;
    var wrapper  = document.createElement('div');
    wrapper.style.cssText = 'display:flex;flex-direction:column;align-items:' + (isOwn ? 'flex-end' : 'flex-start');
    wrapper.innerHTML =
        '<div class="lc-bubble lc-bubble--' + (isOwn ? 'out' : 'in') + '">' +
            '<p>' + _escHtml(msg.message) + '</p>' +
            '<span class="lc-time">' + (msg.time || '') + '</span>' +
        '</div>';
    chatBody.appendChild(wrapper);
}

function appendInBubble(html) {
    var chatBody = document.getElementById('lcBody');
    var wrapper  = document.createElement('div');
    wrapper.style.cssText = 'display:flex;flex-direction:column;align-items:flex-start';
    wrapper.innerHTML =
        '<div class="lc-bubble lc-bubble--in">' +
            '<p>' + html + '</p>' +
            '<span class="lc-time">Just now</span>' +
        '</div>';
    chatBody.appendChild(wrapper);
}

function _lcScrollBottom() {
    var b = document.getElementById('lcBody');
    if (b) b.scrollTop = b.scrollHeight;
}

function _escHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function _lcAlert(msg) {
    if (typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
}

/* ══ Newsletter ════════════════════════════════════════════ */
function subscribeNewsletter() {
    var input = document.getElementById('nlEmail');
    if (!input) return;
    var email = input.value.trim();
    if (!email || !email.includes('@')) {
        if (typeof toastr !== 'undefined') toastr.error('Please enter a valid email address.');
        return;
    }
    @if(isset($fbPixelId) && $fbPixelId)
    if (typeof fbq === 'function') fbq('track', 'Lead', { content_name: 'Newsletter Subscribe' });
    @endif
    if (typeof toastr !== 'undefined') toastr.success("You've subscribed to our newsletter!");
    input.value = '';
}

/* ══ DataLayer / Pixel ════════════════════════════════════ */
window.dataLayer = window.dataLayer || [];
function pushDataLayer(obj) { window.dataLayer.push(obj); }
@if(isset($fbPixelId) && $fbPixelId)
function trackPixelEvent(event, params) {
    if (typeof fbq === 'function') fbq('track', event, params || {});
}
@else
function trackPixelEvent() {}
@endif
</script>

</body>
</html>
