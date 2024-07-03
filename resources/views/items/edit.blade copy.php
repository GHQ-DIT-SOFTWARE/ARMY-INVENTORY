@extends('admin.admin_master')
@section('title')
    Edit-Item
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Equipment</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Edit Item</a></li>
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
                    <h5>Edit Item</h5>
                </div>
                <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
                    <div class="col-md-10 border-right">
                        <div class="card-body">
                            <form action="{{ route('update-item', $items->uuid) }}" method="POST" id="myForm"
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
                                                        <option value="{{ $cat->id }}"
                                                            {{ $cat->id == $items->category_id ? 'selected' : '' }}>
                                                            {{ $cat->category_name }}</option>
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
                                                    value="{{ $items->item_name }}" placeholder="Item Name">
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
                                                <input type="text" class="form-control" name="qty"
                                                    value="{{ $items->qty }}" placeholder="Qty">
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
                                                    value="{{ $items->remarks }}" placeholder="Remarks">
                                                @error('remarks')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-6" style="float:right;">
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Update Item</button>
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
                                        src="{{ !empty($items->item_image) ? url($items->item_image) : url('uploadimage/no_image.jpg') }}"
                                        alt="IMAGE" style="width: 150px; border: 1px solid #000000;">
                                </div>
                                <div class="">
                                    <input name="item_image" class="form-control" type="file" id="image">
                                    @error('item_image')
                                        <span class="badge badge-danger">{{ $message }}</span>
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
            function loadSubCategoriesAndSizes() {
                var categoryId = $('#category_id').val();
                var sizeOptions = [];
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('get-subcategory', ['categoryId' => ':categoryId']) }}'
                            .replace(':categoryId', categoryId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#sub_category').empty();
                            $.each(data, function(index, subcategory) {
                                $('#sub_category').append('<option value="' +
                                    subcategory.id +
                                    '">' + subcategory.sub_name + '</option>');
                            });
                        }
                    });

                    @foreach ($category as $cat)
                        if (categoryId == '{{ $cat->id }}' && '{{ $cat->category_name }}' == 'BOOT') {
                            sizeOptions = [39, 40, 41, 42, 43, 44, 45, 46];
                        } else if (categoryId == '{{ $cat->id }}' && '{{ $cat->category_name }}' ==
                            'BERET') {
                            sizeOptions = [52, 53, 54, 55, 56, 57, 58, 59];
                        } else {
                            sizeOptions = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                        }
                    @endforeach

                    $('#size').empty();
                    $.each(sizeOptions, function(index, size) {
                        $('#size').append('<option value="' + size + '">' + size + '</option>');
                    });
                    $('#size').val('{{ $items->sizes }}');
                } else {
                    $('#sub_category').empty();
                    $('#size').empty();
                    $('#size').append('<option selected="">Select Size</option>');
                }
            }

            $('#category_id').on('change', loadSubCategoriesAndSizes);
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            loadSubCategoriesAndSizes(); // Load subcategories and sizes on page load
        });
    </script>
@endsection
