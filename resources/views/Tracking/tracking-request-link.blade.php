<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'PTTR LoadBoard') }}</title>
      {{-- 
      <title>PTTR LoadBoard | Home</title>
      --}}
      <meta name="description" content="">
      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
      <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.jpg') }}" />
      <!-- Scripts -->
      {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
      @include('layouts.css')
   </head>
   <body class="scrollenis" id="top">
      <!--<div id="preloaders" class="preloader"></div>-->
      <div id="app">
      <div class="mouse-cursor cursor-outer"></div>
      <div class="mouse-cursor cursor-inner"></div>
      <main>
         <div class="container-fluid">
            <div class="backgroundImg"></div>
            <div class="container">
               <div class="loginForms">
                  <div class="lgForm">
                     <figure class="logoBrand">
                        <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                     </figure>
                     <div>
                         </br>
                        <h2 style="text-align:center">Welcome to PTTR</h2>
                        <p>If you are using an Apple device, please make sure to set Safari as your default browser. In case you are not able to do so, simply copy the tracking link to your safari browser.</p>
                        <br/>
                        <!--<p>Note: link works only if Opened with App</p>-->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
   </body>
</html>