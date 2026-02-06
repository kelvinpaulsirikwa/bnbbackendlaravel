

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
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Image</th>
                                        <th>Room #</th>
                                        <th>Type</th>
                                        <th>Price / night</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php if($room->frontimage): ?>
                                                    <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" alt="" class="rounded" style="width: 56px; height: 56px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                                        <i class="fas fa-bed text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?php echo e($room->room_number); ?></strong></td>
                                            <td><?php echo e($room->roomType->name ?? 'N/A'); ?></td>
                                            <td>$<?php echo e(number_format($room->price_per_night, 2)); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($room->status === 'free' ? 'success' : ($room->status === 'booked' ? 'warning' : 'secondary')); ?>">
                                                    <?php echo e(ucfirst($room->status)); ?>

                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo e(route('bnbowner.room-management.show', $room->id)); ?>" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="<?php echo e(route('bnbowner.room-management.edit', $room->id)); ?>" class="btn btn-outline-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('bnbowner.room-management.destroy', $room->id)); ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i> Delete
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