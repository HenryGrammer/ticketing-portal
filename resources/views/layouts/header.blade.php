<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>{{ env('APP_NAME', "Laravel") }}</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/themify-icons/css/themify-icons.css') }}" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="{{ asset('assets/vendors/DataTables/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="{{ url('') }}">
                    <span class="brand">Ticketing Portal
                    </span>
                    <span class="brand-mini">TP</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="{{ url('assets/img/admin-avatar.png') }}" />
                            <span></span>{{ auth()->user()->name }}<i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- <a class="dropdown-item" href="profile.html"><i class="fa fa-user"></i>Profile</a> --}}
                            {{-- <a class="dropdown-item" href="profile.html"><i class="fa fa-cog"></i>Settings</a> --}}
                            {{-- <a class="dropdown-item" href="javascript:;"><i class="fa fa-support"></i>Support</a> --}}
                            {{-- <li class="dropdown-divider"></li> --}}
                            <a class="dropdown-item" href="login.html"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="{{ url('assets/img/admin-avatar.png') }}" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">{{ auth()->user()->name }}</div><small>{{ auth()->user()->role }}</small>
                    </div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="@if(Request::is('home')) active @endif" href="{{ url('') }}"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">MAIN MENU</li>
                    <li>
                        <a href="{{ url('tickets') }}" class="@if(Request::is('tickets')) active @endif">
                            <i class="sidebar-item-icon fa fa-ticket"></i>
                            <span class="nav-label">Tickets</span>
                        </a>
                        <a href="" class="@if(Request::is('reports')) active @endif">
                            <i class="sidebar-item-icon fa fa-file"></i>
                            <span class="nav-label">Reports</span>
                        </a>
                    </li>
                    <li class="heading">SETTINGS</li>
                    <li>
                        <li>
                            <a href="{{ url('users') }}" class="@if(Request::is('users')) active @endif">
                                <i class="sidebar-item-icon fa fa-user"></i>
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('companies') }}" class="@if(Request::is('companies')) active @endif">
                                <i class="sidebar-item-icon fa fa-building"></i>
                                Companies
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('departments') }}" class="@if(Request::is('departments')) active @endif">
                                <i class="sidebar-item-icon fa fa-sitemap"></i>
                                Departments
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('roles') }}" class="@if(Request::is('roles')) active @endif">
                                <i class="sidebar-item-icon fa fa-users"></i>
                                Roles
                            </a>
                        </li>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                @yield('content')
            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">{{ date('Y') }} © <b>WGROUP DEVELOPERS</b> - All rights reserved.</div>
                {{-- <div class="to-top"><i class="fa fa-angle-double-up"></i></div> --}}
            </footer>
        </div>
    </div>

    <!-- BEGIN PAGA BACKDROPS-->
    {{-- <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div> --}}
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/popper.js/dist/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/metisMenu/dist/metisMenu.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script> --}}
    <!-- PAGE LEVEL PLUGINS-->
    {{-- <script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script> --}}
    {{-- <script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script> --}}
    {{-- <script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script> --}}
    {{-- <script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script> --}}
    <!-- CORE SCRIPTS-->
    <script src="{{ asset('assets/js/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/DataTables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    {{-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> --}}
    @yield('js')
</body>

</html>