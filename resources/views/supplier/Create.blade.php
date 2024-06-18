@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <li class="breadcrumb-item"><a href="#!">Add Supplier</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Supplier </h4><br><br>
                            <form method="post" action="{{ route('supstore') }}" id="myForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group fill">
                                            <label for="exampleInputEmail1">Supplier`s Name</label>
                                            <input type="text" name="company_name" class="form-control"
                                                aria-describedby="emailHelp" placeholder="Enter supplier name" required>
                                            @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group fill">
                                            <label for="exampleInputPassword1">Address</label>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Enter supplier address" required>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group fill">
                                            <label>Mobile</label>
                                            <input type="text" name="mobile_no" class="form-control" placeholder="Mobile"
                                                required>
                                            @error('mobile_no')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group fill">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" name="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Enter email" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary waves-effect waves-light" value="Add Supplier">
                        </div>
                        <!-- end row -->

                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    supplier_name: {
                        required: true,
                    },
                    mobile_no: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    supplier_name: {
                        required: 'Please Enter Your Name',
                    },
                    mobile_no: {
                        required: 'Please Enter Your Mobile Number',
                    },
                    email: {
                        required: 'Please Enter Your Email',
                    },
                    address: {
                        required: 'Please Enter Your Address',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
