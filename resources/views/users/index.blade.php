@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">View Users</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] start -->
    @if (session()->has('alert'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('alert') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Users List</h4>
                    <p class="float-right mb-2">

                            <a class="btn btn-info text-white rounded" href="{{ route('create-user') }}">Create New User</a>
                       
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('users.part.message')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Email</th>
                                    <th width="10%">Code</th>
                                    <th width="10%">Phone Number</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Roles</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->code }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>
                                            @if ($user->status == 0)
                                                <a href="{{ route('user.inactive', $user->uuid) }}"
                                                    class="badge badge-danger sm" title="Inactive"
                                                    id="InactiveBtn">-Inactive</a>
                                            @elseif ($user->status == 1)
                                                <a href="{{ route('user.active', $user->uuid) }}"
                                                    class="badge badge-success sm" title="Active" id="ActiveBtn">
                                                    - Active</a>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-info mr-1">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>

                                        <td>

                                                <a class="badge badge-success text-white"
                                                    href="{{ route('edit-user', $user->uuid) }}">Edit</a>



                                                <a class="badge badge-danger text-white" id="delete"
                                                    href="{{ route('destroy-user', $user->uuid) }}">
                                                    Delete
                                                </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    </div>
    </div>



    <!-- [ Main Content ] end -->
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
    </script>
@endsection
