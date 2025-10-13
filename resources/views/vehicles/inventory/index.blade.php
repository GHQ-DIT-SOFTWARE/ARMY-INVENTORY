@extends('admin.admin_master')
@section('title', 'Vehicle Inventory')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Items Register</h5>
                        <p class="text-muted mb-0">Unique vehicle numbers and current disposition.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Vehicles</li>
                        <li class="breadcrumb-item active">Inventory</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form class="d-flex" method="GET" action="{{ route('vehicles.inventory.index') }}">
                <input type="text" name="search" class="form-control" placeholder="Search asset number" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-success ms-2">Search</button>
            </form>
            <a href="{{ route('vehicles.inventory.create') }}" class="btn btn-sm btn-success">Add Vehicle Item</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>VIN</th>
                            <th>Status</th>
                            <th>Supply Point Depo</th>
                            <th>Acquired</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventories as $inventory)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ optional($inventory->vehicle)->name }}</span>
                                    <small class="d-block text-muted">{{ optional($inventory->vehicle)->variant }}</small>
                                </td>
                                <td>{{ $inventory->asset_number }}</td>
                                <td>
                                    @php($status = $inventory->status ?? 'in_pool')
                                    <span class="badge {{ $status === 'deployed' ? 'bg-warning text-dark' : ($status === 'maintenance' ? 'bg-info text-dark' : 'bg-success') }}">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td>{{ optional($inventory->motorPool)->name ?? 'Central Garage' }}</td>
                                <td>{{ optional($inventory->acquired_on)->format('d M Y') ?: '�' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('vehicles.inventory.edit', $inventory) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('vehicles.inventory.destroy', $inventory) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this asset record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No vehicle assets captured yet.</td>
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
