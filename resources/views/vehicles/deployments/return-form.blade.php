@extends('admin.admin_master')
@section('title', 'Return Vehicles')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Returns</h5>
                        <p class="text-muted mb-0">Record fleet assets returning from operations.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Vehicles</li>
                        <li class="breadcrumb-item active">Returns</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Return Processing</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('vehicles.returns.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Asset Numbers<span class="text-danger">*</span></label>
                    <textarea name="asset_numbers" class="form-control" rows="6" placeholder="Enter each asset number separated by comma, space or new line" required>{{ old('asset_numbers') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Return Notes</label>
                    <textarea name="return_notes" class="form-control" rows="3">{{ old('return_notes') }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Process Return</button>
                <a href="{{ route('vehicles.dashboard') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection
