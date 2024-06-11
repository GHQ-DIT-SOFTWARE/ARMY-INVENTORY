@php
    $usr = Auth::guard('web')->user();
@endphp
<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar menu-light  ">
    <div class="navbar-wrapper ">
        <div class="navbar-content scroll-div ">
            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-home"></i></span><b><span
                                class="pcoded-mtext">Dashboard</span></b></a>
                </li>

                @if ($usr->can('superadmin.view'))
                    <li class="nav-item">
                        <a href="{{ route('home.dash') }}" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-home"></i></span>
                            <b><span class="pcoded-mtext">Admin-Dashboard</span></b></a>
                    </li>
                @endif
                @if ($usr->can('admin.view'))
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link"><span class="pcoded-micon"><i
                                    class=" feather icon-align-center"></i></span><b><span class="pcoded-mtext">Outgoing
                                    Item</span></b></a>
                        <ul class="pcoded-submenu">
                            <li class="nav-item pcoded-hasmenu">
                                <!--
                                <a href="{{ route('item.issue.routing.view') }}" class="nav-link "><span
                                        class="pcoded-mtext">Issued</span></a>
                                -->
                            </li> <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('item.issue.electronic.view')}}" class="nav-link "><span class="pcoded-mtext">Eletronic Items-Issuing</span></a>
                            </li> <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('item.issue.general.view')}}" class="nav-link "><span class="pcoded-mtext">General Item-Issuing</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('item.receive.electronic.view')}}" class="nav-link "><span class="pcoded-mtext">Items Returned</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('history.dash')}}" class="nav-link "><span class="pcoded-mtext">Item History</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if ($usr->can('role.create') || $usr->can('role.view') || $usr->can('role.edit') || $usr->can('role.delete'))
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-grid"></i></span><b><span class="pcoded-mtext">Instock
                                    Items</span></b></a>
                        <ul class="pcoded-submenu"
                            {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                            <!--
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('route.items') }}" class="nav-link "><span
                                        class="pcoded-mtext">Items</span></a>
                            </li>
                        -->
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('viewindex') }}" class="nav-link "><span
                                        class="pcoded-mtext">Category</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('viewpro')}}" class="nav-link "><span
                                        class="pcoded-mtext">Electronic Item</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{route('view.nonpro')}}" class="nav-link "><span
                                        class="pcoded-mtext">General Item</span></a>
                            </li>
                            <!--
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('viewsupp') }}" class="nav-link "><span class="pcoded-mtext">Supplier</span></a>
                            </li>
                        -->
                        </ul>
                    </li>
                @endif
                @if ($usr->can('admin.view'))
                    <!--
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class=" feather icon-align-center"></i></span><b><span class="pcoded-mtext">Personnel Info</span></b></a>
                                <ul class="pcoded-submenu"
                                {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                                @if ($usr->can('role.view'))
<li class="{{ Route::is('roles.index') ? 'active' : '' }}"><a
                                            href="{{ route('viewrank') }}">View Rank </a></li>
@endif
                            </ul>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('perview') }}"><b>View Personnels</b></a></li>
                    </ul>
                </li>
            -->
                @endif
                @if (
                    $usr->can('superadmin.create') ||
                        $usr->can('superadmin.view') ||
                        $usr->can('superadmin.edit') ||
                        $usr->can('superadmin.delete'))
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-settings"></i></span><b><span class="pcoded-mtext">
                                    Setting</span></b></a>
                        <ul class="pcoded-submenu"
                            {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><span class="pcoded-mtext">Roles and
                                        Permission</span></a>
                                <ul class="pcoded-submenu"
                                    {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                                    @if ($usr->can('superadmin.view'))
                                        <li
                                            class="{{ Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.create') || Route::is('roles.show') ? 'active' : '' }}">
                                            <a href="{{ route('roles.index') }}">All Roles</a>
                                        </li>
                                    @endif
                                    @if ($usr->can('superadmin.view'))
                                        <li class="{{ Route::is('roles.create') ? 'active' : '' }}"><a
                                                href="{{ route('roles.create') }}">Add Role</a></li>
                                    @endif
                                </ul>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><b><span class="pcoded-mtext">Manage
                                            Profile</span></b></a>
                                <ul class="pcoded-submenu"
                                    {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                                    <li><a href="{{ route('profileview') }}">Profile</a></li>
                                    @if ($usr->can('superadmin.view'))
                                        <li><a href="{{ route('password.view') }}">Password Setting</a></li>
                                    @endif
                                </ul>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><b><span class="pcoded-mtext">Manage
                                            Users</span></b></a>
                                <ul class="pcoded-submenu"
                                    {{ Route::is('roles.create') || Route::is('roles.index') || Route::is('roles.edit') || Route::is('roles.show') ? 'in' : '' }}>
                                    @if ($usr->can('superadmin.view'))
                                        <li
                                            class="{{ Route::is('users.index') || Route::is('users.edit') || Route::is('users.create') || Route::is('users.show') ? 'active' : '' }}">
                                            <a href="{{ route('users.index') }}">User List</a>
                                        </li>
                                    @endif
                                    @if ($usr->can('superadmin.create'))
                                        <li class="{{ Route::is('users.create') ? 'active' : '' }}"><a
                                                href="{{ route('users.create') }}">Add User</a></li>
                                    @endif
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('audit.trail') }}" class="nav-link"><span
                                        class="pcoded-micon"></span><b><span class="pcoded-mtext">Audit
                                            Trail</span></b></a>
                            </li>
                            <li class="nav-item pcoded">
                                <a href="{{ route('login_and_logout') }}" class="nav-link"><span
                                        class="pcoded-micon"></span><b><span class="pcoded-mtext">User Logs
                                            Activies</span></b></a>
                            </li>
                        </ul>

                        @if ($usr->can('admin.view'))
                            <!--
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-pie-chart"></i></span><b><span
                                    class="pcoded-mtext">Reports</span></b></a>
                        <ul class="pcoded-submenu">
                            <li><a href="#"><b>Reports</b></a></li>
                        </ul>
                    </li>
                -->
                        @endif

                    </li>
                @endif
                <li class="nav-item pcoded">
                        <a href="{{ route('logout') }}" class="nav-link"><span class="pcoded-micon"><i
                                    class="fas fa-sign-out-alt"></i></span><b><span
                                    class="pcoded-mtext">Logout</span></b></a>
                    </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
