@extends('admin.admin_master')
@section('title', 'Weapon Library')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Weapon Items</h5>
                        <p class="text-muted mb-0">Detailed platform data for Ghana Armed Forces small arms.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('weapons.dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item">Weapons</li>
                        <li class="breadcrumb-item active">Platforms</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Registered Weapons</h5>
            <a href="{{ route('weapons.platforms.create') }}" class="btn btn-sm btn-primary">Add Weapon</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Weapon</th>
                            <th>Variant</th>
                            <th>Category</th>
                            <th>Caliber</th>
                            <th>Effective Range (m)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($weapons as $weapon)
                            @php
                                $weaponData = [
                                    'name' => $weapon->name,
                                    'variant' => $weapon->variant,
                                    'category' => optional($weapon->category)->name,
                                    'caliber' => $weapon->caliber,
                                    'manufacturer' => $weapon->manufacturer,
                                    'country_of_origin' => $weapon->country_of_origin,
                                    'barrel_length_mm' => $weapon->barrel_length_mm ? number_format($weapon->barrel_length_mm, 0) . ' mm' : null,
                                    'overall_length_mm' => $weapon->overall_length_mm ? number_format($weapon->overall_length_mm, 0) . ' mm' : null,
                                    'weight_kg' => $weapon->weight_kg ? number_format($weapon->weight_kg, 2) . ' kg' : null,
                                    'muzzle_velocity_mps' => $weapon->muzzle_velocity_mps ? number_format($weapon->muzzle_velocity_mps, 0) . ' m/s' : null,
                                    'rate_of_fire_rpm' => $weapon->rate_of_fire_rpm ? number_format($weapon->rate_of_fire_rpm, 0) . ' rpm' : null,
                                    'effective_range_m' => $weapon->effective_range_m ? number_format($weapon->effective_range_m, 0) . ' m' : null,
                                    'maximum_range_m' => $weapon->maximum_range_m ? number_format($weapon->maximum_range_m, 0) . ' m' : null,
                                    'configuration' => $weapon->configuration,
                                    'ammunition_types' => $weapon->ammunition_types,
                                    'notes' => $weapon->notes,
                                    'image_url' => $weapon->image_path ? asset('storage/' . $weapon->image_path) : null,
                                ];
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $weapon->name }}</td>
                                <td>{{ $weapon->variant ?? '' }}</td>
                                <td>{{ optional($weapon->category)->name ?? '' }}</td>
                                <td>{{ $weapon->caliber ?? '' }}</td>
                                <td>{{ $weapon->effective_range_m ? number_format($weapon->effective_range_m) : 'N/A' }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" data-toggle="modal" data-target="#weaponDetailModal" data-weapon='@json($weaponData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)'>View</button>
                                    <a href="{{ route('weapons.platforms.edit', $weapon) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                    <form action="{{ route('weapons.platforms.destroy', $weapon) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this weapon?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No weapons have been catalogued yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $weapons->links() }}
        </div>
    </div>

    <div class="modal fade" id="weaponDetailModal" tabindex="-1" role="dialog" aria-labelledby="weaponModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weaponModalTitle">Weapon Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-4 text-center">
                            <img id="weaponModalImage" src="" alt="Weapon image" class="img-fluid rounded border d-none">
                            <div id="weaponModalNoImage" class="text-muted small">No image available</div>
                        </div>
                        <div class="col-md-8">
                            <dl class="row mb-0">
                                <dt class="col-sm-5">Variant</dt>
                                <dd class="col-sm-7" id="weaponModalVariant">N/A</dd>

                                <dt class="col-sm-5">Category</dt>
                                <dd class="col-sm-7" id="weaponModalCategory">N/A</dd>

                                <dt class="col-sm-5">Caliber</dt>
                                <dd class="col-sm-7" id="weaponModalCaliber">N/A</dd>

                                <dt class="col-sm-5">Manufacturer</dt>
                                <dd class="col-sm-7" id="weaponModalManufacturer">N/A</dd>

                                <dt class="col-sm-5">Country of Origin</dt>
                                <dd class="col-sm-7" id="weaponModalCountry">N/A</dd>

                                <dt class="col-sm-5">Barrel Length</dt>
                                <dd class="col-sm-7" id="weaponModalBarrel">N/A</dd>

                                <dt class="col-sm-5">Overall Length</dt>
                                <dd class="col-sm-7" id="weaponModalOverall">N/A</dd>

                                <dt class="col-sm-5">Weight</dt>
                                <dd class="col-sm-7" id="weaponModalWeight">N/A</dd>

                                <dt class="col-sm-5">Muzzle Velocity</dt>
                                <dd class="col-sm-7" id="weaponModalVelocity">N/A</dd>

                                <dt class="col-sm-5">Rate of Fire</dt>
                                <dd class="col-sm-7" id="weaponModalRate">N/A</dd>

                                <dt class="col-sm-5">Effective Range</dt>
                                <dd class="col-sm-7" id="weaponModalEffective">N/A</dd>

                                <dt class="col-sm-5">Maximum Range</dt>
                                <dd class="col-sm-7" id="weaponModalMaximum">N/A</dd>

                                <dt class="col-sm-5">Configuration</dt>
                                <dd class="col-sm-7 text-break" id="weaponModalConfiguration" style="white-space: pre-wrap;">N/A</dd>

                                <dt class="col-sm-5">Ammunition Types</dt>
                                <dd class="col-sm-7 text-break" id="weaponModalAmmo" style="white-space: pre-wrap;">N/A</dd>

                                <dt class="col-sm-5">Notes</dt>
                                <dd class="col-sm-7 text-break" id="weaponModalNotes" style="white-space: pre-wrap;">N/A</dd>
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

            var $modal = $('#weaponDetailModal');
            if (!$modal.length) {
                return;
            }

            $modal.on('show.bs.modal', function (event) {
                var $trigger = $(event.relatedTarget);
                if (!$trigger.length) {
                    return;
                }

                var weapon = $trigger.data('weapon');
                if (!weapon || typeof weapon === 'string') {
                    var raw = typeof weapon === 'string' && weapon ? weapon : ($trigger.attr('data-weapon') || '{}');
                    try {
                        weapon = JSON.parse(raw);
                    } catch (error) {
                        weapon = {};
                    }
                }

                var setText = function (selector, value) {
                    var $element = $modal.find(selector);
                    if ($element.length) {
                        $element.text(value || 'N/A');
                    }
                };

                $modal.find('#weaponModalTitle').text(weapon.name || 'Weapon Details');

                var $image = $modal.find('#weaponModalImage');
                var $noImage = $modal.find('#weaponModalNoImage');
                if (weapon.image_url) {
                    $image.attr('src', weapon.image_url).removeClass('d-none');
                    $noImage.addClass('d-none');
                } else {
                    $image.attr('src', '').addClass('d-none');
                    $noImage.removeClass('d-none');
                }

                setText('#weaponModalVariant', weapon.variant);
                setText('#weaponModalCategory', weapon.category);
                setText('#weaponModalCaliber', weapon.caliber);
                setText('#weaponModalManufacturer', weapon.manufacturer);
                setText('#weaponModalCountry', weapon.country_of_origin);
                setText('#weaponModalBarrel', weapon.barrel_length_mm);
                setText('#weaponModalOverall', weapon.overall_length_mm);
                setText('#weaponModalWeight', weapon.weight_kg);
                setText('#weaponModalVelocity', weapon.muzzle_velocity_mps);
                setText('#weaponModalRate', weapon.rate_of_fire_rpm);
                setText('#weaponModalEffective', weapon.effective_range_m);
                setText('#weaponModalMaximum', weapon.maximum_range_m);
                setText('#weaponModalConfiguration', weapon.configuration);
                setText('#weaponModalAmmo', weapon.ammunition_types);
                setText('#weaponModalNotes', weapon.notes);
            });
        })(jQuery);
    </script>
@endpush
