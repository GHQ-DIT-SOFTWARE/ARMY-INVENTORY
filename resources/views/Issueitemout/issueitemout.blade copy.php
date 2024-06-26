@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Initiate Request</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Request Items</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <h5>INITIATE REQUEST - ITEMS DETAILS </h5>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Item Category</label>
                                        <div class="col-sm-8">
                                            <select id="category_id" name="category_id" class="form-control select2">
                                                <option selected="">Select category</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                @endforeach
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
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
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Item Name</label>
                                        <div class="col-sm-8">
                                            <select name="item_id" id="item_id" class="form-control select2">
                                                <option selected="">Select Item</option>
                                            </select>
                                            @error('item_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
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
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group row">
                                        <label for="qty" class="col-sm-4 col-form-label">Quatity</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="qty" class="form-control" name="qty"
                                                placeholder="Quatity Available" readonly>
                                            @error('qty')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group row">
                                        <label for="actual_qty" class="col-sm-4 col-form-label">Unit</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="unit_id" id="unit_id" required>
                                                <option value=" ">Select Unit</option>
                                                @foreach ($units as $uni)
                                                    <option value="{{ $uni->id }}">{{ $uni->unit_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                        <i class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore">
                                            Add Request</i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                        <form method="post" action="{{ route('store-items-issued-out') }}">
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
                            </div><br><br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" id="storeButton">Authorise Request</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#category_id').on('change', function() {
                    var categoryId = $(this).val();
                    if (categoryId) {
                        $.ajax({
                            url: '{{ route('get-issue-subcategory', ['categoryId' => ':categoryId']) }}'
                                .replace(':categoryId', categoryId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#sub_category').empty();
                                $('#sub_category').append(
                                    '<option value="">Select Option</option>');
                                $.each(data, function(key, value) {
                                    $('#sub_category').append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#sub_category').empty();
                        $('#sub_category').append('<option value="">Select Option</option>');
                    }
                });

                $('#sub_category').on('change', function() {
                    var subCategoryId = $(this).val();
                    if (subCategoryId) {
                        $.ajax({
                            url: '{{ route('get-items', ['subCategoryId' => ':subCategoryId']) }}'
                                .replace(':subCategoryId', subCategoryId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#item_id').empty();
                                $('#item_id').append('<option value="">Select Item</option>');
                                $.each(data, function(key, value) {
                                    $('#item_id').append('<option value="' + key + '">' +
                                        value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#item_id').empty();
                        $('#item_id').append('<option value="">Select Item</option>');
                    }
                });

                $('#item_id').on('change', function() {
                    var itemId = $(this).val();
                    if (itemId) {
                        $.ajax({
                            url: '{{ route('get-sizes', ['itemId' => ':itemId']) }}'.replace(':itemId',
                                itemId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#size').empty();
                                $('#size').append('<option value="">Select Size</option>');
                                $.each(data, function(index, size) {
                                    $('#size').append('<option value="' + size + '">' +
                                        size + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#size').empty();
                        $('#size').append('<option value="">Select Size</option>');
                    }
                });

                $('#size').on('change', function() {
                    var sizeId = $(this).val();
                    if (sizeId) {
                        $.ajax({
                            url: '{{ route('get-quantity', ['sizeId' => ':sizeId']) }}'.replace(
                                ':sizeId', sizeId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#qty').val(data.qty);
                            }
                        });
                    } else {
                        $('#qty').val('');
                    }
                });

                // Add More button functionality to add rows to the table
                $('.addeventmore').on('click', function() {
                    var categoryId = $('#category_id').val();
                    var categoryName = $('#category_id option:selected').text();
                    var subCategoryId = $('#sub_category').val();
                    var subCategoryName = $('#sub_category option:selected').text();
                    var itemId = $('#item_id').val();
                    var itemName = $('#item_id option:selected').text();
                    var size = $('#size').val();
                    var quantity = $('#qty').val();
                    var unitId = $('#unit_id').val();
                    var unitName = $('#unit_id option:selected').text();
                    var invoiceNo = $('#invoice_no').val();
                    var description = $('#description').val();

                    // Validate required fields (you may want to improve this)
                    if (categoryId === '' || subCategoryId === '' || itemId === '' || size === '' ||
                        quantity === '' || unitId === '') {
                        alert('Please fill all required fields.');
                        return;
                    }

                    // Add row to the table
                    var newRow = '<tr>' +
                        '<td><input type="text" class="form-control" name="category_id[]" value="' +
                        categoryName + '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="sub_category[]" value="' +
                        subCategoryName + '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="item_id[]" value="' + itemName +
                        '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="sizes[]" value="' + size +
                        '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="qty[]" value="' + quantity +
                        '"></td>' +
                        '<td><input type="text" class="form-control" name="unit_id[]" value="' + unitName +
                        '" readonly></td>' +
                        '<td><i class="btn btn-danger btn-sm fas fa-trash-alt removeeventmore"></i></td>' +
                        '</tr>';
                    $('#addRow').append(newRow);

                    // Clear input fields after adding row
                    $('#category_id').val('');
                    $('#sub_category').val('');
                    $('#item_id').val('');
                    $('#size').val('');
                    $('#qty').val('');
                    $('#unit_id').val('');
                    $('#invoice_no').val('');
                    $('#description').val('');
                });

                // Remove row functionality
                $('tbody').on('click', '.removeeventmore', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script>



        {{-- <script type="text/javascript">
            $(document).ready(function() {
                $('#category_id').on('change', function() {
                    var categoryId = $(this).val();
                    if (categoryId) {
                        $.ajax({
                            url: '{{ route('get-issue-subcategory', ['categoryId' => ':categoryId']) }}'
                                .replace(':categoryId', categoryId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#sub_category').empty();
                                $('#sub_category').append(
                                    '<option value="">Select Option</option>');
                                $.each(data, function(key, value) {
                                    $('#sub_category').append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#sub_category').empty();
                        $('#sub_category').append('<option value="">Select Option</option>');
                    }
                });

                $('#sub_category').on('change', function() {
                    var subCategoryId = $(this).val();
                    if (subCategoryId) {
                        $.ajax({
                            url: '{{ route('get-items', ['subCategoryId' => ':subCategoryId']) }}'
                                .replace(':subCategoryId', subCategoryId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#item_id').empty();
                                $('#item_id').append('<option value="">Select Item</option>');
                                $.each(data, function(key, value) {
                                    $('#item_id').append('<option value="' + key + '">' +
                                        value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#item_id').empty();
                        $('#item_id').append('<option value="">Select Item</option>');
                    }
                });

                $('#item_id').on('change', function() {
                    var itemId = $(this).val();
                    if (itemId) {
                        $.ajax({
                            url: '{{ route('get-sizes', ['itemId' => ':itemId']) }}'.replace(':itemId',
                                itemId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#size').empty();
                                $('#size').append('<option value="">Select Size</option>');
                                $.each(data, function(index, size) {
                                    $('#size').append('<option value="' + size + '">' +
                                        size + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#size').empty();
                        $('#size').append('<option value="">Select Size</option>');
                    }
                });

                $('#size').on('change', function() {
                    var sizeId = $(this).val();
                    if (sizeId) {
                        $.ajax({
                            url: '{{ route('get-quantity', ['sizeId' => ':sizeId']) }}'.replace(
                                ':sizeId', sizeId),
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#qty').val(data.qty);
                            }
                        });
                    } else {
                        $('#qty').val('');
                    }
                });

                // Add More button functionality to add rows to the table
                $('.addeventmore').on('click', function() {
                    var categoryId = $('#category_id').val();
                    var categoryName = $('#category_id option:selected').text();
                    var subCategoryId = $('#sub_category').val();
                    var subCategoryName = $('#sub_category option:selected').text();
                    var itemId = $('#item_id').val();
                    var itemName = $('#item_id option:selected').text();
                    var size = $('#size').val();
                    var quantity = $('#qty').val();
                    var unit = $('input[name="unit_id"]').val();
                    var invoiceNo = $('#invoice_no').val();
                    var description = $('#description').val();

                    // Validate required fields (you may want to improve this)
                    if (categoryId === '' || subCategoryId === '' || itemId === '' || size === '' ||
                        quantity === '' || unit === '') {
                        alert('Please fill all required fields.');
                        return;
                    }

                    // Add row to the table
                    var newRow = '<tr>' +
                        '<td><input type="text" class="form-control" name="category_name[]" value="' +
                        categoryName + '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="sub_name[]" value="' +
                        subCategoryName + '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="item_name[]" value="' + itemName +
                        '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="sizes[]" value="' + size +
                        '" readonly></td>' +
                        '<td><input type="text" class="form-control" name="qty[]" value="' + quantity +
                        '"></td>' +
                        '<td><input type="text" class="form-control" name="unit_id[]" value="' + unit +
                        '" readonly></td>' +
                        '<td><i class="btn btn-danger btn-sm fas fa-trash-alt removeeventmore"></i></td>' +
                        '</tr>';
                    $('#addRow').append(newRow);

                    // Clear input fields after adding row
                    $('#size').val('');
                    $('#qty').val('');
                    $('input[name="unit_id"]').val('');
                    $('#invoice_no').val('');
                    $('#description').val('');
                });

                // Remove row functionality
                $('tbody').on('click', '.removeeventmore', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script> --}}
    @endsection
