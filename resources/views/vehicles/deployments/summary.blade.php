@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Deployments Overview</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}">Vehicles</a></li>
                        <li class="breadcrumb-item">Deployed Vehicles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Deployments</span>
                    <h3 class="mt-2 mb-1">{{ number_format($metrics['totalDeployments']) }}</h3>
                    <span class="text-muted small">Historical deployments</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Active Deployments</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($metrics['activeDeployments']) }}</h3>
                    <span class="text-muted small">Currently deployed assets</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Overdue Returns</span>
                    <h3 class="mt-2 mb-1 text-danger">{{ number_format($metrics['overdueDeployments']) }}</h3>
                    <span class="text-muted small">Past expected dates</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Returned This Month</span>
                    <h3 class="mt-2 mb-1 text-success">{{ number_format($metrics['returnedThisMonth']) }}</h3>
                    <span class="text-muted small">Completed returns</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Active Deployments by Motor Pool</h5>
                </div>
                <div class="card-body">
                    @if ($motorPoolBreakdown->isEmpty())
                        <p class="text-muted mb-0">No active deployments recorded.</p>
                    @else
                        <ul class="list-unstyled mb-0">
                            @foreach ($motorPoolBreakdown as $row)
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>{{ $row->pool }}</span>
                                    <span class="font-weight-bold">{{ number_format($row->total) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Currently Deployed Vehicles</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle</th>
                                    <th>Asset No.</th>
                                    <th>Motor Pool</th>
                                    <th>Operator</th>
                                    <th>Deployed At</th>
                                    <th>Expected Return</th>
                                    <th>Issued By</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activeDeployments as $index => $deployment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ optional(optional($deployment->inventory)->vehicle)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($deployment->inventory)->asset_number ?? 'N/A' }}</td>
                                        <td>{{ optional($deployment->motorPool)->name ?? 'Unassigned' }}</td>
                                        <td>{{ optional($deployment->operator)->initial ?? optional($deployment->operator)->surname ?? 'N/A' }}</td>
                                        <td>{{ optional($deployment->deployed_at)->format('d M Y H:i') ?? 'N/A' }}</td>
                                        <td>
                                            @if ($deployment->expected_return_at)
                                                {{ $deployment->expected_return_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($deployment->issuer)->name ?? 'System' }}</td>
                                        <td>
                                            @if ($deployment->expected_return_at && $deployment->expected_return_at->isPast())
                                                <span class="badge badge-danger">Overdue</span>
                                            @else
                                                <span class="badge badge-info">{{ ucfirst($deployment->status ?? 'deployed') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">No active deployments recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

