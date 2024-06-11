@extends('admin.admin_master')
@section('admin')

<!-- [ Main Content ] start -->

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">DIT IMS</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Instock Item</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Instock Items</h5>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group fill">
                                    <div class="col-sm-6 text-right">
                                        <a href="{{route('viewpro')}}" class="btn btn-success btn-sm btn-round has-ripple"
                                            data-target="#modal-report"><i class="feather icon-plus"></i>Electronic Items</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group fill">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="col-sm-6 text-right">
                                        <a href="{{route('view.nonpro')}}" class="btn btn-warning btn-sm btn-round has-ripple"
                                            data-target="#modal-report"><i class="feather icon-plus"></i>General Items</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
@endsection
