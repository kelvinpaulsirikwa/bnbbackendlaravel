@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Hotel owner log #{{ $hotel_owner_log->id }}</h1>
                        <p class="text-muted mb-0">{{ $hotel_owner_log->action }}</p>
                    </div>
                    <a href="{{ route('adminpages.hotel-owner-logs.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Back to logs
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0"><i class="bx bx-desktop me-2"></i>IP &amp; Browser</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">IP address</dt>
                            <dd class="col-sm-8"><code class="fs-6">{{ $hotel_owner_log->ip_address ?? '—' }}</code></dd>
                            <dt class="col-sm-4">Browser</dt>
                            <dd class="col-sm-8">{{ $hotel_owner_log->browser }}</dd>
                            <dt class="col-sm-4">Platform (OS)</dt>
                            <dd class="col-sm-8">{{ $hotel_owner_log->platform }}</dd>
                            <dt class="col-sm-4">User agent</dt>
                            <dd class="col-sm-8"><small class="text-muted text-break">{{ $hotel_owner_log->user_agent ?? '—' }}</small></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0"><i class="bx bx-user me-2"></i>Owner &amp; Action</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Owner</dt>
                            <dd class="col-sm-8">
                                @if($hotel_owner_log->ownerUser)
                                    <strong>{{ $hotel_owner_log->ownerUser->username ?? $hotel_owner_log->ownerUser->useremail }}</strong>
                                    <br><span class="text-muted">{{ $hotel_owner_log->ownerUser->useremail }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </dd>
                            <dt class="col-sm-4">Action</dt>
                            <dd class="col-sm-8">{{ $hotel_owner_log->action }}</dd>
                            <dt class="col-sm-4">Method</dt>
                            <dd class="col-sm-8">
                                @switch($hotel_owner_log->method)
                                    @case('GET') <span class="badge bg-info">GET</span> @break
                                    @case('POST') <span class="badge bg-success">POST</span> @break
                                    @case('PUT') <span class="badge bg-warning text-dark">PUT</span> @break
                                    @case('PATCH') <span class="badge bg-warning text-dark">PATCH</span> @break
                                    @case('DELETE') <span class="badge bg-danger">DELETE</span> @break
                                    @default <span class="badge bg-secondary">{{ $hotel_owner_log->method }}</span>
                                @endswitch
                            </dd>
                            <dt class="col-sm-4">Time</dt>
                            <dd class="col-sm-8">{{ $hotel_owner_log->created_at->format('M d, Y H:i:s') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        @php
            $hasOld = !empty($hotel_owner_log->old_values);
            $hasNew = !empty($hotel_owner_log->new_values);
            $hasRequest = !empty($hotel_owner_log->request_data);
            $currentValues = $hasNew ? $hotel_owner_log->new_values : $hotel_owner_log->request_data;
            $showChanges = $hotel_owner_log->description || $hasOld || $hasNew || $hasRequest;
        @endphp

        @if($showChanges)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0"><i class="bx bx-git-compare me-2"></i>Old value vs current value</h5>
            </div>
            <div class="card-body">
                @if($hotel_owner_log->description)
                    <p class="mb-3"><strong>Description:</strong> {{ $hotel_owner_log->description }}</p>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-danger mb-2"><i class="bx bx-arrow-back me-1"></i>Previous (old) value</h6>
                        @if($hasOld)
                            <pre class="bg-light border border-danger border-opacity-25 p-3 rounded small mb-0" style="max-height: 320px; overflow: auto;">{{ json_encode($hotel_owner_log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        @else
                            <p class="text-muted small mb-0 fst-italic">— Not captured (middleware only records submitted data unless controller sets old values)</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-2"><i class="bx bx-check me-1"></i>Current (new) value</h6>
                        @if($currentValues)
                            <pre class="bg-light border border-success border-opacity-25 p-3 rounded small mb-0" style="max-height: 320px; overflow: auto;">{{ json_encode($currentValues, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        @else
                            <p class="text-muted small mb-0">— No submitted data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0"><i class="bx bx-link me-2"></i>Request</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Route name</dt>
                    <dd class="col-sm-9"><code>{{ $hotel_owner_log->route_name ?? '—' }}</code></dd>
                    <dt class="col-sm-3">URL</dt>
                    <dd class="col-sm-9"><small class="text-break">{{ $hotel_owner_log->url }}</small></dd>
                    @if($hasRequest)
                        <dt class="col-sm-3">Request data (raw)</dt>
                        <dd class="col-sm-9">
                            <pre class="bg-light p-3 rounded small mb-0" style="max-height: 200px; overflow: auto;">{{ json_encode($hotel_owner_log->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection
