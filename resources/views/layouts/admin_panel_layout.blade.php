<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/adminLTE/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/main_admin.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css">

    <!-- Scripts -->
    <script src="https://unpkg.com/vue-recaptcha@latest/dist/vue-recaptcha.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
    <script src="{{ asset('js/adminLTE/jquery.min.js') }}"></script>
    <script src="{{ asset('js/adminLTE/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminLTE/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">

<!-- Site wrapper -->
<div id="app" class="wrapper">

    {{-- верхнее меню --}}
    <nav id="navbar" class="main-header navbar navbar-expand navbar-white navbar-light">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li id="left_salaska_button"
                @click="widthContent()"
                class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>

    {{-- боковое меню --}}
    <aside id="sidebar" class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/admin" class="brand-link elevation-4"> ADMIN </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="/admin/company" class="nav-link">
                            <i class="far fa-newspaper"></i> <p>Компании</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="/admin/client" class="nav-link">
                            <i class="fas fa-user-friends"></i><p>Клиенты</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    @yield('content')

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.0-rc.5
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->
{{-- JS --}}
@yield('scripts')

{{-- CSS --}}
<style>
    #app {
        min-height: 100vh;
        position: relative;
        padding-bottom: 57px;
    }
    #sidebar{
        z-index: 3001;
    }
    .brand-link.elevation-4{
        background-color: #fff!important;
    }
    .nav-link i{
        margin-right: 10px;
    }
    .main-footer {
        position: absolute;
        width: 100%;
        bottom: 0px;
        z-index: 1;
        background: #fff;
        border-top: 1px solid #dee2e6;
        color: #869099;
        padding: 1rem;
        transition: margin-left .3s ease-in-out;
        margin-left: 250px;
    }
</style>
@yield('style')

</body>
</html>

