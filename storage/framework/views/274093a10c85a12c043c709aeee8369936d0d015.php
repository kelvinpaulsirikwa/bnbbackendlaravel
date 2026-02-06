
<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $role = session('auth_user_role');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> BnB | Owner <?php echo e($pageTitle ?? 'Dashboard'); ?></title>
    <link rel="icon" href="<?php echo e(asset('/images/static_files/heslblogos.png')); ?>" type="image/png">

    <!-- Bootstrap CSS (Online) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

    <!-- Boxicons -->
    <link rel="stylesheet" href="<?php echo e(asset('css/adminsidebar.css')); ?>">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Optional Bootstrap JS (requires Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/adminsidebar.js')); ?>"></script>
</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">

    <?php echo $__env->make('bnbowner.layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('bnbowner.layouts.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <div class="main-content" style="flex:1 0 auto;">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo $__env->make('bnbowner.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/layouts/vendorin_owner.blade.php ENDPATH**/ ?>