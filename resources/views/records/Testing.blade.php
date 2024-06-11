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

                <div id="itemDetails">
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
                                            <input class="form-control dropdown-item" id="electronic_item" type="text"
                                                placeholder="Search..">
                                            @foreach ($eletronicitem as $Key => $Value)
                                                <li class="dropdown-item" value="{{ $Value->serial_no }}"
                                                    data-product_name_id={{ $Value->product_name }}
                                                    data-status_id={{ $Value->status }} data-state_id={{ $Value->state }}
                                                    data-category_id={{ $Value->category_name }}>{{ $Value->serial_no }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="form-group svcnumber">
                                        <input type="text" class="form-control" id="serial_no" name="serial_no[]"
                                            placeholder="Serial Number" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- ... -->
                            <div class="form-group row">
                                <label for="surname" class="col-sm-3 col-form-label">Item name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="product_name_id"
                                        name="product_name[]" placeholder="Item name" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-3 col-form-label">Date Issued</label>
                                <div class="col-sm-9">
                                    <input type="text" name="issued_date[]" class="form-control"
                                        id="todaydatefordeparture" value="{{ date('m/d/Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                    class="col-sm-3 col-form-label col-form-label-sm">Category</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="category_id" name="category_name[]"
                                        placeholder="category" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="state[]" class="form-control select2" required>
                                        <option value="">Open select menu</option>
                                        <option value="0">Loan</option>
                                        <option value="2">Keep</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-3 col-form-label">Item Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="item_location[]"
                                        placeholder="Item Location" required>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-2" style="padding-top: 25px; float:right;">
                    <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> </span>
                </div><!-- End col-md-5 -->
                <hr>
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
    <script>
        $(document).ready(function() {
            var count = 1;

            // Add More Event click event
            $(document).on('click', '.addeventmore', function() {
                var html = `
            <div class="whole_extra_item_add" id="whole_extra_item_add">
  		    <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            <div class="row pagePadding">
            <div class="col-md-6">
             <div class="form-group row">
            <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Serial Number</label>
            <div class="col-sm-9 dropdownbox">
              <div class="dropdown electronic-item-dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">----Select----
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <input class="form-control dropdown-item" id="electronic_item_${count}" type="text" placeholder="Search..">
                  @foreach ($eletronicitem as $Key => $Value)
                  <li class="dropdown-item" value="{{ $Value->serial_no }}"
                    data-product_name_id={{ $Value->product_name }}
                    data-status_id={{ $Value->status }} data-state_id={{ $Value->state }}
                    data-category_id={{ $Value->category_name }}>{{ $Value->serial_no }}
                  </li>
                  @endforeach
                </ul>
              </div>
              <div class="form-group svcnumber">
                <input type="text" class="form-control" id="serial_no_${count}" name="serial_no[]"
                  placeholder="Serial Number" readonly>
              </div>
            </div>
          </div>
          <!-- ... -->
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-3 col-form-label">Category</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="category_id_${count}" name="category_name[]"
                placeholder="category" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
              <select name="state[]" class="form-control select2" required>
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
              <input type="text" class="form-control" id="product_name_id_${count}" name="product_name[]"
                placeholder="Item name" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-3 col-form-label">Date Issued</label>
            <div class="col-sm-9">
              <input type="text" name="issued_date[]" class="form-control" id="todaydatefordeparture"
                value="{{ date('m/d/Y') }}" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="colFormLabel" class="col-sm-3 col-form-label">Remark</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="exampleFormControlTextarea1" name="remark[]"
                placeholder="Remark" rows="2"></textarea>
            </div>
          </div>

     	<div class="col-md-2" style="padding-top: 25px;">
           <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> </span>
  <span class="btn btn-danger removeeventmore"><i class="fa fa-minus-circle"></i> </span>
     	</div><!-- End col-md-2 -->
        </div>
      </div>
    </div>
        </div>`;

                $('#itemDetails').append(html);
            });

            // Remove item click event
            $(document).on('click', '.removeeventmore', function(event) {
                $(this).closest(".whole_extra_item_add").remove();
            });

            // Handle dynamic dropdown item click event
            $(document).on('click', '.electronic-item-dropdown li', function(e) {
                var selectedElement = this;
                var count = $(selectedElement).closest('.row').index() + 1;
                $(`#serial_no_${count}`).val(selectedElement.innerHTML);
                $(`#product_name_id_${count}`).val(selectedElement.getAttribute('data-product_name_id'));
                $(`#status_id_${count}`).val(selectedElement.getAttribute('data-status_id'));
                $(`#state_id_${count}`).val(selectedElement.getAttribute('data-state_id'));
                $(`#category_id_${count}`).val(selectedElement.getAttribute('data-category_id'));
            });
        });
    </script>


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
