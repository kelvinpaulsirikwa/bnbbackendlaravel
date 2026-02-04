<?php $__env->startSection('title', 'Hotel Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f5f5f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-50">
            
            <!-- Page Header -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
    <h2 class="fw-bold mb-0">BnB Details Management</h2>

    <?php if($selectedMotel): ?>
        <div class="card border-0 shadow-sm ms-3">
            <div class="card-body py-2 px-3">
                <div class="small text-muted">Currently viewing</div>
                <div class="fw-semibold"><?php echo e($selectedMotel->name); ?></div>
            </div>
        </div>
    <?php endif; ?>
</div>

            
        
            <!-- Alert Messages -->
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

            <!-- Statistics Cards -->
            <?php if($motel->details): ?>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Total Rooms</h6>
                            <h3 class="mb-0"><?php echo e($motel->details->total_rooms); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Available Rooms</h6>
                            <h3 class="mb-0"><?php echo e($motel->details->available_rooms); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Contact Phone</h6>
                            <p class="mb-0 fw-semibold"><?php echo e($motel->details->contact_phone); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Status</h6>
                            <span class="badge bg-<?php echo e($motel->details->status === 'active' ? 'success' : 'danger'); ?>">
                                <?php echo e(ucfirst($motel->details->status)); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Content -->
            <div class="row g-4">
                
                <!-- Motel Information Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>BnB Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('bnbowner.hotel-management.update-motel')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">BnB Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo e(old('name', $motel->name)); ?>" required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?php echo e(old('description', $motel->description)); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="front_image" class="form-label">Front Image</label>
                                    <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*">
                                    <?php $__errorArgs = ['front_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if($motel->front_image): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset('storage/' . $motel->front_image)); ?>" 
                                                 alt="Current Image" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 150px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update BnB
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information Form -->
                    <div class="card mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('bnbowner.hotel-management.update-details')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_phone" class="form-label">Contact Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                               value="<?php echo e(old('contact_phone', $motel->details->contact_phone ?? '')); ?>" required>
                                        <?php $__errorArgs = ['contact_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_email" class="form-label">Contact Email</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                               value="<?php echo e(old('contact_email', $motel->details->contact_email ?? '')); ?>" required>
                                        <?php $__errorArgs = ['contact_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Update Contact
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Current Details</h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Basic Information</h6>
                                <p class="mb-2"><strong>Name:</strong><br><?php echo e($motel->name); ?></p>
                                <p class="mb-2"><strong>Address:</strong><br><?php echo e($motel->street_address); ?></p>
                                <?php if($motel->district): ?>
                                    <p class="mb-2"><strong>District:</strong><br><?php echo e($motel->district->name); ?></p>
                                <?php endif; ?>
                                <?php if($motel->motelType): ?>
                                    <p class="mb-2"><strong>Type:</strong><br><?php echo e($motel->motelType->name); ?></p>
                                <?php endif; ?>
                            </div>

                            <?php if($motel->details): ?>
                            <div>
                                <h6 class="fw-bold mb-3">Contact & Rooms</h6>
                                <p class="mb-2"><strong>Phone:</strong><br><?php echo e($motel->details->contact_phone); ?></p>
                                <p class="mb-2"><strong>Email:</strong><br><?php echo e($motel->details->contact_email); ?></p>
                                <p class="mb-2"><strong>Total Rooms:</strong> <?php echo e($motel->details->total_rooms); ?></p>
                                <p class="mb-2"><strong>Available:</strong> <?php echo e($motel->details->available_rooms); ?></p>
                                <p class="mb-0">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-<?php echo e($motel->details->status === 'active' ? 'success' : 'danger'); ?>">
                                        <?php echo e(ucfirst($motel->details->status)); ?>

                                    </span>
                                </p>
                            </div>
                            <?php else: ?>
                                <p class="text-muted">No additional details available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/hotel-management/index.blade.php ENDPATH**/ ?>