@extends('admin.admin_master')
@section('title', 'Issue Weapons')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issue Weapons to Armories</h5>
                        <p class="text-muted mb-0">Record controlled distribution to forward units.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Issue Out</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('weapons.issues.store') }}">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Issue Details</h5>
                <a href="{{ route('weapons.inventory.index') }}" class="btn btn-sm btn-outline-secondary">View Inventory</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Receiving Armory<span class="text-danger">*</span></label>
                        <select name="armory_id" class="form-control" required>
                            <option value="">Select an Armory </option>
                            @foreach ($armories as $id => $label)
                                <option value="{{ $id }}" @selected(old('armory_id') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Expected Return Date</label>
                        <input type="date" name="expected_return_at" class="form-control" value="{{ old('expected_return_at') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Select Weapons<span class="text-danger">*</span></label>
                        <select name="weapon_inventory_ids[]" class="form-control" multiple size="10" required>
                            @foreach ($availableWeapons as $inventory)
                                <option value="{{ $inventory->id }}">
                                    {{ $inventory->weapon_number }} - {{ optional($inventory->weapon)->name }} {{ optional($inventory->weapon)->variant ? '(' . $inventory->weapon->variant . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl / Cmd to select multiple serials.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Issue Notes</label>
                        <textarea name="issue_notes" class="form-control" rows="3">{{ old('issue_notes') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex gap-2">
                <button type="submit" class="btn btn-primary">Confirm Issue</button>
                <a href="{{ route('weapons.dashboard') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>
    </form>
@endsection
