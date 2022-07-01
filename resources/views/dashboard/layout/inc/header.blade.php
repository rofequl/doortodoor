<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src" 
        style="background: url(/images/{{basic_information()->company_logo}});
            background-size: cover;background-position: center;">
        </div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button"
                    class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        Home
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="{{route('about')}}" class="nav-link">
                        About us
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="{{route('blog')}}" class="nav-link">
                        Blog
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="{{route('contact')}}" class="nav-link">
                        Contact
                    </a>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a class="p-0 btn">
                                    <img width="48" height="48" class="rounded-circle" src="{{Auth::guard('user')->user()->image==null? asset('images/user.png'):asset('storage/user/'.Auth::guard('user')->user()->image)}}"
                                         alt="">
                                    {{Auth::guard('user')->user()->first_name}}
                                    {{Auth::guard('user')->user()->last_name}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
