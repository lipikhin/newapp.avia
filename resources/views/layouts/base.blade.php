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
    <link rel="stylesheet" href={{asset('plugins/fontawesome-free/css/all.min')}}"
    .css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href={{asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}>
    <!-- iCheck -->
    <link rel="stylesheet" href={{asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
    <!-- JQVMap -->
    <link rel="stylesheet" href={{asset("plugins/jqvmap/jqvmap.min.css")}}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{asset("dist/css/adminlte.min.css")}}>
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href={{asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}>
    <!-- Daterange picker -->
    <link rel="stylesheet"
          href={{asset("plugins/daterangepicker/daterangepicker.css")}}>
    <!-- summernote -->
    <link rel="stylesheet" href={{asset("plugins/summernote/summernote-bs4.min.css")}}>

{{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">--}}
    <style>
        .colored-svg {
            width: 180px; /* Установите желаемую ширину */
            height: auto; /* Высота будет автоматически скорректирована пропорционально */
            /*filter: invert(31%) sepia(84%) saturate(5873%) hue-rotate(355deg) brightness(101%) contrast(106%);*/
            filter: brightness(0) saturate(100%) invert(24%) sepia(95%) saturate(2178%) hue-rotate(210deg) brightness(108%) contrast(98%);
            /* Настройте фильтры для получения желаемого цвета */
        }
        .user-panel {
            overflow: visible !important; /* Разрешает выпадающему меню выходить за границы блока */
            position: relative; /* Относительное позиционирование для корректной работы с dropdown */
        }

        .dropdown-menu {
            position: absolute;
            top: 100%; /* Раскрытие сразу под пользователем */
            left: 0;
            right: 0;
            z-index: 1000; /* Убедитесь, что меню будет выше других элементов */
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

    <aside class="main-sidebar  elevation-4  bg-secondary-subtle ">

            <!-- Brand Logo -->
        <div class="">

            <div class="">
                <a href="{{url('/')}}" class="brand-link">
                    <img id="logo-small" src="{{asset('image/AT.png')}}"
                         class="ms-2" alt="AT" style="width: 36px; height:
                         36px; display: none;">
                    <img id="logo-full" src="{{asset('image/AT_logo-rb.svg')}}" alt="AT" class="ms-1 colored-svg">
                </a>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="" >
            <ul class="justify-content d-flex">
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

                @endguest

            </ul>

            <!--Sidebar navigation -->
            <ul class="">

            </ul>

        </div>

            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
                <div class="user-panel  pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/avatars/{{ Auth::user()->avatar }}"
                             class="img-circle me-4 elevation-2" alt="User Image">
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-block dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
            </div>


            <!-- Sidebar Menu -->
        @include('includes.sidebar')
            <!-- /.sidebar-menu -->
        </div>
    </aside>

        <div class="content-wrapper">


            <!-- Main content -->
            <section class="content">

                <div class="container-fluid " >

                    @include('includes.work_header')
                    @yield('content')

                </div>

            </section>

        </div>


    @include('includes.footer')


    </div>
<!-- ./wrapper -->

<!-- jQuery -->
{{--<script src={{asset("plugins/jquery/jquery.min.js")}}></script>--}}
<!-- jQuery UI 1.11.4 -->
{{--<script src={{asset("plugins/jquery-ui/jquery-ui.min.js")}}></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src={{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
<!-- ChartJS -->
<script src={{asset("plugins/chart.js/Chart.min.js")}}></script>
<!-- Sparkline -->
<script src={{asset("plugins/sparklines/sparkline.js")}}></script>
<!-- JQVMap -->
<script src={{asset("plugins/jqvmap/jquery.vmap.min.js")}}></script>
<script src={{asset("plugins/jqvmap/maps/jquery.vmap.usa.js")}}></script>
<!-- jQuery Knob Chart -->
<script src={{asset("plugins/jquery-knob/jquery.knob.min.js")}}></script>
<!-- daterangepicker -->
<script src={{asset("plugins/moment/moment.min.js")}}></script>
<script src={{asset("plugins/daterangepicker/daterangepicker.js")}}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
<!-- Summernote -->
<script src={{asset("plugins/summernote/summernote-bs4.min.js")}}></script>
<!-- overlayScrollbars -->
<script src={{asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("dist/js/adminlte.js")}}></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoSmall = document.getElementById('logo-small');
        const logoFull = document.getElementById('logo-full');
        const sidebarToggleBtn = document.querySelector('[data-widget="pushmenu"]');

        sidebarToggleBtn.addEventListener('click', function () {
            if (logoSmall.style.display === 'none') {
                logoSmall.style.display = 'block';
                logoFull.style.display = 'none';
            } else {
                logoSmall.style.display = 'none';
                logoFull.style.display = 'block';
            }
        });
    });
</script>

</body>
</html>
