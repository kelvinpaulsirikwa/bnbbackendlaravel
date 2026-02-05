<?php $__env->startSection('title', 'Role Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Role Management - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.role-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Role
                    </a>
                    <a href="<?php echo e(route('bnbowner.dashboard')); ?>" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($roles->count() > 0): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($role->id); ?></td>
                                            <td><strong><?php echo e($role->name); ?></strong></td>
                                            <td>
                                                <?php if(!empty($role->permissions)): ?>
                                                    <?php $__currentLoopData = $role->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($permissionLabels[$key])): ?>
                                                            <span class="badge bg-secondary me-1"><?php echo e($permissionLabels[$key]); ?></span>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <span class="text-muted">None</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('bnbowner.role-management.show', $role->id)); ?>" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="<?php echo e(route('bnbowner.role-management.edit', $role->id)); ?>" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="<?php echo e(route('bnbowner.role-management.destroy', $role->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center py-5">
                        <p class="text-muted mb-3">No roles yet. Create roles and assign which functions (e.g. hotel images, rooms, staff) each role can use.</p>
                        <a href="<?php echo e(route('bnbowner.role-management.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Role
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/role-management/index.blade.php ENDPATH**/ ?>