

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Motels Management
                        </h1>
                        <p class="text-muted mb-0">Manage motel properties</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.motels.create')); ?>" class="btn btn-primary btn-lg shadow-sm">
                        Add New Motel
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
                <form method="GET" action="<?php echo e(route('adminpages.motels.index')); ?>" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search motels..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Filter by Status</label>
                            <select class="form-select" id="statusFilter" name="status" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Status</option>
                                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="motelTypeFilter" class="form-label">Filter by Type</label>
                            <select class="form-select" id="motelTypeFilter" name="motel_type_id" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Types</option>
                                <?php $__currentLoopData = $motelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($motelType->id); ?>" <?php echo e(request('motel_type_id') == $motelType->id ? 'selected' : ''); ?>>
                                        <?php echo e($motelType->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="<?php echo e(route('adminpages.motels.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motels Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Motels List
                    <span class="badge bg-primary ms-2"><?php echo e($motels->total()); ?> Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($motels->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Owner</th>
                                    <th class="border-0">Type</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Contact</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $motels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#<?php echo e($motel->id); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-semibold"><?php echo e($motel->name); ?></div>
                                            <?php if($motel->description): ?>
                                                <small class="text-muted"><?php echo e(Str::limit($motel->description, 50)); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($motel->owner->username ?? 'N/A'); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-info"><?php echo e($motel->motelType->name ?? 'No Type'); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                                $statusColors = [
                                                    'active' => 'bg-success',
                                                    'inactive' => 'bg-warning',
                                                    'closed' => 'bg-danger'
                                                ];
                                            ?>
                                            <span class="badge <?php echo e($statusColors[$motel->status] ?? 'bg-secondary'); ?>">
                                                <?php echo e(ucfirst($motel->status)); ?>

                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="small">
                                                <?php if($motel->contact_phone): ?>
                                                    <div><i class="bx bx-phone"></i> <?php echo e($motel->contact_phone); ?></div>
                                                <?php endif; ?>
                                                <?php if($motel->contact_email): ?>
                                                    <div><i class="bx bx-envelope"></i> <?php echo e($motel->contact_email); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($motel->created_at->format('M d, Y')); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('adminpages.motels.show', $motel->id)); ?>" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="<?php echo e(route('adminpages.motels.edit', $motel->id)); ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('adminpages.motels.update-status', $motel->id)); ?>" 
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="<?php echo e($motel->status === 'active' ? 'inactive' : 'active'); ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Make <?php echo e($motel->status === 'active' ? 'Inactive' : 'Active'); ?>">
                                                        <i class="bx bx-power-off"></i>
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
                            <i class="bx bx-home display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No motels found</h5>
                        <p class="text-muted mb-4">Get started by creating your first motel.</p>
                        <a href="<?php echo e(route('adminpages.motels.create')); ?>" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Motel
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if($motels->hasPages()): ?>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing <?php echo e($motels->firstItem()); ?> to <?php echo e($motels->lastItem()); ?> 
                            of <?php echo e($motels->total()); ?> results
                        </div>
                        <div>
                            <?php echo e($motels->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/motels/index.blade.php ENDPATH**/ ?>