<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>TAC-GH Budget Tracker</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />
    <link
        rel="icon"
        href="{{ asset('assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
{{--    <script>--}}
{{--        WebFont.load({--}}
{{--            google: { families: ["Public Sans:300,400,500,600,700"] },--}}
{{--            custom: {--}}
{{--                families: [--}}
{{--                    "Font Awesome 5 Solid",--}}
{{--                    "Font Awesome 5 Regular",--}}
{{--                    "Font Awesome 5 Brands",--}}
{{--                    "simple-line-icons",--}}
{{--                ],--}}
{{--                urls: ["{{ asset('assets/css/fonts.min.css') }}"],--}}
{{--            },--}}
{{--            active: function () {--}}
{{--                sessionStorage.fonts = true;--}}
{{--            },--}}
{{--        });--}}
{{--    </script>--}}

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
{{--    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />--}}
</head>
<body>
<div class="wrapper">
    @include('layouts.navigation')

    <div class="main-panel">
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')
    </div>

</div>
<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Chart JS -->
{{--<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>--}}


<!-- Chart Circle -->
{{--<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>--}}

<!-- Bootstrap Notify -->
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->
{{--<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>--}}

@yield('script')

@if (Session::has('success'))
    <script>
        swal({
            title: "Good job!",
            text: "{!! Session::get('success') !!}",
            icon: "success",
            buttons: {
                confirm: {
                    className: "btn btn-success",
                },
            },
        });
    </script>
@endif

@if (Session::has('error'))
    <script>
        swal({
            title: "Awwwww!",
            text: "{!! Session::get('error') !!}",
            icon: "error",
            buttons: {
                confirm: {
                    className: "btn btn-danger",
                },
            },
        });
    </script>
@endif

<script>
    $(".get-alert").fadeTo(6000, 500).slideUp(500, function(){
        $(".get-alert").slideUp(500);
    });
</script>

</body>
</html>
