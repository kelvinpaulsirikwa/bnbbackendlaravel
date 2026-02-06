

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Motel Types Management
                        </h1>
                        <p class="text-muted mb-0">Manage different types of motels</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.motel-types.create')); ?>" class="btn btn-primary btn-lg shadow-sm">
                        Add New Motel Type
                    </a>
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

        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('adminpages.motel-types.index')); ?>" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search motel types..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="<?php echo e(route('adminpages.motel-types.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motel Types Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Motel Types List
                    <span class="badge bg-primary ms-2"><?php echo e($motelTypes->total()); ?> Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($motelTypes->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Created By</th>
                                    <th class="border-0">Created At</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $motelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#<?php echo e($motelType->id); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="fw-semibold"><?php echo e($motelType->name); ?></div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($motelType->createby ? \App\Models\BnbUser::find($motelType->createby)->username ?? 'User #' . $motelType->createby : 'System'); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($motelType->created_at->format('M d, Y')); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('adminpages.motel-types.show', $motelType->id)); ?>" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="<?php echo e(route('adminpages.motel-types.edit', $motelType->id)); ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('adminpages.motel-types.destroy', $motelType->id)); ?>" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this motel type?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bx bx-building display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No motel types found</h5>
                        <p class="text-muted mb-4">Get started by creating your first motel type.</p>
                        <a href="<?php echo e(route('adminpages.motel-types.create')); ?>" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Motel Type
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if($motelTypes->hasPages()): ?>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing <?php echo e($motelTypes->firstItem()); ?> to <?php echo e($motelTypes->lastItem()); ?> 
                            of <?php echo e($motelTypes->total()); ?> results
                        </div>
                        <div>
                            <?php echo e($motelTypes->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/motel-types/index.blade.php ENDPATH**/ ?>