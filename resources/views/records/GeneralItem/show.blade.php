@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issue Details</h5>
                        <p class="text-muted mb-0">Reference: {{ $issue->invoice_no ?? 'N/A' }}</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>
                        <li class="breadcrumb-item">Issue Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="allocation-details-container">
    <!-- Header Section -->
    <div class="details-header">
        <div class="header-content">
            <div class="title-section">
                <span class="page-eyebrow">Issue Overview</span>
                <h1 class="page-title">Allocation Details</h1>
                <p class="page-subtitle">Complete overview of item allocation and status</p>
            </div>
            <div class="status-badge status-{{ (int) $issue->status === 1 ? 'returned' : 'active' }}">
                <span class="status-light" aria-hidden="true"></span>
                <span class="status-text">{{ (int) $issue->status === 1 ? 'Returned' : 'On Loan' }}</span>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ url()->previous() }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
            @if ((int) $issue->status === 0)
                <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn btn-primary">
                    <i class="fas fa-check-double"></i>
                    Mark Returned
                </a>
            @else
                <a href="{{ route('controls.general-items.mark-loaned', $issue->id) }}" class="btn btn-outline">
                    <i class="fas fa-redo"></i>
                    Reopen Issue
                </a>
            @endif
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="details-grid">
        <!-- Allocation Summary Card -->
        <div class="detail-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="card-title">Allocation Summary</h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Issued On
                        </div>
                        <div class="info-value">
                            {{ optional($issue->date ?? $issue->created_at)->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user-tie"></i>
                            Issued By
                        </div>
                        <div class="info-value">
                            {{ optional($issue->createdBy)->name ?? 'System' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-share-square"></i>
                            Issued To
                        </div>
                        <div class="info-value">
                            <span class="recipient-type">{{ $issuedToType }}</span>
                            <span class="recipient-name">{{ $issuedTo }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>
                            Status
                        </div>
                        <div class="info-value">
                            <span class="status-indicator status-{{ (int) $issue->status === 1 ? 'returned' : 'active' }}">
                                <span class="status-dot"></span>
                                {{ (int) $issue->status === 1 ? 'Returned' : 'On Loan' }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-check-circle"></i>
                            Return Confirmed
                        </div>
                        <div class="info-value">
                            @if($issue->confirmed_issued)
                                <span class="confirmed-date">
                                    {{ optional($issue->confirmed_issued)->format('d M Y H:i') }}
                                </span>
                            @else
                                <span class="pending-text">Pending</span>
                            @endif
                        </div>
                    </div>

                    @if (! empty($issue->remarks))
                    <div class="info-item full-width">
                        <div class="info-label">
                            <i class="fas fa-sticky-note"></i>
                            Remarks
                        </div>
                        <div class="info-value">
                            <div class="remarks-box">
                                {{ $issue->remarks }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Item Details Card -->
        <div class="detail-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="card-title">Item Details</h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-cube"></i>
                            Item Name
                        </div>
                        <div class="info-value item-name">
                            {{ optional($issue->issuedoutitem)->item_name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-folder"></i>
                            Category
                        </div>
                        <div class="info-value">
                            {{ optional(optional($issue->issuedoutitem)->category)->category_name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-folder-open"></i>
                            Sub Category
                        </div>
                        <div class="info-value">
                            {{ optional(optional($issue->issuedoutitem)->subcategory)->sub_category_name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-layer-group"></i>
                            Quantity Issued
                        </div>
                        <div class="info-value">
                            <span class="quantity-badge">
                                {{ number_format($issue->qty) }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-ruler"></i>
                            Size / Variant
                        </div>
                        <div class="info-value">
                            {{ $issue->sizes ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item full-width">
                        <div class="info-label">
                            <i class="fas fa-align-left"></i>
                            Description
                        </div>
                        <div class="info-value">
                            <div class="description-box">
                                {{ $issue->description ?? 'No description provided' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="timeline-section">
        <h3 class="timeline-title">Allocation Timeline</h3>
        <div class="timeline">
            <div class="timeline-item completed">
                <div class="timeline-marker">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="timeline-content">
                    <h4>Item Issued</h4>
                    <p>Item was allocated to recipient</p>
                    <span class="timeline-date">{{ optional($issue->date ?? $issue->created_at)->format('d M Y H:i') }}</span>
                </div>
            </div>

            <div class="timeline-item {{ (int) $issue->status === 1 ? 'completed' : 'pending' }}">
                <div class="timeline-marker">
                    <i class="fas fa-{{ (int) $issue->status === 1 ? 'check' : 'clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <h4>Item Returned</h4>
                    <p>Item returned to inventory</p>
                    @if((int) $issue->status === 1)
                        <span class="timeline-date">{{ optional($issue->confirmed_issued)->format('d M Y H:i') }}</span>
                    @else
                        <span class="timeline-date pending">Awaiting return</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.allocation-details-container {
    max-width: 1200px;
    margin: 0 auto 3.5rem;
    padding: 0 1.5rem 3.5rem;
    --surface: #ffffff;
    --surface-alt: #f5f7fb;
    --border: #e1e7f5;
    --text-primary: #1f2a44;
    --text-secondary: #5b6b8c;
    --primary: #4f6ef2;
    --primary-dark: #3f59d6;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #e5484d;
    --shadow-soft: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
}

/* Header Styles */
.details-header {
    background: linear-gradient(135deg, rgba(79, 110, 242, 0.07) 0%, rgba(71, 185, 163, 0.08) 100%);
    border-radius: 26px;
    padding: 2.75rem;
    margin-bottom: 3rem;
    border: 1px solid rgba(79, 110, 242, 0.08);
    box-shadow: var(--shadow-soft);
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.header-content {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.75rem;
}

.title-section {
    max-width: 540px;
}

.page-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    background: rgba(79, 110, 242, 0.12);
    color: var(--primary-dark);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.page-title {
    margin: 0 0 0.75rem 0;
    font-size: 2.3rem;
    font-weight: 700;
    color: var(--text-primary);
}

.page-subtitle {
    margin: 0;
    color: var(--text-secondary);
    font-size: 1rem;
    line-height: 1.6;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1.75rem;
    border-radius: 999px;
    background: var(--surface);
    border: 1px solid rgba(79, 110, 242, 0.15);
    box-shadow: 0 18px 40px -30px rgba(79, 110, 242, 0.8);
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--primary);
}

.status-badge .status-light {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-flex;
    position: relative;
}

.status-badge .status-light::after {
    content: '';
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    background: rgba(79, 110, 242, 0.12);
    animation: badgePulse 2.6s infinite;
}

.status-badge .status-text {
    letter-spacing: 0.02em;
}

.status-badge.status-returned {
    background: rgba(34, 197, 94, 0.14);
    border-color: rgba(34, 197, 94, 0.28);
    color: #15803d;
}

.status-badge.status-returned .status-light {
    background: #22c55e;
}

.status-badge.status-returned .status-light::after {
    background: rgba(34, 197, 94, 0.2);
}

.status-badge.status-active {
    background: rgba(245, 158, 11, 0.16);
    border-color: rgba(245, 158, 11, 0.28);
    color: #b45309;
}

.status-badge.status-active .status-light {
    background: #f59e0b;
}

.status-badge.status-active .status-light::after {
    background: rgba(245, 158, 11, 0.22);
}

.header-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
}

.header-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.6rem;
    border-radius: 999px;
    font-weight: 600;
    letter-spacing: 0.01em;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all 0.3s ease;
    box-shadow: 0 16px 32px -28px rgba(15, 23, 42, 0.6);
}

.header-actions .btn i {
    font-size: 0.9rem;
}

.header-actions .btn-back {
    background: var(--surface);
    color: var(--text-secondary);
    border-color: var(--border);
}

.header-actions .btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 36px -28px rgba(15, 23, 42, 0.55);
    color: var(--text-primary);
}

.header-actions .btn-primary {
    background: var(--primary);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 20px 40px -22px rgba(79, 110, 242, 0.55);
}

.header-actions .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.header-actions .btn-outline {
    background: transparent;
    color: var(--primary);
    border-color: rgba(79, 110, 242, 0.4);
}

.header-actions .btn-outline:hover {
    background: rgba(79, 110, 242, 0.08);
    color: var(--primary-dark);
    transform: translateY(-2px);
}

/* Cards Grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2.25rem;
    margin-bottom: 3.25rem;
}

.detail-card {
    background: var(--surface);
    border-radius: 24px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 32px 68px -38px rgba(79, 110, 242, 0.35);
}

.card-header {
    padding: 1.75rem 2.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    background: linear-gradient(135deg, rgba(79, 110, 242, 0.08) 0%, rgba(255, 255, 255, 0.7) 100%);
    border-bottom: 1px solid rgba(79, 110, 242, 0.1);
}

.header-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: rgba(79, 110, 242, 0.1);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    box-shadow: 0 14px 28px -24px rgba(79, 110, 242, 0.8);
}

.card-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.card-body {
    padding: 2.25rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: var(--surface-alt);
    border-radius: 18px;
    border: 1px solid rgba(79, 110, 242, 0.12);
    padding: 1.4rem 1.6rem;
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
    min-height: 120px;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
    box-shadow: 0 18px 40px -34px rgba(15, 23, 42, 0.55);
}

.info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 24px 60px -36px rgba(79, 110, 242, 0.3);
}

.info-item.full-width {
    grid-column: 1 / -1;
    min-height: auto;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.info-label i {
    width: 34px;
    height: 34px;
    border-radius: 12px;
    background: var(--surface);
    color: var(--primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    box-shadow: 0 12px 26px -18px rgba(79, 110, 242, 0.7);
    flex-shrink: 0;
}

.info-value {
    flex: 1;
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1.05rem;
    line-height: 1.5;
}

.recipient-type {
    background: rgba(79, 110, 242, 0.12);
    color: var(--primary-dark);
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    margin-right: 0.4rem;
}

.recipient-name {
    font-weight: 700;
    color: var(--text-primary);
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 1.15rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    background: rgba(79, 110, 242, 0.08);
    color: var(--primary-dark);
}

.status-indicator .status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.status-indicator.status-returned {
    background: rgba(34, 197, 94, 0.12);
    color: #15803d;
}

.status-indicator.status-returned .status-dot {
    background: #22c55e;
}

.status-indicator.status-active {
    background: rgba(245, 158, 11, 0.14);
    color: #b45309;
}

.status-indicator.status-active .status-dot {
    background: #f59e0b;
}

.confirmed-date {
    color: var(--success);
    font-weight: 600;
}

.pending-text {
    color: var(--danger);
    font-weight: 600;
}

.quantity-badge {
    background: var(--primary);
    color: #ffffff;
    padding: 0.6rem 1.2rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.95rem;
    letter-spacing: 0.03em;
    box-shadow: 0 18px 40px -28px rgba(79, 110, 242, 0.6);
}

.item-name {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.1rem;
}

.remarks-box,
.description-box {
    background: var(--surface);
    padding: 1.25rem 1.35rem;
    border-radius: 16px;
    border: 1px dashed rgba(79, 110, 242, 0.22);
    line-height: 1.6;
    color: var(--text-secondary);
}

/* Timeline Section */
.timeline-section {
    background: var(--surface);
    border-radius: 26px;
    padding: 2.75rem 2.5rem 3rem;
    box-shadow: var(--shadow-soft);
    border: 1px solid var(--border);
}

.timeline-title {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 700;
    color: var(--text-primary);
    text-align: center;
    letter-spacing: 0.02em;
}

.timeline {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.75rem;
    padding: 2.5rem 1.5rem 1rem;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 72px;
    left: 50%;
    transform: translateX(-50%);
    width: min(60%, 520px);
    height: 2px;
    background: rgba(79, 110, 242, 0.12);
    pointer-events: none;
}

.timeline-item {
    flex: 1 1 260px;
    max-width: 360px;
    background: var(--surface-alt);
    border-radius: 22px;
    border: 1px solid rgba(79, 110, 242, 0.12);
    padding: 2.75rem 2rem 2rem;
    text-align: center;
    position: relative;
    box-shadow: 0 24px 60px -36px rgba(15, 23, 42, 0.5);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.timeline-item:hover {
    transform: translateY(-6px);
    box-shadow: 0 30px 70px -40px rgba(79, 110, 242, 0.35);
}

.timeline-marker {
    position: absolute;
    top: -32px;
    left: 50%;
    transform: translateX(-50%);
    width: 68px;
    height: 68px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--surface);
    border: 1px solid rgba(79, 110, 242, 0.15);
    color: var(--primary);
    font-size: 1.35rem;
    box-shadow: 0 26px 55px -34px rgba(79, 110, 242, 0.55);
}

.timeline-item.completed .timeline-marker {
    background: rgba(34, 197, 94, 0.16);
    border-color: rgba(34, 197, 94, 0.35);
    color: #15803d;
}

.timeline-item.pending .timeline-marker {
    background: rgba(245, 158, 11, 0.16);
    border-color: rgba(245, 158, 11, 0.32);
    color: #b45309;
}

.timeline-content h4 {
    margin: 1.4rem 0 0.6rem 0;
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.1rem;
}

.timeline-content p {
    margin: 0 0 1rem 0;
    color: var(--text-secondary);
    line-height: 1.55;
    font-size: 0.95rem;
}

.timeline-date {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 1.1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    background: var(--surface);
    color: var(--text-secondary);
    border: 1px solid rgba(79, 110, 242, 0.12);
}

.timeline-item.completed .timeline-date {
    color: var(--success);
    border-color: rgba(34, 197, 94, 0.2);
}

.timeline-item.pending .timeline-date.pending {
    color: var(--warning);
    border-color: rgba(245, 158, 11, 0.2);
}

/* Animations */
@keyframes badgePulse {
    0%, 100% {
        opacity: 0.7;
        transform: scale(0.9);
    }
    50% {
        opacity: 0;
        transform: scale(1.4);
    }
}

/* Responsive Design */
@media (max-width: 992px) {
    .details-header {
        padding: 2.25rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .timeline::before {
        width: 70%;
    }
}

@media (max-width: 768px) {
    .details-header {
        padding: 2rem;
        text-align: left;
    }

    .page-title {
        font-size: 2rem;
    }

    .details-grid {
        gap: 1.75rem;
    }

    .card-body {
        padding: 1.85rem;
    }

    .info-item {
        min-height: auto;
    }

    .timeline-section {
        padding: 2.25rem 1.75rem 2.25rem;
    }

    .timeline {
        padding: 2.5rem 0 0.5rem;
    }

    .timeline::before {
        display: none;
    }

    .timeline-item {
        flex: 1 1 100%;
        max-width: none;
        padding: 2.5rem 1.75rem 1.75rem;
    }

    .timeline-marker {
        top: -28px;
        width: 62px;
        height: 62px;
    }
}

@media (max-width: 576px) {
    .allocation-details-container {
        padding: 0 1rem 3rem;
    }

    .details-header {
        padding: 1.75rem;
    }

    .header-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .timeline-item {
        padding: 2.3rem 1.5rem 1.6rem;
    }

    .timeline-marker {
        width: 58px;
        height: 58px;
    }
}
</style>
@endsection
