@extends('admin.admin_master')
@section('title', 'Operations Dashboard')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Logistics Operations Overview</h5>
                        <p class="text-muted mb-0">Realtime insights into stock position, demand signals, and team workload.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Operations</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
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
