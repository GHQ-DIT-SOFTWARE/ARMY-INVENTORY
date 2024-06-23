@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Item Issue Voucher </h5>
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
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ISSUE AND RECEIPT VOUCHER</h5>
            <table class="table table-xs" style="width:100%; ">
                <tr>
                    <th>Defence Form G. 1033</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>Voucher must accompany Store if practicable</td>
                    <td style="border: 1px solid black;">Issue Voucher No. and Date</td>
                    <td style="border: 1px solid black;">{{ $aggregatedItem->invoice_no }}</td>
                    <td style="border: 1px solid black;">RECEIPT Voucher No. and Date</td>
                    <td style="border: 1px solid black;"> Generate No</td>
                </tr>
                <tr>
                    <td>Office Stamp</td>
                    <td style="border: 1px solid black;">Account</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;">Account</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td>Consignor (Original and Triplicate)</td>
                    <td style="border: 1px solid black;">Issued By</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;">Issued To</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td>Consignor (Duplicate)</td>
                    <td style="border: 1px solid black;">Authority for Issue</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;">Date and Mode of Conveyance</td>
                    <td style="border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td rowspan="3">Signature</td>
                    <td rowspan="3" style="border: 1px solid black;">Sheet No</td>
                    <td rowspan="3" style="border: 1px solid black;">No of Sheets </td>
                    <td colspan="2" style="border: 1px solid black; text-align:center;"> For Store Depot use Only</td>
                </tr>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid black; text-align:center;">Carries/Convey</td>
                </tr>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid black; text-align:center;">Note No. and Date</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <form method="POST" action="{{ route('update-issued-items') }}">
                @csrf
                <input type="hidden" name="uuid" value="{{ $aggregatedItem->uuid }}">
                <input type="hidden" name="invoice_no" value="{{ $aggregatedItem->invoice_no }}">
                <table class="table table-sm table-bordered" width="100%" id="itemTable">
                    <thead style="text-align: center">
                        <tr>
                            <th>Sub Category</th>
                            <th>Item Name</th>
                            <th>Size</th>
                            <th>Quantity Requested</th>
                            <th>Quantity Received</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Remarks</th>

                        </tr>
                        <tr>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>
                            <td>(1)</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aggregatedItem->items as $index => $data)
                            <tr>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
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
