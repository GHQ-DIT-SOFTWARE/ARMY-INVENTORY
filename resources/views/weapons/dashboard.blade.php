@extends('admin.admin_master')
@section('title', 'G4 Weapons Operations')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Weapons Command Center</h5>
                        <p class="text-white mb-0">Live inventory for all weapons.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Operations</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}">Weapons</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.widgets.weapon-overview')

    @include('dashboard.widgets.quick-links', [
        'links' => $quickLinks ?? [],
        'title' => 'Quick Launch',
        'subtitle' => 'Most-used workflows in Weapons',
    ])
@endsection
