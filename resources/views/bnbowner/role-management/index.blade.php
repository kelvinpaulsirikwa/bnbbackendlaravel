@extends('layouts.owner')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Role Management - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.role-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Role
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

            @if($roles->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td><strong>{{ $role->name }}</strong></td>
                                            <td>
                                                @if(!empty($role->permissions))
                                                    @foreach($role->permissions as $key)
                                                        @if(isset($permissionLabels[$key]))
                                                            <span class="badge bg-secondary me-1">{{ $permissionLabels[$key] }}</span>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('bnbowner.role-management.edit', $role->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('bnbowner.role-management.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <p class="text-muted mb-3">No roles yet. Create roles and assign which functions (e.g. hotel images, rooms, staff) each role can use.</p>
                        <a href="{{ route('bnbowner.role-management.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Role
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
