<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SISTECH College Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; min-height: 100vh; display: flex; background: #F1F5F9; }

        .login-left {
            flex: 1; background: linear-gradient(135deg, #0066CC 0%, #004C99 50%, #003366 100%);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            padding: 60px; color: white; position: relative; overflow: hidden;
        }
        .login-left::before {
            content: ''; position: absolute; top: -50%; right: -50%; width: 100%; height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }
        .login-left::after {
            content: ''; position: absolute; bottom: -30%; left: -30%; width: 80%; height: 80%;
            background: radial-gradient(circle, rgba(0,176,80,0.2) 0%, transparent 70%);
        }
        .login-left .brand { text-align: center; position: relative; z-index: 1; }
        .login-left .brand .logo {
            width: 100px; height: 100px; background: white; border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px; font-size: 14px; font-weight: 800; color: #0066CC;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .login-left .brand h1 { font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .login-left .brand p { font-size: 16px; opacity: 0.9; font-weight: 300; }

        .login-features { position: relative; z-index: 1; margin-top: 60px; }
        .login-features .feature {
            display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
            background: rgba(255,255,255,0.1); padding: 16px 20px; border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        .login-features .feature i { font-size: 20px; width: 24px; text-align: center; color: #00B050; }
        .login-features .feature span { font-size: 14px; }

        .login-right {
            flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px;
        }

        .login-form {
            width: 100%; max-width: 420px; background: white; border-radius: 16px;
            padding: 40px; box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .login-form h2 { font-weight: 700; margin-bottom: 4px; font-size: 24px; }
        .login-form .subtitle { color: #64748B; font-size: 14px; margin-bottom: 32px; }

        .form-floating { margin-bottom: 20px; }
        .form-floating .form-control {
            border-radius: 10px; border: 1px solid #E2E8F0; padding: 14px 12px; height: 52px;
            font-size: 14px;
        }
        .form-floating .form-control:focus { border-color: #0066CC; box-shadow: 0 0 0 3px rgba(0,102,204,0.1); }

        .btn-login {
            width: 100%; padding: 12px; background: #0066CC; color: white; border: none;
            border-radius: 10px; font-weight: 600; font-size: 15px; margin-top: 8px;
            transition: all 0.2s;
        }
        .btn-login:hover { background: #004C99; color: white; transform: translateY(-1px); }

        .form-check-label { font-size: 13px; color: #64748B; }

        @media (max-width: 768px) {
            .login-left { display: none; }
            body { justify-content: center; }
            .login-right { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="login-left">
        <div class="brand">
            <img src="{{ asset('images/badge.png') }}" alt="SISTECH Badge" style="width: 64px; height: 64px; border-radius: 14px; object-fit: cover;">
            <h1>SISTECH</h1>
            <p>College Management System</p>
            <p style="font-style: italic; opacity: 0.8; font-size: 14px; margin-top: 4px;">"Connecting People to Technology"</p>
        </div>
        <div class="login-features">
            <div class="feature">
                <i class="fas fa-shield-alt"></i>
                <span>Secure & Role-Based Access Control</span>
            </div>
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <span>Real-Time Analytics & Reports</span>
            </div>
            <div class="feature">
                <i class="fas fa-mobile-alt"></i>
                <span>Fully Responsive on All Devices</span>
            </div>
            <div class="feature">
                <i class="fas fa-bolt"></i>
                <span>Fast & Modern Interface</span>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="login-form">
            <h2>Welcome Back</h2>
            <p class="subtitle">Sign in to your account to continue</p>

            @if($errors->any())
            <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                </div>

                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="text-center mt-4">
                <small style="color: #94A3B8;">&copy; {{ date('Y') }} SISTECH. All rights reserved.</small>
            </div>
        </div>
    </div>
</body>
</html>
