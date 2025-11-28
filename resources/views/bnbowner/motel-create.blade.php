@extends('layouts.choose')

@section('title', 'Add New Motel')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <a href="{{ route('bnbowner.motel-selection') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to My Motels
                </a>
                <h1 class="display-5 text-primary">
                    <i class="fas fa-hotel"></i> Register New Motel
                </h1>
                <p class="lead text-muted">Fill in the details below to add a new property to your account</p>
            </div>

            <!-- Important Notice -->
            <div class="alert alert-warning d-flex align-items-start mb-4">
                <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                <div>
                    <h5 class="alert-heading mb-1">Important Notice</h5>
                    <p class="mb-0">Your motel will be submitted with <strong>inactive status</strong> and requires admin approval before it becomes visible to guests. You will be notified once approved.</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Motel Registration Form</h4>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bnbowner.motel.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Basic Information -->
                        <div class="form-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <span class="section-number">1</span>
                                <h5 class="mb-0">Basic Information</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        Motel Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="e.g. Sunrise Beach Resort" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="motel_type_id" class="form-label">
                                        Property Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('motel_type_id') is-invalid @enderror" 
                                            id="motel_type_id" name="motel_type_id" required>
                                        <option value="">Select property type...</option>
                                        @foreach($motelTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('motel_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('motel_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label">
                                        Description <span class="text-muted">(Optional)</span>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4"
                                              placeholder="Describe your property - what makes it special, amenities, nearby attractions...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="front_image" class="form-label">
                                        Property Image <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="file" class="form-control @error('front_image') is-invalid @enderror" 
                                           id="front_image" name="front_image" accept="image/*">
                                    <div class="form-text">Upload a main image for your property (JPG, PNG, max 2MB)</div>
                                    @error('front_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Location -->
                        <div class="form-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <span class="section-number">2</span>
                                <h5 class="mb-0">Location Information</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="street_address" class="form-label">
                                        Street Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('street_address') is-invalid @enderror" 
                                           id="street_address" name="street_address" value="{{ old('street_address') }}"
                                           placeholder="e.g. 123 Ocean Drive, Suite 4" required>
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="country_id" class="form-label">
                                        Country <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('country_id') is-invalid @enderror" 
                                            id="country_id" name="country_id" required>
                                        <option value="">Select country...</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="region_id" class="form-label">
                                        Region <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('region_id') is-invalid @enderror" 
                                            id="region_id" name="region_id" required>
                                        <option value="">Select region...</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}" data-country="{{ $region->countryid }}" 
                                                    {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">
                                        District <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('district_id') is-invalid @enderror" 
                                            id="district_id" name="district_id" required>
                                        <option value="">Select district...</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" data-region="{{ $district->regionid }}"
                                                    {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">
                                        Latitude <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude') }}"
                                           placeholder="e.g. -6.1629">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">
                                        Longitude <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude') }}"
                                           placeholder="e.g. 35.7516">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Contact & Room Details -->
                        <div class="form-section mb-4">
                            <div class="section-header d-flex align-items-center mb-3">
                                <span class="section-number">3</span>
                                <h5 class="mb-0">Contact & Room Details</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">
                                        Contact Phone <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                                           id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}"
                                           placeholder="+255 xxx xxx xxx" required>
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">
                                        Contact Email <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                           id="contact_email" name="contact_email" value="{{ old('contact_email') }}"
                                           placeholder="motel@example.com">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="total_rooms" class="form-label">
                                        Total Rooms <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control @error('total_rooms') is-invalid @enderror" 
                                           id="total_rooms" name="total_rooms" value="{{ old('total_rooms') }}"
                                           placeholder="e.g. 25" min="1" required>
                                    @error('total_rooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="available_rooms" class="form-label">
                                        Available Rooms <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="number" class="form-control @error('available_rooms') is-invalid @enderror" 
                                           id="available_rooms" name="available_rooms" value="{{ old('available_rooms') }}"
                                           placeholder="Currently available" min="0">
                                    @error('available_rooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="form-section">
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>What happens next?</strong> Your motel will be submitted with <strong>inactive</strong> status. 
                                Our team will review your submission and activate it within 24-48 hours. 
                                You'll receive a notification once approved.
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('bnbowner.motel-selection') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Submit Motel for Approval
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-section {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.form-section:last-child {
    background: transparent;
    padding: 0;
}

.section-header {
    margin-bottom: 1rem;
}

.section-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    margin-right: 0.75rem;
}

.form-control, .form-select {
    border-radius: 10px;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
}

.btn-lg {
    border-radius: 10px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
}

.display-5 {
    font-weight: 300;
}

.alert {
    border-radius: 12px;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country_id');
    const regionSelect = document.getElementById('region_id');
    const districtSelect = document.getElementById('district_id');
    
    const allRegions = Array.from(regionSelect.options);
    const allDistricts = Array.from(districtSelect.options);
    
    // Filter regions by country
    countrySelect.addEventListener('change', function() {
        const countryId = this.value;
        regionSelect.innerHTML = '<option value="">Select region...</option>';
        districtSelect.innerHTML = '<option value="">Select district...</option>';
        
        allRegions.forEach(option => {
            if (option.dataset.country === countryId || option.value === '') {
                regionSelect.appendChild(option.cloneNode(true));
            }
        });
    });
    
    // Filter districts by region
    regionSelect.addEventListener('change', function() {
        const regionId = this.value;
        districtSelect.innerHTML = '<option value="">Select district...</option>';
        
        allDistricts.forEach(option => {
            if (option.dataset.region === regionId || option.value === '') {
                districtSelect.appendChild(option.cloneNode(true));
            }
        });
    });
});
</script>
@endpush
@endsection

