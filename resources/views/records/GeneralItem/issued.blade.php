@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Active General Item Loans</h5>
                        <p class="text-muted mb-0">Items currently on loan from the stock catalogue.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item">Issued Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Currently On Loan</h5>
            <a href="{{ route('controls.general-items.issue') }}" class="btn btn-primary"><i class="feather icon-plus"></i> Issue Item</a>
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
                                <td colspan="8" class="text-center text-muted py-4">No active loans at the moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
