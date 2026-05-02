<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: #1a2035;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 44px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .brand-top {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 56px; height: 56px;
            background: #1a2035;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 14px;
        }

        .brand-top h5 {
            font-size: 20px;
            font-weight: 700;
            color: #1a2035;
            margin-bottom: 4px;
        }

        .brand-top p {
            font-size: 13px;
            color: #8a94a6;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #2d3a5e;
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #f8f9fc;
            border: 1px solid #e0e4ed;
            border-right: none;
            color: #8a94a6;
        }

        .form-control {
            border: 1px solid #e0e4ed;
            border-left: none;
            background: #f8f9fc;
            font-size: 14px;
            padding: 10px 14px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4e9ef5;
            background: #fff;
        }

        .form-control:focus + .input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: #4e9ef5;
            background: #fff;
        }

        .toggle-pass {
            background: #f8f9fc;
            border: 1px solid #e0e4ed;
            border-left: none;
            cursor: pointer;
            color: #8a94a6;
            padding: 0 14px;
        }

        .toggle-pass:hover { color: #1a2035; }

        .btn-login {
            width: 100%;
            background: #1a2035;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            margin-top: 8px;
            transition: background 0.2s;
        }

        .btn-login:hover { background: #4e9ef5; color: #fff; }

        .alert-danger {
            font-size: 13px;
            border-radius: 10px;
            padding: 10px 14px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #aab;
            margin-top: 24px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-top">
        <div class="brand-icon">G</div>
        <h5>Employee Login</h5>
        <p>Genius Shop — Employee Panel</p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success" style="font-size:13px; border-radius:10px;">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('emplee.login.submit') }}" method="POST">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="employee@example.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                />
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input
                    type="password"
                    name="password"
                    id="passwordField"
                    class="form-control"
                    placeholder="••••••••"
                    required
                />
                <button type="button" class="toggle-pass" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold" style="color:#4e9ef5;">Forgot Password?</a>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt me-2"></i> Login
        </button>
    </form>

    <div class="footer-text">
        &copy; {{ date('Y') }} Genius Shop. All rights reserved.
    </div>
</div>

<script>
    function togglePassword() {
        const field = document.getElementById('passwordField');
        const icon  = document.getElementById('eyeIcon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

</body>
</html>
