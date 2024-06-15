@extends('admin.admin_master')
@section('title')
    Restock-Item
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Items</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Restock-Item</a></li>
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
                    <h5>Restock Item</h5>
                </div>
                <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
                    <div class="col-md-12 border-right">
                        <div class="card-body">
                            <form action="{{ route('storepurchase') }}" method="POST" id="myForm">
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
                                            <label for="name" class="col-sm-3 col-form-label">Supplier`s Name</label>
                                            <div class="col-sm-9">
                                                <select name="supplier_id" class="form-control select2">
                                                    <option selected="">Open this select menu</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}
                                                        </option>
                                                    @endforeach
                                                    @error('supplier_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
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
                                            <button type="submit" class="btn  btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
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

                    // Update size options based on category
                    @foreach ($category as $cat)
                        if (categoryId == '{{ $cat->id }}' && '{{ $cat->category_name }}' ==
                            'BOOT') {
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
                } else {
                    $('#sub_category').empty();
                    $('#size').empty();
                    $('#size').append('<option selected="">Select Size</option>');
                }
            });
        });
    </script>
@endsection
