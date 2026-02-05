<?php $__env->startSection('title', 'Edit Staff Member'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Staff Member - <?php echo e($staff->username); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.staff-management.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Staff
                    </a>
                </div>
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

            <?php if(session('reset_password')): ?>
                <div class="alert alert-info">
                    <strong>New Password:</strong> <?php echo e(session('reset_password')); ?>

                    <p class="mb-0 small text-muted">Share this password securely with the staff member. They should change it after logging in.</p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-edit"></i> Staff Member Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-4">
                                <form method="POST" action="<?php echo e(route('bnbowner.staff-management.reset-password', $staff->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-sync-alt"></i> Reset Password
                                    </button>
                                </form>
                            </div>
                            <form method="POST" action="<?php echo e(route('bnbowner.staff-management.update', $staff->id)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="<?php echo e(old('username', $staff->username)); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="useremail" name="useremail" 
                                                   value="<?php echo e(old('useremail', $staff->useremail)); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" 
                                                   value="<?php echo e(old('telephone', $staff->telephone)); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="motel_role_id" class="form-label">Role (from Role Management)</label>
                                            <select class="form-select" id="motel_role_id" name="motel_role_id">
                                                <option value="">— No role —</option>
                                                <?php $__currentLoopData = $motelRoles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($r->id); ?>" <?php echo e(old('motel_role_id', $staff->motel_role_id) == $r->id ? 'selected' : ''); ?>><?php echo e($r->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if(empty($motelRoles) || $motelRoles->isEmpty()): ?>
                                                <small class="text-muted">Create roles in <a href="<?php echo e(route('bnbowner.role-management.index')); ?>">Role Management</a> first.</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="profileimage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="profileimage" name="profileimage" 
                                           accept="image/*">
                                    <?php if($staff->profileimage): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset('storage/' . $staff->profileimage)); ?>" 
                                                 alt="Current Image" 
                                                 style="max-width: 100px; max-height: 100px; object-fit: cover;"
                                                 class="img-thumbnail rounded-circle">
                                            <p class="text-muted small mt-1">Current image</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?php echo e(route('bnbowner.staff-management.index')); ?>" class="btn btn-secondary me-md-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Staff Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if(isset($ownedMotels) && $ownedMotels->isNotEmpty()): ?>
                    <div class="card mt-4 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-exchange-alt"></i> Transfer to another BNB
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Move this staff member to one of your other properties. You will need to enter your account password to confirm.</p>
                            <form method="POST" action="<?php echo e(route('bnbowner.staff-management.transfer', $staff->id)); ?>" class="transfer-form">
                                <?php echo csrf_field(); ?>
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label for="target_motel_id" class="form-label">Transfer to BNB</label>
                                        <select class="form-select" id="target_motel_id" name="target_motel_id" required>
                                            <option value="">— Select a BNB —</option>
                                            <?php $__currentLoopData = $ownedMotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="transfer_password" class="form-label">Your account password</label>
                                        <input type="password" class="form-control" id="transfer_password" name="password" required placeholder="Enter your login password" autocomplete="current-password">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-exchange-alt"></i> Transfer Staff
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="card mt-4 border-secondary">
                        <div class="card-body text-muted">
                            <i class="fas fa-info-circle"></i> Transfer to another BNB is available when you own more than one property.
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/staff-management/edit.blade.php ENDPATH**/ ?>