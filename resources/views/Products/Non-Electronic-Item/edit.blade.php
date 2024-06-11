@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">DIT MIS</h5>
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
                    <h5>Edit General Item.</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('update.nonpro') }}" method="POST" id="myForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $non_electronic->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Item Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="product_name"
                                            value="{{ $non_electronic->product_name }}">
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Category Name</label>
                                    <div class="col-sm-9">
                                        <select name="category_name" class="form-control select2">
                                            <option selected="">Open this select menu</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == $non_electronic->category_name ? 'selected' : '' }}>
                                                    {{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Body No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="body_no"
                                            value="{{ $non_electronic->body_no }}">
                                        @error('body_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="status">
                                            <option value="">Select Option</option>
                                            <option {{ $non_electronic->status == '1' ? 'selected' : '' }} value="1">
                                                Ser</option>
                                            <option {{ $non_electronic->status == '0' ? 'selected' : '' }} value="0">
                                                UnSer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">State</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="state">
                                            <option value="">Select Option</option>
                                            <option {{ $non_electronic->state == '1' ? 'selected' : '' }} value="1">
                                                Available</option>
                                            <option {{ $non_electronic->state == '0' ? 'selected' : '' }} value="0">
                                                Unavailable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="service" class="col-sm-3 col-form-label">Item Location</label>
                                    <div class="col-sm-9">
                                    <input type="text"  class="form-control" name="item_location" value="{{$non_electronic->item_location}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="unit" class="col-sm-3 col-form-label">Item Image</label>
                                    <div class="col-sm-9">
                                        <input name="item_image" class="form-control" type="file" id="image"
                                            value="{{ $non_electronic->item_image }}">
                                    </div>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ url('nonelectronics/no_image.jpg') }}" alt="IMAGE"
                                            style="width: 100px; width: 100px; border: 1px solid #000000;">
                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn  btn-success">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    supplier_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Your Unit',
                    },
                    supplier_id: {
                        required: 'Please Select One Supplier',
                    },
                    category_id: {
                        required: 'Please Select One Category',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
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
