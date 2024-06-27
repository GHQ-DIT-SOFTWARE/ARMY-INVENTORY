@extends('admin.admin_master')
@section('admin')
    <style>
        #example {
            font-size: 19px;
        }
    </style>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Personnel Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">View</a></li>
                        <li class="breadcrumb-item"><a href="#!">Records</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card user-profile-list">
                <div class="card-header">
                    {{-- <div class="alert alert-info">
                        <strong>Instructions for Importing Excel Data:</strong>
                        <ol>
                            <li>Ensure your Excel file follows the specified format:</li>
                            <li>
                                To download the sample Excel file, click the button:
                                <button id="downloadButton" class="btn btn-success">Download</button>
                            </li>
                        </ol>
                    </div> --}}
                    <nav class="navbar justify-content-between p-0 align-items-center">
                        <div class="col-sm-6 text-left"><br />
                            <p>Perform these Actions on Personal.</p>
                        </div>
                        <div class="input-group" style="width: auto;">
                            {{-- <div class="col-auto">
                                <div class="btn-group">
                                    <form action="{{ route('import-personnel') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="input_container">
                                                <input type="file" name="file" id="fileUpload" accept=".xlsx, .csv">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-info">Import Excel File</button>
                                            </div>
                                        </div>
                                        @error('file')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }} Please upload a valid file (xlsx, csv).
                                            </div>
                                        @enderror
                                    </form>
                                </div>
                            </div> --}}

                            <div class="col text-right">
                                <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                    <a href="{{ route('personal-mech') }}" class="btn  btn-success " type="button"
                                        aria-haspopup="true" aria-expanded="false"><i class="feather icon-plus"></i>Add
                                        Personal</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">

                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="personnel-table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select_all"
                                                        value="1" id="contactstable-select-all">
                                                    <label class="custom-control-label" for="contactstable-select-all">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>#SVC</th>
                                            <th>RANK</th>
                                            <th>PERSONAL NAME</th>
                                            <th>UNIT</th>

                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#personnel-table').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        text: 'Copy to clipboard'
                    },
                    'excel',
                ],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: '{{ route('api-view-personnel') }}',
                    type: 'POST',
                    dataSrc: 'data',
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'svcnumber',
                        name: 'svcnumber'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name',

                    },
                    {
                        data: 'personnel_name',
                        name: 'personnel_name',
                    },
                    {
                        data: 'unit_name',
                        name: 'unit_name'
                    },


                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var downloadButton = document.getElementById('downloadButton');
            if (downloadButton) {
                downloadButton.addEventListener('click', function() {
                    var downloadLink = document.createElement('a');
                    downloadLink.href = "{{ url('/download-sample-excel') }}";
                    downloadLink.download = 'personnel.csv';
                    downloadLink.style.display = 'none';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                });
            }
        });
    </script>
@endsection
