@extends('admin.admin_master')
@section('admin')
    @php
        $availableStockTotals = (int) \App\Models\Item::sum('qty');
    @endphp
    <style>
        .dashboard-shell {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: rgba(222, 223, 227, 0.78);
            box-shadow: 0 24px 48px rgba(255, 255, 255, 0.4);
        }

        .dashboard-shell::before {
            content: '';
            position: absolute;
            inset: -220px;
            background:
                radial-gradient(circle at 18% 22%, rgba(249, 249, 249, 0.35), transparent 58%),
                radial-gradient(circle at 78% 32%, rgba(250, 250, 251, 0.38), transparent 48%),
                radial-gradient(circle at 42% 82%, rgba(250, 250, 250, 0.4), transparent 54%);
            animation: auroraShift 18s ease-in-out infinite alternate;
            filter: blur(65px);
        }

        .dashboard-shell::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(249, 249, 249, 0.94), rgba(255, 255, 255, 0.66));
        }

        .dashboard-content {
            position: relative;
            z-index: 2;
            color: #f8fafc;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.38), rgba(59, 130, 246, 0.2));
            box-shadow: 0 18px 40px rgba(59, 130, 246, 0.32);
            animation: floatUp 24s linear infinite;
            opacity: 0.5;
        }

        .floating-orb.is-secondary {
            background: radial-gradient(circle at 70% 30%, rgba(139, 92, 246, 0.42), rgba(59, 130, 246, 0.22));
            box-shadow: 0 18px 42px rgba(139, 92, 246, 0.38);
            animation-duration: 29s;
        }

        .floating-orb.is-tertiary {
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.45), rgba(59, 130, 246, 0.19));
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
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 1rem;
            border-radius: 999px;
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            color: #03609e;
        }

        .pulse-dot {
            display: inline-flex;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #02587e;
            box-shadow: 0 0 0 rgba(1, 125, 179, 0.9);
            animation: pulse 3s ease-out infinite;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 1rem;
        }

        .quick-actions .card {
            border: none;
            border-radius: 1rem;
            background: rgba(15, 23, 42, 0.45);
            color: #f8fafc;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(14px);
        }

        .quick-actions .card:hover {
            transform: translateY(-6px);
            background: rgba(106, 138, 207, 0.6);
            box-shadow: 0 20px 30px rgba(82, 107, 159, 0.35);
        }

        .quick-actions .icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(160, 188, 233, 0.28);
            color: #bfdbfe;
            margin-bottom: 0.9rem;
        }

        .summary-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .summary-metrics .metric-card {
            border: none;
            border-radius: 1.15rem;
            padding: 1.65rem;
            background: rgba(84, 99, 132, 0.52);
            backdrop-filter: blur(16px);
            color: #ffffff;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }

        .summary-metrics .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 34px rgba(15, 23, 42, 0.45);
        }

        .metric-value {
            font-size: 2.3rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.35rem;
        }

        .metric-label {
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.78);
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
                box-shadow: 0 0 0 0 rgba(120, 203, 239, 0.65);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 14px rgba(124, 142, 150, 0);
            }

            100% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(98, 140, 158, 0);
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
                text-align: center;
            }

            .quick-actions {
                grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            }

            .summary-metrics {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-shell {
                border-radius: 1rem;
            }

            .dashboard-hero {
                padding: 2.15rem 1.35rem;
            }
        }
    </style>
    @php
        $user = Auth::user();
    @endphp
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10" style="color:#d4af37;">Command Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Welcome</a></li>
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
                            Operational Readiness - Live
                        </div>
                        <h1 class="display-6">
                            Welcome back, {{ $user?->name ?? 'Logistics Team' }}.
                        </h1>
                        <p class="text-light mb-0">
                            Maintain situational awareness across weapons, vehicles, and personnel. The command center
                            continuously synchronizes mission-critical assets to keep units deployment-ready.
                        </p>
                    </div>
                    {{-- <div class="mt-3 mt-lg-0 text-lg-right">
                        <small class="text-light opacity-75 d-block">GAF Logistics Command</small>
                        <h2 class="h4 text-white mb-0">Unified Operations Center</h2>
                        <p class="mb-0 text-light opacity-75">Continuously monitoring readiness levels and mission support queues.</p>
                    </div> --}}
                </div>

                <div class="quick-actions">
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-target"></i>
                        </div>
                        <h5 class="mb-1 text-white">Weapon Stock</h5>
                        <p class="mb-3 text-light">Update technical details, configurations, and deployment kits.</p>
                        <a href="{{ route('weapons.platforms.index') }}" class="text-white-50">
                            Manage weapons <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-truck"></i>
                        </div>
                        <h5 class="mb-1 text-white">Vehicle Depo Pool</h5>
                        <p class="mb-3 text-light">Track fleet readiness, deployment orders, and service windows.</p>
                        <a href="{{ route('vehicles.platforms.index') }}" class="text-white-50">
                            Open vehicle items <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-users"></i>
                        </div>
                        <h5 class="mb-1 text-white">Personnel</h5>
                        <p class="mb-3 text-light">Maintain profiles, readiness status, and issuance assignments.</p>
                        <a href="{{ route('personal-view') }}" class="text-white-50">
                            Review roster <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="card p-4 shadow-sm">
                        <div class="icon-wrap">
                            <i class="feather icon-clipboard"></i>
                        </div>
                        <h5 class="mb-1 text-white">Records Hub</h5>
                        <p class="mb-3 text-light">Audit stock movements, returns, and historical accountability.</p>
                        <a href="{{ route('controls.general-items.records') }}" class="text-white-50">
                            View records <i class="feather icon-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="summary-metrics mt-4">
                    <div class="metric-card">
                        <div class="metric-label">G-Control Logistics</div>
                        <div class="metric-value">{{ number_format($availableStockTotals) }}</div>
                        <small class="text-primary">+3 movements logged in the last 48 hours</small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Weapon Readiness</div>
                        <div class="metric-value">428</div>
                        <small class="text-primary">Next compliance audit scheduled for tomorrow</small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Fleet Readiness</div>
                        <div class="metric-value">94%</div>
                        <small class="text-primary">5 vehicles awaiting maintenance clearance</small>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Personnel Records</div>
                        <div class="metric-value">1,248</div>
                        <small class="text-primary">15 new profiles activated this week</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
