@extends('admin.admin_master')
@section('admin')
<style>
    #example{
        font-size: 19px;
    }
   </style>
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Use Log Activities</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Activities Log</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="row justify-content-center">
            <!-- liveline-section start -->
            <div class="col-sm-12">

                <div class="card user-profile-list">
                    <div class="card-header">
                        <h5>Details of Activities</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="col-sm-6 text-left"><br/>
                                <p>Perform these Actions on Record.</p>
                            </div>

                            <div class="dt-responsive table-responsive">
                                        <div class="dt-responsive table-responsive">
                                            <table id="example" class="table table-striped table-bordered nowrap">

                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="select_all" value="1" id="contactstable-select-all">
                                                                <label class="custom-control-label" for="contactstable-select-all"> </label>
                                                            </div>
                                                        </th>
                                                        <th>NAME</th>
                                                        <th>EMAIL</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>DATE TIME</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i=1;
                                                    @endphp
                                                        @foreach ($login_and_logout as $log)
                                                    <tr>

                                                        <td>{{$i++}}</td>
                                                        <td>{{$log->name}} </td>
                                                        <td> {{$log->email}} </td>
                                                        <td>{{$log->description}} </td>
                                                        <td>{{$log->date_time}} </td>


                                                    </tr>
                                                    @endforeach
                                               </tbody>
                                            </table>
                                  </div>
                            </div>
                    </div>
                    </div>
                </div>
            </div>


            <!-- liveline-section end -->
        </div>
@endsection
