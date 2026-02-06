<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- Breadcrumb & Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('adminpages.motels.index')); ?>">Motels</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('adminpages.motels.show', $motel->id)); ?>"><?php echo e($motel->name); ?></a></li>
                    <li class="breadcrumb-item active">Room <?php echo e($room->room_number); ?></li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h3 mb-1">Room <?php echo e($room->room_number); ?></h1>
                    <p class="text-muted mb-0">View-only — room details, items, images & bookings</p>
                </div>
                <a href="<?php echo e(route('adminpages.motels.show', $motel->id)); ?>" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to motel
                </a>
            </div>
        </div>
    </div>

    <!-- Room summary card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bx bx-bed me-2"></i>Room information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Room number</span>
                            <span class="fw-semibold"><?php echo e($room->room_number); ?></span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Type</span>
                            <span class="fw-semibold"><?php echo e($room->roomType->name ?? '—'); ?></span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Price per night</span>
                            <span class="fw-semibold"><?php echo e($room->price_per_night ? number_format($room->price_per_night) . ' ' . (config('app.currency', 'USD')) : '—'); ?></span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Status</span>
                            <?php
                                $statusClass = ($room->status ?? ($room->is_active ? 'active' : 'inactive')) === 'active' ? 'bg-success' : 'bg-warning text-dark';
                            ?>
                            <span class="badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($room->status ?? ($room->is_active ? 'Active' : 'Inactive'))); ?></span>
                        </div>
                        <?php if($room->description): ?>
                            <div class="col-12 pt-2 border-top">
                                <span class="text-muted small d-block">Description</span>
                                <p class="mb-0 fw-semibold"><?php echo e($room->description); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Room items (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-list-ul me-2"></i>Room items</h5>
                    <span class="badge bg-primary"><?php echo e($roomItems->total()); ?> total</span>
                </div>
                <div class="card-body p-0">
                    <?php if($roomItems->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roomItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($item->name); ?></td>
                                            <td class="text-muted"><?php echo e($item->description ?: '—'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-pagination-wrap p-3 pt-4 border-top">
                            <?php echo e($roomItems->withQueryString()->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-package fa-3x mb-2"></i>
                            <p class="mb-0">No items for this room.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Room images (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-images me-2"></i>Room images</h5>
                    <span class="badge bg-primary"><?php echo e($roomImages->total()); ?> total</span>
                </div>
                <div class="card-body">
                    <?php if($roomImages->count() > 0): ?>
                        <div class="row g-3">
                            <?php $__currentLoopData = $roomImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="border rounded overflow-hidden bg-light text-center p-2">
                                        <?php
                                            $imgSrc = $img->imagepath ? (str_starts_with($img->imagepath, 'http') ? $img->imagepath : asset('storage/' . ltrim($img->imagepath, '/'))) : asset('images/static_file/nodp.png');
                                        ?>
                                        <img src="<?php echo e($imgSrc); ?>" alt="Room image" class="img-fluid rounded" style="max-height: 160px; object-fit: cover; width: 100%;" onerror="this.src='<?php echo e(asset('images/static_file/nodp.png')); ?>'">
                                        <?php if($img->description): ?>
                                            <p class="small text-muted mb-0 mt-1"><?php echo e(Str::limit($img->description, 40)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="admin-pagination-wrap mt-4 pt-4 border-top bg-white">
                            <?php echo e($roomImages->withQueryString()->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-image fa-3x mb-2"></i>
                            <p class="mb-0">No images for this room.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bookings (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-calendar-check me-2"></i>Bookings (recent)</h5>
                    <span class="badge bg-primary"><?php echo e($bookings->total()); ?> total</span>
                </div>
                <div class="card-body p-0">
                    <?php if($bookings->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Guest</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Nights</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="fw-semibold"><?php echo e($booking->customer->username ?? $booking->customer->useremail ?? 'N/A'); ?></span>
                                                <?php if($booking->contact_number): ?>
                                                    <br><small class="text-muted"><?php echo e($booking->contact_number); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($booking->check_in_date->format('M d, Y')); ?></td>
                                            <td><?php echo e($booking->check_out_date->format('M d, Y')); ?></td>
                                            <td><?php echo e($booking->number_of_nights ?? '—'); ?></td>
                                            <td><?php echo e($booking->total_amount ? number_format($booking->total_amount, 0) . ' ' . (config('app.currency', 'USD')) : '—'); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo e(ucfirst($booking->status ?? '—')); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="admin-pagination-wrap p-3 pt-4 border-top">
                            <?php echo e($bookings->withQueryString()->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-calendar-x fa-3x mb-2"></i>
                            <p class="mb-0">No bookings for this room yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/motels/rooms/show.blade.php ENDPATH**/ ?>