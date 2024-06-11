@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">ELECTRONIC ITEMS</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Electronic Items</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('addpro') }}" class="btn btn-success btn-sm btn-round has-ripple"
                                data-target="#modal-report"><i class="feather icon-plus"></i> Add Eletronic Item</a>
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
                                    <th>Serial Number</th>
                                    <th>Status</th>
                                    <th>State</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($item->item_image==null)
                                            <img id="showImage" class="rounded avatar-lg"
                                            src="{{url('uploadimage/no_image.jpg')}}" alt="IMAGE"
                                            style="width: 50px; width: 50px; border: 1px solid #000000;">
                                            @elseif ($item->item_image !==null)
                                            <img src="{{asset($item->item_image) }}" style="width:60px; height:50px">
                                            @endif
                                        </td>
                                        <td class="align-middle">

                                            {{ $item->product_name }}

                                        </td>
                                        <td class="align-middle">
                                                {{ $item['category']['category_name'] }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $item->serial_no }}
                                        </td>
                                        <td>
                                            @if ($item->state == '1')
                                            <span class="badge badge-primary sm">INSTOCK</span>

                                        @elseif ($item->state == '0')
                                        <span class="badge badge-warning sm">ISSUED OUT</span>

                                        @endif
                                        </td>
                                        <td>
                                            @if ($item->status == '1')
                                            <a href="{{ route('item.approve', $item->id) }}"
                                                class="badge badge-primary sm" title="Approved" id="ApproveBtn"> <i
                                                    class="fas fa-check-circle"></i>- SERV</a>
                                        @elseif ($item->status == '0')
                                            <a href="{{ route('item.reschudel', $item->id) }}"
                                                class="badge badge-warning sm" title="Rescheduled" id="RescheduleBtn">
                                                <i class="fas fa-times"></i>-UNSERV </a>
                                        @endif
                                        </td>
                                        <td class="table-action">
                                            <!--
                                            <a href="{{ route('total.each.eletronic.item')}}" class="btn btn-success btn-sm"><i
                                                class="feather icon-eye"> </i></a>-->
                                            <a href="{{ route('editpro', $item->id) }}" class="btn btn-primary btn-sm"><i
                                                    class="feather icon-edit"> </i></a>
                                            <a href="{{ route('deletepro', $item->id) }}" class="btn btn-danger btn-sm"
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
  <!--
                                            <a href="{{ route('item.eletronic.unavailability', $item->id) }}"
                                                class="badge badge-warning sm" title="ElectronicUnavailability" id="UnAvailableEletronicBtn">
                                                <i class="fas fa-times"></i>-ISSUED OUT</a>
                                            -->
                                              <!--
                                            <a href="{{ route('item.eletronic.availability', $item->id) }}"
                                                class="badge badge-primary sm" title="Electronicavailability" id="AvailableEletronicBtn"> <i
                                                    class="fas fa-check-circle"></i>-INSTOCK</a>
                                            -->
