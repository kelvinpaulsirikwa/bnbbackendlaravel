<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login | <?php echo e(config('bnbcompany.name', 'BnB')); ?></title>
    <link rel="icon" href="<?php echo e(asset('images/static_file/applogo.png')); ?>" type="image/png">
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Navbar -->
    <nav class="login-navbar">
        <div class="login-nav-inner">
            <a href="<?php echo e(route('website.home')); ?>" class="login-nav-brand">
                <img src="<?php echo e(asset('images/static_file/applogo.png')); ?>" alt="<?php echo e(config('bnbcompany.name')); ?>" class="login-nav-logo">
                <span class="login-nav-brand-text"><?php echo e(config('bnbcompany.name')); ?></span>
            </a>
            <div class="login-nav-links">
                <a href="<?php echo e(route('website.home')); ?>" class="login-nav-link">Home</a>
                <a href="<?php echo e(route('login')); ?>" class="login-nav-link login-nav-link-active">Login</a>
                <a href="<?php echo e(route('website.auth.register')); ?>" class="login-nav-link">Register</a>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <!-- Left Panel - Promotional Image -->
        <div class="promotional-panel" style="background-image: url('<?php echo e(asset('images/static_file/welcomeimage.png')); ?>');">
            <div class="promotional-content">
                <div class="promo-text-top"><?php echo e(config('bnbcompany.name')); ?></div>
                <div class="promo-text-bottom">
                    <div class="promo-name"><?php echo e(config('bnbcompany.name')); ?></div>
                    <div class="promo-description">
                        <?php echo e(config('bnbcompany.welcome_note')); ?>

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
                    <span class="logo-text"><?php echo e(config('bnbcompany.short')); ?></span>
                </div>

                <!-- Welcome Message -->
                <div class="welcome-section">
                    <h1 class="welcome-title">Welcome Back!</h1>
                    <p class="welcome-subtitle"><?php echo e(config('bnbcompany.name')); ?>, <?php echo e(config('bnbcompany.motto')); ?></p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="<?php echo e(route('login.submit')); ?>" class="login-form">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session('status')): ?>
                        <div class="alert alert-info">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="useremail" class="form-label">Email</label>
                        <input
                            type="email"
                            id="useremail"
                            name="useremail"
                            class="form-input <?php $__errorArgs = ['useremail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Enter your email"
                            value="<?php echo e(old('useremail')); ?>"
                            required
                            autofocus
                        >
                        <?php $__errorArgs = ['useremail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Enter your password"
                            required
                        >
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <small>Don't have an account? <a href="<?php echo e(route('website.auth.register')); ?>">Register</a></small>
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
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/auth/login.blade.php ENDPATH**/ ?>