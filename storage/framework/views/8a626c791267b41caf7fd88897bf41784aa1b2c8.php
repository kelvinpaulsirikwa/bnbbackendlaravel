<?php if($paginator->hasPages()): ?>
    <nav class="motels-pagination-inner" role="navigation" aria-label="Pagination">
        <div class="motels-pagination-summary">
            Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> of <?php echo e($paginator->total()); ?> results
        </div>

        <ul class="motels-pagination-list">
            
            <?php if($paginator->onFirstPage()): ?>
                <li aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span class="motels-page-btn motels-page-btn--disabled" aria-hidden="true">‹</span>
                </li>
            <?php else: ?>
                <li>
                    <a class="motels-page-btn" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">‹</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li aria-disabled="true">
                        <span class="motels-page-btn motels-page-btn--disabled"><?php echo e($element); ?></span>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li aria-current="page">
                                <span class="motels-page-btn motels-page-btn--active"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li>
                                <a class="motels-page-btn" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a class="motels-page-btn" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">›</a>
                </li>
            <?php else: ?>
                <li aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span class="motels-page-btn motels-page-btn--disabled" aria-hidden="true">›</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/components/pagination/motels.blade.php ENDPATH**/ ?>