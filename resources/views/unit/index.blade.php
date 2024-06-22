@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Unit</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Units</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dasboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">

            <div class="card user-profile-list">
                <div class="card-header">
                    <h5>Details</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        {{-- <div class="col-sm-6 text-left">

                            <nav class="navbar justify-content-between p-0 align-items-center">
                                <div class="col-sm-6 text-left"><br />
                                    <p>Perform these Actions on Personal.</p>
                                </div>
                                <div class="input-group" style="width: auto;">
                                    <div class="col-auto">
                                        <div class="btn-group">
                                            <form action="{{ route('import-units') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="input_container">
                                                        <input type="file" name="file" id="fileUpload"
                                                            accept=".xlsx, .csv">
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
                                    </div>
                                    <div class="col text-right">
                                        <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                            <a href="{{ route('add-unit') }}" class="btn  btn-primary " type="button"
                                                aria-haspopup="true" aria-expanded="false"><i
                                                    class="feather icon-plus"></i>Add
                                                Units</a>

                                        </div>
                                    </div>

                                </div>
                            </nav>
                        </div> --}}
                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select_all"
                                                        value="1" id="contactstable-select-all">
                                                    <label class="custom-control-label" for="contactstable-select-all">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>NAME</th>
                                            <th width="20%">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($units as $key => $record)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $record->unit_name }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('edit-unit', $record->uuid) }}"><i
                                                            class="feather icon-edit"> </i></a>
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('delete-unit', $record->uuid) }}" title="Delete Data"
                                                        id="delete"><i class="feather icon-trash-2"></i></a>
                                                </td>
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
    <!-- [ Main Content ] end -->
    <!-- [ Main Content ] end -->


    <!-- Modal -->
    <div class="modal fade" id="notificationModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="notificationModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <div class="carousel-inner text-center">


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>



    <!-- [ Main Content ] end -->
@endsection

<script>
    function printData() {
        // var divToPrint = document.getElementById("printTable");
        // newWin = window.open("");
        // newWin.document.write("<link rel=\"stylesheet\" href=\"#"/>" );
        // newWin.document.write(divToPrint.outerHTML);
        // newWin.print();
        // newWin.close();
        // return true;
    }
    $('.btn-print-invoice').on('click', function() {
        printData();
    })

    function linkcolored(selected) {
        selected.style = 'color: black;';
    }

    function linkuncolored(selected) {
        selected.style = '';
    }
</script>
