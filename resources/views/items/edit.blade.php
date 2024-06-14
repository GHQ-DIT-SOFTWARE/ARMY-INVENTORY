@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Logistics Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Edit Item</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Item Details</h5>
                </div>
                <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
                    <div class="col-md-12 border-right">
                        <div class="card-body">
                            <form action="{{ route('update-items-quantities', $item->uuid) }}" method="POST" id="myForm"
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
                                                            {{ $cat->id == $item->category_id ? 'selected' : '' }}>
                                                            {{ $cat->category_name }}
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
                                    {{-- <div class="col-md-4">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Mission</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="mission_id" id="mission_id"
                                                    required>
                                                    <option value="">Select the Mission</option>
                                                    @foreach ($missions as $list)
                                                        <option
                                                            value="{{ $list->id }}"{{ $list->id == $item->mission_id ? 'selected' : '' }}>
                                                            {{ $list->mission_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('mission_id')
                                                    <span class="btn btn-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Item Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="item_name"
                                                    value="{{ $item->item_name }}">
                                                @error('item_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="service" class="col-sm-4 col-form-label">Actual Qty</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="actual_qty"
                                                    placeholder="Description" value="{{ $item->actual_qty }}">
                                                @error('actual_qty')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group row">
                                            <label for="service" class="col-sm-4 col-form-label">Mou Qty</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="mou_qty"
                                                    placeholder="Item Serial No" value="{{ $item->mou_qty }}">
                                                @error('mou_qty')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn  btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch and populate subcategories when the page loads
            var categoryId = $('#category_id').val();
            populateSubcategories(categoryId);
            // Event listener for changes in the main category dropdown
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId);
            });
            // Function to fetch and populate subcategories
            function populateSubcategories(categoryId) {
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
                } else {
                    $('#sub_category').empty();
                }
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
