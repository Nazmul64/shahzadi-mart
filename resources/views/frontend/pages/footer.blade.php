@php
    // $gs, $footerSetting, $pagecrate — AppServiceProvider থেকে cached share হয়
    $footerCategories = $pagecrate ?? collect();
@endphp
{{-- ── FOOTER ── --}}
<footer class="site-footer">
    <div class="{{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        <div class="footer-inner">
            <div class="footer-accent"></div>
            <div class="footer-grid">

                {{-- Brand Column --}}
                <div class="footer-col footer-col--brand">
                    <a href="{{ url('/') }}" class="foot-logo">
                        @if($footerSetting->footer_logo)
                            <img src="{{ asset('uploads/avator/' . $footerSetting->footer_logo) }}" alt="{{ $gs->site_name }}" style="max-height: 50px;">
                        @elseif($gs->footer_logo)
                            <img src="{{ asset($gs->footer_logo) }}" alt="{{ $gs->site_name }}" style="max-height: 50px;">
                        @else
                            {{ $gs->site_name }}<span class="foot-logo__dot"></span>
                        @endif
                    </a>
                    <p class="foot-desc">{{ $footerSetting->footer_description }}</p>
                    <div class="newsletter">
                        <div class="newsletter__label"><i class="bi bi-envelope-fill"></i> Subscribe for exclusive deals</div>
                        <div class="newsletter__row">
                            <input type="email" id="nlEmail" class="newsletter__input" placeholder="your@email.com" autocomplete="email">
                            <button class="newsletter__btn" type="button" onclick="subscribeNewsletter(event)">Subscribe</button>
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
               @foreach($footerCategories as $footercat)
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
                    by <a href="{{ $footerSetting->powered_by_text }}" target="_blank" style="color:inherit; text-decoration:none;"><strong style="color:#e0e0e0">{{ $footerSetting->powered_by_text }}</strong></a>
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
            <a href="{{ $contactinformationadmin->messanger_url ?? '#' }}" target="_blank" rel="noopener"
               class="fc-sub-btn fc-sub-btn--messenger" aria-label="Messenger"><i class="bi bi-messenger"></i></a>
        </div>
        <div class="fc-sub-item">
            <span class="fc-label">WhatsApp</span>
            <a href="https://wa.me/{{ $contactinformationadmin->watsapp_url ?? '' }}" target="_blank" rel="noopener"
               class="fc-sub-btn fc-sub-btn--whatsapp" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
        <div class="fc-sub-item">
            <span class="fc-label">Call Us</span>
            <a href="tel:{{ $contactinformationadmin->phone ?? '' }}" class="fc-sub-btn fc-sub-btn--phone" aria-label="Call Us">
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
                <p class="lc-header__name">{{ $gs->site_name }} Support</p>
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
/* ── Global Loader & Network Status ── */
(function() {
    const loader = document.getElementById('global-loader');
    const progressBar = document.getElementById('top-progress-bar');
    const offlineIndicator = document.getElementById('offline-indicator');
    const offlineIcon = document.getElementById('offline-icon-bi');
    const offlineText = document.getElementById('offline-text');

    // 1. Hide Loader
    function hideLoader() {
        if (loader) {
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 600);
        }
    }

    window.addEventListener('load', hideLoader);
    // Fallback: hide loader after 1.5 seconds anyway — superfast feel
    setTimeout(hideLoader, 1500);

    // 2. Top Progress Bar
    function startProgressBar() {
        if (!progressBar) return;
        progressBar.style.width = '0%';
        progressBar.style.display = 'block';
        let width = 0;
        const interval = setInterval(() => {
            if (width >= 90) {
                clearInterval(interval);
            } else {
                width += Math.random() * 5;
                progressBar.style.width = width + '%';
            }
        }, 200);

        window.progressBarInterval = interval;
    }

    function completeProgressBar() {
        if (!progressBar) return;
        if (window.progressBarInterval) clearInterval(window.progressBarInterval);
        progressBar.style.width = '100%';
        setTimeout(() => {
            progressBar.style.opacity = '0';
            setTimeout(() => {
                progressBar.style.display = 'none';
                progressBar.style.width = '0%';
                progressBar.style.opacity = '1';
            }, 300);
        }, 500);
    }

    // Intercept link clicks for progress bar
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link &&
            link.href &&
            !link.href.includes('#') &&
            !link.href.includes('javascript:') &&
            link.target !== '_blank' &&
            link.host === window.location.host) {
            startProgressBar();
        }
    });

    // 3. Network Status
    function updateNetworkStatus() {
        if (!offlineIndicator) return;

        if (navigator.onLine) {
            if (offlineIndicator.classList.contains('offline')) {
                offlineIndicator.classList.remove('offline');
                offlineIndicator.classList.add('online');
                offlineIcon.className = 'bi bi-wifi';
                offlineText.textContent = 'আপনি এখন অনলাইনে আছেন।';

                // Hide after 3 seconds of being online
                setTimeout(() => {
                    offlineIndicator.classList.remove('show');
                }, 3000);
            }
        } else {
            offlineIndicator.classList.add('show');
            offlineIndicator.classList.add('offline');
            offlineIndicator.classList.remove('online');
            offlineIcon.className = 'bi bi-wifi-off';
            offlineText.textContent = 'আপনি অফলাইনে আছেন! সংযোগ পরীক্ষা করুন।';
        }
    }

    window.addEventListener('online', updateNetworkStatus);
    window.addEventListener('offline', updateNetworkStatus);

    // Initial check
    if (!navigator.onLine) {
        updateNetworkStatus();
    }
})();

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
            appendInBubble('Hello! 👋 Welcome to <strong>' + '{{ $gs->site_name }}' + '</strong>. How can we help you today?');
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
function subscribeNewsletter(e) {
    var input = document.getElementById('nlEmail');
    if (!input) return;
    var email = input.value.trim();
    if (!email) {
        if (typeof toastr !== 'undefined') toastr.error('ইমেইল প্রদান করুন।');
        return;
    }

    // Basic regex for email
    var re = /\S+@\S+\.\S+/;
    if (!re.test(email)) {
        if (typeof toastr !== 'undefined') toastr.error('সঠিক ইমেইল প্রদান করুন।');
        return;
    }

    var btn = e ? e.currentTarget : document.querySelector('.newsletter__btn');
    var originalText = btn.innerText;
    btn.disabled = true;
    btn.innerText = '...';

    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.innerText = originalText;
        if (data.success) {
            if (typeof toastr !== 'undefined') toastr.success(data.message);
            input.value = '';
            @if(isset($fbPixelId) && $fbPixelId)
            if (typeof fbq === 'function') fbq('track', 'Lead', { content_name: 'Newsletter Subscribe' });
            @endif
        } else {
            if (typeof toastr !== 'undefined') toastr.error(data.message);
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.innerText = originalText;
        if (typeof toastr !== 'undefined') toastr.error('কিছু ভুল হয়েছে, আবার চেষ্টা করুন।');
    });
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

