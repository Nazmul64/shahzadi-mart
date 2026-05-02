@include('frontend.pages.header')

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="auth-page-wrapper">
    <div class="auth-box">
        <!-- Brand/Welcome Section (Optional, can be logo) -->
        <div class="auth-header">
            <h2>Welcome to Shahzadi Mart</h2>
            <p>Join our community of shoppers today</p>
        </div>

        <!-- Tab Toggle -->
        <div class="tab-switcher">
            <button class="tab-trigger active" data-tab="signin" onclick="toggleAuthTab('signin')">Sign In</button>
            <button class="tab-trigger" data-tab="signup" onclick="toggleAuthTab('signup')">Sign Up</button>
            <div class="tab-indicator"></div>
        </div>

        <!-- Sign In Form -->
        <div class="auth-form-content active" id="signin-content">
            <form action="{{ route('customer.login.submit') }}" method="POST">
                @csrf
                <div class="form-control">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="far fa-envelope"></i>
                        <input type="email" name="email" placeholder="example@mail.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="pass-in" placeholder="••••••••" required>
                        <button type="button" class="visibility-toggle" onclick="togglePassVisibility('pass-in')">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span class="custom-check"></span>
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-pwd">Forgot Password?</a>
                </div>

                <button type="submit" class="auth-submit-btn">Sign In</button>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="auth-form-content" id="signup-content">
            <form action="{{ route('customer.register.submit') }}" method="POST">
                @csrf
                <div class="form-control">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <i class="far fa-user"></i>
                        <input type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required>
                    </div>
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="far fa-envelope"></i>
                        <input type="email" name="email" placeholder="example@mail.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label>Phone Number</label>
                    <div class="phone-container">
                        <div class="country-box">
                            <img src="https://flagcdn.com/w40/bd.png" alt="BD">
                            <span>+880</span>
                        </div>
                        <input type="tel" name="phone" placeholder="1XXX XXXXXX" value="{{ old('phone') }}" required>
                    </div>
                    @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="pass-up" placeholder="••••••••" required>
                        <button type="button" class="visibility-toggle" onclick="togglePassVisibility('pass-up')">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" id="pass-conf" placeholder="••••••••" required>
                        <button type="button" class="visibility-toggle" onclick="togglePassVisibility('pass-conf')">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn">Create Account</button>
            </form>
        </div>

        <!-- Social & Footer -->
        <div class="social-auth-section">
            <div class="separator">
                <span>Or continue with</span>
            </div>
            <div class="social-btns">
                <a href="#" class="social-link google">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                    <span>Google</span>
                </a>
                <a href="#" class="social-link facebook">
                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook">
                    <span>Facebook</span>
                </a>
            </div>
            <p class="terms-text">By joining, you agree to our <a href="#">Terms</a> & <a href="#">Privacy Policy</a></p>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #C8102E;
        --primary-light: #FFF5F6;
        --border: #E9ECEF;
        --bg-gray: #F8F9FA;
        --text-main: #2D3436;
        --text-muted: #636E72;
    }

    .auth-page-wrapper {
        min-height: 100vh;
        background: var(--bg-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    .auth-box {
        background: #FFFFFF;
        width: 100%;
        max-width: 500px;
        border-radius: 28px;
        padding: 50px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .auth-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .auth-header p {
        color: var(--text-muted);
        font-size: 15px;
    }

    /* Tab Switcher */
    .tab-switcher {
        display: flex;
        background: var(--bg-gray);
        padding: 6px;
        border-radius: 100px;
        position: relative;
        margin-bottom: 40px;
    }

    .tab-trigger {
        flex: 1;
        border: none;
        background: none;
        padding: 14px;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        z-index: 2;
        transition: color 0.3s;
    }

    .tab-trigger.active {
        color: var(--primary);
    }

    .tab-indicator {
        position: absolute;
        width: calc(50% - 6px);
        height: calc(100% - 12px);
        background: #FFFFFF;
        border: 2px solid var(--primary);
        border-radius: 100px;
        top: 6px;
        left: 6px;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 1;
        box-shadow: 0 4px 12px rgba(200, 16, 46, 0.1);
    }

    /* Form Controls */
    .form-control {
        margin-bottom: 24px;
    }

    .form-control label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 10px;
    }

    .input-wrapper, .phone-container {
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 2px solid var(--border);
        border-radius: 14px;
        padding: 0 18px;
        transition: all 0.3s;
        height: 56px;
        width: 100%;
    }

    .input-wrapper:focus-within, .phone-container:focus-within {
        border-color: var(--primary);
        background: var(--primary-light);
        box-shadow: 0 0 0 4px rgba(200, 16, 46, 0.05);
    }

    .input-wrapper i {
        color: var(--primary);
        font-size: 18px;
        margin-right: 14px;
        opacity: 0.6;
    }

    .input-wrapper input, .phone-container input {
        flex: 1;
        border: none;
        background: none;
        outline: none;
        font-size: 16px;
        font-weight: 500;
        color: var(--text-main);
        height: 100%;
        width: 100%;
    }

    .phone-container {
        padding-left: 10px;
    }

    .country-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-gray);
        padding: 8px 12px;
        border-radius: 10px;
        margin-right: 12px;
        border: 1px solid var(--border);
    }

    .country-box img {
        width: 20px;
        border-radius: 2px;
    }

    .country-box span {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
    }

    .visibility-toggle {
        background: none;
        border: none;
        color: #ADB5BD;
        cursor: pointer;
        padding: 10px;
        font-size: 18px;
    }

    /* Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
    }

    .remember-me input {
        display: none;
    }

    .custom-check {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border);
        border-radius: 6px;
        position: relative;
        transition: all 0.2s;
    }

    .remember-me input:checked + .custom-check {
        background: var(--primary);
        border-color: var(--primary);
    }

    .custom-check:after {
        content: "\f00c";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #FFF;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.2s;
    }

    .remember-me input:checked + .custom-check:after {
        transform: translate(-50%, -50%) scale(1);
    }

    .forgot-pwd {
        color: var(--primary);
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-submit-btn {
        width: 100%;
        height: 60px;
        background: var(--primary);
        color: #FFFFFF;
        border: none;
        border-radius: 16px;
        font-size: 17px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(200, 16, 46, 0.15);
    }

    .auth-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(200, 16, 46, 0.25);
        background: #A00D25;
    }

    /* Social Section */
    .separator {
        text-align: center;
        position: relative;
        margin: 35px 0;
    }

    .separator:after {
        content: "";
        position: absolute;
        width: 100%;
        height: 1px;
        background: var(--border);
        top: 50%;
        left: 0;
        z-index: 1;
    }

    .separator span {
        background: #FFFFFF;
        padding: 0 20px;
        font-size: 14px;
        color: #ADB5BD;
        position: relative;
        z-index: 2;
        font-weight: 600;
    }

    .social-btns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 30px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        height: 56px;
        border: 2px solid var(--border);
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-link:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .social-link img {
        width: 24px;
    }

    .social-link span {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
    }

    .terms-text {
        text-align: center;
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .terms-text a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }

    .error-msg {
        display: block;
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
    }

    /* Animation & Switching */
    .auth-form-content {
        display: none;
    }

    .auth-form-content.active {
        display: block;
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
        .auth-box {
            padding: 30px 20px;
        }
        .social-btns {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function toggleAuthTab(tab) {
        const triggers = document.querySelectorAll('.tab-trigger');
        const contents = document.querySelectorAll('.auth-form-content');
        const indicator = document.querySelector('.tab-indicator');

        triggers.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));

        document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
        document.getElementById(`${tab}-content`).classList.add('active');

        if (tab === 'signup') {
            indicator.style.transform = 'translateX(100%)';
        } else {
            indicator.style.transform = 'translateX(0)';
        }
    }

    function togglePassVisibility(id) {
        const input = document.getElementById(id);
        const icon = event.currentTarget.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'far fa-eye';
        } else {
            input.type = 'password';
            icon.className = 'far fa-eye-slash';
        }
    }

    window.addEventListener('load', () => {
        if (window.location.pathname.includes('register')) {
            toggleAuthTab('signup');
        }
    });
</script>

@include('frontend.pages.footer')
