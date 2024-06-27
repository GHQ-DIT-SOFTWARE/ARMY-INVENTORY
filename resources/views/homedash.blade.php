@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Main</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    {{-- <div id="filters" class="button-group">
                        <button class="button btn btn-outline-secondary my-1 active" data-filter="*">Show
                            all</button>
                        <button class="button btn btn-outline-secondary my-1" data-filter=".operation">Operations</button>
                        <button class="button btn btn-outline-secondary my-1" data-filter=".logistics">Logistics</button>
                        <button class="button btn btn-outline-secondary my-1" data-filter=".admin">Administration</button>
                        <button class="button btn btn-outline-secondary my-1" data-filter=".others">Others</button>
                    </div> --}}
                    <h5 style="text-align: center">MANAGE DASHBOARD</h5>
                    @php
                        $totalItems = \App\Models\Item::count();
                        $totalQty = \App\Models\Item::sum('qty');
                        $totalrestock = \App\Models\Restock::sum('qty');
                        $totalSubCategory = \App\Models\SubCategory::count();
                    @endphp

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card bg-c-green text-white widget-visitor-card">
                                <div class="card-body text-center">
                                    <h2 class="text-white" id="totalItems">{{ $totalItems }}</h2>
                                    <h6 class="text-white">TOTAL ITEMS</h6>
                                    <i class="feather icon-user-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card bg-c-green text-white widget-visitor-card">
                                <div class="card-body text-center">
                                    <h2 class="text-white">{{ $totalQty }}</h2>
                                    <h6 class="text-white">STOCK QUANTITY</h6>
                                    <i class="feather icon-user-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card bg-c-green text-white widget-visitor-card">
                                <div class="card-body text-center">
                                    <h2 class="text-white">{{ $totalrestock }}</h2>
                                    <h6 class="text-white">RESTOCK QUANTITY TOTAL</h6>
                                    <i class="feather icon-user-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card bg-c-green text-white widget-visitor-card">
                                <div class="card-body text-center">
                                    <h2 class="text-white">{{ $totalSubCategory }}</h2>
                                    <h6 class="text-white">CATEGORIES</h6>
                                    <i class="feather icon-user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="">
                <div class="card-body hd-detail hdd-admin border-bottom">
                    <div class="grid row">
                        <div class="element-item operation sponsored" data-category="operation">
                            <a href="{{ route('Issue-out') }}">
                                <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                    <img src="{{ asset('assets/images/dashicons/write-off.png') }}" style="width: 3rem;"
                                        class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                    <div class="card-body p-2">
                                        <p class="card-text text-center font-weight-bold">Request</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="element-item admin notrated " data-category="logistics">
                            <a href="{{ route('item-issued-out') }}">
                                <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                    <img src="{{ asset('assets/images/dashicons/authorise.png') }}" style="width: 3rem;"
                                        class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                    <div class="card-body p-2">
                                        <p class="card-text text-center font-weight-bold">Authorized</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="element-item admin notrated " data-category="logistics">
                            <a href="{{ route('aggregated-item') }}">
                                <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                    <img src="{{ asset('assets/images/dashicons/pending.png') }}" style="width: 3rem;"
                                        class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                    <div class="card-body p-2">
                                        <p class="card-text text-center font-weight-bold">Pending</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="element-item admin sponsored " data-category="admin">
                            <a href="{{ route('all-items-confirmed-issued') }}">
                                <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                    <img src="{{ asset('assets/images/dashicons/request.png') }}" style="width: 3rem;"
                                        class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                    <div class="card-body p-2">
                                        <p class="card-text text-center font-weight-bold">Issued</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="element-item logistics notrated " data-category="admin">
                            <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                <img src="{{ asset('assets/images/dashicons/search.png') }}" style="width: 3rem;"
                                    class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                <div class="card-body p-2">
                                    <p class="card-text text-center font-weight-bold">Search</p>
                                </div>
                            </div>
                        </div>

                        <div class="element-item others neutral " data-category="others">
                            <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                <img src="{{ asset('assets/images/dashicons/stock.png') }}" style="width: 3rem;"
                                    class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                <div class="card-body p-2">
                                    <p class="card-text text-center font-weight-bold">Stock level</p>
                                </div>
                            </div>
                        </div>

                        <div class="element-item others sponsored " data-category="others">
                            <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                <img src="{{ asset('assets/images/dashicons/charts.png') }}" style="width: 3rem;"
                                    class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                <div class="card-body p-2">
                                    <p class="card-text text-center font-weight-bold">Charts</p>
                                </div>
                            </div>
                        </div>

                        <div class="element-item operation sponsored " data-category="operation">
                            <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                <img src="{{ asset('assets/images/dashicons/supplier.png') }}" style="width: 3rem;"
                                    class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                <div class="card-body p-2">
                                    <p class="card-text text-center font-weight-bold">Suppliers</p>
                                </div>
                            </div>
                        </div>
                        <div class="element-item operation neutral " data-category="operation">
                            <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                <img src="{{ asset('assets/images/dashicons/catalog.png') }}" style="width: 3rem;"
                                    class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                <div class="card-body p-2">
                                    <p class="card-text text-center font-weight-bold">Catalog</p>
                                </div>
                            </div>
                        </div>
                        <div class="element-item admin neutral " data-category="admin">
                            <a href="{{ route('all-items-confirmed-issued') }}">
                                <div class="card mx-3 shadow p-3" style="width: 8rem;">
                                    <img src="{{ asset('assets/images/dashicons/letter.png') }}" style="width: 3rem;"
                                        class="card-img-top mx-auto d-block mt-2 mb-2" alt="...">
                                    <div class="card-body p-2">
                                        <p class="card-text text-center font-weight-bold">Write-Off</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                </div>
            </div>

            <!-- progressbar static data start -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Request by all units</h5>
                        </div>
                        <div class="card-body">
                            <div id="collected-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
