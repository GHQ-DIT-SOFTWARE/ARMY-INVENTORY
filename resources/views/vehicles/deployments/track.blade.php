@extends('admin.admin_master')
@section('title', 'Track Vehicle Asset')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Tracking</h5>
                        <p class="text-muted mb-0">Determine the current location and deployment trail instantly.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Vehicles</li>
                        <li class="breadcrumb-item active">Track Asset</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Search Asset Number</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('vehicles.deployments.track') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Asset Number</label>
                    <input type="text" name="asset_number" class="form-control" value="{{ $search }}" placeholder="e.g. GAF-APC-1021" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Track Asset</button>
                </div>
            </form>
        </div>
    </div>

    @if ($search)
        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Trace Result</h5>
                    <small class="text-muted">Asset Number: {{ $search }}</small>
                </div>
            </div>
            <div class="card-body">
                @if ($result)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Vehicle Profile</h6>
                            <p class="mb-1"><strong>{{ optional($result->vehicle)->name }}</strong></p>
                            <p class="text-muted mb-0">Variant: {{ optional($result->vehicle)->variant ?? '—' }}</p>
                            <p class="text-muted mb-0">Manufacturer: {{ optional($result->vehicle)->manufacturer ?? '—' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Current Status</h6>
                            <p class="mb-1">{{ ucfirst(str_replace('_', ' ', $result->status)) }}</p>
                            <p class="text-muted mb-0">Motor Pool: {{ optional($result->motorPool)->name ?? 'Central Garage' }}</p>
                            <p class="text-muted mb-0">Last Serviced: {{ optional($result->last_serviced_at)->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Acquisition</h6>
                            <p class="mb-1">Acquired: {{ optional($result->acquired_on)->format('d M Y') ?? '—' }}</p>
                            <p class="text-muted mb-0">Condition: {{ $result->condition_notes ?? 'No remarks' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-uppercase text-muted">Deployment Timeline</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Deployed At</th>
                                    <th>Motor Pool</th>
                                    <th>Issued By</th>
                                    <th>Return Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($result->deployments as $deployment)
                                    <tr>
                                        <td>{{ optional($deployment->deployed_at)->format('d M Y H:i') }}</td>
                                        <td>{{ optional($deployment->motorPool)->name }}</td>
                                        <td>{{ optional($deployment->issuer)->name ?? 'System' }}</td>
                                        <td>
                                            @if ($deployment->returned_at)
                                                <span class="badge bg-success">Returned {{ optional($deployment->returned_at)->format('d M Y') }}</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Outstanding</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted text-center">No deployments recorded for this asset.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">No vehicle found with the asset number provided.</div>
                @endif
            </div>
        </div>
    @endif
@endsection
