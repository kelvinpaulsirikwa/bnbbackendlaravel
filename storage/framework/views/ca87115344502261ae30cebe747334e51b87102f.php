

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            Edit Country
                        </h1>
                        <p class="text-muted mb-0">Update country information</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.countries.index')); ?>" class="btn btn-outline-secondary">
                        Back to Countries
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-flag me-2 text-primary"></i>
                            Country Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="<?php echo e(route('adminpages.countries.update', $country)); ?>" id="countryForm">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            
                            <!-- Country Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-flag me-2 text-primary"></i>Country Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       placeholder="Enter country name"
                                       value="<?php echo e(old('name', $country->name)); ?>"
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Enter the official name of the country
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-user me-2 text-primary"></i>Created By
                                </label>
                                <input type="text"
                                       class="form-control"
                                       value="<?php echo e($country->createby ?? 'System'); ?>"
                                       readonly>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>This value reflects who originally created the record.
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="<?php echo e(route('adminpages.countries.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Country
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('countryForm');
            const nameInput = document.getElementById('name');
            
            // Real-time validation
            nameInput.addEventListener('input', function() {
                if (this.value.trim().length < 2) {
                    this.setCustomValidity('Country name must be at least 2 characters long');
                } else {
                    this.setCustomValidity('');
                }
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                if (nameInput.value.trim().length < 2) {
                    e.preventDefault();
                    nameInput.focus();
                    return false;
                }
            });
        });
    </script>
    
 <?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/countries/edit.blade.php ENDPATH**/ ?>