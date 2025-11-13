@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Edit Motel
                        </h1>
                        <p class="text-muted mb-0">Update motel information</p>
                    </div>
                    <a href="{{ route('adminpages.motels.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back to Motels
                    </a>
                </div>
            </div>
        </div>

        @php
            $selectedRegionId = old('region_id', optional($motel->district)->regionid);
            $selectedCountryId = old('country_id');
            if (!$selectedCountryId && $selectedRegionId) {
                $regionMatch = $regions->firstWhere('id', $selectedRegionId);
                $selectedCountryId = $regionMatch->countryid ?? '';
            }
        @endphp

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-edit me-2"></i>
                            Motel Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminpages.motels.update', $motel->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <!-- Name Field -->
                                <div class="col-12">
                                    <label for="name" class="form-label">
                                        Motel Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $motel->name) }}" 
                                           placeholder="Enter motel name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="col-12">
                                    <label for="description" class="form-label">
                                        Description
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Enter motel description">{{ old('description', $motel->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Street Address Field -->
                                <div class="col-12">
                                    <label for="street_address" class="form-label">
                                        Street Address
                                    </label>
                                    <input type="text"
                                           class="form-control @error('street_address') is-invalid @enderror"
                                           id="street_address"
                                           name="street_address"
                                           value="{{ old('street_address', $motel->street_address) }}"
                                           placeholder="Enter street address">
                                    @error('street_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Location Selection -->
                                <div class="col-md-4">
                                    <label for="country_id" class="form-label">
                                        Country
                                    </label>
                                    <select class="form-select" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $selectedCountryId == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="region_id" class="form-label">
                                        Region
                                    </label>
                                    <select class="form-select" id="region_id" name="region_id" data-selected="{{ $selectedRegionId }}">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}"
                                                    data-country="{{ $region->countryid }}"
                                                    {{ $selectedRegionId == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">
                                        District
                                    </label>
                                    <select class="form-select @error('district_id') is-invalid @enderror"
                                            id="district_id"
                                            name="district_id"
                                            data-selected="{{ old('district_id', $motel->district_id) }}">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}"
                                                    data-region="{{ $district->regionid }}"
                                                    {{ old('district_id', $motel->district_id) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Latitude and Longitude -->
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">
                                        Latitude
                                    </label>
                                    <input type="number"
                                           class="form-control @error('latitude') is-invalid @enderror"
                                           id="latitude"
                                           name="latitude"
                                           value="{{ old('latitude', $motel->latitude) }}"
                                           step="0.000001"
                                           min="-90"
                                           max="90"
                                           placeholder="Enter latitude">
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">
                                        Longitude
                                    </label>
                                    <input type="number"
                                           class="form-control @error('longitude') is-invalid @enderror"
                                           id="longitude"
                                           name="longitude"
                                           value="{{ old('longitude', $motel->longitude) }}"
                                           step="0.000001"
                                           min="-180"
                                           max="180"
                                           placeholder="Enter longitude">
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Owner Field -->
                                <div class="col-md-6">
                                    <label for="owner_id" class="form-label">
                                        Owner <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('owner_id') is-invalid @enderror" 
                                            id="owner_id" 
                                            name="owner_id" 
                                            required>
                                        <option value="">Select Owner</option>
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->id }}" {{ old('owner_id', $motel->owner_id) == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->username }} ({{ $owner->useremail }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('owner_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Motel Type Field -->
                                <div class="col-md-6">
                                    <label for="motel_type_id" class="form-label">
                                        Motel Type
                                    </label>
                                    <select class="form-select @error('motel_type_id') is-invalid @enderror" 
                                            id="motel_type_id" 
                                            name="motel_type_id">
                                        <option value="">Select Motel Type</option>
                                        @foreach($motelTypes as $motelType)
                                            <option value="{{ $motelType->id }}" {{ old('motel_type_id', $motel->motel_type_id) == $motelType->id ? 'selected' : '' }}>
                                                {{ $motelType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('motel_type_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contact Phone Field -->
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">
                                        Contact Phone
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="{{ old('contact_phone', $motel->contact_phone) }}" 
                                           placeholder="Enter contact phone">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contact Email Field -->
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">
                                        Contact Email
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                           id="contact_email" 
                                           name="contact_email" 
                                           value="{{ old('contact_email', $motel->contact_email) }}" 
                                           placeholder="Enter contact email">
                                    @error('contact_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Total Rooms Field -->
                                <div class="col-md-6">
                                    <label for="total_rooms" class="form-label">
                                        Total Rooms <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('total_rooms') is-invalid @enderror"
                                           id="total_rooms"
                                           name="total_rooms"
                                           value="{{ old('total_rooms', $motel->total_rooms) }}"
                                           min="0"
                                           placeholder="Enter total rooms"
                                           required>
                                    @error('total_rooms')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Available Rooms Field -->
                                <div class="col-md-6">
                                    <label for="available_rooms" class="form-label">
                                        Available Rooms <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('available_rooms') is-invalid @enderror"
                                           id="available_rooms"
                                           name="available_rooms"
                                           value="{{ old('available_rooms', $motel->available_rooms) }}"
                                           min="0"
                                           placeholder="Enter available rooms"
                                           required>
                                    @error('available_rooms')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Status Field -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $motel->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $motel->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="closed" {{ old('status', $motel->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('adminpages.motels.index') }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Update Motel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countrySelect = document.getElementById('country_id');
        const regionSelect = document.getElementById('region_id');
        const districtSelect = document.getElementById('district_id');

        if (!countrySelect || !regionSelect || !districtSelect) {
            return;
        }

        function deriveRegionFromDistrict() {
            if (!regionSelect.dataset.selected && districtSelect.dataset.selected) {
                const matchingDistrict = Array.from(districtSelect.options).find(option => option.value === districtSelect.dataset.selected);
                if (matchingDistrict) {
                    regionSelect.dataset.selected = matchingDistrict.dataset.region || '';
                }
            }
        }

        function deriveCountryFromRegion() {
            if (!countrySelect.value && regionSelect.dataset.selected) {
                const matchingRegion = Array.from(regionSelect.options).find(option => option.value === regionSelect.dataset.selected);
                if (matchingRegion) {
                    countrySelect.value = matchingRegion.dataset.country || '';
                }
            }
        }

        function filterRegions() {
            const selectedCountry = countrySelect.value;
            let regionPreserved = false;

            Array.from(regionSelect.options).forEach(option => {
                if (option.value === '') {
                    option.hidden = false;
                    return;
                }

                const matches = !selectedCountry || option.dataset.country === selectedCountry;
                option.hidden = !matches;

                if (!matches && option.selected) {
                    option.selected = false;
                }

                if (matches && option.value === regionSelect.dataset.selected) {
                    option.selected = true;
                    regionPreserved = true;
                }
            });

            if (!regionPreserved && selectedCountry) {
                regionSelect.selectedIndex = 0;
                regionSelect.dataset.selected = '';
            } else {
                regionSelect.dataset.selected = regionSelect.value;
            }

            filterDistricts();
        }

        function filterDistricts() {
            const selectedRegion = regionSelect.value;
            let districtPreserved = false;

            Array.from(districtSelect.options).forEach(option => {
                if (option.value === '') {
                    option.hidden = false;
                    return;
                }

                const matches = !selectedRegion || option.dataset.region === selectedRegion;
                option.hidden = !matches;

                if (!matches && option.selected) {
                    option.selected = false;
                }

                if (matches && option.value === districtSelect.dataset.selected) {
                    option.selected = true;
                    districtPreserved = true;
                }
            });

            if (!districtPreserved && selectedRegion) {
                districtSelect.selectedIndex = 0;
                districtSelect.dataset.selected = '';
            } else {
                districtSelect.dataset.selected = districtSelect.value;
            }
        }

        countrySelect.addEventListener('change', () => {
            regionSelect.dataset.selected = '';
            districtSelect.dataset.selected = '';
            filterRegions();
        });

        regionSelect.addEventListener('change', () => {
            regionSelect.dataset.selected = regionSelect.value;
            districtSelect.dataset.selected = '';
            filterDistricts();
        });

        districtSelect.addEventListener('change', () => {
            districtSelect.dataset.selected = districtSelect.value;
        });

        deriveRegionFromDistrict();
        deriveCountryFromRegion();
        filterRegions();
    });
</script>
@endsection
