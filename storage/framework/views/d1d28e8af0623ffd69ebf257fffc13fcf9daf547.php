

<?php $__env->startSection('title', 'Hotel Facilities'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2">Hotel Facilities</h1>
                    <p class="text-muted mb-0">Manage amenities and their images for <strong><?php echo e($motel->name); ?></strong></p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo e(route('bnbowner.hotel-management.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Hotel Management
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

            <div class="row">
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-plus-circle"></i> Add Amenity
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('bnbowner.hotel-facilities.store')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="amenities_id" class="form-label">Select Amenity</label>
                                    <select class="form-select" id="amenities_id" name="amenities_id" required>
                                        <option value="">Choose amenity</option>
                                        <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($amenity->id); ?>"
                                                <?php echo e(in_array($amenity->id, $assignedAmenityIds) ? 'disabled' : ''); ?>>
                                                <?php echo e($amenity->name); ?>

                                                <?php if(in_array($amenity->id, $assignedAmenityIds)): ?>
                                                    (Already added)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="text-muted">Only amenities not already assigned can be selected.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description (optional)</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe how this amenity is offered"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Add Amenity
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-concierge-bell text-primary"></i> Current Amenities
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if($motel->amenities->isEmpty()): ?>
                                <div class="p-4 text-center text-muted">
                                    <i class="fas fa-info-circle me-2"></i>No amenities added yet. Use the form to add one.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Amenity</th>
                                                <th>Description</th>
                                                <th>Added By</th>
                                                <th class="text-center">Images</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $motel->amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motelAmenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo e($motelAmenity->amenity->name ?? 'Unknown Amenity'); ?></strong>
                                                    </td>
                                                    <td><?php echo e($motelAmenity->description ?? '—'); ?></td>
                                                    <td><?php echo e($motelAmenity->postedBy->username ?? $motelAmenity->postedBy->useremail ?? 'Unknown'); ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">
                                                            <?php echo e($motelAmenity->images->count()); ?>

                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="<?php echo e(route('bnbowner.hotel-facilities.images', $motelAmenity->id)); ?>"
                                                           class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="fas fa-images"></i> Manage Images
                                                        </a>
                                                        <form method="POST" action="<?php echo e(route('bnbowner.hotel-facilities.destroy', $motelAmenity->id)); ?>" class="d-inline" onsubmit="return confirm('Remove this amenity?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash-alt"></i> Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/hotel-facilities/index.blade.php ENDPATH**/ ?>