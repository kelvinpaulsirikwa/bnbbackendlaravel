

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            BNB Rules Management
                        </h1>
                        <p class="text-muted mb-0">View and manage hotel rules and policies</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Search Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('adminpages.bnb-rules.index')); ?>" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-10">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search by rules content or hotel name..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2 w-100">
                                <i class="bx bx-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Rules Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    BNB Rules List
                    <span class="badge bg-primary ms-2"><?php echo e($rules->total()); ?> Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($rules->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 5%;">#</th>
                                    <th scope="col" style="width: 20%;">Hotel Name</th>
                                    <th scope="col" style="width: 40%;">Rules Preview</th>
                                    <th scope="col" style="width: 15%;">Posted By</th>
                                    <th scope="col" style="width: 10%;">Created</th>
                                    <th scope="col" style="width: 10%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($rules->firstItem() + $index); ?></td>
                                        <td>
                                            <strong><?php echo e($rule->motel->name ?? 'N/A'); ?></strong>
                                            <?php if($rule->motel && $rule->motel->owner): ?>
                                                <br>
                                                <small class="text-muted">
                                                    Owner: <?php echo e($rule->motel->owner->username); ?>

                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($rule->rules): ?>
                                                <div class="text-truncate" style="max-width: 400px;" title="<?php echo e(strip_tags($rule->rules)); ?>">
                                                    <?php echo e(Str::limit(strip_tags($rule->rules), 120)); ?>

                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">No rules set</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($rule->postedBy): ?>
                                                <strong><?php echo e($rule->postedBy->username); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e($rule->postedBy->useremail); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($rule->created_at->format('M d, Y')); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('adminpages.bnb-rules.show', $rule->id)); ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="bx bx-show"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer bg-white border-0 py-3">
                        <?php echo e($rules->links('adminpages.layouts.partials.pagination')); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-info-circle fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No rules found.</p>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('adminpages.bnb-rules.index')); ?>" class="btn btn-outline-primary mt-2">
                                Clear Search
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/bnb-rules/index.blade.php ENDPATH**/ ?>