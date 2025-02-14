<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PTTR LoadBoard') }}</title>
        {{-- <title>PTTR LoadBoard | Home</title>   --}}
        <meta name="description" content="">



        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.jpg') }}" />

        <!-- Scripts -->
        {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
        
        @include('layouts.css')
        <style>
            /*.preloader */
            /*{*/
            /*    position: fixed;*/
            /*    left: 0px;*/
            /*    top: 0px;*/
            /*    width: 100%;*/
            /*    height: 100%;*/
            /*    z-index: 99999999999999999;*/
            /*    background: url({{asset('assets/images/209.gif')}}) 50% 50% no-repeat rgb(249,249,249);*/
            /*    opacity: .9;*/
            /*}*/
        </style>
    </head>
    

<body class="scrollenis" id="top">
        <!--<div id="preloaders" class="preloader"></div>-->
    <div id="app">
        <div class="mouse-cursor cursor-outer"></div>
        <div class="mouse-cursor cursor-inner"></div>

        <main>
            <div class="container-fluid">
                <div class="row">

                    @auth
                        @if(auth()->user()->email_verified_at)
                            <div class="col-md-2">
                            <!-- Begin: Nav -->
                                @include('layouts.header')
                                <!-- END: Nav -->
                            </div>
                        @endif
                    @endauth

                        @yield('content')

                </div>
            </div>
        </main>
        @include('layouts.footer')
        @include('layouts.js')
        <script>
          (function(d){
             var s = d.createElement("script");
             /* uncomment the following line to override default position*/
             s.setAttribute("data-position", 1);
             /* uncomment the following line to override default size (values: small, large)*/
             s.setAttribute("data-size", "large");
             /* uncomment the following line to override default language (e.g., fr, de, es, he, nl, etc.)*/
             /* s.setAttribute("data-language", "null");*/
             /* uncomment the following line to override color set via widget (e.g., #053f67)*/
             s.setAttribute("data-color", "#009edd");
             /* uncomment the following line to override type set via widget (1=person, 2=chair, 3=eye, 4=text)*/
             /* s.setAttribute("data-type", "1");*/
             /* s.setAttribute("data-statement_text:", "Our Accessibility Statement");*/
             /* s.setAttribute("data-statement_url", "http://www.example.com/accessibility";*/
             /* uncomment the following line to override support on mobile devices*/
             /* s.setAttribute("data-mobile", true);*/
             /* uncomment the following line to set custom trigger action for accessibility menu*/
             /* s.setAttribute("data-trigger", "triggerId")*/
             s.setAttribute("data-account", "rRRO89g0Kp");
             s.setAttribute("src", "https://cdn.userway.org/widget.js");
             (d.body || d.head).appendChild(s);})(document)
        </script>
     
         <style>
            
            body .uwy.userway_p1 .userway_buttons_wrapper{ 
            top: initial !important;
            right: initial  !important;
            bottom: 20px !important;
            left: 20px !important;
            transform: initial !important; }
         </style>
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
