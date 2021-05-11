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

    <!-- Scripts -->
    <script src="{{ asset('js/adminLTE/jquery.min.js') }}"></script>
    <script src="{{ asset('js/adminLTE/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">

<!-- Site wrapper -->
<div class="wrapper">

    @yield('content')


</div>
<!-- ./wrapper -->
{{-- JS --}}
@yield('scripts')

{{-- CSS --}}
@yield('style')

</body>
</html>

