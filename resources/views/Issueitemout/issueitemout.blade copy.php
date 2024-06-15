@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Item </h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Items</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Sales </h4><br><br>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Main Category</label>
                                        <div class="col-sm-8">
                                            <select id="category_id" name="category_id" class="form-control select2">
                                                <option selected="">Open this select menu</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                    </option>
                                                @endforeach
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="service" class="col-sm-4 col-form-label">Sub Category</label>
                                        <div class="col-sm-8">
                                            <select id="sub_category" class="form-control select2" name="sub_category"
                                                required>
                                                <option value="">Select Option</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Item Name</label>
                                        <div class="col-sm-8">
                                            <select name="item_id" class="form-control select2">
                                                <option selected="">Open this select menu</option>
                                                @foreach ($products as $pro)
                                                    <option value="{{ $pro->id }}">{{ $pro->item_name }}</option>
                                                @endforeach

                                                @error('item_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </select>
                                            @error('item_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label for="size" class="col-sm-4 col-form-label">Size</label>
                                        <div class="col-sm-8">
                                            <select id="size" name="sizes" class="form-control select2">
                                                <option selected="">Select Size</option>
                                            </select>
                                            @error('sizes')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group row">
                                        <label for="actual_qty" class="col-sm-4 col-form-label">Qty</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="qty" placeholder="Qty"
                                                readonly>
                                            @error('actual_qty')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="actual_qty" class="col-sm-4 col-form-label">Unit</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="qty" placeholder="Qty">
                                            @error('actual_qty')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Invoice No:</label>
                                        <div class="col-sm-9">
                                            <input class="form-control example-date-input" name="invoice_no" type="text"
                                                value="" id="invoice_no" readonly style="background-color:#ddd">
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


                        <div class="card-body">
                            <form method="post" action="">
                                @csrf
                                <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Item Name</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
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
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="storeButton"> Invoice Store</button>
                                </div>
                            </form>
                        </div> <!-- End card-body -->
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>




    <script id="document-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date" value="@{{date}}">
            <input type="hidden" name="invoice_no" value="@{{invoice_no}}">
        <td>
            <input type="hidden" name="category_id[]" value="@{{category_id}}">
            @{{ category_name }}
        </td>

         <td>
            <input type="hidden" name="product_id[]" value="@{{product_id}}">
            @{{ product_name }}
        </td>

         <td>
            <input type="number" min="1" class="form-control selling_qty text-right" name="selling_qty[]" value="">
        </td>

        <td>
            <input type="number" id="unit_price" class="form-control unit_price text-right" name="unit_price[]" value="@{{unit_price}}">

        </td>
         <td>
            <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly>
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
                var unit_price = $('#unit_price').val();


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
                    date: date,
                    invoice_no: invoice_no,
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
                totalAmountPrice();
            });
           
         
        });
    </script>
   
@endsection
