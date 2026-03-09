<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #f0f4f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 40px 36px; width: 100%; max-width: 420px; }
        .auth-logo { width: 52px; height: 52px; background: linear-gradient(135deg, #1e3a5f, #2d6a9f); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; margin: 0 auto 18px; }
        .auth-title { font-size: 22px; font-weight: 700; color: #1e293b; text-align: center; margin-bottom: 4px; }
        .auth-sub { font-size: 13px; color: #64748b; text-align: center; margin-bottom: 28px; }
        .form-label { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #475569; }
        .form-control { border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 11px 14px; font-size: 14px; background: #f8fafc; }
        .form-control:focus { border-color: #2d6a9f; box-shadow: 0 0 0 3px rgba(45,106,159,0.10); background: #fff; }
        .btn-login { width: 100%; background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: #fff; border: none; border-radius: 10px; padding: 12px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 6px; transition: opacity 0.2s; }
        .btn-login:hover { opacity: 0.9; color: #fff; }
        .auth-footer { text-align: center; font-size: 13px; color: #64748b; margin-top: 20px; }
        .auth-footer a { color: #2d6a9f; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo"><i class="bi bi-shield-lock"></i></div>
    <div class="auth-title">Welcome Back</div>
    <div class="auth-sub">আপনার অ্যাকাউন্টে লগইন করুন</div>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-3" style="font-size:13px;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:13px;">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember" style="font-size:13px;">Remember me</label>
        </div>
        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
    </form>
    <div class="auth-footer">
        অ্যাকাউন্ট নেই? <a href="{{ route('register') }}">Register করুন</a>
    </div>
</div>
</body>
</html>
