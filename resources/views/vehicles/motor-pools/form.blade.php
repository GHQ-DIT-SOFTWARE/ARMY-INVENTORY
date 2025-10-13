@extends('admin.admin_master')
@section('title', isset($motorPool) ? 'Edit Motor Pool' : 'Add Motor Pool')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($motorPool) ? 'Update Motor Pool' : 'Add Vehicle Supply Pools' }}</h5>
                        <p class="text-muted mb-0">Capture staging areas for fleet assignment and accountability.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.motor-pools.index') }}">Vehicle Supply Pools</a></li>
                        <li class="breadcrumb-item active">{{ isset($motorPool) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Vehicle Supply Pool Profile</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($motorPool) ? route('vehicles.motor-pools.update', $motorPool) : route('vehicles.motor-pools.store') }}">
                @csrf
                @if (isset($motorPool))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Supply Point Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $motorPool->name ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unique Code<span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $motorPool->code ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Location/Region/Unit</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $motorPool->location ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fleet Manager</label>
                        <input type="text" name="fleet_manager" class="form-control" value="{{ old('fleet_manager', $motorPool->fleet_manager ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $motorPool->contact_number ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $motorPool->email ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $motorPool->notes ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">{{ isset($motorPool) ? 'Update Motor Pool' : 'Save Motor Pool' }}</button>
                    <a href="{{ route('vehicles.motor-pools.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
