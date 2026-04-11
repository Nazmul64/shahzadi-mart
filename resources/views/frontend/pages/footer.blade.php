{{-- resources/views/frontend/pages/footer.blade.php --}}

{{-- ── MOBILE BOTTOM NAV ── --}}
<nav class="mob-nav" id="mobNav">
    <div class="mob-nav__items">
        <a href="{{ url('/') }}" class="mob-nav__item active" id="mnHome">
            <i class="bi bi-house-fill"></i><span>Home</span>
        </a>
        <a href="#" class="mob-nav__item" onclick="toggleSidebar(); return false;" id="mnCats">
            <i class="bi bi-grid-fill"></i><span>Categories</span>
        </a>
        <a href="#" class="mob-nav__item" id="mnAlerts">
            <i class="bi bi-bell-fill"></i><span>Alerts</span>
            <span class="mob-nav__badge">2</span>
        </a>
        <a href="{{ url('cart') }}" class="mob-nav__item" id="mnCart">
            <i class="bi bi-cart3"></i><span>Cart</span>
            <span class="mob-nav__badge" id="mobCartBadge">0</span>
        </a>
        <a href="{{ url('customer/account') }}" class="mob-nav__item" id="mnAccount">
            <i class="bi bi-person-circle"></i><span>Account</span>
        </a>
    </div>
</nav>

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
                <p class="foot-desc">Your trusted marketplace for premium products across Kenya and East Africa. Quality guaranteed, delivered to your door.</p>

                <div class="newsletter">
                    <div class="newsletter__label">
                        <i class="bi bi-envelope-fill"></i> Subscribe for exclusive deals
                    </div>
                    <div class="newsletter__row">
                        <input type="email" placeholder="your@email.com"
                               class="newsletter__input" id="nlEmail">
                        <button class="newsletter__btn" onclick="subscribeNewsletter()">
                            Subscribe
                        </button>
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
                    <li><a href="#">About Shahzadi-mart</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press & Media</a></li>
                </ul>
            </div>

            {{-- Make Money --}}
            <div class="footer-col">
                <h4 class="footer-col__title">Make Money</h4>
                <ul class="footer-col__list">
                    <li><a href="#">Sell on Shahzadi-mart</a></li>
                    <li><a href="#">Affiliate Program</a></li>
                    <li><a href="#">Apply to Deliver</a></li>
                    <li><a href="#">Pickup Station</a></li>
                    <li><a href="#">Advertise With Us</a></li>
                </ul>
            </div>

            {{-- Customer Care --}}
            <div class="footer-col">
                <h4 class="footer-col__title">Customer Care</h4>
                <ul class="footer-col__list">
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Refund Policy</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Track Your Order</a></li>
                    <li><a href="#">Report a Problem</a></li>
                </ul>
            </div>

        </div>

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

{{-- ══════════════════════════════════════
     FLOATING CHAT WIDGET
══════════════════════════════════════ --}}
<div class="fc-wrap" id="fcWrap">

    {{-- Sub buttons (shown when open) --}}
    <div class="fc-sub-list" id="fcSubList">

        {{-- Live Chat --}}
        <div class="fc-sub-item">
            <span class="fc-label">Live Chat</span>
            <a href="#" class="fc-sub-btn fc-sub-btn--chat" aria-label="Live Chat" onclick="openLiveChat(); return false;">
                <i class="bi bi-chat-dots-fill"></i>
            </a>
        </div>

        {{-- Messenger --}}
        <div class="fc-sub-item">
            <span class="fc-label">Messenger</span>
            <a href="https://m.me/YourPageName" target="_blank" rel="noopener" class="fc-sub-btn fc-sub-btn--messenger" aria-label="Messenger">
                <i class="bi bi-messenger"></i>
            </a>
        </div>

        {{-- WhatsApp --}}
        <div class="fc-sub-item">
            <span class="fc-label">WhatsApp</span>
            <a href="https://wa.me/254700000000" target="_blank" rel="noopener" class="fc-sub-btn fc-sub-btn--whatsapp" aria-label="WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
        </div>

        {{-- Phone --}}
        <div class="fc-sub-item">
            <span class="fc-label">Call Us</span>
            <a href="tel:+254700000000" class="fc-sub-btn fc-sub-btn--phone" aria-label="Call Us">
                <i class="bi bi-telephone-fill"></i>
            </a>
        </div>

    </div>

    {{-- Main toggle button --}}
    <button class="fc-main-btn" id="fcMainBtn" onclick="toggleFloatChat()" aria-label="Contact us">
        <i class="bi bi-chat-dots-fill fc-icon-open"  id="fcIconOpen"></i>
        <i class="bi bi-x-lg              fc-icon-close" id="fcIconClose"></i>
    </button>

    {{-- Notification dot --}}
    <span class="fc-notif" id="fcNotif"></span>

