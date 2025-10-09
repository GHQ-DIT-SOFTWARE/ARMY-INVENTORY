@extends('admin.admin_master')
@section('title', 'Military Vehicles Operations')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Fleet Command Center</h5>
                        <p class="text-muted mb-0">Operational picture for armored and tactical vehicles.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Operations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vehicles.dashboard') }}">Vehicles</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.widgets.vehicle-overview')

    @include('dashboard.widgets.quick-links', [
        'links' => $quickLinks ?? [],
        'title' => 'Quick Launch',
        'subtitle' => 'Access fleet workflows instantly',
    ])
@endsection
