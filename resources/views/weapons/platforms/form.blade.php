@extends('admin.admin_master')
@section('title', isset($weapon) ? 'Edit Weapon' : 'Add Weapon')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($weapon) ? 'Update Weapon' : 'Add New Weapon' }}</h5>
                        <p class="text-muted mb-0">Capture the full technical dossier for each platform.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.platforms.index') }}">Weapon Library</a></li>
                        <li class="breadcrumb-item active">{{ isset($weapon) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ isset($weapon) ? route('weapons.platforms.update', $weapon) : route('weapons.platforms.store') }}">
        @csrf
        @if (isset($weapon))
            @method('PUT')
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">General Details</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Weapon Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $weapon->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Variant / Model</label>
                        <input type="text" name="variant" class="form-control" value="{{ old('variant', $weapon->variant ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category<span class="text-danger">*</span></label>
                        <select name="weapon_category_id" class="form-control" required>
                            <option value="">- Select Category -</option>
                            @foreach ($categories as $id => $label)
                                <option value="{{ $id }}" @selected(old('weapon_category_id', $weapon->weapon_category_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Representative Image</label>
                        <input type="file" name="image" class="form-control">
                        @if (isset($weapon) && $weapon->image_path)
                            <small class="text-muted d-block mt-1">Current file: {{ $weapon->image_path }}</small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Caliber</label>
                        <input type="text" name="caliber" class="form-control" value="{{ old('caliber', $weapon->caliber ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Manufacturer</label>
                        <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $weapon->manufacturer ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country of Origin</label>
                        <input type="text" name="country_of_origin" class="form-control" value="{{ old('country_of_origin', $weapon->country_of_origin ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">Ballistics &amp; Dimensions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Barrel Length (mm)</label>
                        <input type="number" step="0.01" name="barrel_length_mm" class="form-control" value="{{ old('barrel_length_mm', $weapon->barrel_length_mm ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Overall Length (mm)</label>
                        <input type="number" step="0.01" name="overall_length_mm" class="form-control" value="{{ old('overall_length_mm', $weapon->overall_length_mm ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.001" name="weight_kg" class="form-control" value="{{ old('weight_kg', $weapon->weight_kg ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Muzzle Velocity (m/s)</label>
                        <input type="number" step="0.01" name="muzzle_velocity_mps" class="form-control" value="{{ old('muzzle_velocity_mps', $weapon->muzzle_velocity_mps ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Rate of Fire (rpm)</label>
                        <input type="number" step="0.01" name="rate_of_fire_rpm" class="form-control" value="{{ old('rate_of_fire_rpm', $weapon->rate_of_fire_rpm ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Effective Range (m)</label>
                        <input type="number" step="0.01" name="effective_range_m" class="form-control" value="{{ old('effective_range_m', $weapon->effective_range_m ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Maximum Range (m)</label>
                        <input type="number" step="0.01" name="maximum_range_m" class="form-control" value="{{ old('maximum_range_m', $weapon->maximum_range_m ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h5 class="mb-0">Configuration &amp; Notes</h5>
            </div>
            <div class="card-body">
                @php
                    $configurationOptions = $configurationOptions ?? [];
                    $rawConfiguration = collect(old('configuration_items', null));
                    if ($rawConfiguration->isEmpty()) {
                        $rawConfiguration = collect(isset($weapon) && ! empty($weapon->configuration) ? explode(',', $weapon->configuration) : [])
                            ->map(fn ($value) => trim($value))
                            ->filter();
                    } else {
                        $rawConfiguration = $rawConfiguration->map(fn ($value) => trim($value))->filter();
                    }

                    $preselectedConfiguration = $rawConfiguration
                        ->filter(fn ($value) => in_array($value, $configurationOptions, true))
                        ->values()
                        ->all();

                    $customConfiguration = old('configuration_custom');
                    if ($customConfiguration === null) {
                        $customConfiguration = $rawConfiguration
                            ->reject(fn ($value) => in_array($value, $configurationOptions, true))
                            ->implode(', ');
                    }
                @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Configuration</label>
                        <select name="configuration_items[]" class="form-control" multiple size="6">
                            @foreach ($configurationOptions as $option)
                                <option value="{{ $option }}" @selected(in_array($option, $preselectedConfiguration, true))>{{ $option }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple accessories.</small>
                        @error('configuration_items')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Additional Accessories</label>
                        <input type="text" name="configuration_custom" class="form-control" value="{{ $customConfiguration }}" placeholder="e.g. Folding stock, Tactical grip">
                        <small class="text-muted">Separate multiple items with commas.</small>
                        @error('configuration_custom')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ammunition Types</label>
                        <textarea name="ammunition_types" class="form-control" rows="3">{{ old('ammunition_types', $weapon->ammunition_types ?? '') }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $weapon->notes ?? '') }}</textarea>
                    </div>
                </div> 
            </div>
        </div>

        <div class="mb-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">{{ isset($weapon) ? 'Update Weapon' : 'Save Weapon' }}</button>
            <a href="{{ route('weapons.platforms.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
@endsection
