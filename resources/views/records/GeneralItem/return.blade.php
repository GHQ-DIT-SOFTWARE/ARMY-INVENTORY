@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Return General Control Items</h5>
                        <p class="text-muted mb-0">Confirm the receipt of items that have been issued out.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Return Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Items Awaiting Return</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Issued To</th>
                            <th>Type</th>
                            <th>Issued On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($issues as $index => $issue)
                            @php
                                $isUnit = !is_null($issue->unit_id);
                                $issuedTo = $isUnit ? optional($issue->unit)->unit_name : ($issue->description ?? 'Personnel');
                                $issuedType = $isUnit ? 'Unit' : 'Personnel';
                                $itemName = optional($issue->issuedoutitem)->item_name ?? 'N/A';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $issue->invoice_no ?? 'N/A' }}</td>
                                <td>{{ $itemName }}</td>
                                <td>{{ number_format($issue->qty) }}</td>
                                <td>{{ $issuedTo }}</td>
                                <td>{{ $issuedType }}</td>
                                <td>{{ optional($issue->date ?? $issue->created_at)->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('controls.general-items.show', $issue->id) }}" class="btn btn-outline-secondary">
                                            <i class="feather icon-eye"></i> View
                                        </a>
                                        <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn btn-success">
                                            <i class="feather icon-log-in"></i> Return
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">There are no items awaiting return.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
