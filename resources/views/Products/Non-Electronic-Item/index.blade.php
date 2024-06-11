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
                        <li class="breadcrumb-item"><a href="#!">General Items</a></li>
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
                        <div class="col-sm-6 text-right">
                            <a href="{{route('add.nonpro')}}" class="btn btn-success btn-sm btn-round has-ripple"
                                data-target="#modal-report"> Add General Item</a>
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
                                    <th>State</th>
                                    <th>Status</th>


                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($non_electronic as $key => $nonelec)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($nonelec->item_image==null)
                                            <img id="showImage" class="rounded avatar-lg"
                                            src="{{ url('nonelectronics/no_image.jpg') }}" alt="IMAGE"
                                            style="width: 50px; width: 50px; border: 1px solid #000000;">
                                            @elseif ($nonelec->item_image !==null)
                                            <img src="{{ asset($nonelec->item_image) }}" style="width:60px; height:50px">
                                            @endif
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
                                            @if ($nonelec->state == '1')
                                            <span class="badge badge-primary sm">INSTOCK</span>

                                        @elseif ($nonelec->state == '0')
                                        <span class="badge badge-warning sm">ISSUED OUT</span>

                                        @endif
                                        </td>
                                        <td>
                                            @if ($nonelec->status == '1')
                                            <a href="{{ route('item.ser', $nonelec->id) }}"
                                                class="badge badge-primary sm" title="Ser" id="serBtn"> <i
                                                    class="fas fa-check-circle"></i>-SERV</a>
                                        @elseif ($nonelec->status == '0')
                                            <a href="{{ route('item.unserv', $nonelec->id) }}"
                                                class="badge badge-warning sm" title="Unser" id="UnserBtn">
                                                <i class="fas fa-times"></i>-UNSERV </a>
                                        @endif

                                        </td>

                                        <td class="table-action">
                                            <!--
                                            <a href="{{route('total.each.general.item')}}" class="btn btn-success btn-sm"><i
                                                class="feather icon-eye"> </i></a>-->
                                            <a href="{{route('edit.nonpro',$nonelec->id)}}" class="btn btn-primary btn-sm"><i
                                                    class="feather icon-edit"> </i></a>
                                            <a href="{{ route('delete.nonpro', $nonelec->id) }}" class="btn btn-danger btn-sm"
                                                title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>
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
