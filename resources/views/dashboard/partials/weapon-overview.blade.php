@once
    <style>
        .dashboard-metric-card {
            transition: transform .2s ease, box-shadow .3s ease;
        }

        .dashboard-metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, .12);
        }

        .dashboard-spark {
            height: 6px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .dashboard-spark span {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #0d6efd, #4f8bf5);
        }

        .dashboard-timeline-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #0d6efd;
            margin-right: .75rem;
        }
    </style>
@endonce

@php
    $totals = $summary['totals'] ?? [];
    $recentIssues = collect($summary['recentIssues'] ?? []);
    $returnsDue = collect($summary['returnsDue'] ?? []);
    $armoryStock = collect($summary['armoryStock'] ?? []);
    $categoryDistribution = collect($summary['categoryDistribution'] ?? []);
    $statusTimeline = collect($summary['statusTimeline'] ?? []);
@endphp

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $sectionTitle ?? 'Weapons Command Center' }}</h5>
                    <p class="text-muted mb-0">{{ $sectionSubtitle ?? 'Realtime insight into stock position, demand signals and team workload.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Categories</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($totals['categories'] ?? 0) }}</h3>
                <small class="text-muted">Weapon groupings in scope</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Sub Category</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($totals['weapon_platforms'] ?? 0) }}</h3>
                <small class="text-muted">Distinct weapon type</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Inventory</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($totals['inventory'] ?? 0) }}</h3>
                <small class="text-muted">Serials under control</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Available</span>
                <h3 class="fw-bold mt-2 mb-0 text-success">{{ number_format($totals['available'] ?? 0) }}</h3>
                <small class="text-muted">Ready for tasking</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Issued</span>
                <h3 class="fw-bold mt-2 mb-0 text-warning">{{ number_format($totals['issued'] ?? 0) }}</h3>
                <small class="text-muted">Forward deployed</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card dashboard-metric-card shadow-sm h-100">
            <div class="card-body">
                <span class="text-uppercase text-muted small">Armories</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($totals['armories'] ?? 0) }}</h3>
                <small class="text-muted">Active receiving units</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Recent Issues</h5>
                    <small class="text-muted">Last six transactions</small>
                </div>
                @can('weapons.issue')
                    <a href="{{ route('weapons.issues.create') }}" class="btn btn-sm btn-primary">Issue Weapons</a>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0 align-middle">
                        <thead class="bg-light">
                        <tr>
                            <th>Weapon</th>
                            <th>Armory</th>
                            <th>Issued At</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentIssues as $log)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ optional(optional($log->inventory)->weapon)->name ?? 'Weapon removed' }}</span>
                                    <small class="text-muted d-block">{{ optional($log->inventory)->weapon_number ?? 'N/A' }}</small>
                                </td>
                                <td>{{ optional($log->armory)->name ?? 'No armory' }}</td>
                                <td>{{ optional($log->issued_at)->format('d M, H:i') ?? 'Unknown date' }}</td>
                                <td><span class="badge bg-primary">Issued</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No weapon issues have been recorded yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Returns Due</h5>
                    <small class="text-muted">Expiring commitments</small>
                </div>
                @can('weapons.return')
                    <a href="{{ route('weapons.returns.form') }}" class="btn btn-sm btn-outline-primary">Process Returns</a>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0 align-middle">
                        <thead class="bg-light">
                        <tr>
                            <th>Weapon</th>
                            <th>Armory</th>
                            <th>Due Back</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($returnsDue as $log)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ optional(optional($log->inventory)->weapon)->name ?? 'Weapon removed' }}</span>
                                    <small class="text-muted d-block">{{ optional($log->inventory)->weapon_number ?? 'N/A' }}</small>
                                </td>
                                <td>{{ optional($log->armory)->name ?? 'No armory' }}</td>
                                <td>{{ optional($log->expected_return_at)->format('d M, H:i') ?? 'Unknown date' }}</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No pending returns.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Armory Readiness</h5>
                <small class="text-muted">Issued holdings by location</small>
            </div>
            <div class="card-body">
                @forelse ($armoryStock as $armory)
                    @php($issuedCount = (int) ($armory->issued_count ?? 0))
                    @php($totalCount = (int) ($armory->total_count ?? 0))
                    @php($percent = $totalCount > 0 ? round(($issuedCount / $totalCount) * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $armory->name }}</span>
                            <span class="text-muted">{{ $issuedCount }}/{{ $totalCount }}</span>
                        </div>
                        <div class="dashboard-spark mt-1"><span style="width: {{ $percent }}%"></span></div>
                        <small class="text-muted">{{ $armory->location ?? 'No location set' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No armories configured.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Category Concentration</h5>
                <small class="text-muted">Top five by platform count</small>
            </div>
            <div class="card-body">
                @forelse ($categoryDistribution as $category)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $category->name ?? $category['category_name'] ?? 'Unassigned' }}</span>
                            <span class="text-muted">{{ number_format($category->weapons_count ?? $category['weapons_count'] ?? 0) }} platforms</span>
                        </div>
                        <small class="text-muted">Scope: {{ $category->unit_scope ?? 'N/A' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No category information recorded.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Issue Activity (14 days)</h5>
                <small class="text-muted">Volume trend by day</small>
            </div>
            <div class="card-body">
                                @forelse ( as )
                    @php( = (int) (['total'] ?? ->total ?? ['issued'] ?? ->issued ?? 0))
                    <div class=\"d-flex align-items-center mb-2\">
                        <span class=\"dashboard-timeline-dot\"></span>
                        <div class=\"flex-grow-1\">
                            <div class=\"d-flex justify-content-between\">
                                <span class=\"fw-semibold\">
                                    {{ ( = ['day'] ?? ->day ?? ['label'] ?? ->label ?? null)
                                        ? \\Carbon\\Carbon::parse()->format('d M')
                                        : '-' }}
                                </span>
                                <span class=\"text-muted\">{{ number_format() }} issue(s)</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted">No issues recorded in this window.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@include('dashboard.partials.quick-links', ['quickLinks' => $quickLinks ?? []])
