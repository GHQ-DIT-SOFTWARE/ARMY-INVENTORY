@extends('admin.admin_master')
@section('title', isset($vehicleInventory) ? 'Edit Vehicle Asset' : 'Add Vehicle Asset')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($vehicleInventory) ? 'Update Asset' : 'Add Vehicle Asset' }}</h5>
                        <p class="text-muted mb-0">Maintain serialized visibility of every vehicle.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.inventory.index') }}">Vehicle Inventory</a></li>
                        <li class="breadcrumb-item active">{{ isset($vehicleInventory) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Asset Details</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($vehicleInventory) ? route('vehicles.inventory.update', $vehicleInventory) : route('vehicles.inventory.store') }}">
                @csrf
                @if (isset($vehicleInventory))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Vehicle<span class="text-danger">*</span></label>
                        <select name="vehicle_id" class="form-control" required>
                            <option value=""> Select Vehicle</option>
                            @foreach ($vehicles as $id => $label)
                                <option value="{{ $id }}" @selected(old('vehicle_id', $vehicleInventory->vehicle_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chases Number<span class="text-danger">*</span></label>
                        <input type="text" name="asset_number" class="form-control" value="{{ old('asset_number', $vehicleInventory->asset_number ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Acquired On</label>
                        <input type="date" name="acquired_on" class="form-control" value="{{ old('acquired_on', optional($vehicleInventory->acquired_on ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Current Status</label>
                        @php($status = old('status', $vehicleInventory->status ?? 'in_pool'))
                        <select name="status" class="form-control">
                            <option value="in_pool" @selected($status === 'in_pool')>In Motor Pool</option>
                            <option value="deployed" @selected($status === 'deployed')>Deployed</option>
                            <option value="maintenance" @selected($status === 'maintenance')>Maintenance</option>
                            <option value="retired" @selected($status === 'retired')>Retired</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Current Motor Pool</label>
                        <select name="current_motor_pool_id" class="form-control">
                            <option value="">Central Garage</option>
                            @foreach ($motorPools as $id => $label)
                                <option value="{{ $id }}" @selected(old('current_motor_pool_id', $vehicleInventory->current_motor_pool_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Serviced</label>
                        <input type="date" name="last_serviced_at" class="form-control" value="{{ old('last_serviced_at', optional($vehicleInventory->last_serviced_at ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Condition Notes</label>
                        <textarea name="condition_notes" class="form-control" rows="3">{{ old('condition_notes', $vehicleInventory->condition_notes ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">{{ isset($vehicleInventory) ? 'Update Asset' : 'Save Asset' }}</button>
                    <a href="{{ route('vehicles.inventory.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
