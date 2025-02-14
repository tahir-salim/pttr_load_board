<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.jpg') }}" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PTTR LoadBoard') }}</title>
        {{-- <title>PTTR LoadBoard | Home</title>   --}}
        <meta name="description" content="">



        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    </head>
    @include('Admin.layouts.css')

<body class="scrollenis" id="top">
    <div id="app">
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

        <main>
            <div class="container-fluid">
                <div class="row">

                    @auth
                        <div class="col-md-2">
                        <!-- Begin: Nav -->
                            @include('Admin.layouts.header');
                            <!-- END: Nav -->
                        </div>
                    @endauth
                        @yield('content')

                </div>
            </div>
        </main>
        @include('Admin.layouts.footer')
        @include('Admin.layouts.js')

        <script>

            @if(Session::has('success'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
            toastr.success("{{ session('success') }}");
            @endif

            @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
            @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.info("{{ session('info') }}");
            @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.warning("{{ session('warning') }}");
            @endif
          </script>
    </div>
</body>
</html>
