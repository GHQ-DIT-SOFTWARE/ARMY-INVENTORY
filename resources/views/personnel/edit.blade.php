@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Personnel Details</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Details</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Personnel.</h5>
                </div>
                <div class="card-body">
                    <h5>Bio Data</h5>
                    <hr>
                    <form action="{{ route('perupdate') }}" method="POST" id="myForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $personel->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="svcnumber" class="col-sm-3 col-form-label">Service Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="svcnumber"
                                            value="{{ $personel->svcnumber }}">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="surname"
                                            value="{{ $personel->surname }}">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mobile_no"
                                            value="{{ $personel->mobile_no }}">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="gender" value="{{ $personel->gender }}">
                                            <option value>Select Gender</option>
                                            <option {{ $personel->gender == 'Male' ? 'selected' : '' }} value="Male">MALE
                                            </option>
                                            <option {{ $personel->gender == 'Female' ? 'selected' : '' }} value="Female">
                                                FEMALE</option>
                                        </select>
                                        @error('gender')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">



                                <div class="form-group row">
                                    <label for="othernames" class="col-sm-3 col-form-label">Other Name(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="othernames"
                                            value="{{ $personel->othernames }}">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $personel->email }}">

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rank" class="col-sm-3 col-form-label col-form-label-sm">Rank</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="rank_name">
                                            <option value=" ">Select Rank</option>
                                            @foreach ($ranks as $ran)
                                                <option value="{{ $ran->id }}"
                                                    {{ $ran->id == $personel->rank_name ? 'selected' : '' }}>
                                                    {{ $ran->rank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn  btn-success">Update Record</button>
                        </div>
                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    svcnumber: {
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
                    personnel_image: {
                        required: true,
                    },
                },
                messages: {
                    svcnumber: {
                        required: 'Please Enter Your service number',
                    },
                    mobile_no: {
                        required: 'Please Enter Your Mobile Number',
                    },
                    email: {
                        required: 'Please Enter Your Email',
                    },
                    gender: {
                        required: 'Please Enter Your Address',
                    },
                    personnel_image: {
                        required: 'Please Select one Image',
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


    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
<script src="{{ asset('assets/js/pages/todo.js') }}"></script>
