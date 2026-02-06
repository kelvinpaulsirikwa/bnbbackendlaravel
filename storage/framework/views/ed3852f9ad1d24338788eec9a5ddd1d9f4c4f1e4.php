<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Create Terms of Service</h1>
                        <p class="text-muted mb-0">Add new terms of service</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.terms-of-service.index')); ?>" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0"><i class="bx bx-plus-circle me-2"></i>Terms of Service</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('adminpages.terms-of-service.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title"
                                           value="<?php echo e(old('title')); ?>" placeholder="e.g. Terms of Service (2026)" required>
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="content" name="content" rows="12" required><?php echo e(old('content')); ?></textarea>
                                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="is_active">Set as active (show this version to users)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('adminpages.terms-of-service.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/terms-of-service/create.blade.php ENDPATH**/ ?>