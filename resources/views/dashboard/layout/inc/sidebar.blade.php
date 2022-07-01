<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li>
                    <a href="{{route('user.dashboard')}}" class="{{ (request()->is('dashboard')) ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-tachometer"></i>
                        Merchant Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{route('profile')}}" class="{{ (request()->is('profile')) ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-user"></i>
                        My Profile
                    </a>
                </li>
                <li>
                    <a href="{{route('account')}}">
                        <i class="metismenu-icon fa fa-cog"></i>
                        My Account
                    </a>
                </li>
                <li>
                    <a href="{{route('PrepareShipment')}}" class="{{ (request()->is('prepare-shipment')) ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-location-arrow" aria-hidden="true"></i>
                        Prepare Shipment
                    </a>
                </li>
                <li>
                    <a href="{{route('payments')}}" class="{{ (request()->is('payments')) ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-money" aria-hidden="true"></i>
                        Payments
                    </a>
                </li>
                <li>
                    <a href="{{route('csv-upload')}}" class="{{ (request()->is('csv-upload')) || (request()->is('csv-temporary')) ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-file-excel-o" aria-hidden="true"></i>
                        Upload CSV
                    </a>
                </li>
                <li>
                    <a href="{{route('logout')}}"
                       onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        <i class="metismenu-icon fa fa-sign-out" aria-hidden="true"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
