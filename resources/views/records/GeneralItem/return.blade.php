@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Return General Control Items</h5>
                        <p class="text-muted mb-0">Confirm the receipt of items that have been issued out.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Return Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="awaiting-returns-section">
        <div class="section-header">
            <div class="header-content">
                <div class="title-group">
                    <span class="eyebrow">Returns Queue</span>
                    <h3 class="section-title">Items Awaiting Return</h3>
                    <p class="section-subtitle">Track and manage items that need to be restored to inventory</p>
                </div>
                <div class="header-badge">
                    <span class="badge-count">{{ count($issues) }}</span>
                    <span class="badge-label">Pending Returns</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="action-btn btn-refresh" title="Refresh list">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="action-btn btn-filter" title="Filter results">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>

        @php
            $issueCollection = $issues instanceof \Illuminate\Support\Collection ? $issues : collect($issues);
            $overdueCount = $issueCollection->filter(function ($issue) {
                $daysAgo = \Carbon\Carbon::parse($issue->date ?? $issue->created_at)->diffInDays(now());
                return $daysAgo > 30;
            })->count();
            $unitReturns = $issueCollection->whereNotNull('unit_id')->count();
            $personnelReturns = $issueCollection->whereNull('unit_id')->count();
        @endphp

        <div class="returns-stats">
            <div class="stat-card">
                <span class="stat-label">Awaiting Confirmation</span>
                <span class="stat-value">{{ number_format($issueCollection->count()) }}</span>
                <span class="stat-hint">Open return records</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Potential Overdues</span>
                <span class="stat-value">{{ number_format($overdueCount) }}</span>
                <span class="stat-hint">More than 30 days out</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Unit Issues</span>
                <span class="stat-value">{{ number_format($unitReturns) }}</span>
                <span class="stat-hint">Waiting on formations</span>
            </div>
            <div class="stat-card">
                <span class="stat-label">Personnel Issues</span>
                <span class="stat-value">{{ number_format($personnelReturns) }}</span>
                <span class="stat-hint">Waiting on individuals</span>
            </div>
        </div>

    <div class="returns-table-container">
        @if($issues->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h4>All Items Returned</h4>
                <p>Great job! There are no items currently awaiting return.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="returns-table">
                    <thead>
                        <tr>
                            <th class="column-serial">
                                <span>#</span>
                            </th>
                            <th class="column-invoice">
                                <span>Invoice</span>
                                <i class="fas fa-sort"></i>
                            </th>
                            <th class="column-item">
                                <span>Item Details</span>
                            </th>
                            <th class="column-quantity">
                                <span>Qty</span>
                            </th>
                            <th class="column-recipient">
                                <span>Issued To</span>
                            </th>
                            <th class="column-type">
                                <span>Type</span>
                            </th>
                            <th class="column-date">
                                <span>Issued On</span>
                                <i class="fas fa-sort"></i>
                            </th>
                            <th class="column-actions">
                                <span>Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($issues as $index => $issue)
                            @php
                                $isUnit = !is_null($issue->unit_id);
                                $issuedTo = $isUnit ? optional($issue->unit)->unit_name : ($issue->description ?? 'Personnel');
                                $issuedType = $isUnit ? 'Unit' : 'Personnel';
                                $itemName = optional($issue->issuedoutitem)->item_name ?? 'N/A';
                                $daysAgo = \Carbon\Carbon::parse($issue->date ?? $issue->created_at)->diffInDays(now());
                                $isOverdue = $daysAgo > 30;
                            @endphp
                            <tr class="return-item {{ $isOverdue ? 'overdue' : '' }}">
                                <td class="serial-cell">
                                    <span class="serial-number">{{ $index + 1 }}</span>
                                </td>
                                <td class="invoice-cell">
                                    <div class="invoice-info">
                                        <span class="invoice-number">{{ $issue->invoice_no ?? 'N/A' }}</span>
                                        @if($isOverdue)
                                            <span class="overdue-badge">Overdue</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="item-cell">
                                    <div class="item-info">
                                        <span class="item-name">{{ $itemName }}</span>
                                        <span class="item-category">General Item</span>
                                    </div>
                                </td>
                                <td class="quantity-cell">
                                    <span class="quantity-badge">{{ number_format($issue->qty) }}</span>
                                </td>
                                <td class="recipient-cell">
                                    <div class="recipient-info">
                                        <i class="fas {{ $isUnit ? 'fa-building' : 'fa-user' }} recipient-icon"></i>
                                        <span class="recipient-name">{{ $issuedTo }}</span>
                                    </div>
                                </td>
                                <td class="type-cell">
                                    <span class="type-badge type-{{ strtolower($issuedType) }}">
                                        {{ $issuedType }}
                                    </span>
                                </td>
                                <td class="date-cell">
                                    <div class="date-info">
                                        <span class="issue-date">{{ optional($issue->date ?? $issue->created_at)->format('d M Y') }}</span>
                                        <span class="days-ago">{{ $daysAgo }} days ago</span>
                                    </div>
                                </td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('controls.general-items.show', $issue->id) }}" class="btn-action btn-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn-action btn-return" title="Mark as Returned">
                                            <i class="fas fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div class="footer-info">
                    <span class="info-text">Showing {{ count($issues) }} pending returns</span>
                </div>
                <div class="footer-actions">
                    <button class="btn-secondary btn-export">
                        <i class="fas fa-download"></i>
                        Export List
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.awaiting-returns-section {
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
    overflow: hidden;
    border: 1px solid #e4eaf6;
}

