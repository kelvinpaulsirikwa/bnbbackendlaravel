<?php $__env->startSection('title', 'Edit Room'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Room <?php echo e($room->room_number); ?> - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
                    </a>
                </div>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-edit"></i> Room Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('bnbowner.room-management.update', $room->id)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="room_number" class="form-label">Room Number</label>
                                            <input type="text" class="form-control" id="room_number" name="room_number" 
                                                   value="<?php echo e(old('room_number', $room->room_number)); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="room_type_id" class="form-label">Room Type</label>
                                            <select class="form-select" id="room_type_id" name="room_type_id" required>
                                                <option value="">Select Room Type</option>
                                                <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($roomType->id); ?>" 
                                                            <?php echo e(old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : ''); ?>>
                                                        <?php echo e($roomType->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price_per_night" class="form-label">Price Per Night ($)</label>
                                            <input type="number" class="form-control" id="price_per_night" name="price_per_night" 
                                                   value="<?php echo e(old('price_per_night', $room->price_per_night)); ?>" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="free" <?php echo e(old('status', $room->status) == 'free' ? 'selected' : ''); ?>>Free</option>
                                                <option value="booked" <?php echo e(old('status', $room->status) == 'booked' ? 'selected' : ''); ?>>Booked</option>
                                                <option value="maintainace" <?php echo e(old('status', $room->status) == 'maintainace' ? 'selected' : ''); ?>>Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="frontimage" class="form-label">Room Image</label>
                                            <input type="file" class="form-control" id="frontimage" name="frontimage" 
                                                   accept="image/*">
                                            <?php if($room->frontimage): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" 
                                                         alt="Current Image" 
                                                         style="max-width: 200px; max-height: 150px; object-fit: cover;"
                                                         class="img-thumbnail">
                                                    <p class="text-muted small mt-1">Current image</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-secondary me-md-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Room
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/room-management/edit.blade.php ENDPATH**/ ?>