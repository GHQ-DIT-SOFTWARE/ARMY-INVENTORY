@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <style>
        /* Style the input field */
        #myInput,
        #myOutput {
            padding: 20px;
            margin-top: -6px;
            border: 0;
            border-radius: 0;
            background: #f1f1f1;
        }

        input[type="text"] {
            padding: 0 15px !important;
        }

        .pagePadding {
            padding: 12px 24px 4px 24px !important;
        }

        .dropdownbox {
            display: flex;
            flex-direction: row;
            gap: 2vw;
            justify-content: start;
        }

        .svcnumber {
            width: 90% !important;
        }

        .serial_no {
            width: 90% !important;
        }
    </style>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Add New</a></li>
                        <li class="breadcrumb-item"><a href="#!">Record</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Enter Record Details</h5>
                </div>
                <h1 class="pagePadding">Personnel Details</h1>
                <hr>
                <div class="card-body">
                    <form action="{{ route('item.issue.electronic.store') }}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Service
                                        Number</label>
                                    <div class="col-sm-9 dropdownbox ">
                                        <div class="form-group svcnumber">
                                            <input type="text" class="form-control" id="personnels_svcnumber"
                                                name="svcnumber" placeholder="Service Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="surname" name="surname"
                                            placeholder="Surname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select name="gender" class="form-control select2">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                        class="col-sm-3 col-form-label col-form-label-sm">Rank</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="rank_id" name="rank_name"
                                            placeholder="Rank">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Other Name(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="othernames" name="othernames"
                                            placeholder="Other Name(s)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="mobile_no" name="mobile"
                                            placeholder="eg. 233245002022">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- ... -->
                <h1 class="mt-5 pagePadding">Electronic Item Details</h1>
                <hr>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row pagePadding">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Serial
                                            Number</label>
                                        <div class="col-sm-9 dropdownbox">
                                            <div class="dropdown electronic-item-dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button"
                                                    data-toggle="dropdown">----Select----
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <input class="form-control dropdown-item" id="electronic_item"
                                                        type="text" placeholder="Search..">
                                                    @foreach ($eletronicitem as $Key => $Value)
                                                        <li class="dropdown-item" value="{{ $Value->serial_no }}"
                                                            data-product_name_id={{ $Value->product_name }}
                                                            data-status_id={{ $Value->status }}
                                                            data-state_id={{ $Value->state }}
                                                            data-category_id={{ $Value->category_name }}>
                                                            {{ $Value->serial_no }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="form-group svcnumber">
                                                <input type="text" class="form-control" id="serial_no"
                                                    name="serial_no" placeholder="Serial Number" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ... -->
                                    <div class="form-group row">
                                        <label for="surname" class="col-sm-3 col-form-label">Item name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="product_name_id"
                                                name="product_name" placeholder="Item name" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Date Issued</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="issued_date" class="form-control" id="date"
                                                value="{{ date('m/d/Y') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-3 col-form-label col-form-label-sm">Category</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="category_id"
                                                name="category_name" placeholder="category" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select name="state" class="form-control select2" required>
                                                <option value="">Open select menu</option>
                                                <option value="0">Loan</option>
                                                <option value="2">Keep</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top:43px;">
                                    </label>
                                    <i
                                        class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore">
                                        Add More</i>
                                </div>
                            </div>
                        </div> <!-- End card-body -->
                        <!--  ---------------------------------- -->
                        <div class="card-body">
                            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Item Name </th>
                                        <th width="15%">Serial Number</th>
                                        <th width="15%">Status</th>
                                        <th width="30%">Item Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addRow" class="addRow">
                                </tbody>
                            </table><br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="Write Description Here"></textarea>
                                </div>
                            </div><br>
                        </div> <!-- End card-body -->
                    </div>
                </div> <!-- end col -->
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn  btn-success">Add Record</button>
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
    <script id="document-template" type="text/x-handlebars-template">
        <tr class="delete_add_more_item">
            <input type="hidden" name="issued_date" value="@{{issued_date}}">
            <td>
                <input type="hidden" name="category_name[]" value="@{{category_name}}">
                @{{category_name}}
            </td>
            <td>
                <input type="hidden" name="product_name[]" value="@{{product_name}}">
                @{{product_name}}
            </td>
            <td>
                <input type="text" min="1" class="form-control serial_no text-right" name="serial_no[]" placeholder="Serial No." readonly>
            </td>
            <td>
                <input type="text" name="status[]" class="form-control status" placeholder="Status" readonly>

            </td>
            <td>
                <input type="text" class="form-control item_location text-right" name="item_location[]" placeholder="Enter Item Location">
            </td>
            <td>
                <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
            </td>
        </tr>
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".addeventmore", function() {
                var date = $('#date').val();
                var invoice_no = $('#invoice_no').val();
                var category_id = $('#category_id').val();
                var category_name = $('#category_id').find('option:selected').text();
                var product_id = $('#product_id').val();
                var product_name = $('#product_id').find('option:selected').text();
                var unit_price = $('#unit_price').val(); // Retrieve the product price from the input field

                if (date == '') {
                    $.notify("Date is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                    return false;
                }

                if (category_id == '') {
                    $.notify("Category is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                    return false;
                }

                if (product_id == '') {
                    $.notify("Product Field is Required", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                    return false;
                }
                var source = $("#document-template").html();
                var tamplate = Handlebars.compile(source);
                var data = {
                    issued_date: issued_date,
                    category_id: category_id,
                    category_name: category_name,
                    product_id: product_id,
                    product_name: product_name,
                    unit_price: unit_price
                };
                var html = tamplate(data);
                $("#addRow").append(html);
            });

            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_add_more_item").remove();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#electronic_item").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".electronic-item-dropdown li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.electronic-item-dropdown li').on('click', function(e) {
                var selectedElement = this;
                $('#serial_no').val(selectedElement.innerHTML);
                $('#product_name_id').val(selectedElement.getAttribute('data-product_name_id'));
                $('#status_id').val(selectedElement.getAttribute('data-status_id'));
                $('#state_id').val(selectedElement.getAttribute('data-state_id'));
                $('#category_id').val(selectedElement.getAttribute('data-category_id'));

            });
        })
    </script>
@endsection
