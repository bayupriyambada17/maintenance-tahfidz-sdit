<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="shorcut icon" href="{{ url('assets/img/sdit.png') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .btn {
            border-radius: 10px
        }

        .card {
            border-radius: 20px
        }
    </style>
    @stack('style')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('partials.topbar')

        @include('partials.sidebar')
        <div class="content-wrapper"
            style="background-image: url({{ url('assets/img/alquran.jpg') }}); background-size:cover">
            <div class="content-header">
                <div class="container-fluid">
                    <center>
                        <div class="m-4">
                            <h1 class="m-0" style="color: rgb(253, 220, 207)">{{ $title }}</h1>
                        </div>
                    </center>
                </div>
            </div>

            <section class="content">
                @yield('isi')
            </section>
            <br><br>

        </div>

        @include('partials.footer')

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    @include('partials.script')
    @stack('script')
    @include('sweetalert::alert')

</body>

</html>
