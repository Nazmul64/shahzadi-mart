{{-- resources/views/frontend/pages/footer.blade.php --}}

{{-- ── FOOTER ── --}}
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-accent"></div>
        <div class="footer-grid">

            {{-- Brand Column --}}
            <div class="footer-col footer-col--brand">
                <a href="{{ url('/') }}" class="foot-logo">
                    Shahzadi<em>-mart</em><span class="foot-logo__dot"></span>
                </a>
                <p class="foot-desc">Your trusted marketplace for premium products. Quality guaranteed, delivered to your door.</p>
                <div class="newsletter">
                    <div class="newsletter__label"><i class="bi bi-envelope-fill"></i> Subscribe for exclusive deals</div>
                    <div class="newsletter__row">
                        <input type="email" id="nlEmail" class="newsletter__input" placeholder="your@email.com" autocomplete="email">
                        <button class="newsletter__btn" type="button" onclick="subscribeNewsletter()">Subscribe</button>
                    </div>
                </div>
                <div class="socials">
                    <a href="#" class="soc-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="soc-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="soc-btn" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="soc-btn" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="soc-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            {{-- About --}}
            <div class="footer-col">
                <h4 class="footer-col__title">About Us</h4>
                <ul class="footer-col__list">
                    <li><a href="#"><i class="bi bi-chevron-right"></i> About Shahzadi-mart</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Contact Us</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Terms &amp; Conditions</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Careers</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Press &amp; Media</a></li>
                </ul>
            </div>

            {{-- Make Money --}}
            <div class="footer-col">
                <h4 class="footer-col__title">Make Money</h4>
                <ul class="footer-col__list">
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Sell on Shahzadi-mart</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Affiliate Program</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Apply to Deliver</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Pickup Station</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Advertise With Us</a></li>
                </ul>
            </div>

            {{-- Customer Care --}}
            <div class="footer-col">
                <h4 class="footer-col__title">Customer Care</h4>
                <ul class="footer-col__list">
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Return Policy</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Refund Policy</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Shipping Policy</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Help Center</a></li>
                    <li><a href="{{ route('order.track') }}"><i class="bi bi-chevron-right"></i> Track Your Order</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i> Report a Problem</a></li>
                </ul>
            </div>

        </div>{{-- /.footer-grid --}}

        <div class="footer-btm">
            <p class="footer-btm__copy">
                &copy; {{ date('Y') }} Shahzadi-mart. All rights reserved. Made with
                <i class="bi bi-heart-fill" style="color:var(--red);font-size:10px;margin:0 3px"></i>
                by <strong style="color:#555">Freaku Technologies</strong>
            </p>
            <div class="pay-badges">
                <span class="pay-b">VISA</span>
                <span class="pay-b">M-PESA</span>
                <span class="pay-b">PAYPAL</span>
                <span class="pay-b">MASTERCARD</span>
                <span class="pay-b">AIRTEL</span>
            </div>
        </div>
    </div>
</footer>

{{-- ── FLOATING CHAT WIDGET ── --}}
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
    <span class="fc-notif" id="fcNotif"></span>
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

    {{-- ── STEP 1: Guest info form (hidden for logged-in users) ── --}}
    @guest
    <div class="lc-guest-form" id="lcGuestForm">
        <div class="lc-gf-inner">
            <p class="lc-gf-title">👋 Hi there! Before we chat…</p>
            <input type="text"  id="lcGuestName"  class="lc-gf-input" placeholder="Your Name *" maxlength="100">
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

