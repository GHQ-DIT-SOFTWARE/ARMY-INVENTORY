@extends('admin.admin_master')
@section('title', 'Track Weapon Number')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Weapon Trace</h5>
                        <p class="text-muted mb-0">Instant insight into the current location and custody trail.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Track Weapon</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Search Weapon Number</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('weapons.issues.track') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Weapon Number</label>
                    <input type="text" name="weapon_number" class="form-control" value="{{ $search }}" placeholder="e.g. GAF-M16-00032" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Track Weapon</button>
                </div>
            </form>
        </div>
    </div>

    @if ($search)
        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Trace Result</h5>
                    <small class="text-muted">Weapon Number: {{ $search }}</small>
                </div>
            </div>
            <div class="card-body">
                @if ($result)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Weapon Profile</h6>
                            <p class="mb-1"><strong>{{ optional($result->weapon)->name }}</strong></p>
                            <p class="text-muted mb-0">Variant: {{ optional($result->weapon)->variant ?? '—' }}</p>
                            <p class="text-muted mb-0">Caliber: {{ optional($result->weapon)->caliber ?? '—' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Current Status</h6>
                            <p class="mb-1">{{ ucfirst(str_replace('_', ' ', $result->status)) }}</p>
                            <p class="text-muted mb-0">Current Armory: {{ optional($result->armory)->name ?? 'Central Stores' }}</p>
                            <p class="text-muted mb-0">Last Audited: {{ optional($result->last_audited_at)->format('d M Y H:i') ?? '—' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted">Acquisition</h6>
                            <p class="mb-1">Acquired: {{ optional($result->acquired_on)->format('d M Y') ?? '—' }}</p>
                            <p class="text-muted mb-0">Condition: {{ $result->condition_notes ?? 'No remarks' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-uppercase text-muted">Issue Timeline</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Issued At</th>
                                    <th>Armory</th>
                                    <th>Issued By</th>
                                    <th>Return Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($result->issueLogs as $log)
                                    <tr>
                                        <td>{{ optional($log->issued_at)->format('d M Y H:i') }}</td>
                                        <td>{{ optional($log->armory)->name }}</td>
                                        <td>{{ optional($log->issuer)->name ?? 'System' }}</td>
                                        <td>
                                            @if ($log->returned_at)
                                                <span class="badge bg-success">Returned {{ optional($log->returned_at)->format('d M Y') }}</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Outstanding</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted text-center">No issues recorded for this weapon.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">No weapon found with the number provided.</div>
                @endif
            </div>
        </div>
    @endif
@endsection
