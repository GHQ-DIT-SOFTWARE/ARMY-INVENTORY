@extends('admin.admin_master')
@section('admin')
    @php
        $availableStockTotals = (int) \App\Models\Item::sum('qty');
        $user = Auth::user();
    @endphp

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #8b5cf6;
            --secondary: #f59e0b;
            --accent: #10b981;
            --dark: #1e293b;
            --light: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-hover: rgba(255, 255, 255, 1);
            --text-primary: #334155;
            --text-secondary: #64748b;
            --border-light: rgba(226, 232, 240, 0.8);
        }

        .dashboard-shell {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #f0f4ff 0%, #f8fafc 100%);
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.04),
                0 5px 10px rgba(0, 0, 0, 0.02);
        }

        .dashboard-shell::before {
            content: '';
            position: absolute;
            inset: -220px;
            background:
                radial-gradient(circle at 18% 22%, rgba(99, 102, 241, 0.08), transparent 58%),
                radial-gradient(circle at 78% 32%, rgba(139, 92, 246, 0.06), transparent 48%),
                radial-gradient(circle at 42% 82%, rgba(16, 185, 129, 0.05), transparent 54%);
            animation: auroraShift 18s ease-in-out infinite alternate;
            filter: blur(65px);
        }

        .dashboard-content {
            position: relative;
            z-index: 2;
            color: var(--text-primary);
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.15), rgba(99, 102, 241, 0.05));
            box-shadow: 0 18px 40px rgba(99, 102, 241, 0.1);
            animation: floatUp 24s linear infinite;
            opacity: 0.6;
        }

        .floating-orb.is-secondary {
            background: radial-gradient(circle at 70% 30%, rgba(139, 92, 246, 0.12), rgba(139, 92, 246, 0.04));
            box-shadow: 0 18px 42px rgba(139, 92, 246, 0.08);
            animation-duration: 29s;
        }

        .floating-orb.is-tertiary {
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.03));
            animation-duration: 33s;
        }

        .dashboard-hero {
            padding: 3rem 2.75rem;
            display: flex;
            flex-direction: column;
            gap: 2.25rem;
        }

        .dashboard-hero h1 {
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
            font-size: 2.5rem;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            color: var(--accent);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-light);
        }

        .pulse-dot {
            display: inline-flex;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse 3s ease-out infinite;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .quick-actions .card {
            border: 1px solid var(--border-light);
            border-radius: 1rem;
            background: var(--card-bg);
            color: var(--text-primary);
            transition: all 0.3s ease;
            backdrop-filter: blur(14px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            position: relative;
        }

        .quick-actions .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .quick-actions .card:hover {
            transform: translateY(-6px);
            background: var(--card-hover);
            box-shadow: 0 20px 30px rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .quick-actions .card:hover::before {
            transform: scaleX(1);
        }

        .quick-actions .icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .quick-actions .card:hover .icon-wrap {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
        }

        .quick-actions .card h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .quick-actions .card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .quick-actions .card a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .quick-actions .card a:hover {
            color: var(--primary-light);
            transform: translateX(4px);
        }

        .summary-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .summary-metrics .metric-card {
            border: 1px solid var(--border-light);
            border-radius: 1.15rem;
            padding: 1.75rem;
            background: var(--card-bg);
            color: var(--dark);
            transition: all 0.35s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .summary-metrics .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .summary-metrics .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.08);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .metric-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            margin-right: 1rem;
        }

        .metric-value {
            font-size: 2.3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.35rem;
            color: var(--dark);
        }

        .metric-label {
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .metric-card small {
            color: var(--text-secondary);
            font-weight: 500;
            margin-top: auto;
        }

        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .trend-up {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
        }

        .trend-down {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .page-header-title h5 {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        .welcome-text {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 600px;
        }

        @keyframes auroraShift {
            0% {
                transform: translate(-6%, -4%) scale(1);
            }

            50% {
                transform: translate(6%, 4%) scale(1.05);
            }

            100% {
                transform: translate(-8%, 6%) scale(1.1);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        @keyframes floatUp {
            0% {
                transform: translate3d(-10%, 18%, 0) scale(0.72);
            }

            50% {
                transform: translate3d(12%, -6%, 0) scale(1);
            }

            100% {
                transform: translate3d(-14%, -28%, 0) scale(0.85);
            }
        }

        @media (max-width: 991.98px) {
            .dashboard-hero {
                padding: 2.5rem 1.75rem;
            }

            .quick-actions {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .summary-metrics {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-shell {
                border-radius: 1rem;
            }

            .dashboard-hero {
                padding: 2.15rem 1.35rem;
            }

            .dashboard-hero h1 {
                font-size: 2rem;
            }
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Business Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Overview</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-shell mb-4">
        <span class="floating-orb" style="width: 240px; height: 240px; top: 6%; right: 13%;"></span>
        <span class="floating-orb is-secondary" style="width: 175px; height: 175px; bottom: 16%; left: 9%;"></span>
        <span class="floating-orb is-tertiary" style="width: 280px; height: 280px; bottom: -6%; right: -8%;"></span>

        <div class="dashboard-content">
            <div class="dashboard-hero">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                    <div class="mb-4 mb-lg-0">
                        <div class="status-chip">
                            <span class="pulse-dot"></span>
                            System Status: Active
                        </div>
                        <h1 class="display-6">
                            Welcome back, {{ $user?->name ?? 'Team Member' }}!
                        </h1>
                        <p class="welcome-text mb-0">
                            Here's an overview of your business operations. Monitor key metrics, manage inventory, and track performance across all departments.
                        </p>
                    </div>
                </div>

                <div class="quick-actions">
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-package"></i>
                        </div>
                        <h5 class="mb-1">Inventory Management</h5>
                        <p class="mb-3">Manage stock levels, track items, and update product information.</p>
                        <a href="{{ route('weapons.platforms.index') }}">
                            View inventory <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5 class="mb-1">Fleet Management</h5>
                        <p class="mb-3">Track vehicles, maintenance schedules, and deployment status.</p>
                        <a href="{{ route('vehicles.platforms.index') }}">
                            Manage fleet <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-users"></i>
                        </div>
                        <h5 class="mb-1">Team Management</h5>
                        <p class="mb-3">View team members, assign tasks, and track performance.</p>
                        <a href="{{ route('personal-view') }}">
                            View team <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-bar-chart-2"></i>
                        </div>
                        <h5 class="mb-1">Reports & Analytics</h5>
                        <p class="mb-3">Access performance reports and business intelligence data.</p>
                        <a href="{{ route('controls.general-items.records') }}">
                            View reports <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="summary-metrics mt-4">
                    <div class="metric-card">
                        <div class="metric-header">
                            <div class="metric-icon">
                                <i class="feather icon-package"></i>
                            </div>
                            <div>
                                <div class="metric-label">Total Inventory</div>
                                <div class="metric-value">{{ number_format($availableStockTotals) }}</div>
                            </div>
                        </div>
                        <small>+3 new items added this week <span class="trend-indicator trend-up">+2.4%</span></small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-header">
                            <div class="metric-icon">
                                <i class="feather icon-check-circle"></i>
                            </div>
                            <div>
                                <div class="metric-label">Operational Rate</div>
                                <div class="metric-value">96%</div>
                            </div>
                        </div>
                        <small>All systems running optimally <span class="trend-indicator trend-up">+1.2%</span></small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-header">
                            <div class="metric-icon">
                                <i class="feather icon-truck"></i>
                            </div>
                            <div>
                                <div class="metric-label">Fleet Availability</div>
                                <div class="metric-value">94%</div>
                            </div>
                        </div>
                        <small>5 vehicles scheduled for maintenance <span class="trend-indicator trend-down">-0.8%</span></small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-header">
                            <div class="metric-icon">
                                <i class="feather icon-users"></i>
                            </div>
                            <div>
                                <div class="metric-label">Team Members</div>
                                <div class="metric-value">48</div>
                            </div>
                        </div>
                        <small>2 new members joined this month <span class="trend-indicator trend-up">+4.3%</span></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
