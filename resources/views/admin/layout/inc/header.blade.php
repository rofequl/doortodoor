<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <div class="nav toggle" style="border-bottom:1px solid silver;text-align:center; margin-top:3px;width:auto;">
            @if(Auth::guard('admin')->user()->role_id !=1)
            <?php $hubs = \App\Admin_hub::where('admin_id',Auth::guard('admin')->user()->id)->get();?>
                <select style="padding:3px" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    @foreach($hubs as $row)
                    <option @if(\Session::get('admin_hub')->id==$row->hub_id) selected @endif value="/admin/admin-change-hub/{{$row->hub_id}}">{{$row->hub->name}}</option> @endforeach
                </select>

            @else <b class="text-success"><span class="fa fa-check"></span> Super-admin</b> @endif
        </div>

        <ul class="nav navbar-nav navbar-right" style="width:61%">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    <img src="{{asset('images/user.png')}}" alt="">{{Auth::guard('admin')->user()->first_name}}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href=""> Profile</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i
                                class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="/" target="_blank" class="info-number">
                    <div class="form-group">
                        <div class="input-group">
                            <i class="fa fa-desktop"></i> Website
                        </div>
                    </div>
                </a>
            </li>

            <li role="presentation" class="dropdown hidden-xs">
                <a class="info-number">
                    <div class="form-group top_search" style="width: 230px">
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
<form id="frm-logout" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
