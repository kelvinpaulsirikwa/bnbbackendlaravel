
<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $role = session('auth_user_role'); // Accessing role from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> BnB | Choose <?php echo e($pageTitle ?? 'Dashboard'); ?></title>
    <link rel="icon" href="<?php echo e(asset('/images/static_file/applogo.png')); ?>" type="image/png">

    <!-- Bootstrap CSS (Online) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   
    <!-- Optional Bootstrap JS (requires Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="<?php echo e(asset('js/adminsidebar.js')); ?>"></script>
</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">


    
    <div class="main-content" style="flex:1 0 auto;">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo $__env->make('adminpages.layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/layouts/choose.blade.php ENDPATH**/ ?>