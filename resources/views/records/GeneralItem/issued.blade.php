@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Active General Item Loans</h5>
                        <p class="text-muted mb-0">Items currently on loan from the stock catalogue.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Issued Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="issued-page">
        <div class="loan-dashboard">
            <div class="loan-actions">
                <div class="actions-content">
                    <div>
                        <span class="section-eyebrow">Current Loans</span>
                        <h2 class="actions-title">General Items On Loan</h2>
                        <p class="actions-subtitle">Monitor active allocations and quickly process returns.</p>
                    </div>
                    <a href="{{ route('controls.general-items.issue') }}" class="btn-issue">
                        <i class="feather icon-plus"></i>
                        Issue Item
                    </a>
                </div>
            </div>

            @php
                $issueCollection = $issues instanceof \Illuminate\Support\Collection ? $issues : collect($issues);
                $activeLoans = $issueCollection->count();
                $totalQuantity = $issueCollection->sum('qty');
                $unitLoans = $issueCollection->whereNotNull('unit_id')->count();
                $personnelLoans = $issueCollection->whereNull('unit_id')->count();
            @endphp

            <div class="loan-stats">
                <div class="stat-card">
                    <span class="stat-label">Active Loans</span>
                    <span class="stat-value">{{ number_format($activeLoans) }}</span>
                    <span class="stat-hint">Records currently out</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Items Loaned</span>
                    <span class="stat-value">{{ number_format($totalQuantity) }}</span>
                    <span class="stat-hint">Units of inventory on loan</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Unit Allocations</span>
                    <span class="stat-value">{{ number_format($unitLoans) }}</span>
                    <span class="stat-hint">Issued to formations</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Personnel Loans</span>
                    <span class="stat-value">{{ number_format($personnelLoans) }}</span>
                    <span class="stat-hint">Issued to individuals</span>
                </div>
            </div>

            <div class="loan-table-card">
                <div class="table-wrapper">
                    <table class="loan-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Issued To</th>
                                <th>Type</th>
                                <th>Issued On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($issues as $index => $issue)
                                @php
                                    $isUnit = !is_null($issue->unit_id);
                                    $issuedTo = $isUnit ? optional($issue->unit)->unit_name : ($issue->description ?? 'Personnel');
                                    $issuedType = $isUnit ? 'Unit' : 'Personnel';
                                    $itemName = optional($issue->issuedoutitem)->item_name ?? 'N/A';
                                @endphp
                                <tr>
                                    <td data-label="#">#{{ $index + 1 }}</td>
                                    <td data-label="Invoice">{{ $issue->invoice_no ?? 'N/A' }}</td>
                                    <td data-label="Item">
                                        <div class="item-name">{{ $itemName }}</div>
                                        <small class="item-ref">Ref: {{ optional($issue->issuedoutitem)->item_code ?? 'N/A' }}</small>
                                    </td>
                                    <td data-label="Qty">
                                        <span class="qty-badge">{{ number_format($issue->qty) }}</span>
                                    </td>
                                    <td data-label="Issued To">
                                        <div class="recipient">
                                            <span class="recipient-name">{{ $issuedTo }}</span>
                                            <span class="recipient-id">{{ $issuedType }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Type">
                                        <span class="type-pill type-pill-{{ strtolower($issuedType) }}">{{ $issuedType }}</span>
                                    </td>
                                    <td data-label="Issued On">
                                        {{ optional($issue->date ?? $issue->created_at)->format('d M Y') }}
                                    </td>
                                    <td data-label="Action">
                                        <div class="action-buttons">
                                            <a href="{{ route('controls.general-items.show', $issue->id) }}" class="btn-action btn-view">
                                                <i class="feather icon-eye"></i>
                                                <span>View</span>
                                            </a>
                                            <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn-action btn-return">
                                                <i class="feather icon-log-in"></i>
                                                <span>Return</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-state">
                                        <div class="empty-card">
                                            <div class="empty-icon">
                                                <i class="feather icon-package"></i>
                                            </div>
                                            <h4>No active loans</h4>
                                            <p>All issued items have been accounted for. Issue a new item to see it appear here.</p>
                                            <a href="{{ route('controls.general-items.issue') }}" class="btn-empty-cta">
                                                <i class="feather icon-plus"></i>
                                                Issue an Item
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<style>
.issued-page {
    --surface: #ffffff;
    --surface-alt: #f6f8fc;
    --border: #e2e8f5;
    --text-primary: #1f2a44;
    --text-secondary: #546384;
    --text-muted: #8793ab;
    --primary: #4f6ef2;
    --primary-light: #e8edff;
    --primary-dark: #3f59d6;
    --accent: #47b9a3;
    --danger: #e5484d;
    --shadow-soft: 0 24px 60px -32px rgba(15, 23, 42, 0.45);
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.loan-dashboard {
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
}

.loan-actions {
    background: linear-gradient(135deg, rgba(79, 110, 242, 0.08) 0%, rgba(71, 185, 163, 0.12) 100%);
    border-radius: 24px;
    padding: 2.4rem;
    border: 1px solid rgba(79, 110, 242, 0.12);
    box-shadow: var(--shadow-soft);
}

.actions-content {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}

.section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.85rem;
    border-radius: 999px;
    background: rgba(79, 110, 242, 0.14);
    color: var(--primary-dark);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.actions-title {
    margin: 0;
    font-size: 2.1rem;
    font-weight: 700;
    color: var(--text-primary);
}

.actions-subtitle {
    margin: 0.35rem 0 0;
    color: var(--text-secondary);
    font-size: 1rem;
    max-width: 540px;
    line-height: 1.6;
}

.btn-issue {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.9rem 2rem;
    border-radius: 999px;
    background: var(--primary);
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 20px 40px -20px rgba(79, 110, 242, 0.45);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.btn-issue:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 25px 50px -22px rgba(79, 110, 242, 0.45);
}

.loan-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
}

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 18px 44px -30px rgba(79, 110, 242, 0.35);
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.stat-label {
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--text-muted);
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
}

