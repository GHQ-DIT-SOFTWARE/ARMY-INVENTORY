<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG  ') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/ekko-lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        type="text/css"href=" https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            color: rgb(1, 10, 89);
            text-align: center;
            height: 40px;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    @include('admin.sidebar')
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <img src="{{ asset('assets/images/gaf.gif') }}" alt="" class="logo" width="220px"
                    style="padding-top: 3em">
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
            @php
                $user = Auth::user();
            @endphp
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ !empty($user->image) ? url('upload/user_images/' . $user->image) : url('upload/no_image.jpg') }}"
                                alt="" class="img-radius"height="40px" width="40px">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <span>{{ $user ? $user->name : 'Guest' }}</span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="{{ route('profileview') }}" class="dropdown-item"><i
                                            class="feather icon-user"></i> Profile</a></li>
                                <li><a href="{{ route('logout') }}" class="dropdown-item"><i
                                            class="feather icon-lock"></i>Logout</a></li>
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
    <div class="footer text-center bg-light" id="footerdiv">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p id="copy">&copy; {{ date('Y') }} GAF-LOGISTICS MANAGEMENT SYSTEM| All Rights
                        Reserved | Powered by (GHQ-DIT)</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('copy').innerHTML = 'Copyright &copy; ' + (new Date().getFullYear()) +
            'GAF-LOGISTICS MANAGEMENT SYSTEM| All Rights Reserved | Powered by (GHQ-DIT).
    </script>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Required Js -->
    <script src="{{ asset('assets/js/vendor-all.min.js ') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js ') }}"></script>
    <script src="{{ asset('assets/js/ripple.js ') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js ') }}"></script>
    <script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ac-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/js/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/validate.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('assets/js/multiselect.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <script src="{{ asset('assets/js/code.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="{{ asset('assets/js/plugins/ekko-lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ac-lightbox.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('assets/js/plugins/isotope.pkgd.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


    <script>
        // init Isotope
        var $grid = $('.grid').isotope({
            itemSelector: '.element-item',
            layoutMode: 'fitRows',
            getSortData: {
                name: '.name',
                symbol: '.symbol',
                number: '.number parseInt',
                category: '[data-category]',
            }
        });

        // bind filter button click
        $('#filters').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        $('#filters-side').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });
        // change active class on buttons
        $('.button-group').each(function(i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', 'button', function() {
                $buttonGroup.find('.active').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#delete', function(e) {
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
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
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
