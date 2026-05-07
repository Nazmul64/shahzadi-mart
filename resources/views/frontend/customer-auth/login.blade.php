@include('frontend.pages.header')

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="auth-page-wrapper">
    <div class="auth-box">
        <!-- Brand/Welcome Section (Optional, can be logo) -->
        <div class="auth-header">
            <h2>Welcome to {{ $gs->site_name }}</h2>
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
            <p class="terms-text">By joining, you agree to our <a href="{{ route('terms.conditions') }}">Terms</a> & <a href="{{ route('privacy.policy') }}">Privacy Policy</a></p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/auth.css">


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
