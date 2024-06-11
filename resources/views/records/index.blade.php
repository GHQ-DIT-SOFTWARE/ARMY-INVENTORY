@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">View</a></li>
                        <li class="breadcrumb-item"><a href="#!">Records</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">
            <div class="card user-profile-list">
                <div class="card-header">
                    <h5>Details of Eletronic Items Issued Out</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-left"><br />
                            <p>Perform these Actions on Record.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('item.issue.electronic.create') }}" class="btn  btn-primary "
                                    aria-haspopup="true" aria-expanded="false"><i class="feather icon-plus"></i>Create
                                    Record</a>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
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
                                        @foreach ($electronicissue as $key => $item)
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

                                                            <span class="badge badge-primary sm">Item
                                                                Returned</span>
                                                    @elseif ($item->state == '0')

                                                            <span class="badge badge-warning sm">Item Loaned</span>
                                                    @elseif ($item->state == '2')
                                                      <span class="badge badge-success sm">Item Keep</span>
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
            </div>
        </div>
        <!-- liveline-section end -->
    </div>
    <!-- [ Main Content ] end -->
@endsection
