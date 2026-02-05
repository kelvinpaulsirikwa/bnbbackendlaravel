<?php $__env->startSection('title', 'Create Role'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Create Role - <?php echo e($motel->name); ?></h1>
                <a href="<?php echo e(route('bnbowner.role-management.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-tag"></i> Role Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('bnbowner.role-management.store')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="mb-4">
                                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="e.g. Receptionist, Security" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Permissions – choose which functions this role can use</label>
                                    <div class="border rounded p-3 bg-light">
                                        <?php $__currentLoopData = $permissionLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo e($key); ?>" id="perm_<?php echo e($key); ?>" <?php echo e(in_array($key, old('permissions', [])) ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="perm_<?php echo e($key); ?>"><?php echo e($label); ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('bnbowner.role-management.index')); ?>" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/role-management/create.blade.php ENDPATH**/ ?>