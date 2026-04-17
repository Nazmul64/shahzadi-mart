@include('frontend.pages.header')

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Authentication Container -->
<div class="auth-wrapper">
    <div class="auth-container">

        <!-- Tab Navigation -->
        <div class="auth-tabs">
            <button class="tab-btn active" id="signin-tab" onclick="switchTab('signin')">
                Sign In
            </button>
            <button class="tab-btn" id="signup-tab" onclick="switchTab('signup')">
                Sign Up
            </button>
        </div>

        <!-- Sign In Form -->
        <div class="form-container active" id="signin-form">
            <form id="signin-form-element" method="POST" action="{{ route('customer.login.submit') }}">
                @csrf

                <!-- Email Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="far fa-envelope input-icon"></i>
                        <input type="email"
                               class="text-input"
                               name="email"
                               id="signin-email"
                               placeholder="agentone@gmail.com"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               class="text-input"
                               name="password"
                               id="signin-password"
                               placeholder="Password"
                               required>
                        <button class="toggle-password-btn" onclick="togglePassword('signin-password')" type="button">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me-container">
                    <label class="remember-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <!-- Forgot Password -->
                <div class="forgot-password">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <!-- Sign In Button -->
                <button class="submit-btn" type="submit">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span>Or continue with</span>
                </div>

                <!-- Social Login Buttons -->
                <div class="social-buttons">
                    <button class="social-btn google-btn" onclick="continueWithGoogle()" type="button">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </button>
                    <button class="social-btn facebook-btn" onclick="continueWithFacebook()" type="button">
                        <i class="fab fa-facebook"></i>
                        <span>Facebook</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="form-container" id="signup-form">
            <form id="signup-form-element" method="POST" action="{{ route('customer.register.submit') }}">
                @csrf

                <!-- Full Name Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="far fa-user input-icon"></i>
                        <input type="text"
                               class="text-input"
                               name="name"
                               id="signup-name"
                               placeholder="Full Name"
                               value="{{ old('name') }}"
                               required>
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="far fa-envelope input-icon"></i>
                        <input type="email"
                               class="text-input"
                               name="email"
                               id="signup-email"
                               placeholder="Email Address"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number Input with Dropdown -->
                <div class="input-group">
                    <div class="phone-input-container">
                        <div class="country-selector" onclick="toggleCountryDropdown('signup')">
                            <span style="font-size: 20px;" id="signup-flag">🇧🇩</span>
                            <span class="country-text" id="signup-country">Bangladesh +880</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>

                        <!-- Country Dropdown -->
                        <div class="country-dropdown" id="signup-dropdown">
                            <div class="dropdown-search">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Search country..." onkeyup="filterCountries('signup', this.value)">
                            </div>
                            <div class="country-list" id="signup-country-list">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <input type="tel"
                               class="phone-input"
                               name="phone"
                               id="signup-phone"
                               placeholder="1700000002"
                               maxlength="15"
                               value="{{ old('phone') }}"
                               required>
                        <button class="copy-btn" onclick="copyPhoneNumber('signup-phone')" type="button">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               class="text-input"
                               name="password"
                               id="signup-password"
                               placeholder="Password"
                               required>
                        <button class="toggle-password-btn" onclick="togglePassword('signup-password')" type="button">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="input-group">
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               class="text-input"
                               name="password_confirmation"
                               id="confirm-password"
                               placeholder="Confirm Password"
                               required>
                        <button class="toggle-password-btn" onclick="togglePassword('confirm-password')" type="button">
                            <i class="far fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <!-- Sign Up Button -->
                <button class="submit-btn" type="submit">
                    Create Account
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span>Or continue with</span>
                </div>

                <!-- Social Login Buttons -->
                <div class="social-buttons">
                    <button class="social-btn google-btn" onclick="continueWithGoogle()" type="button">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </button>
                    <button class="social-btn facebook-btn" onclick="continueWithFacebook()" type="button">
                        <i class="fab fa-facebook"></i>
                        <span>Facebook</span>
                    </button>
                </div>

                <!-- Terms and Conditions -->
                <div class="terms-notice">
                    By creating an account, you agree to our
                    <a href="#" class="terms-link">Terms &amp; Conditions</a>
                    and
                    <a href="#" class="terms-link">Privacy Policy</a>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    /* ===== RESET ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    /* ===== AUTH WRAPPER ===== */
    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #f5f5f5;
    }

    /* ===== AUTH CONTAINER ===== */
    .auth-container {
        width: 100%;
        max-width: 500px;
        background: #ffffff;
        border-radius: 18px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(200, 16, 46, 0.08);
        border: 1px solid #f0e0e3;
    }

    /* ===== TAB NAVIGATION ===== */
    .auth-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 32px;
        background: #fdf0f2;
        padding: 6px;
        border-radius: 50px;
    }

    .tab-btn {
        flex: 1;
        padding: 12px 24px;
        background: transparent;
        border: 2px solid transparent;
        border-radius: 50px;
        color: #999;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .tab-btn.active {
        background: #ffffff;
        color: #c8102e;
        border-color: #c8102e;
        box-shadow: 0 2px 10px rgba(200, 16, 46, 0.18);
    }

    .tab-btn:hover:not(.active) {
        color: #c8102e;
        background: rgba(200, 16, 46, 0.04);
    }

    /* ===== FORM CONTAINER ===== */
    .form-container {
        display: none;
    }

    .form-container.active {
        display: block;
        animation: fadeIn 0.35s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== INPUT GROUP ===== */
    .input-group {
        margin-bottom: 18px;
        position: relative;
    }

    /* ===== ERROR MESSAGE ===== */
    .error-message {
        display: block;
        color: #c8102e;
        font-size: 12px;
        margin-top: 5px;
        margin-left: 4px;
        font-weight: 500;
    }

    /* ===== INPUT CONTAINER ===== */
    .input-container {
        display: flex;
        align-items: center;
        background: #fdf7f8;
        border: 1.5px solid #f0d8db;
        border-radius: 10px;
        padding: 13px 15px;
        transition: all 0.3s ease;
        gap: 10px;
    }

    .input-container:focus-within {
        background: #ffffff;
        border-color: #c8102e;
        box-shadow: 0 0 0 4px rgba(200, 16, 46, 0.10);
    }

    /* Error state for input */
    .input-group:has(.error-message) .input-container {
        border-color: #c8102e;
    }

    .input-group:has(.error-message) .input-container:focus-within {
        box-shadow: 0 0 0 4px rgba(200, 16, 46, 0.12);
    }

    .input-icon {
        color: #c8102e;
        font-size: 16px;
        min-width: 18px;
        opacity: 0.7;
    }

    .text-input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 14px;
        color: #333;
        font-family: inherit;
    }

    .text-input::placeholder {
        color: #bbb;
    }

    /* ===== TOGGLE PASSWORD BUTTON ===== */
    .toggle-password-btn {
        background: transparent;
        border: none;
        color: #bbb;
        font-size: 16px;
        cursor: pointer;
        padding: 2px 6px;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toggle-password-btn:hover {
        color: #c8102e;
    }

    /* ===== REMEMBER ME ===== */
    .remember-me-container {
        margin-bottom: 10px;
        margin-top: -6px;
    }

    .remember-checkbox {
        display: flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        gap: 8px;
    }

    .remember-checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #c8102e;
        cursor: pointer;
    }

    .remember-checkbox span {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }

    /* ===== FORGOT PASSWORD ===== */
    .forgot-password {
        text-align: right;
        margin-bottom: 22px;
        margin-top: -4px;
    }

    .forgot-link {
        color: #c8102e;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .forgot-link:hover {
        color: #a00d25;
        text-decoration: underline;
    }

    /* ===== PHONE INPUT CONTAINER ===== */
    .phone-input-container {
        position: relative;
        display: flex;
        align-items: center;
        background: #fdf7f8;
        border: 1.5px solid #f0d8db;
        border-radius: 10px;
        padding: 10px 14px;
        transition: all 0.3s ease;
        gap: 10px;
    }

    .phone-input-container:focus-within {
        background: #ffffff;
        border-color: #c8102e;
        box-shadow: 0 0 0 4px rgba(200, 16, 46, 0.10);
    }

    .country-selector {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        background: #ffffff;
        border: 1px solid #f0d8db;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        user-select: none;
    }

    .country-selector:hover {
        border-color: #c8102e;
        background: #fff8f9;
    }

    .country-selector.active {
        border-color: #c8102e;
    }

    .country-text {
        font-size: 13px;
        color: #333;
        font-weight: 500;
    }

    .dropdown-arrow {
        font-size: 11px;
        color: #c8102e;
        transition: transform 0.3s ease;
    }

    .country-selector.active .dropdown-arrow {
        transform: rotate(180deg);
    }

    /* ===== COUNTRY DROPDOWN ===== */
    .country-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1.5px solid #f0d8db;
        border-radius: 12px;
        box-shadow: 0 8px 28px rgba(200, 16, 46, 0.12);
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .country-dropdown.active {
        max-height: 350px;
        opacity: 1;
        visibility: visible;
    }

    .dropdown-search {
        display: flex;
        align-items: center;
        padding: 11px 15px;
        border-bottom: 1px solid #f0e0e3;
        gap: 10px;
    }

    .dropdown-search i {
        color: #c8102e;
        font-size: 14px;
        opacity: 0.7;
    }

    .dropdown-search input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 13px;
        color: #333;
        background: transparent;
        font-family: inherit;
    }

    .dropdown-search input::placeholder {
        color: #bbb;
    }

    .country-list {
        max-height: 278px;
        overflow-y: auto;
    }

    .country-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        cursor: pointer;
        transition: background 0.15s ease;
        gap: 10px;
    }

    .country-item:hover {
        background: #fff8f9;
    }

    .country-item-name {
        flex: 1;
        font-size: 13px;
        color: #333;
        font-weight: 500;
    }

    .country-item-code {
        font-size: 13px;
        color: #c8102e;
        font-weight: 500;
    }

    .phone-input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 14px;
        color: #333;
        font-family: inherit;
        min-width: 0;
    }

    .phone-input::placeholder {
        color: #bbb;
    }

    .copy-btn {
        background: transparent;
        border: none;
        color: #bbb;
        font-size: 15px;
        cursor: pointer;
        padding: 2px 6px;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
    }

    .copy-btn:hover {
        color: #c8102e;
    }

    /* ===== SUBMIT BUTTON ===== */
    .submit-btn {
        width: 100%;
        padding: 15px 24px;
        background: #c8102e;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: inherit;
        letter-spacing: 0.3px;
    }

    .submit-btn:hover {
        background: #a00d25;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(200, 16, 46, 0.35);
    }

    .submit-btn:active {
        transform: translateY(0);
        box-shadow: none;
    }

    /* ===== DIVIDER ===== */
    .divider {
        position: relative;
        text-align: center;
        margin: 26px 0;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #f0e0e3;
    }

    .divider span {
        position: relative;
        background: #ffffff;
        padding: 0 18px;
        color: #bbb;
        font-size: 13px;
        font-weight: 500;
    }

    /* ===== SOCIAL BUTTONS ===== */
    .social-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }

    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 18px;
        background: #ffffff;
        border: 1.5px solid #f0d8db;
        border-radius: 10px;
        color: #333;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: inherit;
    }

    .social-btn i {
        font-size: 18px;
    }

    .social-btn:hover {
        transform: translateY(-2px);
        border-color: #c8102e;
        box-shadow: 0 4px 12px rgba(200, 16, 46, 0.12);
    }

    .google-btn i {
        color: #4285f4;
    }

    .facebook-btn i {
        color: #1877f2;
    }

    /* ===== TERMS NOTICE ===== */
    .terms-notice {
        text-align: center;
        font-size: 12px;
        color: #999;
        line-height: 1.7;
        margin-top: 16px;
    }

    .terms-link {
        color: #c8102e;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .terms-link:hover {
        color: #a00d25;
        text-decoration: underline;
    }

    /* ===== TOAST NOTIFICATION ===== */
    .toast-notification {
        position: fixed;
        top: 24px;
        right: 24px;
        color: #ffffff;
        padding: 14px 22px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        font-size: 14px;
        font-weight: 600;
        animation: slideIn 0.35s ease;
        max-width: 300px;
        font-family: inherit;
    }

    @keyframes slideIn {
        from { transform: translateX(110%); opacity: 0; }
        to   { transform: translateX(0);   opacity: 1; }
    }

    @keyframes slideOut {
        from { transform: translateX(0);   opacity: 1; }
        to   { transform: translateX(110%); opacity: 0; }
    }

    /* ===== SCROLLBAR ===== */
    .country-list::-webkit-scrollbar {
        width: 5px;
    }

    .country-list::-webkit-scrollbar-track {
        background: #fdf0f2;
        border-radius: 10px;
    }

    .country-list::-webkit-scrollbar-thumb {
        background: #c8102e;
        border-radius: 10px;
    }

    .country-list::-webkit-scrollbar-thumb:hover {
        background: #a00d25;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 576px) {
        .auth-container {
            padding: 24px 20px;
        }

        .tab-btn {
            font-size: 14px;
            padding: 10px 16px;
        }

        .country-text {
            font-size: 12px;
        }

        .social-buttons {
            flex-direction: column;
        }

        .social-btn {
            width: 100%;
        }
    }