.stat-hint {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.loan-table-card {
    background: var(--surface);
    border-radius: 24px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-soft);
}

.table-wrapper {
    overflow-x: auto;
}

.loan-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 920px;
}

.loan-table thead th {
    font-size: 0.75rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--text-muted);
    background: var(--surface-alt);
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border);
}

.loan-table tbody tr {
    transition: background 0.2s ease;
}

.loan-table tbody tr:hover {
    background: rgba(79, 110, 242, 0.04);
}

.loan-table tbody td {
    padding: 1.25rem;
    border-bottom: 1px solid var(--border);
    font-size: 0.95rem;
    color: var(--text-secondary);
    vertical-align: middle;
}

.loan-table tbody tr:last-child td {
    border-bottom: none;
}

.item-name {
    font-weight: 600;
    color: var(--text-primary);
}

.item-ref {
    display: block;
    color: var(--text-muted);
    margin-top: 0.3rem;
    font-size: 0.75rem;
}

.qty-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 3.2rem;
    padding: 0.4rem 0.75rem;
    border-radius: 999px;
    background: var(--primary-light);
    color: var(--primary-dark);
    font-weight: 700;
    font-size: 0.85rem;
}

.recipient {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.recipient-name {
    font-weight: 600;
    color: var(--text-primary);
}

.recipient-id {
    font-size: 0.78rem;
    color: var(--text-muted);
}

.type-pill {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.9rem;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.type-pill-unit {
    background: rgba(79, 110, 242, 0.12);
    color: var(--primary-dark);
}

.type-pill-personnel {
    background: rgba(71, 185, 163, 0.16);
    color: #2f8071;
}

.action-buttons {
    display: inline-flex;
    gap: 0.6rem;
    flex-wrap: wrap;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 1.1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid transparent;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.btn-action i {
    font-size: 0.9rem;
}

.btn-action.btn-view {
    background: #f3f5ff;
    color: var(--primary-dark);
    border-color: rgba(79, 110, 242, 0.24);
}

.btn-action.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px -24px rgba(79, 110, 242, 0.6);
}

.btn-action.btn-return {
    background: rgba(71, 185, 163, 0.14);
    color: #2f8071;
    border-color: rgba(71, 185, 163, 0.22);
}

.btn-action.btn-return:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px -24px rgba(71, 185, 163, 0.6);
}

.empty-state {
    padding: 3rem 1.5rem;
    text-align: center;
}

.empty-card {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 2.5rem 2rem;
    background: var(--surface-alt);
    border-radius: 22px;
    border: 1px dashed rgba(79, 110, 242, 0.2);
}

.empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(79, 110, 242, 0.1);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    box-shadow: 0 16px 40px -26px rgba(79, 110, 242, 0.6);
}

.empty-card h4 {
    margin: 0;
    font-size: 1.2rem;
    color: var(--text-primary);
}

.empty-card p {
    margin: 0;
    color: var(--text-secondary);
    max-width: 360px;
    line-height: 1.55;
}

.btn-empty-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.4rem;
    border-radius: 999px;
    background: var(--primary);
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    margin-top: 0.5rem;
}

.btn-empty-cta:hover {
    background: var(--primary-dark);
}

/* Responsive */
@media (max-width: 992px) {
    .loan-actions {
        padding: 2rem;
    }

    .loan-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .actions-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-issue {
        width: 100%;
        justify-content: center;
    }

    .loan-table {
        min-width: auto;
    }

    .loan-stats {
        grid-template-columns: 1fr;
    }

    .loan-table thead {
        display: none;
    }

    .loan-table tbody tr {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
        border-radius: 18px;
        margin-bottom: 1rem;
    }

    .loan-table tbody td {
        border: none;
        padding: 0;
    }

    .loan-table tbody td[data-label]::before {
        content: attr(data-label);
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        margin-bottom: 0.35rem;
        font-weight: 600;
    }

    .action-buttons {
        width: 100%;
    }

    .btn-action {
        flex: 1;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .loan-actions {
        padding: 1.75rem;
    }

    .issued-page {
        gap: 2rem;
    }

    .loan-dashboard {
        gap: 1.25rem;
    }

    .loan-table tbody tr {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .empty-card {
        padding: 2rem 1.75rem;
    }
}
</style>
@endsection



