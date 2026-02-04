

<?php $__env->startSection('title', 'BNB Rules Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f5f5f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            
            <!-- Page Header -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">BNB Rules Management</h2>

                <?php if($motel): ?>
                    <div class="card border-0 shadow-sm ms-3">
                        <div class="card-body py-2 px-3">
                            <div class="small text-muted">Currently viewing</div>
                            <div class="fw-semibold"><?php echo e($motel->name); ?></div>
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

            <!-- Rules Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Hotel Rules</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('bnbowner.bnb-rules.store')); ?>" id="rulesForm">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="rules" class="form-label">Rules and Policies</label>
                            <textarea class="form-control" id="rules" name="rules" rows="15" 
                                      placeholder="Enter your hotel rules, policies, and guidelines here. You can include information about check-in/check-out times, cancellation policies, pet policies, smoking policies, etc."><?php echo e(old('rules', $bnbRule->rules ?? '')); ?></textarea>
                            <div class="form-text">Write all the rules and policies for your BNB. This information will be visible to guests.</div>
                            <?php $__errorArgs = ['rules'];
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
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if($bnbRule && $bnbRule->id): ?>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Rules
                                    </button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus me-1"></i>Create Rules
                                    </button>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('bnbowner.dashboard')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tips for Writing Rules</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Be clear and specific about your policies</li>
                        <li>Include check-in and check-out times</li>
                        <li>Mention cancellation and refund policies</li>
                        <li>Specify rules about pets, smoking, parties, etc.</li>
                        <li>Include any age restrictions or special requirements</li>
                        <li>Mention quiet hours or noise policies</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/bnb-rules/index.blade.php ENDPATH**/ ?>