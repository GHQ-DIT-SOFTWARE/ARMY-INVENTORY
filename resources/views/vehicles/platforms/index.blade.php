@extends('admin.admin_master')
@section('title', 'Vehicle Library')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Vehicle Library</h5>
                        <p class="text-white mb-0">Structured technical data for every fleet platform.</p>
                    </div>
                    <ul class="breadcrumb text-white">
                        <li class="breadcrumb-item text-white"><a href="{{ route('vehicles.dashboard') }}" class="text-white"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item text-white">Vehicles</li>
                        <li class="breadcrumb-item active text-white">Platforms</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Registered Vehicle Systems</h5>
            @can('vehicles.manage')
                <a href="{{ route('vehicles.platforms.create') }}" class="btn btn-sm btn-success">Add Vehicle</a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Variant</th>
                            <th>Category</th>
                            <th>Engine</th>
                            <th>Max Speed (kph)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                            @php
                                $vehicleData = [
                                    'name' => $vehicle->name,
                                    'variant' => $vehicle->variant,
                                    'category' => optional($vehicle->category)->name,
                                    'manufacturer' => $vehicle->manufacturer,
                                    'country_of_origin' => $vehicle->country_of_origin,
                                    'engine_type' => $vehicle->engine_type,
                                    'engine_power_hp' => $vehicle->engine_power_hp ? number_format($vehicle->engine_power_hp, 0) . ' hp' : null,
                                    'max_speed_kph' => $vehicle->max_speed_kph ? number_format($vehicle->max_speed_kph) . ' kph' : null,
                                    'range_km' => $vehicle->range_km ? number_format($vehicle->range_km) . ' km' : null,
                                    'fuel_capacity_l' => $vehicle->fuel_capacity_l ? number_format($vehicle->fuel_capacity_l) . ' L' : null,
                                    'weight_tons' => $vehicle->weight_tons ? number_format($vehicle->weight_tons, 2) . ' t' : null,
                                    'crew_capacity' => $vehicle->crew_capacity !== null ? number_format($vehicle->crew_capacity) : null,
                                    'passenger_capacity' => $vehicle->passenger_capacity !== null ? number_format($vehicle->passenger_capacity) : null,
                                    'armament' => $vehicle->armament,
                                    'armor' => $vehicle->armor,
                                    'communication_systems' => $vehicle->communication_systems,
                                    'notes' => $vehicle->notes,
                                    'image_url' => $vehicle->image_path ? asset('storage/' . $vehicle->image_path) : null,
                                ];
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $vehicle->name }}</td>
                                <td>{{ $vehicle->variant ?? 'N/A' }}</td>
                                <td>{{ optional($vehicle->category)->name ?? 'N/A' }}</td>
                                <td>{{ $vehicle->engine_type ?? 'N/A' }}</td>
                                <td>{{ $vehicle->max_speed_kph ? number_format($vehicle->max_speed_kph) : 'N/A' }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" data-toggle="modal" data-target="#vehicleDetailModal" data-vehicle='@json($vehicleData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)'>View</button>
                                    @can('vehicles.manage')
                                        <a href="{{ route('vehicles.platforms.edit', $vehicle) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                    @endcan
                                    @can('vehicles.delete')
                                        <form action="{{ route('vehicles.platforms.destroy', $vehicle) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vehicle?')">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No vehicles have been catalogued yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $vehicles->links() }}
        </div>
    </div>

    <div class="modal fade" id="vehicleDetailModal" tabindex="-1" role="dialog" aria-labelledby="vehicleDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleModalTitle">Vehicle Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="border rounded mb-3">
                                <img id="vehicleModalImage" src="" alt="Vehicle image" class="img-fluid rounded d-none">
                                <div id="vehicleModalNoImage" class="text-center text-muted py-5">No image available.</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Variant / Model</dt>
                                <dd class="col-sm-7" id="vehicleModalVariant">N/A</dd>

                                <dt class="col-sm-5">Category</dt>
                                <dd class="col-sm-7" id="vehicleModalCategory">N/A</dd>

                                <dt class="col-sm-5">Manufacturer</dt>
                                <dd class="col-sm-7" id="vehicleModalManufacturer">N/A</dd>

                                <dt class="col-sm-5">Country of Origin</dt>
                                <dd class="col-sm-7" id="vehicleModalCountry">N/A</dd>

                                <dt class="col-sm-5">Engine Type</dt>
                                <dd class="col-sm-7" id="vehicleModalEngineType">N/A</dd>

                                <dt class="col-sm-5">Engine Power</dt>
                                <dd class="col-sm-7" id="vehicleModalPower">N/A</dd>

                                <dt class="col-sm-5">Max Speed</dt>
                                <dd class="col-sm-7" id="vehicleModalSpeed">N/A</dd>

                                <dt class="col-sm-5">Operational Range</dt>
                                <dd class="col-sm-7" id="vehicleModalRange">N/A</dd>

                                <dt class="col-sm-5">Fuel Capacity</dt>
                                <dd class="col-sm-7" id="vehicleModalFuel">N/A</dd>

                                <dt class="col-sm-5">Weight</dt>
                                <dd class="col-sm-7" id="vehicleModalWeight">N/A</dd>

                                <dt class="col-sm-5">Crew Capacity</dt>
                                <dd class="col-sm-7" id="vehicleModalCrew">N/A</dd>

                                <dt class="col-sm-5">Passenger Capacity</dt>
                                <dd class="col-sm-7" id="vehicleModalPassengers">N/A</dd>

                                <dt class="col-sm-5">Armament</dt>
                                <dd class="col-sm-7 text-break" id="vehicleModalArmament" style="white-space: pre-wrap;">N/A</dd>

                                <dt class="col-sm-5">Armor</dt>
                                <dd class="col-sm-7 text-break" id="vehicleModalArmor" style="white-space: pre-wrap;">N/A</dd>

                                <dt class="col-sm-5">Communication Systems</dt>
                                <dd class="col-sm-7 text-break" id="vehicleModalComms" style="white-space: pre-wrap;">N/A</dd>

                                <dt class="col-sm-5">Notes</dt>
                                <dd class="col-sm-7 text-break" id="vehicleModalNotes" style="white-space: pre-wrap;">N/A</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function ($) {
            'use strict';

            var $modal = $('#vehicleDetailModal');
            if (!$modal.length) {
                return;
            }

            $modal.on('show.bs.modal', function (event) {
                var $trigger = $(event.relatedTarget);
                if (!$trigger.length) {
                    return;
                }

                var vehicle = $trigger.data('vehicle');
                if (!vehicle || typeof vehicle === 'string') {
                    var raw = typeof vehicle === 'string' && vehicle ? vehicle : ($trigger.attr('data-vehicle') || '{}');
                    try {
                        vehicle = JSON.parse(raw);
                    } catch (error) {
                        vehicle = {};
                    }
                }

                var setText = function (selector, value) {
                    var $element = $modal.find(selector);
                    if ($element.length) {
                        $element.text(value !== undefined && value !== null && value !== '' ? value : 'N/A');
                    }
                };

                $modal.find('#vehicleModalTitle').text(vehicle.name || 'Vehicle Details');

                var $image = $modal.find('#vehicleModalImage');
                var $noImage = $modal.find('#vehicleModalNoImage');
                if (vehicle.image_url) {
                    $image.attr('src', vehicle.image_url).removeClass('d-none');
                    $noImage.addClass('d-none');
                } else {
                    $image.attr('src', '').addClass('d-none');
                    $noImage.removeClass('d-none');
                }

                setText('#vehicleModalVariant', vehicle.variant);
                setText('#vehicleModalCategory', vehicle.category);
                setText('#vehicleModalManufacturer', vehicle.manufacturer);
                setText('#vehicleModalCountry', vehicle.country_of_origin);
                setText('#vehicleModalEngineType', vehicle.engine_type);
                setText('#vehicleModalPower', vehicle.engine_power_hp);
                setText('#vehicleModalSpeed', vehicle.max_speed_kph);
                setText('#vehicleModalRange', vehicle.range_km);
                setText('#vehicleModalFuel', vehicle.fuel_capacity_l);
                setText('#vehicleModalWeight', vehicle.weight_tons);
                setText('#vehicleModalCrew', vehicle.crew_capacity);
                setText('#vehicleModalPassengers', vehicle.passenger_capacity);
                setText('#vehicleModalArmament', vehicle.armament);
                setText('#vehicleModalArmor', vehicle.armor);
                setText('#vehicleModalComms', vehicle.communication_systems);
                setText('#vehicleModalNotes', vehicle.notes);
            });
        })(jQuery);
    </script>
@endpush
