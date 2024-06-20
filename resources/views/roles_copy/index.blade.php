@extends('admin.admin_master')
@section('admin')
<!-- [ breadcrumb ] end -->
<style>
    #dataTable{
        font-size: 19px;
    }
   </style>
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Roles </h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashbaord</a></li>
                            <li class="breadcrumb-item"><a href="#!">All Roles</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- customar project  start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Roles List</h4>
                        <p class="float-right mb-2">
                            @if (Auth::guard('web')->user()->can('role.create'))
                                <a class="btn btn-primary text-white" href="{{ route('roles.create') }}">Create New Role</a>
                            @endif
                        </p>
                        <div class="clearfix"></div>
                        <div class="data-tables">
                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th width="10%">Role</th>
                                        <th width="60%">Permissions</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($roles as $role)
                                   <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $perm)
                                                <span class="badge badge-info mr-1">
                                                    {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (Auth::guard('web')->user()->can('role.edit'))
                                                <a class="btn btn-success text-white" href="{{ route('roles.edit', $role->id) }}">Edit</a>

                                            @endif
                                           @if (Auth::guard('web')->user()->can('role.delete'))
                                                <a class="btn btn-danger text-white" href="{{ route('roles.destroy', $role->id) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                    Delete
                                                </a>

                                                <form id="delete-form-{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- customar project  end -->
        </div>
        <!-- [ Main Content ] end -->


        <script>
            /*================================
           datatable active
           ==================================*/
           if ($('#dataTable').length) {
               $('#dataTable').DataTable({
                   responsive: true
               });
           }

        </script>
    <!-- Required Js -->

<script src="{{asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables.bootstrap4.min.js')}}"></script>
<!-- Apex Chart -->
<script src="{{asset('assets/js/plugins/apexcharts.min.js')}}"></script>
<script>
    // DataTable start
    $('#report-table').DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ]
    });
    // DataTable end
</script>
<!-- [ Main Content ] end -->


@endsection
