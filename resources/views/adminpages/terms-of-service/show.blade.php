@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">{{ $term->title }}</h1>
                        <p class="text-muted mb-0">
                            @if($term->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif
                            · Updated {{ $term->updated_at->format('M d, Y') }}
                            @if($term->creator)
                                · Created by <strong>{{ $term->creator->username }}</strong> ({{ $term->created_at->format('M d, Y') }})
                            @else
                                · Created {{ $term->created_at->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.terms-of-service.edit', $term->id) }}" class="btn btn-outline-warning">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.terms-of-service.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="content prose">
                    {!! nl2br(e($term->content)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
