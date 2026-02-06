@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Hotel Owner Logs</h1>
                        <p class="text-muted mb-0">Track every activity performed by hotel/BnB owners</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('adminpages.hotel-owner-logs.index') }}">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="motel_id" class="form-label">Hotel</label>
                            <select class="form-select" id="motel_id" name="motel_id">
                                <option value="">All hotels</option>
                                @foreach($motels as $m)
                                    <option value="{{ $m->id }}" {{ request('motel_id') == $m->id ? 'selected' : '' }}>
                                        {{ Str::limit($m->name, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="owner_user_id" class="form-label">Owner</label>
                            <select class="form-select" id="owner_user_id" name="owner_user_id">
                                <option value="">All owners</option>
                                @foreach($ownerUsers as $u)
                                    <option value="{{ $u->id }}" {{ request('owner_user_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->username ?? $u->useremail }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Sort by</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="date" {{ request('sort', 'date') === 'date' ? 'selected' : '' }}>Date (newest)</option>
                                <option value="user" {{ request('sort') === 'user' ? 'selected' : '' }}>User then date</option>
                                <option value="hotel" {{ request('sort') === 'hotel' ? 'selected' : '' }}>Hotel then date</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="method" class="form-label">Method</label>
                            <select class="form-select" id="method" name="method">
                                <option value="">All</option>
                                <option value="POST" {{ request('method') === 'POST' ? 'selected' : '' }}>POST</option>
                                <option value="PUT" {{ request('method') === 'PUT' ? 'selected' : '' }}>PUT</option>
                                <option value="PATCH" {{ request('method') === 'PATCH' ? 'selected' : '' }}>PATCH</option>
                                <option value="DELETE" {{ request('method') === 'DELETE' ? 'selected' : '' }}>DELETE</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Action, route..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Filter
                            </button>
                            <a href="{{ route('adminpages.hotel-owner-logs.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Activity log
                    <span class="badge bg-primary ms-2">{{ $logs->total() }} Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($logs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Hotel</th>
                                    <th>Owner</th>
                                    <th>What changed</th>
                                    <th>Method</th>
                                    <th>IP address</th>
                                    <th>Browser</th>
                                    <th>Time</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td class="align-middle"><span class="badge bg-light text-dark">#{{ $log->id }}</span></td>
                                        <td class="align-middle">
                                            @if($log->ownerUser && $log->ownerUser->motel)
                                                <span class="fw-semibold">{{ Str::limit($log->ownerUser->motel->name, 25) }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($log->ownerUser)
                                                <span class="fw-semibold">{{ $log->ownerUser->username ?? $log->ownerUser->useremail }}</span>
                                                <br><small class="text-muted">{{ $log->ownerUser->useremail }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($log->description)
                                                <span title="{{ $log->description }}">{{ Str::limit($log->description, 45) }}</span>
                                            @else
                                                <span class="text-muted">{{ Str::limit($log->action, 40) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @switch($log->method)
                                                @case('GET') <span class="badge bg-info">GET</span> @break
                                                @case('POST') <span class="badge bg-success">POST</span> @break
                                                @case('PUT') <span class="badge bg-warning text-dark">PUT</span> @break
                                                @case('PATCH') <span class="badge bg-warning text-dark">PATCH</span> @break
                                                @case('DELETE') <span class="badge bg-danger">DELETE</span> @break
                                                @default <span class="badge bg-secondary">{{ $log->method }}</span>
                                            @endswitch
                                        </td>
                                        <td class="align-middle"><code class="small">{{ $log->ip_address ?? '—' }}</code></td>
                                        <td class="align-middle small">
                                            {{ $log->browser }}@if($log->platform !== 'Unknown') <span class="text-muted">({{ $log->platform }})</span>@endif
                                        </td>
                                        <td class="align-middle text-muted small">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('adminpages.hotel-owner-logs.show', $log) }}" class="btn btn-sm btn-outline-info" title="View details"><i class="bx bx-show"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($logs->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            {{ $logs->links('adminpages.layouts.partials.pagination') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-hotel fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No hotel owner activity logged yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