/* Header Styles */
.section-header {
    background: linear-gradient(135deg, rgba(79, 110, 242, 0.18) 0%, rgba(71, 185, 163, 0.22) 100%);
    padding: 2.25rem 2.75rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #1f2a44;
}

.header-content {
    display: flex;
    align-items: flex-start;
    gap: 1.75rem;
    flex-wrap: wrap;
}

.title-group {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

.title-group .section-title {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #0f172a;
}

.title-group .section-subtitle {
    margin: 0.1rem 0 0;
    opacity: 0.75;
    font-size: 1rem;
    color: #334155;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    background: rgba(79, 110, 242, 0.16);
    color: #3f59d6;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.header-badge {
    background: rgba(255, 255, 255, 0.4);
    padding: 0.65rem 1.2rem;
    border-radius: 16px;
    text-align: center;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(79, 110, 242, 0.2);
    box-shadow: 0 12px 36px -28px rgba(79, 110, 242, 0.6);
}

.badge-count {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
    color: #0f172a;
}

.badge-label {
    font-size: 0.8rem;
    opacity: 0.8;
    color: #1f2a44;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.action-btn {
    background: rgba(255, 255, 255, 0.6);
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    color: #3f59d6;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(16px);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px -20px rgba(79, 110, 242, 0.6);
}

.action-btn:hover {
    background: rgba(79, 110, 242, 0.15);
    transform: translateY(-2px);
    color: #2a3fb0;
}

.returns-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    padding: 2rem 2.75rem 1.5rem;
}

.stat-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e4eaf6;
    padding: 1.65rem;
    box-shadow: 0 22px 60px -38px rgba(79, 110, 242, 0.4);
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.stat-label {
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
}

.stat-value {
    font-size: 1.85rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.2;
}

.stat-hint {
    font-size: 0.85rem;
    color: #475569;
}

/* Table Container */
.returns-table-container {
    padding: 0 2.75rem 2.5rem;
}

.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: #64748b;
}

.empty-icon {
    font-size: 3.5rem;
    margin-bottom: 1rem;
    opacity: 0.55;
    color: #3f59d6;
}

.empty-state h4 {
    margin: 0 0 0.5rem 0;
    color: #1f2a44;
    font-size: 1.4rem;
}

.empty-state p {
    margin: 0;
    opacity: 0.7;
}

/* Table Styles */
.table-wrapper {
    overflow-x: auto;
}

.returns-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 18px 48px -38px rgba(15, 23, 42, 0.4);
}

.returns-table thead {
    background: #f8faff;
    border-bottom: 1px solid #e5ecfb;
}

.returns-table th {
    padding: 1.15rem 1.5rem;
    text-align: left;
    font-weight: 700;
    color: #475569;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    white-space: nowrap;
}

.returns-table th span {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
}

.returns-table th i {
    opacity: 0.45;
    font-size: 0.75rem;
    color: #6b7280;
}

.returns-table tbody tr {
    border-bottom: 1px solid #eef2ff;
    transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
}

.returns-table tbody tr:hover {
    background: #f5f8ff;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px -24px rgba(79, 110, 242, 0.35);
}

