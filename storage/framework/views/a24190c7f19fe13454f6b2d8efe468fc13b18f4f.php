<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Log #<?php echo e($admin_log->id); ?></h1>
                        <p class="text-muted mb-0"><?php echo e($admin_log->action); ?></p>
                    </div>
                    <a href="<?php echo e(route('adminpages.admin-logs.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Back to logs
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0"><i class="bx bx-desktop me-2"></i>IP &amp; Browser</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">IP address</dt>
                            <dd class="col-sm-8"><code class="fs-6"><?php echo e($admin_log->ip_address ?? '—'); ?></code></dd>
                            <dt class="col-sm-4">Browser</dt>
                            <dd class="col-sm-8"><?php echo e($admin_log->browser); ?></dd>
                            <dt class="col-sm-4">Platform (OS)</dt>
                            <dd class="col-sm-8"><?php echo e($admin_log->platform); ?></dd>
                            <dt class="col-sm-4">User agent</dt>
                            <dd class="col-sm-8"><small class="text-muted text-break"><?php echo e($admin_log->user_agent ?? '—'); ?></small></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0"><i class="bx bx-user me-2"></i>Admin &amp; Action</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Admin</dt>
                            <dd class="col-sm-8">
                                <?php if($admin_log->adminUser): ?>
                                    <strong><?php echo e($admin_log->adminUser->username ?? $admin_log->adminUser->useremail); ?></strong>
                                    <br><span class="text-muted"><?php echo e($admin_log->adminUser->useremail); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </dd>
                            <dt class="col-sm-4">Action</dt>
                            <dd class="col-sm-8"><?php echo e($admin_log->action); ?></dd>
                            <dt class="col-sm-4">Method</dt>
                            <dd class="col-sm-8">
                                <?php switch($admin_log->method):
                                    case ('GET'): ?> <span class="badge bg-info">GET</span> <?php break; ?>
                                    <?php case ('POST'): ?> <span class="badge bg-success">POST</span> <?php break; ?>
                                    <?php case ('PUT'): ?> <span class="badge bg-warning text-dark">PUT</span> <?php break; ?>
                                    <?php case ('PATCH'): ?> <span class="badge bg-warning text-dark">PATCH</span> <?php break; ?>
                                    <?php case ('DELETE'): ?> <span class="badge bg-danger">DELETE</span> <?php break; ?>
                                    <?php default: ?> <span class="badge bg-secondary"><?php echo e($admin_log->method); ?></span>
                                <?php endswitch; ?>
                            </dd>
                            <dt class="col-sm-4">Time</dt>
                            <dd class="col-sm-8"><?php echo e($admin_log->created_at->format('M d, Y H:i:s')); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <?php if($admin_log->description || !empty($admin_log->old_values) || !empty($admin_log->new_values)): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0"><i class="bx bx-git-compare me-2"></i>What changed</h5>
            </div>
            <div class="card-body">
                <?php if($admin_log->description): ?>
                    <p class="mb-3"><strong>Description:</strong> <?php echo e($admin_log->description); ?></p>
                <?php endif; ?>
                <?php if(!empty($admin_log->old_values) || !empty($admin_log->new_values)): ?>
                    <div class="row">
                        <?php if(!empty($admin_log->old_values)): ?>
                            <div class="col-md-6">
                                <h6 class="text-muted">Previous values</h6>
                                <pre class="bg-light p-3 rounded small mb-0" style="max-height: 280px; overflow: auto;"><?php echo e(json_encode($admin_log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($admin_log->new_values)): ?>
                            <div class="col-md-6">
                                <h6 class="text-muted">New values</h6>
                                <pre class="bg-light p-3 rounded small mb-0" style="max-height: 280px; overflow: auto;"><?php echo e(json_encode($admin_log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0"><i class="bx bx-link me-2"></i>Request</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Route name</dt>
                    <dd class="col-sm-9"><code><?php echo e($admin_log->route_name ?? '—'); ?></code></dd>
                    <dt class="col-sm-3">URL</dt>
                    <dd class="col-sm-9"><small class="text-break"><?php echo e($admin_log->url); ?></small></dd>
                    <?php if(!empty($admin_log->request_data)): ?>
                        <dt class="col-sm-3">Request data</dt>
                        <dd class="col-sm-9">
                            <pre class="bg-light p-3 rounded small mb-0" style="max-height: 300px; overflow: auto;"><?php echo e(json_encode($admin_log->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                        </dd>
                    <?php endif; ?>
                </dl>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/admin-logs/show.blade.php ENDPATH**/ ?>