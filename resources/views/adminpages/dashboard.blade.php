@extends('adminpages.layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <!-- Bootstrap Test Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Bootstrap is working!</strong> If you can see this styled alert, Bootstrap CSS is loading correctly.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        Admin Dashboard
                    </h5>
                </div>
                <div class="card-body">
                    <h1 class="h3 mb-3">Welcome, {{ auth()->user()->username ?? auth()->user()->useremail }}</h1>
                    <p class="text-muted">This is your admin dashboard. Bootstrap components are now working properly!</p>
                    
                    <!-- Bootstrap Button Test -->
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#testModal">
                            Test Modal
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="testBootstrapJS()">
                            Test Bootstrap JS
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        System Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2">✓</span>
                        <span>Bootstrap CSS: <strong>Loaded</strong></span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2">✓</span>
                        <span>Bootstrap JS: <strong>Loaded</strong></span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success me-2">✓</span>
                        <span>FontAwesome: <strong>Loaded</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Modal -->
<div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">
                    Bootstrap Test Modal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>🎉 <strong>Congratulations!</strong> Bootstrap JavaScript is working perfectly!</p>
                <p>This modal was opened using Bootstrap's modal component.</p>
                <div class="alert alert-info">
                    All Bootstrap components (CSS and JS) are now functioning correctly.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Got it!</button>
            </div>
        </div>
    </div>
</div>

<script>
function testBootstrapJS() {
    // Test Bootstrap Toast
    const toastHtml = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Bootstrap Test</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Bootstrap JavaScript is working perfectly! 🎉
            </div>
        </div>
    `;
    
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1055';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Initialize and show toast
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}
</script>
 @endsection
