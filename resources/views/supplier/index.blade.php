@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Company(Suppliers)</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">View</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
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
                    <h5>Companies</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('supadd') }}" class="btn btn-primary btn-rounded waves-effect waves-light"
                        style="float:right;"><i class="fas fa-plus-circle"> Add Supplier </i></a> <br> <br>
                    <table id="example" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Mobile Number </th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $key => $supplier)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $supplier->company_name }} </td>
                                    <td> {{ $supplier->mobile_no }} </td>
                                    <td> {{ $supplier->email }} </td>
                                    <td> {{ $supplier->address }} </td>
                                    <td>
                                        <a href="{{ route('supedit', $supplier->uuid) }}" class="btn btn-info sm"
                                            title="Edit Data"> <i class="fas fa-edit"></i> </a>
                                        <a href="{{ route('supdel', $supplier->uuid) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
