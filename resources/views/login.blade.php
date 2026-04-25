<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TAC-GH Budget Tracker | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            overflow: hidden;
            background: #f0f4ff;
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            width: 48%;
            background: linear-gradient(145deg, #1a1a6e 0%, #3b2fb5 45%, #6c5ce7 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -160px; right: -160px;
        }
        .panel-left::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -100px; left: -80px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 1;
        }
        .brand-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            backdrop-filter: blur(6px);
        }
        .brand-name { font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .brand-tagline { font-size: 12px; opacity: 0.65; font-weight: 400; margin-top: 1px; }
        .panel-left-hero {
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 0;
        }
        .hero-title {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 18px;
        }
        .hero-title span { color: #a29bfe; }
        .hero-desc {
            font-size: 15px;
            line-height: 1.7;
            opacity: 0.72;
            max-width: 380px;
        }
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 36px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            opacity: 0.85;
        }
        .feature-dot {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .panel-left-footer {
            z-index: 1;
            font-size: 12px;
            opacity: 0.45;
        }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: #f0f4ff;
        }
        .login-card { width: 100%; max-width: 420px; }
        .login-card-header { margin-bottom: 36px; }
        .login-card-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a3e;
            margin-bottom: 6px;
        }
        .login-card-header p { color: #6b7280; font-size: 14px; }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-wrap .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }
        .input-wrap input {
            width: 100%;
            height: 50px;
            padding: 0 16px 0 44px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #1a1a3e;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-wrap input:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 0 3px rgba(108,92,231,0.12);
        }
        .input-wrap input::placeholder { color: #b0b7c3; }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
        }
        .toggle-password:hover { color: #6c5ce7; }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            color: #b91c1c;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-login {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #3b2fb5, #6c5ce7);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: opacity 0.2s, transform 0.15s;
            margin-top: 8px;
        }
        .btn-login:hover { opacity: 0.92; }
        .btn-login:active { transform: scale(0.98); }

        .login-footer {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 32px;
        }

        @media (max-width: 768px) {
            .panel-left { display: none; }
            .panel-right { background: #fff; }
        }
    </style>
</head>
<body>

<div class="panel-left">
    <div class="brand">
        <div class="brand-icon"><i class="fas fa-wallet"></i></div>
        <div>
            <div class="brand-name">TAC-GH</div>
            <div class="brand-tagline">Budget Tracker System</div>
        </div>
    </div>

    <div class="panel-left-hero">
        <div class="hero-title">
            Budget Control<br>System for<br><span>TAC-GH</span>
        </div>
        <p class="hero-desc">
            Track allocations, manage departmental spending, monitor requests and generate powerful financial reports — all in one place.
        </p>
        <div class="feature-list">
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-chart-pie"></i></div>
                <span>Real-time budget utilization tracking</span>
            </div>
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-building"></i></div>
                <span>Departmental &amp; category-level reporting</span>
            </div>
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-chart-bar"></i></div>
                <span>Budget Utilisation Summary</span>
            </div>
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-file-invoice-dollar"></i></div>
                <span>Export to Excel &amp; PDF in one click</span>
            </div>
        </div>
    </div>

    <div class="panel-left-footer">
        &copy; {{ date('Y') }} TAC-GH. All rights reserved.
    </div>
</div>

<div class="panel-right">
    <div class="login-card">
        <div class="login-card-header">
            <h2>Welcome back 👋</h2>
            <p>Sign in to your account to continue</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePwd()">
                        <i class="fas fa-eye" id="pwd-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>

        <div class="login-footer">
            TAC-GH Budget Tracker &mdash; Secure Access Portal
        </div>
    </div>
</div>

<script>
    function togglePwd() {
        const input = document.getElementById('password');
        const eye   = document.getElementById('pwd-eye');
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>
