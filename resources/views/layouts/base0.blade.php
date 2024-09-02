<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <style>
        .colored-svg {
            width: 180px; /* Установите желаемую ширину */
            height: auto; /* Высота будет автоматически скорректирована пропорционально */
            /*filter: invert(31%) sepia(84%) saturate(5873%) hue-rotate(355deg) brightness(101%) contrast(106%);*/
            filter: brightness(0) saturate(100%) invert(24%) sepia(95%) saturate(2178%) hue-rotate(210deg) brightness(108%) contrast(98%);
            /* Настройте фильтры для получения желаемого цвета */
        }
    </style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('image/AT.png')}}" alt="AT_Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->

    <aside class="main-sidebar bg-secondary-subtle ">

            <!-- Brand Logo -->
            <div class="">
                <a href="{{url('/')}}" class="brand-link">
{{--                <img src="{{asset('image/AT.png')}}" class="ms-1 " alt="AT"--}}
{{--                     style="width: 36px; height: 36px">--}}
{{--                <span> "   "</span>--}}

                    <img src="{{asset('image/AT_logo-rb.svg')}}" alt="AT" class="ms-1 colored-svg">
                    {{--                        <span class="brand-text font-weight-light"></span>--}}
                </a>
            </div>






        <!-- Sidebar -->
        <div class="ms-1" >
            <ul class="">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="sidebar-nav">
                            <a class="sidebar-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="sidebar-nav">
                            <a class="sidebar-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <div class="dropdown show m-1">
                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/avatars/{{Auth::user()->avatar }}" class="rounded-circle " alt=" "
                                 width="40">{{ Auth::user()->name }}

                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a  class="sidebar-link" href="{{route('user.profile')}}">
                                <i class="fa-solid fa-list pe-2"></i>
                                Profile
                            </a>
                            <a  class="sidebar-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();" aria-labelledby="dropdownMenuLink">
                                <i class="fa-solid fa-outdent pe-2"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest

            </ul>

            <!--Sidebar navigation -->
            <ul class="sidebar-nav ">
                {{--                <li class="sidebar-header">--}}
                {{--                    Tool--}}
                {{--                </li>--}}

                {{--                        <li class="sidebar-item">--}}
                {{--                            <a href="#" class="sidebar-link">--}}
                {{--                                <i class="fa-solid fa-list pe-2"></i>--}}
                {{--                                __--}}
                {{--                            </a>--}}
                {{--                        </li>--}}

                {{--                        <li class="sidebar-item">--}}
                {{--                            <a href="#" class="sidebar-link">--}}
                {{--                                <i class="fa-solid fa-gear pe-2"></i>--}}
                {{--                                ___--}}
                {{--                            </a>--}}
                {{--                        </li>--}}


                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages"
                       aria-expanded="false" aria-controls="pages">
                        <i class="fa-solid fa-gear pe-2"></i>
                        {{__('Additions')}}
                    </a>
                    <ul id="pages" class="sidebar-dropdown  collapse" data-bs-parent="#sidebar">

                        @auth
                            @if(Auth::user()->admin)

                                <li class="sidebar-item">
                                    <a href="{{route('admin.cmms.index')}}"
                                       class="sidebar-link">
                                        {{__('Manuals')}}</a>
                                </li>



                                <li class="sidebar-item">
                                    <a href="{{route('admin.customers.index')}}"
                                       class="sidebar-link">
                                        {{__
                                    ('Customers')}}</a>
                                </li>
                            @endif
                        @endauth

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link"> {{__
                                    ('Units')}}</a>
                        </li>

                    </ul>
                </li>


                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#library"
                       aria-expanded="false" aria-controls="library">
                        <i class="fa-solid fa-book pe-2"></i>
                        Library
                    </a>
                    <ul id="library" class="sidebar-dropdown
                             collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link"> Materials</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                {{__('Processes')}}</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link"> ... News</a>
                        </li>

                    </ul>
                </li>

            </ul>

        </div>
{{--        <div class="sidebar">--}}
{{--            <!-- Sidebar user panel (optional) -->--}}
{{--            <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
{{--                <div class="image">--}}
{{--                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
{{--                </div>--}}
{{--                <div class="info">--}}
{{--                    <a href="#" class="d-block">Alexander Pierce</a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- SidebarSearch Form -->--}}
{{--            <div class="form-inline">--}}
{{--                <div class="input-group" data-widget="sidebar-search">--}}
{{--                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button class="btn btn-sidebar">--}}
{{--                            <i class="fas fa-search fa-fw"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Sidebar Menu -->--}}
{{--@include('includes.sidebar')--}}
{{--            <!-- /.sidebar-menu -->--}}
{{--        </div>--}}
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
{{--        <div class="content-header">--}}

{{--        </div>--}}
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid " >
@include('includes.work_header')
                @yield('content')

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="#">Aviatechnik</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 0.0.1
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>


</body>
</html>
