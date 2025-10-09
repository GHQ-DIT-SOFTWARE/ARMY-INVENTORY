@extends('admin.admin_master')
@section('title', 'Vehicle Categories')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Categories</h5>
                        <p class="text-white mb-0">Classify mobility assets for precise readiness reporting.</p>
                    </div>
                    <ul class="breadcrumb text-white">
                        <li class="breadcrumb-item text-white"><a href="{{ route('vehicles.dashboard') }}" class="text-white"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item text-white">Vehicles</li>
                        <li class="breadcrumb-item active text-white">Categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Configured Categories</h5>
            <a href="{{ route('vehicles.categories.create') }}" class="btn btn-sm btn-success">Add Category</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td>{{ $category->unit_scope }}</td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $category->is_active ? 'Serviceable' : 'Non-Serviceable' }}</span>
                                </td>
                                <td>{{ $category->description ?? 'ï¿½' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('vehicles.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form action="{{ route('vehicles.categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No vehicle categories configured.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>
@endsection