</div>

{{-- ── Live Chat Modal ── --}}
<div class="lc-overlay" id="lcOverlay" onclick="closeLiveChat()"></div>
<div class="lc-modal" id="lcModal">
    <div class="lc-header">
        <div class="lc-header__info">
            <div class="lc-avatar"><i class="bi bi-headset"></i></div>
            <div>
                <p class="lc-header__name">Shahzadi-mart Support</p>
                <p class="lc-header__status"><span class="lc-dot"></span> Online now</p>
            </div>
        </div>
        <button class="lc-close" onclick="closeLiveChat()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="lc-body" id="lcBody">
        <div class="lc-bubble lc-bubble--in">
            <p>Hello! 👋 Welcome to <strong>Shahzadi-mart</strong>. How can we help you today?</p>
            <span class="lc-time">Just now</span>
        </div>
    </div>
    <div class="lc-footer">
        <input type="text" class="lc-input" id="lcInput" placeholder="Type a message…" onkeydown="if(event.key==='Enter') sendLCMsg()">
        <button class="lc-send" onclick="sendLCMsg()"><i class="bi bi-send-fill"></i></button>
    </div>
</div>

<style>
/* ════════════════════════════════════════════
   FOOTER
════════════════════════════════════════════ */
.site-footer {
    background: var(--dark); margin-top: 60px; position: relative;
}
.footer-accent {
    height: 3px;
    background: linear-gradient(90deg, var(--red), var(--gold), var(--red));
    background-size: 200% 100%;
    animation: grad-flow 4s ease infinite;
}
@keyframes grad-flow { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }

.footer-grid {
    max-width: var(--wrap); margin: 0 auto;
    padding: 48px 20px 32px;
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1fr;
    gap: 44px;
}

.foot-logo {
    font-family: 'Fraunces', serif;
    font-size: 24px; font-weight: 900;
    color: var(--white); letter-spacing: -.02em;
    display: inline-flex; align-items: center; margin-bottom: 12px;
}
.foot-logo em { color: var(--red); font-style: normal; }
.foot-logo__dot {
    width: 6px; height: 6px; background: var(--gold);
    border-radius: 50%; margin-left: 3px; display: inline-block;
}
.foot-desc {
    color: #555; font-size: 13px; line-height: 1.75;
    margin-bottom: 20px; max-width: 300px;
}

