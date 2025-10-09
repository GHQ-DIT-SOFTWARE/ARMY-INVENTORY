@extends('admin.admin_master')
@section('title', isset($vehicleCategory) ? 'Edit Vehicle Category' : 'Add Vehicle Category')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($vehicleCategory) ? 'Update Category' : 'Create Category' }}</h5>
                        <p class="text-muted mb-0">Define how vehicles are grouped for command oversight.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ isset($vehicleCategory) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Category Details</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($vehicleCategory) ? route('vehicles.categories.update', $vehicleCategory) : route('vehicles.categories.store') }}">
                @csrf
                @if (isset($vehicleCategory))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Category Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $vehicleCategory->name ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="unit_scope" class="form-control" value="{{ old('unit_scope', $vehicleCategory->unit_scope ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" @selected(old('is_active', $vehicleCategory->is_active ?? true))>Serviceable</option>
                            <option value="0" @selected(!old('is_active', $vehicleCategory->is_active ?? true))>Non-Serviceable</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $vehicleCategory->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">{{ isset($vehicleCategory) ? 'Update Category' : 'Create Category' }}</button>
                    <a href="{{ route('vehicles.categories.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
