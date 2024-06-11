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
                        <h5 class="m-b-10">General Item Records</h5>
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
                    <form action="{{route('item.issue.general.store')}}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Service
                                        Number</label>
                                    <div class="col-sm-9 dropdownbox ">
                                        <div class="dropdown personnel-dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button"
                                                data-toggle="dropdown">----Select----
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <input class="form-control" id="personnels_search" type="text"
                                                    placeholder="Search..">
                                                @foreach ($personnels as $inputKey => $inputValue)
                                                    <li class="dropdown-item" value="{{ $inputValue->svcnumber }}"
                                                        data-surname={{ $inputValue->surname }}
                                                        data-email={{ $inputValue->email }}
                                                        data-othernames={{ $inputValue->othernames }}
                                                        data-rank_id={{ $inputValue->rank_name }}
                                                        data-gender={{ $inputValue->gender }}
                                                        data-mobile_no={{ $inputValue->mobile_no }}>
                                                        {{ $inputValue->svcnumber }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="form-group svcnumber">
                                            <input type="text" class="form-control" id="personnels_svcnumber"
                                                name="svcnumber" placeholder="Service Number" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-3 col-form-label">Surname</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="surname" name="surname"
                                            placeholder="Surname" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="gender" name="gender"
                                            placeholder="Gender" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="mobile_no" name="mobile"
                                            placeholder="eg. 233245002022" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                        class="col-sm-3 col-form-label col-form-label-sm">Rank</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="rank_id" name="rank_name"
                                            placeholder="Rank" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Other Name(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="othernames" name="othernames"
                                            placeholder="Other Name(s)" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="email" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <h1 class="mt-5 pagePadding">General Item Details</h1>
                <hr>
                <div class="row pagePadding">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Service
                                Number</label>
                            <div class="col-sm-9 dropdownbox">
                                <div class="dropdown general-item-dropdown">
                                    <button class="btn btn-info dropdown-toggle" type="button"
                                        data-toggle="dropdown">----Select----
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <input class="form-control dropdown-item" id="general_item" type="text"
                                            placeholder="Search..">
                                        @foreach ($generalitem  as $Key => $Value)
                                            <li class="dropdown-item" value="{{ $Value->body_no }}"
                                                data-product_name_id={{ $Value->product_name }}
                                                data-status_id={{ $Value->status }} data-state_id={{ $Value->state }}
                                                data-category_id={{ $Value->category_name }}>{{ $Value->body_no }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="form-group svcnumber">
                                    <input type="text" class="form-control" id="body_no" name="body_no"
                                        placeholder="Body Number" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Category</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="category_id" name="category_name"
                                    placeholder="category" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control select2" required>
                                    <option value="">Open select menu</option>
                                    <option value="0">Loan</option>
                                    <option value="2">Keep</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="surname" class="col-sm-3 col-form-label">Item name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="product_name_id" name="product_name"
                                    placeholder="Item name" readonly>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="colFormLabel" class="col-sm-3 col-form-label">Item Location</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="othernames" name="item_location"
                                    placeholder="Item Location" required>
                            </div>
                        </div>
                    </div>
                </div>
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
    <!-- JavaScript -->

    <script>
        $(document).ready(function() {
            $("#personnels_search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".personnel-dropdown li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.personnel-dropdown li').on('click', function(e) {
                var selectedElement = this;
                $('#personnels_svcnumber').val(selectedElement.innerHTML);
                $('#surname').val(selectedElement.getAttribute('data-surname'));
                $('#othernames').val(selectedElement.getAttribute('data-othernames'));
                $('#rank_id').val(selectedElement.getAttribute('data-rank_id'));
                $('#mobile_no').val(selectedElement.getAttribute('data-mobile_no'));
                $('#gender').val(selectedElement.getAttribute('data-gender'));
                $('#email').val(selectedElement.getAttribute('data-email'));
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            $("#general_item").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".general-item-dropdown li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.general-item-dropdown li').on('click', function(e) {
                var selectedElement = this;
                $('#body_no').val(selectedElement.innerHTML);
                $('#product_name_id').val(selectedElement.getAttribute('data-product_name_id'));
                $('#status_id').val(selectedElement.getAttribute('data-status_id'));
                $('#state_id').val(selectedElement.getAttribute('data-state_id'));
                $('#category_id').val(selectedElement.getAttribute('data-category_id'));

            });
        })
    </script>
@endsection
