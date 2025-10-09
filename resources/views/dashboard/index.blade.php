@extends('admin.admin_master')
@section('title', $pageTitle)
@section('admin')
    @includeWhen($globalSummary, 'dashboard.partials.global-overview', [
        'summary' => $globalSummary,
        'sectionTitle' => $globalTitle,
        'sectionSubtitle' => $globalSubtitle,
    ])

    @includeWhen($weaponSummary, 'dashboard.partials.weapon-overview', [
        'summary' => $weaponSummary,
        'sectionTitle' => $weaponTitle,
        'sectionSubtitle' => $weaponSubtitle,
    ])

    @includeWhen($vehicleSummary, 'dashboard.partials.vehicle-overview', [
        'summary' => $vehicleSummary,
        'sectionTitle' => $vehicleTitle,
        'sectionSubtitle' => $vehicleSubtitle,
    ])

    @include('dashboard.partials.quick-links', ['quickLinks' => $quickLinks])
@endsection