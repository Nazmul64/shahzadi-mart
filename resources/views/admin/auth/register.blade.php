<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .btn-register { width: 100%; background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: #fff; border: none; border-radius: 10px; padding: 12px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 6px; transition: opacity 0.2s; }
        .btn-register:hover { opacity: 0.9; color: #fff; }
        .auth-footer { text-align: center; font-size: 13px; color: #64748b; margin-top: 20px; }
        .auth-footer a { color: #2d6a9f; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo"><i class="bi bi-person-plus"></i></div>
    <div class="auth-title">Create Account</div>
    <div class="auth-sub">নতুন অ্যাকাউন্ট তৈরি করুন</div>

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="আপনার নাম" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="you@example.com" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="কমপক্ষে ৬ অক্ষর" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="পাসওয়ার্ড আবার দিন" required>
        </div>
        <button type="submit" class="btn-register">
            <i class="bi bi-person-check me-2"></i>Register
        </button>
    </form>
    <div class="auth-footer">
        ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">Login করুন</a>
    </div>
</div>
</body>
</html>
