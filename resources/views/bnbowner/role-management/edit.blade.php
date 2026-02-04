@extends('layouts.owner')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Role - {{ $role->name }}</h1>
                <a href="{{ route('bnbowner.role-management.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-tag"></i> Role Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.role-management.update', $role->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" placeholder="e.g. Receptionist, Security" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Permissions – choose which functions this role can use</label>
                                    <div class="border rounded p-3 bg-light">
                                        @foreach($permissionLabels as $key => $label)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $key }}" id="perm_{{ $key }}" {{ in_array($key, old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $key }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('bnbowner.role-management.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
