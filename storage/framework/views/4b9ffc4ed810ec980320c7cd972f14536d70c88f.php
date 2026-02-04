

<?php $__env->startSection('title', __('website.contact.meta_title')); ?>
<?php $__env->startSection('meta_description', __('website.contact.meta_description')); ?>


<?php $__env->startSection('content'); ?>
  
<?php echo $__env->make('websitepages.components.contact-section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('websitepages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/contact.blade.php ENDPATH**/ ?>