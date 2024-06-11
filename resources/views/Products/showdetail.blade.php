@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Item Detail</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Item Details</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dasboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row justify-content-center">
        <!-- liveline-section start -->

        <div class="col-sm-12">
            @if (isset($message))
                <div class="alert alert-{{ $alertType }}">{{ $message }}</div>
            @endif
            <div class="card user-profile-list">
                <div class="card-header">
                    <h5>Details</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-right"><br />
                        </div>
                        @if ($categoryItems->count() > 0)
                        <div class="dt-responsive table-responsive">
                            <table id="example" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="select_all"
                                                    value="1" id="contactstable-select-all">
                                                <label class="custom-control-label" for="contactstable-select-all"></label>
                                            </div>
                                        </th>
                                        <th>Item Name</th>
                                        <th>In stock</th>
                                        <th>Issued out</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categoryItems as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->available }}</td>
                                            <td>{{ $product->unavailable }}</td>
                                            <td>{{$product->available + $product->unavailable}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @if ($relatedItems->count() > 0)
                            <div class="dt-responsive table-responsive">
                                <table id="related-items" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select_all"
                                                        value="1" id="related-items-select-all">
                                                    <label class="custom-control-label"
                                                        for="related-items-select-all"></label>
                                                </div>
                                            </th>
                                            <th>Item Name</th>
                                            <th>In Stock</th>
                                            <th>Issued Out</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($relatedItems as $key => $relatedItem)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $relatedItem->product_name }}</td>
                                            <td>{{ $relatedItem->available }}</td>
                                            <td>{{ $relatedItem->unavailable }}</td>
                                            <td>{{ $relatedItem->available + $relatedItem->unavailable }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- liveline-section end -->
    </div>
    <!-- [ Main Content ] end -->
    <!-- [ Main Content ] end -->


    <!-- Modal -->
    </div>
    </div>



    <!-- [ Main Content ] end -->
    <script>
        $(document).ready(function() {
            $('#related-items-select-all').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

@endsection
