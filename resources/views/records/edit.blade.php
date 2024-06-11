@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <!-- [ breadcrumb ] start -->
 <div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Records</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Edit New</a></li>
                    <li class="breadcrumb-item"><a href="#!">Record</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>{{ session('success') }}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif
<!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        <div class="card-header">
                            <h5>Update Record Details</h5>
                        </div>
                        <h1>Personnel Details</h1>
                        <hr>
                        <form action="{{route('course.update',$record->id)}}" method="POST" id="myForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Service
                                            Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="svcnumber"  value="{{$record->svcnumber}}" readonly>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="surname"  value="{{$record->surname}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="gender" name="gender"
                                                value="{{$record->gender}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mobile_no" name="mobile"
                                               value="{{$record->mobile}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-3 col-form-label col-form-label-sm">Rank</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="rank_id" name="rank_name"
                                                value="{{$record->rank_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Other Name(s)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="othernames" name="othernames"
                                               value="{{$record->othernames}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{$record->email}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Service:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="service_id" name="service_name"
                                                value="{{$record->service_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Unit:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="unit_id" name="unit_name"
                                                value="{{$record->unit_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="unit" class="col-sm-3 col-form-label">Personnel Image</label>
                                        <div class="col-sm-9">
                                            <input name="personnel_image" class="form-control" type="text"  id="image"  value="{{$record->personnel_image}}" readonly>

                                          </div>
                                        </div>
                                </div>
                            </div>
                            <h1 class="mt-5">Course Details</h1>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">Course Name</label>
                                        <div class="col-sm-9">
                                            <select name="course_name" id="course_id" class="form-control select2" aria-label="Default select example">
                                                <option value="">Open select course</option>
                                                 @foreach ($cours as $course)

                                                 <option value="{{$course->course_name}}" {{$course->course_name==$record->course_name ? 'selected': ''}}>{{$course->course_name}}</option>
                                                 @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">Today`s date</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="today_departure_date" class="form-control" id="todaydatefordeparture" value="{{ date("m/d/Y") }}" readonly >
                                            @error('today_departure_date')
                                                <span class="btn btn-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Departure Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="departure_date" id="demo" value="{{$record->departure_date}}">
                                            @error('departure_date')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Departure Time</label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control" name="departure_time" value="{{$record->departure_time}}">
                                            @error('departure_time')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Certification</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="certification" value="{{$record->certification}}">
                                            @error('certification')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">Country</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="country">
                                                <option value>Select Option</option>
                                              @foreach ($country as $coun)
                                              <option value="{{$coun->country_name}}" {{$coun->country_name==$record->country_name ? 'selected': ''}}>{{$coun->country_name}}</option>
                                              @endforeach

                                            </select>
                                            @error('country')
                                                <span class="btn btn-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="status" value="{{$record->status}}">
                                                <option value>Select</option>
                                                    <option {{($record->status)=='5' ? 'selected':''}} value="5">Pending</option>
                                                    <option {{($record->status)=='1' ? 'selected':''}} value="1" >Travelled</option>
                                                    <option {{($record->status)=='2' ? 'selected':''}} value="2" >Cancelled</option>
                                                    <option {{($record->status)=='3' ? 'selected':''}} value="3" >Scheduled</option>
                                                    <option {{($record->status)=='4' ? 'selected':''}} value="4" >Returned</option>

                                            </select>
                                            @error('status')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Sponsor/Self</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="sponsorship" value="{{$record->sponsorship}}">
                                                <option value>Select</option>
                                                    <option {{($record->sponsorship)=='GAF' ? 'selected':''}} value="GAF">GAF</option>
                                                    <option {{($record->sponsorship)=='SelfSponsor' ? 'selected':''}} value="SelfSponsor" >SelfSponsor</option>
                                            </select>
                                            @error('sponsorship')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Returm Date</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control"  name="arrival_date" id="back" value="{{$record->arrival_date}}">
                                            @error('arrival_date')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Returning Time</label>
                                        <div class="col-sm-9">
                                            <input type="time" class="form-control"  name="return_time" value="{{$record->return_time}}">
                                            @error('return_time')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelLg" class="col-sm-3 col-form-label ">Amount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="amount" value="{{$record->amount}}">
                                            @error('amount')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Location</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  name="location" value="{{$record->location}}">
                                            @error('location')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelLg" class="col-sm-3 col-form-label ">Remarks</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="remarks" value="{{$record->remarks}}">
                                            @error('remarks')
                                            <span class="btn btn-danger">{{$message}}</span>
                                         @enderror
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
                    </div>
                  </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var date = new Date();
            var tdate= date.getDate();
            var month=date.getMonth() +1;
            if(tdate <10){
             tdate='0'+ tdate;
            }
            if(month <10){
             month='0'+ month;
            }
            var year= date.getUTCFullYear();
            var minDate= year +"-"+ month + "-" + tdate;
            document.getElementById("demo").setAttribute('min',minDate);
         </script>

     <script>
        var date = new Date();
        var tdate= date.getDate();
        var month=date.getMonth() +1;
        if(tdate <10){
         tdate='0'+ tdate;
        }
        if(month <10){
         month='0'+ month;
        }
        var year= date.getUTCFullYear();
        var minDate= year +"-"+ month + "-" + tdate;
        document.getElementById("back").setAttribute('min',minDate);
     </script>

     <script>
         var date = new Date();
         var tdate= date.getDate();
         var month=date.getMonth() +1;
         if(tdate <10){
          tdate='0'+ tdate;
         }
         if(month <10){
          month='0'+ month;
         }
         var year= date.getUTCFullYear();
         var minDate= year +"-"+ month + "-" + tdate;
         document.getElementById("todaydatefordeparture").setAttribute('min',minDate);

      </script>

     <script>
         var date = new Date();
         var tdate= date.getDate();
         var month=date.getMonth() +1;
         if(tdate <10){
          tdate='0'+ tdate;
         }
         if(month <10){
          month='0'+ month;
         }
         var year= date.getUTCFullYear();
         var minDate= year +"-"+ month + "-" + tdate;
         document.getElementById("todaydateforreturn").setAttribute('min',minDate);

      </script>

        <script type="text/javascript">
            $(document).ready(function (){
                $('#myForm').validate({
                    rules: {
                        svcnumber: {
                            required : true,
                        },
                         mobile_no: {
                            required : true,
                        },
                         email: {
                            required : true,
                        },
                         address: {
                            required : true,
                        },
                         personnel_image: {
                            required : true,
                        },
                    },
                    messages :{
                        svcnumber: {
                            required : 'Please Enter  service number',
                        },
                        mobile_no: {
                            required : 'Please Enter  Mobile Number',
                        },
                        email: {
                            required : 'Please Enter  Email',
                        },
                        gender: {
                            required : 'Please Enter  Address',
                        },
                        personnel_image: {
                            required : 'Please Select one Image',
                        },
                    },
                    errorElement : 'span',
                    errorPlacement: function (error,element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight : function(element, errorClass, validClass){
                        $(element).addClass('is-invalid');
                    },
                    unhighlight : function(element, errorClass, validClass){
                        $(element).removeClass('is-invalid');
                    },
                });
            });

        </script>
@endsection
