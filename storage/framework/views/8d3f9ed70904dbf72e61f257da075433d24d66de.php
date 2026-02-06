

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Guest Chats</h2>
            <p class="text-muted mb-0">Review conversations and respond to guests staying at your motels.</p>
        </div>
        <?php if($selectedMotel): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="small text-muted">Currently viewing</div>
                    <div class="fw-semibold"><?php echo e($selectedMotel->name); ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Guest</th>
                             <th scope="col">Booking</th>
                            <th scope="col">Last message</th>
                            <th scope="col">Updated</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $chatViewModels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?php echo e($chat['customer']->username ?? 'Guest'); ?></div>
                                    <div class="text-muted small"><?php echo e($chat['customer']->useremail ?? 'No email'); ?></div>
                                </td>
                               
                                <td>
                                    <?php if($chat['booking']): ?>
                                        <div class="text-muted small">
                                            <?php echo e($chat['booking']['check_in_date'] ?? '-'); ?> → <?php echo e($chat['booking']['check_out_date'] ?? '-'); ?>

                                        </div>
                                        <span class="badge bg-light text-muted border"><?php echo e(strtoupper($chat['booking']['status'] ?? 'N/A')); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">No booking linked</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($chat['last_message']): ?>
                                        <div class="small text-truncate" style="max-width: 280px;">
                                            <?php echo e($chat['last_message']['sender_name'] ?? ($chat['last_message']['sender_type'] === 'customer' ? 'Guest' : 'Staff')); ?>:
                                            <?php echo e($chat['last_message']['message']); ?>

                                        </div>
                                        <div class="text-muted small">
                                            <?php echo e(optional($chat['last_message']['created_at'])->timezone(config('app.timezone'))->format('M d, Y • H:i')); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">No messages yet</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        <?php echo e(optional($chat['updated_at'])->timezone(config('app.timezone'))->diffForHumans()); ?>

                                    </div>
                                    <span class="badge <?php echo e($chat['status'] === 'active' ? 'bg-success' : 'bg-secondary'); ?>">
                                        <?php echo e(strtoupper($chat['status'])); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('bnbowner.chats.show', $chat['id'])); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-message-rounded-detail me-1"></i> Open chat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No conversations found for the selected filters.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($chats->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($chats->links('pagination::bootstrap-5')); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/guest-chat/index.blade.php ENDPATH**/ ?>