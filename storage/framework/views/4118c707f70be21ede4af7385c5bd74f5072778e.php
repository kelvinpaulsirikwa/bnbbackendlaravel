

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
        <div>
            <h1 class="h2 mb-1">Admin Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, <?php echo e(auth()->user()->username ?? auth()->user()->useremail); ?></p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <span class="badge bg-primary fs-6"><?php echo e(now()->format('l, F j, Y')); ?></span>
        </div>
    </div>

    <!-- BnB Users Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3"><i class="fas fa-users text-primary me-2"></i>BnB Users Overview</h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Total Users</h6>
                            <h2 class="mb-0 fw-bold"><?php echo e(number_format($bnbUserStats['total'])); ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-success me-1"><?php echo e($bnbUserStats['active']); ?> Active</span>
                        <span class="badge bg-warning"><?php echo e($bnbUserStats['inactive']); ?> Inactive</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Registered Today</h6>
                            <h2 class="mb-0 fw-bold"><?php echo e(number_format($bnbUserStats['today'])); ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-plus fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">
                        <i class="fas fa-clock me-1"></i>Yesterday: <?php echo e($bnbUserStats['yesterday']); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">This Month</h6>
                            <h2 class="mb-0 fw-bold"><?php echo e(number_format($bnbUserStats['this_month'])); ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-calendar-alt fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">
                        <i class="fas fa-globe me-1"></i>Website Signups: <?php echo e($bnbUserStats['website_registrations']); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.75rem;">Total Customers</h6>
                            <h2 class="mb-0 fw-bold"><?php echo e(number_format($customerStats['total'])); ?></h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-tag fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-2 small text-muted">
                        <i class="fas fa-plus-circle me-1"></i>Today: <?php echo e($customerStats['today']); ?> | This Month: <?php echo e($customerStats['this_month']); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Motels & Location Statistics -->
    <div class="row mb-4">
        <!-- Motels -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-hotel text-danger me-2"></i>Motel Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h3 class="mb-0 fw-bold text-primary"><?php echo e($motelStats['total']); ?></h3>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h3 class="mb-0 fw-bold text-success"><?php echo e($motelStats['active']); ?></h3>
                                <small class="text-muted">Active</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h3 class="mb-0 fw-bold text-warning"><?php echo e($motelStats['inactive']); ?></h3>
                                <small class="text-muted">Inactive</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h3 class="mb-0 fw-bold text-info"><?php echo e($motelStats['pending']); ?></h3>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Awaiting Approval</span>
                            <span class="badge bg-warning fs-6"><?php echo e($motelStats['inactive']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Summary -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt text-success me-2"></i>Location Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded p-3 bg-light">
                                <i class="fas fa-globe fa-2x text-primary mb-2"></i>
                                <h3 class="mb-0 fw-bold"><?php echo e($locationStats['countries']); ?></h3>
                                <small class="text-muted">Countries</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-3 bg-light">
                                <i class="fas fa-map fa-2x text-success mb-2"></i>
                                <h3 class="mb-0 fw-bold"><?php echo e($locationStats['regions']); ?></h3>
                                <small class="text-muted">Regions</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-3 bg-light">
                                <i class="fas fa-city fa-2x text-info mb-2"></i>
                                <h3 class="mb-0 fw-bold"><?php echo e($locationStats['districts']); ?></h3>
                                <small class="text-muted">Districts</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users by Role -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-user-shield text-info me-2"></i>Users by Role</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                <i class="fas fa-user-cog fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0 fw-bold"><?php echo e($usersByRole['bnbadmin']); ?></h4>
                                <small class="text-muted">Admins</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                <i class="fas fa-building fa-2x text-success mb-2"></i>
                                <h4 class="mb-0 fw-bold"><?php echo e($usersByRole['bnbowner']); ?></h4>
                                <small class="text-muted">Owners</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                <i class="fas fa-concierge-bell fa-2x text-info mb-2"></i>
                                <h4 class="mb-0 fw-bold"><?php echo e($usersByRole['receptionist']); ?></h4>
                                <small class="text-muted">Receptionists</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                <i class="fas fa-shield-alt fa-2x text-warning mb-2"></i>
                                <h4 class="mb-0 fw-bold"><?php echo e($usersByRole['security']); ?></h4>
                                <small class="text-muted">Security</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-6 mb-3">
                            <div class="text-center p-3 bg-danger bg-opacity-10 rounded">
                                <i class="fas fa-utensils fa-2x text-danger mb-2"></i>
                                <h4 class="mb-0 fw-bold"><?php echo e($usersByRole['chef']); ?></h4>
                                <small class="text-muted">Chefs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Approvals & Recent Registrations -->
    <div class="row">
        <!-- Pending Motels -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clock text-warning me-2"></i>Pending Motel Approvals</h5>
                    <span class="badge bg-warning"><?php echo e($pendingMotels->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($pendingMotels->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $pendingMotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?php echo e($motel->name); ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i><?php echo e($motel->owner->username ?? 'N/A'); ?>

                                            <span class="mx-1">•</span>
                                            <i class="fas fa-map-marker-alt me-1"></i><?php echo e($motel->district->name ?? 'N/A'); ?>

                                        </small>
                                    </div>
                                    <span class="badge bg-warning">Pending</span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <p class="mb-0">No pending approvals</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Website Registrations -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-plus text-success me-2"></i>Recent Website Registrations</h5>
                    <span class="badge bg-success"><?php echo e($bnbUserStats['website_registrations']); ?> total</span>
                </div>
                <div class="card-body p-0">
                    <?php if($recentRegistrations->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $recentRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?php echo e($user->username); ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope me-1"></i><?php echo e($user->useremail); ?>

                                            <span class="mx-1">•</span>
                                            <i class="fas fa-calendar me-1"></i><?php echo e($user->created_at->format('M d, Y')); ?>

                                        </small>
                                    </div>
                                    <?php if($user->status === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">No recent registrations</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.border-4 {
    border-width: 4px !important;
}

.list-group-item {
    border-left: 0;
    border-right: 0;
}

.list-group-item:first-child {
    border-top: 0;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/dashboard.blade.php ENDPATH**/ ?>