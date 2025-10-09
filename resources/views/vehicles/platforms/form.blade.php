@extends('admin.admin_master')
@section('title', isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($vehicle) ? 'Update Vehicle' : 'Add New Vehicle' }}</h5>
                        <p class="text-muted mb-0">Capture comprehensive specifications for each vehicle type.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.platforms.index') }}">Vehicle Library</a></li>
                        <li class="breadcrumb-item active">{{ isset($vehicle) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ isset($vehicle) ? route('vehicles.platforms.update', $vehicle) : route('vehicles.platforms.store') }}">
        @csrf
        @if (isset($vehicle))
            @method('PUT')
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">General Details</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Vehicle Make<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $vehicle->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Variant / Model</label>
                        <input type="text" name="variant" class="form-control" value="{{ old('variant', $vehicle->variant ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category<span class="text-danger">*</span></label>
                        <select name="vehicle_category_id" class="form-control" required>
                            <option value=""> Select Category </option>
                            @foreach ($categories as $id => $label)
                                <option value="{{ $id }}" @selected(old('vehicle_category_id', $vehicle->vehicle_category_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Representative Image</label>
                        <input type="file" name="image" class="form-control">
                        @if (isset($vehicle) && $vehicle->image_path)
                            <small class="text-muted d-block mt-1">Current file: {{ $vehicle->image_path }}</small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Manufacturer</label>
                        <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $vehicle->manufacturer ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country of Origin</label>
                        <input type="text" name="country_of_origin" class="form-control" value="{{ old('country_of_origin', $vehicle->country_of_origin ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Engine Type</label>
                        <input type="text" name="engine_type" class="form-control" value="{{ old('engine_type', $vehicle->engine_type ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">Performance</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Engine Power (hp)</label>
                        <input type="number" step="0.01" name="engine_power_hp" class="form-control" value="{{ old('engine_power_hp', $vehicle->engine_power_hp ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Max Speed (kph)</label>
                        <input type="number" step="0.01" name="max_speed_kph" class="form-control" value="{{ old('max_speed_kph', $vehicle->max_speed_kph ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Operational Range (km)</label>
                        <input type="number" step="0.01" name="range_km" class="form-control" value="{{ old('range_km', $vehicle->range_km ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fuel Capacity (L)</label>
                        <input type="number" step="0.01" name="fuel_capacity_l" class="form-control" value="{{ old('fuel_capacity_l', $vehicle->fuel_capacity_l ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Weight (tons)</label>
                        <input type="number" step="0.001" name="weight_tons" class="form-control" value="{{ old('weight_tons', $vehicle->weight_tons ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Crew Capacity</label>
                        <input type="number" name="crew_capacity" class="form-control" value="{{ old('crew_capacity', $vehicle->crew_capacity ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Passenger Capacity</label>
                        <input type="number" name="passenger_capacity" class="form-control" value="{{ old('passenger_capacity', $vehicle->passenger_capacity ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">Systems & Notes</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Armament</label>
                        <textarea name="armament" class="form-control" rows="3">{{ old('armament', $vehicle->armament ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Armor</label>
                        <textarea name="armor" class="form-control" rows="3">{{ old('armor', $vehicle->armor ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Communication Systems</label>
                        <textarea name="communication_systems" class="form-control" rows="3">{{ old('communication_systems', $vehicle->communication_systems ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 d-flex gap-2">
            <button type="submit" class="btn btn-success">{{ isset($vehicle) ? 'Update Vehicle' : 'Save Vehicle' }}</button>
            <a href="{{ route('vehicles.platforms.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
@endsection

