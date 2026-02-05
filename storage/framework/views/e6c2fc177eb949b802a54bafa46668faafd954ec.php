

<?php $__env->startSection('title', 'Staff Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Staff Management - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.staff-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Staff
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

            <?php if($staff->count() > 0): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
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
                                                <?php if($member->motelRole): ?>
                                                    <span class="badge bg-primary"><?php echo e($member->motelRole->name); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo e($member->status === 'active' ? 'success' : 'danger'); ?>">
                                                    <?php echo e(ucfirst($member->status)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('bnbowner.staff-management.edit', $member->id)); ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('bnbowner.staff-management.toggle-status', $member->id)); ?>" 
                                                          class="d-inline"
                                                          onsubmit="return confirmToggleStatus(this, '<?php echo e($member->status); ?>')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-<?php echo e($member->status === 'active' ? 'warning' : 'success'); ?>">
                                                            <i class="fas fa-<?php echo e($member->status === 'active' ? 'ban' : 'check'); ?>"></i> 
                                                            <?php echo e($member->status === 'active' ? 'Block' : 'Unblock'); ?>

                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4>No Staff Members Found</h4>
                    <p class="text-muted">You haven't added any staff members to this motel yet.</p>
                    <a href="<?php echo e(route('bnbowner.staff-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Staff Member
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<script>
function confirmToggleStatus(form, status) {
    const action = status === 'active' ? 'block' : 'unblock';
    return confirm('Are you sure you want to ' + action + ' this staff member?');
}
</script>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/staff-management/index.blade.php ENDPATH**/ ?>