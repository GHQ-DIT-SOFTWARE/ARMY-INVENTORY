@php
    $metrics = [
        ['label' => 'Categories', 'value' => $totals['categories'] ?? 0, 'hint' => 'Vehicle groupings'],
        ['label' => 'Sub Categories', 'value' => $totals['platforms'] ?? 0, 'hint' => 'Distinct vehicle types'],
        ['label' => 'Inventory', 'value' => $totals['inventory'] ?? 0, 'hint' => 'Tracked asset numbers'],
        ['label' => 'Available', 'value' => $totals['available'] ?? 0, 'hint' => 'In motor pools', 'badge' => 'success'],
        ['label' => 'Deployed', 'value' => $totals['deployed'] ?? 0, 'hint' => 'On mission', 'badge' => 'warning'],
        ['label' => 'Motor Pools', 'value' => $totals['motor_pools'] ?? 0, 'hint' => 'Fleet staging areas'],
    ];

    $deploymentEntries = collect($recentDeployments ?? []);
    $returnEntries = collect($dueReturns ?? []);
    $motorPoolEntries = collect($motorPoolStock ?? []);
    $categoryEntries = collect($categoryDistribution ?? []);
    $timelineEntries = collect($deploymentTimeline ?? []);
@endphp

<div class="row g-3">
    @foreach ($metrics as $metric)
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <span class="text-uppercase text-muted small">{{ $metric['label'] }}</span>
                    @php($classes = empty($metric['badge']) ? '' : 'text-' . $metric['badge'])
                    <h3 class="fw-bold mt-2 mb-0 {{ $classes }}">{{ number_format((int) $metric['value']) }}</h3>
                    <small class="text-muted">{{ $metric['hint'] }}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Recent Deployments</h5>
                    <small class="text-muted">Last six taskings</small>
                </div>
                @can('vehicles.deploy')
                    <a href="{{ route('vehicles.deployments.create') }}" class="btn btn-sm btn-success">Deploy Vehicles</a>
                @endcan
            </div>
            <div class="card-body">
                @forelse ($deploymentEntries as $deployment)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ optional(optional($deployment)->inventory->vehicle)->display_name ?? 'Vehicle removed' }}</span>
                            <span class="badge bg-success">{{ optional($deployment->motorPool)->name ?? 'No pool' }}</span>
                        </div>
                        <small class="text-muted">
                            {{ optional($deployment->deployed_at)->format('d M Y H:i') ?? 'Unknown date' }} - {{ optional($deployment->inventory)->asset_number ?? 'Unknown asset' }}
                        </small>
                    </div>
                @empty
                    <div class="text-center text-muted">No deployment records yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Returns Due</h5>
                    <small class="text-muted">Approaching commitments</small>
                </div>
                @can('vehicles.return')
                    <a href="{{ route('vehicles.returns.form') }}" class="btn btn-sm btn-outline-success">Process Return</a>
                @endcan
            </div>
            <div class="card-body">
                @forelse ($returnEntries as $due)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ optional(optional($due)->inventory->vehicle)->display_name ?? 'Vehicle removed' }}</span>
                            <span class="badge bg-warning text-dark">{{ optional($due->expected_return_at)->format('d M Y') ?? 'No date' }}</span>
                        </div>
                        <small class="text-muted">Mission {{ $due->mission_reference ?? 'N/A' }} - {{ optional($due->motorPool)->name ?? 'No pool' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No pending vehicle returns within the next 72 hours.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Motor Pool Holdings</h5>
                <small class="text-muted">Deployed vs total fleet</small>
            </div>
            <div class="card-body">
                @forelse ($motorPoolEntries as $pool)
                    @php($deployed = (int) ($pool->deployed_count ?? 0))
                    @php($total = (int) ($pool->total_count ?? 0))
                    @php($percent = $total > 0 ? round(($deployed / $total) * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $pool->name ?? 'Unknown pool' }}</span>
                            <span class="text-muted">{{ $deployed }}/{{ $total }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%"></div>
                        </div>
                        <small class="text-muted">{{ $pool->location ?? 'No location recorded' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No motor pools configured.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Category Concentration</h5>
                <small class="text-muted">Top five by sub-categories count</small>
            </div>
            <div class="card-body">
                @forelse ($categoryEntries as $category)
                    <div class="py-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $category->name ?? $category['category_name'] ?? 'Unassigned' }}</span>
                            <span class="text-muted">{{ number_format((int) ($category->vehicles_count ?? $category['vehicles_count'] ?? 0)) }} sub-categories</span>
                        </div>
                        <small class="text-muted">Description: {{ $category->unit_scope ?? $category['unit_scope'] ?? 'Unspecified' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No category analytics available.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Deployment Activity (14 days)</h5>
                <small class="text-muted">Volume trend by day</small>
            </div>
            <div class="card-body">
                @forelse ($timelineEntries as $row)
                    @php($countValue = (int) ($row['total'] ?? $row->total ?? $row['issued'] ?? $row->issued ?? 0))
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="fw-semibold">
                            {{ ($value = $row['day'] ?? $row->day ?? $row['label'] ?? $row->label ?? null)
                                ? \Carbon\Carbon::parse($value)->format('d M')
                                : 'Unknown' }}
                        </span>
                        <span class="badge bg-success">{{ number_format($countValue) }} deployment(s)</span>
                    </div>
                @empty
                    <div class="text-center text-muted">No deployments recorded during the window.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- @include('dashboard.widgets.quick-links', [
    'links' => $quickLinks ?? [],
    'title' => 'Quick Launch',
    'subtitle' => 'Access fleet workflows instantly',
]) --}}
