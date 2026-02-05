<?php $__env->startSection('title', 'People in Role - ' . $role->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">People in role: <?php echo e($role->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.role-management.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Role Management
                    </a>
                </div>
            </div>

            <?php if($staff->count() > 0): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <?php if($member->profileimage): ?>
                                                    <img src="<?php echo e(asset('storage/' . $member->profileimage)); ?>"
                                                         class="rounded-circle"
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         alt="<?php echo e($member->username); ?>">
                                                <?php else: ?>
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($member->username); ?></td>
                                            <td><?php echo e($member->useremail); ?></td>
                                            <td><?php echo e($member->telephone ?? 'N/A'); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($member->status === 'active' ? 'success' : 'danger'); ?>">
                                                    <?php echo e(ucfirst($member->status)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('bnbowner.staff-management.edit', $member->id)); ?>" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Edit Staff
                                                </a>
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
                        <p class="text-muted mb-3">No one is assigned to this role yet.</p>
                        <a href="<?php echo e(route('bnbowner.staff-management.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Staff
                        </a>
                        <a href="<?php echo e(route('bnbowner.role-management.index')); ?>" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> Back to Roles
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/role-management/show.blade.php ENDPATH**/ ?>