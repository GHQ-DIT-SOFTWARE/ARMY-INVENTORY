@extends('admin.admin_master')
@section('title')
    Add-Item
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Items</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">AddItem</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Item</h5>
                </div>
                <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
                    <div class="col-md-10 border-right">
                        <div class="card-body">
                            <form action="{{ route('store-item') }}" method="POST" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
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
                                                <input type="text" class="form-control" name="item_name"
                                                    placeholder="Item Name">
                                                @error('item_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="actual_qty" class="col-sm-4 col-form-label">Quantity</label>
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
                                            <label for="size" class="col-sm-4 col-form-label">Sizes</label>
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
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="remarks"
                                                    placeholder="Remarks">
                                                @error('remarks')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn  btn-primary">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-2 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="margin-top: -40px">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <img id="showImage" class="rounded avatar-lg"
                                        src="{{ url('uploadimage/no_image.jpg') }}" alt="IMAGE"
                                        style="width: 150px; border: 1px solid #000000;">
                                </div>
                                <div class="">
                                    <input name="item_image" class="form-control" type="file" id="image">
                                    @error('item_image')
                                        <span class="badge badge-dander">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to update sub-categories based on selected main category
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('get-subcategory', ['categoryId' => ':categoryId']) }}'
                            .replace(':categoryId', categoryId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#sub_category').empty();
                            $('#sub_category').append(
                            '<option value="">Select Option</option>');
                            $.each(data, function(index, subcategory) {
                                $('#sub_category').append('<option value="' +
                                    subcategory.id + '">' + subcategory.sub_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_category').empty();
                    $('#sub_category').append('<option value="">Select Option</option>');
                    $('#size').empty();
                    $('#size').append('<option selected="">Select Size</option>');
                }
            });

            // Function to update sizes based on selected sub-category
            $('#sub_category').on('change', function() {
                var subCategoryId = $(this).val();
                var sizeOptions = [];
                if (subCategoryId) {
                    var selectedSubCategory = $('#sub_category option:selected').text().trim();
                    if (selectedSubCategory === 'BERETS') {
                        sizeOptions = [52, 53, 54, 55, 56, 57, 58, 59];
                    } else if (selectedSubCategory === 'BLACK SHOE' || selectedSubCategory ===
                        'BROWN SHOE' || selectedSubCategory === 'COMBAT BOOT' || selectedSubCategory ===
                        'DESERT BOOT') {
                        sizeOptions = [39, 40, 41, 42, 43, 44, 45, 46];
                    } else {
                        sizeOptions = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                    }

                    $('#size').empty();
                    $.each(sizeOptions, function(index, size) {
                        $('#size').append('<option value="' + size + '">' + size + '</option>');
                    });
                } else {
                    $('#size').empty();
                    $('#size').append('<option selected="">Select Size</option>');
                }
            });

            // Function to handle visibility of Sizes based on selected category
            $('#category_id').on('change', function() {
                var selectedCategory = $('#category_id option:selected').text().trim();
                var hideSizesCategories = ['TECHNICAL', 'ACCOMMODATION'];

                if (hideSizesCategories.includes(selectedCategory)) {
                    $('#size').closest('.col-md-4').hide(); // Hide the entire column for sizes
                } else {
                    $('#size').closest('.col-md-4').show(); // Show the sizes column
                }
            });

            // Clear size value if the sizes field is hidden before form submission
            $('#myForm').on('submit', function() {
                var selectedCategory = $('#category_id option:selected').text().trim();
                var hideSizesCategories = ['TECHNICAL', 'ACCOMMODATION'];

                if (hideSizesCategories.includes(selectedCategory)) {
                    $('#size').val(''); // Clear the value of the size field
                }
            });

            // Trigger change event initially to check category on page load
            $('#category_id').change();
        });
    </script>
@endsection
