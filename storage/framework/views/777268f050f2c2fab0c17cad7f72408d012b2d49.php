<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Edit Amenity
                        </h1>
                        <p class="text-muted mb-0">Update amenity information</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.amenities.index')); ?>" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back to Amenities
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-edit me-2"></i>
                            Amenity Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('adminpages.amenities.update', $amenity->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            
                            <div class="row g-3">
                                <!-- Name Field -->
                                <div class="col-12">
                                    <label for="name" class="form-label">
                                        Amenity Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="name" 
                                           name="name" 
                                           value="<?php echo e(old('name', $amenity->name)); ?>" 
                                           placeholder="Enter amenity name"
                                           required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Icon Field -->
                                <div class="col-12">
                                    <label for="icon" class="form-label">
                                        Icon Image
                                    </label>
                                    
                                    <?php if($amenity->icon): ?>
                                        <div class="mb-3">
                                            <label class="form-label">Current Icon:</label>
                                            <div>
                                                <img src="<?php echo e($amenity->icon_url); ?>" alt="Current icon" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" onerror="this.onerror=null;this.src='<?php echo e(asset('images/noimage.png')); ?>';">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <input type="file" 
                                           class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="icon" 
                                           name="icon" 
                                           accept="image/*">
                                    <div class="form-text">
                                        Upload a new icon image (JPEG, PNG, JPG, GIF, SVG - Max 2MB). Leave empty to keep current icon.
                                    </div>
                                    <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?php echo e(route('adminpages.amenities.index')); ?>" 
                                           class="btn btn-outline-secondary">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Update Amenity
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/amenities/edit.blade.php ENDPATH**/ ?>