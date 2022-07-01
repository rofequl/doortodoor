<header class="header-main header-style3">

    <!-- Header Topbar -->
    <div class="top-bar2">
        <div class="theme-container container">
            <div class="row">
                <div class="col-md-2 col-sm-12">
                    <a class="navbar-logo" href="#"> <img src="/images/{{basic_information()->company_logo}}" alt="logo"/> </a>
                </div>
                <div class="col-md-10 col-sm-12 fs-12 text-right">
                    <ul class="list-inline">
                        <li><h6 class="font2-light"> Come to office </h6>
                            <p class="theme-clr  font2-title1"> {{basic_information()->address}} </p></li>
                        <li><h6 class="font2-light"> Want to meet? </h6>
                            <p class="theme-clr  font2-title1"> {{basic_information()->meet_time}} </p></li>
                        <li><h6 class="font2-light"> Need a help? </h6>
                            <p class="theme-clr font2-title1"> {{basic_information()->phone_number_one}} </p></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- /.Header Topbar -->

    <!-- Header Logo & Navigation -->
    <nav class="menu-bar font2-title1 white-clr">
        <div class="theme-container container">
            <div class="row">
                <div class="col-xs-12 visible-xs">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="visible-xs">
                        <a data-toggle="modal" href="#login-popup" class="sign-in fs-12 black-bg"> sign in </a>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12 fs-12">
                    <a class="sticky-logo hidden-sm" href="/">
                     <img alt="" width="115" src="/images/{{basic_information()->company_logo}}"/> </a>
                    <div id="navbar" class="collapse navbar-collapse no-pad">
                        <ul class="navbar-nav theme-menu">
                            <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="{{route('home')}}">home</a>
                            </li>
                            <li class="{{ (request()->is('about')) ? 'active' : '' }}"><a href="{{route('about')}}">about</a>
                            </li>
                            <li class="{{ (request()->is('tracking')) ? 'active' : '' }}"><a
                                    href="{{route('tracking')}}"> tracking </a></li>
                            <li class="{{ (request()->is('pricing')) ? 'active' : '' }}"><a href="{{route('pricing')}}">
                                    pricing </a></li>
                            <li class="{{ (request()->is('contact')) ? 'active' : '' }}"><a href="{{route('contact')}}">
                                    contact </a></li>
                            <li class="{{ (request()->is('blog')) ? 'active' : '' }}"><a href="{{route('blog')}}">
                                    blog </a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                @if(!Auth::guard('user')->check())
                    <div class="col-md-2 col-sm-2 text-right hidden-xs">
                        <a href="{{route('login')}}" class="sign-in fs-12 black-bg"> sign in </a>
                    </div>
                    <div class="col-md-2 col-sm-2 text-right hidden-xs">
                        <a href="{{route('register')}}" class="sign-in fs-12 black-bg"> register </a>
                    </div>
                @else
                    <div class="col-md-3 col-sm-3 text-right hidden-xs">
                        <a href="{{route('user.dashboard')}}" class="sign-in fs-12 black-bg"> Merchant Dashboard </a>
                    </div>
                @endif

            </div>
        </div>
    </nav>
    <!-- /.Header Logo & Navigation -->

</header>
