@extends('admin.admin_master')
@section('admin')

<!-- [ Main Content ] start -->

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">FORMS</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">REPORT FORM</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Invoice ] start -->
            <div class="container" id="printTable">
                <div>
                    <div class="card">
                     <!DOCTYPE html>
<html>
<head>
<style>
#content{
  padding: 2.0em;
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid rgb(227, 225, 240);
  padding: 8px;
}
#customers tr:nth-child(even){background-color: #f2f2f2;}
#customers tr:hover {background-color: #ddd;}
#customers tr.noborder td{
  border: 0;
}
.blank_row{
height: 10px;
background-color: white;
}
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #6c8ff0;
  color: white;
  /* width: 15%; */
}
</style>
</head>
<body>
  <div id="content">
<table id="customers">
  <tr class="noborder">
    <td><h3>GHANA ARMED FORCES</h3>
      <h5><b>GAF Address:</b>
          Directorate of Public Relations General<br>
          Headquarters Burma Camp, Accra, Ghana.<br>
          <b>Phone</b> : +233302774511<br>
          <b>Email</b> : gaf@gmail.com</h5>
    </td> 
   <td>
    <img src="{{ asset( $data->personnel_image ) }}"  style="width: 220px; height: 200px;" align="right">
    </td>
  </tr>
  <h4 style="text-align:center;">RESTRICTED<hr>
    <b>Issued by - </b> <span class="pull-right">SRL #:{{Auth::user()->name }}</span>
    </h4>
</table>
<table id="customers">
  <tr>
    <th >BIO DATA</th>
    {{-- <th colspan="3"></th>
    <th colspan="3"></td>
    <th colspan="3"></td> --}}
  </tr>
  <tr>
    <td colspan="3"><b>Service_No: </b></td>
    <td colspan="3">{{$data->svcnumber}}</td>
    <td colspan="3"><b>Rank: </b></td>
    <td colspan="3">{{$data->rank_name}}</td>
  </tr>
  <tr>
    <td colspan="3"><b>Surname: </b></td>
    <td colspan="3">{{$data->surname}}</td>
    <td colspan="3"><b>Othernames: </b></td>
    <td colspan="3">{{$data->othernames}}</td>
  </tr>
    <tr>
    <td colspan="3"><b>Unit: </b></td>
    <td colspan="3">{{$data->unit_name}}</td>
    <td colspan="3"><b>Arm of Service: </b></td>
    <td colspan="3">{{$data->service_name}}</td>
  </tr>
  <tr>
    <td colspan="3"><b>Email: </b></td>
    <td colspan="3">{{$data->email}}</td>
    <td colspan="3"><b>Mobile: </b></td>
    <td colspan="3">{{$data->mobile}}</td>
  </tr>
  <tr>
    <td colspan="3"><b>Gender: </b></td>
    <td colspan="3">{{$data->gender}}</td>
    <td colspan="3"></td>
    <td colspan="3"></td>
  </tr>
  <tr class="blank_row noborder">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>COURSE DETAILS</th>
    {{-- <th></th>
    <th></th>
    <th></th> --}}
  </tr>
    <tr>
    <td colspan="3"><b>Course: </b></td>
    <td colspan="3">{{$data->course_name}}</td>
    <td colspan="3"><b>Location: </b></td>
    <td colspan="3">{{$data->location}}</td>
  </tr>
    <tr>
      <td colspan="3"><b>Certification: </b></td>
      <td colspan="3">{{$data->certification}}</td>
      <td colspan="3"><b>Amount: </b></td>
      <td colspan="3">₵{{$data->amount}}</td>
  </tr>
  <tr>
    <td colspan="3"><b>GAF/Self Sponsor: </b></td>
    <td colspan="3">{{$data->sponsorship}}</td>
    <td colspan="3"></td>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3">.</td>
    <td colspan="3"></td>
    <td colspan="3"></td>
    <td colspan="3"></td>
  </tr>
  <tr class="blank_row noborder">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>TRAVEL  DETAILS</th>
    {{-- <th></th>
    <th></th>
    <th></th> --}}
  </tr>
    <tr>
    <td colspan="3"><b>Departure Date: </b></td>
    <td colspan="3"> {{date('d F, Y',strtotime($data->departure_date)) }}</td>
    <td colspan="3"><b>Return Date: </b></td>
    <td colspan="3"> {{date('d F, Y',strtotime($data->arrival_date)) }}</td>
  </tr>
    <tr>
    <td colspan="3"><b>ETD: </b></td>
    <td colspan="3">{{$data->departure_time}}</td>
    <td colspan="3"><b>ETA: </b></td>
    <td colspan="3">{{$data->return_time}}</td>
  </tr>
  <tr>
    <td colspan="3"><b>Remarks: </b></td>
    <td colspan="3">{{$data->remarks}}</td>
    <td colspan="3"><b>Status: </b></td>
    <td colspan="3">   
      @if($data->status == '5')
      <span class="badge badge-warning mr-1  " >Pending</span>
      @elseif($data->status == '1')
      <span class="badge badge-success mr-1 ">Travelled</span>
      @elseif($data->status == '2')
      <span class="badge badge-danger mr-1 ">Cancelled</span>
      @elseif($data->status == '3')
      <span class="badge badge-info mr-1 ">scheduled</span>
      @elseif($data->status == '4')
      <span class="badge badge-secondary mr-1 ">Returned</span>
      @endif
    </td>
  </tr>
</table>
<br><br><br>

  <h4 style="text-align:center;">
    <i style="font-size: 10px; float: right;">Printed at: {{ date("d M Y  h:i:sa") }}</i></h4>
<hr>
<h4 style="text-align:center;">
  RESTRICTED
</h4>

  </div>
</body>
</html>
             </div>
                </div>
            </div>
            
        </div>
        <!-- [ Main Content ] end -->
        <div class="row text-center">
            <div class="col-sm-12 invoice-btn-group text-center">
                <button type="button" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
            </div>
        </div>
    <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/ripple.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
	<script src="{{asset('assets/js/menu-setting.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
<script>
    function printData() {
        var divToPrint = document.getElementById("printTable");
        newWin = window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }
    $('.btn-print-invoice').on('click', function() {
        printData();
    })
</script>


</body>
</html>

@endsection