.returns-table tbody tr.overdue {
    background: linear-gradient(90deg, rgba(255, 211, 182, 0.25) 0%, rgba(255, 255, 255, 0.8) 100%);
    border-left: 4px solid #f97316;
}

.returns-table tbody tr.overdue:hover {
    background: linear-gradient(90deg, rgba(255, 211, 182, 0.35) 0%, rgba(245, 248, 255, 0.95) 100%);
}

.returns-table td {
    padding: 1.2rem 1.5rem;
    vertical-align: middle;
}

/* Column Specific Styles */
.serial-cell {
    text-align: center;
}

.serial-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: #eef2ff;
    border-radius: 10px;
    font-weight: 600;
    color: #3f59d6;
    font-size: 0.85rem;
}

.invoice-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.invoice-number {
    font-weight: 600;
    color: #1f2a44;
    font-family: 'JetBrains Mono', 'Menlo', monospace;
    font-size: 0.95rem;
}

.overdue-badge {
    background: rgba(239, 68, 68, 0.16);
    color: #b91c1c;
    padding: 0.25rem 0.55rem;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    align-self: flex-start;
}

.item-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.item-name {
    font-weight: 600;
    color: #1f2a44;
    font-size: 0.95rem;
}

.item-category {
    font-size: 0.75rem;
    color: #52607d;
    background: #eef2ff;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    align-self: flex-start;
}

.quantity-badge {
    background: rgba(79, 110, 242, 0.12);
    color: #3f59d6;
    padding: 0.45rem 0.85rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.85rem;
    display: inline-block;
}

.recipient-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.recipient-icon {
    color: #94a3b8;
    font-size: 0.9rem;
}

.recipient-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9rem;
}

.type-badge {
    padding: 0.45rem 0.85rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.type-unit {
    background: rgba(59, 130, 246, 0.12);
    color: #1d4ed8;
}

.type-personnel {
    background: rgba(14, 165, 233, 0.14);
    color: #075985;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.issue-date {
    font-weight: 600;
    color: #1f2a44;
    font-size: 0.9rem;
}

.days-ago {
    font-size: 0.78rem;
    color: #64748b;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.65rem;
    justify-content: center;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    box-shadow: 0 12px 28px -24px rgba(79, 110, 242, 0.6);
}

.btn-view {
    background: #eef2ff;
    color: #3f59d6;
}

.btn-view:hover {
    background: rgba(79, 110, 242, 0.18);
    color: #2a3fb0;
    transform: translateY(-2px);
}

.btn-return {
    background: rgba(71, 185, 163, 0.16);
    color: #2f8071;
}

.btn-return:hover {
    background: rgba(71, 185, 163, 0.26);
    transform: translateY(-2px);
    box-shadow: 0 14px 32px -24px rgba(71, 185, 163, 0.55);
}

/* Table Footer */
.table-footer {
    padding: 1.75rem 2.75rem;
    background: #f5f8ff;
    border-top: 1px solid #e5ecfb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-info .info-text {
    color: #64748b;
    font-size: 0.85rem;
}

.btn-secondary {
    background: #ffffff;
    border: 1px solid rgba(79, 110, 242, 0.25);
    color: #3f59d6;
    padding: 0.75rem 1.5rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 16px 40px -30px rgba(79, 110, 242, 0.5);
}

.btn-secondary:hover {
    background: rgba(79, 110, 242, 0.08);
    border-color: rgba(79, 110, 242, 0.35);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .header-content {
        flex-direction: column;
        gap: 1rem;
    }

    .returns-table th,
    .returns-table td {
        padding: 1rem;
    }

    .returns-stats {
        padding: 1.75rem 2rem 1.25rem;
        gap: 1.25rem;
    }
}

@media (max-width: 900px) {
    .returns-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .section-header {
        padding: 1.75rem;
    }

    .table-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .returns-table {
        font-size: 0.875rem;
    }

    .returns-table th span {
        font-size: 0.75rem;
    }

    .returns-stats {
        grid-template-columns: 1fr;
        padding: 1.5rem;
    }
}

@media (max-width: 576px) {
    .awaiting-returns-section {
        border-radius: 20px;
    }

    .section-header {
        padding: 1.5rem;
    }

    .returns-table-container {
        padding: 0 1.5rem 2rem;
    }

    .table-wrapper {
        margin: 0 -1rem;
    }

    .table-footer {
        padding: 1.4rem 1.5rem;
    }
}
</style>
@endsection