</style>

<script>
    {{-- Laravel session messages --}}
    @if(session('success'))
        showNotification("{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        showNotification("{{ session('error') }}", 'error');
    @endif

    @if($errors->any())
        @if($errors->has('email') || $errors->has('password'))
            switchTab('signin');
        @else
            switchTab('signup');
        @endif
    @endif

    // ===== COUNTRY DATA =====
    const countries = [
        { name: 'Afghanistan',            code: '+93',    flag: '🇦🇫' },
        { name: 'Albania',                code: '+355',   flag: '🇦🇱' },
        { name: 'Algeria',                code: '+213',   flag: '🇩🇿' },
        { name: 'Andorra',                code: '+376',   flag: '🇦🇩' },
        { name: 'Angola',                 code: '+244',   flag: '🇦🇴' },
        { name: 'Argentina',              code: '+54',    flag: '🇦🇷' },
        { name: 'Armenia',                code: '+374',   flag: '🇦🇲' },
        { name: 'Australia',              code: '+61',    flag: '🇦🇺' },
        { name: 'Austria',                code: '+43',    flag: '🇦🇹' },
        { name: 'Azerbaijan',             code: '+994',   flag: '🇦🇿' },
        { name: 'Bahamas',                code: '+1-242', flag: '🇧🇸' },
        { name: 'Bahrain',                code: '+973',   flag: '🇧🇭' },
        { name: 'Bangladesh',             code: '+880',   flag: '🇧🇩' },
        { name: 'Barbados',               code: '+1-246', flag: '🇧🇧' },
        { name: 'Belarus',                code: '+375',   flag: '🇧🇾' },
        { name: 'Belgium',                code: '+32',    flag: '🇧🇪' },
        { name: 'Belize',                 code: '+501',   flag: '🇧🇿' },
        { name: 'Benin',                  code: '+229',   flag: '🇧🇯' },
        { name: 'Bhutan',                 code: '+975',   flag: '🇧🇹' },
        { name: 'Bolivia',                code: '+591',   flag: '🇧🇴' },
        { name: 'Bosnia',                 code: '+387',   flag: '🇧🇦' },
        { name: 'Botswana',               code: '+267',   flag: '🇧🇼' },
        { name: 'Brazil',                 code: '+55',    flag: '🇧🇷' },
        { name: 'Brunei',                 code: '+673',   flag: '🇧🇳' },
        { name: 'Bulgaria',               code: '+359',   flag: '🇧🇬' },
        { name: 'Burkina Faso',           code: '+226',   flag: '🇧🇫' },
        { name: 'Burundi',                code: '+257',   flag: '🇧🇮' },
        { name: 'Cambodia',               code: '+855',   flag: '🇰🇭' },
        { name: 'Cameroon',               code: '+237',   flag: '🇨🇲' },
        { name: 'Canada',                 code: '+1',     flag: '🇨🇦' },
        { name: 'Cape Verde',             code: '+238',   flag: '🇨🇻' },
        { name: 'Chad',                   code: '+235',   flag: '🇹🇩' },
        { name: 'Chile',                  code: '+56',    flag: '🇨🇱' },
        { name: 'China',                  code: '+86',    flag: '🇨🇳' },
        { name: 'Colombia',               code: '+57',    flag: '🇨🇴' },
        { name: 'Comoros',                code: '+269',   flag: '🇰🇲' },
        { name: 'Congo',                  code: '+242',   flag: '🇨🇬' },
        { name: 'Costa Rica',             code: '+506',   flag: '🇨🇷' },
        { name: 'Croatia',                code: '+385',   flag: '🇭🇷' },
        { name: 'Cuba',                   code: '+53',    flag: '🇨🇺' },
        { name: 'Cyprus',                 code: '+357',   flag: '🇨🇾' },
        { name: 'Czech Republic',         code: '+420',   flag: '🇨🇿' },
        { name: 'Denmark',                code: '+45',    flag: '🇩🇰' },
        { name: 'Djibouti',               code: '+253',   flag: '🇩🇯' },
        { name: 'Dominica',               code: '+1-767', flag: '🇩🇲' },
        { name: 'Dominican Republic',     code: '+1-809', flag: '🇩🇴' },
        { name: 'Ecuador',                code: '+593',   flag: '🇪🇨' },
        { name: 'Egypt',                  code: '+20',    flag: '🇪🇬' },
        { name: 'El Salvador',            code: '+503',   flag: '🇸🇻' },
        { name: 'England',                code: '+44',    flag: '🏴󠁧󠁢󠁥󠁮󠁧󠁿' },
        { name: 'Eritrea',                code: '+291',   flag: '🇪🇷' },
        { name: 'Estonia',                code: '+372',   flag: '🇪🇪' },
        { name: 'Ethiopia',               code: '+251',   flag: '🇪🇹' },
        { name: 'Fiji',                   code: '+679',   flag: '🇫🇯' },
        { name: 'Finland',                code: '+358',   flag: '🇫🇮' },
        { name: 'France',                 code: '+33',    flag: '🇫🇷' },
        { name: 'Gabon',                  code: '+241',   flag: '🇬🇦' },
        { name: 'Gambia',                 code: '+220',   flag: '🇬🇲' },
        { name: 'Georgia',                code: '+995',   flag: '🇬🇪' },
        { name: 'Germany',                code: '+49',    flag: '🇩🇪' },
        { name: 'Ghana',                  code: '+233',   flag: '🇬🇭' },
        { name: 'Greece',                 code: '+30',    flag: '🇬🇷' },
        { name: 'Grenada',                code: '+1-473', flag: '🇬🇩' },
        { name: 'Guatemala',              code: '+502',   flag: '🇬🇹' },
        { name: 'Guinea',                 code: '+224',   flag: '🇬🇳' },
        { name: 'Guinea-Bissau',          code: '+245',   flag: '🇬🇼' },
        { name: 'Guyana',                 code: '+592',   flag: '🇬🇾' },
        { name: 'Haiti',                  code: '+509',   flag: '🇭🇹' },
        { name: 'Honduras',               code: '+504',   flag: '🇭🇳' },
        { name: 'Hong Kong',              code: '+852',   flag: '🇭🇰' },
        { name: 'Hungary',                code: '+36',    flag: '🇭🇺' },
        { name: 'Iceland',                code: '+354',   flag: '🇮🇸' },
        { name: 'India',                  code: '+91',    flag: '🇮🇳' },
        { name: 'Indonesia',              code: '+62',    flag: '🇮🇩' },
        { name: 'Iran',                   code: '+98',    flag: '🇮🇷' },
        { name: 'Iraq',                   code: '+964',   flag: '🇮🇶' },
        { name: 'Ireland',                code: '+353',   flag: '🇮🇪' },
        { name: 'Israel',                 code: '+972',   flag: '🇮🇱' },
        { name: 'Italy',                  code: '+39',    flag: '🇮🇹' },
        { name: 'Jamaica',                code: '+1-876', flag: '🇯🇲' },
        { name: 'Japan',                  code: '+81',    flag: '🇯🇵' },
        { name: 'Jordan',                 code: '+962',   flag: '🇯🇴' },
        { name: 'Kazakhstan',             code: '+7',     flag: '🇰🇿' },
        { name: 'Kenya',                  code: '+254',   flag: '🇰🇪' },
        { name: 'Kuwait',                 code: '+965',   flag: '🇰🇼' },
        { name: 'Kyrgyzstan',             code: '+996',   flag: '🇰🇬' },
        { name: 'Laos',                   code: '+856',   flag: '🇱🇦' },
        { name: 'Latvia',                 code: '+371',   flag: '🇱🇻' },
        { name: 'Lebanon',                code: '+961',   flag: '🇱🇧' },
        { name: 'Lesotho',                code: '+266',   flag: '🇱🇸' },
        { name: 'Liberia',                code: '+231',   flag: '🇱🇷' },
        { name: 'Libya',                  code: '+218',   flag: '🇱🇾' },
        { name: 'Lithuania',              code: '+370',   flag: '🇱🇹' },
        { name: 'Luxembourg',             code: '+352',   flag: '🇱🇺' },
        { name: 'Madagascar',             code: '+261',   flag: '🇲🇬' },
        { name: 'Malawi',                 code: '+265',   flag: '🇲🇼' },
        { name: 'Malaysia',               code: '+60',    flag: '🇲🇾' },
        { name: 'Maldives',               code: '+960',   flag: '🇲🇻' },
        { name: 'Mali',                   code: '+223',   flag: '🇲🇱' },
        { name: 'Malta',                  code: '+356',   flag: '🇲🇹' },
        { name: 'Mauritania',             code: '+222',   flag: '🇲🇷' },
        { name: 'Mauritius',              code: '+230',   flag: '🇲🇺' },
        { name: 'Mexico',                 code: '+52',    flag: '🇲🇽' },
        { name: 'Moldova',                code: '+373',   flag: '🇲🇩' },
        { name: 'Monaco',                 code: '+377',   flag: '🇲🇨' },
        { name: 'Mongolia',               code: '+976',   flag: '🇲🇳' },
        { name: 'Montenegro',             code: '+382',   flag: '🇲🇪' },
        { name: 'Morocco',                code: '+212',   flag: '🇲🇦' },
        { name: 'Mozambique',             code: '+258',   flag: '🇲🇿' },
        { name: 'Myanmar',                code: '+95',    flag: '🇲🇲' },
        { name: 'Namibia',                code: '+264',   flag: '🇳🇦' },
        { name: 'Nepal',                  code: '+977',   flag: '🇳🇵' },
        { name: 'Netherlands',            code: '+31',    flag: '🇳🇱' },
        { name: 'New Zealand',            code: '+64',    flag: '🇳🇿' },
        { name: 'Nicaragua',              code: '+505',   flag: '🇳🇮' },
        { name: 'Niger',                  code: '+227',   flag: '🇳🇪' },
        { name: 'Nigeria',                code: '+234',   flag: '🇳🇬' },
        { name: 'North Korea',            code: '+850',   flag: '🇰🇵' },
        { name: 'Norway',                 code: '+47',    flag: '🇳🇴' },
        { name: 'Oman',                   code: '+968',   flag: '🇴🇲' },
        { name: 'Pakistan',               code: '+92',    flag: '🇵🇰' },
        { name: 'Palestine',              code: '+970',   flag: '🇵🇸' },
        { name: 'Panama',                 code: '+507',   flag: '🇵🇦' },
        { name: 'Papua New Guinea',       code: '+675',   flag: '🇵🇬' },
        { name: 'Paraguay',               code: '+595',   flag: '🇵🇾' },
        { name: 'Peru',                   code: '+51',    flag: '🇵🇪' },
        { name: 'Philippines',            code: '+63',    flag: '🇵🇭' },
        { name: 'Poland',                 code: '+48',    flag: '🇵🇱' },
        { name: 'Portugal',               code: '+351',   flag: '🇵🇹' },
        { name: 'Qatar',                  code: '+974',   flag: '🇶🇦' },
        { name: 'Romania',                code: '+40',    flag: '🇷🇴' },
        { name: 'Russia',                 code: '+7',     flag: '🇷🇺' },
        { name: 'Rwanda',                 code: '+250',   flag: '🇷🇼' },
        { name: 'Saudi Arabia',           code: '+966',   flag: '🇸🇦' },
        { name: 'Senegal',                code: '+221',   flag: '🇸🇳' },
        { name: 'Serbia',                 code: '+381',   flag: '🇷🇸' },
        { name: 'Singapore',              code: '+65',    flag: '🇸🇬' },
        { name: 'Slovakia',               code: '+421',   flag: '🇸🇰' },
        { name: 'Slovenia',               code: '+386',   flag: '🇸🇮' },
        { name: 'Somalia',                code: '+252',   flag: '🇸🇴' },
        { name: 'South Africa',           code: '+27',    flag: '🇿🇦' },
        { name: 'South Korea',            code: '+82',    flag: '🇰🇷' },
        { name: 'Spain',                  code: '+34',    flag: '🇪🇸' },
        { name: 'Sri Lanka',              code: '+94',    flag: '🇱🇰' },
        { name: 'Sudan',                  code: '+249',   flag: '🇸🇩' },
        { name: 'Sweden',                 code: '+46',    flag: '🇸🇪' },
        { name: 'Switzerland',            code: '+41',    flag: '🇨🇭' },
        { name: 'Syria',                  code: '+963',   flag: '🇸🇾' },
        { name: 'Taiwan',                 code: '+886',   flag: '🇹🇼' },
        { name: 'Tajikistan',             code: '+992',   flag: '🇹🇯' },
        { name: 'Tanzania',               code: '+255',   flag: '🇹🇿' },
        { name: 'Thailand',               code: '+66',    flag: '🇹🇭' },
        { name: 'Togo',                   code: '+228',   flag: '🇹🇬' },
        { name: 'Trinidad and Tobago',    code: '+1-868', flag: '🇹🇹' },
        { name: 'Tunisia',                code: '+216',   flag: '🇹🇳' },
        { name: 'Turkey',                 code: '+90',    flag: '🇹🇷' },
        { name: 'Turkmenistan',           code: '+993',   flag: '🇹🇲' },
        { name: 'Uganda',                 code: '+256',   flag: '🇺🇬' },
        { name: 'Ukraine',                code: '+380',   flag: '🇺🇦' },
        { name: 'United Arab Emirates',   code: '+971',   flag: '🇦🇪' },
        { name: 'United Kingdom',         code: '+44',    flag: '🇬🇧' },
        { name: 'United States',          code: '+1',     flag: '🇺🇸' },
        { name: 'Uruguay',                code: '+598',   flag: '🇺🇾' },
        { name: 'Uzbekistan',             code: '+998',   flag: '🇺🇿' },
        { name: 'Venezuela',              code: '+58',    flag: '🇻🇪' },
        { name: 'Vietnam',                code: '+84',    flag: '🇻🇳' },
        { name: 'Yemen',                  code: '+967',   flag: '🇾🇪' },
        { name: 'Zambia',                 code: '+260',   flag: '🇿🇲' },
        { name: 'Zimbabwe',               code: '+263',   flag: '🇿🇼' },
    ].sort((a, b) => a.name.localeCompare(b.name));

    let selectedCountry = {
        signin: { name: 'Bangladesh', code: '+880', flag: '🇧🇩' },
        signup: { name: 'Bangladesh', code: '+880', flag: '🇧🇩' }
    };

    // ===== INITIALIZE COUNTRY LISTS =====
    function initializeCountryLists() {
        populateCountryList('signup');
    }

    function populateCountryList(formType) {
        const listElement = document.getElementById(`${formType}-country-list`);
        listElement.innerHTML = '';

        countries.forEach(country => {
            const item = document.createElement('div');
            item.className = 'country-item';
            item.innerHTML = `
                <span style="font-size: 18px;">${country.flag}</span>
                <span class="country-item-name">${country.name}</span>
                <span class="country-item-code">${country.code}</span>
            `;
            item.onclick = () => selectCountry(formType, country);
            listElement.appendChild(item);
        });
    }

    // ===== TOGGLE COUNTRY DROPDOWN =====
    function toggleCountryDropdown(formType) {
        const dropdown = document.getElementById(`${formType}-dropdown`);
        const selector = dropdown.previousElementSibling;

        document.querySelectorAll('.country-dropdown').forEach(dd => {
            if (dd.id !== `${formType}-dropdown`) dd.classList.remove('active');
        });
        document.querySelectorAll('.country-selector').forEach(sel => {
            if (!sel.nextElementSibling || sel.nextElementSibling.id !== `${formType}-dropdown`) {
                sel.classList.remove('active');
            }
        });

        dropdown.classList.toggle('active');
        selector.classList.toggle('active');
    }

    // ===== SELECT COUNTRY =====
    function selectCountry(formType, country) {
        selectedCountry[formType] = country;

        document.getElementById(`${formType}-flag`).textContent    = country.flag;
        document.getElementById(`${formType}-country`).textContent = `${country.name} ${country.code}`;

        const dropdown = document.getElementById(`${formType}-dropdown`);
        const selector = dropdown.previousElementSibling;
        dropdown.classList.remove('active');
        selector.classList.remove('active');

        showNotification(`Selected: ${country.name} ${country.code}`, 'success');
    }

    // ===== FILTER COUNTRIES =====
    function filterCountries(formType, searchValue) {
        const q = searchValue.toLowerCase();
        const listElement = document.getElementById(`${formType}-country-list`);
        listElement.innerHTML = '';

        const filtered = countries.filter(c =>
            c.name.toLowerCase().includes(q) || c.code.includes(q)
        );

        if (filtered.length === 0) {
            listElement.innerHTML = '<div style="padding:20px;text-align:center;color:#bbb;font-size:13px;">No countries found</div>';
            return;
        }

        filtered.forEach(country => {
            const item = document.createElement('div');
            item.className = 'country-item';
            item.innerHTML = `
                <span style="font-size: 18px;">${country.flag}</span>
                <span class="country-item-name">${country.name}</span>
                <span class="country-item-code">${country.code}</span>
            `;
            item.onclick = () => selectCountry(formType, country);
            listElement.appendChild(item);
        });
    }

    // ===== CLOSE DROPDOWN ON OUTSIDE CLICK =====
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.phone-input-container')) {
            document.querySelectorAll('.country-dropdown').forEach(dd => dd.classList.remove('active'));
            document.querySelectorAll('.country-selector').forEach(sel => sel.classList.remove('active'));
        }
    });

    // ===== SWITCH TABS =====
    function switchTab(tab) {
        const signinTab  = document.getElementById('signin-tab');
        const signupTab  = document.getElementById('signup-tab');
        const signinForm = document.getElementById('signin-form');
        const signupForm = document.getElementById('signup-form');

        if (tab === 'signin') {
            signinTab.classList.add('active');    signupTab.classList.remove('active');
            signinForm.classList.add('active');   signupForm.classList.remove('active');
        } else {
            signupTab.classList.add('active');    signinTab.classList.remove('active');
            signupForm.classList.add('active');   signinForm.classList.remove('active');
        }
    }

    // ===== TOGGLE PASSWORD =====
    function togglePassword(inputId) {
        const input  = document.getElementById(inputId);
        const icon   = input.parentElement.querySelector('.toggle-password-btn i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    // ===== COPY PHONE NUMBER =====
    function copyPhoneNumber(inputId) {
        const val = document.getElementById(inputId).value;
        if (val) {
            navigator.clipboard.writeText(val)
                .then(()  => showNotification('Phone number copied!', 'success'))
                .catch(()  => showNotification('Failed to copy', 'error'));
        } else {
            showNotification('No phone number to copy', 'error');
        }
    }

    // ===== SOCIAL LOGIN =====
    function continueWithGoogle() {
        showNotification('Google login coming soon...', 'info');
    }

    function continueWithFacebook() {
        showNotification('Facebook login coming soon...', 'info');
    }

    // ===== SHOW NOTIFICATION =====
    function showNotification(message, type = 'success') {
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast-notification';

        const colors = {
            success: '#c8102e',
            error:   '#333333',
            info:    '#2196f3'
        };

        toast.style.background = colors[type] || '#c8102e';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.35s ease';
            setTimeout(() => toast.remove(), 350);
        }, 3000);
    }

    // ===== INIT =====
    document.addEventListener('DOMContentLoaded', function () {
        switchTab('signin');
        initializeCountryLists();
    });
</script>

</body>
</html>
