<?php $__env->startSection('title', 'My activity'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
        <div>
            <h1 class="h2 mb-1">My activity</h1>
            <p class="text-muted mb-0">Here’s a friendly summary of what you’ve been up to — what you added, changed, or removed.</p>
        </div>
        <a href="<?php echo e(route('bnbowner.dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Back to main dashboard
        </a>
    </div>

    <!-- My contribution counters -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Total actions</h6>
                    <h2 class="mb-0 fw-bold"><?php echo e(number_format($totalActions)); ?></h2>
                    <small class="text-muted">Everything you’ve done so far, <?php echo e($user->username ?? $user->useremail); ?></small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Things you added</h6>
                    <h2 class="mb-0 fw-bold text-success"><?php echo e(number_format($created)); ?></h2>
                    <small class="text-muted">New items you created</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Things you changed</h6>
                    <h2 class="mb-0 fw-bold text-warning"><?php echo e(number_format($updated)); ?></h2>
                    <small class="text-muted">Updates you made</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Things you removed</h6>
                    <h2 class="mb-0 fw-bold text-danger"><?php echo e(number_format($deleted)); ?></h2>
                    <small class="text-muted">Items you deleted</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity focus -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.8rem;">Last 30 days</h6>
                    <h2 class="mb-0 fw-bold"><?php echo e(number_format($last30Actions)); ?></h2>
                    <small class="text-muted">Your activity in the past month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bx bx-history me-2"></i>Your recent activity</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($recentLogs->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>What you did</th>
                                        <th>Type</th>
                                        <th>When</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($log->description ?? $log->action); ?></td>
                                            <td>
                                                <?php switch($log->method):
                                                    case ('POST'): ?> <span class="badge bg-success">CREATE</span> <?php break; ?>
                                                    <?php case ('PUT'): ?> <?php case ('PATCH'): ?> <span class="badge bg-warning text-dark">UPDATE</span> <?php break; ?>
                                                    <?php case ('DELETE'): ?> <span class="badge bg-danger">DELETE</span> <?php break; ?>
                                                    <?php default: ?> <span class="badge bg-secondary"><?php echo e($log->method); ?></span>
                                                <?php endswitch; ?>
                                            </td>
                                            <td class="text-muted small"><?php echo e($log->created_at->format('M d, Y H:i:s')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-user-x fa-3x mb-3"></i>
                            <p class="mb-0">No activity recorded yet. When you add, edit, or delete something, it’ll appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/authenticated-users-summary.blade.php ENDPATH**/ ?>