<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="" />
        @yield('head')
        {{-- <title>@yield('title', 'Page Title')</title> --}}
        {!! SEO::generate() !!}
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="/static/css/style.css">
    </head>
    <body>
        <!-- Responsive navbar-->
        @include('layouts.header')

        <!-- Page content-->
            <div class="container mt-5">
                <div class="row">
                    {{-- responsive main --}}

                        @yield('content')


                    {{-- responsive sidebar --}}

                        @section('sidebar')
                            @include('layouts.sidebar')
                        @show

                </div>
            </div>

        {{-- footer --}}
        @include('layouts.footer')


        {{-- <script src="/static/js/script.js"></script> --}}
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        @yield('script')
        <!-- Core theme JS-->
        <script src="/static/js/scripts.js"></script>
        @include('sweetalert::alert')

    </body>
</html>
