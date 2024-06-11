@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] end -->
    <link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
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
                        <li class="breadcrumb-item"><a href="#!">Electronic-Item</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
  <!-- Scroll - Vertical table start -->
  <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5> <span class="badge badge-primary mr-1">Scroll - Vertical Serviceable Electronic Items</span></h5>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="scr-vrt-dt" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>SRL</th>
                            <th>Item Name</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    </thead>
                    <tbody>
                        @foreach ($allservqty as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $item->product_name }}
                            </td>
                            <td>
                                {{ $item->count }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

  <!-- Scroll - Vertical, Dynamic Height table start -->
  <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>
                <span class="badge badge-primary mr-1"> Scroll - Vertical, Unserviceable Electronic Items</span>
               </h5>
        </div>
        <div class="card-body">
            <div class="dt-responsive table-responsive">
                <table id="scr-vtr-dynamic" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>SRL</th>
                            <th>Item Name</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allunservqty as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $item->product_name }}
                            </td>
                            <td>
                                {{ $item->count }}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<!-- Scroll - Vertical, Dynamic Height table end -->
<!-- Scroll - Vertical table end -->

<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<!-- datatable Js -->
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/data-basic-custom.js')}}"></script>


@endsection
