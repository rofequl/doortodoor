<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-3.3.6/css/bootstrap.min.css">
    <!-- Bootstrap Select Css -->
    <link rel="stylesheet" type="text/css"
          href="assets/plugins/bootstrap-select-1.10.0/dist/css/bootstrap-select.min.css">
    <!-- Fonts Css -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/font-awesome-4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/font-elegant/elegant.css">
    <!-- OwlCarousel2 Slider Css -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/owl.carousel.2/assets/owl.carousel.css">
    <!-- Animate Css -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <!-- Main Css -->
    <link rel="stylesheet" type="text/css" href="assets/css/theme.css">
    <!--[if lt IE 9]>
    <script src="assets/plugins/iesupport/html5shiv.js"></script>
    <script src="assets/plugins/iesupport/respond.js"></script>
    <![endif]-->
</head>
<body>
<div id="home">
    <!-- Preloader -->
@stack('loader')
<!-- /.Preloader -->


    <!-- Main Wrapper -->
    <main class="wrapper">

        <!-- Header -->
    @include('layouts.inc.header')
    <!-- /.Header -->

        <!-- Content Wrapper -->
    @yield('content')
    <!-- /.Content Wrapper -->

        <!-- Footer -->
    @include('layouts.inc.footer')
    <!-- /.Footer -->


    </main>
    <!-- / Main Wrapper -->

    <!-- Top -->
    <div class="to-top theme-clr-bg transition"><i class="fa fa-angle-up"></i></div>

</div>
<!-- Main Jquery JS -->
<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<!-- Bootstrap JS -->
<script src="assets/plugins/bootstrap-3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Bootstrap Select JS -->
<script src="assets/plugins/bootstrap-select-1.10.0/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<!-- OwlCarousel2 Slider JS -->
<script src="assets/plugins/owl.carousel.2/owl.carousel.min.js" type="text/javascript"></script>
<!-- Sticky Header -->
<script src="assets/js/jquery.sticky.js"></script>
<!-- Wow JS -->
<script src="assets/plugins/WOW-master/dist/wow.min.js" type="text/javascript"></script>
<!-- Theme JS -->
<script src="assets/js/theme.js" type="text/javascript"></script>
</body>
</html>
