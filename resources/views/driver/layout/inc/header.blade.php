<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    <img src="{{asset('images/user.png')}}" alt="">Driver
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href=""> Profile</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('driver.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i
                                class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a class="info-number">
                    <div class="form-group pull-right top_search" style="width: 230px">
                        <div class="input-group">
                            <input type="text" class="form-control search" placeholder="Tracking No...">
                            <span class="input-group-btn search-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                        </div>
                    </div>
                </a>
            </li>
        </ul>

    </div>
</div>
<form id="frm-logout" action="{{ route('driver.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
