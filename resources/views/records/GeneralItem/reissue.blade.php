@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Re-Issue General Control Item</h5>
                        <p class="text-muted mb-0">Invoice reference: {{ $issue->invoice_no ?? 'N/A' }}</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.returned') }}">Returned Items</a></li>
                        <li class="breadcrumb-item">Re-Issue</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Available Stock</span>
                    <h3 class="mt-2 mb-1">{{ number_format($summary['availableStock']) }}</h3>
                    <span class="text-muted small">Current quantity in inventory</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Active Loans</span>
                    <h3 class="mt-2 mb-1 text-warning">{{ number_format($summary['activeLoans']) }}</h3>
                    <span class="text-muted small">Open allocations for this item</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Loans</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($summary['returnedLoans'] + $summary['activeLoans']) }}</h3>
                    <span class="text-muted small">Historical allocations for this item</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Previously Issued Qty</span>
                    <h3 class="mt-2 mb-1 text-primary">{{ number_format($issue->qty) }}</h3>
                    <span class="text-muted small">Amount from the last transaction</span>
                </div>
            </div>
        </div>
    </div>

    @if (($item->qty ?? 0) <= 0)
        <div class="alert alert-warning">
            This item currently has no available stock. Please replenish the stock before re-issuing.
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Re-Issue Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('controls.general-items.reissue', $issue->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-muted text-uppercase small d-block">Selected Item</label>
                            <h4 class="mb-1">{{ optional($item)->item_name ?? 'N/A' }}</h4>
                            <p class="text-muted mb-0">
                                Category: {{ optional(optional($item)->category)->category_name ?? 'N/A' }} |
                                Sub Category: {{ optional(optional($item)->subcategory)->sub_category_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold d-block">Issue To</label>
                            @php
                                $defaultIssueTo = $issue->unit_id ? 'unit' : 'personnel';
                            @endphp
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="issue_to" id="issue_to_unit" value="unit"
                                    {{ old('issue_to', $defaultIssueTo) === 'unit' ? 'checked' : '' }}>
                                <label class="form-check-label" for="issue_to_unit">Unit</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="issue_to" id="issue_to_personnel" value="personnel"
                                    {{ old('issue_to', $defaultIssueTo) === 'personnel' ? 'checked' : '' }}>
                                <label class="form-check-label" for="issue_to_personnel">Personnel</label>
                            </div>
                        </div>
                        <div class="form-group" id="unit-picker" style="display: none;">
                            <label for="unit_id">Select Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control select2">
                                <option value="">-- Choose Unit --</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ old('unit_id', $issue->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->unit_name }}
                                    </option>
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
                                        $defaultUuid = $defaultPersonnel?->uuid ?? null;
                                    @endphp
                                    <option value="{{ $personnel->uuid }}"
                                        {{ old('personnel_uuid', $defaultUuid) == $personnel->uuid ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('personnel_uuid')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="number" min="1" class="form-control" id="quantity" name="quantity"
                                    value="{{ old('quantity', $issue->qty) }}">
                                @error('quantity')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-muted">Available Stock</label>
                                <div class="form-control-plaintext">{{ number_format($item->qty ?? 0) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Additional instructions or reference">{{ old('notes') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="text-muted small">Previous Remarks</label>
                            <div class="border rounded p-2 bg-light">
                                {{ $issue->remarks ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('controls.general-items.returned') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="feather icon-refresh-ccw"></i> Re-Issue</button>
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

            $('input[name="issue_to"]').on('change', toggleRecipientFields);
            toggleRecipientFields();
        })();
    </script>
@endsection
