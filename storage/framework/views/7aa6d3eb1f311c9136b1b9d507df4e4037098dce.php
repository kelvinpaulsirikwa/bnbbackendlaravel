<?php $__env->startSection('title', 'View Room ' . $room->room_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">View Room <?php echo e($room->room_number); ?> - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.room-management.edit', $room->id)); ?>" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit Room
                    </a>
                    <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
                    </a>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-bed"></i> Room Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?php if($room->frontimage): ?>
                                <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" class="img-fluid rounded" alt="Room <?php echo e($room->room_number); ?>">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="140">Room Number</th>
                                    <td><?php echo e($room->room_number); ?></td>
                                </tr>
                                <tr>
                                    <th>Room Type</th>
                                    <td><?php echo e($room->roomType->name ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <th>Price per night</th>
                                    <td>$<?php echo e(number_format($room->price_per_night, 2)); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-<?php echo e($room->status === 'free' ? 'success' : ($room->status === 'booked' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($room->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created by</th>
                                    <td><?php echo e($room->creator ? $room->creator->username : '—'); ?><?php if($room->creator): ?> <span class="text-muted">(<?php echo e($room->creator->useremail); ?>)</span><?php endif; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Room Items (<?php echo e($room->items->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if($room->items->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $room->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->description ?? '—'); ?></td>
                                            <td><?php echo e($item->creator ? $item->creator->username : '—'); ?><?php if($item->creator): ?> <span class="text-muted small">(<?php echo e($item->creator->useremail); ?>)</span><?php endif; ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No items in this room.</p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-images"></i> Room Images (<?php echo e($roomImages->total()); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if($roomImages->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $roomImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <img src="<?php echo e(asset('storage/' . $image->imagepath)); ?>" class="card-img-top" alt="Room image" style="height: 180px; object-fit: cover;">
                                        <div class="card-body py-2">
                                            <?php if($image->description): ?>
                                                <p class="card-text small text-muted mb-1"><?php echo e($image->description); ?></p>
                                            <?php endif; ?>
                                            <p class="card-text small mb-0"><strong>Created by:</strong> <?php echo e($image->creator ? $image->creator->username : '—'); ?><?php if($image->creator): ?> <span class="text-muted">(<?php echo e($image->creator->useremail); ?>)</span><?php endif; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($roomImages->links()); ?>

                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No images for this room.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/room-management/show.blade.php ENDPATH**/ ?>