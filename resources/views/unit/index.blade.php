@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Unit Summary</h5>
                        <p class="text-muted mb-0">Manage units and track their issued control items.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Controls</a></li>
                        <li class="breadcrumb-item">Units</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Units</span>
                    <h3 class="mt-2 mb-1">{{ number_format($summary['totalUnits']) }}</h3>
                    <span class="text-muted small">Registered destinations for control items</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Units With Active Issues</span>
                    <h3 class="mt-2 mb-1 text-warning">{{ number_format($summary['activeUnits']) }}</h3>
                    <span class="text-muted small">Issued items awaiting return</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Items Allocated To Units</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($summary['totalItemsIssued']) }}</h3>
                    <span class="text-muted small">Total quantity currently on unit loan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Unit Directory</h5>
                <span class="text-muted small">Manage, import, and track unit-level allocations.</span>
            </div>
            <div class="btn-group">
                <a href="{{ route('add-unit') }}" class="btn btn-primary"><i class="feather icon-plus"></i> Add Unit</a>
                <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#importUnitsModal">
                    <i class="feather icon-upload"></i> Import Units
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Unit Name</th>
                            <th>Issueance Count</th>
                            <th>Quantity Issued</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $index => $unit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $unit->unit_name }}</td>
                                <td>{{ number_format($unit->active_issue_count) }}</td>
                                <td>{{ number_format($unit->active_issue_qty) }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('edit-unit', $unit->uuid) }}">
                                        <i class="feather icon-edit"></i> Edit
                                    </a>
                                    <a class="btn btn-sm btn-outline-danger" href="{{ route('delete-unit', $unit->uuid) }}" id="delete">
                                        <i class="feather icon-trash-2"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No units available. Use the buttons above to add or import units.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importUnitsModal" tabindex="-1" role="dialog" aria-labelledby="importUnitsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importUnitsModalLabel">Import Units</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('import-units') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">Upload a CSV or Excel file to bulk add units.</p>
                        <div class="form-group">
                            <label for="unitImportFile">Select File</label>
                            <input type="file" class="form-control" id="unitImportFile" name="file" accept=".csv,.xlsx,.xls" required>
                        </div>
                        @error('file')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
