@extends('layouts.owner')

@section('title', 'Staff Management')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Staff Management - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.staff-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Staff
                    </a>
                    <a href="{{ route('bnbowner.dashboard') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($staff->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $member)
                                        <tr>
                                            <td>
                                                @if($member->profileimage)
                                                    <img src="{{ asset('storage/' . $member->profileimage) }}" 
                                                         class="rounded-circle" 
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         alt="{{ $member->username }}">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $member->username }}</td>
                                            <td>{{ $member->useremail }}</td>
                                            <td>{{ $member->telephone ?? 'N/A' }}</td>
                                            <td>
                                                @if($member->motelRole)
                                                    <span class="badge bg-primary">{{ $member->motelRole->name }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $member->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($member->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('bnbowner.staff-management.edit', $member->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('bnbowner.staff-management.toggle-status', $member->id) }}" 
                                                          class="d-inline"
                                                          onsubmit="return confirmToggleStatus(this, '{{ $member->status }}')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-{{ $member->status === 'active' ? 'warning' : 'success' }}">
                                                            <i class="fas fa-{{ $member->status === 'active' ? 'ban' : 'check' }}"></i> 
                                                            {{ $member->status === 'active' ? 'Block' : 'Unblock' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4>No Staff Members Found</h4>
                    <p class="text-muted">You haven't added any staff members to this motel yet.</p>
                    <a href="{{ route('bnbowner.staff-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Staff Member
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
function confirmToggleStatus(form, status) {
    const action = status === 'active' ? 'block' : 'unblock';
    return confirm('Are you sure you want to ' + action + ' this staff member?');
}
</script>
