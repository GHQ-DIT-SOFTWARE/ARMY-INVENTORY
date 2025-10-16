@php
    $metrics = [
        ['label' => 'Catalog Items', 'value' => $totals['items'] ?? 0, 'hint' => 'Active inventory records', 'icon' => 'fas fa-boxes', 'color' => 'primary', 'trend' => 'up'],
        ['label' => 'General Control Strength', 'value' => $totals['stock_quantity'] ?? 0, 'hint' => 'Total units in store', 'icon' => 'fas fa-chart-line', 'color' => 'success', 'trend' => 'up'],
        ['label' => 'Pending Requests', 'value' => $totals['pending_requests'] ?? 0, 'hint' => 'Awaiting authorization', 'icon' => 'fas fa-clock', 'color' => 'warning', 'trend' => 'down'],
        ['label' => 'Issued Today', 'value' => $totals['issued_today'] ?? 0, 'hint' => 'Confirmed disbursements', 'icon' => 'fas fa-paper-plane', 'color' => 'info', 'trend' => 'up'],
        ['label' => 'Restocked (30 days)', 'value' => $totals['restocks_30_days'] ?? 0, 'hint' => 'Units replenished recently', 'icon' => 'fas fa-arrow-up', 'color' => 'purple', 'trend' => 'up'],
        ['label' => 'Lifetime Restocks', 'value' => $totals['restock_quantity'] ?? 0, 'hint' => 'Cumulative replenishments', 'icon' => 'fas fa-history', 'color' => 'teal', 'trend' => 'up'],
        ['label' => 'Suppliers', 'value' => $totals['suppliers'] ?? 0, 'hint' => 'Active vendor partners', 'icon' => 'fas fa-handshake', 'color' => 'orange', 'trend' => 'stable'],
        ['label' => 'Personnel', 'value' => $totals['personnel'] ?? 0, 'hint' => 'Registered stakeholders', 'icon' => 'fas fa-users', 'color' => 'pink', 'trend' => 'up'],
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

<div class="dashboard-container">
    <!-- Metrics Cards -->
    <div class="metrics-grid">
        @foreach ($metrics as $metric)
            <div class="metric-card-wrapper">
                <div class="metric-card card-{{ $metric['color'] }}">
                    <div class="metric-header">
                        <div class="metric-icon">
                            <i class="{{ $metric['icon'] }}"></i>
                        </div>
                        <div class="metric-trend trend-{{ $metric['trend'] ?? 'stable' }}">
                            <i class="fas fa-chevron-{{ $metric['trend'] === 'down' ? 'down' : 'up' }}"></i>
                        </div>
                    </div>
                    <div class="metric-content">
                        <h3 class="metric-value">{{ number_format((int) $metric['value']) }}</h3>
                        <p class="metric-label">{{ $metric['label'] }}</p>
                        <small class="metric-hint">{{ $metric['hint'] }}</small>
                    </div>
                    <div class="metric-wave"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Status Overview Cards -->
    <div class="dashboard-row">
        <!-- Low Stock Items -->
        <div class="dashboard-card card-warning">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Low Stock Items</h5>
                    <p>Closest to reorder threshold</p>
                </div>
                <span class="card-badge badge-danger">{{ $lowStockItemsList->count() }}</span>
            </div>
            <div class="card-content">
                @forelse ($lowStockItemsList as $item)
                    <div class="data-item">
                        <div class="item-info">
                            <span class="item-name">{{ $item['name'] ?? 'Unnamed' }}</span>
                            <span class="item-details">{{ $item['category'] ?? 'Unassigned' }} • {{ $item['subcategory'] ?? 'No subcategory' }}</span>
                        </div>
                        <span class="item-badge badge-danger">{{ $item['qty'] ?? 0 }}</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>Stock levels stable across catalog</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Issue Requests -->
        <div class="dashboard-card card-info">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Pending Issue Requests</h5>
                    <p>Awaiting approval or processing</p>
                </div>
                <span class="card-badge badge-warning">{{ $pendingIssues->count() }}</span>
            </div>
            <div class="card-content">
                @forelse ($pendingIssues as $issue)
                    <div class="data-item">
                        <div class="item-main">
                            <span class="item-name">{{ $issue['item'] ?? 'Item removed' }}</span>
                            <span class="item-badge badge-warning">{{ $issue['qty'] ?? 0 }}</span>
                        </div>
                        <div class="item-details">
                            <span>Invoice {{ $issue['invoice'] ?? 'N/A' }} • {{ $issue['requester'] ?? 'Unknown requester' }}</span>
                            <small>Requested {{ $issue['created_at'] ?? 'Unknown date' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>All requests have been cleared</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Restocks -->
        <div class="dashboard-card card-success">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Recent Restocks</h5>
                    <p>Most recent inbound deliveries</p>
                </div>
                <span class="card-badge badge-success">{{ $recentRestocksList->count() }}</span>
            </div>
            <div class="card-content">
                @forelse ($recentRestocksList as $restock)
                    <div class="data-item">
                        <div class="item-main">
                            <span class="item-name">{{ $restock['item'] ?? 'Item removed' }}</span>
                            <span class="item-badge badge-success">{{ $restock['qty'] ?? 0 }}</span>
                        </div>
                        <div class="item-details">
                            <span>{{ $restock['supplier'] ?? 'Unknown supplier' }} • {{ $restock['restock_date'] ?? 'No date' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-truck-loading"></i>
                        <p>No restock activity recorded yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="dashboard-row">
        <!-- Recently Issued -->
        <div class="dashboard-card card-primary">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Recently Issued</h5>
                    <p>Last confirmed outbound items</p>
                </div>
                <span class="card-badge badge-primary">{{ $recentlyIssuedList->count() }}</span>
            </div>
            <div class="card-content">
                @forelse ($recentlyIssuedList as $issue)
                    <div class="data-item">
                        <div class="item-info">
                            <span class="item-name">{{ $issue['item'] ?? 'Item removed' }}</span>
                            <span class="item-details">Invoice {{ $issue['invoice'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="item-stats">
                            <span class="item-badge badge-primary">{{ $issue['qty'] ?? 0 }}</span>
                            <small>{{ $issue['confirmed_issued'] ?? 'No date' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-shipping-fast"></i>
                        <p>No issue confirmations captured yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="dashboard-card card-purple">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Category Distribution</h5>
                    <p>Top groupings by stock</p>
                </div>
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="card-content">
                @forelse ($categoryEntries as $category)
                    <div class="data-item">
                        <div class="category-info">
                            <span class="category-name">{{ $category['category_name'] ?? 'Unassigned' }}</span>
                            <span class="category-value">{{ number_format((int) ($category['total_qty'] ?? 0)) }} units</span>
                        </div>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ min(100, (($category['total_qty'] ?? 0) / max(1, $categoryEntries->max('total_qty'))) * 100) }}%"></div>
                        </div>
                        <small class="category-count">{{ number_format((int) ($category['item_count'] ?? 0)) }} catalog items</small>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-tags"></i>
                        <p>No category analytics available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Trends Section -->
    <div class="dashboard-row">
        <!-- Monthly Issue Trend -->
        <div class="dashboard-card card-teal">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Monthly Issue Trend</h5>
                    <p>Issued vs pending (last 6 months)</p>
                </div>
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="card-content">
                <div class="trend-table">
                    <table>
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
                                    <td class="text-center trend-up">{{ $row['issued'] ?? 0 }}</td>
                                    <td class="text-center trend-warning">{{ $row['pending'] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-trend">
                                        <i class="fas fa-chart-line"></i>
                                        <span>Trend data not available</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Monthly Restock Trend -->
        <div class="dashboard-card card-orange">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Monthly Restock Trend</h5>
                    <p>Units replenished (last 6 months)</p>
                </div>
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-content">
                <div class="trend-table">
                    <table>
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
                                    <td class="text-end trend-up">{{ number_format((int) ($row['qty'] ?? 0)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-trend">
                                        <i class="fas fa-chart-area"></i>
                                        <span>Trend data not available</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status & Batches Section -->
    <div class="dashboard-row">
        <!-- Issue Status -->
        <div class="dashboard-card card-pink">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Issue Status</h5>
                    <p>Batch processing pipeline</p>
                </div>
                <i class="fas fa-tasks"></i>
            </div>
            <div class="card-content">
                @forelse ($issueStatus as $label => $count)
                    <div class="status-item">
                        <span class="status-label">{{ $label }}</span>
                        <span class="status-badge status-{{ strtolower($label) }}">{{ $count }}</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <p>No issue requests logged</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Aggregated Batches -->
        <div class="dashboard-card card-gradient">
            <div class="card-header">
                <div class="card-title-section">
                    <h5>Aggregated Batches</h5>
                    <p>Workflow summary</p>
                </div>
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="card-content">
                @if ($batchSummaryEntries->isNotEmpty())
                    <div class="batch-grid">
                        @foreach ($batchSummaryEntries as $batch)
                            <div class="batch-card">
                                <span class="batch-status">{{ $batch['status'] ?? 'Unknown' }}</span>
                                <h3 class="batch-count">{{ $batch['count'] ?? 0 }}</h3>
                                <div class="batch-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-boxes"></i>
                        <p>No aggregated batch activity recorded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    padding: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Color System */
:root {
    --primary: #3B82F6;
    --primary-light: #60A5FA;
    --success: #10B981;
    --success-light: #34D399;
    --warning: #F59E0B;
    --warning-light: #FBBF24;
    --danger: #EF4444;
    --danger-light: #F87171;
    --info: #06B6D4;
    --info-light: #22D3EE;
    --purple: #8B5CF6;
    --purple-light: #A78BFA;
    --teal: #14B8A6;
    --teal-light: #2DD4BF;
    --orange: #F97316;
    --orange-light: #FB923C;
    --pink: #EC4899;
    --pink-light: #F472B6;

    --text-primary: #1F2937;
    --text-secondary: #6B7280;
    --text-muted: #9CA3AF;
    --bg-light: #F9FAFB;
    --border-light: #E5E7EB;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Metrics Grid */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card-wrapper {
    perspective: 1000px;
}

.metric-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-light);
}

.metric-card:hover {
    transform: translateY(-8px) rotateX(5deg);
    box-shadow: var(--shadow-lg);
}

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.metric-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.metric-trend {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.trend-up { background: rgba(16, 185, 129, 0.1); color: var(--success); }
.trend-down { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
.trend-stable { background: rgba(107, 114, 128, 0.1); color: var(--text-secondary); }

.metric-content {
    position: relative;
    z-index: 2;
}

.metric-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    line-height: 1;
}

.metric-label {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.metric-hint {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.metric-wave {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 120px;
    height: 120px;
    opacity: 0.1;
    border-radius: 50%;
}

/* Card Color Variants */
.card-primary .metric-icon,
.card-primary .metric-wave { background: var(--primary); }
.card-success .metric-icon,
.card-success .metric-wave { background: var(--success); }
.card-warning .metric-icon,
.card-warning .metric-wave { background: var(--warning); }
.card-danger .metric-icon,
.card-danger .metric-wave { background: var(--danger); }
.card-info .metric-icon,
.card-info .metric-wave { background: var(--info); }
.card-purple .metric-icon,
.card-purple .metric-wave { background: var(--purple); }
.card-teal .metric-icon,
.card-teal .metric-wave { background: var(--teal); }
.card-orange .metric-icon,
.card-orange .metric-wave { background: var(--orange); }
.card-pink .metric-icon,
.card-pink .metric-wave { background: var(--pink); }

/* Dashboard Layout */
.dashboard-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.dashboard-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.card-title-section h5 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.card-title-section p {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.card-badge {
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
}

.badge-primary { background: var(--primary); }
.badge-success { background: var(--success); }
.badge-warning { background: var(--warning); }
.badge-danger { background: var(--danger); }

/* Data Items */
.data-item {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-light);
    transition: background-color 0.2s ease;
}

.data-item:hover {
    background-color: var(--bg-light);
    margin: 0 -1rem;
    padding: 1rem;
    border-radius: 12px;
    border-bottom: 1px solid transparent;
}

.data-item:last-child {
    border-bottom: none;
}

.item-main {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.item-info {
    flex: 1;
}

.item-name {
    font-weight: 600;
    color: var(--text-primary);
    display: block;
    margin-bottom: 0.25rem;
}

.item-details {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.item-stats {
    text-align: right;
}

.item-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

/* Category Items */
.category-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.category-name {
    font-weight: 600;
    color: var(--text-primary);
}

.category-value {
    font-weight: 700;
    color: var(--primary);
}

.progress-container {
    height: 6px;
    background: var(--border-light);
    border-radius: 3px;
    margin-bottom: 0.5rem;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
    border-radius: 3px;
    transition: width 0.5s ease;
}

.category-count {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Status Items */
.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-light);
}

.status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: 500;
    color: var(--text-primary);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
}

.status-issued { background: var(--success); }
.status-pending { background: var(--warning); }
.status-processing { background: var(--info); }

/* Batch Grid */
.batch-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.batch-card {
    background: var(--bg-light);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid var(--border-light);
}

.batch-card:hover {
    background: white;
    transform: translateY(-4px);
    box-shadow: var(--shadow);
}

.batch-status {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 0.5rem;
}

.batch-count {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    line-height: 1;
}

.batch-icon {
    color: var(--text-muted);
    font-size: 1.25rem;
}

/* Trend Tables */
.trend-table {
    overflow-x: auto;
}

.trend-table table {
    width: 100%;
    border-collapse: collapse;
}

.trend-table th {
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border-light);
}

.trend-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-light);
    font-weight: 500;
}

.trend-table tr:last-child td {
    border-bottom: none;
}

.trend-up {
    color: var(--success);
    font-weight: 700;
}

.trend-warning {
    color: var(--warning);
    font-weight: 700;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 1rem;
}

.empty-trend {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
}

.empty-trend i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
    opacity: 0.5;
}

/* Card Gradient Variant */
.card-gradient::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #3b82f6, #10b981);
}
.card-gradient .card-title-section h5,
.card-gradient .card-title-section p,
.card-gradient .card-header i {
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .metrics-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-row {
        grid-template-columns: 1fr;
    }

    .batch-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .metric-value {
        font-size: 2rem;
    }
}
</style>
