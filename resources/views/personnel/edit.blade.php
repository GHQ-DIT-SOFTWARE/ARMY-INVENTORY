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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <nav class="navbar justify-content-between p-0 align-items-center">
                    <h5>Update Personnel Details</h5>
                </nav>
            </div>
        </div>

        <div class="row" style="background-color: #ffffff; margin:15px 0 15px 0">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" id="showImage"
                        src="{{ $personel->personnel_image ? asset($personel->personnel_image) : asset('upload/personnel.jpeg') }}"
                        alt="Personnel Photo"><span class="font-weight-bold">Personnel Photo</span><span> </span>
                    <form action="{{ route('personal-update') }}" method="POST" id="myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <input name="personnel_image" class="form-control" type="file" id="image"
                                value="{{ $personel->personnel_image }}">
                            @error('personnel_image')
                                <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
            </div>

            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <h4>Personal Details</h4>
                    <hr>
                    <div class="row mt-2" style="margin-left:10px">
                        <input type="hidden" name="uuid" value="{{ $personel->uuid }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="surname"
                                            value="{{ $personel->surname }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="othernames" class="col-sm-3 col-form-label">Other Name(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="othernames"
                                            value="{{ $personel->othernames }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="first_name"
                                            value="{{ $personel->first_name }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="mobile_no"
                                            value="{{ $personel->mobile_no }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender" value="{{ $personel->gender }}">
                                            <option value>Select Gender</option>
                                            <option {{ $personel->gender == 'MALE' ? 'selected' : '' }} value="MALE">MALE
                                            </option>
                                            <option {{ $personel->gender == 'FEMALE' ? 'selected' : '' }} value="FEMALE">
                                                FEMALE</option>
                                        </select>
                                        @error('gender')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="height" class="col-sm-3 col-form-label">Height</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="height"
                                            value="{{ $personel->height }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="blood_group" class="col-sm-3 col-form-label">Blood Group</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="blood_group"
                                            value="{{ $personel->blood_group }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="virtual_mark" class="col-sm-3 col-form-label">V/Mark</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="virtual_mark"
                                            value="{{ $personel->virtual_mark }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="">
                        <h4 class="">Service Details</h4>
                        <hr>
                    </div>
                    <div class="row mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="arm_of_service" class="col-sm-4 col-form-label col-form-label-sm">Arm of
                                        Service</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="arm_of_service">
                                            <option value=" ">Select Army</option>
                                            @foreach ($service as $ser)
                                                <option value="{{ $ser->id }}"
                                                    {{ $ser->id == $personel->arm_of_service ? 'selected' : '' }}>
                                                    {{ $ser->arm_of_service }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="svcnumber" class="col-sm-4 col-form-label">Service Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="svcnumber"
                                            value="{{ $personel->svcnumber }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $personel->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Service Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control  select2" name="service_category"
                                            value="{{ $personel->service_category }}">
                                            <option value>Select </option>
                                            <option {{ $personel->service_category == 'OFFICER' ? 'selected' : '' }}
                                                value="OFFICER">OFFICER</option>
                                            <option {{ $personel->service_category == 'SOLDIER' ? 'selected' : '' }}
                                                value="SOLDIER">SOLDIER</option>
                                        </select>
                                        @error('service_category')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rank" class="col-sm-3 col-form-label col-form-label-sm">Rank</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="rank_id">
                                            <option value=" ">Select Rank</option>
                                            @foreach ($ranks as $ran)
                                                <option
                                                    value="{{ $ran->id }}"{{ $ran->id == $personel->rank_id ? 'selected' : '' }}>
                                                    {{ $ran->rank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rank" class="col-sm-3 col-form-label col-form-label-sm">Unit</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="unit_id">
                                            <option value=" ">Select Unit</option>
                                            @foreach ($unit as $uni)
                                                <option
                                                    value="{{ $uni->id }}"{{ $uni->id == $personel->unit_id ? 'selected' : '' }}>
                                                    {{ $uni->unit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                </form>
            </div>
        </div>
    </div>
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
