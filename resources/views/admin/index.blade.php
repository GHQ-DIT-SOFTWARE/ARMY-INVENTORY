@extends('admin.admin_master')
@section('admin')
    <style>
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Main</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card" style="background-color:rgb(255, 249, 249);">
            {{-- <h1 class="font-weight-normal" style="text-align: center; color:rgb(19, 20, 20);"><b
                    class="font-weight-bolder">GAF LOGISTICS MANAGEMENT SYSTEM</b></h1> --}}
            <img src="{{ asset('assets/images/WELCOME.png') }}"alt=""
                class="img-fluid">
            {{-- <img src="{{ asset('assets/images/auth/new.png') }}" alt="" class="img-fluid"> --}}
        </div>
    </div>
@endsection
