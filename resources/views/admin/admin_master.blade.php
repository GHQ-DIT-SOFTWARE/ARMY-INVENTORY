<!DOCTYPE html>
<html lang="en">

<head>
    <title>DIT | IMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="SUSU" />
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG  ')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fullcalendar.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/ekko-lightbox.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/plugins/lightbox.min.css')}}">
    <link  rel="stylesheet" type="text/css"  href="{{ asset('assets/select2/css/select2.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" >
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" >
</head>
<body >
    @include('admin.sidebar')
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
						{{-- <img src="{{ asset('assets/images/logo.png')}}" alt="" class="logo"> --}}
						<img src="{{ asset('assets/images/gaf.gif')}}" alt="" class="logo" width="220px" style="padding-top: 3em">
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
                    @php
                    $user = DB::table('users')->where('id',Auth::user()->id)->first();
                   @endphp
					<ul class="navbar-nav ml-auto">
						<li>
							<div class="dropdown drp-user">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="{{ (!empty($user->image))? url('upload/user_images/'.$user->image):url('upload/no_image.jpg') }}" alt="" class="img-radius"height="40px" width="40px">
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-notification">
									<div class="pro-head">
										<span>{{Auth::user()->name}}</span>
									</div>
									<ul class="pro-body">
										<li><a href="{{route('profileview')}}" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                                        <li><a href="{{ route('password.view') }}" class="dropdown-item"><i class="feather icon-user"></i> Change Password</a></li>
										<li><a href="{{route('logout')}}" class="dropdown-item"><i class="feather icon-lock"></i>Logout</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
	</header>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        @yield('admin')
    </div>
</div>
<div class="footer card text-center" id="footerdiv">
    <span><p id="copy"></p></span>
    </div>
    <script>document.getElementById('copy').innerHTML = 'Copyright &copy; '+(new Date().getFullYear())+' GHQ-DIT.All Rights Reserved.'</script>    </div>
    </div>
    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.min.js ') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js ') }}"></script>
    <script src="{{ asset('assets/js/ripple.js ') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js ') }}"></script>
	<script src="{{ asset('assets/js/menu-setting.min.js ') }}"></script>
    <script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
<!-- datatable Js -->
<script src="{{asset('assets/js/pages/data-autofill-custom.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/data-export-custom.js')}}"></script>
<script src="{{ asset('assets/js/pages/dashboard-main.js ') }}"></script>
<script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/validate.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" ></script>

<script src="{{ asset('assets/js/code.js') }}"></script>
<!-- datatable Js -->
<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets/js/pages/data-autofill-custom.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/pages/data-export-custom.js')}}"></script>

<script src="{{asset('assets/js/plugins/ekko-lightbox.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/lightbox.min.js')}}"></script>
<script src="{{asset('assets/js/pages/ac-lightbox.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="
https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="
https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="
https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="

https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="
https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>


<script>
      $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script type="text/javascript">
$(function(){
  $(document).on('click','#delete',function(e){
      e.preventDefault();
      var link = $(this).attr("href");
                Swal.fire({
                  title: 'Are you sure?',
                  text: "Delete This Data?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = link
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  }
                })
  });

});
</script>
<script>
@if(Session::has('message'))
var type = "{{ Session::get('alert-type','info') }}"
switch(type){
case 'info':
toastr.info(" {{ Session::get('message') }} ");
break;

case 'success':
toastr.success(" {{ Session::get('message') }} ");
break;

case 'warning':
toastr.warning(" {{ Session::get('message') }} ");
break;
case 'error':
toastr.error(" {{ Session::get('message') }} ");
break;
}
@endif
</script>



</body>
</html>
