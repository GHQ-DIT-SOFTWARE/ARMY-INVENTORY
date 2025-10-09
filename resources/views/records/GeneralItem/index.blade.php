@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">General Control Issuance</h5>
                        <p class="text-muted mb-0">Monitor items issued from Stock Items to units and individual personnel.</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Controls</a></li>
                        <li class="breadcrumb-item">General Items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Total Issues</span>
                    <h3 class="mt-2 mb-1">{{ number_format($summary['totalIssues']) }}</h3>
                    <span class="text-muted small">Historical allocations</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Active Loans</span>
                    <h3 class="mt-2 mb-1 text-warning">{{ number_format($summary['activeLoans']) }}</h3>
                    <span class="text-muted small">Awaiting return</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Returned Items</span>
                    <h3 class="mt-2 mb-1 text-success">{{ number_format($summary['returned']) }}</h3>
                    <span class="text-muted small">Confirmed received</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">Unit Allocations</span>
                    <h3 class="mt-2 mb-1 text-info">{{ number_format($summary['unitIssues']) }}</h3>
                    <span class="text-muted small">Issued to units</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">Recent Issues</h5>
                <span class="text-muted small">Latest transactions from the stock items catalogue.</span>
            </div>
            <div class="btn-group">
                <a href="{{ route('controls.general-items.issue') }}" class="btn btn-primary"><i class="feather icon-plus"></i> Issue Item</a>
                <a href="{{ route('controls.general-items.returns') }}" class="btn btn-outline-primary">Return Items</a>
            </div>
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
                            <th>Status</th>
                            <th>Actions</th>
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
                                    @if ((int) $issue->status === 1)
                                        <span class="badge badge-success">Returned</span>
                                    @else
                                        <span class="badge badge-warning">On Loan</span>
                                    @endif
                                </td>
                                <td>
                                    @if ((int) $issue->status === 0)
                                        <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn btn-sm btn-success">
                                            <i class="feather icon-check"></i> Mark Returned
                                        </a>
                                    @else
                                        <a href="{{ route('controls.general-items.mark-loaned', $issue->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="feather icon-refresh-ccw"></i> Reopen
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No general control issues recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
