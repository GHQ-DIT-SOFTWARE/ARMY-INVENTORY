@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Item </h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Items</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ route('confirm-quantity') }} --}}<div class="card">

        <div class="card-body">
            <h4 class="card-title">Issue/Receipt Voucher</h4>
            <form method="POST" action="{{ route('update-issued-items') }}">
                @csrf
                <input type="hidden" name="uuid" value="{{ $aggregatedItem->uuid }}">
                <input type="hidden" name="invoice_no" value="{{ $aggregatedItem->invoice_no }}">
                <table class="table table-bordered" id="itemTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Item Name</th>
                            <th>Size</th>
                            <th>Quantity Requested</th>
                            <th>Confirm Quantity</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Invoice No</th> <!-- Added column for Invoice No -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aggregatedItem->items as $index => $data)
                            <tr>
                                <td>{{ $data['CATEGORY_ID'] ?? 'Unknown Category' }}</td>
                                <td>{{ $data['SUB_CATEGORY'] ?? 'Unknown Sub Category' }}</td>
                                <td>{{ $itemNames[$data['ITEM_ID']] ?? 'Unknown Item' }}</td>
                                <td>{{ $data['SIZES'] ?? 'Unknown Size' }}</td>
                                <td>{{ $data['QTY'] ?? 'Unknown Quantity' }}</td>
                                <td>
                                    <input type="text" class="form-control" name="confirm_qty[{{ $index }}]"
                                        placeholder="Confirm Qty" value="{{ old('confirm_qty.' . $index) }}">
                                    <input type="hidden" name="item_data[{{ $index }}][ITEM_ID]"
                                        value="{{ $data['ITEM_ID'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][CATEGORY_ID]"
                                        value="{{ $data['CATEGORY_ID'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][SUB_CATEGORY]"
                                        value="{{ $data['SUB_CATEGORY'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][SIZES]"
                                        value="{{ $data['SIZES'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][QTY]"
                                        value="{{ $data['QTY'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][UNIT_ID]"
                                        value="{{ $data['UNIT_ID'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][DESCRIPTION]"
                                        value="{{ $data['DESCRIPTION'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][STATUS]"
                                        value="{{ $data['STATUS'] }}">
                                    <input type="hidden" name="item_data[{{ $index }}][INVOICE_NO]"
                                        value="{{ $aggregatedItem->invoice_no }}"> <!-- Add invoice_no here -->
                                </td>
                                <td>{{ $data['UNIT_ID'] ?? 'Unknown Unit' }}</td>
                                <td>{{ $data['DESCRIPTION'] ?? 'No Description' }}</td>
                                <td>
                                    @if ($data['STATUS'] == 0)
                                        <span class="badge badge-warning">Pending Issuance</span>
                                    @else
                                        <span class="badge badge-success">Issued</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="remarks[{{ $index }}]"
                                        placeholder="Remarks" value="{{ old('remarks.' . $index) }}">
                                </td>
                                <td>{{ $aggregatedItem->invoice_no }}</td> <!-- Display invoice_no -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

    </div>

    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Issue Items</h4>
            <table class="table table-bordered" id="itemTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Item Name</th>
                        <th>Size</th>
                        <th>Quantity Requested</th>
                        <th>Confirm Quantity</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aggregatedItem->items as $data)
                        <tr>
                            <td>{{ $data['CATEGORY_ID'] ?? 'Unknown Category' }}</td>
                            <td>{{ $data['SUB_CATEGORY'] ?? 'Unknown Sub Category' }}</td>
                            <td>{{ $itemNames[$data['ITEM_ID']] ?? 'Unknown Item' }}</td>
                            <td>{{ $data['SIZES'] ?? 'Unknown Size' }}</td>
                            <td>{{ $data['QTY'] ?? 'Unknown Quantity' }}</td>
                            <td>
                                <input type="text" class="form-control" name="confirm_qty[]" placeholder="Confirm Qty">
                            </td>
                            <td>{{ $data['UNIT_ID'] ?? 'Unknown Unit' }}</td>
                            <td>{{ $data['DESCRIPTION'] ?? 'No Description' }}</td>
                            <td>
                                <a href="{{ route('edit-item-issued-out', $aggregatedItem->uuid) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="feather icon-edit"></i> Edit
                                </a>
                                <a href="{{ route('delete-item-issued-out', $aggregatedItem->uuid) }}"
                                    class="btn btn-danger btn-sm ml-1" id="delete">
                                    <i class="feather icon-trash-2"></i> Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
@endsection
