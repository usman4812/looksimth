@php
    $segments = request()->segments();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2 5C2 3.34315 3.34315 2 5 2L11 2C12.6569 2 14 3.34315 14 5V11C14 12.6569 12.6569 14 11 14H5C3.34315 14 2 12.6569 2 11L2 5ZM18 5C18 3.34315 19.3431 2 21 2L27 2C28.6569 2 30 3.34315 30 5V11C30 12.6569 28.6569 14 27 14H21C19.3431 14 18 12.6569 18 11V5ZM2 21C2 19.3431 3.34315 18 5 18H11C12.6569 18 14 19.3431 14 21V27C14 28.6569 12.6569 30 11 30H5C3.34315 30 2 28.6569 2 27L2 21ZM18 21C18 19.3431 19.3431 18 21 18H27C28.6569 18 30 19.3431 30 21V27C30 28.6569 28.6569 30 27 30H21C19.3431 30 18 28.6569 18 27V21Z"
                fill="#3053FF" />
        </svg>
        <span class="brand-text font-weight-light">Product Line Cards</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile') }}" class="d-block">Profile</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {!! (@$segments[0] == '') ? 'active' : '' !!}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-header">PAGES</li>

                <li class="nav-item">
                    <a href="{{ route('tenants.list') }}" class="nav-link {!! (@$segments[0] == 'tenants') ? 'active' : '' !!}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Tenants</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('builds.list') }}" class="nav-link {!! (@$segments[0] == 'builds') ? 'active' : '' !!}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Builds</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('plans.list') }}" class="nav-link {!! (@$segments[0] == 'plans') ? 'active' : '' !!}">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>Plans</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transactions.list') }}" class="nav-link {!! (@$segments[0] == 'transactions') ? 'active' : '' !!}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Transactions</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logs.list') }}" class="nav-link {!! (@$segments[0] == 'logs') ? 'active' : '' !!}">
                        <i class="nav-icon fa fa-history"></i>
                        <p>Logs</p>
                    </a>
                </li>
                <hr style="background: #FFF;color: #fff;border: 1px solid #FFF;width: 100%;">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 52 52" xml:space="preserve" fill="#fff"><path d="M21 48.5v-3c0-.8-.7-1.5-1.5-1.5h-10c-.8 0-1.5-.7-1.5-1.5v-33C8 8.7 8.7 8 9.5 8h10c.8 0 1.5-.7 1.5-1.5v-3c0-.8-.7-1.5-1.5-1.5H6C3.8 2 2 3.8 2 6v40c0 2.2 1.8 4 4 4h13.5c.8 0 1.5-.7 1.5-1.5"></path><path d="M49.6 27c.6-.6.6-1.5 0-2.1L36.1 11.4c-.6-.6-1.5-.6-2.1 0l-2.1 2.1c-.6.6-.6 1.5 0 2.1l5.6 5.6c.6.6.2 1.7-.7 1.7H15.5c-.8 0-1.5.6-1.5 1.4v3c0 .8.7 1.6 1.5 1.6h21.2c.9 0 1.3 1.1.7 1.7l-5.6 5.6c-.6.6-.6 1.5 0 2.1l2.1 2.1c.6.6 1.5.6 2.1 0z"></path></svg>&nbsp;
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
