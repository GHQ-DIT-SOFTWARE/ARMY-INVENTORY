@extends('admin.admin_master')
@section('title', isset($weaponCategory) ? 'Edit Weapon Category' : 'Add Weapon Category')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($weaponCategory) ? 'Update Category' : 'Create Category' }}</h5>
                        <p class="text-muted mb-0">Align the weapons taxonomy with G4 operational needs.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ isset($weaponCategory) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Create Category</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($weaponCategory) ? route('weapons.categories.update', $weaponCategory) : route('weapons.categories.store') }}">
                @csrf
                @if (isset($weaponCategory))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Base Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">Select if applicable</option>
                            @foreach ($baseCategories as $id => $label)
                                <option value="{{ $id }}" @selected(old('category_id', $weaponCategory->category_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $weaponCategory->name ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" name="unit_scope" class="form-control" value="{{ old('unit_scope', $weaponCategory->unit_scope ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" @selected(old('is_active', $weaponCategory->is_active ?? true))>Serviceable</option>
                            <option value="0" @selected(!old('is_active', $weaponCategory->is_active ?? true))>Non-Serviceable</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $weaponCategory->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ isset($weaponCategory) ? 'Update Category' : 'Create Category' }}</button>
                    <a href="{{ route('weapons.categories.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