/* Newsletter */
.newsletter { margin-bottom: 20px; }
.newsletter__label {
    color: #555; font-size: 11px; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    margin-bottom: 9px; display: flex; align-items: center; gap: 6px;
}
.newsletter__label .bi { color: var(--gold); }
.newsletter__row {
    display: flex; border: 1px solid #222; border-radius: var(--r); overflow: hidden;
}
.newsletter__input {
    flex: 1; background: #141414; border: none;
    padding: 10px 13px; color: var(--white);
    font-family: 'Nunito', sans-serif; font-size: 13px; outline: none; min-width: 0;
}
.newsletter__input::placeholder { color: #333; }
.newsletter__btn {
    background: var(--red); color: #fff; border: none; padding: 10px 16px;
    font-family: 'Nunito', sans-serif; font-size: 11.5px; font-weight: 800;
    letter-spacing: .07em; text-transform: uppercase;
    cursor: pointer; white-space: nowrap; transition: var(--t); flex-shrink: 0;
}
.newsletter__btn:hover { background: var(--red-d); }

/* Socials */
.socials { display: flex; gap: 8px; flex-wrap: wrap; }
.soc-btn {
    width: 34px; height: 34px; background: #141414; border: 1px solid #222;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #555; font-size: 14px; transition: var(--t); text-decoration: none;
}
.soc-btn:hover {
    background: var(--red); border-color: var(--red); color: #fff;
    transform: translateY(-3px); box-shadow: 0 5px 14px rgba(200,16,46,.3);
}

/* Column */
.footer-col__title {
    color: var(--white); font-size: 9.5px; font-weight: 800;
    letter-spacing: .17em; text-transform: uppercase;
    margin-bottom: 18px; padding-bottom: 11px; border-bottom: 1px solid #1e1e1e;
    position: relative;
}
.footer-col__title::after {
    content: ''; position: absolute; bottom: -1px; left: 0;
    width: 22px; height: 2px; background: var(--red);
}
.footer-col__list { display: flex; flex-direction: column; gap: 9px; }
.footer-col__list li a {
    color: #555; font-size: 13px; font-weight: 500; transition: var(--t);
    display: flex; align-items: center; gap: 6px;
}
.footer-col__list li a::before { content: '›'; color: #2a2a2a; font-size: 16px; transition: color .2s; }
.footer-col__list li a:hover { color: var(--gold-lt); padding-left: 4px; }
.footer-col__list li a:hover::before { color: var(--gold); }

/* Bottom bar */
.footer-btm {
    max-width: var(--wrap); margin: 0 auto;
    padding: 16px 20px; border-top: 1px solid #171717;
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; flex-wrap: wrap;
}
.footer-btm__copy { color: #3a3a3a; font-size: 12px; }
.pay-badges { display: flex; gap: 7px; flex-wrap: wrap; }
.pay-b {
    background: #141414; border: 1px solid #222; border-radius: 3px;
    padding: 3px 9px; color: #444;
    font-size: 9px; font-weight: 800; letter-spacing: .08em;
    transition: border-color .2s, color .2s;
}
.pay-b:hover { border-color: #3a3a3a; color: #666; }

/* Footer responsive */
@media (max-width: 1000px) {
    .footer-grid { grid-template-columns: 1.4fr 1fr 1fr; gap: 32px; }
    .footer-col--brand { grid-column: 1 / -1; }
    .foot-desc { max-width: 100%; }
    .newsletter__row { max-width: 380px; }
}
@media (max-width: 640px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 22px; padding: 28px 14px 20px; }
    .footer-col--brand { grid-column: 1 / -1; }
    .footer-btm { flex-direction: column; text-align: center; padding: 12px; }
    .site-footer { margin-top: 0; }
}
@media (max-width: 380px) {
    .footer-grid { grid-template-columns: 1fr; }
}

/* ════════════════════════════════════════════
   FLOATING CHAT WIDGET
════════════════════════════════════════════ */
.fc-wrap {
    position: fixed;
    bottom: 86px;   /* above mobile nav */
    right: 18px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
}
@media (min-width: 768px) {
    .fc-wrap { bottom: 24px; }
}

/* ── Main toggle button ── */
.fc-main-btn {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: #25d366;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
    box-shadow: 0 4px 18px rgba(37,211,102,.45);
    transition: transform .25s cubic-bezier(.34,1.56,.64,1),
                background .2s;
    position: relative; z-index: 2;
}
.fc-main-btn:hover { transform: scale(1.1); background: #1ebe5d; }
.fc-main-btn.is-open { background: #444; box-shadow: 0 4px 18px rgba(0,0,0,.3); }

/* icon swap */
.fc-icon-open  { display: block; transition: opacity .2s, transform .2s; }
.fc-icon-close { display: none;  transition: opacity .2s, transform .2s; }
.fc-main-btn.is-open .fc-icon-open  { display: none; }
.fc-main-btn.is-open .fc-icon-close { display: block; }

/* notification dot */
.fc-notif {
    position: absolute;
    bottom: 86px; right: 18px; /* lines up with main btn top-right */
    width: 12px; height: 12px;
    background: #ff3b30; border: 2px solid #fff;
    border-radius: 50%;
    z-index: 3;
    animation: fc-pulse 2s ease infinite;
}
@media (min-width: 768px) { .fc-notif { bottom: 24px; } }
@keyframes fc-pulse {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.25); }
}
.fc-notif.hide { display: none; }

/* ── Sub buttons list ── */
.fc-sub-list {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    opacity: 0;
    transform: translateY(12px) scale(.96);
    pointer-events: none;
    transition: opacity .25s ease, transform .25s cubic-bezier(.34,1.3,.64,1);
}
.fc-sub-list.is-open {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
}

/* stagger children */
.fc-sub-list .fc-sub-item:nth-child(1) { transition-delay: .03s; }
.fc-sub-list .fc-sub-item:nth-child(2) { transition-delay: .07s; }
.fc-sub-list .fc-sub-item:nth-child(3) { transition-delay: .11s; }
.fc-sub-list .fc-sub-item:nth-child(4) { transition-delay: .15s; }

.fc-sub-item {
    display: flex; align-items: center; gap: 10px;
}

/* label chip */
.fc-label {
    background: #fff;
    color: #222;
    font-size: 12px; font-weight: 700;
    padding: 4px 11px; border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,.18);
    white-space: nowrap; pointer-events: none;
    letter-spacing: .02em;
}

/* sub icon button base */
.fc-sub-btn {
    width: 46px; height: 46px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff; text-decoration: none;
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .2s;
}
.fc-sub-btn:hover { transform: scale(1.12); color: #fff; }

/* individual colours */
.fc-sub-btn--chat      { background: #1DB954; box-shadow: 0 3px 12px rgba(29,185,84,.4); }
.fc-sub-btn--messenger { background: #0084ff; box-shadow: 0 3px 12px rgba(0,132,255,.4); }
.fc-sub-btn--whatsapp  { background: #25d366; box-shadow: 0 3px 12px rgba(37,211,102,.4); }
.fc-sub-btn--phone     { background: #ff3b30; box-shadow: 0 3px 12px rgba(255,59,48,.4); }

.fc-sub-btn--chat:hover      { background: #17a349; }
.fc-sub-btn--messenger:hover { background: #0073e0; }
.fc-sub-btn--whatsapp:hover  { background: #1ebe5d; }
.fc-sub-btn--phone:hover     { background: #e0342a; }

/* ════════════════════════════════════════════
   LIVE CHAT MODAL
════════════════════════════════════════════ */
.lc-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.4);
    z-index: 9998;
    opacity: 0; pointer-events: none;
    transition: opacity .25s;
}
.lc-overlay.is-open { opacity: 1; pointer-events: auto; }

.lc-modal {
    position: fixed;
    bottom: 160px; right: 18px;
    width: 320px; max-height: 480px;
    background: #fff; border-radius: 18px;
    box-shadow: 0 8px 40px rgba(0,0,0,.22);
    display: flex; flex-direction: column;
    overflow: hidden;
    z-index: 9999;
    opacity: 0; pointer-events: none;
    transform: translateY(20px) scale(.97);
    transition: opacity .28s ease, transform .28s cubic-bezier(.34,1.3,.64,1);
}
.lc-modal.is-open {
    opacity: 1; pointer-events: auto;
    transform: translateY(0) scale(1);
}
@media (max-width: 400px) {
    .lc-modal { width: calc(100vw - 36px); bottom: 150px; }
}

/* header */
.lc-header {
    background: #25d366;
    padding: 14px 16px;
    display: flex; align-items: center; justify-content: space-between;
}
.lc-header__info { display: flex; align-items: center; gap: 10px; }
.lc-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #fff;
}
.lc-header__name { color: #fff; font-size: 13px; font-weight: 700; margin: 0; }
.lc-header__status {
    color: rgba(255,255,255,.85); font-size: 11px; margin: 2px 0 0;
    display: flex; align-items: center; gap: 5px;
}
.lc-dot {
    width: 7px; height: 7px; background: #fff;
    border-radius: 50%; display: inline-block;
    animation: fc-pulse 1.8s ease infinite;
}
.lc-close {
    background: rgba(255,255,255,.2); border: none; border-radius: 50%;
    width: 30px; height: 30px; color: #fff; font-size: 13px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background .2s;
}
.lc-close:hover { background: rgba(255,255,255,.35); }

/* body */
.lc-body {
    flex: 1; overflow-y: auto; padding: 16px;
    display: flex; flex-direction: column; gap: 10px;
    background: #f0f4f8;
}
.lc-bubble {
    max-width: 78%;
    padding: 10px 13px;
    border-radius: 16px;
    font-size: 13px; line-height: 1.55;
}
.lc-bubble p { margin: 0; }
.lc-bubble--in {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 4px;
    align-self: flex-start;
    box-shadow: 0 1px 4px rgba(0,0,0,.07);
}
.lc-bubble--out {
    background: #25d366;
    color: #fff;
    border-bottom-right-radius: 4px;
    align-self: flex-end;
}
.lc-time {
    display: block; font-size: 10px;
    color: #aaa; margin-top: 4px;
}
.lc-bubble--out .lc-time { color: rgba(255,255,255,.7); }

/* footer */
.lc-footer {
    padding: 10px 12px;
    background: #fff;
    border-top: 1px solid #eee;
    display: flex; gap: 8px; align-items: center;
}
.lc-input {
    flex: 1; border: 1px solid #ddd; border-radius: 22px;
    padding: 9px 14px; font-size: 13px; outline: none;
    font-family: 'Nunito', sans-serif;
    transition: border-color .2s;
}
.lc-input:focus { border-color: #25d366; }
.lc-send {
    width: 38px; height: 38px; border-radius: 50%;
    background: #25d366; border: none; color: #fff;
    font-size: 15px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s, transform .2s;
}
.lc-send:hover { background: #1ebe5d; transform: scale(1.08); }
</style>

<script>
/* ── Mobile nav active ── */
document.querySelectorAll('.mob-nav__item').forEach(item => {
    item.addEventListener('click', function() {
        if (this.getAttribute('onclick')) return;
        document.querySelectorAll('.mob-nav__item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});

/* ── Newsletter ── */
function subscribeNewsletter() {
    const input = document.getElementById('nlEmail');
    if (!input) return;
    const email = input.value.trim();
    if (!email || !email.includes('@')) {
        if (typeof toastr !== 'undefined') toastr.error('Please enter a valid email address.');
        return;
    }
    if (typeof toastr !== 'undefined') toastr.success("You've subscribed to our newsletter!");
    input.value = '';
}

/* ════════════════════════════════════════════
   FLOATING CHAT WIDGET
════════════════════════════════════════════ */
let fcOpen = false;

function toggleFloatChat() {
    fcOpen = !fcOpen;
    const btn     = document.getElementById('fcMainBtn');
    const subList = document.getElementById('fcSubList');
    const notif   = document.getElementById('fcNotif');

    btn.classList.toggle('is-open', fcOpen);
    subList.classList.toggle('is-open', fcOpen);

    /* hide notification dot once opened */
    if (fcOpen && notif) notif.classList.add('hide');
}

/* close widget when clicking outside */
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('fcWrap');
    if (fcOpen && wrap && !wrap.contains(e.target)) {
        fcOpen = false;
        document.getElementById('fcMainBtn').classList.remove('is-open');
        document.getElementById('fcSubList').classList.remove('is-open');
    }
});

/* ── Live Chat ── */
function openLiveChat() {
    document.getElementById('lcModal').classList.add('is-open');
    document.getElementById('lcOverlay').classList.add('is-open');
    /* close the sub-list */
    fcOpen = false;
    document.getElementById('fcMainBtn').classList.remove('is-open');
    document.getElementById('fcSubList').classList.remove('is-open');
    setTimeout(() => document.getElementById('lcInput').focus(), 300);
}

function closeLiveChat() {
    document.getElementById('lcModal').classList.remove('is-open');
    document.getElementById('lcOverlay').classList.remove('is-open');
}

function sendLCMsg() {
    const input = document.getElementById('lcInput');
    const body  = document.getElementById('lcBody');
    const text  = input.value.trim();
    if (!text) return;

    /* user bubble */
    const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const userBubble = document.createElement('div');
    userBubble.className = 'lc-bubble lc-bubble--out';
    userBubble.innerHTML = `<p>${escapeHtml(text)}</p><span class="lc-time">${now}</span>`;
    body.appendChild(userBubble);

    input.value = '';
    body.scrollTop = body.scrollHeight;

    /* auto reply after 1.2s */
    setTimeout(() => {
        const rep = document.createElement('div');
        rep.className = 'lc-bubble lc-bubble--in';
        rep.innerHTML = `<p>Thanks for reaching out! Our team will get back to you shortly. 😊</p><span class="lc-time">Just now</span>`;
        body.appendChild(rep);
        body.scrollTop = body.scrollHeight;
    }, 1200);
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>

</body>
</html>
