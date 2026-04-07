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
</script>

</body>
</html>
