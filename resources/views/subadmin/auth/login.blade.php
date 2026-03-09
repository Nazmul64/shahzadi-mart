<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sub Admin Login — shahzadimart Shop</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Sora',sans-serif; min-height:100vh; display:flex; background:#0d1b2a; overflow:hidden; }
    .left { width:52%; position:relative; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:60px 50px; background:linear-gradient(145deg,#0d1b2a 0%,#1a0a0f 55%,#0d1b2a 100%); overflow:hidden; }
    .blob { position:absolute; border-radius:50%; filter:blur(90px); pointer-events:none; animation:blob-float 9s ease-in-out infinite; }
    .b1 { width:380px;height:380px;background:rgba(230,57,70,0.22);top:-80px;left:-80px;animation-delay:0s; }
    .b2 { width:280px;height:280px;background:rgba(244,162,97,0.18);bottom:-60px;right:-40px;animation-delay:3.5s; }
    .b3 { width:200px;height:200px;background:rgba(230,57,70,0.12);top:55%;left:55%;animation-delay:6s; }
    @keyframes blob-float { 0%,100% { transform:translateY(0) scale(1); } 50% { transform:translateY(-28px) scale(1.06); } }
    .grid-dots { position:absolute; bottom:36px; right:36px; display:grid; grid-template-columns:repeat(7,1fr); gap:9px; opacity:0.12; }
    .grid-dots span { width:3px;height:3px;background:#e63946;border-radius:50%;display:block; }
    .deco-ring { position:absolute; top:-60px; right:-60px; width:280px;height:280px;border-radius:50%; border:40px solid rgba(230,57,70,0.08); }
    .deco-ring2 { position:absolute; bottom:-40px; left:-40px; width:180px;height:180px;border-radius:50%; border:28px solid rgba(244,162,97,0.07); }
    .left-content { position:relative;z-index:2;text-align:center; }
    .logo-box { width:68px;height:68px;border-radius:18px; background:linear-gradient(135deg,#e63946,#f4a261); display:flex;align-items:center;justify-content:center; font-size:26px;font-weight:800;color:#fff; margin:0 auto 22px; box-shadow:0 18px 40px rgba(230,57,70,0.45); }
    .left-content h1 { font-size:34px;font-weight:800;color:#fff; line-height:1.25;margin-bottom:12px; }
    .left-content h1 span { background:linear-gradient(135deg,#e63946,#f4a261); -webkit-background-clip:text;-webkit-text-fill-color:transparent; }
    .left-content p { font-size:14px;color:#8896a5; max-width:310px;margin:0 auto 34px;line-height:1.75; }
    .feat-list { list-style:none;text-align:left;display:inline-block; }
    .feat-list li { display:flex;align-items:center;gap:12px; color:#cbd5e1;font-size:13.5px;margin-bottom:13px; }
    .feat-list li .fi { width:32px;height:32px;border-radius:8px; background:rgba(230,57,70,0.18); display:flex;align-items:center;justify-content:center; font-size:13px;color:#f87171;flex-shrink:0; }
    .access-badge { display:inline-flex;align-items:center;gap:8px; background:rgba(230,57,70,0.15); border:1px solid rgba(230,57,70,0.3); color:#f87171;font-size:12px;font-weight:600; padding:6px 16px;border-radius:20px;margin-bottom:28px; letter-spacing:0.5px; }
    .right { width:48%; background:#fff; display:flex;align-items:center;justify-content:center; padding:48px 52px; position:relative; }
    .right::before { content:'';position:absolute;top:0;right:0; width:120px;height:120px; background:linear-gradient(135deg,rgba(230,57,70,0.06),transparent); border-bottom-left-radius:120px; }
    .form-box { width:100%;max-width:370px; }
    .form-box .tag { font-size:11.5px;font-weight:700;color:#e63946; letter-spacing:2px;text-transform:uppercase;margin-bottom:8px; }
    .form-box h2 { font-size:26px;font-weight:800;color:#0d1b2a;margin-bottom:5px; }
    .form-box .sub { font-size:13px;color:#8896a5;margin-bottom:30px; }
    .my-alert { border-radius:10px;font-size:13px;padding:11px 15px; display:flex;align-items:center;gap:9px;margin-bottom:18px; }
    .al-err { background:#fef2f2;color:#991b1b;border:1px solid #fecaca; }
    .al-ok  { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
    .field { margin-bottom:18px; }
    .field label { font-size:12.5px;font-weight:600;color:#374151; margin-bottom:7px;display:block; }
    .field-wrap { position:relative;display:flex;align-items:center; }
    .field-wrap .ficon { position:absolute;left:13px; color:#9ca3af;font-size:13px;pointer-events:none;transition:color 0.2s; }
    .field-wrap input { width:100%; padding:11px 13px 11px 40px; border:1.5px solid #e5e7eb;border-radius:10px; font-size:13.5px;font-family:'Sora',sans-serif; color:#1a202c;background:#f9fafb;outline:none; transition:all 0.2s; }
    .field-wrap input:focus { border-color:#e63946;background:#fff; box-shadow:0 0 0 4px rgba(230,57,70,0.09); }
    .field-wrap input.err { border-color:#ef4444;background:#fff5f5; }
    .eye-btn { position:absolute;right:12px; background:none;border:none;color:#9ca3af; cursor:pointer;font-size:13px;padding:4px;transition:color 0.2s; }
    .eye-btn:hover { color:#e63946; }
    .btn-go { width:100%;padding:13px;margin-top:4px; background:linear-gradient(135deg,#e63946,#c1172a); color:#fff;border:none;border-radius:10px; font-size:14.5px;font-weight:700;font-family:'Sora',sans-serif; cursor:pointer;transition:all 0.25s; box-shadow:0 5px 18px rgba(230,57,70,0.38); display:flex;align-items:center;justify-content:center;gap:8px; }
    .btn-go:hover { background:linear-gradient(135deg,#c1172a,#9b0e1e); box-shadow:0 8px 24px rgba(230,57,70,0.5); transform:translateY(-1px); }
    .btn-go:active { transform:translateY(0); }
    .divider { display:flex;align-items:center;gap:10px; margin:20px 0;color:#d1d5db;font-size:12px; }
    .divider::before,.divider::after { content:'';flex:1;height:1px;background:#e5e7eb; }
    .info-box { background:#fff8f8;border:1px solid #fecaca;border-radius:10px; padding:12px 14px;display:flex;align-items:flex-start;gap:10px; }
    .info-box i { color:#e63946;font-size:14px;margin-top:1px;flex-shrink:0; }
    .info-box p { font-size:12px;color:#7f1d1d;line-height:1.5;margin:0; }
    .foot { text-align:center;margin-top:24px; font-size:12px;color:#9ca3af; }
    .foot a { color:#e63946;text-decoration:none;font-weight:600; }
    .foot a:hover { text-decoration:underline; }
    @media(max-width:860px) { .left { display:none; } .right { width:100%;padding:40px 22px; } }
  </style>
</head>
<body>

  <!-- LEFT -->
  <div class="left">
    <div class="blob b1"></div>
    <div class="blob b2"></div>
    <div class="blob b3"></div>
    <div class="deco-ring"></div>
    <div class="deco-ring2"></div>

    <div class="left-content">
      <div class="logo-box">G</div>
      <div class="access-badge"><i class="fas fa-shield-alt"></i> Sub Admin Access</div>
      <h1>Shahzadimart Shop<br/><span>Sub Admin Panel</span></h1>
      <p>Manage orders, products, customers and vendors with restricted administrative privileges.</p>
      <ul class="feat-list">
        <li><div class="fi"><i class="fas fa-shopping-bag"></i></div> Order & product management</li>
        <li><div class="fi"><i class="fas fa-users"></i></div> Customer & vendor oversight</li>
        <li><div class="fi"><i class="fas fa-chart-bar"></i></div> Sales reports & analytics</li>
        <li><div class="fi"><i class="fas fa-tags"></i></div> Coupon & review control</li>
      </ul>
    </div>

    <div class="grid-dots">
      @for($i = 0; $i < 28; $i++)
        <span></span>
      @endfor
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right">
    <div class="form-box">

      <div class="tag">Sub Admin Portal</div>
      <h2>Sign In 🔐</h2>
      <p class="sub">Enter your credentials to access the sub admin panel</p>

      {{-- Error Message --}}
      @if($errors->any())
        <div class="my-alert al-err">
          <i class="fas fa-exclamation-circle"></i>
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Success Message --}}
      @if(session('success'))
        <div class="my-alert al-ok">
          <i class="fas fa-check-circle"></i>
          {{ session('success') }}
        </div>
      @endif

      {{-- Error Session --}}
      @if(session('error'))
        <div class="my-alert al-err">
          <i class="fas fa-exclamation-circle"></i>
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('subadmin.login.submit') }}" method="POST" novalidate>
        @csrf

        {{-- Email --}}
        <div class="field">
          <label for="email">Email Address</label>
          <div class="field-wrap">
            <i class="fas fa-envelope ficon"></i>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="subadmin@example.com"
              value="{{ old('email') }}"
              class="{{ $errors->has('email') ? 'err' : '' }}"
              required
              autofocus
            />
          </div>
        </div>

        {{-- Password --}}
        <div class="field">
          <label for="passField">Password</label>
          <div class="field-wrap">
            <i class="fas fa-lock ficon"></i>
            <input
              type="password"
              id="passField"
              name="password"
              placeholder="••••••••"
              class="{{ $errors->has('password') ? 'err' : '' }}"
              required
            />
            <button type="button" class="eye-btn" onclick="togglePass()">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-go">
          <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
      </form>

      <div class="divider">account info</div>

      <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <p>Sub Admin accounts are created by the Super Admin or Admin. Contact your administrator if you cannot login.</p>
      </div>

      <div class="foot">
        &copy; {{ date('Y') }} Genius Shop. All rights reserved.<br/>
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