<style>
/* ── FOOTER ── */
.site-footer{background:var(--dark);margin-top:60px;position:relative}
.footer-accent{height:3px;background:linear-gradient(90deg,var(--red),var(--gold),var(--red));background-size:200% 100%;animation:grad-flow 4s ease infinite}
@keyframes grad-flow{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
.footer-grid{max-width:var(--wrap);margin:0 auto;padding:48px 20px 32px;display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:44px}
.foot-logo{font-family:'Fraunces',serif;font-size:24px;font-weight:900;color:var(--white);letter-spacing:-.02em;display:inline-flex;align-items:center;margin-bottom:12px;text-decoration:none}
.foot-logo em{color:var(--red);font-style:normal}
.foot-logo__dot{width:6px;height:6px;background:var(--gold);border-radius:50%;margin-left:3px;display:inline-block}
.foot-desc{color:#555;font-size:13px;line-height:1.75;margin-bottom:20px;max-width:300px}
.newsletter{margin-bottom:20px}
.newsletter__label{color:#555;font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;margin-bottom:9px;display:flex;align-items:center;gap:6px}
.newsletter__label .bi{color:var(--gold)}
.newsletter__row{display:flex;border:1px solid #222;border-radius:var(--r);overflow:hidden}
.newsletter__input{flex:1;background:#141414;border:none;padding:10px 13px;color:var(--white);font-family:'Nunito',sans-serif;font-size:13px;outline:none;min-width:0}
.newsletter__input::placeholder{color:#333}
.newsletter__btn{background:var(--red);color:#fff;border:none;padding:10px 16px;font-family:'Nunito',sans-serif;font-size:11.5px;font-weight:800;letter-spacing:.07em;text-transform:uppercase;cursor:pointer;white-space:nowrap;transition:var(--t);flex-shrink:0}
.newsletter__btn:hover{background:var(--red-d)}
.socials{display:flex;gap:8px;flex-wrap:wrap}
.soc-btn{width:34px;height:34px;background:#141414;border:1px solid #222;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#555;font-size:14px;transition:var(--t);text-decoration:none}
.soc-btn:hover{background:var(--red);border-color:var(--red);color:#fff;transform:translateY(-3px);box-shadow:0 5px 14px rgba(200,16,46,.3)}
.footer-col__title{color:var(--white);font-size:9.5px;font-weight:800;letter-spacing:.17em;text-transform:uppercase;margin-bottom:18px;padding-bottom:11px;border-bottom:1px solid #1e1e1e;position:relative}
.footer-col__title::after{content:'';position:absolute;bottom:-1px;left:0;width:22px;height:2px;background:var(--red)}
.footer-col__list{display:flex;flex-direction:column;gap:9px;list-style:none;padding:0;margin:0}
.footer-col__list li a{color:#555;font-size:13px;font-weight:500;transition:var(--t);display:flex;align-items:center;gap:6px;text-decoration:none}
.footer-col__list li a .bi{font-size:11px;color:#2a2a2a;transition:color .2s}
.footer-col__list li a:hover{color:var(--gold-lt);padding-left:4px}
.footer-col__list li a:hover .bi{color:var(--gold)}
.footer-btm{max-width:var(--wrap);margin:0 auto;padding:16px 20px;border-top:1px solid #171717;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap}
.footer-btm__copy{color:#3a3a3a;font-size:12px;margin:0}
.pay-badges{display:flex;gap:7px;flex-wrap:wrap}
.pay-b{background:#141414;border:1px solid #222;border-radius:3px;padding:3px 9px;color:#444;font-size:9px;font-weight:800;letter-spacing:.08em;transition:border-color .2s,color .2s}
.pay-b:hover{border-color:#3a3a3a;color:#666}
@media(max-width:1000px){.footer-grid{grid-template-columns:1.4fr 1fr 1fr;gap:32px}.footer-col--brand{grid-column:1/-1}.foot-desc{max-width:100%}.newsletter__row{max-width:380px}}
@media(max-width:640px){.footer-grid{grid-template-columns:1fr 1fr;gap:22px;padding:28px 14px 20px}.footer-col--brand{grid-column:1/-1}.footer-btm{flex-direction:column;text-align:center;padding:12px}.site-footer{margin-top:0}}
@media(max-width:380px){.footer-grid{grid-template-columns:1fr}}

/* ── FLOATING CHAT ── */
.fc-wrap{position:fixed;bottom:86px;right:18px;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;gap:10px}
@media(min-width:768px){.fc-wrap{bottom:24px}}
.fc-main-btn{width:56px;height:56px;border-radius:50%;background:#25d366;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;box-shadow:0 4px 18px rgba(37,211,102,.45);transition:transform .25s cubic-bezier(.34,1.56,.64,1),background .2s;position:relative;z-index:2}
.fc-main-btn:hover{transform:scale(1.1);background:#1ebe5d}
.fc-main-btn.is-open{background:#444;box-shadow:0 4px 18px rgba(0,0,0,.3)}
.fc-icon-open{display:block}.fc-icon-close{display:none}
.fc-main-btn.is-open .fc-icon-open{display:none}.fc-main-btn.is-open .fc-icon-close{display:block}
.fc-notif{position:absolute;bottom:86px;right:18px;width:12px;height:12px;background:#ff3b30;border:2px solid #fff;border-radius:50%;z-index:3;animation:fc-pulse 2s ease infinite;pointer-events:none}
@media(min-width:768px){.fc-notif{bottom:24px}}
@keyframes fc-pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.25)}}
.fc-notif.hide{display:none}
.fc-sub-list{display:flex;flex-direction:column;align-items:flex-end;gap:10px;opacity:0;transform:translateY(12px) scale(.96);pointer-events:none;transition:opacity .25s ease,transform .25s cubic-bezier(.34,1.3,.64,1)}
.fc-sub-list.is-open{opacity:1;transform:translateY(0) scale(1);pointer-events:auto}
.fc-sub-list .fc-sub-item:nth-child(1){transition-delay:.03s}
.fc-sub-list .fc-sub-item:nth-child(2){transition-delay:.07s}
.fc-sub-list .fc-sub-item:nth-child(3){transition-delay:.11s}
.fc-sub-list .fc-sub-item:nth-child(4){transition-delay:.15s}
.fc-sub-item{display:flex;align-items:center;gap:10px}
.fc-label{background:#fff;color:#222;font-size:12px;font-weight:700;padding:4px 11px;border-radius:20px;box-shadow:0 2px 8px rgba(0,0,0,.18);white-space:nowrap;pointer-events:none;letter-spacing:.02em}
.fc-sub-btn{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;text-decoration:none;transition:transform .22s cubic-bezier(.34,1.56,.64,1),box-shadow .2s}
.fc-sub-btn:hover{transform:scale(1.12);color:#fff}
.fc-sub-btn--chat{background:#1DB954;box-shadow:0 3px 12px rgba(29,185,84,.4)}
.fc-sub-btn--messenger{background:#0084ff;box-shadow:0 3px 12px rgba(0,132,255,.4)}
.fc-sub-btn--whatsapp{background:#25d366;box-shadow:0 3px 12px rgba(37,211,102,.4)}
.fc-sub-btn--phone{background:#ff3b30;box-shadow:0 3px 12px rgba(255,59,48,.4)}
.fc-sub-btn--chat:hover{background:#17a349}
.fc-sub-btn--messenger:hover{background:#0073e0}
.fc-sub-btn--whatsapp:hover{background:#1ebe5d}
.fc-sub-btn--phone:hover{background:#e0342a}

/* ── LIVE CHAT MODAL ── */
.lc-overlay{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:9998;opacity:0;pointer-events:none;transition:opacity .25s}
.lc-overlay.is-open{opacity:1;pointer-events:auto}
.lc-modal{position:fixed;bottom:160px;right:18px;width:330px;max-height:520px;background:#fff;border-radius:18px;box-shadow:0 8px 40px rgba(0,0,0,.22);display:flex;flex-direction:column;overflow:hidden;z-index:9999;opacity:0;pointer-events:none;transform:translateY(20px) scale(.97);transition:opacity .28s ease,transform .28s cubic-bezier(.34,1.3,.64,1)}
.lc-modal.is-open{opacity:1;pointer-events:auto;transform:translateY(0) scale(1)}
@media(max-width:400px){.lc-modal{width:calc(100vw - 36px);bottom:150px}}
.lc-header{background:#25d366;padding:14px 16px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.lc-header__info{display:flex;align-items:center;gap:10px}
.lc-avatar{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff}
.lc-header__name{color:#fff;font-size:13px;font-weight:700;margin:0}
.lc-header__status{color:rgba(255,255,255,.85);font-size:11px;margin:2px 0 0;display:flex;align-items:center;gap:5px}
.lc-dot{width:7px;height:7px;background:#fff;border-radius:50%;display:inline-block;animation:fc-pulse 1.8s ease infinite}
.lc-close{background:rgba(255,255,255,.2);border:none;border-radius:50%;width:30px;height:30px;color:#fff;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s}
.lc-close:hover{background:rgba(255,255,255,.35)}
.lc-guest-form{flex:1;display:flex;align-items:center;justify-content:center;padding:20px;background:#f0f4f8}
.lc-gf-inner{width:100%;display:flex;flex-direction:column;gap:10px}
.lc-gf-title{font-size:14px;font-weight:700;color:#222;margin:0 0 4px;text-align:center}
.lc-gf-input{border:1px solid #ddd;border-radius:10px;padding:10px 14px;font-size:13px;font-family:'Nunito',sans-serif;outline:none;transition:border-color .2s}
.lc-gf-input:focus{border-color:#25d366}
.lc-gf-btn{background:#25d366;color:#fff;border:none;border-radius:10px;padding:11px;font-size:13px;font-weight:700;cursor:pointer;transition:background .2s;font-family:'Nunito',sans-serif}
.lc-gf-btn:hover{background:#1ebe5d}
.lc-body{flex:1;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;background:#f0f4f8}
.lc-bubble{max-width:78%;padding:10px 13px;border-radius:16px;font-size:13px;line-height:1.55}
.lc-bubble p{margin:0}
.lc-bubble--in{background:#fff;color:#222;border-bottom-left-radius:4px;align-self:flex-start;box-shadow:0 1px 4px rgba(0,0,0,.07)}
.lc-bubble--out{background:#25d366;color:#fff;border-bottom-right-radius:4px;align-self:flex-end}
.lc-time{display:block;font-size:10px;color:#aaa;margin-top:4px}
.lc-bubble--out .lc-time{color:rgba(255,255,255,.7)}
.lc-footer{padding:10px 12px;background:#fff;border-top:1px solid #eee;display:flex;gap:8px;align-items:center;flex-shrink:0}
.lc-input{flex:1;border:1px solid #ddd;border-radius:22px;padding:9px 14px;font-size:13px;outline:none;font-family:'Nunito',sans-serif;transition:border-color .2s}
.lc-input:focus{border-color:#25d366}
.lc-send{width:38px;height:38px;border-radius:50%;background:#25d366;border:none;color:#fff;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s,transform .2s}
.lc-send:hover{background:#1ebe5d;transform:scale(1.08)}
.lc-typing{display:flex;gap:5px;align-items:center;padding:8px 12px;background:#fff;border-radius:16px;border-bottom-left-radius:4px;align-self:flex-start;box-shadow:0 1px 4px rgba(0,0,0,.07);width:fit-content}
.lc-typing span{width:7px;height:7px;background:#bbb;border-radius:50%;animation:lc-bounce .9s ease infinite}
.lc-typing span:nth-child(2){animation-delay:.15s}
.lc-typing span:nth-child(3){animation-delay:.3s}
@keyframes lc-bounce{0%,80%,100%{transform:translateY(0)}40%{transform:translateY(-6px)}}
</style>

<script>
/* ═══════════════════════════════════════════════════════════════
   CHAT API URLS — url() helper ব্যবহার করা হয়েছে
   route() helper ব্যবহার করা হয়নি কারণ route name
   cache হলে "not defined" error আসে।
═══════════════════════════════════════════════════════════════ */
var _chatUrl = {
    start    : '{{ url("/chat/start") }}',
    send     : '{{ url("/chat/send") }}',
    messages : '{{ url("/chat/messages") }}',
    close    : '{{ url("/chat/close") }}'
};

/* ── State variables ── */
var _fcOpen        = false;
var _lcSessionUuid = null;
var _lcLastMsgId   = 0;
var _lcPollTimer   = null;
var _lcStarted     = false;
var _isLoggedIn    = @auth true @else false @endauth;
var _csrfToken     = '{{ csrf_token() }}';

/* ══ Floating chat toggle ══════════════════════════════════════ */
function toggleFloatChat() {
    _fcOpen = !_fcOpen;
    document.getElementById('fcMainBtn').classList.toggle('is-open', _fcOpen);
    document.getElementById('fcSubList').classList.toggle('is-open', _fcOpen);
    if (_fcOpen) {
        var notif = document.getElementById('fcNotif');
        if (notif) notif.classList.add('hide');
    }
}

document.addEventListener('click', function (e) {
    var wrap = document.getElementById('fcWrap');
    if (_fcOpen && wrap && !wrap.contains(e.target)) {
        _fcOpen = false;
        document.getElementById('fcMainBtn').classList.remove('is-open');
        document.getElementById('fcSubList').classList.remove('is-open');
    }
});

/* ══ Open / Close modal ═══════════════════════════════════════ */
function openLiveChat() {
    document.getElementById('lcModal').classList.add('is-open');
    document.getElementById('lcOverlay').classList.add('is-open');
    _fcOpen = false;
    document.getElementById('fcMainBtn').classList.remove('is-open');
    document.getElementById('fcSubList').classList.remove('is-open');

    // Logged-in user → auto-start
    if (_isLoggedIn && !_lcStarted) {
        startChat();
        return;
    }

    // Guest → check localStorage-এ পুরনো session আছে কিনা
    if (!_isLoggedIn && !_lcStarted) {
        var storedUuid = localStorage.getItem('lc_session_uuid');
        if (storedUuid) {
            _lcSessionUuid = storedUuid;
            startChat(true); // resume করো
        }
        // নতুন guest → form দেখাবে (already visible)
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

/* ══ Start / resume chat session ══════════════════════════════ */
function startChat(isResume) {
    var payload = {};

    if (!_isLoggedIn && !isResume) {
        // নতুন guest → form validate করো
        var nameEl  = document.getElementById('lcGuestName');
        var emailEl = document.getElementById('lcGuestEmail');
        var name    = nameEl  ? nameEl.value.trim()  : '';
        var email   = emailEl ? emailEl.value.trim() : '';
        if (!name)                          { _lcAlert('Please enter your name.');          return; }
        if (!email || !email.includes('@')) { _lcAlert('Please enter a valid email.');      return; }
        payload.guest_name  = name;
        payload.guest_email = email;
    }

    // guest resume → UUID পাঠাও
    if (!_isLoggedIn && isResume && _lcSessionUuid) {
        payload.session_uuid = _lcSessionUuid;
    }

    fetch(_chatUrl.start, {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json',
            'X-CSRF-TOKEN' : _csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (!d.success) {
            // Guest-এর পুরনো session expire হলে form-এ ফেরাও
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

        // Guest-এর UUID localStorage-এ সংরক্ষণ করো
        if (!_isLoggedIn) {
            localStorage.setItem('lc_session_uuid', _lcSessionUuid);
        }

        // Guest form লুকাও, body ও footer দেখাও
        var guestForm = document.getElementById('lcGuestForm');
        if (guestForm) guestForm.style.display = 'none';
        document.getElementById('lcBody').style.display   = 'flex';
        document.getElementById('lcFooter').style.display = 'flex';

        // পুরনো message render করো
        var chatBody = document.getElementById('lcBody');
        chatBody.innerHTML = '';
        if (d.messages && d.messages.length) {
            d.messages.forEach(function (m) { appendBubble(m); });
            _lcLastMsgId = d.messages[d.messages.length - 1].id;
        } else {
            // প্রথমবার → welcome message
            appendInBubble('Hello! 👋 Welcome to <strong>Shahzadi-mart</strong>. How can we help you today?');
        }

        _lcScrollBottom();
        startPolling();

        // Input-এ focus দাও
        setTimeout(function () {
            var inp = document.getElementById('lcInput');
            if (inp) inp.focus();
        }, 300);
    })
    .catch(function () {
        _lcAlert('Network error. Please check your connection and try again.');
    });
}

/* ══ Send message ══════════════════════════════════════════════ */
function sendLCMsg() {
    var input = document.getElementById('lcInput');
    if (!input) return;
    var text = input.value.trim();
    if (!text) return;
    input.value = '';

    var payload = { message: text };
    if (!_isLoggedIn && _lcSessionUuid) {
        payload.session_uuid = _lcSessionUuid;
    }

    fetch(_chatUrl.send, {
        method  : 'POST',
        headers : {
            'Content-Type' : 'application/json',
            'X-CSRF-TOKEN' : _csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
        if (d.success) {
            appendBubble(d.message);
            _lcLastMsgId = d.message.id;
            _lcScrollBottom();
        }
    })
    .catch(function () { /* silent fail — message already typed */ });
}

/* ══ Polling — প্রতি ৩ সেকেন্ডে নতুন message আনো ════════════ */
function startPolling() {
    stopPolling();
    _lcPollTimer = setInterval(pollMessages, 3000);
}

function stopPolling() {
    if (_lcPollTimer) {
        clearInterval(_lcPollTimer);
        _lcPollTimer = null;
    }
}

function pollMessages() {
    if (!_lcStarted) return;

    var url = _chatUrl.messages + '?after_id=' + _lcLastMsgId;
    if (!_isLoggedIn && _lcSessionUuid) {
        url += '&session_uuid=' + encodeURIComponent(_lcSessionUuid);
    }

    fetch(url, {
        headers: { 'X-CSRF-TOKEN': _csrfToken }
    })
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
    .catch(function () { /* silent — next poll চেষ্টা করবে */ });
}

/* ══ Bubble render helpers ════════════════════════════════════ */
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
    if (typeof toastr !== 'undefined') {
        toastr.error(msg);
    } else {
        alert(msg);
    }
}

/* ══ Newsletter subscribe ══════════════════════════════════════ */
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

/* ══ DataLayer / Pixel helpers ════════════════════════════════ */
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
