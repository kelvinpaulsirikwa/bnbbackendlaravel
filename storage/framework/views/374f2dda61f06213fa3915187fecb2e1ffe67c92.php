

<?php $__env->startSection('title', 'BnB Owner Dashboard - ' . $selectedMotel->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
        <div>
            <h1 class="h2 mb-1"><?php echo e($selectedMotel->name); ?></h1>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt me-1"></i> 
                Registered <?php echo e($selectedMotel->created_at->format('F j, Y')); ?>

                <span class="mx-2">•</span>
                <i class="fas fa-tag me-1"></i> 
                <?php echo e($selectedMotel->motelType->name ?? 'N/A'); ?>

            </p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo e(route('bnbowner.switch-account')); ?>" class="btn btn-outline-primary">
                <i class="fas fa-exchange-alt me-1"></i> Switch Motel
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-bed fa-lg"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bold"><?php echo e($motelStats['total_rooms']); ?></h3>
                            <small class="text-muted">Total Rooms</small>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            <?php echo e($motelStats['available_rooms']); ?> Available
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bold"><?php echo e($motelStats['total_staff']); ?></h3>
                            <small class="text-muted">Staff Members</small>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <a href="<?php echo e(route('bnbowner.staff-management.index')); ?>" class="text-success text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Manage Staff
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-concierge-bell fa-lg"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bold"><?php echo e($motelStats['total_amenities']); ?></h3>
                            <small class="text-muted">Amenities</small>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <a href="<?php echo e(route('bnbowner.hotel-facilities.index')); ?>" class="text-warning text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> View Facilities
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-images fa-lg"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bold"><?php echo e($motelStats['total_images']); ?></h3>
                            <small class="text-muted">Gallery Images</small>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <a href="<?php echo e(route('bnbowner.hotel-images.index')); ?>" class="text-info text-decoration-none small">
                            <i class="fas fa-arrow-right me-1"></i> Manage Gallery
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Motel Overview Card -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-hotel text-primary me-2"></i>Motel Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <?php if($selectedMotel->front_image): ?>
                                <img src="<?php echo e(asset('storage/' . $selectedMotel->front_image)); ?>" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="<?php echo e($selectedMotel->name); ?>"
                                     style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                     style="height: 200px;">
                                    <i class="fas fa-hotel fa-4x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <p class="text-muted mb-3"><?php echo e(Str::limit($selectedMotel->description, 200) ?? 'No description available.'); ?></p>
                            
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-map-marker-alt text-danger mt-1 me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Address</small>
                                            <strong><?php echo e($selectedMotel->street_address ?? 'Not set'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-city text-primary mt-1 me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Location</small>
                                            <strong>
                                                <?php echo e($selectedMotel->district->name ?? 'N/A'); ?>

                                                <?php if($selectedMotel->district && $selectedMotel->district->region): ?>
                                                    , <?php echo e($selectedMotel->district->region->name); ?>

                                                <?php endif; ?>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-phone text-success mt-1 me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Contact Phone</small>
                                            <strong><?php echo e($selectedMotel->contact_phone ?? 'Not set'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-envelope text-info mt-1 me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Contact Email</small>
                                            <strong><?php echo e($selectedMotel->contact_email ?? 'Not set'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3 pt-3 border-top">
                                <a href="<?php echo e(route('bnbowner.hotel-management.index')); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Information
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>Quick Info
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted"><i class="fas fa-calendar-plus me-2"></i>Created</span>
                            <strong><?php echo e($motelStats['created_at']->format('M d, Y')); ?></strong>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted"><i class="fas fa-clock me-2"></i>Age</span>
                            <strong><?php echo e($motelStats['created_at']->diffForHumans(null, true)); ?></strong>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted"><i class="fas fa-tag me-2"></i>Type</span>
                            <span class="badge bg-primary"><?php echo e($selectedMotel->motelType->name ?? 'N/A'); ?></span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted"><i class="fas fa-signal me-2"></i>Status</span>
                            <?php if($selectedMotel->status === 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif($selectedMotel->status === 'inactive'): ?>
                                <span class="badge bg-warning">Inactive</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($selectedMotel->status ?? 'Unknown')); ?></span>
                            <?php endif; ?>
                        </li>
                        <?php if($selectedMotel->latitude && $selectedMotel->longitude): ?>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted"><i class="fas fa-map-pin me-2"></i>GPS</span>
                            <small class="text-end">
                                <?php echo e(number_format($selectedMotel->latitude, 4)); ?>,<br>
                                <?php echo e(number_format($selectedMotel->longitude, 4)); ?>

                            </small>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-bed fa-2x mb-2 d-block"></i>
                                Manage Rooms
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo e(route('bnbowner.hotel-facilities.index')); ?>" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-concierge-bell fa-2x mb-2 d-block"></i>
                                Manage Facilities
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo e(route('bnbowner.staff-management.index')); ?>" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                Manage Staff
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="<?php echo e(route('bnbowner.chats.index')); ?>" class="btn btn-outline-warning w-100 py-3">
                                <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                                Guest Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Motels Quick Access -->
    <?php if($allMotels->count() > 1): ?>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-building text-secondary me-2"></i>Your Other Motels
                        </h5>
                        <span class="badge bg-secondary"><?php echo e($allMotels->count() - 1); ?> more</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $__currentLoopData = $allMotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($motel->id != $selectedMotel->id): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border">
                                            <div class="card-body">
                                                <h6 class="card-title mb-2">
                                                    <i class="fas fa-hotel text-muted me-1"></i>
                                                    <?php echo e($motel->name); ?>

                                                </h6>
                                                <p class="card-text small text-muted mb-3"><?php echo e(Str::limit($motel->description, 60)); ?></p>
                                                <form method="POST" action="<?php echo e(route('bnbowner.select-motel')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="motel_id" value="<?php echo e($motel->id); ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-exchange-alt me-1"></i> Switch To
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/dashboard.blade.php ENDPATH**/ ?>