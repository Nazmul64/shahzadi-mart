<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manager Login — shahzadimart shop</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      background: #0f172a;
      overflow: hidden;
    }

    /* ── LEFT PANEL ── */
    .left-panel {
      width: 55%;
      background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      animation: float 8s ease-in-out infinite;
    }
    .blob-1 { width:400px; height:400px; background:rgba(99,102,241,0.25); top:-100px; left:-100px; animation-delay:0s; }
    .blob-2 { width:300px; height:300px; background:rgba(6,182,212,0.2); bottom:-80px; right:-80px; animation-delay:3s; }
    .blob-3 { width:200px; height:200px; background:rgba(139,92,246,0.2); top:50%; left:50%; animation-delay:5s; }

    @keyframes float {
      0%,100% { transform: translateY(0) scale(1); }
      50%      { transform: translateY(-30px) scale(1.05); }
    }

    .left-content { position: relative; z-index: 2; text-align: center; }

    .brand-logo {
      width: 70px; height: 70px;
      background: linear-gradient(135deg, #6366f1, #06b6d4);
      border-radius: 20px;
      display: flex; align-items: center; justify-content: center;
      font-size: 28px; font-weight: 800; color: #fff;
      margin: 0 auto 24px;
      box-shadow: 0 20px 40px rgba(99,102,241,0.4);
    }

    .left-content h1 { font-size: 36px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 14px; }
    .left-content h1 span {
      background: linear-gradient(135deg, #6366f1, #06b6d4);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .left-content p { font-size: 15px; color: #94a3b8; max-width: 320px; margin: 0 auto 36px; line-height: 1.7; }

    .feature-list { list-style: none; text-align: left; display: inline-block; }
    .feature-list li { display: flex; align-items: center; gap: 12px; color: #cbd5e1; font-size: 14px; margin-bottom: 14px; }
    .feature-list li .fi {
      width: 32px; height: 32px; border-radius: 8px;
      background: rgba(99,102,241,0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; color: #818cf8; flex-shrink: 0;
    }

    .dots-grid {
      position: absolute; bottom: 40px; left: 40px;
      display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; opacity: 0.15;
    }
    .dots-grid span { width: 4px; height: 4px; background: #818cf8; border-radius: 50%; display: block; }

    /* ── RIGHT PANEL ── */
    .right-panel {
      width: 45%;
      background: #fff;
      display: flex; align-items: center; justify-content: center;
      padding: 48px 56px;
    }

    .login-box { width: 100%; max-width: 380px; }

    .top-label { font-size: 12px; font-weight: 700; color: #6366f1; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px; }
    .login-box h2 { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
    .login-box .sub { font-size: 13px; color: #94a3b8; margin-bottom: 32px; }

    .alert-custom {
      border-radius: 10px; font-size: 13px; padding: 12px 16px;
      display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
    }
    .alert-err { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .alert-ok  { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    .form-group { margin-bottom: 20px; }
    .form-group label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px; display: block; }

    .input-wrap { position: relative; display: flex; align-items: center; }
    .input-wrap .i-icon {
      position: absolute; left: 14px;
      color: #94a3b8; font-size: 14px; pointer-events: none; transition: color 0.2s;
    }
    .input-wrap input {
      width: 100%;
      padding: 12px 14px 12px 42px;
      border: 1.5px solid #e5e7eb; border-radius: 10px;
      font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
      color: #1e293b; background: #f9fafb; outline: none; transition: all 0.2s;
    }
    .input-wrap input:focus {
      border-color: #6366f1; background: #fff;
      box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
    }
    .input-wrap input.is-invalid { border-color: #ef4444; background: #fff5f5; }

    .toggle-btn {
      position: absolute; right: 12px;
      background: none; border: none; color: #94a3b8;
      cursor: pointer; font-size: 14px; padding: 4px; transition: color 0.2s;
    }
    .toggle-btn:hover { color: #6366f1; }

    .btn-submit {
      width: 100%; padding: 13px;
      background: linear-gradient(135deg, #6366f1, #4f46e5);
      color: #fff; border: none; border-radius: 10px;
      font-size: 15px; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer; margin-top: 6px;
      transition: all 0.25s;
      box-shadow: 0 4px 15px rgba(99,102,241,0.35);
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-submit:hover {
      background: linear-gradient(135deg, #4f46e5, #3730a3);
      box-shadow: 0 6px 20px rgba(99,102,241,0.5);
      transform: translateY(-1px);
    }
    .btn-submit:active { transform: translateY(0); }

    .footer-note { text-align: center; margin-top: 28px; font-size: 12px; color: #94a3b8; }
    .footer-note a { color: #6366f1; text-decoration: none; font-weight: 600; }
    .footer-note a:hover { text-decoration: underline; }

    @media (max-width: 900px) {
      .left-panel { display: none; }
      .right-panel { width: 100%; padding: 40px 24px; }
    }
  </style>
</head>
<body>

  <!-- LEFT PANEL -->
  <div class="left-panel">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="left-content">
      <div class="brand-logo">G</div>
      <h1>shahzadimart shop<br/><span>Manager Panel</span></h1>
      <p>Manage your store operations, track orders, and grow your business with powerful tools.</p>
      <ul class="feature-list">
        <li><div class="fi"><i class="fas fa-chart-bar"></i></div> Real-time sales & revenue reports</li>
        <li><div class="fi"><i class="fas fa-box-open"></i></div> Full product & inventory control</li>
        <li><div class="fi"><i class="fas fa-shopping-bag"></i></div> Order tracking & management</li>
        <li><div class="fi"><i class="fas fa-users"></i></div> Customer & vendor oversight</li>
      </ul>
    </div>

    <div class="dots-grid">
      @for($i = 0; $i < 24; $i++) <span></span> @endfor
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="right-panel">
    <div class="login-box">

      <div class="top-label">Manager Access</div>
      <h2>Welcome back 👋</h2>
      <p class="sub">Sign in to your manager account to continue</p>

      @if($errors->any())
        <div class="alert-custom alert-err">
          <i class="fas fa-exclamation-circle"></i>
          {{ $errors->first() }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert-custom alert-ok">
          <i class="fas fa-check-circle"></i>
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('manager.login.submit') }}" method="POST">
        @csrf

        <div class="form-group">
          <label>Email Address</label>
          <div class="input-wrap">
            <i class="fas fa-envelope i-icon"></i>
            <input
              type="email"
              name="email"
              placeholder="manager@example.com"
              value="{{ old('email') }}"
              class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
              required
              autofocus
            />
          </div>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock i-icon"></i>
            <input
              type="password"
              name="password"
              id="passField"
              placeholder="••••••••"
              required
            />
            <button type="button" class="toggle-btn" onclick="togglePass()">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <div class="text-end mb-4">
          <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold" style="color: #6366f1;">Forgot Password?</a>
        </div>

        <button type="submit" class="btn-submit">
          <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
      </form>

      <div class="footer-note">
        &copy; {{ date('Y') }} shahzadimart shop . All rights reserved.<br/>
        <a href="#">Need help? Contact support</a>
      </div>

    </div>
  </div>

<script>
  function togglePass() {
    const f = document.getElementById('passField');
    const i = document.getElementById('eyeIcon');
    if (f.type === 'password') {
      f.type = 'text';
      i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      f.type = 'password';
      i.classList.replace('fa-eye-slash', 'fa-eye');
    }
  }
</script>

</body>
</html>
