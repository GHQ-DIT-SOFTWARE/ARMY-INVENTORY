@extends('admin.admin_master')
@section('title', 'Deploy Vehicles')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Deploy Vehicles</h5>
                        <p class="text-muted mb-0">Assign vehicles to active operations or supporting units.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Vehicles</li>
                        <li class="breadcrumb-item active">Deploy</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('vehicles.deployments.store') }}">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Deployment Details</h5>
                <a href="{{ route('vehicles.inventory.index') }}" class="btn btn-sm btn-outline-success">View Inventory</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Destination Motor Pool<span class="text-danger">*</span></label>
                        <select name="motor_pool_id" class="form-control" required>
                            <option value="">- Select Motor Pool -</option>
                            @foreach ($motorPools as $id => $label)
                                <option value="{{ $id }}" @selected(old('motor_pool_id') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Operator / Driver</label>
                        <select name="operator_id" class="form-control">
                            <option value="">- Optional -</option>
                            @foreach ($operators as $operator)
                                <option value="{{ $operator->id }}" @selected(old('operator_id') == $operator->id)>{{ $operator->surname }} {{ $operator->othernames }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expected Return Date</label>
                        <input type="date" name="expected_return_at" class="form-control" value="{{ old('expected_return_at') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Select Vehicle Assets<span class="text-danger">*</span></label>
                        <select name="vehicle_inventory_ids[]" class="form-control" multiple size="10" required>
                            @foreach ($availableVehicles as $inventory)
                                <option value="{{ $inventory->id }}">
                                    {{ $inventory->asset_number }} - {{ optional($inventory->vehicle)->name }} {{ optional($inventory->vehicle)->variant ? '(' . $inventory->vehicle->variant . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl / Cmd to select multiple vehicles.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deployment Notes</label>
                        <textarea name="deployment_notes" class="form-control" rows="3">{{ old('deployment_notes') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex gap-2">
                <button type="submit" class="btn btn-success">Confirm Deployment</button>
                <a href="{{ route('vehicles.dashboard') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>
    </form>
@endsection
