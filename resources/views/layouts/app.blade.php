<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - YRS</title>
    <link rel="shortcut icon" href="{{asset('image/logo.png')}}" type="image/x-icon">
    <!-- Font Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Lato:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.css') }}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    
    {{-- Viewer --}}
    <link rel="stylesheet" href="{{asset('plugins/viewer/viewer.css')}}">

    {{-- leaflet --}}
    <link rel="stylesheet" href="{{asset('plugins/leaflet/leaflet.css')}}">

    {{-- leaflet loction picker--}}
    <link rel="stylesheet" href="{{asset('plugins/leaflet-locationpicker/leaflet-locationpicker.css')}}">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        @include('layouts.navigation')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <x-flash-message></x-flash-message>

                    @yield('header')

                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('layouts.footer')

    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- Data Table -->
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    {{-- Viewer --}}
    <script src="{{ asset('plugins/viewer/viewer.js') }}"></script>
    {{-- <script src="{{ asset('plugins/viewer/viewer.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/viewer/viewer.common.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/viewer/viewer.esm.js') }}"></script> --}}
    
    {{-- leaflet  --}}
    <script src="{{ asset('plugins/leaflet/leaflet.js') }}"></script>

    {{-- leaflet location picker  --}}
    <script src="{{ asset('plugins/leaflet-locationpicker/leaflet-locationpicker.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!-- Laravel JSValidation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-Token": document.head.querySelector('meta[name="csrf-token"]').content
                },
                error: function(res, status, error) {
                    toastr.error(res.responseJSON.message);
                },
            });

            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif

        });
    </script>

    @stack('scripts')

</body>


</html>
