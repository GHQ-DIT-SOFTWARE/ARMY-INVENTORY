@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Product</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">New Product Purchase</a></li>
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
                            <a href="{{ route('addpurchase') }}" class="btn btn-success btn-sm btn-round has-ripple"
                                data-target="#modal-report"><i class="feather icon-plus"></i> New Purchase</a>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="example" class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Product</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Date Purchased</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as  $key=> $newpurchase)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td class="align-middle">
                                            {{$newpurchase['product']['name']}}
                                        </td>

                                        <td class="align-middle">
                                            {{$newpurchase['supplier']['name']}}
                                        </td>

                                        <td class="align-middle">
                                            <span class="badge badge-success mr-1 "> {{$newpurchase->quantity}}</span>

                                        </td>
                                        <td class="align-middle">
                                            {{ date('d F, Y', strtotime($newpurchase->purchase_date)) }}

                                        </td>
                                        <td class="table-action">
                                            <a href="{{route('editpurchase',$newpurchase->id)}}" class="btn btn-primary btn-sm"><i class="feather icon-edit">
                                                </i></a>
                                            <a href="{{route('deletepurchase',$newpurchase->id)}}" class="btn btn-danger btn-sm" title="Delete Data"
                                                id="delete"><i class="feather icon-trash-2"></i></a>
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
