@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Unit Summary</h5>
                        <p class="text-muted mb-0">Manage units and track their issued control items.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Controls</a></li>
                        <li class="breadcrumb-item">Units</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="unit-dashboard">
        <section class="dashboard-header">
            <div class="header-copy">
                <span class="header-eyebrow">Control Centre</span>
                <h2>Unit Directory & Allocation Overview</h2>
                <p>Monitor unit registrations, understand current loan exposure, and keep records in sync with your control inventory.</p>
            </div>
            <div class="header-meta">
                <div class="meta-pill">
                    <i class="fas fa-database"></i>
                    <span>Summary refresh: {{ now()->format('d M Y, H:i') }}</span>
                </div>
                <div class="meta-pill">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Bulk import supported (.csv / .xlsx)</span>
                </div>
            </div>
        </section>

        <section class="stats-grid">
            <article class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Total Units</span>
                    <span class="stat-value">{{ number_format($summary['totalUnits']) }}</span>
                    <small class="stat-hint">Registered destinations for control items</small>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Active Issues</span>
                    <span class="stat-value">{{ number_format($summary['activeUnits']) }}</span>
                    <small class="stat-hint">Units holding items awaiting return</small>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Items Allocated</span>
                    <span class="stat-value">{{ number_format($summary['totalItemsIssued']) }}</span>
                    <small class="stat-hint">Quantity currently on unit loan</small>
                </div>
            </article>
        </section>

        <section class="directory-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-eyebrow">Unit Directory</span>
                    <h3>Manage Unit-Level Allocations</h3>
                    <p>Search, import or update units to keep allocation records aligned with real-world deployments.</p>
                </div>
                <div class="panel-actions">
                    <a href="{{ route('add-unit') }}" class="btn btn-primary">
                        <i class="feather icon-plus"></i>
                        New Unit
                    </a>
                    <button class="btn btn-soft" type="button" data-toggle="modal" data-target="#importUnitsModal">
                        <i class="feather icon-upload"></i>
                        Import Units
                    </button>
                </div>
            </header>

            <div class="table-wrapper">
                <table class="unit-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unit Name</th>
                            <th>Issues</th>
                            <th>Quantity Issued</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            @php
                                $rowIndex = method_exists($units, 'firstItem')
                                    ? $units->firstItem() + $loop->index
                                    : $loop->iteration;
                            @endphp
                            <tr>
                                <td data-label="#">
                                    <span class="row-index">#{{ $rowIndex }}</span>
                                </td>
                                <td data-label="Unit Name">
                                    <div class="unit-name">
                                        <span class="name-text">{{ $unit->unit_name }}</span>
                                    </div>
                                </td>
                                <td data-label="Issues">
                                    <span class="badge badge-warning">{{ number_format($unit->active_issue_count) }}</span>
                                </td>
                                <td data-label="Quantity Issued">
                                    <span class="badge badge-info">{{ number_format($unit->active_issue_qty) }}</span>
                                </td>
                                <td data-label="Actions">
                                    <div class="action-buttons">
                                        <a class="btn-action btn-view" href="{{ route('edit-unit', $unit->uuid) }}">
                                            <i class="feather icon-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                        <a class="btn-action btn-delete" href="{{ route('delete-unit', $unit->uuid) }}" id="delete">
                                            <i class="feather icon-trash-2"></i>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-row">
                                        <i class="fas fa-folder-open"></i>
                                        <p>No units available. Use the buttons above to add or import units.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($units, 'links'))
                <div class="pagination-wrapper">
                    {{ $units->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </section>
    </div>

    <div class="modal fade" id="importUnitsModal" tabindex="-1" role="dialog" aria-labelledby="importUnitsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importUnitsModalLabel">Import Units</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('import-units') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">Upload a CSV or Excel file to bulk add units.</p>
                        <div class="form-group">
                            <label for="unitImportFile">Select File</label>
                            <input type="file" class="form-control" id="unitImportFile" name="file" accept=".csv,.xlsx,.xls" required>
                        </div>
                        @error('file')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #4f6ef2;
            --accent: #47b9a3;
            --warning: #f7b267;
            --info: #6ea8fe;
            --text-dark: #1f2a44;
            --text-mid: #56617a;
            --text-muted: #8892aa;
            --panel: #ffffff;
            --panel-alt: #f7f9fd;
            --border: #e4eaf6;
            --shadow-soft: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
        }

        .unit-dashboard {
            background: var(--panel);
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
        }

        .dashboard-header {
            padding: 2.6rem 2.75rem 2.3rem;
            background: linear-gradient(135deg, rgba(79, 110, 242, 0.14) 0%, rgba(71, 185, 163, 0.2) 100%);
            display: flex;
            justify-content: space-between;
            gap: 1.75rem;
            flex-wrap: wrap;
        }

        .header-copy h2 {
            margin: 0.6rem 0 0.8rem;
            font-size: 2.15rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-copy p {
            margin: 0;
            max-width: 560px;
            color: var(--text-mid);
            line-height: 1.6;
        }

        .header-eyebrow {
            display: inline-flex;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            background: rgba(79, 110, 242, 0.18);
            color: var(--primary);
            font-weight: 700;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .header-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.25rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(79, 110, 242, 0.2);
            color: var(--text-mid);
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 2rem 2.75rem 2.4rem;
            background: var(--panel);
        }

        .stat-card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.75rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            box-shadow: 0 22px 60px -38px rgba(79, 110, 242, 0.35);
        }

        .stat-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
        }

        .stat-icon-primary { background: linear-gradient(135deg, #4f6ef2 0%, #7286f5 100%); }
        .stat-icon-warning { background: linear-gradient(135deg, #f7b267 0%, #f6a04c 100%); }
        .stat-icon-info { background: linear-gradient(135deg, #6ea8fe 0%, #5a99f8 100%); }

        .stat-label {
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
        }

        .stat-value {
            display: block;
            font-size: 1.95rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0.2rem 0;
        }

        .stat-hint {
            font-size: 0.88rem;
            color: var(--text-mid);
        }

        .directory-panel {
            padding: 0 2.75rem 2.75rem;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 2.25rem 2rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: var(--panel-alt);
        }

        .panel-eyebrow {
            display: inline-flex;
            padding: 0.25rem 0.7rem;
            background: rgba(79, 110, 242, 0.12);
            color: var(--primary);
            border-radius: 999px;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            font-weight: 700;
            text-transform: uppercase;
        }

        .panel-header h3 {
            margin: 0.55rem 0 0.6rem;
            color: var(--text-dark);
            font-size: 1.6rem;
        }

        .panel-header p {
            margin: 0;
            color: var(--text-mid);
            max-width: 520px;
        }

        .panel-actions {
            display: inline-flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.4rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 18px 40px -28px rgba(79, 110, 242, 0.55);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-soft {
            background: var(--panel);
            color: var(--text-mid);
            border: 1px solid var(--border);
        }

        .btn-soft:hover {
            transform: translateY(-2px);
        }

        .table-wrapper {
            margin-top: 2rem;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 18px 48px -36px rgba(15, 23, 42, 0.35);
        }

        .unit-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--panel);
        }

        .unit-table th {
            background: #f5f8ff;
            border-bottom: 1px solid var(--border);
            padding: 1.15rem 1.5rem;
            text-align: left;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .unit-table td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-mid);
        }

        .unit-table tbody tr:hover {
            background: rgba(79, 110, 242, 0.06);
        }

        .row-index {
            font-weight: 700;
            color: var(--text-dark);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-warning {
            background: rgba(247, 178, 103, 0.15);
            color: #c87011;
        }

        .badge-info {
            background: rgba(110, 168, 254, 0.15);
            color: #2961c4;
        }

        .action-buttons {
            display: inline-flex;
            gap: 0.55rem;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid transparent;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-action span {
            display: none;
        }

        .btn-view {
            background: #eef2ff;
            color: var(--primary);
            border-color: rgba(79, 110, 242, 0.25);
        }

        .btn-delete {
            background: rgba(233, 99, 90, 0.12);
            color: #b33430;
            border-color: rgba(233, 99, 90, 0.28);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 32px -26px rgba(79, 110, 242, 0.45);
        }

        .empty-row {
            padding: 2.5rem 1.5rem;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-row i {
            font-size: 1.6rem;
            display: block;
            margin-bottom: 0.75rem;
        }

        .pagination-wrapper {
            margin-top: 1.75rem;
            display: flex;
            justify-content: flex-end;
        }

        .pagination-wrapper .pagination {
            margin: 0;
        }

        @media (max-width: 992px) {
            .dashboard-header {
                padding: 2.2rem 2rem;
            }

            .stats-grid,
            .directory-panel {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 2rem 1.6rem;
            }

            .stats-grid,
            .directory-panel {
                padding-left: 1.6rem;
                padding-right: 1.6rem;
            }

            .panel-header {
                padding: 1.8rem 1.6rem;
            }

            .btn-action span {
                display: inline;
            }
        }

        @media (max-width: 576px) {
            .unit-dashboard {
                border-radius: 20px;
            }

            .dashboard-header,
            .stats-grid,
            .directory-panel {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .table-wrapper {
                border-radius: 16px;
            }

            .unit-table th,
            .unit-table td {
                padding: 1rem;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .btn-action span {
                display: inline;
            }
        }
    </style>
@endsection
