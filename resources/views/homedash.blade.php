@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Main</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->

    <div class="row">
        <!-- page statustic card start -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <a href="{{route('users.index')}}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{ $total_users }}</h4>
                                <h6 class="text-muted m-b-0">Total Users</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-file-text f-28"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="card-footer bg-c-blue">
                    <a href="{{route('users.index')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Users</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <a href="{{route('viewindex')}}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_category}}</h4>
                                <h6 class="text-muted m-b-0">Total Categories</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-bar-chart-2 f-28"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('viewindex')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Categories</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6">
            <div class="card">
                <a href="{{route('viewpro')}}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_electronic}}</h4>
                                <h6 class="text-muted m-b-0">Total Electronic Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-calendar f-28"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('viewpro')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Electronic Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <a href="{{route('view.nonpro')}}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_nonelectronic}}</h4>
                                <h6 class="text-muted m-b-0">General Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-info f-28"></i>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('view.nonpro')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage General Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('view.elec.one') }}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_ser}}</h4>
                                <h6 class="text-muted m-b-0">Serviceable-Electronic Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{ route('view.elec.one') }}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Serviceable-Electronic Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('view.elec.stazero') }}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_unser}}</h4>
                                <h6 class="text-muted m-b-0">Unserviceable-Electronic Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{ route('view.elec.stazero') }}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Unserviceable-Electronic Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('view.nonstaone')}}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_sevnon}}</h4>
                                <h6 class="text-muted m-b-0">Serviceable-General Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('view.nonstaone')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Serviceable-General Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('view.nonstazero')}}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_unsernon}}</h4>
                                <h6 class="text-muted m-b-0">UnServiceable-General Items</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('view.nonstazero')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage UnServiceable-General Items</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('item.issue.electronic.view')}}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_item_loaned}}</h4>
                                <h6 class="text-muted m-b-0">Electronic Items Loaned</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('item.issue.electronic.view')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Electronic Items Loaned</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('item.receive.electronic.view')}}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">{{$total_item_returned}}</h4>
                                <h6 class="text-muted m-b-0">Electronic Items Returned</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-check-square f-28"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card-footer bg-c-blue">
                    <a href="{{route('item.receive.electronic.view')}}">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Manage Electronic Items Returned </p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
