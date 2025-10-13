<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar menu-light">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i> </span>
                        <span class="pcoded-mtext">Home</span></a>
                </li>


                <li class="nav-item pcoded-hasmenu">
                    <a href="#" class="nav-link">
                        <span class="pcoded-micon">
                            <img src="{{ asset('images/office.png') }}" alt="Offices" style="width:20px; height:20px;">
                        </span>
                        <span class="pcoded-mtext">G-Controls</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.g4.dash') }}" class="nav-link"><span class="pcoded-mtext">G-Control
                                    Dashboard</span></a></li>
                        <li><a href="{{ route('controls.general-items.issue') }}" class="nav-link"><span
                                    class="pcoded-mtext">Issue General Items</span></a></li>
                        <li><a href="{{ route('controls.general-items.returns') }}" class="nav-link"><span
                                    class="pcoded-mtext">Return Items</span></a></li>
                        <li><a href="{{ route('controls.general-items.issued') }}" class="nav-link"><span
                                    class="pcoded-mtext">Issued Items</span></a></li>
                        <li><a href="{{ route('controls.general-items.returned') }}" class="nav-link"><span
                                    class="pcoded-mtext">Returned Items</span></a></li>
                        <li><a href="{{ route('view-unit') }}" class="nav-link"><span class="pcoded-mtext">Unit
                                    Directory</span></a></li>
                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="feather icon-crosshair"></i></span><span class="pcoded-mtext">Weapons</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('controls.general-items.records') }}" class="nav-link"><span
                                    class="pcoded-mtext">Weapon State</span></a></li>
                        <li><a href="{{ route('weapons.dashboard') }}" class="nav-link"><span
                                    class="pcoded-mtext">Weapon Dashboard</span></a></li>
                        <li><a href="{{ route('weapons.categories.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Categories</span></a></li>
                        <li><a href="{{ route('weapons.platforms.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Sub-Category Items</span></a></li>
                        <li><a href="{{ route('weapons.inventory.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Weapon Inventory</span></a></li>
                        <li><a href="{{ route('weapons.issues.create') }}" class="nav-link"><span
                                    class="pcoded-mtext">Issue Weapons</span></a></li>
                        <li><a href="{{ route('weapons.issues.summary') }}" class="nav-link"><span
                                    class="pcoded-mtext">Issued Weapons</span></a></li>
                        <li><a href="{{ route('weapons.issues.track') }}" class="nav-link"><span
                                    class="pcoded-mtext">Track Weapon</span></a></li>
                        <li><a href="{{ route('weapons.returns.form') }}" class="nav-link"><span
                                    class="pcoded-mtext">Process Returns</span></a></li>
                        <li><a href="{{ route('weapons.armories.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Armories</span></a></li>
                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="fas fa-truck"></i></span><span class="pcoded-mtext">Vehicles</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('vehicles.dashboard') }}" class="nav-link"><span
                                    class="pcoded-mtext">Vehicle Dashboard</span></a></li>
                        <li><a href="{{ route('vehicles.motor-pools.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Vehicle Supply Pools</span></a></li>
                        <li><a href="{{ route('vehicles.categories.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Vehicle Base Category</span></a></li>
                        <li><a href="{{ route('vehicles.platforms.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Vehicle Category</span></a></li>
                        <li><a href="{{ route('vehicles.inventory.index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Vehicle Items</span></a></li>
                        <li><a href="{{ route('vehicles.deployments.summary') }}" class="nav-link"><span
                                    class="pcoded-mtext">Deployed Vehicles</span></a></li>
                        <li><a href="{{ route('vehicles.deployments.track') }}" class="nav-link"><span
                                    class="pcoded-mtext">Track Asset</span></a></li>
                        <li><a href="{{ route('vehicles.deployments.create') }}" class="nav-link"><span
                                    class="pcoded-mtext">Deploy Vehicles</span></a></li>
                        <li><a href="{{ route('vehicles.returns.form') }}" class="nav-link"><span
                                    class="pcoded-mtext">Return Vehicles</span></a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('personal-view') }}" class="nav-link"><span class="pcoded-micon"><i
                                class="feather icon-monitor"></i></span>
                        <span class="pcoded-mtext">Personnel</span></a>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="feather icon-grid"></i></span><span class="pcoded-mtext">Stock Items</span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item pcoded-hasmenu">
                            <a href="{{ route('view-index') }}" class="nav-link"><span
                                    class="pcoded-mtext">Category</span></a>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="{{ route('view-subcategory') }}" class="nav-link"><span
                                    class="pcoded-mtext">Sub Category</span></a>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="{{ route('view-item') }}" class="nav-link"><span class="pcoded-mtext">Stock
                                    Item</span></a>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="{{ route('viewpurchase') }}" class="nav-link"><span
                                    class="pcoded-mtext">Restock Item</span></a>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="{{ route('viewsupp') }}" class="nav-link"><span
                                    class="pcoded-mtext">Supplier</span></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                class="feather icon-settings"></i></span><span class="pcoded-mtext">Setting</span></a>
                    <ul class="pcoded-submenu">
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-mtext">Unit</span></a>
                            <ul class="pcoded-submenu">
                                <li><a href="{{ route('view-unit') }}">Unit Datatable</a></li>
                                <li><a href="{{ route('add-unit') }}">Add Unit</a></li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-mtext">Roles and
                                    Permission</span></a>
                            <ul class="pcoded-submenu">
                                <li><a href="{{ route('index-roles') }}">All Roles</a></li>
                                <li><a href="{{ route('create-roles') }}">Add Role</a></li>
                            </ul>
                        </li>
                        <li class="nav-item pcoded-hasmenu">
                            <a href="#!" class="nav-link"><span class="pcoded-mtext">Manage Users</span></a>
                            <ul class="pcoded-submenu">
                                <li><a href="{{ route('index-user') }}">User List</a></li>
                                <li><a href="{{ route('create-user') }}">Add User</a></li>
                                <li><a href="{{ route('audit.trail') }}">Audit Trail</a></li>
                                <li class="nav-item pcoded"><a href="{{ route('login_and_logout_activities') }}">User
                                        Logs Activies</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item pcoded">
                    <a href="{{ route('logout') }}" class="nav-link"><span class="pcoded-micon"><i
                                class="fas fa-sign-out-alt"></i></span><span class="pcoded-mtext">Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
