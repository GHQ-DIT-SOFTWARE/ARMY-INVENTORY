@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] end -->

    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">DIT MIS</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">General-Item</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- customar project  start -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6">
                        </div>
                       
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="example" class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>SL</th>
                                    <th></th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Body Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allData as $key => $nonelec)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ asset($nonelec->item_image) }}" style="width:60px; height:50px">
                                        </td>
                                        <td class="align-middle">
                                            {{ $nonelec->product_name }}
                                        </td>

                                        <td class="align-middle">
                                            {{ $nonelec['category']['category_name'] }}
                                        </td>

                                        <td class="align-middle">
                                            {{ $nonelec->body_no }}

                                        </td>
                                        <td>
                                            @if ($nonelec->status == '0')
                                                <span class="badge badge-warning mr-1 ">Unserviceable</span>
                                            @elseif($nonelec->status == '1')
                                                <span class="badge badge-primary mr-1 ">Serviceable</span>
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
@endsection
