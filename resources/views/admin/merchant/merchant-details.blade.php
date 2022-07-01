@extends('admin.layout.app')
@section('title','Merchant List')
@section('content')

    <div class="right_col" role="main">
        
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Merchant <b>{{$user->first_name}}</b> details</h3>
                </div>
                <div class="title_right">
                    <div class="pull-right top_search">
                        <button type="button" class="btn btn-info btn-sm" onclick="history.back();">
                            <i class="fa fa-user-plus fs-13 m-r-3"></i> Back to Merchant list
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            @if ($errors->any())
                <ul class="alert alert-danger alert-dismissible">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="row">
                <div class="x_panel">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="height: 100px" class="img-thumbnail img-fluid" src="{{$user->image == null? asset('images/user.png'):asset('storage/user/'.$user->image)}}" ></div>
                            <div class="col-md-8">
                                Merchant ID: {{$user['user_id']}} <br>
                                Name: {{$user['first_name']}} {{$user['last_name']}} <br>
                                Email: {{$user['email']}} <br>
                                Phone: {{$user['phone']}} <br>
                                
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                @if($user->area_id !=null)
                                 Area: {{$user->area->name}} @else 
                                    Area: <span class="text-danger">Not set</span> @endif
                                <br> 
                                Address: {{$user->address}} <br>
                                Zip-Code: {{$user->zip_code}} <br>
                                Website: @if($user->website_link==null)
                                <span class="label label-warning">Not link</span> 
                                @else <a target="_blank" class="label label-success">{{$user->website_link}}</a>  @endif <br>
                            </div>
                            <div class="col-md-6">
                                Join Date: {{date('M d, Y',strtotime($user->created_at))}} <br>

                                Status: @if($user->status==1)
                                    <span class="label label-success">Registerd</span> 
                                @else <span class="label label-danger">Block</span>  @endif <br>
                                Total Parcels: {{COUNT($shipments)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <h3>Parcels of <b>{{$user->first_name.' '.$user->last_name}}</b></h3>
                            <table id="datatable-buttons"
                                   class="table table-striped table-bordered dataTable no-footer dtr-inline">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Shipment info</th><th>Customer Info</th>
                
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($shipments as $key => $shipment)
                                    <tr>
                                        <th scope="row">
                                            Invoice ID: {{$shipment->invoice_id}} <br>
                                            Shipment Type : @if($shipment->delivery_type=='1') Regular Delivery @else Express Delivery @endif <br>
                                            Price: {{$shipment->total_price}} 
                                            ( @if($shipment->price=='0') Paid by merchant @else Pay by customer @endif ) <br>
                                            Tracking code: <a href="/tracking?code={{$shipment->tracking_code}}" target="_blank">{{$shipment->tracking_code}}</a> <br>
                                            Status: @include('admin.shipment.status',['status'=>$shipment->status,'shipping_status'=>$shipment->shipping_status]) <br>
                                            Date: {{date('M d, Y',strtotime($shipment->created_at))}}

                                        </th>
                                        <th scope="row">
                                            Shipment ID : {{$shipment->id}} <br>
                                            Name : {{$shipment->name}} <br>
                                            Phone : {{$shipment->phone}} <br>
                                            Area: {{$shipment->area->name}} <br>
                                            Hub: {{$shipment->area->hub->name}} <br>
                                            Zone: {{$shipment->area->hub->zone->name}}
                                           
                                        </th>
                                    </tr>@endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}"
          rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Datatables -->
    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>
@endpush
