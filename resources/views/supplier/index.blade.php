@extends('admin.admin_master')
@section('admin')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Suppliers</h5>
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
                <h5>SUPPLIERS</h5>
            </div>
            <div class="card-body">

                <a href="{{route('supadd')}}" class="btn btn-primary btn-rounded waves-effect waves-light" style="float:right;"><i class="fas fa-plus-circle"> Add Supplier </i></a> <br>  <br>

                 <h4 class="card-title">Supplier All Data </h4>


                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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

                         @foreach($suppliers as $key => $supplier)
                     <tr>
                         <td> {{ $key+1}} </td>
                         <td> {{ $supplier->supplier_name }} </td>
                          <td> {{ $supplier->mobile_no }} </td>
                           <td> {{ $supplier->email }} </td>
                            <td> {{ $supplier->address }} </td>
                         <td>
                         <a href="{{route('supedit',$supplier->id)}}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

                         <a href="{{route('supdel',$supplier->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

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


    <!-- liveline-section end -->
</div>
<!-- [ Main Content ] end -->

@endsection
