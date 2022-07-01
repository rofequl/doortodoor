@extends('admin.layout.app')
@section('title','Dashboard | Admin')
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            @if(session()->has('message'))
                <div class=" col-md-12 m-t-5"><div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session()->get('message') }}
                </div></div>
            @endif
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-shopping-cart"></i>
                </div>
                <?php $shipments = \DB::table('shipments')->select('id')->count();?>  
                <div class="count">{{sprintf("%02d",$shipments)}}</div>

                <h3>Total shipments</h3>
                <p><a href="/admin/shipping-list/">All shipments from the scratch</a></p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-truck"></i>
                </div>
                <?php $drivers = \DB::table('drivers')->select('id')->count();?> 
                <div class="count">{{sprintf('%02d',$drivers)}}</div>

                <h3>Riders</h3>
                <p><a href="/admin/driver-list/">Riders total data-record</a></p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                </div>
                <?php $users = \DB::table('users')->select('id')->count();?> 
                <div class="count">{{sprintf('%02d',$users)}}</div>

                <h3>Merchants</h3>
                <p><a href="/admin/driver-list/">Riders total data-record</a></p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-user-plus"></i>
                </div>
                <?php $admins = \DB::table('admins')->where('role_id',1)->select('id')->count();?> 
                <?php $employees = \DB::table('admins')->where('role_id','!=',1)->select('id')->count();?> 
                <div class="count">{{sprintf('%02d',$admins)}} / {{sprintf('%02d',$employees)}}</div>

                <h3>Employees</h3>
                <p><a href="/admin/admin-list/">Admin / Employee data-record</a></p>
              </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 ">
                <div class="x_panel">
                    <div class="x_content">
                        <p style="padding: 20px" class="text-right">
                            <b class="pull-left fa-2x">Shop summary </b>
                            <strong class="p5">{{sprintf('%02d',$users)}} </strong><br>
                            Registerd Shop(s)
                        </p> <br><br>
                        <?php $todayShop = \DB::table('users')->whereDate('created_at', \Carbon\Carbon::today())->count();?>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>{{sprintf('%02d',$todayShop)}}</strong><br> <p>Shop onboarded, today</p>
                            </div>
                            <div class="col-md-4">
                                <?php $yesterdayShop = \DB::table('users')->whereDate('created_at', \Carbon\Carbon::yesterday())->count();?>
                                <strong>{{sprintf('%02d',$yesterdayShop)}}</strong><br> <p>Shop onboarded, yesterday</p>
                            </div>
                            <div class="col-md-4">
                                <?php  $dayBefore7 = \Carbon\Carbon::today()->subDays(7);
                                $shop7 = \DB::table('users')->where('created_at', '>=', $dayBefore7)->count(); ?>
                                <strong>{{sprintf('%02d',$shop7)}}</strong><br> <p>Shop onboarded, last 7 days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 ">
                <div class="x_panel">
                    <div class="x_content">
                        <p class="text-right" style="padding: 20px">
                            <b class="pull-left fa-2x">Sales summary </b>
                            <strong class="p5">{{sprintf('%02d',$users)}} </strong><br>
                            Total transaction(s)
                        </p> <br><br>
                        <div class="row">
                            <div class="col-md-3">
                                <?php $ordersToday= \DB::table('shipments')->whereDate('created_at', \Carbon\Carbon::today())->count(); ?>
                                <strong>{{sprintf('%02d',$ordersToday)}}</strong><br> <p>Orders, today</p>
                            </div>
                            <div class="col-md-3">
                                <?php $salesToday= \DB::table('driver_hub_shipment_box')->where('status','partial')
                                ->orWhere('status','delivery')->whereDate('created_at', \Carbon\Carbon::today())->count(); ?>
                                <strong>{{sprintf('%02d',$salesToday)}}</strong><br> <p>Sales, Today</p>
                            </div>
                            <div class="col-md-3">
                                <?php $orderYesterday = \DB::table('shipments')->whereDate('created_at', \Carbon\Carbon::yesterday())->count();?>
                                <strong>{{sprintf('%02d',$orderYesterday)}}</strong><br> <p>Orders, yesterday</p>
                            </div>
                            <div class="col-md-3">
                                <?php $salesYesterday = \DB::table('driver_hub_shipment_box')->where('status','partial')
                                ->orWhere('status','delivery')->whereDate('created_at', \Carbon\Carbon::yesterday())->count(); ?>
                                <strong>{{sprintf("%02d",$salesYesterday)}}</strong><br> <p>Sales, yesterday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
