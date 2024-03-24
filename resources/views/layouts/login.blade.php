<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $title }}</title>
        <link rel="shorcut icon" href="{{ url('assets/img/sdit.png') }}" />
        <link
            rel="stylesheet"
            href="{{
                url(
                    'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'
                )
            }}"
        />
        <link
            rel="stylesheet"
            href="{{
                url('adminlte/plugins/fontawesome-free/css/all.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            href="{{
                url(
                    'adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'
                )
            }}"
        />

        <link
            rel="stylesheet"
            href="{{ url('adminlte/dist/css/adminlte.min.css') }}"
        />
    </head>
    <body class="hold-transition login-page" style="background-image: url({{ url('assets/img/alquran.jpg') }}); background-size:cover">

        <div class="login-box">@yield('auth')</div>

        <script src="{{
                url('adminlte/plugins/jquery/jquery.min.js')
            }}"></script>

        <script src="{{
                url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')
            }}"></script>
            
        <script src="{{ url('adminlte/dist/js/adminlte.min.js') }}"></script>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </body>
</html>
