

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            User Management
                        </h1>
                        <p class="text-muted mb-0">Manage BNB system users</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.users.create')); ?>" class="btn btn-primary btn-lg shadow-sm">
                        Add New User
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
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('adminpages.users.index')); ?>" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search users..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="roleFilter" class="form-label">Filter by Role</label>
                            <select class="form-select" id="roleFilter" name="role" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Roles</option>
                                <option value="bnbadmin" <?php echo e(request('role') == 'bnbadmin' ? 'selected' : ''); ?>>Admin</option>
                                <option value="bnbowner" <?php echo e(request('role') == 'bnbowner' ? 'selected' : ''); ?>>Owner</option>
                                <option value="bnbreceiptionist" <?php echo e(request('role') == 'bnbreceiptionist' ? 'selected' : ''); ?>>Receptionist</option>
                                <option value="bnbsecurity" <?php echo e(request('role') == 'bnbsecurity' ? 'selected' : ''); ?>>Security</option>
                                <option value="bnbchef" <?php echo e(request('role') == 'bnbchef' ? 'selected' : ''); ?>>Chef</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Filter by Status</label>
                            <select class="form-select" id="statusFilter" name="status" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Status</option>
                                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="unactive" <?php echo e(request('status') == 'unactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="<?php echo e(route('adminpages.users.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Users List
                    <span class="badge bg-primary ms-2"><?php echo e($users->total()); ?> Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($users->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Profile</th>
                                    <th class="border-0">Username</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Role</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Phone</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#<?php echo e($user->id); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <?php if($user->profileimage): ?>
                                                <img src="<?php echo e(asset($user->profileimage)); ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <?php echo e(strtoupper(substr($user->username, 0, 1))); ?>

                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-semibold"><?php echo e($user->username); ?></div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($user->useremail); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                                $roleLabels = [
                                                    'bnbadmin' => 'Admin',
                                                    'bnbowner' => 'Owner',
                                                    'bnbreceiptionist' => 'Receptionist',
                                                    'bnbsecurity' => 'Security',
                                                    'bnbchef' => 'Chef'
                                                ];
                                            ?>
                                            <span class="badge bg-info"><?php echo e($roleLabels[$user->role] ?? $user->role); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge <?php echo e($user->status == 'active' ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e(ucfirst($user->status)); ?>

                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($user->telephone ?? 'N/A'); ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('adminpages.users.show', $user->id)); ?>" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="<?php echo e(route('adminpages.users.edit', $user->id)); ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <?php if($user->id !== auth()->id()): ?>
                                                    <form action="<?php echo e(route('adminpages.users.update-status', $user->id)); ?>" 
                                                          method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="status" value="<?php echo e($user->status === 'active' ? 'unactive' : 'active'); ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="<?php echo e($user->status === 'active' ? 'Deactivate' : 'Activate'); ?>">
                                                            <i class="bx bx-power-off"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline-secondary" title="You cannot change your own status" disabled>
                                                        <i class="bx bx-lock"></i>
                                                    </button>
                                                <?php endif; ?>
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
                            <i class="bx bx-user display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No users found</h5>
                        <p class="text-muted mb-4">Get started by creating your first user.</p>
                        <a href="<?php echo e(route('adminpages.users.create')); ?>" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New User
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if($users->hasPages()): ?>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing <?php echo e($users->firstItem()); ?> to <?php echo e($users->lastItem()); ?> 
                            of <?php echo e($users->total()); ?> results
                        </div>
                        <div>
                            <?php echo e($users->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/users/index.blade.php ENDPATH**/ ?>