@extends('admin.admin_master')
@section('title', 'Weapon Inventory')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Weapon Serial Register</h5>
                        <p class="text-muted mb-0">Track every unique weapon number across the force.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form class="d-flex" method="GET" action="{{ route('weapons.inventory.index') }}">
                <input type="text" name="search" class="form-control" placeholder="Search weapon number" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary ms-2">Search</button>
            </form>
            <a href="{{ route('weapons.inventory.create') }}" class="btn btn-sm btn-primary">Add Weapon Items</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Weapon</th>
                            <th>Weapon Number</th>
                            <th>Status</th>
                            <th>Current Armory</th>
                            <th>Acquired</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventories as $inventory)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ optional($inventory->weapon)->name }}</span>
                                    <small class="d-block text-muted">{{ optional($inventory->weapon)->variant }}</small>
                                </td>
                                <td>{{ $inventory->weapon_number }}</td>
                                <td>
                                    @php($status = $inventory->status ?? 'in_store')
                                    <span class="badge {{ $status === 'issued' ? 'bg-warning text-dark' : ($status === 'maintenance' ? 'bg-info text-dark' : 'bg-success') }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td>{{ optional($inventory->armory)->name ?? 'Central Stores' }}</td>
                                <td>{{ optional($inventory->acquired_on)->format('d M Y') ?: '�' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('weapons.inventory.edit', $inventory) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('weapons.inventory.destroy', $inventory) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this serial record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No weapon inventory captured yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $inventories->links() }}
        </div>
    </div>
@endsection
