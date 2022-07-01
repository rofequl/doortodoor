<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                <img src="/images/{{basic_information()->company_logo}}"></a>
        </div>
        <div class="clearfix"></div>
        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li><a><i class="fa mdi mdi-google-maps"></i> Area Manage <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('zone') != 0 )
                            <li><a href="{{route('zone')}}">Distribution Zone</a></li> @endif
                            @if(checkAdminAccess('hub') != 0 )
                            <li><a href="{{route('hub')}}">Hub</a></li> @endif
                            @if(checkAdminAccess('area') != 0 )
                            <li><a href="{{route('area')}}">Area</a></li> @endif
                        </ul>
                    </li>
                    <li><a><i class="fa fa-money"></i> Shipping Price <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('shipping-price-set') != 0 )
                            <li><a href="/shipping-price-set">Price rate set</a></li> @endif
                        </ul>
                    </li>

                    @if(checkAdminAccess('all-shipments') != 0 )
                    <li><a href="/admin/all-shipments"><i class="fa mdi mdi-export"></i> All shipments</a></li> @endif

                    <li><a><i class="fa mdi mdi-cube-send"></i> Logistics <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('shipping-list') != 0 )
                            <li><a href="/admin/shipping-list">Pick-up</a></li> @endif

                            @if(checkAdminAccess('shipping-list/received') != 0 )
                            <li><a href="/admin/shipping-list/received">Receive</a></li> @endif

                            @if(checkAdminAccess('shipping-list/dispatch') != 0 )
                            <li><a href="/admin/shipping-list/dispatch">Dispatch</a></li> @endif

                            @if(checkAdminAccess('agent-dispatch') != 0 )
                            <li><a href="/admin/agent-dispatch">Agent Dispatch</a></li> @endif

                            @if(checkAdminAccess('reconcile') != 0 )
                            <li><a href="/admin/reconcile">Reconcile</a></li> @endif

                            @if(checkAdminAccess('delivery') != 0 )
                            <li><a href="/admin/delivery">Delivery</a></li> @endif

                            @if(checkAdminAccess('shipment-download') != 0 )
                            <li><a href="{{route('AdminDownload')}}">Download</a></li> @endif

                            @if(checkAdminAccess('admin-upload-csv') != 0 )
                            <li><a href="{{route('AdminUploadCSV')}}">Upload CSV-File</a></li> @endif
                            
                            <?php $zones = \DB::table('zones')->where('status','1')->get();?>
                            @foreach ($zones as $zone)
                            @if(checkAdminAccess('thirdparty-shipments') != 0 )
                            <li><a href="{{route('thirdparty-shipments',$zone->id)}}">{{$zone->name}}</a></li> @endif
                            @endforeach
                        </ul>
                    </li>

                    <li><a><i class="fa mdi mdi-cube-send"></i>  Delivered Logistics <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('hold-shipments') != 0 )
                            <li><a href="{{route('hold-shipments','hold')}}">Hold-parcels</a></li> @endif

                            @if(checkAdminAccess('hold-shipments') != 0 )
                            <li><a href="{{route('hold-shipments','return')}}">Return-parcels</a></li> @endif

                            @if(checkAdminAccess('return-dispatch') != 0 )
                            <li><a href="{{route('return-dispatch')}}">Dispatch</a></li> @endif

                            @if(checkAdminAccess('return-merchant-handover') != 0 )
                            <li><a href="{{route('merchant-handover')}}">Merchant Handover</a></li> @endif 
                            {{-- <li><a href="{{route('return-agent-dispatch')}}">Agent Dispatch</a></li>  --}}
                            
                            @if(checkAdminAccess('receive-from-hub') != 0 )
                            <li><a href="{{route('receive-from-hub')}}">Receive From Hub</a></li> @endif

                            @if(checkAdminAccess('hold-shipments') != 0 )
                            <li><a href="{{route('hold-shipments','partial')}}">Partially delivered</a></li> @endif
                        </ul>
                    </li>

                    <li><a href="/admin/driver-list"><i class="fa mdi mdi-truck-fast"></i> Riders</a> </li> 

                    @if(checkAdminAccess('merchant-list') != 0 )
                    <li><a href="{{route('merchant.list')}}"><i class="fa mdi mdi-account-multiple-plus"></i> Merchant List</a></li> @endif

                    <li>
                        <a><i class="fa mdi mdi-account"></i> Employee Manage<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('admin-list') != 0 )
                            <li><a href="{{route('admin-list')}}">Employee List</a></li> @endif
                            @if(checkAdminAccess('role-assign') != 0 )
                            <li><a href="{{route('role-assign')}}">Role Assign</a></li> @endif
                        </ul>
                    </li>
                    <li><a><i class="fa fa-home"></i> Website Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @if(checkAdminAccess('basic-information') != 0 )
                            <li><a href="{{route('basic-information')}}">Basic Information</a></li> @endif

                            @if(checkAdminAccess('sliders') != 0 )
                            <li><a href="/admin/sliders">Slider Manage</a></li> @endif

                            @if(checkAdminAccess('about-us') != 0 )
                            <li><a href="/admin/about-us">About Us page</a></li> @endif

                            @if(checkAdminAccess('client-reviews') != 0 )
                            <li><a href="/admin/client-reviews">Client Reviews</a></li> @endif 

                            @if(checkAdminAccess('messages') != 0 )
                            <li><a href="/admin/messages">Contact Messages</a></li> @endif

                            <li><a> Blogs <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none;">
                                    @if(checkAdminAccess('blog/index') != 0 )
                                    <li><a href="/admin/blog/index">Blog Posts</a> </li> @endif 

                                    @if(checkAdminAccess('blog/category') != 0 )
                                    <li><a href="/admin/blog/category">Blog Category</a> </li> @endif 
                                </ul>
                            </li>
                        </ul>
                    </li>

                    @if(checkAdminAccess('set-mail-info') != 0 )
                    <li><a href="{{route('mail-setup')}}"><i class="fa mdi mdi-email-open"></i> Mail SetUp</a> </li> @endif 
                    

                    <li class="text-danger"><a href="javascript:;"><i class="fa mdi mdi-power"></i> Logout</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</div>
