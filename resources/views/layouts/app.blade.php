<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ \URL::to('/') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/remixicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/side-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css-pro-layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/style.css')}}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}" />
    @stack('extra_css')
  </head>

  <body>
    <div class="layout has-sidebar fixed-sidebar fixed-header">
      @include('includes.sidebar')
      <div id="overlay" class="overlay"></div>
      <div class="layout">
        @include('includes.header')
        <main class="content">
            @yield('content')
        </main>
        <div class="overlay"></div>
      </div>
    </div>

    <script src="{{ asset('js/jquery-3.6.3.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/side-menu.js') }}"></script>
    <script src="{{ asset('js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/validation.js') }}?v={{ time() }}"></script>


    <!-- <script src="//cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script> -->
    @yield('scripts')
  </body>
</html>

