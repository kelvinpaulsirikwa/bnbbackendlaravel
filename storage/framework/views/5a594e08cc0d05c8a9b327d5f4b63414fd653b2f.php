

<?php $__env->startSection('content'); ?>
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-flag me-2 text-primary"></i>
                            Countries Management
                        </h1>
                        <p class="text-muted mb-0">Manage countries in your system</p>
                    </div>
                    <a href="<?php echo e(route('adminpages.countries.create')); ?>" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus me-2"></i>Add New Country
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search countries...">
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="badge bg-primary fs-6">
                            Total: <?php echo e($countries->total()); ?> countries
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Countries Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Countries List
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($countries->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="countriesTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 py-3 px-4">
                                        <i class="fas fa-flag me-2 text-muted"></i>Country Name
                                    </th>
                                    <th class="border-0 py-3 px-4">
                                        <i class="fas fa-calendar me-2 text-muted"></i>Created Date
                                    </th>
                                    <th class="border-0 py-3 px-4 text-center">
                                        <i class="fas fa-cogs me-2 text-muted"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="align-middle">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-flag text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold"><?php echo e($country->name); ?></h6>
                                                    <small class="text-muted">Country</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark">
                                                <?php echo e($country->created_at->format('M d, Y')); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('adminpages.countries.edit', $country)); ?>" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Country">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('adminpages.countries.destroy', $country)); ?>" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this country? This action cannot be undone.')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Country">
                                                        <i class="fas fa-trash"></i>
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
                        <div class="mb-4">
                            <i class="fas fa-flag fa-4x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-muted">No Countries Found</h5>
                        <p class="text-muted">Get started by adding your first country.</p>
                        <a href="<?php echo e(route('adminpages.countries.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Country
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if($countries->hasPages()): ?>
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            <?php echo e($countries->appends(request()->query())->links('adminpages.layouts.partials.pagination')); ?>

                        </div>
                        <div class="text-center">
                            <small class="text-muted">
                                Showing <?php echo e($countries->firstItem()); ?> to <?php echo e($countries->lastItem()); ?> of <?php echo e($countries->total()); ?> results
                            </small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('countriesTable');
            const rows = table.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                
                for (let i = 1; i < rows.length; i++) {
                    const countryName = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                    if (countryName.includes(filter)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
 <?php $__env->stopSection(); ?>

<?php echo $__env->make('adminpages.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/adminpages/countries/index.blade.php ENDPATH**/ ?>