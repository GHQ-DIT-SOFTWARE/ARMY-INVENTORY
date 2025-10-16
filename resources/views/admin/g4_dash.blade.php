@extends('admin.admin_master')
@section('title', 'Operations Dashboard')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h1 class="h3 mb-2">Logistics Operations Overview</h1>
                        <p class="text-muted mb-0">Real-time insights into stock position, demand signals, and team workload
                        </p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Operations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.widgets.global-overview')

    @include('dashboard.widgets.quick-links', [
        'links' => $quickLinks ?? [],
        'title' => 'Quick Actions',
        'subtitle' => 'Access the most-used workflows directly',
    ])
@endsection

<style>
    .card-gradient {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #1f2937;
        box-shadow: 0 8px 32px rgba(31, 41, 135, 0.1);
    }

    .page-header-title h1 {
        font-weight: 700;
        margin-bottom: 0.5rem;
         color: rgba(255, 255, 255, 0.8) !important;
    }

    .page-header-title p {
        color: rgba(255, 255, 255, 0.8) !important;
        margin-bottom: 0;
    }

    .breadcrumb {
        background: transparent;
        margin-bottom: 0;
        padding: 0.75rem 0 0 0;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .breadcrumb-item.active {
        color: rgba(20, 179, 139, 0.6) !important;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
    }
</style>
