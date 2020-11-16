<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('dashboard')}}" class="site_title"><img
                    src="{{asset('storage/logo/'.basic_information()->company_logo)}}"></a>
        </div>

        <div class="clearfix"></div>


        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li><a><i class="fa mdi mdi-google-maps"></i> Area Manage <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('zone')}}">Distribution Zone</a></li>
                            <li><a href="{{route('hub')}}">Hub</a></li>
                            <li><a href="{{route('area')}}">Area</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa mdi mdi-export"></i> Shipping Price <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('shippingPrice.set')}}">Price rate set</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa mdi mdi-cube-send"></i> Shipment <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('AdminShipment.index')}}">Merchant List</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('driver-list.index')}}"><i class="fa mdi mdi-truck-fast"></i> Driver</a>
                    <li><a href="{{route('merchant.list')}}"><i class="fa mdi mdi-account-multiple-plus"></i> Merchant
                            List</a>
                    </li>
                    <li><a><i class="fa fa-home"></i> Website Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('basic-information.index')}}">Basic Information</a></li>
                            <li><a href="index2.html">Slider Manage</a></li>
                            <li><a href="index3.html">Contact us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

    </div>
</div>
