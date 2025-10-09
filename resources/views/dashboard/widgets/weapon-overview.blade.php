@php
    $metrics = [
        ['label' => 'Categories', 'value' => $totals['categories'] ?? 0, 'hint' => 'Weapon groupings'],
        ['label' => 'Sub Category', 'value' => $totals['weapon_platforms'] ?? 0, 'hint' => 'Distinct weapon type'],
        ['label' => 'Inventory', 'value' => $totals['inventory'] ?? 0, 'hint' => 'Unique serialised weapons'],
        ['label' => 'Available', 'value' => $totals['available'] ?? 0, 'hint' => 'Ready for tasking', 'badge' => 'success'],
        ['label' => 'Issued Out', 'value' => $totals['issued'] ?? 0, 'hint' => 'Forward deployed', 'badge' => 'warning'],
        ['label' => 'Armories', 'value' => $totals['armories'] ?? 0, 'hint' => 'Receiving locations'],
    ];

    $recentIssuesList = collect($recentIssues ?? []);
    $returnsDueList = collect($returnsDue ?? []);
    $armoryEntries = collect($armoryStock ?? []);
    $categoryEntries = collect($categoryDistribution ?? []);
    $timelineEntries = collect($statusTimeline ?? []);
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
                    <h5 class="mb-0">Recent Issues</h5>
                    <small class="text-muted">Last six transactions</small>
                </div>
                @can('weapons.issue')
                    <a href="{{ route('weapons.issues.create') }}" class="btn btn-sm btn-primary">Issue Weapons</a>
                @endcan
            </div>
            <div class="card-body">
                @forelse ($recentIssuesList as $log)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ optional(optional($log)->inventory->weapon)->name ?? 'Weapon removed' }}</span>
                            <span class="badge bg-primary text-white">{{ optional($log->inventory)->weapon_number ?? 'N/A' }}</span>
                        </div>
                        <small class="text-muted">
                            {{ $log->issued_at ? \Carbon\Carbon::parse($log->issued_at)->format('d M Y H:i') : 'Unknown date' }}
                            - {{ optional($log->armory)->name ?? 'No armory' }}
                        </small>
                    </div>
                @empty
                    <div class="text-center text-muted">No weapon issues have been recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Returns Due</h5>
                    <small class="text-muted">Expiring commitments</small>
                </div>
                @can('weapons.return')
                    <a href="{{ route('weapons.returns.form') }}" class="btn btn-sm btn-outline-primary">Process Returns</a>
                @endcan
            </div>
            <div class="card-body">
                @forelse ($returnsDueList as $due)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ optional(optional($due)->inventory->weapon)->name ?? 'Weapon removed' }}</span>
                            <span class="badge bg-warning text-dark">{{ optional($due->expected_return_at)->format('d M Y') ?? 'No date' }}</span>
                        </div>
                        <small class="text-muted">{{ optional($due->inventory)->weapon_number ?? 'Unknown serial' }} - {{ optional($due->armory)->name ?? 'No armory' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No pending returns within the next 72 hours.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Armory Readiness</h5>
                <small class="text-muted">Issued holdings by location</small>
            </div>
            <div class="card-body">
                @forelse ($armoryEntries as $entry)
                    @php($issuedCount = (int) ($entry->issued_count ?? 0))
                    @php($totalCount = (int) ($entry->total_count ?? 0))
                    @php($percent = $totalCount > 0 ? round(($issuedCount / $totalCount) * 100) : 0)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $entry->name ?? 'Unknown armory' }}</span>
                            <span class="text-muted">{{ $issuedCount }}/{{ $totalCount }}</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%"></div>
                        </div>
                        <small class="text-muted">{{ $entry->location ?? 'Unknown location' }}</small>
                    </div>
                @empty
                    <div class="text-center text-muted">No armories configured.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Category Concentration</h5>
                <small class="text-muted">Top five by platform count</small>
            </div>
            <div class="card-body">
                @forelse ($categoryEntries as $category)
                    <div class="py-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $category->name ?? $category['category_name'] ?? 'Unassigned' }}</span>
                            <span class="text-muted">{{ number_format((int) ($category->weapons_count ?? $category['weapons_count'] ?? 0)) }} platforms</span>
                        </div>
                        <small class="text-muted">Scope: {{ $category->unit_scope ?? $category['unit_scope'] ?? 'Unspecified' }}</small>
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
                <h5 class="mb-0">Issue Activity (14 days)</h5>
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
                        <span class="badge bg-primary text-white">{{ number_format($countValue) }} issue(s)</span>
                    </div>
                @empty
                    <div class="text-center text-muted">No weapon issues recorded during the window.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- @include('dashboard.widgets.quick-links', [
    'links' => $quickLinks ?? [],
    'title' => 'Quick Launch',
    'subtitle' => 'Most-used workflows',
]) --}}