/* ── Global Toast System ── */
function showGlobalToast(msg, type = 'success') {
    var toast = document.createElement('div');
    toast.style.cssText = 'position:fixed;top:20px;right:20px;background:#1a1a2e;color:#fff;padding:14px 24px;border-radius:12px;z-index:2147483647;display:flex;align-items:center;gap:12px;box-shadow:0 10px 30px rgba(0,0,0,0.2);border-left:4px solid ' + (type === 'error' ? '#ef4444' : '#be0318') + ';animation:toastIn .4s cubic-bezier(0.175, 0.885, 0.32, 1.275);';
    toast.innerHTML = '<i class="bi bi-' + (type === 'error' ? 'exclamation-circle' : 'check-circle') + '-fill" style="color:' + (type === 'error' ? '#ef4444' : '#be0318') + ';font-size:18px;"></i> <span>' + msg + '</span>';
    document.body.appendChild(toast);
    
    setTimeout(function() {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        toast.style.transition = 'all .3s';
        setTimeout(function() { toast.remove(); }, 300);
    }, 3000);
}

// Inline animation for toast
var style = document.createElement('style');
style.innerHTML = '@keyframes toastIn { from { opacity:0; transform:translateX(50px); } to { opacity:1; transform:translateX(0); } }';
document.head.appendChild(style);

/* ── Global Wishlist Listener ── */
document.addEventListener('click', function(e) {
    var btn = e.target.closest('.smhome-p-wish, .pdp__wish-btn');
    if (btn) {
        e.preventDefault();
        e.stopPropagation();
        
        var url = btn.getAttribute('href') || btn.dataset.url;
        if (!url) return;
        
        // Visual feedback immediately
        var icon = btn.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        }
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            showGlobalToast(d.message, d.success ? 'success' : 'error');
            if (d.success) {
                btn.style.color = 'var(--red)';
                
                // Update badges
                var badge = document.getElementById('wishBadge');
                if (badge && d.count !== undefined) {
                    badge.textContent = d.count;
                    badge.classList.remove('zero');
                }
                var pill = document.querySelector('.wish-count-pill');
                if (pill && d.count !== undefined) {
                    pill.textContent = d.count;
                }
            } else {
                // If not successful (e.g. already in wishlist), keep the filled icon but maybe it was already filled
            }
        })
        .catch(function(err) {
            console.error('Wishlist error:', err);
            showGlobalToast('কিছু ভুল হয়েছে, আবার চেষ্টা করুন।', 'error');
        });
    }
});
</script>

</body>
</html>
