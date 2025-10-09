@php
    $metrics = [
        ['label' => 'Catalog Items', 'value' => $totals['items'] ?? 0, 'hint' => 'Active inventory records'],
        ['label' => 'Available Stock', 'value' => $totals['stock_quantity'] ?? 0, 'hint' => 'Total units in store'],
        ['label' => 'Pending Requests', 'value' => $totals['pending_requests'] ?? 0, 'hint' => 'Awaiting authorization'],
        ['label' => 'Issued Today', 'value' => $totals['issued_today'] ?? 0, 'hint' => 'Confirmed disbursements'],
        ['label' => 'Restocked (30 days)', 'value' => $totals['restocks_30_days'] ?? 0, 'hint' => 'Units replenished recently'],
        ['label' => 'Lifetime Restocks', 'value' => $totals['restock_quantity'] ?? 0, 'hint' => 'Cumulative replenishments'],
        ['label' => 'Suppliers', 'value' => $totals['suppliers'] ?? 0, 'hint' => 'Active vendor partners'],
        ['label' => 'Personnel', 'value' => $totals['personnel'] ?? 0, 'hint' => 'Registered stakeholders'],
    ];

    $lowStockItemsList = collect($lowStockItems ?? [])->take(6);
    $pendingIssues = collect($pendingIssueRequests ?? [])->take(5);
    $recentRestocksList = collect($recentRestocks ?? [])->take(5);
    $recentlyIssuedList = collect($recentlyIssued ?? [])->take(6);
    $categoryEntries = collect($categoryDistribution ?? [])->take(5);
    $issueStatus = collect($issueStatusBreakdown ?? []);
    $monthlyIssueEntries = collect($monthlyIssueTrend ?? []);
    $restockTrendEntries = collect($restockTrend ?? []);
    $batchSummaryEntries = collect($batchedIssueSummary ?? []);
@endphp

<div class="row g-3">
    @foreach ($metrics as $metric)
        <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <span class="text-uppercase text-muted small">{{ $metric['label'] }}</span>
                    <h3 class="fw-bold mt-2 mb-0">{{ number_format((int) $metric['value']) }}</h3>
                    <small class="text-muted">{{ $metric['hint'] }}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Low Stock Items</h5>
                <small class="text-muted">Closest to reorder threshold</small>
            </div>
            <div class="card-body">
                @forelse ($lowStockItemsList as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <span class="fw-semibold d-block">{{ $item['name'] ?? 'Unnamed' }}</span>
                            <small class="text-muted">{{ $item['category'] ?? 'Unassigned' }} - {{ $item['subcategory'] ?? 'No subcategory' }}</small>
                        </div>
                        <span class="badge bg-danger">{{ $item['qty'] ?? 0 }}</span>
                    </div>
                @empty
                    <div class="text-muted text-center">Stock levels stable across catalog.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Pending Issue Requests</h5>
                <small class="text-muted">Awaiting approval or processing</small>
            </div>
            <div class="card-body">
                @forelse ($pendingIssues as $issue)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $issue['item'] ?? 'Item removed' }}</span>
                            <span class="badge bg-warning text-dark">{{ $issue['qty'] ?? 0 }}</span>
                        </div>
                        <small class="text-muted">Invoice {{ $issue['invoice'] ?? 'N/A' }} - {{ $issue['requester'] ?? 'Unknown requester' }}</small><br>
                        <small class="text-muted">Requested {{ $issue['created_at'] ?? 'Unknown date' }}</small>
                    </div>
                @empty
                    <div class="text-muted text-center">All requests have been cleared.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Recent Restocks</h5>
                <small class="text-muted">Most recent inbound deliveries</small>
            </div>
            <div class="card-body">
                @forelse ($recentRestocksList as $restock)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $restock['item'] ?? 'Item removed' }}</span>
                            <span class="badge bg-success">{{ $restock['qty'] ?? 0 }}</span>
                        </div>
                        <small class="text-muted">{{ $restock['supplier'] ?? 'Unknown supplier' }} - {{ $restock['restock_date'] ?? 'No date' }}</small>
                    </div>
                @empty
                    <div class="text-muted text-center">No restock activity recorded yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Recently Issued</h5>
                <small class="text-muted">Last confirmed outbound items</small>
            </div>
            <div class="card-body">
                @forelse ($recentlyIssuedList as $issue)
                    <div class="py-2 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-semibold d-block">{{ $issue['item'] ?? 'Item removed' }}</span>
                            <small class="text-muted">Invoice {{ $issue['invoice'] ?? 'Unknown' }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">{{ $issue['qty'] ?? 0 }}</span>
                            <div><small class="text-muted">{{ $issue['confirmed_issued'] ?? 'No date' }}</small></div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted text-center">No issue confirmations captured yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Category Distribution</h5>
                <small class="text-muted">Top groupings by stock</small>
            </div>
            <div class="card-body">
                @forelse ($categoryEntries as $category)
                    <div class="py-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $category['category_name'] ?? 'Unassigned' }}</span>
                            <span class="text-muted">{{ number_format((int) ($category['total_qty'] ?? 0)) }} units</span>
                        </div>
                        <small class="text-muted">{{ number_format((int) ($category['item_count'] ?? 0)) }} catalog items</small>
                    </div>
                @empty
                    <div class="text-muted text-center">No category analytics available.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-xl-6">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Monthly Issue Trend</h5>
                <small class="text-muted">Issued vs pending (last 6 months)</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-center">Issued</th>
                            <th class="text-center">Pending</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($monthlyIssueEntries as $row)
                            <tr>
                                <td>{{ $row['label'] ?? 'Unknown' }}</td>
                                <td class="text-center">{{ $row['issued'] ?? 0 }}</td>
                                <td class="text-center">{{ $row['pending'] ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Trend data not available.</td>
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
            <div class="card-header">
                <h5 class="mb-0">Monthly Restock Trend</h5>
                <small class="text-muted">Units replenished (last 6 months)</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-end">Qty</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($restockTrendEntries as $row)
                            <tr>
                                <td>{{ $row['label'] ?? 'Unknown' }}</td>
                                <td class="text-end">{{ number_format((int) ($row['qty'] ?? 0)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Trend data not available.</td>
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
            <div class="card-header">
                <h5 class="mb-0">Issue Status</h5>
                <small class="text-muted">Batch processing pipeline</small>
            </div>
            <div class="card-body">
                @forelse ($issueStatus as $label => $count)
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>{{ $label }}</span>
                        <span class="badge {{ strtolower($label) === 'issued' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $count }}</span>
                    </div>
                @empty
                    <div class="text-muted text-center">No issue requests logged.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h5 class="mb-0">Aggregated Batches</h5>
                <small class="text-muted">Workflow summary</small>
            </div>
            <div class="card-body">
                @if ($batchSummaryEntries->isNotEmpty())
                    <div class="row g-3">
                        @foreach ($batchSummaryEntries as $batch)
                            <div class="col-md-4 col-sm-6">
                                <div class="border rounded p-3 h-100">
                                    <span class="text-uppercase text-muted small">{{ $batch['status'] ?? 'Unknown' }}</span>
                                    <h4 class="fw-bold mt-1 mb-0">{{ $batch['count'] ?? 0 }}</h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted text-center">No aggregated batch activity recorded.</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- @include('dashboard.widgets.quick-links', [
    'links' => $quickLinks ?? [],
    'title' => 'Quick Actions',
    'subtitle' => 'Access the most-used workflows directly',
]) --}}
