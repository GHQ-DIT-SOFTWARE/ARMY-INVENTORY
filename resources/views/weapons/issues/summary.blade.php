@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issued Weapons Overview</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}">Weapons</a></li>
                        <li class="breadcrumb-item">Issued Weapons</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Issues</span>
                    <h3 class="mt-2 mb-1">{{ number_format($metrics['totalIssued']) }}</h3>
                    <span class="text-muted small">Historical weapon issues</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Currently Issued</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($metrics['currentlyIssued']) }}</h3>
                    <span class="text-muted small">Active allocations</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Overdue Returns</span>
                    <h3 class="mt-2 mb-1 text-danger">{{ number_format($metrics['overdue']) }}</h3>
                    <span class="text-muted small">Past due dates</span>
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
                    <h5 class="mb-0">Active Issues by Armory</h5>
                </div>
                <div class="card-body">
                    @if ($armoryBreakdown->isEmpty())
                        <p class="text-muted mb-0">No active issues recorded.</p>
                    @else
                        <ul class="list-unstyled mb-0">
                            @foreach ($armoryBreakdown as $row)
                                <li class="d-flex justify-content-between py-2 border-bottom">
                                    <span>{{ $row->armory }}</span>
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
                    <h5 class="mb-0">Currently Issued Weapons</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Weapon</th>
                                    <th>Weapon No.</th>
                                    <th>Armory</th>
                                    <th>Issued At</th>
                                    <th>Expected Return</th>
                                    <th>Issued By</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activeIssues as $index => $issue)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ optional(optional($issue->inventory)->weapon)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($issue->inventory)->weapon_number ?? 'N/A' }}</td>
                                        <td>{{ optional($issue->armory)->name ?? 'Unassigned' }}</td>
                                        <td>{{ optional($issue->issued_at)->format('d M Y H:i') ?? 'N/A' }}</td>
                                        <td>
                                            @if ($issue->expected_return_at)
                                                {{ $issue->expected_return_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">Not set</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($issue->issuer)->name ?? 'System' }}</td>
                                        <td>
                                            @if ($issue->expected_return_at && $issue->expected_return_at->isPast())
                                                <span class="badge badge-danger">Overdue</span>
                                            @else
                                                <span class="badge badge-info">{{ ucfirst($issue->status ?? 'issued') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No active issues recorded.</td>
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

