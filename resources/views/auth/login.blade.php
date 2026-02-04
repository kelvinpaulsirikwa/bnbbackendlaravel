<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login | {{ config('bnbcompany.name', 'BnB') }}</title>
    <link rel="icon" href="{{ asset('images/static_file/applogo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="login-navbar">
        <div class="login-nav-inner">
            <a href="{{ route('website.home') }}" class="login-nav-brand">
                <img src="{{ asset('images/static_file/applogo.png') }}" alt="{{ config('bnbcompany.name') }}" class="login-nav-logo">
                <span class="login-nav-brand-text">{{ config('bnbcompany.name') }}</span>
            </a>
            <div class="login-nav-links">
                <a href="{{ route('website.home') }}" class="login-nav-link">Home</a>
                <a href="{{ route('login') }}" class="login-nav-link login-nav-link-active">Login</a>
                <a href="{{ route('website.auth.register') }}" class="login-nav-link">Register</a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <!-- Left Panel - Promotional Image -->
        <div class="promotional-panel" style="background-image: url('{{ asset('images/static_file/welcomeimage.png') }}');">
            <div class="promotional-content">
                <div class="promo-text-top">{{ config('bnbcompany.name') }}</div>
                <div class="promo-text-bottom">
                    <div class="promo-name">{{ config('bnbcompany.name') }}</div>
                    <div class="promo-description">
                        {{ config('bnbcompany.welcome_note') }}
                    </div>
                </div>
            </div>
            <div class="promotional-overlay"></div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="login-form-panel">
            <div class="login-content">
                <!-- Logo -->
                <div class="logo-container">
                    <div class="logo-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 4L20 12L28 14L20 16L16 24L12 16L4 14L12 12L16 4Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="logo-text">{{ config('bnbcompany.short') }}</span>
                </div>

                <!-- Welcome Message -->
                <div class="welcome-section">
                    <h1 class="welcome-title">Welcome Back!</h1>
                    <p class="welcome-subtitle">{{ config('bnbcompany.name') }}, {{ config('bnbcompany.motto') }}</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="useremail" class="form-label">Email</label>
                        <input
                            type="email"
                            id="useremail"
                            name="useremail"
                            class="form-input @error('useremail') is-invalid @enderror"
                            placeholder="Enter your email"
                            value="{{ old('useremail') }}"
                            required
                            autofocus
                        >
                        @error('useremail')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                        >
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot-password-link">Forgot Password</a>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit" class="btn-signin">Sign In</button>
                </form>

                <div class="text-footer mt-3">
                    <small>Don't have an account? <a href="{{ route('website.auth.register') }}">Register</a></small>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            window.location.href = window.location.href + (window.location.href.indexOf('?') > -1 ? '&' : '?') + '_t=' + new Date().getTime();
        }
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.href = window.location.href.split('?')[0] + '?_t=' + new Date().getTime();
            }
        });
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.addEventListener('popstate', function() {
                window.history.pushState(null, null, window.location.href);
                window.location.href = window.location.href.split('?')[0] + '?_t=' + new Date().getTime();
            });
        }
    </script>
</body>
</html>
