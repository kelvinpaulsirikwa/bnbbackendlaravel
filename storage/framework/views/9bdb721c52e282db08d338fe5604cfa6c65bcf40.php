
    
<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1"> All Guest Chats</h2>
            <a href="<?php echo e(route('bnbowner.chats.index')); ?>" class="btn btn-link px-0">
            <i class="bx bx-chevron-left"></i> Back to chats
        </a>        </div>
       
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="small text-muted">Currently viewing</div>
                    <div class="fw-semibold">Chat</div>
                </div>
            </div>
       
    </div>
   
    </div>

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1"><?php echo e($chat->customer->username ?? 'Guest'); ?></h3>
            <div class="text-muted">
                Motel: <?php echo e($chat->motel->name ?? 'N/A'); ?>

                <?php if($chat->booking): ?>
                    • Booking <?php echo e($chat->booking->check_in_date?->format('Y-m-d') ?? '-'); ?> → <?php echo e($chat->booking->check_out_date?->format('Y-m-d') ?? '-'); ?>

                <?php endif; ?>
            </div>
            <div class="text-muted small">Chat status: <span class="badge <?php echo e($chat->status === 'active' ? 'bg-success' : 'bg-secondary'); ?>"><?php echo e(strtoupper($chat->status)); ?></span></div>
        </div>
        <div class="text-end">
            <div class="text-muted small">Created: <?php echo e($chat->created_at?->format('M d, Y H:i')); ?></div>
            <div class="text-muted small">Last updated: <?php echo e($chat->updated_at?->diffForHumans()); ?></div>
        </div>
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

    <?php if(!$canSend && $sendRestriction): ?>
        <div class="alert alert-warning" role="alert">
            <?php echo e($sendRestriction); ?>

        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body" style="max-height: 520px; overflow-y: auto;">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isCustomer = $message->sender_type === 'customer';
                    $bubbleClasses = $isCustomer ? 'bg-light text-dark' : 'bg-success text-white';
                    $timestampClasses = $isCustomer ? 'text-muted' : 'text-white-50';
                    $senderName = $isCustomer
                        ? ($chat->customer->username ?? 'Guest')
                        : ($message->sender?->username ?? 'Staff');
                    if (!$isCustomer && $message->sender_id === auth()->id()) {
                        $senderName = 'You';
                    }
                ?>
                <div class="d-flex <?php echo e($isCustomer ? 'justify-content-start' : 'justify-content-end'); ?> mb-3">
                    <div class="p-3 rounded-4 shadow-sm <?php echo e($bubbleClasses); ?>" style="max-width: 70%;">
                        <div class="small fw-semibold mb-2"><?php echo e($senderName); ?></div>
                        <div class="mb-2" style="white-space: pre-wrap;"><?php echo e($message->message); ?></div>
                        <div class="small <?php echo e($timestampClasses); ?>">
                            <?php echo e($message->created_at?->timezone(config('app.timezone'))->format('M d, Y • H:i')); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    No messages yet. Start the conversation by sending a reply below.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('bnbowner.chats.send', $chat->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Your reply</label>
                    <textarea name="message" id="message" class="form-control" rows="3" placeholder="Type your message here..." <?php echo e($canSend ? '' : 'disabled'); ?>><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
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
                    <small class="text-muted">Guests will see your response instantly inside the mobile app.</small>
                    <button type="submit" class="btn btn-primary" <?php echo e($canSend ? '' : 'disabled'); ?>>
                        <i class="bx bx-send"></i> Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.owner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/bnbowner/guest-chat/show.blade.php ENDPATH**/ ?>