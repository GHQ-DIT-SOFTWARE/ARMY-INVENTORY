@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Roles</h5>
                        <p class="text-muted mb-0">Manage application roles and their associated permissions.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item">All Roles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="role-dashboard">
        <section class="dashboard-header">
            <div class="header-copy">
                <span class="header-eyebrow">Access Management</span>
                <h2>Role Directory & Permission Coverage</h2>
                <p>Review existing roles, understand their permission footprint, and keep access aligned with operational responsibilities.</p>
            </div>
            @if (Auth::guard('web')->user()->can('users.manage-all'))
                <a class="btn btn-primary" href="{{ route('create-roles') }}">
                    <i class="feather icon-plus"></i>
                    New Role
                </a>
            @endif
        </section>

        <section class="metrics-grid">
            <article class="metric-card">
                <div class="metric-icon metric-icon-primary">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="metric-body">
                    <span class="metric-label">Total Roles</span>
                    <span class="metric-value">{{ number_format(method_exists($roles, 'total') ? $roles->total() : $roles->count()) }}</span>
                    <small class="metric-hint">Active access profiles</small>
                </div>
            </article>
            <article class="metric-card">
                <div class="metric-icon metric-icon-muted">
                    <i class="fas fa-key"></i>
                </div>
                <div class="metric-body">
                    <span class="metric-label">Unique Permissions</span>
                    <span class="metric-value">{{ number_format($permissionsCount ?? 0) }}</span>
                    <small class="metric-hint">Capabilities assigned across roles</small>
                </div>
            </article>
        </section>

        <section class="roles-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-eyebrow">Roles Catalogue</span>
                    <h3>Roles & Effective Permissions</h3>
                    <p>Each role lists its permissions so you can audit coverage without leaving the page.</p>
                </div>
            </header>

            <div class="table-wrapper">
                <table class="roles-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td data-label="#">
                                    @php
                                        $baseIndex = method_exists($roles, 'firstItem')
                                            ? ($roles->firstItem() ?? 1)
                                            : 1;
                                    @endphp
                                    <span class="table-index">#{{ $baseIndex + $loop->index }}</span>
                                </td>
                                <td data-label="Name">
                                    <span class="role-name">{{ $role->name }}</span>
                                </td>
                                <td data-label="Permissions">
                                    <div class="permission-chips">
                                        @forelse ($role->permissions as $perm)
                                            <span class="chip">{{ $perm->name }}</span>
                                        @empty
                                            <span class="chip chip-empty">No permissions assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td data-label="Actions">
                                    <div class="action-buttons">
                                        @if (Auth::guard('web')->user()->can('users.manage-all'))
                                            <a class="btn-action btn-view" href="{{ route('edit-roles', ['uuid' => $role->uuid]) }}">
                                                <i class="feather icon-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                        @endif

                                        @if (Auth::guard('web')->user()->can('users.manage-all'))
                                            <a class="btn-action btn-delete" id="delete" href="{{ route('destroy-roles', $role->uuid) }}">
                                                <i class="feather icon-trash-2"></i>
                                                <span>Delete</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-row">
                                        <i class="fas fa-folder-open"></i>
                                        <p>No roles have been created yet. Use the button above to add a new role.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($roles, 'links'))
                <div class="pagination-wrapper">
                    {{ $roles->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </section>
    </div>

    <style>
        :root {
            --primary: #4f6ef2;
            --primary-light: #e9edff;
            --muted: #8892aa;
            --text-dark: #1f2a44;
            --text-mid: #4b5565;
            --panel: #ffffff;
            --border: #e4eaf6;
            --shadow-soft: 0 28px 60px -42px rgba(15, 23, 42, 0.45);
        }

        .role-dashboard {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            padding-bottom: 2.5rem;
        }

        .dashboard-header {
            padding: 2.6rem 2.75rem 2.3rem;
            background: linear-gradient(135deg, rgba(79, 110, 242, 0.14) 0%, rgba(71, 185, 163, 0.18) 100%);
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .header-copy h2 {
            margin: 0.55rem 0 0.7rem;
            color: var(--text-dark);
            font-size: 2.05rem;
            font-weight: 700;
        }

        .header-copy p {
            margin: 0;
            color: var(--text-mid);
            max-width: 600px;
            line-height: 1.6;
        }

        .header-eyebrow {
            display: inline-flex;
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            background: rgba(79, 110, 242, 0.2);
            color: var(--primary);
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.45rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 18px 40px -28px rgba(79, 110, 242, 0.55);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 2rem 2.75rem 2.4rem;
        }

        .metric-card {
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1.6rem;
            border-radius: 18px;
            border: 1px solid var(--border);
            background: var(--panel);
            box-shadow: 0 22px 60px -38px rgba(79, 110, 242, 0.35);
        }

        .metric-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
        }

        .metric-icon-primary {
            background: linear-gradient(135deg, #4f6ef2 0%, #7286f5 100%);
        }

        .metric-icon-muted {
            background: linear-gradient(135deg, #6b7a9c 0%, #94a0c2 100%);
        }

        .metric-label {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 700;
        }

        .metric-value {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0.15rem 0;
        }

        .metric-hint {
            font-size: 0.88rem;
            color: var(--text-mid);
        }

        .roles-panel {
            padding: 0 2.75rem 2.75rem;
        }

        .panel-header {
            background: var(--panel-alt);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.1rem 2rem;
            margin-bottom: 2rem;
        }

        .panel-eyebrow {
            display: inline-flex;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            background: rgba(79, 110, 242, 0.12);
            color: var(--primary);
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            font-weight: 700;
            text-transform: uppercase;
        }

        .panel-header h3 {
            margin: 0.5rem 0 0.6rem;
            color: var(--text-dark);
            font-size: 1.6rem;
        }

        .panel-header p {
            margin: 0;
            color: var(--text-mid);
        }

        .table-wrapper {
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 48px -36px rgba(15, 23, 42, 0.35);
        }

        .roles-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--panel);
        }

        .roles-table th {
            background: #f5f8ff;
            border-bottom: 1px solid var(--border);
            padding: 1.15rem 1.5rem;
            text-align: left;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .roles-table td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-mid);
        }

        .roles-table tbody tr:hover {
            background: rgba(79, 110, 242, 0.06);
        }

        .table-index {
            font-weight: 700;
            color: var(--text-dark);
        }

        .permission-chips {
            display: inline-flex;
            gap: 0.45rem;
            flex-wrap: wrap;
        }

        .chip {
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.78rem;
        }

        .chip-empty {
            background: rgba(108, 117, 125, 0.14);
            color: #6c757d;
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
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
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
            color: var(--muted);
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

            .metrics-grid,
            .roles-panel {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 2rem 1.6rem;
            }

            .metrics-grid,
            .roles-panel {
                padding-left: 1.6rem;
                padding-right: 1.6rem;
            }

            .panel-header {
                padding: 1.8rem 1.6rem;
            }
        }

        @media (max-width: 576px) {
            .role-dashboard {
                border-radius: 20px;
            }

            .dashboard-header,
            .metrics-grid,
            .roles-panel {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .table-wrapper {
                border-radius: 16px;
            }

            .roles-table th,
            .roles-table td {
                padding: 1rem;
            }

            .action-buttons {
                width: 100%;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection
