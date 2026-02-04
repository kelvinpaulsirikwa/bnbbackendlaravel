

<?php $__env->startSection('title', 'Room Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Room Management - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.room-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Room
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

            <?php if($rooms->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <?php if($room->frontimage): ?>
                                    <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo e($room->room_number); ?>" 
                                         style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-bed fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Room <?php echo e($room->room_number); ?></h5>
                                    <p class="card-text">
                                        <strong>Type:</strong> <?php echo e($room->roomType->name ?? 'N/A'); ?><br>
                                        <strong>Price:</strong> $<?php echo e(number_format($room->price_per_night, 2)); ?>/night<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-<?php echo e($room->status === 'active' ? 'success' : 'danger'); ?>">
                                            <?php echo e(ucfirst($room->status)); ?>

                                        </span>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="btn-group w-100" role="group">
                                            <a href="<?php echo e(route('bnbowner.room-management.edit', $room->id)); ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?php echo e(route('bnbowner.room-items.index', $room->id)); ?>" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-box"></i> Items
                                            </a>
                                            <a href="<?php echo e(route('bnbowner.room-images.index', $room->id)); ?>" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-images"></i> Images
                                            </a>
                                        </div>
                                        
                                        <form method="POST" action="<?php echo e(route('bnbowner.room-management.destroy', $room->id)); ?>" 
                                              class="mt-2" 
                                              onsubmit="return confirm('Are you sure you want to delete this room?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-bed fa-4x text-muted mb-3"></i>
                    <h4>No Rooms Found</h4>
                    <p class="text-muted">You haven't added any rooms to this motel yet.</p>
                    <a href="<?php echo e(route('bnbowner.room-management.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Room
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/room-management/index.blade.php ENDPATH**/ ?>