@extends('admin.admin_master')
@section('admin')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">History</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Main</a></li>
                    <li class="breadcrumb-item"><a href="#!">Item History</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
<!-- [ Main Content ] start -->



        <div class="row">

            <!-- Scroll - Vertical table start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>History -  Eletronic Items Loaned</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="scr-vrt-dt" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="select_all"
                                                    value="1" id="contactstable-select-all">
                                                <label class="custom-control-label" for="contactstable-select-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>SVC NO.</th>
                                        <th>PERSONNEL</th>
                                        <th>ITEM NAME</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>ITEM LOCATION</th>
                                        <th>STATUS</th>
                                        <th>DATE ISSUED</th>
                                        <th>ISSUED BY</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Loaned_Item as $key => $item)
                                        @php
                                            $full_name = $item->surname . ' ' . $item->othernames;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->svcnumber }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->serial_no }}</td>
                                            <td>{{ $item->item_location }}</td>
                                            <td>
                                                @if ($item->state == '1')
                                                <!--
                                                    <a href="{{ route('item.eletronic.returned', $item->id) }}"
                                                        class="badge badge-primary sm" title="ElectronicReturned"
                                                        id="ElecreturnBtn"> <i class="fas fa-check-circle"></i>-Item
                                                        Returned</a>
                                                    -->
                                                        <span class="badge badge-primary sm">Item
                                                            Returned</span>
                                                @elseif ($item->state == '0')
                                                  <!--
                                                    <a href="{{ route('item.eletronic.loaned', $item->id) }}"
                                                        class="badge badge-warning sm" title="ElectronicLoaned"
                                                        id="ElecLoanBtn">
                                                        <i class="fas fa-times"></i>- Item Loaned</a>
                                                    -->
                                                        <span class="badge badge-warning sm">Item Loaned</span>
                                                @elseif ($item->state == '2')
                                                  <span class="badge badge-success sm"></span> Item Kept
                                                @endif
                                            </td>
                                            <td>

                                               {{date('d F, Y', strtotime($item->issued_date))}}
                                            </td>
                                            <td>{{$item['issueduser']['name']}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll - Vertical table end -->
            <!-- Scroll - Vertical, Dynamic Height table start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>History -  Electronic Items Returned</h5>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="scr-vtr-dynamic" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="select_all"
                                                    value="1" id="contactstable-select-all">
                                                <label class="custom-control-label" for="contactstable-select-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>SVC NO.</th>
                                        <th>PERSONNEL</th>
                                        <th>ITEM NAME</th>
                                        <th>SERIAL NUMBER</th>

                                        <th>STATUS</th>
                                        <th>DATE RECEIVED</th>
                                        <th>RECEIVED BY</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($received_item as $key => $item)
                                        @php
                                            $full_name = $item->surname . ' ' . $item->othernames;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->svcnumber }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->serial_no }}</td>
                                            <td>
                                                @if ($item->state == '1')
                                                <span    class="badge badge-success sm">Item
                                                    Returned</span>

                                                @endif
                                            </td>
                                            <td>

                                               {{date('d F, Y', strtotime($item->receive_date))}}
                                            </td>
                                            <td>{{$item['issueduser']['name']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Scroll - Vertical, Dynamic Height table end -->

        </div>
        <!-- [ Main Content ] end -->
        <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<!-- datatable Js -->
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>

<!-- [ Main Content ] end -->
@endsection
