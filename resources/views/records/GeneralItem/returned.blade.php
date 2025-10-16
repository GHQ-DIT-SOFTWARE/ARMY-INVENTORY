@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Returned General Control Items</h5>
                        <p class="text-muted mb-0">Audit trail of items that have been confirmed as returned.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Returned Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="returned-items-panel">
        <div class="panel-header">
            <div class="header-info">
                <div>
                    <span class="header-eyebrow">Return History</span>
                    <h3 class="header-title">Confirmed Returns</h3>
                    <p class="header-subtitle">Review every item that has been reconciled back into inventory.</p>
                </div>
                <a href="{{ route('controls.general-items.issue') }}" class="btn-issue">
                    <i class="feather icon-plus"></i>
                    Issue New Item
                </a>
            </div>

            @php
                $issueCollection = $issues instanceof \Illuminate\Support\Collection ? $issues : collect($issues);
                $totalReturns = $issueCollection->count();
                $totalQty = $issueCollection->sum('qty');
                $lastReturn = $issueCollection->sortByDesc('confirmed_issued')->first();
                $lastReturnAt = $lastReturn ? optional($lastReturn->confirmed_issued)->format('d M Y') : null;
            @endphp

            <div class="header-stats">
                <div class="stat-card">
                    <span class="stat-label">Completed Returns</span>
                    <span class="stat-value">{{ number_format($totalReturns) }}</span>
                    <span class="stat-hint">Records reconciled</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Items Processed</span>
                    <span class="stat-value">{{ number_format($totalQty) }}</span>
                    <span class="stat-hint">Total quantity returned</span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Last Return</span>
                    <span class="stat-value">{{ $lastReturnAt ?? '—' }}</span>
                    <span class="stat-hint">Most recent confirmation</span>
                </div>
            </div>
        </div>

        <div class="table-container">
            @if ($issues->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="feather icon-archive"></i>
                    </div>
                    <h4>No returned items yet</h4>
                    <p>Once items are confirmed back into stock, their history will appear here.</p>
                    <a href="{{ route('controls.general-items.issue') }}" class="btn-empty-cta">
                        <i class="feather icon-plus"></i>
                        Issue an Item
                    </a>
                </div>
            @else
                <div class="table-wrapper">
                    <table class="returns-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Issued To</th>
                                <th>Type</th>
                                <th>Issued On</th>
                                <th>Returned On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $index => $issue)
                                @php
                                    $isUnit = ! is_null($issue->unit_id);
                                    $issuedTo = $isUnit ? optional($issue->unit)->unit_name : ($issue->description ?? 'Personnel');
                                    $issuedType = $isUnit ? 'Unit' : 'Personnel';
                                    $itemName = optional($issue->issuedoutitem)->item_name ?? 'N/A';
                                @endphp
                                <tr>
                                    <td data-label="#">#{{ $index + 1 }}</td>
                                    <td data-label="Invoice">
                                        <span class="invoice-number">{{ $issue->invoice_no ?? 'N/A' }}</span>
                                    </td>
                                    <td data-label="Item">
                                        <div class="item-info">
                                            <span class="item-name">{{ $itemName }}</span>
                                            <small class="item-meta">ID: {{ optional($issue->issuedoutitem)->item_code ?? '—' }}</small>
                                        </div>
                                    </td>
                                    <td data-label="Qty">
                                        <span class="qty-badge">{{ number_format($issue->qty) }}</span>
                                    </td>
                                    <td data-label="Issued To">
                                        <div class="recipient-info">
                                            <i class="feather {{ $isUnit ? 'icon-briefcase' : 'icon-user' }}"></i>
                                            <span>{{ $issuedTo }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Type">
                                        <span class="type-pill type-pill-{{ strtolower($issuedType) }}">{{ $issuedType }}</span>
                                    </td>
                                    <td data-label="Issued On">
                                        {{ optional($issue->date ?? $issue->created_at)->format('d M Y') }}
                                    </td>
                                    <td data-label="Returned On">
                                        {{ optional($issue->confirmed_issued)->format('d M Y') ?? 'N/A' }}
                                    </td>
                                    <td data-label="Action">
                                        <div class="actions">
                                            <a href="{{ route('controls.general-items.show', $issue->id) }}" class="btn-action btn-view">
                                                <i class="feather icon-eye"></i>
                                                <span>View</span>
                                            </a>
                                            <a href="{{ route('controls.general-items.reissue.form', $issue->id) }}" class="btn-action btn-reissue">
                                                <i class="feather icon-refresh-ccw"></i>
                                                <span>Re-Issue</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .returned-items-panel {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
        border: 1px solid #e4eaf6;
        overflow: hidden;
    }

    .panel-header {
        padding: 2.4rem 2.75rem 2rem;
        background: linear-gradient(135deg, rgba(79, 110, 242, 0.14) 0%, rgba(71, 185, 163, 0.18) 100%);
    }

    .header-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .header-eyebrow {
        display: inline-flex;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        background: rgba(79, 110, 242, 0.2);
        color: #3f59d6;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 0.6rem;
    }

    .header-title {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .header-subtitle {
        margin: 0.4rem 0 0;
        color: #475569;
        font-size: 1rem;
        max-width: 520px;
        line-height: 1.6;
    }

    .btn-issue {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.85rem 1.8rem;
        border-radius: 999px;
        background: #4f6ef2;
        color: #ffffff;
        font-weight: 600;
        text-decoration: none;
        border: none;
        box-shadow: 0 20px 40px -22px rgba(79, 110, 242, 0.55);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .btn-issue:hover {
        background: #3f59d6;
        transform: translateY(-2px);
    }

    .header-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.35rem;
        margin-top: 2rem;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e4eaf6;
        border-radius: 18px;
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
    }

    .stat-hint {
        font-size: 0.85rem;
        color: #475569;
    }

    .table-container {
        padding: 0 2.75rem 2.75rem;
    }

    .empty-state {
        padding: 4rem 1.5rem;
        text-align: center;
        color: #64748b;
    }

    .empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 16px;
        background: rgba(79, 110, 242, 0.14);
        color: #4f6ef2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        box-shadow: 0 16px 40px -30px rgba(79, 110, 242, 0.55);
    }

    .empty-state h4 {
        margin: 0;
        font-size: 1.3rem;
        color: #1f2a44;
    }

    .empty-state p {
        margin: 0.5rem 0 1.25rem;
    }

    .btn-empty-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        border-radius: 999px;
        background: #4f6ef2;
        color: #ffffff;
        font-weight: 600;
        text-decoration: none;
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 18px;
        box-shadow: 0 18px 48px -38px rgba(15, 23, 42, 0.4);
    }

    .returns-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
    }

    .returns-table th {
        background: #f8faff;
        border-bottom: 1px solid #e5ecfb;
        padding: 1.15rem 1.5rem;
        text-align: left;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
    }

    .returns-table td {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #e9edf9;
        font-size: 0.95rem;
        color: #344155;
    }

    .returns-table tbody tr:hover {
        background: #f5f8ff;
    }

    .invoice-number {
        font-family: 'JetBrains Mono', 'Menlo', monospace;
        font-size: 0.9rem;
        color: #1f2a44;
    }

    .item-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .item-name {
        font-weight: 600;
        color: #1f2937;
    }

    .item-meta {
        font-size: 0.78rem;
        color: #64748b;
    }

    .qty-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 3.1rem;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        background: rgba(79, 110, 242, 0.12);
        color: #3f59d6;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .recipient-info {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        color: #1f2937;
    }

    .recipient-info i {
        color: #94a3b8;
        font-size: 0.95rem;
    }

    .type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.85rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .type-pill-unit {
        background: rgba(59, 130, 246, 0.12);
        color: #1d4ed8;
    }

    .type-pill-personnel {
        background: rgba(71, 185, 163, 0.12);
        color: #2f8071;
    }

    .actions {
        display: inline-flex;
        gap: 0.65rem;
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

    .btn-view {
        background: #eef2ff;
        color: #3f59d6;
        border-color: rgba(79, 110, 242, 0.25);
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px -24px rgba(79, 110, 242, 0.6);
    }

    .btn-reissue {
        background: rgba(71, 185, 163, 0.14);
        color: #2f8071;
        border-color: rgba(71, 185, 163, 0.25);
    }

    .btn-reissue:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px -24px rgba(71, 185, 163, 0.55);
    }

    @media (max-width: 992px) {
        .panel-header {
            padding: 2.1rem 2rem 1.8rem;
        }

        .header-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .header-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-stats {
            grid-template-columns: 1fr;
        }

        .table-container {
            padding: 0 1.75rem 2.25rem;
        }

        .returns-table th,
        .returns-table td {
            padding: 1rem 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .panel-header {
            padding: 1.85rem 1.5rem 1.6rem;
        }

        .table-container {
            padding: 0 1.5rem 2rem;
        }

        .table-wrapper {
            margin: 0 -1rem;
        }

        .btn-action {
            flex: 1 1 100%;
            justify-content: center;
        }
    }
</style>
@endsection
