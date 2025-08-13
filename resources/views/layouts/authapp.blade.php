<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- logocoloer.ico --}}
    <link rel="icon" type="image/png" sizes="56x56" href="{{ asset('logo.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>safepod-@yield('title')</title>

    
    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style.min.css') }}">

    <!-- Waves Effect -->
    <link rel="stylesheet" href="{{ asset('dash/assets/plugin/waves/waves.min.css') }}">

    <!-- RTL -->
    <link rel="stylesheet" href="{{ asset('dash/assets/styles/style-rtl.min.css') }}">
	<link rel="stylesheet" href="{{asset('dash/assets/fonts/cairo.css')}}">

</head>

<body style="font-family:Cairo ">

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: -1;"></div>

    <div id="single-wrapper" style="padding: 20px; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="row" style="width: 100%; max-width: 1200px; margin: auto;">
            <div class="col-md-6" style="background: rgba(255, 255, 255, 0.9); border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                @yield('content')
            </div>
            <div class="col-md-6" style="text-align: center; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('logoo.png') }}" alt="Logo" style="max-width: 100%; height: auto; margin-top: 20px;">
            </div>
        </div>
    </div>

    <script src="{{ asset('dash/assets/scripts/jquery.min.js') }}"></script>
    <script src="{{ asset('dash/assets/scripts/modernizr.min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('dash/assets/plugin/waves/waves.min.js') }}"></script>

    <script src="{{ asset('dash/assets/scripts/main.min.js') }}"></script>
</body>

</html>