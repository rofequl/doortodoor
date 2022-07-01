<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('pageTitle') - {{basic_information()->website_title}}</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="{{asset('dashboards/main.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/font-awesome-4.6.1/css/font-awesome.min.css')}}"/>
    @stack('style')
</head>
<body style="font-family: 'Lato', serif;">
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

    @include('dashboard.layout.inc.header')
    <div class="app-main">
        @include('dashboard.layout.inc.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                @if(is_user_filled(Auth::guard('user')->user()->id)==0)
                    @include('dashboard.layout.inc.merchant-fields')
                @else
                    @yield('content')
                @endif
            </div>
            @include('dashboard.layout.inc.footer')
        </div>
    </div>

</div>
<script src="{{asset('vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('dashboards/main.js')}}"></script>
<style type="text/css"> #datatable-buttons_filter{width:44%} </style>
@stack('script')
</body>
</html>
