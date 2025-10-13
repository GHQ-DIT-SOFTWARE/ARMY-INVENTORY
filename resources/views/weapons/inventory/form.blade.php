@extends('admin.admin_master')
@section('title', isset($weaponInventory) ? 'Edit Weapon Serial' : 'Add Weapons Items')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">{{ isset($weaponInventory) ? 'Update Weapon Serial' : 'Add Weapon Items' }}</h5>
                        <p class="text-muted mb-0">Every individual weapon remains traceable across its lifecycle.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.inventory.index') }}">Weapon Inventory</a></li>
                        <li class="breadcrumb-item active">{{ isset($weaponInventory) ? 'Edit' : 'Create' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Weapon Item Addition</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($weaponInventory) ? route('weapons.inventory.update', $weaponInventory) : route('weapons.inventory.store') }}">
                @csrf
                @if (isset($weaponInventory))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Weapon Sub-Category<span class="text-danger">*</span></label>
                        <select name="weapon_id" class="form-control" required>
                            <option value="">- Select One -</option>
                            @foreach ($weapons as $id => $label)
                                <option value="{{ $id }}" @selected(old('weapon_id', $weaponInventory->weapon_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Weapon Number<span class="text-danger">*</span></label>
                        <input type="text" name="weapon_number" class="form-control" value="{{ old('weapon_number', $weaponInventory->weapon_number ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Acquired On</label>
                        <input type="date" name="acquired_on" class="form-control" value="{{ old('acquired_on', optional($weaponInventory->acquired_on ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Current Status</label>
                        <select name="status" class="form-control">
                            @php($status = old('status', $weaponInventory->status ?? 'in_store'))
                            <option value="in_store" @selected($status === 'in_store')>In Store</option>
                            <option value="issued" @selected($status === 'issued')>Issued Out</option>
                            <option value="maintenance" @selected($status === 'maintenance')>Maintenance</option>
                            <option value="retired" @selected($status === 'retired')>Retired</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Current Armory</label>
                        <select name="current_armory_id" class="form-control">
                            <option value="">Central Stores</option>
                            @foreach ($armories as $id => $label)
                                <option value="{{ $id }}" @selected(old('current_armory_id', $weaponInventory->current_armory_id ?? '') == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Audited</label>
                        <input type="date" name="last_audited_at" class="form-control" value="{{ old('last_audited_at', optional($weaponInventory->last_audited_at ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Condition Notes</label>
                        <textarea name="condition_notes" class="form-control" rows="3">{{ old('condition_notes', $weaponInventory->condition_notes ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ isset($weaponInventory) ? 'Update Serial' : 'Save Serial' }}</button>
                    <a href="{{ route('weapons.inventory.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
