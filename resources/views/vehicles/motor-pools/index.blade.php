@extends('admin.admin_master')
@section('title', 'Motor Pools')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Motor Pools</h5>
                        <p class="text-muted mb-0">Manage fleet staging areas and contact information.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Vehicles</li>
                        <li class="breadcrumb-item active">Motor Pools</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Registered Motor Pools</h5>
            <a href="{{ route('vehicles.motor-pools.create') }}" class="btn btn-sm btn-success">Add Motor Pool</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Fleet Manager</th>
                            <th>Contact</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($motorPools as $pool)
                            <tr>
                                <td class="fw-semibold">{{ $pool->name }}</td>
                                <td>{{ $pool->code }}</td>
                                <td>{{ $pool->location ?? '—' }}</td>
                                <td>{{ $pool->fleet_manager ?? '—' }}</td>
                                <td>
                                    <div>{{ $pool->contact_number ?? '—' }}</div>
                                    <small class="text-muted">{{ $pool->email ?? '' }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('vehicles.motor-pools.edit', $pool) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('vehicles.motor-pools.destroy', $pool) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this motor pool?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No motor pools have been registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $motorPools->links() }}
        </div>
    </div>
@endsection
