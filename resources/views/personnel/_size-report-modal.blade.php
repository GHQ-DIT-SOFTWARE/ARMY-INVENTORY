{{--
    This partial contains the modal for the personnel size report and the
    necessary scripts. It should be included in the main personnel view.
--}}

{{-- DataTables and Buttons CSS/JS --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- Size Report Modal -->
<div class="modal fade" id="sizeReportModal" tabindex="-1" role="dialog" aria-labelledby="sizeReportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sizeReportModalLabel">Personnel Size Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="personnelSizeTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Svc No</th>
                            <th>Rank</th>
                            <th>Surname</th>
                            <th>First Name</th>
                            <th>Phone</th>
                            <th>Unit</th>
                            <th>Shoe Size</th>
                            <th>Boot Size</th>
                            <th>Uniform Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data will be loaded here by DataTables --}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sizeReportModal').on('shown.bs.modal', function() {
            if (!$.fn.DataTable.isDataTable('#personnelSizeTable')) {
                $('#personnelSizeTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('personnel.size.report.data') }}",
                    columns: [
                        { data: 'svcnumber', name: 'svcnumber' },
                        { data: 'rank.rank_name', name: 'rank.rank_name' },
                        { data: 'surname', name: 'surname' },
                        { data: 'first_name', name: 'first_name' },
                        { data: 'mobile_no', name: 'mobile_no' },
                        { data: 'unit.unit_name', name: 'unit.unit_name' },
                        { data: 'shoe_size', name: 'shoe_size' },
                        { data: 'boot_size', name: 'boot_size' },
                        { data: 'uniform_size', name: 'uniform_size' }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    });
</script>

{{--
    Note for developer:
    1. You will need to create a new route in `routes/web.php` pointing to a controller method:
       Route::get('/personnel/size-report/data', [PersonnelController::class, 'getSizeReportData'])->name('personnel.size.report.data');

    2. In `PersonnelController`, create the `getSizeReportData` method to handle the AJAX request from DataTables.
       It should fetch personnel data with their related rank and unit, and return it in the format required by DataTables (using a package like yajra/laravel-datatables-oracle is highly recommended).
--}}
