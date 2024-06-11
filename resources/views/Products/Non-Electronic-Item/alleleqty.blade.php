@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] end -->

    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">ITEM</h5>
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
                        <div class="col-sm-6 text-right">
                            <a href="{{ route('addpro') }}" class="btn btn-success btn-sm btn-round has-ripple"
                                data-target="#modal-report"><i class="feather icon-plus"></i> Add Eletronic-Item</a>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="example" class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Item Name</th>
                                    <th>Total</th>
                                    <th>Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totalProductsQty as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->count }}</td>
                                        <td>{{ $item['category']['category_name'] }}</td>

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
