@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">General Items Records</h5>
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
                    <h5>Details of Items Issued Out</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-left"><br />
                            <p>Perform these Actions on Record.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('item.issue.general.create') }}" class="btn  btn-primary "
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
                                            <th>BODY NUMBER</th>
                                            <th>ITEM LOCATION</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($generalview as $key => $item)
                                            @php
                                                $full_name = $item->surname . ' ' . $item->othernames;
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->svcnumber }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->body_no }}</td>
                                                <td>{{ $item->item_location }}</td>
                                                <td>
                                                    @if ($item->status == '1')
                                                        <a href="{{ route('item.general.returned', $item->id) }}"
                                                            class="badge badge-primary sm" title="GeneralReturn"
                                                            id="GeneralreturnBtn"> <i class="fas fa-check-circle"></i>-Item
                                                            Returned</a>
                                                    @elseif ($item->status == '0')
                                                        <a href="{{ route('item.general.loaned', $item->id) }}"
                                                            class="badge badge-warning sm" title="GeneralonLoan"
                                                            id="GeneraloanBtn">
                                                            <i class="fas fa-times"></i>- Item Loaned</a>
                                                    @elseif ($item->status == '2')
                                                        <span class="badge badge-success mr-1">Item Kept</span>
                                                    @endif
                                                </td>
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
