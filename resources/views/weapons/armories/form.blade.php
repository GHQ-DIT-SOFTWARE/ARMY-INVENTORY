@extends('admin.admin_master')
@section('title', isset($armory) ? 'Edit Armory' : 'Add Armory')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($armory) ? 'Update Armory' : 'Register Armory' }}</h5>
                        <p class="text-muted mb-0">Maintain visibility over all authorized storage facilities.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.armories.index') }}">Armories</a></li>
                        <li class="breadcrumb-item active">{{ isset($armory) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Armory Profile</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($armory) ? route('weapons.armories.update', $armory) : route('weapons.armories.store') }}">
                @csrf
                @if (isset($armory))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Armory Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $armory->name ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unique Code<span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $armory->code ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $armory->location ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Armourer</label>
                        <input type="text" name="commanding_officer" class="form-control" value="{{ old('commanding_officer', $armory->commanding_officer ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $armory->contact_number ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $armory->email ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="notes" class="form-control" rows="4">{{ old('notes', $armory->notes ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ isset($armory) ? 'Update Armory' : 'Save Armory' }}</button>
                    <a href="{{ route('weapons.armories.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
