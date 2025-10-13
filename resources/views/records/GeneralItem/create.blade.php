@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issue General Control Items</h5>
                        <p class="text-muted mb-0">Allocate available stock items to units or individual personnel.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Issue</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Available Categogies</span>
                    <h3 class="mt-2 mb-1">{{ number_format($summary['availableItems']) }}</h3>
                    <span class="text-muted small">Distinct stock catalogue entries</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Stock</span>
                    <h3 class="mt-2 mb-1">{{ number_format($summary['totalStock']) }}</h3>
                    <span class="text-muted small">Items currently in inventory</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Units</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($summary['units']) }}</h3>
                    <span class="text-muted small">Available destinations</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Personnel</span>
                    <h3 class="mt-2 mb-1 text-primary">{{ number_format($summary['personnels']) }}</h3>
                    <span class="text-muted small">Eligible individuals</span>
                </div>
            </div>
        </div>
    </div>


    @if ($items->isEmpty())
        <div class="alert alert-warning">
            No stock items are currently available for issuance. Please add inventory in the Stock Items module first.
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Issuance Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('controls.general-items.issue.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold d-block">Issue To</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="issue_to" id="issue_to_unit" value="unit" {{ old('issue_to', 'unit') === 'unit' ? 'checked' : '' }}>
                                <label class="form-check-label" for="issue_to_unit">Unit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="issue_to" id="issue_to_personnel" value="personnel" {{ old('issue_to') === 'personnel' ? 'checked' : '' }}>
                                <label class="form-check-label" for="issue_to_personnel">Personnel</label>
                            </div>
                        </div>
                        <div class="form-group" id="unit-picker" style="display: none;">
                            <label for="unit_id">Select Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control select2">
                                <option value="">-- Choose Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group" id="personnel-picker" style="display: none;">
                            <label for="personnel_uuid">Select Personnel</label>
                            <select name="personnel_uuid" id="personnel_uuid" class="form-control select2">
                                <option value="">-- Choose Personnel --</option>
                                @foreach ($personnels as $personnel)
                                    @php
                                        $label = trim(($personnel->svcnumber ?? '') . ' - ' . (($personnel->surname ?? '') . ' ' . ($personnel->othernames ?? '')));
                                    @endphp
                                    <option value="{{ $personnel->uuid }}" {{ old('personnel_uuid') == $personnel->uuid ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('personnel_uuid')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="item_id">Select Item</label>
                            <select name="item_id" id="item_id" class="form-control select2">
                                <option value="">-- Choose Item --</option>
                                @foreach ($items as $item)
                                    @php
                                        $category = optional($item->category)->category_name ?? 'Uncategorised';
                                        $subCategory = optional($item->subcategory)->sub_category_name ?? 'N/A';
                                        $label = $item->item_name . ' (' . $category . ' / ' . $subCategory . ')';
                                    @endphp
                                    <option value="{{ $item->id }}" data-qty="{{ $item->qty }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="1" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}">
                                @error('quantity')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-muted">Available Stock</label>
                                <div class="form-control-plaintext" id="available-stock">--</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Additional instructions or reference">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success"><i class="feather icon-check"></i> Issue Item</button>
                    <a href="{{ route('controls.general-items.records') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        (function() {
            function toggleRecipientFields() {
                var issueTo = $('input[name="issue_to"]:checked').val();
                $('#unit-picker').toggle(issueTo === 'unit');
                $('#personnel-picker').toggle(issueTo === 'personnel');
            }

            function updateAvailableStock() {
                var selected = $('#item_id option:selected');
                var qty = selected.data('qty');
                $('#available-stock').text(qty !== undefined ? qty : '--');
            }

            $('input[name="issue_to"]').on('change', toggleRecipientFields);
            $('#item_id').on('change', updateAvailableStock);

            toggleRecipientFields();
            updateAvailableStock();
        })();
    </script>
@endsection
