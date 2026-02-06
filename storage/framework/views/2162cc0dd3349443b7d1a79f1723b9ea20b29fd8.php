<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Hotel Owner Logs</h1>
                        <p class="text-muted mb-0">Track every activity performed by hotel/BnB owners</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('adminpages.hotel-owner-logs.index')); ?>">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="motel_id" class="form-label">Hotel</label>
                            <select class="form-select" id="motel_id" name="motel_id">
                                <option value="">All hotels</option>
                                <?php $__currentLoopData = $motels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m->id); ?>" <?php echo e(request('motel_id') == $m->id ? 'selected' : ''); ?>>
                                        <?php echo e(Str::limit($m->name, 30)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo e(request('date')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="owner_user_id" class="form-label">Owner</label>
                            <select class="form-select" id="owner_user_id" name="owner_user_id">
                                <option value="">All owners</option>
                                <?php $__currentLoopData = $ownerUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($u->id); ?>" <?php echo e(request('owner_user_id') == $u->id ? 'selected' : ''); ?>>
                                        <?php echo e($u->username ?? $u->useremail); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Sort by</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="date" <?php echo e(request('sort', 'date') === 'date' ? 'selected' : ''); ?>>Date (newest)</option>
                                <option value="user" <?php echo e(request('sort') === 'user' ? 'selected' : ''); ?>>User then date</option>
                                <option value="hotel" <?php echo e(request('sort') === 'hotel' ? 'selected' : ''); ?>>Hotel then date</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="method" class="form-label">Method</label>
                            <select class="form-select" id="method" name="method">
                                <option value="">All</option>
                                <option value="POST" <?php echo e(request('method') === 'POST' ? 'selected' : ''); ?>>POST</option>
                                <option value="PUT" <?php echo e(request('method') === 'PUT' ? 'selected' : ''); ?>>PUT</option>
                                <option value="PATCH" <?php echo e(request('method') === 'PATCH' ? 'selected' : ''); ?>>PATCH</option>
                                <option value="DELETE" <?php echo e(request('method') === 'DELETE' ? 'selected' : ''); ?>>DELETE</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Action, route..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Filter
                            </button>
                            <a href="<?php echo e(route('adminpages.hotel-owner-logs.index')); ?>" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Activity log
                    <span class="badge bg-primary ms-2"><?php echo e($logs->total()); ?> Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($logs->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Hotel</th>
                                    <th>Owner</th>
                                    <th>What changed</th>
                                    <th>Method</th>
                                    <th>IP address</th>
                                    <th>Browser</th>
                                    <th>Time</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="align-middle"><span class="badge bg-light text-dark">#<?php echo e($log->id); ?></span></td>
                                        <td class="align-middle">
                                            <?php if($log->ownerUser && $log->ownerUser->motel): ?>
                                                <span class="fw-semibold"><?php echo e(Str::limit($log->ownerUser->motel->name, 25)); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php if($log->ownerUser): ?>
                                                <span class="fw-semibold"><?php echo e($log->ownerUser->username ?? $log->ownerUser->useremail); ?></span>
                                                <br><small class="text-muted"><?php echo e($log->ownerUser->useremail); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php if($log->description): ?>
                                                <span title="<?php echo e($log->description); ?>"><?php echo e(Str::limit($log->description, 45)); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(Str::limit($log->action, 40)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php switch($log->method):
                                                case ('GET'): ?> <span class="badge bg-info">GET</span> <?php break; ?>
                                                <?php case ('POST'): ?> <span class="badge bg-success">POST</span> <?php break; ?>
                                                <?php case ('PUT'): ?> <span class="badge bg-warning text-dark">PUT</span> <?php break; ?>
                                                <?php case ('PATCH'): ?> <span class="badge bg-warning text-dark">PATCH</span> <?php break; ?>
                                                <?php case ('DELETE'): ?> <span class="badge bg-danger">DELETE</span> <?php break; ?>
                                                <?php default: ?> <span class="badge bg-secondary"><?php echo e($log->method); ?></span>
                                            <?php endswitch; ?>
                                        </td>
                                        <td class="align-middle"><code class="small"><?php echo e($log->ip_address ?? '—'); ?></code></td>
                                        <td class="align-middle small">
                                            <?php echo e($log->browser); ?><?php if($log->platform !== 'Unknown'): ?> <span class="text-muted">(<?php echo e($log->platform); ?>)</span><?php endif; ?>
                                        </td>
                                        <td class="align-middle text-muted small"><?php echo e($log->created_at->format('M d, Y H:i:s')); ?></td>
                                        <td class="align-middle text-center">
                                            <a href="<?php echo e(route('adminpages.hotel-owner-logs.show', $log)); ?>" class="btn btn-sm btn-outline-info" title="View details"><i class="bx bx-show"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($logs->hasPages()): ?>
                        <div class="card-footer bg-white border-0 py-3">
                            <?php echo e($logs->links('adminpages.layouts.partials.pagination')); ?>

                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bx bx-hotel fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No hotel owner activity logged yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/hotel-owner-logs/index.blade.php ENDPATH**/ ?>