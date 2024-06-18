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
                    <h5>Add New Personnel Details</h5>
                </nav>
            </div>
        </div>

        <div class="row" style="background-color: #ffffff; margin:15px 0 15px 0">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        id="showImage" width="150px" src="{{ url('upload/personnel.jpeg') }}" alt="Card image cap"><span
                        class="font-weight-bold">Personnel Photo</span><span> </span>
                    <form action="{{ route('personal-store') }}" method="POST" id="myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <input name="personnel_image" class="form-control" type="file" id="image">
                            @error('personnel_image')
                                <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ url('upload/no_image.jpg') }}" alt="Card image cap"
                                            style="width: 100px; width: 100px; border: 1px solid #000000;">
                                    </div> --}}
                </div>
            </div>

            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <h4 class="">Personal Details</h4>
                    <hr>
                    <div class="row mt-2" style="margin-left:10px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-4 col-form-label">Surname</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="surname" placeholder="Surname"
                                            value="{{ old('surname') }}">
                                        @error('surname')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="othernames" class="col-sm-4 col-form-label">Other Name(s)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="othernames"
                                            placeholder="Other Name(s)" value="{{ old('othernames') }}">
                                        @error('othernames')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-4 col-form-label">First Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="First Name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-4 col-form-label">Mobile Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="mobile_no"
                                            placeholder="eg. 0245002022" value="{{ old('mobile_no') }}">
                                        @error('mobile_no')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-4 col-form-label">Gender</label>
                                    <div class="col-sm-8">
                                        <select class="form-control  select2" name="gender" value="{{ old('gender') }}">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                        @error('gender')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="height" class="col-sm-4 col-form-label">Height</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="height"
                                            placeholder="Height in ft" value="{{ old('height') }}">
                                        @error('height')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="blood_group" class="col-sm-4 col-form-label">Blood Group</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="blood_group"
                                            placeholder="Blood Group" value="{{ old('blood_group') }}">
                                        @error('blood_group')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="virtual_mark" class="col-sm-4 col-form-label">V/Mark</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="virtual_mark"
                                            placeholder="Visual Mark" value="{{ old('virtual_mark') }}">
                                        @error('first_name')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
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
                    <div class="row mt-2" style="margin-left:10px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="rank" class="col-sm-4 col-form-label col-form-label-sm">Arm of
                                        Service</label>
                                    <div class="col-sm-8">
                                        <select name="arm_of_service" id="service_id" class="form-control select2"
                                            aria-label="Default select example" value="{{ old('arm_of_service') }}">
                                            <option value=" ">Select service</option>
                                            @foreach ($service as $arms)
                                                <option value="{{ $arms->id }}">{{ $arms->arm_of_service }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="svcnumber" class="col-sm-4 col-form-label">Service Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="svcnumber"
                                            placeholder="Enter Svc Number" value="{{ old('svcnumber') }}">
                                        @error('svcnumber')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" name="email" placeholder="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group row">
                                    <label for="service" class="col-sm-4 col-form-label">Service Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-control  select2" name="service_category"
                                            value="{{ old('service_category') }}">
                                            <option value=" ">Select Category</option>
                                            <option value="OFFICER">OFFICER</option>
                                            <option value="SOLDIER">SOLDIER</option>
                                        </select>
                                        @error('service_category')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rank" class="col-sm-4 col-form-label col-form-label-sm">Rank</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="rank_id" id="rank_id"
                                            value="{{ old('rank_id') }}" required>
                                            <option value=" ">Select Rank</option>
                                            @foreach ($ranks as $ran)
                                                <option value="{{ $ran->id }}">{{ $ran->rank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="rank" class="col-sm-4 col-form-label col-form-label-sm">Unit</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="unit_name" id="unit_id"
                                            value="{{ old('unit_name') }}" required>
                                            <option value=" ">Select Unit</option>
                                            @foreach ($unit as $uni)
                                                <option value="{{ $uni->id }}">{{ $uni->unit_name }}</option>
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
                            <button type="submit" class="btn  btn-primary">Save Record</button>
                        </div>
                    </div>
                </div>


                </form>
            </div>
        </div>
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
