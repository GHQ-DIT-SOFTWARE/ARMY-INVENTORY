@extends('admin.admin_master')
@section('title', 'Armory Register')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">GAF Armories</h5>
                        <p class="text-muted mb-0">Authorized holding locations for weapon distribution.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Armories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Registered Armouries</h5>
            <a href="{{ route('weapons.armories.create') }}" class="btn btn-sm btn-primary">Add Armoury</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Armourer</th>
                            <th>Contact</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($armories as $armory)
                            <tr>
                                <td class="fw-semibold">{{ $armory->name }}</td>
                                <td>{{ $armory->code }}</td>
                                <td>{{ $armory->location ?? '' }}</td>
                                <td>{{ $armory->commanding_officer ?? '' }}</td>
                                <td>
                                    <div>{{ $armory->contact_number ?? '' }}</div>
                                    <small class="text-muted">{{ $armory->email ?? '' }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('weapons.armories.edit', $armory) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('weapons.armories.destroy', $armory) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this armory?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No armories have been registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $armories->links() }}
        </div>
    </div>
@endsection
