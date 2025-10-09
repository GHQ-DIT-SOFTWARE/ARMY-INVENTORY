@extends('admin.admin_master')
@section('admin')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />

    <style>
        .personnel-dashboard .card {
            border: none;
            box-shadow: 0 0.25rem 1rem rgba(44, 62, 80, 0.08);
        }

        .personnel-dashboard .card-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            color: #6c757d;
        }

        .personnel-dashboard .stat-value {
            font-size: 2rem;
            font-weight: 700;
        }

        .personnel-dashboard .list-unstyled li {
            display: flex;
            justify-content: space-between;
            padding: 0.35rem 0;
            border-bottom: 1px dashed #e9ecef;
            font-size: 0.9rem;
        }

        .personnel-dashboard .list-unstyled li:last-child {
            border-bottom: none;
        }

        .filter-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .recent-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #f1f3f5;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Personnel Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Personnel</li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="personnel-dashboard">
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title">Total Personnel</span>
                        <div class="stat-value text-primary">{{ number_format($totals['all'] ?? 0) }}</div>
                        <small class="text-muted">All records in the database</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title">Officers</span>
                        <div class="stat-value text-success">{{ number_format($totals['officers'] ?? 0) }}</div>
                        <small class="text-muted">Service category: OFFICER</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title">Other Ranks</span>
                        <div class="stat-value text-warning">{{ number_format($totals['otherRanks'] ?? 0) }}</div>
                        <small class="text-muted">Non-officer personnel</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <span class="card-title">With Email</span>
                        <div class="stat-value text-info">{{ number_format($totals['withEmail'] ?? 0) }}</div>
                        <small class="text-muted">Profiles with email addresses</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Arm Composition</h5>
                        <span class="badge badge-light text-dark">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="text-muted text-uppercase mb-3">By Unit</h6>
                                <div class="position-relative">
                                    <canvas id="unit-distribution-chart" height="220"></canvas>
                                    @if (! count($unitChartData['labels']))
                                        <p class="text-muted small text-center mt-3">No data available</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-muted text-uppercase mb-3">By Gender</h6>
                                <div class="position-relative">
                                    <canvas id="gender-distribution-chart" height="220"></canvas>
                                    @if (! count($genderChartData['labels']))
                                        <p class="text-muted small text-center mt-3">No data available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('personal-mech') }}" class="btn btn-primary btn-block mb-2">
                                <i class="feather icon-user-plus"></i> Add Personnel
                            </a>
                            <button type="button" id="export-personnel" class="btn btn-outline-primary btn-block mb-2">
                                <i class="feather icon-download"></i> Export Personnel
                            </button>
                            <a href="{{ route('personnel.size-report') }}" class="btn btn-outline-success btn-block">
                                <i class="feather icon-pie-chart"></i> Personnel Size Report
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Additions</h5>
                        <span class="badge badge-primary text-uppercase">Last 6</span>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($recentlyAdded as $person)
                            <li class="list-group-item d-flex align-items-center">
                                <img class="recent-avatar me-3"
                                    src="{{ $person->personnel_image ? asset($person->personnel_image) : asset('upload/images.png') }}"
                                    alt="{{ $person->initial }}">
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $person->initial }}</div>
                                    <small class="text-muted">
                                        {{ $person->svcnumber }} � {{ optional($person->rank)->rank_name ?? 'N/A' }}
                                    </small>
                                </div>
                                <small class="text-muted">{{ $person->created_at?->diffForHumans() }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">No recent records</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center">
                <div>
                    <h5 class="mb-1">Personnel Registry</h5>
                    <span class="text-muted">Use the controls to run targeted queries.</span>
                </div>
                <div class="ml-md-auto mt-3 mt-md-0">
                    <button class="btn btn-link text-decoration-none p-0" type="button" data-toggle="collapse"
                        data-target="#filter-collapse" aria-expanded="true" aria-controls="filter-collapse">
                        <i class="feather icon-filter"></i> Toggle Filters
                    </button>
                </div>
            </div>
            <div class="collapse show" id="filter-collapse">
                <div class="card-body">
                    <form id="personnel-filter-form" class="row">
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-service-category">Service Category</label>
                            <select id="filter-service-category" name="service_category" class="form-control">
                                <option value="">Any</option>
                                @foreach ($serviceCategories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-service">Service</label>
                            <select id="filter-service" name="service" class="form-control">
                                <option value="">Any</option>
                                @foreach ($serviceOptions as $service)
                                    <option value="{{ $service['value'] }}">{{ $service['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-rank">Rank</label>
                            <select id="filter-rank" name="rank" class="form-control">
                                <option value="">Any</option>
                                @foreach ($rankOptions as $rank)
                                    <option value="{{ $rank['value'] }}">{{ $rank['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-unit">Unit</label>
                            <select id="filter-unit" name="unit" class="form-control">
                                <option value="">Any</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name ?? $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-gender">Gender</label>
                            <select id="filter-gender" name="gender" class="form-control">
                                <option value="">Any</option>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-email">Email Status</label>
                            <select id="filter-email" name="has_email" class="form-control">
                                <option value="">Any</option>
                                <option value="true">Has email</option>
                                <option value="false">No email</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group mb-3">
                            <label for="filter-from">Created From</label>
                            <input type="date" id="filter-from" name="created_from" class="form-control">
                        </div>
                        <div class="col-xl-2 col-md-4 col-sm-6 filter-group">
                            <label for="filter-to">Created To</label>
                            <input type="date" id="filter-to" name="created_to" class="form-control">
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-6 filter-group mb-3">
                            <label for="filter-search">Quick Search</label>
                            <input type="text" id="filter-search" name="search_term" class="form-control"
                                placeholder="Svc number, name, etc.">
                        </div>
                        <div class="col-xl-3 col-md-6 col-sm-6 d-flex align-items-end mb-3">
                            <button type="button" id="apply-filters" class="btn btn-primary btn-block mr-2">
                                <i class="feather icon-sliders"></i> Apply Filters
                            </button>
                            <button type="button" id="reset-filters" class="btn btn-light btn-block">
                                <i class="feather icon-rotate-ccw"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table id="personnel-table" class="table table-striped table-bordered nowrap w-100">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Service No.</th>
                                <th>Rank</th>
                                <th>Initials</th>
                                <th>Service</th>
                                <th>Category</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Import Personnel</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Import personnel data using the official template. Ensure your Excel
                            columns
                            match the sample file before uploading.</p>
                        <form action="{{ route('import-personnel') }}" method="POST" enctype="multipart/form-data"
                            class="row">
                            @csrf
                            <div class="col-lg-8 col-md-7 col-sm-12 mb-3 mb-md-0">
                                <input type="file" name="file" id="fileUpload" class="form-control"
                                    accept=".xlsx, .csv">
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-12">
                                <button class="btn btn-info btn-block"><i class="feather icon-upload-cloud"></i> Import File</button>
                            </div>
                            @error('file')
                                <div class="col-12">
                                    <div class="alert alert-danger mb-0">
                                        {{ $message }} Please upload a valid file (xlsx, csv).
                                    </div>
                                </div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Template & Tips</h5>
                        <button id="download-template" class="btn btn-sm btn-success">
                            <i class="feather icon-download-cloud"></i> Download Template
                        </button>
                    </div>
                    <div class="card-body">
                        <ol class="mb-0 small">
                            <li>Download the template and populate it with personnel data.</li>
                            <li>Do not change the column headers or sheet order.</li>
                            <li>Images are optional; upload them later through the edit screen.</li>
                            <li>Validate mandatory fields (service no., names, phone) before import.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        (function() {
            const unitChartData = @json($unitChartData);
            const genderChartData = @json($genderChartData);

            function buildPalette(count) {
                const base = ['#1d4ed8', '#0ea5e9', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#ec4899', '#14b8a6', '#f97316', '#84cc16'];
                const colors = [];
                for (let i = 0; i < count; i += 1) {
                    colors.push(base[i % base.length]);
                }
                return colors;
            }

            function renderChart(canvasId, type, labels, values, extraOptions = {}) {
                const canvas = document.getElementById(canvasId);
                if (!canvas || !Array.isArray(labels) || !labels.length) {
                    return null;
                }

                const datasetColors = buildPalette(labels.length);
                const chartConfig = {
                    type,
                    data: {
                        labels,
                        datasets: [{
                            label: 'Personnel',
                            data: values,
                            backgroundColor: datasetColors,
                            borderColor: datasetColors,
                            borderWidth: type === 'bar' ? 0 : 1,
                            borderRadius: type === 'bar' ? 6 : 0,
                        }],
                    },
                    options: Object.assign({
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: type !== 'bar',
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                                        return `${context.label}: ${value} personnel`;
                                    },
                                },
                            },
                        },
                        scales: type === 'bar' ? {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                },
                                grid: {
                                    color: '#f1f5f9',
                                },
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                },
                                grid: {
                                    display: false,
                                },
                            },
                        } : undefined,
                    }, extraOptions),
                };

                return new Chart(canvas, chartConfig);
            }

            renderChart('unit-distribution-chart', 'bar', unitChartData.labels || [], unitChartData.values || [], {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            });

            renderChart('gender-distribution-chart', 'doughnut', genderChartData.labels || [], genderChartData.values || []);

            const filterForm = $('#personnel-filter-form');

            function getSelectValue(selector) {
                const value = $(selector).val();
                return value ? [value] : [];
            }

            function buildAjaxData(d) {
                d._token = '{{ csrf_token() }}';
                d.service_categories = getSelectValue('#filter-service-category');
                d.services = getSelectValue('#filter-service');
                d.ranks = getSelectValue('#filter-rank');
                d.units = getSelectValue('#filter-unit');
                d.genders = getSelectValue('#filter-gender');
                d.has_email = $('#filter-email').val();
                d.created_from = $('#filter-from').val();
                d.created_to = $('#filter-to').val();
                d.search_term = $('#filter-search').val();
            }

            const table = $('#personnel-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100, 200],
                    [10, 25, 50, 100, 200],
                ],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-right'B>>rtip",
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'Personnel Export',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Personnel Export',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Personnel Export',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        title: 'Personnel Export',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                ajax: {
                    url: '{{ route('api-view-personnel') }}',
                    type: 'POST',
                    dataSrc: 'data',
                    data: function(d) {
                        buildAjaxData(d);
                    },
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'svcnumber',
                        name: 'svcnumber'
                    },
                    {
                        data: 'rank_label',
                        name: 'rank_id',
                        defaultContent: ''
                    },
                    {
                        data: 'initial',
                        name: 'initial'
                    },
                    {
                        data: 'service_label',
                        name: 'arm_of_service',
                        defaultContent: ''
                    },
                    {
                        data: 'service_category',
                        name: 'service_category'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        defaultContent: ''
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        defaultContent: ''
                    },
                    {
                        data: 'mobile_no',
                        name: 'mobile_no',
                        defaultContent: ''
                    },
                    {
                        data: 'personnel_image',
                        name: 'personnel_image',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            const fallback = '{{ asset('upload/images.png') }}';
                            const imageUrl = data ? '{{ asset('') }}' + data : fallback;
                            return '<img src="' + imageUrl +
                                '" class="img-thumbnail" style="width:60px;height:50px;object-fit:cover;">';
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full) {
                            const profileUrl = '{{ route('personnel.profile', ':uuid') }}'.replace(':uuid', full.uuid);
                            const editUrl = '{{ route('personal-edit', ':uuid') }}'.replace(':uuid', full.uuid);
                            return '' +
                                '<div class="btn-group btn-group-sm" role="group">' +
                                '<a href="' + profileUrl + '" class="btn btn-outline-secondary"><i class="feather icon-eye"></i> View</a>' +
                                '<a href="' + editUrl + '" class="btn btn-primary"><i class="feather icon-edit"></i> Edit</a>' +
                                '</div>';
                        }
                    },
                ]
            });

            $('#apply-filters').on('click', function() {
                table.ajax.reload(null, true);
            });

            $('#reset-filters').on('click', function() {
                filterForm[0].reset();
                filterForm.find('select').val('');
                table.ajax.reload(null, true);
            });

            let searchTimeout = null;
            $('#filter-search').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    table.ajax.reload(null, true);
                }, 400);
            });

            $('#export-personnel').on('click', function() {
                table.button('.buttons-excel').trigger();
            });

            $('#download-template').on('click', function() {
                window.location.href = '{{ url('/personnel/download-sample-excel') }}';
            });
        })();
    </script>
@endsection
