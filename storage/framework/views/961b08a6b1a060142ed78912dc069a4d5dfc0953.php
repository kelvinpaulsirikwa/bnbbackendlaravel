

<?php $__env->startSection('title', 'Room Items - Room ' . $room->room_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Room Items - Room <?php echo e($room->room_number); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.room-items.create', $room->id)); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </a>
                    <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
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

            <!-- Room Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?php if($room->frontimage): ?>
                                <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" 
                                     class="img-fluid rounded" 
                                     alt="Room <?php echo e($room->room_number); ?>">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="height: 150px;">
                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <h4>Room <?php echo e($room->room_number); ?></h4>
                            <p><strong>Type:</strong> <?php echo e($room->roomType->name ?? 'N/A'); ?></p>
                            <p><strong>Price:</strong> $<?php echo e(number_format($room->price_per_night, 2)); ?>/night</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-<?php echo e($room->status === 'active' ? 'success' : 'danger'); ?>">
                                    <?php echo e(ucfirst($room->status)); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($items->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo e($item->name); ?></h5>
                                    <p class="card-text flex-grow-1"><?php echo e($item->description); ?></p>
                                    
                                    <div class="mt-auto">
                                        <div class="btn-group w-100" role="group">
                                            <a href="<?php echo e(route('bnbowner.room-items.edit', [$room->id, $item->id])); ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="<?php echo e(route('bnbowner.room-items.destroy', [$room->id, $item->id])); ?>" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-box fa-4x text-muted mb-3"></i>
                    <h4>No Items Found</h4>
                    <p class="text-muted">This room doesn't have any items added yet.</p>
                    <a href="<?php echo e(route('bnbowner.room-items.create', $room->id)); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Item
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/room-items/index.blade.php ENDPATH**/ ?>