@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Issue Details</h5>
                        <p class="text-muted mb-0">Reference: {{ $issue->invoice_no ?? 'N/A' }}</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('controls.general-items.records') }}">General Items</a></li>
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>
                        <li class="breadcrumb-item">Issue Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Allocation Summary</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted">Issued On</dt>
                        <dd class="col-sm-7">{{ optional($issue->date ?? $issue->created_at)->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-5 text-muted">Issued By</dt>
                        <dd class="col-sm-7">{{ optional($issue->createdBy)->name ?? 'System' }}</dd>

                        <dt class="col-sm-5 text-muted">Issued To</dt>
                        <dd class="col-sm-7">{{ $issuedToType }} &mdash; {{ $issuedTo }}</dd>

                        <dt class="col-sm-5 text-muted">Status</dt>
                        <dd class="col-sm-7">
                            @if ((int) $issue->status === 1)
                                <span class="badge badge-success">Returned</span>
                            @else
                                <span class="badge badge-warning">On Loan</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5 text-muted">Return Confirmed</dt>
                        <dd class="col-sm-7">{{ optional($issue->confirmed_issued)->format('d M Y H:i') ?? 'Pending' }}</dd>

                        @if (! empty($issue->remarks))
                            <dt class="col-sm-5 text-muted">Remarks</dt>
                            <dd class="col-sm-7">{{ $issue->remarks }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Item Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted">Item Name</dt>
                        <dd class="col-sm-7">{{ optional($issue->issuedoutitem)->item_name ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Category</dt>
                        <dd class="col-sm-7">{{ optional(optional($issue->issuedoutitem)->category)->category_name ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Sub Category</dt>
                        <dd class="col-sm-7">{{ optional(optional($issue->issuedoutitem)->subcategory)->sub_category_name ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Quantity Issued</dt>
                        <dd class="col-sm-7">{{ number_format($issue->qty) }}</dd>

                        <dt class="col-sm-5 text-muted">Size / Variant</dt>
                        <dd class="col-sm-7">{{ $issue->sizes ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Description</dt>
                        <dd class="col-sm-7">{{ $issue->description ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="{{ url()->previous() }}" class="btn btn-light"><i class="feather icon-arrow-left"></i> Back</a>
        @if ((int) $issue->status === 0)
            <a href="{{ route('controls.general-items.mark-returned', $issue->id) }}" class="btn btn-success"><i class="feather icon-check"></i> Mark Returned</a>
        @else
            <a href="{{ route('controls.general-items.mark-loaned', $issue->id) }}" class="btn btn-outline-primary"><i class="feather icon-refresh-ccw"></i> Reopen Issue</a>
        @endif
    </div>
@endsection
