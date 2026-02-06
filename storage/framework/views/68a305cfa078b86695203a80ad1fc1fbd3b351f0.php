<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800"><?php echo e($term->title); ?></h1>
                        <p class="text-muted mb-0">
                            <?php if($term->is_active): ?><span class="badge bg-success">Active</span><?php else: ?><span class="badge bg-secondary">Inactive</span><?php endif; ?>
                            · Updated <?php echo e($term->updated_at->format('M d, Y')); ?>

                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('adminpages.terms-of-service.edit', $term->id)); ?>" class="btn btn-outline-warning">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="<?php echo e(route('adminpages.terms-of-service.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="content prose">
                    <?php echo nl2br(e($term->content)); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/terms-of-service/show.blade.php ENDPATH**/ ?>