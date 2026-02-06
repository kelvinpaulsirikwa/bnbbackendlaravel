<?php $__env->startSection('title', 'Edit Room'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Room <?php echo e($room->room_number); ?> - <?php echo e($motel->name); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.room-management.show', $room->id)); ?>" class="btn btn-outline-primary me-2">
                        <i class="fas fa-eye"></i> View Room
                    </a>
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

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Room Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('bnbowner.room-management.update', $room->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Room Number</label>
                                    <input type="text" class="form-control" id="room_number" name="room_number" value="<?php echo e(old('room_number', $room->room_number)); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_type_id" class="form-label">Room Type</label>
                                    <select class="form-select" id="room_type_id" name="room_type_id" required>
                                        <option value="">Select Room Type</option>
                                        <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($roomType->id); ?>" <?php echo e(old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : ''); ?>><?php echo e($roomType->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price Per Night ($)</label>
                                    <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="<?php echo e(old('price_per_night', $room->price_per_night)); ?>" step="0.01" min="0" required>
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
                                    <input type="file" class="form-control" id="frontimage" name="frontimage" accept="image/*">
                                    <?php if($room->frontimage): ?>
                                        <div class="mt-2">
                                            <img src="<?php echo e(asset('storage/' . $room->frontimage)); ?>" alt="Current" style="max-width: 120px; max-height: 90px; object-fit: cover;" class="img-thumbnail">
                                            <p class="text-muted small mt-1 mb-0">Current image</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('bnbowner.room-management.index')); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Room</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Room Items (<?php echo e($room->items->count()); ?>)</h5>
                    <a href="<?php echo e(route('bnbowner.room-items.create', $room->id)); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if($room->items->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th class="text-end" style="width: 140px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $room->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->description ?? '—'); ?></td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('bnbowner.room-items.edit', [$room->id, $item->id])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form method="POST" action="<?php echo e(route('bnbowner.room-items.destroy', [$room->id, $item->id])); ?>" class="d-inline" onsubmit="return confirm('Delete this item?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0 p-3">No items yet. <a href="<?php echo e(route('bnbowner.room-items.create', $room->id)); ?>">Add item</a></p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-images"></i> Room Images (<?php echo e($room->images->count()); ?>)</h5>
                    <a href="<?php echo e(route('bnbowner.room-images.create', $room->id)); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Upload Image
                    </a>
                </div>
                <div class="card-body">
                    <?php if($room->images->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $room->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <img src="<?php echo e(asset('storage/' . $image->imagepath)); ?>" class="card-img-top" alt="" style="height: 160px; object-fit: cover;">
                                        <div class="card-body py-2">
                                            <?php if($image->description): ?>
                                                <p class="card-text small text-muted mb-2"><?php echo e(Str::limit($image->description, 40)); ?></p>
                                            <?php endif; ?>
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="<?php echo e(route('bnbowner.room-images.edit', [$room->id, $image->id])); ?>" class="btn btn-outline-primary">Edit</a>
                                                <form method="POST" action="<?php echo e(route('bnbowner.room-images.destroy', [$room->id, $image->id])); ?>" class="d-inline" onsubmit="return confirm('Delete this image?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No images yet. <a href="<?php echo e(route('bnbowner.room-images.create', $room->id)); ?>">Upload image</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/room-management/edit.blade.php ENDPATH**/ ?>