@extends('layouts.owner')

@section('title', 'People in Role - ' . $role->name)

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">People in role: {{ $role->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.role-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Role Management
                    </a>
                </div>
            </div>

            @if($staff->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $index => $member)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
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
                                                <span class="badge bg-{{ $member->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($member->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('bnbowner.staff-management.edit', $member->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Edit Staff
                                                </a>
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
                        <p class="text-muted mb-3">No one is assigned to this role yet.</p>
                        <a href="{{ route('bnbowner.staff-management.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Staff
                        </a>
                        <a href="{{ route('bnbowner.role-management.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> Back to Roles
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
